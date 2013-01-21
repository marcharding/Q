<?php

/**
 * Simple (and stupid) template class for Q
 *
 * This simple template class combines DOM-methods an PHP
 * and enable one to simply use xml file as an content source
 * It supports inline PHP (though eval()) and inline processing
 * of additional templates
 *
 * @package Q
 * @author Marc Harding
 */
class Q_Template
{

	/** Q template namespace  */
	private $namespace = 'q:template';

	/** Array of contents */
	private $stack = array();

	/** DOMDocument instance for contents */
	private $dom;

	/** Filename of template */
	private $template;

	/** Webroot */
	private $web;

	/**
	 * Construct template object
	 *
	 * @param string $template Template to render, optional
	 */
	function __construct( $template = false, $web = __DIR__ )
	{
		if ( $template ) {
			$this->template = $template;
		}

		$this->dom = new DOMDocument();
		$this->dom->preserveWhiteSpace = false;
		$this->dom->formatOutput = true;
		$this->web = $web;
	}

	/**
	 * Shortcut for get()
	 *
	 * @param string $key Name of key
	 * @return mixed Value of key
	 */
	public function g( $key )
	{
		return $this->get( $key );
	}

	/**
	 * Get contents of given key
	 *
	 * @param string $key Name of key
	 * @return mixed Value of key
	 */
	public function get( $key )
	{
		if ( array_key_exists( $key, $this->stack ) ) {
			return $this->stack[$key];
		}
	}

	/**
	 * Render Navigation
	 *
	 * @param string $path Path to template
	 * @param string $uri Request URI
	 * @return string Navigation
	 */
	public function navigation( $path, $uri, $options = array() )
	{
		return Q_Navigation::render( $this->web . $path, $uri, $options );
	}

	/**
	 * Get contents of given key
	 *
	 * @param string $key Name of key
	 * @return mixed Value of key
	 */
	function addPage( $page )
	{
		$this->dom->load( $page );

		$nodeList = $this->dom->documentElement->getElementsByTagNameNS( $this->namespace, '*' );

		foreach ( $nodeList as $element ) {

			if ( $element->hasChildNodes() ) {

				if ( !isset( $this->stack[ $element->localName ] ) ) {
					$this->stack[ $element->localName ] = "";
				}

				foreach ( $element->childNodes as $childNode)  {
					// see http://www.php.net/manual/en/dom.constants.php for constants
					if ( $childNode->nodeType === XML_PI_NODE ){

						if ( $childNode->target == 'php' ){
							ob_start();
							eval( $childNode->data );
							$content = ob_get_clean ();
							$this->stack[ $element->localName ] .= $content;
						}
					} else {
						$this->stack[ $element->localName ] .= trim( $this->dom->saveXML( $childNode ) );
					}
				}

			} else {

				if ( $element->localName == 'include') {
					$qTemplate = new self;
					$qTemplate->addPage( $element->getAttribute('path') );
					$this->stack[ $element->getAttribute('name') ] = $qTemplate->render( $element->getAttribute('template') );
				}

				if ( $element->localName == 'variable') {
					$this->stack[ $element->getAttribute('name') ] = $element->getAttribute('value');
				}

			}

		}

	}

	/**
	 * Renders given template with previously added contents
	 *
	 * @param string $template Path of template
	 * @param boolean $formatOutput Format/prettyprint output
	 * @return string Rendered template
	 */
	function render( $template = false, $formatOutput = true )
	{
		if ( $template ) {
			$this->template = $template;
		}

		ob_start();
		$q = $this;
		include $this->template;
		$content = ob_get_contents();
		ob_end_clean();

		// prettyprint output, default yes
		if ( $formatOutput ) {
			$dom = new DOMDocument();
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML( $content );
			$dom->preserveWhiteSpace = false;
			return $dom->doctype->internalSubset . PHP_EOL . $dom->saveXML( $dom->documentElement );
		} else {
			return $content;
		}

	}

}
