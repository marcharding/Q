<?php

header( 'Content-Type: text/html; charset=utf-8' );
header( 'Cache-Control: max-age=5184000, private, must-revalidate' );

require_once '_q/bootstrap.php';

$dispatchOptions = array(
    'web' => __DIR__,
	'index' => 'index',
	'404' => '404',
	'template' => __DIR__ . '/assets/template/default.php',
	'page' => $_SERVER['REQUEST_URI']
);

echo Q_Dispatch::dispatch( $dispatchOptions );
