<?php
/**
 * Project constants
 *
 * @package tutor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TUTOR_VERSION', '2.2.3' );
define( 'TUTOR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TUTOR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'TUTOR_PLUGIN_FILE', __DIR__ . '/tutor.php' );

define( 'TUTOR_ASSET_VERSION', time() );
define( 'TUTOR_ASSET_URL', plugin_dir_url( __FILE__ ) . 'assets' );
