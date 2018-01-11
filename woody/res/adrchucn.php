<?php require_once('php/_adr.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php AdrEchoTitle(true); ?></title>
<meta name="description" content="<?php AdrEchoMetaDescription(true); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutAdrTopLeft(true); ?>

<div>
<h1><?php AdrEchoTitle(true); ?></h1>
<?php AdrEchoAll(true); ?>
<p><a href="http://www.kekegold.com/stock/hm/2015-04-23/344386.html" target=_blank>中国联通A股和港股的关系</a>
<br />相关软件: 
<?php
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
