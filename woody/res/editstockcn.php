<?php require_once('php/_stock.php'); ?>
<?php require_once('php/_editstockform.php'); ?>
<?php AcctAuth(); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>修改股票说明</title>
<meta name="description" content="本中文页面文件跟/woody/res/php/_submitstock.php和/woody/res/php/_editstockform.php一起配合完成修改股票说明内容的功能.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0 onLoad=OnLoad()>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>修改股票说明</h1>
<?php StockEditForm(STOCK_EDIT_CN, true); ?>
</div>

<?php LayoutTail(true); ?>

</body>
</html>