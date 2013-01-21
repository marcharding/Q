<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title><?php echo ( $q->g( 'title' ) ) ? $q->g( 'title' ) . ' » ' : '' ?>Example</title>
	<meta name="description" content="<?php echo ( $q->g( 'description' ) ) ?>" />
	<meta name="content-language" content="en" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="stylesheet" href="/assets/css/default.css" type="text/css" media="screen" />
	<!--[if lte IE 6]><link rel="stylesheet" href="/assets/css/ie6.css" type="text/css" media="screen" /><![endif]-->
	<?php if ( $q->g( 'javascript' ) ) { ?>
		<script src="/assets/js/javascript.js"></script>
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
