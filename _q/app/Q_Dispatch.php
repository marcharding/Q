<?php

/**
 * Q dispather
 *
 * dipatches an request to Q_Template
 *
 * @package Q
 * @author Marc Harding
 */
class Q_Dispatch
{

	/**
	 * Constructor
	 *
	 * @param array $dispatchOptions Dispatch options ( requested page, template, error/index-page )
	 */
	public function __construct( $dispatchOptions )
	{
		$this->dispatchOptions = $dispatchOptions;
	}

	/**
	 * Grabs the content instatiates a Q_Template and returns the rendered page
	 *
	 * @param string $path Path to content
	 * @param string $template Template with should be used for rendering
	 * @return string Rendered page
	 */
	public function getDispatch( $path, $template )
	{
		$path = preg_replace( '/\w+\/\.\.\//', '', $path );

		if ( $path == '/' ) {
			$path = $this->dispatchOptions['index'];
		}

		$qTemplate = new Q_Template( $template );

		if ( file_exists( DOCUMENT_ROOT . '/pages/' . $path . '.php' ) ) {
			$qTemplate->addPage( DOCUMENT_ROOT . '/pages/' . $path . '.php' );
		} else if ( file_exists( DOCUMENT_ROOT . '/pages/' . $path . '/index.php' ) ) {
			$qTemplate->addPage( DOCUMENT_ROOT . '/pages/' . $path . '.php' );
		} else {
			header( 'HTTP/1.0 404 Not Found' );
			$qTemplate->addPage( DOCUMENT_ROOT . '/pages/' . $this->dispatchOptions['404'] . '.php' );
		}

		return $qTemplate->render();
	}

	/**
	 * Dispatch wrapper method
	 *
	 * @param array $dispatchOptions Dispatch options ( requested page, template, error/index-page )
	 * @return string Rendered page
	 */
	public static function dispatch( $dispatchOptions )
	{
		$instance = new self( $dispatchOptions );
		return $instance->getDispatch( $dispatchOptions['page'], $dispatchOptions['template'] );
	}

}
