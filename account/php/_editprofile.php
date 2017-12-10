<?php
require_once('_account.php');
require_once('php/_editprofileform.php');

function _getEditProfileSubmit($bChinese)
{
    if ($bChinese)
    {
        $str = ACCOUNT_PROFILE_EDIT_CN;
    }
    else
    {
        $str = ACCOUNT_PROFILE_EDIT;
    }
    return $str;
}

function EchoEditProfileTitle($bChinese)
{
    $str = _getEditProfileSubmit($bChinese);
    echo $str;
}

function EchoEditProfile($bChinese)
{
    $strSubmit = _getEditProfileSubmit($bChinese);
    EditProfileForm($strSubmit);
}

    AcctAuth();
    
?>

