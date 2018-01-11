<?php require_once('php/_groups.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>恒生指数基金净值计算工具</title>
<meta name="description" content="计算恒生指数基金的净值, 目前包括恒生ETF(SZ159920), 恒指LOF(SZ160924)和恒生通(SH513660). 使用恒生指数(^HSI)进行估值, 恒生指数盈富基金(02800)仅作为参考.">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutTopLeft(true); ?>

<div>
<h1>恒生指数基金净值计算工具</h1>
<p>使用恒生指数(^HSI)进行估值, 恒生指数盈富基金(02800)仅作为参考.
<?php EchoHangSengToolTable(true); ?>
</p>
<?php EchoPromotionHead('', true); ?>
<p>相关软件:
<?php 
    EchoStockCategoryLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
