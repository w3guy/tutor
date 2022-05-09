<?php
namespace Tutor\Hooks;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class ActivationHook
 *
 * @package tutor
 * @link: https://themeum.com
 */
class ActivationHook {

	/**
	 * Constructor
	 */
	public function __construct() {
		register_activation_hook( TUTOR_PLUGIN_FILE, array( $this, 'on_plugin_activated' ) );
		register_deactivation_hook( TUTOR_PLUGIN_FILE, array( $this, 'on_plugin_deactivated' ) );
	}

	/**
	 * Run on plugin activated
	 *
	 * @return void
	 */
	public function on_plugin_activated() {
		$version = get_option( 'tutor_version' );
		$this->create_tables();

		// Save Option
		if ( ! $version ) {
			$this->create_role_and_permission();
			$this->create_tutor_pages();

			$options = self::default_options();
			update_option( 'tutor_option', $options );

			// Rewrite Flush.
			update_option( 'required_rewrite_flush', tutor_time() );
			update_option( 'tutor_version', TUTOR_VERSION );
		}

		// Set Schedule
		if ( ! wp_next_scheduled( 'tutor_once_in_day_run_schedule' ) ) {
			wp_schedule_event( tutor_time(), 'twicedaily', 'tutor_once_in_day_run_schedule' );
		}

		/**
		 * Backward Compatibility for version < 1.2.0
		 */
		if ( version_compare( get_option( 'tutor_version' ), '1.2.0', '<' ) ) {
			/**
			 * Creating New Database
			 */
			self::create_withdraw_database();
			// Update the tutor version
			update_option( 'tutor_version', '1.2.0' );
			// Rewrite Flush
			update_option( 'required_rewrite_flush', tutor_time() );
		}

		/**
		 * Backward Compatibility to < 1.3.1 for make course plural
		 */
		if ( version_compare( get_option( 'tutor_version' ), '1.3.1', '<' ) ) {
			global $wpdb;

			if ( ! get_option( 'is_course_post_type_updated' ) ) {
				$wpdb->update( $wpdb->posts, array( 'post_type' => 'courses' ), array( 'post_type' => 'course' ) );
				update_option( 'is_course_post_type_updated', true );
				update_option( 'tutor_version', '1.3.1' );
				flush_rewrite_rules();
			}
		}

		/**
		 * Save First activation Time
		 */
		$first_activation_date = get_option( 'tutor_first_activation_time' );
		if ( ! $first_activation_date ) {
			update_option( 'tutor_first_activation_time', tutor_time() );
		}
	}

	/**
	 * Run on plugin deactivated
	 *
	 * @return void
	 */
	public function on_plugin_deactivated() {
		wp_clear_scheduled_hook( 'tutor_once_in_day_run_schedule' );
	}

	/**
	 * Redirect to setup page
	 *
	 * @return void
	 */
	public function goto_setup_page() {
		if ( ( ! get_option( 'tutor_wizard' ) ) && version_compare( TUTOR_VERSION, '1.5.6', '>' ) ) {
			update_option( 'tutor_wizard', 'active' );
			wp_redirect( admin_url( 'admin.php?page=tutor-setup' ) );
			exit;
		}
	}

	/**
	 * Plguin default options
	 *
	 * @return array
	 */
	public static function default_options() {
		$options = array(
			'pagination_per_page'               => '20',
			'course_allow_upload_private_files' => '1',
			'display_course_instructors'        => '1',
			'enable_q_and_a_on_course'          => '1',
			'courses_col_per_row'               => '3',
			'courses_per_page'                  => '12',
			'lesson_permalink_base'             => 'lesson',
			'quiz_when_time_expires'            => 'autosubmit',
			'quiz_attempts_allowed'             => '10',
			'quiz_grade_method'                 => 'highest_grade',
			'enable_public_profile'             => '1',
			'email_to_students'                 =>
				array(
					'quiz_completed'   => '1',
					'completed_course' => '1',
				),
			'email_to_instructors'              =>
				array(
					'a_student_enrolled_in_course' => '1',
					'a_student_completed_course'   => '1',
					'a_student_completed_lesson'   => '1',
					'a_student_placed_question'    => '1',
				),
			'email_from_name'                   => get_option( 'blogname' ),
			'email_from_address'                => get_option( 'admin_email' ),
			'email_footer_text'                 => '',
			'earning_admin_commission'          => '20',
			'earning_admin_commission'          => '20',
			'earning_instructor_commission'     => '80',
		);
		return $options;
	}

