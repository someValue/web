<?php
require_once('_stock.php');
require_once('_editstockoptionform.php');

function EchoTitle()
{
    global $g_strOptionType;
    echo $g_strOptionType;
}

function EchoHeadLine()
{
	EchoTitle();
}

function EchoMetaDescription($bChinese)
{
    global $g_strOptionType;

    if ($bChinese)
    {
        $str = '本中文页面文件跟/woody/res/php/_submitstockoptions.php和/woody/res/php/_editstockoptionform.php一起配合';
    }
    else
    {
        $str = 'This English web page works together with php/_submitstockoptions.php and php/_editstockoptionform.php to ';
    }
    $str .= $g_strOptionType;
    EchoMetaDescriptionText($str);
}

function EchoAll()
{
    global $g_strOptionType;
    StockOptionEditForm($g_strOptionType);
}

function SetStockOptionType($strType)
{
    global $g_strOptionType;
    $g_strOptionType = $strType;
}

    AcctAuth();
    $g_strOptionType = STOCK_OPTION_ADJCLOSE_CN;
    
?>