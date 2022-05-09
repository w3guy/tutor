<?php
namespace Tutor\API;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WP_REST_Request;
use Tutor\Core\Traits\ApiResponse;

/**
 * Class AuthorApi
 *
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */

class AuthorApi {
	use ApiResponse;

	private $user_id;

	/**
	 * Get author details by ID.
	 *
	 * @param WP_REST_Request $request request data.
	 * @return mixed
	 */
	public function author_detail( WP_REST_Request $request ) {
		$this->user_id = $request->get_param( 'id' );
		global $wpdb;
		$table = $wpdb->prefix . 'users';

		// Author obj.
		$author = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT user_email, user_registered, display_name FROM $table WHERE ID = %d",
				$this->user_id
			)
		);

		if ( $author ) {
			// Get author course ID.
			$author->courses = get_user_meta( $this->user_id, '_tutor_instructor_course_id', false );
			return $this->api_data( $author );
		}

		return $this->api_fail( __( 'Author not found', 'tutor' ) );
	}
}