	/**
	 * Create tutor pages
	 *
	 * @return void
	 */
	public static function create_tutor_pages() {
		$student_dashboard_args    = array(
			'post_title'   => __( 'Dashboard', 'tutor' ),
			'post_content' => '',
			'post_type'    => 'page',
			'post_status'  => 'publish',
		);
		$student_dashboard_page_id = wp_insert_post( $student_dashboard_args );
		tutor_utils()->update_option( 'tutor_dashboard_page_id', $student_dashboard_page_id );

		$student_registration_args = array(
			'post_title'   => __( 'Student Registration', 'tutor' ),
			'post_content' => '[tutor_student_registration_form]',
			'post_type'    => 'page',
			'post_status'  => 'publish',
		);
		$student_register_page_id  = wp_insert_post( $student_registration_args );
		tutor_utils()->update_option( 'student_register_page', $student_register_page_id );

		$instructor_registration_args = array(
			'post_title'   => __( 'Instructor Registration', 'tutor' ),
			'post_content' => '[tutor_instructor_registration_form]',
			'post_type'    => 'page',
			'post_status'  => 'publish',
		);
		$instructor_registration_id   = wp_insert_post( $instructor_registration_args );
		tutor_utils()->update_option( 'instructor_register_page', $instructor_registration_id );
	}

	/**
	 * Create role and role permission
	 *
	 * @return void
	 */
	private function create_role_and_permission() {
		$instructor_role = tutor()->instructor_role;
		add_role( $instructor_role, __( 'Tutor Instructor', 'tutor' ), array() );

		$custom_post_type_permission = array(
			// Manage Instructor.
			'manage_tutor_instructor',

			// Tutor Posts Type Permission.
			'edit_tutor_course',
			'read_tutor_course',
			'delete_tutor_course',
			'delete_tutor_courses',
			'edit_tutor_courses',
			'edit_others_tutor_courses',
			'read_private_tutor_courses',
			'edit_tutor_courses',

			'edit_tutor_lesson',
			'read_tutor_lesson',
			'delete_tutor_lesson',
			'delete_tutor_lessons',
			'edit_tutor_lessons',
			'edit_others_tutor_lessons',
			'read_private_tutor_lessons',
			'edit_tutor_lessons',
			'publish_tutor_lessons',

			'edit_tutor_quiz',
			'read_tutor_quiz',
			'delete_tutor_quiz',
			'delete_tutor_quizzes',
			'edit_tutor_quizzes',
			'edit_others_tutor_quizzes',
			'read_private_tutor_quizzes',
			'edit_tutor_quizzes',
			'publish_tutor_quizzes',

			'edit_tutor_question',
			'read_tutor_question',
			'delete_tutor_question',
			'delete_tutor_questions',
			'edit_tutor_questions',
			'edit_others_tutor_questions',
			'publish_tutor_questions',
			'read_private_tutor_questions',
			'edit_tutor_questions',
		);

		$instructor = get_role( $instructor_role );
		if ( $instructor ) {
			$instructor_cap = array(
				'edit_posts',
				'read',
				'upload_files',
			);

			$instructor_cap = array_merge( $instructor_cap, $custom_post_type_permission );

			$can_publish_course = (bool) get_option( 'instructor_can_publish_course' );
			if ( $can_publish_course ) {
				$instructor_cap[] = 'publish_tutor_courses';
			}

			foreach ( $instructor_cap as $cap ) {
				$instructor->add_cap( $cap );
			}
		}

		$administrator = get_role( 'administrator' );
		if ( $administrator ) {
			$administrator_cap   = array(
				'manage_tutor',
			);
			$administrator_cap   = array_merge( $administrator_cap, $custom_post_type_permission );
			$administrator_cap[] = 'publish_tutor_courses';

			foreach ( $administrator_cap as $cap ) {
				$administrator->add_cap( $cap );
			}
		}

		/**
		 * Add Instructor role to administrator
		 */
		if ( current_user_can( 'administrator' ) ) {
			tutor_utils()->add_instructor_role( get_current_user_id() );
		}
	}

