<?php
namespace Tutor\API;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WP_REST_Request;
use Tutor\Core\Traits\ApiResponse;

/**
 * Class TopicApi
 *
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */
class TopicApi {
	use ApiResponse;

	private $post_parent;
	private $post_type = 'topics';

	/**
	 * Get topic data by course ID.
	 *
	 * @param WP_REST_Request $request request data.
	 * @return mixed
	 */
	public function course_topic( WP_REST_Request $request ) {
		$this->post_parent = $request->get_param( 'id' );

		global $wpdb;

		$table = $wpdb->prefix . 'posts';

		$result = $wpdb->get_results(
			$wpdb->prepare( "SELECT ID, post_title, post_content, post_name FROM $table WHERE post_type = %s AND post_parent = %d", $this->post_type, $this->post_parent )
		);

		if ( count( $result ) > 0 ) {
			return $this->api_data( $result );
		}

		return $this->api_fail( __( 'Topic not found for given ID', 'tutor' ) );
	}
}
