<?php
namespace Tutor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Input;
use Tutor\Classes\Quiz;
use Tutor\Classes\User;
use Tutor\Classes\Lesson;
use Tutor\Classes\Reviews;
use Tutor\Classes\Student;
use Tutor\Classes\Frontend;
use Tutor\Classes\Template;
use Tutor\Classes\Upgrader;
use Tutor\Classes\Withdraw;
use Tutor\Classes\Dashboard;
use Tutor\Classes\Gutenberg;
use Tutor\Classes\Instructor;
use Tutor\Classes\FormHandler;
use Tutor\Classes\CourseFilter;
use Tutor\Controllers\QuestionAnswerController;
use Tutor\Classes\CourseSettingsTabs;
use Tutor\Classes\ThemeCompatibility;
use Tutor\Classes\PrivateCourseAccess;
use Tutor\Controllers\SetupController;
use Tutor\Controllers\ToolsController;
use Tutor\Controllers\AddonsController;
use Tutor\Controllers\CourseController;
use Tutor\Controllers\GetProController;
use Tutor\Controllers\StudentController;
use Tutor\Controllers\SettingsController;
use Tutor\Controllers\InstructorController;
use Tutor\Controllers\QuizAttemptController;
use Tutor\Controllers\AnnouncementController;
use Tutor\Controllers\WithdrawRequestController;

/**
 * Class AdminMenu
 */
class AdminMenu {

	/**
	 * Controller instances
	 */
	private $course_ctrl;
	private $tools_ctrl;
	private $setup_ctrl;
	private $settings_ctrl;
	private $announcement_ctrl;
	private $question_answer_ctrl;
	private $quiz_attempt_ctrl;
	private $withdraw_req_ctrl;
	private $addons_ctrl;
	private $get_pro_ctrl;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->course_ctrl          = new CourseController();
		$this->tools_ctrl           = new ToolsController();
		$this->setup_ctrl           = new SetupController();
		$this->settings_ctrl        = new SettingsController();
		$this->student_ctrl         = new StudentController();
		$this->instructor_ctrl      = new InstructorController();
		$this->announcement_ctrl    = new AnnouncementController();
		$this->question_answer_ctrl = new QuestionAnswerController();
		$this->quiz_attempt_ctrl    = new QuizAttemptController();
		$this->withdraw_req_ctrl    = new WithdrawRequestController();
		$this->addons_ctrl          = new AddonsController();
		$this->get_pro_ctrl         = new GetProController();

		new Lesson();
		new Template();
		new Instructor();
		new Quiz();
		new User();
		new ThemeCompatibility();
		new Gutenberg();
		new CourseSettingsTabs();
		new Withdraw();
		new Upgrader();
		new Dashboard();
		new FormHandler();
		new Frontend();
		new PrivateCourseAccess();
		new CourseFilter();
		new Reviews();
		new Student();

		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_filter( 'submenu_file', array( $this, 'submenu_file_active' ), 10, 2 );
		add_filter( 'parent_file', array( $this, 'parent_menu_active' ) );

