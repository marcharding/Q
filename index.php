<?php

header( 'Content-Type: text/html; charset=utf-8' );

require_once '_q/bootstrap.php';

$qDispatchOptions = array(
	'index' => 'index',
	'404' => '404',
	'template' => DOCUMENT_ROOT . '/assets/template/default.php',
	'page' => $_SERVER['REQUEST_URI']
);

echo Q_Dispatch::dispatch( $qDispatchOptions );
