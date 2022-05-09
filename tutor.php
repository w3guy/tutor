<?php
/**
 * Plugin Name: Tutor LMS
 * Plugin URI: https://www.themeum.com/product/tutor-lms/
 * Description: Tutor is a complete solution for creating a Learning Management System in WordPress way. It can help you to create small to large scale online education site very conveniently. Power features like report, certificate, course preview, private file sharing make Tutor a robust plugin for any educational institutes.
 * Author: Themeum
 * Version: 2.0.3
 * Author URI: https://themeum.com
 * Requires at least: 4.5
 * Tested up to: 5.9
 * License: GPLv2 or later
 * Text Domain: tutor
 *
 * @package tutor
 */

use Tutor\TutorPlugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'vendor/autoload.php';
require_once 'constants.php';

do_action( 'tutor_before_load' );
$tutor_plugin = TutorPlugin::get_instance();
$tutor_plugin->init();
$tutor_plugin->register_post_types();
$tutor_plugin->register_metaboxes();
$tutor_plugin->register_taxonomies();
$tutor_plugin->register_shortcodes();
$tutor_plugin->register_widgets();
$tutor_plugin->add_integrations();
do_action( 'tutor_loaded' );
