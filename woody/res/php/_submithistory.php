<?php
require_once('/php/account.php');
require_once('/php/stock.php');
require_once('/php/stockhis.php');

// https://danjuanapp.com/djmodule/value-center

class YMDOldest extends YMDString
{
    function YMDOldest()
    {
        parent::YMDString('2014-01-01');
    }
}

function _webUpdateSinaHistory($sql, $sym)
{
    $ymd_oldest = new YMDOldest();
    $iYearOldest = $ymd_oldest->GetYear();
    
	$ymd = new YMDNow();
	$iYear = $ymd->GetYear();
	$iSeason = $ymd->GetSeason();
	$iTotal = 0;
	while ($iTotal < MAX_QUOTES_DAYS)
	{
        $str = SinaGetStockHistory($sym, $iYear, $iSeason);
        $arMatch = preg_match_sina_history($str);
        foreach ($arMatch as $ar)
        {
        	$sql->Merge($ar[1], $ar[2], $ar[3], $ar[5], $ar[4], $ar[6], $ar[4]);
        	$iTotal ++;
		}
		$iSeason --;
		if ($iSeason == 0)
		{
			$iSeason = 4;
			$iYear --;
			if ($iYear < $iYearOldest)	break;
		}
	}
    DebugString(sprintf('_webUpdateSinaHistory %s total %d', $sym->GetSymbol(), $iTotal));
}

function _webUpdateYahooHistory($sql, $strYahooSymbol)
{
    $iTime = time();
    $iTotal = 0;
    $iMax = 100;
    $iMaxSeconds = $iMax * SECONDS_IN_DAY;
    for ($k = 0; $k < MAX_QUOTES_DAYS; $k += $iMax)
    {
        $iTimeBegin = $iTime - $iMaxSeconds;
        $str = YahooGetStockHistory($strYahooSymbol, $iTimeBegin, $iTime);

        $arMatch = preg_match_yahoo_history($str);
        $iVal = count($arMatch);
        $iTotal += $iVal;
        if ($iVal < $iMax / 2)
        {
            $ymd_begin = new YMDTick($iTimeBegin);
            $ymd = new YMDTick($iTime);
            DebugString(sprintf('_webUpdateYahooHistory %s %d from %s to %s', $strYahooSymbol, $iVal, $ymd_begin->GetYMD(), $ymd->GetYMD()));
        }
        
        for ($j = 0; $j < $iVal; $j ++)
        {
            $ymd = new YMDTick(strtotime($arMatch[$j][1]));
            $strDate = $ymd->GetYMD();
            
            $ar = array();
            $str = $strDate;
            for ($i = 0; $i < 6; $i ++)
            {
                $strNoComma = str_replace(',', '', $arMatch[$j][$i + 2]); 
                $ar[] = $strNoComma;
                $str .= ' '.$strNoComma; 
            }
            $sql->Merge($strDate, $ar[0], $ar[1], $ar[2], $ar[3], $ar[5], $ar[4]);
        }
        $iTime = $iTimeBegin;
    }
    DebugString(sprintf('_webUpdateYahooHistory %s total %d', $strYahooSymbol, $iTotal));
}

function _isInvalidDate($strYMD)
{
    $ymd = new YMDString($strYMD);
    if ($ymd->IsWeekend())      return true;
    if ($ymd->IsFuture())       return true;
    
    $ymd_oldest = new YMDOldest();
    if ($ymd->GetTick() < $ymd_oldest->GetTick())                 return true;
    return false;
}

function _cleanInvalidStockHistory($sql)
{
    $ar = array();
    if ($result = $sql->GetAll()) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            if (_isInvalidDate($history['date']))
            {
                $ar[] = $history['id'];
            }
        }
        @mysql_free_result($result);
    }

    foreach ($ar as $strId)
    {
        $sql->DeleteById($strId);
    }
}

function _cleanInvalidHistory($strTableName)
{
    $ar = array();
    if ($result = SqlGetTableData($strTableName)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            if (_isInvalidDate($history['date']))
            {
                $ar[] = $history['id'];
            }
        }
        @mysql_free_result($result);
    }

    $iCount = count($ar);
    DebugString($strTableName.' - invalid date: '.strval($iCount)); 
    foreach ($ar as $strId)
    {
        SqlDeleteTableDataById($strTableName, $strId);
    }
}

function _submitStockHistory($strStockId, $strSymbol)
{
    if (AcctIsAdmin() == false)     return;
    
    unlinkConfigFile($strSymbol);
    $sym = new StockSymbol($strSymbol);
    $sym->SetTimeZone();
	$sql = new StockHistorySql($strStockId);
	if ($sym->IsIndexA())
	{
		_webUpdateSinaHistory($sql, $sym);
	}
	else
	{
		_webUpdateYahooHistory($sql, $sym->GetYahooSymbol());
		if ($sym->IsSymbolA() || $sym->IsSymbolH())
		{   // Yahoo has wrong Chinese and Hongkong holiday record with '0' volume 
			if ($sym->IsIndex() == false)
			{
				$sql->DeleteByZeroVolume();
			}
		}
	}
    _cleanInvalidStockHistory($sql);
//    _cleanInvalidHistory(TABLE_FUND_HISTORY);
}

    AcctNoAuth();
	if ($strStockId = UrlGetQueryValue('id'))
	{
	    if ($strSymbol = SqlGetStockSymbol($strStockId))
	    {
	        _submitStockHistory($strStockId, $strSymbol);
	    }
	}
	else if ($strSymbol = UrlGetQueryValue('symbol'))
	{
	    if ($strStockId = SqlGetStockId($strSymbol))
	    {
	        _submitStockHistory($strStockId, $strSymbol);
	    }
	}
	SwitchToSess();
	
?>
