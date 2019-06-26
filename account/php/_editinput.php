<?php
require_once('_account.php');
require_once('/php/tutorial/editinput.php');
require_once('/php/tutorial/primenumber.php');
require_once('/php/sql/sqlcommonphrase.php');
require_once('/php/ui/editinputform.php');
require_once('/php/ui/table.php');

function _getCommonPhraseString($strInput, $strMemberId, $bChinese)
{
	$sql = new CommonPhraseSql($strMemberId);
	if (empty($strInput) == false)
	{
		if ($sql->Get($strInput) == false)
		{
			$sql->Insert($strInput);
			trigger_error(ACCOUNT_TOOL_PHRASE_CN.' -- '.$strInput);
		}
	}
	
	$strConfirm = $bChinese ? '确认删除' : 'Confirm Delete';
	$str = '';
	if ($result = $sql->GetAll()) 
	{
		while ($record = mysql_fetch_assoc($result)) 
		{
			$strVal = $record['val'];
		    $str .= GetOnClickLink('/account/php/_submitcommonphrase.php?delete='.$record['id'], $strConfirm.': '.$strVal.'?', $strVal).'<br />';
		}
		@mysql_free_result($result);
	}
	return $str;
}

function EchoAll($bChinese = true)
{
	global $acct;
	
	$strTitle = $acct->GetTitle();
	$strMemberId = $acct->GetLoginId();
	
    if (isset($_POST['submit']))
	{
		unset($_POST['submit']);
		$strInput = UrlCleanString($_POST[EDIT_INPUT_NAME]);
	}
	else if ($strInput = $acct->GetQuery())	{}
    else
    {
    	switch ($strTitle)
    	{
    	case 'editinput':
    		$strInput = GetEditInputDefault();
    		break;

    	case 'ip':
    		$strInput = UrlGetIp();
    		break;
    		
    	case 'primenumber':
    		$strInput = strval(time());
    		break;
    		
    	default:
    		$strInput = '';
    		break;
    	}
    }
    
    EchoEditInputForm(GetAccountToolStr($strTitle, $bChinese), $strInput, $bChinese);
    switch ($strTitle)
    {
    case 'editinput':
    	$str = GetEditInputString($strInput);
    	break;
    		
    case 'commonphrase':
    	$str = _getCommonPhraseString($strInput, $strMemberId, $bChinese);
    	break;
    		
    case 'ip':
    	$str = IpLookupGetString($strInput, '<br />', $bChinese);
    	break;
    	
    case 'primenumber':
    	$str = GetPrimeNumberString($strInput);
    	break;
    }
    $str .= '<br /><br />'.GetDevGuideLink('20100905', $strTitle, $bChinese);
    $str .= '<br />'.GetCategoryLinks(GetAccountToolArray($bChinese), ACCT_PATH, $bChinese);
    EchoParagraph($str);
}

function _getAccountToolTitle($strTitle, $strQuery, $bChinese)
{
	$str = $strQuery ? $strQuery.' ' : '';
	$str .= GetAccountToolStr($strTitle, $bChinese);
	return $str;
}

function EchoMetaDescription($bChinese = true)
{
	global $acct;
	
	$strTitle = $acct->GetTitle();
  	$str = _getAccountToolTitle($strTitle, $acct->GetQuery(), $bChinese);
  	switch ($strTitle)
  	{
  	case 'editinput':
  		$str .= $bChinese ? '页面. 测试代码在/php/tutorial/editinput.php中, 测试成熟后再分配具体长期使用的工具页面. 不成功的测试就可以直接放弃了.'
    						: 'page, testing source code in /php/tutorial/editinput.php. Functions will be moved to permanent pages after test.';
  		break;
  		
  	case 'commonphrase':
  		$str .= $bChinese ? '页面. 输入, 显示, 修改和删除个人常用短语. 用在股票交易记录等处, 方便快速输入和修改个人评论. 限制每条短语最长32个字, 每个用户最多20条短语.'
    						: 'page, input, display, edit and delete personal common phrases, used in places like stock transaction records.';
  		break;
  		
  	case 'ip':
  		$str .= $bChinese ? '查询页面. 从ipinfo.io等网站查询IP地址对应的国家, 城市, 网络运营商和公司等信息. 同时也从palmmicro.com的用户登录和评论中提取对应记录.'
    						: 'page, display country, city, service provider and company information from ipinfo.io.';
  		break;
  		
  	case 'primenumber':
  		$str .= $bChinese ? '页面. 质数又称素数, 该数除了1和它本身以外不再有其他的因数, 否则称为合数. 每个合数都可以写成几个质数相乘的形式. 其中每个质数都是这个合数的因数, 叫做这个合数的分解质因数.'
    						: ' page. A prime number (or a prime) is a natural number greater than 1 that has no positive divisors other than 1 and itself.';	//  A natural number greater than 1 that is not a prime number is called a composite number
    	break;
    }
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
	global $acct;
	
	$strTitle = $acct->GetTitle();
  	$str = _getAccountToolTitle($strTitle, $acct->GetQuery(), $bChinese);
  	echo $str;
}

	$acct = new TitleAcctStart(false, array('commonphrase', 'ip'));

?>
