<?php
namespace Tutor\Core\Contracts;

/**
 * Shortcode contract
 */
interface ShortcodeContract {
	/**
	 * Add shortcode
	 *
	 * @param array $attr
	 * @return void
	 */
	public function add( $attr );
}
