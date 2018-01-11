<?php require_once('php/_lofhk.php'); ?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php EchoTitle(true); ?></title>
<meta name="description" content="<?php EchoMetaDescription(true); ?>">
<link href="../../common/style.css" rel="stylesheet" type="text/css" />
</head>

<body bgproperties=fixed leftmargin=0 topmargin=0>
<?php _LayoutLofHkTopLeft(true); ?>


<div>
<h1><?php EchoTitle(true); ?></h1>
<?php EchoAll(true); ?>
<p>相关软件:
<?php
    EchoHangSengSoftwareLinks(true);
    EchoHSharesSoftwareLinks(true);
    EchoSpySoftwareLinks(true);
    EchoFortuneSoftwareLinks(true);
    EchoStockGroupLinks(true);
?>
</p>
</div>

<?php LayoutTailLogin(true); ?>

</body>
</html>
