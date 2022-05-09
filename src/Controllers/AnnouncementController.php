<?php
namespace Tutor\Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Input;
use Tutor\Traits\BackendPageTrait;

/**
 * Class AnnouncementController
 * 
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */
class AnnouncementController {
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
		$this->page_title = __( 'Announcements', 'tutor' );
		/**
		 * Handle bulk action
		 *
		 * @since v2.0.0
		 */
		add_action( 'wp_ajax_tutor_announcement_bulk_action', array( $this, 'announcement_bulk_action' ) );
	}

	/**
	 * Show announcement page.
	 *
	 * @return void
	 */
	public function show_announcement_page() {
		$announcement_obj = new self();

		$limit         = tutor_utils()->get_option( 'pagination_per_page' );
		$page_filter   = Input::get( 'paged', 1, Input::TYPE_INT );
		$order_filter  = Input::get( 'order', 'DESC' );
		$search_filter = Input::get( 'search', '' );
		$course_id     = Input::get( 'course-id', '' );
		$date_filter   = Input::get( 'date', '' );

		$year  = date( 'Y', strtotime( $date_filter ) );
		$month = date( 'm', strtotime( $date_filter ) );
		$day   = date( 'd', strtotime( $date_filter ) );

		$args = array(
			'post_type'      => 'tutor_announcements',
			'post_status'    => 'publish',
			's'              => $search_filter,
			'post_parent'    => $course_id,
			'posts_per_page' => sanitize_text_field( $limit ),
			'paged'          => sanitize_text_field( $page_filter ),
			'orderBy'        => 'ID',
			'order'          => sanitize_text_field( $order_filter ),
		);

		if ( ! empty( $date_filter ) ) {
			$args['date_query'] = array(
				array(
					'year'  => $year,
					'month' => $month,
					'day'   => $day,
				),
			);
		}

		if ( ! current_user_can( 'administrator' ) ) {
			$args['author'] = get_current_user_id();
		}

		$the_query = new \WP_Query( $args );

		/**
		 * Navbar data to make nav menu
		 */
		$navbar_data = array(
			'page_title' => $announcement_obj->page_title,
		);

		/**
		 * Filters for sorting searching
		 */
		$filters = array(
			'bulk_action'   => $announcement_obj->bulk_action,
			'bulk_actions'  => $announcement_obj->prepare_bulk_actions(),
			'ajax_action'   => 'tutor_announcement_bulk_action',
			'filters'       => true,
			'course_filter' => true,
		);

		include tutor()->path . 'views/pages/announcements.php';
	}

	/**
	 * Prepare bulk actions that will show on dropdown options
	 *
	 * @return array
	 * @since v2.0.0
	 */
	public function prepare_bulk_actions(): array {
		$actions = array(
			$this->bulk_action_default(),
			$this->bulk_action_delete(),
		);
		return $actions;
	}

	/**
	 * Handle bulk action for enrollment cancel | delete
	 *
	 * @return string JSON response.
	 * @since v2.0.0
	 */
	public function announcement_bulk_action() {
		// check nonce.
		tutor_utils()->checking_nonce();
		$action   = isset( $_POST['bulk-action'] ) ? sanitize_text_field( $_POST['bulk-action'] ) : '';
		$bulk_ids = isset( $_POST['bulk-ids'] ) ? sanitize_text_field( $_POST['bulk-ids'] ) : '';
		$update   = self::delete_announcements( $action, $bulk_ids );
		return true === $update ? wp_send_json_success() : wp_send_json_error();
		exit;
	}

	/**
	 * Execute bulk action for enrollments ex: complete | cancel
	 *
	 * @param string $action hold action.
	 * @param string $bulk_ids ids that need to update.
	 * @return bool
	 * @since v2.0.0
	 */
	public static function delete_announcements( $action, $bulk_ids ): bool {
		global $wpdb;
		$post_table = $wpdb->posts;
		if ( 'delete' === $action ) {
			$delete = $wpdb->query(
				$wpdb->prepare(
					" DELETE FROM {$post_table}
                    WHERE ID IN ($bulk_ids)
                "
				)
			);
			return false === $delete ? false : true;
		}
		return false;
	}
}
