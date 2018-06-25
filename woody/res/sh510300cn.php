<?php require_once('php/_chinaetf.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(); ?></title>
<meta name="description" content="<?php EchoMetaDescription(); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutChinaEtfTopLeft(); ?>

<div>
<h1><?php EchoTitle(); ?></h1>
<?php EchoAll(); ?>
<p>
<a href="https://dws.com/US/EN/Product-Detail-Page/ASHR" target=_blank>ASHR官网</a>
<br />相关软件:
<?php
    EchoASharesSoftwareLinks();
    EchoSpySoftwareLinks();
    EchoHuaTaiSoftwareLinks();
    EchoStockGroupLinks();
?>
</p>
</div>

<?php LayoutTailLogin(); ?>

</body>
</html>
