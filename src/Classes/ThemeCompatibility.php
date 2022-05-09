<?php
namespace Tutor\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class ThemeCompatibility
 *
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 * @since v.1.0.0
 */
class ThemeCompatibility {

	public function __construct() {
		$template   = trailingslashit( get_template() );
		$tutor_path = tutor()->path;

		$compatibility_theme_path = $tutor_path . 'theme-compatibility/' . $template . 'functions.php';

		if ( file_exists( $compatibility_theme_path ) ) {
			include $compatibility_theme_path;
		}
	}

}
