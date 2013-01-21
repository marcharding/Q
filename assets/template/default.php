<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
	<title><?php echo ( $q->g( 'title' ) ) ? $q->g( 'title' ) . ' » ' : '' ?>Example</title>
	<meta name="description" content="<?php echo ( $q->g( 'description' ) ) ?>" />
	<meta name="content-language" content="en" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" href="/assets/css/default.css" type="text/css" media="screen" />
	<!--[if lte IE 6]><link rel="stylesheet" href="/assets/css/ie6.css" type="text/css" media="screen" /><![endif]-->
	<?php if ( $q->g( 'javascript' ) ) { ?>
		<script src="/assets/js/javascript.js" type="text/javascript" charset="utf-8"></script>
	<?php } ?>
</head>
<body>

<?php echo $q->g( 'image' ) ?>

<?php echo $q->navigation( '/assets/navigation/default.php', $_SERVER['REQUEST_URI'] ); ?>

<?php echo $q->navigation( '/assets/navigation/default.php', $_SERVER['REQUEST_URI'], array( 1 => 0 ) ); ?>

<?php echo $q->navigation( '/assets/navigation/default.php', $_SERVER['REQUEST_URI'], 3 ); ?>

<?php echo $q->g( 'content' ) ?>

</body>
</html>
