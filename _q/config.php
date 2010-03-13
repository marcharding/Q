<?php

/**
 * Basic configuration
 *
 * @author Marc Harding
 */

// set locale
setlocale( LC_ALL, 'de_DE.UTF-8' );

// development mode
define( 'DEVELOPMENT', true );

if( DEVELOPMENT ) {
	ini_set( 'display_errors', 1 );
	error_reporting( E_ALL );
	libxml_use_internal_errors( false );
} else {
	error_reporting( 0 );
	ini_set( 'display_errors', 0 );
	libxml_use_internal_errors( true );
}

// set required paths
define( 'DOCUMENT_ROOT', dirname( dirname( __FILE__ ) ) );
define( '_Q', DOCUMENT_ROOT . '/_q/app' );