	/**
	 * Create database tables
	 *
	 * @return void
	 */
	private function create_tables() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		/**
		 * Table SQL
		 *
		 * {$wpdb->prefix}tutor_quiz_attempts
		 * {$wpdb->prefix}tutor_quiz_attempt_answers
		 * {$wpdb->prefix}tutor_quiz_questions
		 * {$wpdb->prefix}tutor_quiz_question_answers
		 * {$wpdb->prefix}tutor_earnings
		 * {$wpdb->prefix}tutor_withdraws
		 *
		 * @since v.1.0.0
		 */
		$quiz_attempts_sql = "CREATE TABLE {$wpdb->prefix}tutor_quiz_attempts (
				attempt_id bigint(20) NOT NULL AUTO_INCREMENT,
				course_id bigint(20) DEFAULT NULL,
				quiz_id bigint(20) DEFAULT NULL,
				user_id bigint(20) DEFAULT NULL,
				total_questions int(11) DEFAULT NULL,
				total_answered_questions int(11) DEFAULT NULL,
				total_marks decimal(9,2) DEFAULT NULL,
				earned_marks decimal(9,2) DEFAULT NULL,
				attempt_info text,
				attempt_status varchar(50) DEFAULT NULL,
				attempt_ip varchar(250) DEFAULT NULL,
				attempt_started_at datetime DEFAULT NULL,
				attempt_ended_at datetime DEFAULT NULL,
				is_manually_reviewed int(1) DEFAULT NULL,
				manually_reviewed_at datetime DEFAULT NULL,
				PRIMARY KEY  (attempt_id)
			) $charset_collate;";

		$quiz_attempt_answers = "CREATE TABLE {$wpdb->prefix}tutor_quiz_attempt_answers (
			  	attempt_answer_id bigint(20) NOT NULL AUTO_INCREMENT,
				user_id bigint(20) DEFAULT NULL,
			  	quiz_id bigint(20) DEFAULT NULL,
			  	question_id bigint(20) DEFAULT NULL,
			  	quiz_attempt_id bigint(20) DEFAULT NULL,
			  	given_answer longtext,
			  	question_mark decimal(8,2) DEFAULT NULL,
			  	achieved_mark decimal(8,2) DEFAULT NULL,
			  	minus_mark decimal(8,2) DEFAULT NULL,
			  	is_correct tinyint(4) DEFAULT NULL,
			  	PRIMARY KEY  (attempt_answer_id)
			) $charset_collate;";

		$tutor_quiz_questions = "CREATE TABLE {$wpdb->prefix}tutor_quiz_questions (
				question_id bigint(20) NOT NULL AUTO_INCREMENT,
				quiz_id bigint(20) DEFAULT NULL,
				question_title text,
				question_description longtext,
				question_type varchar(50) DEFAULT NULL,
				question_mark decimal(9,2) DEFAULT NULL,
				question_settings longtext,
				question_order int(11) DEFAULT NULL,
				PRIMARY KEY (question_id)
			) $charset_collate;";

		$tutor_quiz_question_answers = "CREATE TABLE {$wpdb->prefix}tutor_quiz_question_answers (
			 	answer_id bigint(20) NOT NULL AUTO_INCREMENT,
			  	belongs_question_id bigint(20) DEFAULT NULL,
			  	belongs_question_type varchar(250) DEFAULT NULL,
			  	answer_title text,
			  	is_correct tinyint(4) DEFAULT NULL,
			  	image_id bigint(20) DEFAULT NULL,
			  	answer_two_gap_match text,
			  	answer_view_format varchar(250) DEFAULT NULL,
			  	answer_settings text,
			  	answer_order int(11) DEFAULT '0',
				PRIMARY KEY (answer_id)
			) $charset_collate;";

		$earning_table = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tutor_earnings (
			earning_id bigint(20) NOT NULL AUTO_INCREMENT,
			user_id bigint(20) DEFAULT NULL,
			course_id bigint(20) DEFAULT NULL,
			order_id bigint(20) DEFAULT NULL,
			order_status varchar(50) DEFAULT NULL,
			course_price_total decimal(16,2) DEFAULT NULL,
			course_price_grand_total decimal(16,2) DEFAULT NULL,
			instructor_amount decimal(16,2) DEFAULT NULL,
			instructor_rate decimal(16,2) DEFAULT NULL,
			admin_amount decimal(16,2) DEFAULT NULL,
			admin_rate decimal(16,2) DEFAULT NULL,
			commission_type varchar(20) DEFAULT NULL,
			deduct_fees_amount decimal(16,2) DEFAULT NULL,
			deduct_fees_name varchar(250) DEFAULT NULL,
			deduct_fees_type varchar(20) DEFAULT NULL,
			process_by varchar(20) DEFAULT NULL,
			created_at datetime DEFAULT NULL,
			PRIMARY KEY (earning_id)
		) $charset_collate;";

		$withdraw_table = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tutor_withdraws (
			withdraw_id bigint(20) NOT NULL AUTO_INCREMENT,
			user_id bigint(20) DEFAULT NULL,
			amount decimal(16,2) DEFAULT NULL,
			method_data text DEFAULT NULL,
			status varchar(50) DEFAULT NULL,
			updated_at datetime DEFAULT NULL,
			created_at datetime DEFAULT NULL,
			PRIMARY KEY (withdraw_id)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $quiz_attempts_sql );
		dbDelta( $quiz_attempt_answers );
		dbDelta( $tutor_quiz_questions );
		dbDelta( $tutor_quiz_question_answers );
		dbDelta( $earning_table );
		dbDelta( $withdraw_table );
	}

	/**
	 * Create withdraw database
	 *
	 * @since v.1.2.0
	 */
	public static function create_withdraw_database() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		/**
		 * Table SQL
		 *
		 * {$wpdb->prefix}tutor_earnings
		 * {$wpdb->prefix}tutor_withdraws
		 *
		 * @since v.1.2.0
		 */

		$earning_table = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tutor_earnings (
			earning_id bigint(20) NOT NULL AUTO_INCREMENT,
			user_id bigint(20) DEFAULT NULL,
			course_id bigint(20) DEFAULT NULL,
			order_id bigint(20) DEFAULT NULL,
			order_status varchar(50) DEFAULT NULL,
			course_price_total decimal(16,2) DEFAULT NULL,
			course_price_grand_total decimal(16,2) DEFAULT NULL,
			instructor_amount decimal(16,2) DEFAULT NULL,
			instructor_rate decimal(16,2) DEFAULT NULL,
			admin_amount decimal(16,2) DEFAULT NULL,
			admin_rate decimal(16,2) DEFAULT NULL,
			commission_type varchar(20) DEFAULT NULL,
			deduct_fees_amount decimal(16,2) DEFAULT NULL,
			deduct_fees_name varchar(250) DEFAULT NULL,
			deduct_fees_type varchar(20) DEFAULT NULL,
			process_by varchar(20) DEFAULT NULL,
			created_at datetime DEFAULT NULL,
			PRIMARY KEY (earning_id)
		) $charset_collate;";

		$withdraw_table = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}tutor_withdraws (
			withdraw_id bigint(20) NOT NULL AUTO_INCREMENT,
			user_id bigint(20) DEFAULT NULL,
			amount decimal(16,2) DEFAULT NULL,
			method_data text DEFAULT NULL,
			status varchar(50) DEFAULT NULL,
			updated_at datetime DEFAULT NULL,
			created_at datetime DEFAULT NULL,
			PRIMARY KEY (withdraw_id)
		) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $earning_table );
		dbDelta( $withdraw_table );

		/**
		 * Setting previous dashboard to new dashboard
		 */
		$previous_dashboard_page_id = (int) tutor_utils()->get_option( 'student_dashboard' );
		tutor_utils()->update_option( 'tutor_dashboard_page_id', $previous_dashboard_page_id );
	}
}
