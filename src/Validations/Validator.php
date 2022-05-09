<?php
namespace Tutor\Validations;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Validator
 *
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */
class Validator {
	/**
	 * Check whether order name is ASC or DESC
	 *
	 * @param string $order SQL order name.
	 * @return boolean
	 */
	public static function is_valid_order( $order ) {
		return in_array( strtoupper( $order ), array( 'ASC', 'DESC' ), false );
	}
}
