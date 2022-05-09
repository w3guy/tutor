<?php
namespace Tutor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\API\ApiManager;
use Tutor\Hooks\ActivationHook;
use Tutor\Integrations\TutorEDD;
use Tutor\PostTypes\QuizPostType;
use Tutor\Metaboxes\CourseMetabox;
use Tutor\PostTypes\TopicPostType;
use Tutor\Integrations\WooCommerce;
use Tutor\PostTypes\CoursePostType;
use Tutor\PostTypes\LessonPostType;
use Tutor\Controllers\AjaxController;
use Tutor\PostTypes\EnrolledPostType;
use Tutor\Shortcodes\CourseShortcode;
use Tutor\Controllers\PluginController;
use Tutor\PostTypes\AssignmentPostType;
use Tutor\Taxonomies\CourseTagTaxonomy;
use Tutor\Shortcodes\DashboardShortcode;
use Tutor\Controllers\ShortcodeController;
use Tutor\Taxonomies\CourseCategoryTaxonomy;
use Tutor\Controllers\RewriteRulesController;
use Tutor\Shortcodes\InstructorListShortcode;
use Tutor\Shortcodes\StudentRegistrationShortcode;
use Tutor\Shortcodes\InstructorRegistrationShortcode;

/**
 * Class TutorPlugin
 */
class TutorPlugin {

	/**
	 * Hold the class instance
	 *
	 * @var TutorPlugin
	 */
	private static $instance;

	/**
	 * Constructor
	 * Keep the constructor blank
	 */
	public function __construct() {}

	/**
	 * Clone magic method
	 * Keep this blank
	 *
	 * @return void
	 */
	public function __clone() {}

	/**
	 * Wakeup magic method
	 * Keep this blank
	 *
	 * @return void
	 */
	public function __wakeup() {}

	/**
	 * Get the class instance
	 *
	 * @return TutorPlugin
	 */
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initialize work for plugin
	 *
	 * @return void
	 */
	public function init() {
		new PluginController();
		new ActivationHook();
		new AssetManager();
		new AdminMenu();
		add_action( 'init', array( $this, 'init_action' ) );
		add_action( 'plugins_loaded', array( $this, 'on_plugin_loaded' ) );
	}

	/**
	 * Register Tutor Action Via do_action
	 *
	 * @since 1.2.14
	 * @return void
	 */
	public function init_action() {
		if ( isset( $_REQUEST['tutor_action'] ) ) {
			do_action( 'tutor_action_' . $_REQUEST['tutor_action'] );
		}
	}

	/**
	 * Task after on plugin loaded
	 *
	 * @return void
	 */
	public function on_plugin_loaded() {
		load_plugin_textdomain( 'tutor', false, TUTOR_PLUGIN_DIR . '/languages' );
		new AjaxController();
		new RewriteRulesController();
		new ApiManager();
	}

	/**
	 * Register custom post types
	 *
	 * @return void
	 */
	public function register_post_types() {
		new CoursePostType();
		new LessonPostType();
		new QuizPostType();
		new TopicPostType();
		new AssignmentPostType();
		new EnrolledPostType();
	}

	/**
	 * Register metaboxes for post types
	 *
	 * @return void
	 */
	public function register_metaboxes() {
		new CourseMetabox();
	}

	/**
	 * Register custom taxonomies
	 *
	 * @return void
	 */
	public function register_taxonomies() {
		new CourseCategoryTaxonomy();
		new CourseTagTaxonomy();
	}

	/**
	 * Register all plugin shortcodes
	 *
	 * @return void
	 */
	public function register_shortcodes() {
		new StudentRegistrationShortcode();
		new DashboardShortcode();
		new InstructorRegistrationShortcode();
		new CourseShortcode();
		new InstructorListShortcode();

		new ShortcodeController();
	}

	/**
	 * All integrations
	 *
	 * @return void
	 */
	public function add_integrations() {
		new WooCommerce();
		new TutorEDD();
	}

	/**
	 * Register all plugin widgets
	 *
	 * @return void
	 */
	public function register_widgets() {
		add_action(
			'widgets_init',
			function() {
				register_widget( 'Tutor\Widgets\CourseWidget' );
			}
		);
	}
}
