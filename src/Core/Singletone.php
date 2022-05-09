<?php
namespace Tutor\Core;

/**
 * Singletone class
 */
abstract class Singletone {

	/**
	 * Instances
	 *
	 * @var array
	 */
	protected static $instances = array();

	/**
	 * Constructor
	 */
	abstract protected function __construct();
	//phpcs:ignore
	public static function getInstance() {
		$class = get_called_class();
		if ( ! array_key_exists( $class, self::$instances ) ) {
			self::$instances[ $class ] = new $class();
		}
		return self::$instances[ $class ];
	}

}
