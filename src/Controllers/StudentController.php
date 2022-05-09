<?php
namespace Tutor\Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Input;
use Tutor\Traits\BackendPageTrait;

/**
 * Class StudentController
 * 
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */
class StudentController {
	use BackendPageTrait;

	/**
	 * Page Title
	 *
	 * @var $page_title
	 */
	public $page_title;

	/**
	 * Bulk Action
	 *
	 * @var $bulk_action
	 */
	public $bulk_action = true;

	/**
	 * Handle dependencies
	 */
	public function __construct() {
		$this->page_title = __( 'Students', 'tutor' );
		/**
		 * Handle bulk action
		 *
		 * @since v2.0.0
		 */
		add_action( 'wp_ajax_tutor_student_bulk_action', array( $this, 'student_bulk_action' ) );
	}

	public function show_students_page() {
		$user_id   = Input::get( 'user_id', '' );
		$course_id = Input::get( 'course-id', '' );
		$order     = Input::get( 'order', 'DESC' );
		$date      = Input::has( 'date' ) ? tutor_get_formated_date( 'Y-m-d', Input::get( 'date' ) ) : '';
		$search    = Input::get( 'search', '' );

		$paged    = Input::get( 'paged', 1, Input::TYPE_INT );
		$per_page = tutor_utils()->get_option( 'pagination_per_page' );
		$offset   = ( $per_page * $paged ) - $per_page;

		$students_list = tutor_utils()->get_students( $offset, $per_page, $search, $course_id, $date, $order );
		$total         = tutor_utils()->get_total_students( $search, $course_id, $date );

		$navbar_data = array(
			'page_title' => $this->page_title,
		);

		/**
		 * Bulk action & filters
		 */
		$filters = array(
			'bulk_action'   => tutor_utils()->has_user_role( 'administrator' ) ? $this->bulk_action : false,
			'bulk_actions'  => $this->prpare_bulk_actions(),
			'ajax_action'   => 'tutor_student_bulk_action',
			'filters'       => true,
			'course_filter' => true,
		);

		include tutor()->path . 'views/pages/students.php';
	}

	/**
	 * Prepare bulk actions that will show on dropdown options
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function prpare_bulk_actions(): array {
		$actions = array(
			$this->bulk_action_default(),
			$this->bulk_action_delete(),
		);
		return $actions;
	}

	/**
	 * Handle bulk action for student delete
	 *
	 * @return string JSON response.
	 * @since v2.0.0
	 */
	public function student_bulk_action() {
		// check nonce.

		tutor_utils()->checking_nonce();
		$action   = isset( $_POST['bulk-action'] ) ? sanitize_text_field( $_POST['bulk-action'] ) : '';
		$bulk_ids = isset( $_POST['bulk-ids'] ) ? sanitize_text_field( $_POST['bulk-ids'] ) : array();
		if ( 'delete' === $action ) {
			return true === self::delete_students( $bulk_ids ) ? wp_send_json_success() : wp_send_json_error();
		}
		return wp_send_json_error();
		exit;
	}

	/**
	 * Delete student
	 *
	 * @param string $student_ids, ids that need to delete.
	 * @param int    $reassign_id, reassign to other user.
	 * @return bool
	 * @since v2.0.0
	 */
	public static function delete_students( string $student_ids, $reassign_id = null ): bool {
		$student_ids     = explode( ',', $student_ids );
		$current_user_id = get_current_user_id();

		foreach ( $student_ids as $id ) {
			if ( $id != $current_user_id ) {
				null === $reassign_id ? wp_delete_user( $id ) : wp_delete_user( $id, $reassign_id );
			}
		}

		return true;
	}
}
