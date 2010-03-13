<?php

/**
 * Q navigation class
 *
 * Takes a normal unordered list as its source and
 * marks currently active node and parent node
 *
 * @author Marc Harding
 */
class Q_Navigation
{

	/** Dateiname des Lockfiles */
	const CLASS_ACTIVE = 'active';

	/** Dateiname des Lockfiles */
	const CLASS_OPEN = 'open';

	/** Dateiname des Lockfiles */
	const ID_SELECTED = 'active';

	/** Dateiname des Lockfiles */
	const ID_OPEN = 'open';

	/** Die Dateien, die transformierend werden solle */
	private $requestedUri;

	/** Die Dateien, die transformierend werden solle */
	private $dom;

	/** Die Dateien, die transformierend werden solle */
	private $xp;

	/** Die Dateien, die transformierend werden solle */
	private $options;

	/**
	 * Konstruktor des Importer Objekts
	 *
	 * @param string $sourceDirectory Quellverzeichnis, enthält die NTIF-Dateien
	 */
	public function __construct( $navigationFile, $requestedUri = false, $options = array() )
	{
		$this->requestedUri = $requestedUri;

		$this->dom = new DOMDocument();
		$this->dom->preserveWhiteSpace = false;
		$this->dom->formatOutput = true;
		$this->dom->load( $navigationFile );

		$this->xp = new DOMXPath( $this->dom );

		$this->processNodes( $this->dom->documentElement->parentNode );
	}

	/**
	 * Konstruktor des Importer Objekts
	 *
	 * @param string $sourceDirectory Quellverzeichnis, enthält die NTIF-Dateien
	 */
	public function processNodes( $node )
	{
		$nodelist = $this->xp->query( "./ul/li", $node );

		foreach ( $nodelist as $node ) {

			$currentNode = $this->xp->query( ".//a", $node )->item(0);
			$currentParentNode = $currentNode->parentNode;

			if ( $this->requestedUri == $currentNode->getAttribute( 'href' ) ) {
				$currentNode->setAttribute( 'class', trim( $currentNode->getAttribute( 'class' ) . ' ' . self::CLASS_ACTIVE ) );
				$currentParentNode->setAttribute( 'class', trim( $currentParentNode->getAttribute( 'class' ) . ' ' . self::CLASS_ACTIVE ) );
				return true;
			}

			if ( $this->processNodes( $node ) ) {
				$currentNode->setAttribute( 'class', trim( $currentNode->getAttribute( 'class' ) . ' ' . self::CLASS_OPEN ) );
				$currentParentNode->setAttribute( 'class', trim( $currentParentNode->getAttribute( 'class' ) . ' ' . self::CLASS_OPEN ) );
				return true;
			}

		}
	}

	/**
	 * Konstruktor des Importer Objekts
	 *
	 * @param string $sourceDirectory Quellverzeichnis, enthält die NTIF-Dateien
	 */
	public function filterRange( $range )
	{
		if ( is_int( $range ) ) {
			$level = $range;
			$depth = false;
		} else {
			$level = array_shift( array_keys( $range ) );
			$depth = array_shift( array_values( $range ) );
		}

		$nodeList = $this->xp->query( "/descendant-or-self::*[ name() = 'ul' and count( ancestor-or-self::ul ) >= " . $level . " and descendant-or-self::*[ @class='open' or @class='active' ] ]" )->item( 0 );

		if ( !$nodeList ) {
			return false;
		}

		if ( $depth === false ) {
			return $nodeList;
		}

		$depthNodelist = $this->xp->query( "./descendant::*[ name() = 'ul' and count( ancestor-or-self::ul ) > " . ( $level + $depth ) . " ]" , $nodeList );

		foreach ( $depthNodelist as $node ) {
			 $node->parentNode->removeChild( $node );
		}

		if ( $nodeList ) {
			return $nodeList;
		} else {
			return false;
		}
	}

	/**
	 * Konstruktor des Importer Objekts
	 *
	 * @param string $sourceDirectory Quellverzeichnis, enthält die NTIF-Dateien
	 */
	public static function render( $navigationFile, $requestedUri = false, $range = false )
	{
		$instance = new Q_Navigation( $navigationFile, $requestedUri, $range );

		if ( $range ) {
			if ( $temp = $instance->filterRange( $range ) ) {
				return $instance->dom->saveXML( $temp );
			}
		} else {
			return $instance->dom->saveXML( $instance->dom->documentElement );
		}
	}

}
