<?php
namespace Tutor\API;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WP_REST_Request;
use Tutor\Core\Traits\ApiResponse;

/**
 * Class RatingApi
 *
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */

class RatingApi {
	use ApiResponse;
	private $post_id;
	private $post_type = 'tutor_course_rating';

	/**
	 * Comment/review with meta by course id.
	 *
	 * @param WP_REST_Request $request request data.
	 * @return mixed
	 */
	public function course_rating( WP_REST_Request $request ) {
		$this->post_id = $request->get_param( 'id' );

		global $wpdb;
		$t_comment     = $wpdb->prefix . 'comments';
		$t_commentmeta = $wpdb->prefix . 'commentmeta';

		$ratings = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT c.comment_author,c.comment_author_email,comment_date,
					comment_content,comment_approved, cm.meta_value as rating 
					FROM $t_comment as c JOIN $t_commentmeta as cm ON cm.comment_id = c.comment_ID 
					WHERE c.comment_post_ID = %d AND c.comment_type = %s ",
				$this->post_id,
				$this->post_type
			)
		);

		if ( count( $ratings ) > 0 ) {
			return $this->api_data( $ratings );
		}

		return $this->api_fail( __( 'Rating not found for given ID', 'tutor' ) );
	}
}
