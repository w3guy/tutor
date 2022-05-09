<?php
namespace Tutor\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\PostType;

/**
 * Class CourseModel
 */
class CourseModel {
	/**
	 * Get number of course by status
	 *
	 * @param string $status post type status.
	 * @return int
	 */
	public static function count( $status = PostType::STATUS_PUBLISH ) {
		$count = wp_count_posts( tutor()->course_post_type );
		switch ( $status ) {
			case PostType::STATUS_PUBLISH:
				return $count->publish;
			case PostType::STATUS_DRAFT:
				return $count->draft;
			case PostType::STATUS_PENDING:
				return $count->pending;
			case PostType::STATUS_FUTURE:
				return $count->future;
			case PostType::STATUS_PRIVATE:
				return $count->private;
			default:
				return $count->publish;
		}
	}
}
