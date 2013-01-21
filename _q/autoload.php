<?php

/**
 * Autoloader
 *
 * @author Marc Harding
 */
function autoloadFunction( $class )
{
	$file = __DIR__ . '/app/' . $class . '.php';

	if( is_file( $file ) ) {
		require_once $file;
	}
}

spl_autoload_register( 'autoloadFunction' );
