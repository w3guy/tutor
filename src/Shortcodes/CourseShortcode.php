<?php
namespace Tutor\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Contracts\ShortcodeContract;

/**
 * Class CourseShortcode
 */
class CourseShortcode implements ShortcodeContract {
	/**
	 * Shortcode tag name
	 *
	 * @var string
	 */
	protected $tag = 'tutor_course';

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_shortcode( $this->tag, array( $this, 'add' ) );
	}

	/**
	 * Add shortcode
	 *
	 * @param array $atts
	 * @return mixed
	 */
	public function add( $atts ) {
		$course_post_type = tutor()->course_post_type;

		$a = shortcode_atts(
			array(
				'post_type'   => $course_post_type,
				'post_status' => 'publish',

				'id'          => '',
				'exclude_ids' => '',
				'category'    => '',

				'orderby'     => 'ID',
				'order'       => 'DESC',
				'count'       => 6,
				'paged'       => get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1,
			),
			$atts
		);

		if ( ! empty( $a['id'] ) ) {
			$ids           = (array) explode( ',', $a['id'] );
			$a['post__in'] = $ids;
		}

		if ( ! empty( $a['exclude_ids'] ) ) {
			$exclude_ids       = (array) explode( ',', $a['exclude_ids'] );
			$a['post__not_in'] = $exclude_ids;
		}
		if ( ! empty( $a['category'] ) ) {
			$category = (array) explode( ',', $a['category'] );

			$a['tax_query'] = array(
				array(
					'taxonomy' => 'course-category',
					'field'    => 'term_id',
					'terms'    => $category,
					'operator' => 'IN',
				),
			);
		}
		$a['posts_per_page'] = (int) $a['count'];

		wp_reset_query();
		$the_query = new \WP_Query( $a );

		// Load the renderer now
		ob_start();
		tutor_load_template(
			'archive-course-init',
			array(
				'course_filter'     => isset( $atts['course_filter'] ) && $atts['course_filter'] == 'on',
				'supported_filters' => tutor_utils()->get_option( 'supported_course_filters', array() ),
				'loop_content_only' => false,
				'column_per_row'    => isset( $atts['column_per_row'] ) ? $atts['column_per_row'] : null,
				'course_per_page'   => $a['posts_per_page'],
				'show_pagination'   => isset( $atts['show_pagination'] ) && $atts['show_pagination'] == 'on',
				'the_query'         => $the_query,
			)
		);
		$output = ob_get_clean();

		wp_reset_postdata();

		return $output;
	}
}