		add_action( 'admin_init', array( $this, 'filter_posts_for_instructors' ) );
		add_action( 'load-post.php', array( $this, 'check_if_current_users_post' ) );
	}

	/**
	 * Add admin menu
	 *
	 * @return void
	 */
	public function add_admin_menu() {
		$hasPro          = tutor()->has_pro;
		$pro_text        = $hasPro ? ' ' . __( 'Pro', 'tutor' ) : '';
		$parent_slug     = 'tutor';
		$admin_menu_text = __( 'Tutor LMS', 'tutor' ) . $pro_text;

		$welcome                   = $this->setup_ctrl->is_welcome_page_visited();
		$enable_course_marketplace = (bool) tutor_utils()->get_option( 'enable_course_marketplace' );

		$unanswered_questions = tutor_utils()->unanswered_question_count();
		$unanswered_bubble    = '';
		if ( $unanswered_questions ) {
			$unanswered_bubble = '<span class="update-plugins count-' . $unanswered_questions . '"><span class="plugin-count">' . $unanswered_questions . '</span></span>';
		}

		add_menu_page(
			$admin_menu_text,
			$admin_menu_text,
			'manage_tutor_instructor',
			$parent_slug,
			false === $welcome && 'tutor' === Input::get( 'page' ) && Input::has( 'welcome' ) ? array( $this->setup_ctrl, 'show_welcome_page' ) : array( $this->course_ctrl, 'show_courses_page' ),
			'data:image/svg+xml;base64,' . base64_encode( file_get_contents( TUTOR_ASSET_URL . '/images/tutor-menu-icon.svg') ),//phpcs:ignore
			2
		);

		add_submenu_page( $parent_slug, __( 'Courses', 'tutor' ), __( 'Courses', 'tutor' ), 'manage_tutor_instructor', 'tutor', array( $this->course_ctrl, 'show_courses_page' ), null );
		add_submenu_page( $parent_slug, __( 'Categories', 'tutor' ), __( 'Categories', 'tutor' ), 'manage_tutor', 'edit-tags.php?taxonomy=course-category&post_type=' . tutor()->course_post_type, null );
		add_submenu_page( $parent_slug, __( 'Tags', 'tutor' ), __( 'Tags', 'tutor' ), 'manage_tutor', 'edit-tags.php?taxonomy=course-tag&post_type=' . tutor()->course_post_type, null );
		add_submenu_page( $parent_slug, __( 'Students', 'tutor' ), __( 'Students', 'tutor' ), 'manage_tutor', 'tutor-students', array( $this->student_ctrl, 'show_students_page' ) );

		if ( $enable_course_marketplace ) {
			add_submenu_page( $parent_slug, __( 'Instructors', 'tutor' ), __( 'Instructors', 'tutor' ), 'manage_tutor', 'tutor-instructors', array( $this->instructor_ctrl, 'show_instructor_page' ) );
		}

		add_submenu_page( $parent_slug, __( 'Announcements', 'tutor' ), __( 'Announcements', 'tutor' ), 'manage_tutor_instructor', 'tutor_announcements', array( $this->announcement_ctrl, 'show_announcement_page' ) );
		add_submenu_page( $parent_slug, __( 'Q & A', 'tutor' ), __( 'Q & A ', 'tutor' ) . $unanswered_bubble, 'manage_tutor_instructor', 'question_answer', array( $this->question_answer_ctrl, 'show_qa_page' ) );
		add_submenu_page( $parent_slug, __( 'Quiz Attempts', 'tutor' ), __( 'Quiz Attempts', 'tutor' ), 'manage_tutor_instructor', 'tutor_quiz_attempts', array( $this->quiz_attempt_ctrl, 'show_quiz_attempts_page' ) );

		if ( $enable_course_marketplace ) {
			add_submenu_page( $parent_slug, __( 'Withdraw Requests', 'tutor' ), __( 'Withdraw Requests', 'tutor' ), 'manage_tutor', 'tutor_withdraw_requests', array( $this->withdraw_req_ctrl, 'show_withdraw_requests_page' ) );
		}

		add_submenu_page( $parent_slug, __( 'Add-ons', 'tutor' ), __( 'Add-ons', 'tutor' ), 'manage_tutor', 'tutor-addons', array( $this->addons_ctrl, 'show_addons_page' ) );
		add_submenu_page( $parent_slug, __( 'Tools', 'tutor' ), __( 'Tools', 'tutor' ), 'manage_tutor', 'tutor-tools', array( $this->tools_ctrl, 'show_tools_page' ) );
		add_submenu_page( $parent_slug, __( 'Settings', 'tutor' ), __( 'Settings', 'tutor' ), 'manage_tutor', 'tutor_settings', array( $this->settings_ctrl, 'show_settings_page' ) );

		if ( ! $hasPro ) {
			add_submenu_page( $parent_slug, __( 'Get Pro', 'tutor' ), __( '<span class="dashicons dashicons-awards tutor-get-pro-text"></span> Get Pro', 'tutor' ), 'manage_options', 'tutor-get-pro', array( $this->get_pro_ctrl, 'show_get_pro_page' ) );
		}

		add_dashboard_page( '', '', 'manage_options', 'tutor-setup', '' );
		remove_menu_page( 'edit.php?post_type=courses' );
	}

	/**
	 * Parent menu force active
	 *
	 * @param string $parent_file
	 * @return string
	 */
	public function parent_menu_active( $parent_file ) {
		$taxonomy = tutor_utils()->avalue_dot( 'taxonomy', tutor_sanitize_data( $_GET ) );
		if ( $taxonomy === 'course-category' || $taxonomy === 'course-tag' ) {
			return 'tutor';
		}
		return $parent_file;
	}

	/**
	 * Submenu set active class
	 *
	 * @param string $submenu_file
	 * @param string $parent_file
	 * @return string
	 */
	public function submenu_file_active( $submenu_file, $parent_file ) {
		$taxonomy         = Input::get( 'taxonomy' );
		$course_post_type = tutor()->course_post_type;

		if ( $taxonomy === 'course-category' ) {
			return 'edit-tags.php?taxonomy=course-category&post_type=' . $course_post_type;
		}
		if ( $taxonomy === 'course-tag' ) {
			return 'edit-tags.php?taxonomy=course-tag&post_type=' . $course_post_type;
		}
		return $submenu_file;
	}

	/**
	 * Filter posts for instructor
	 */
	public function filter_posts_for_instructors() {
		if ( ! current_user_can( 'administrator' ) && current_user_can( tutor()->instructor_role ) ) {
			@remove_menu_page( 'edit-comments.php' ); // Comments
			add_filter( 'posts_clauses_request', array( $this, 'posts_clauses_request' ) );
		}
	}

	/**
	 * Prevent unauthorised course/lesson edit page by direct URL
	 *
	 * @since v.1.0.0
	 */
	public function check_if_current_users_post() {
		if ( current_user_can( 'administrator' ) || ! current_user_can( tutor()->instructor_role ) ) {
			return;
		}

		if ( ! empty( $_GET['post'] ) ) {
			$get_post_id      = (int) $_GET['post'];
			$get_post         = get_post( $get_post_id );
			$tutor_post_types = array( tutor()->course_post_type, tutor()->lesson_post_type );

			$current_user = get_current_user_id();

			if ( in_array( $get_post->post_type, $tutor_post_types ) && $get_post->post_author != $current_user ) {
				global $wpdb;

				$get_assigned_courses_ids = (int) $wpdb->get_var(
					$wpdb->prepare(
						"SELECT user_id
					from {$wpdb->usermeta}
					WHERE user_id = %d AND meta_key = '_tutor_instructor_course_id' AND meta_value = %d ",
						$current_user,
						$get_post_id
					)
				);

				if ( ! $get_assigned_courses_ids ) {
					wp_die( __( 'Permission Denied', 'tutor' ) );
				}
			}
		}
	}
}
