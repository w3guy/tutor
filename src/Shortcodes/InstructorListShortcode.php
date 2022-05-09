<?php
namespace Tutor\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Contracts\ShortcodeContract;

/**
 * Class InstructorListShortcode
 */
class InstructorListShortcode implements ShortcodeContract {
	/**
	 * Instructor layout
	 *
	 * @var array
	 */
	public $instructor_layout = array(
		'default',
		'cover',
		'minimal',
		'portrait-horizontal',
		'minimal-horizontal',
	);

	/**
	 * Shortcode tag name
	 *
	 * @var string
	 */
	protected $tag = 'tutor_instructor_list';

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
		global $wpdb;
		! is_array( $atts ) ? $atts = array() : 0;

		$current_page = (int) tutor_utils()->array_get( 'instructor-page', $_GET, 1 );
		$current_page = $current_page >= 1 ? $current_page : 1;

		$show_filter         = isset( $atts['filter'] ) ? $atts['filter'] == 'on' : tutor_utils()->get_option( 'instructor_list_show_filter', false );
		$atts['show_filter'] = $show_filter;

		// Get instructor list to sow
		$payload                = $this->prepare_instructor_list( $current_page, $atts );
		$payload['show_filter'] = $show_filter;

		ob_start();
		tutor_load_template( 'shortcode.tutor-instructor', $payload );
		$content = ob_get_clean();

		if ( $show_filter ) {
			$limit           = 8;
			$course_taxonomy = 'course-category';
			$course_cats     = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT * FROM {$wpdb->terms} AS term
				INNER JOIN {$wpdb->term_taxonomy} AS taxonomy
					ON taxonomy.term_id = term.term_id AND taxonomy.taxonomy = %s
				ORDER BY term.term_id DESC
				LIMIT %d",
					$course_taxonomy,
					$limit
				)
			);

			$all_cats = $wpdb->get_var(
				$wpdb->prepare(
					"SELECT COUNT(*) as total FROM {$wpdb->terms} AS term
					INNER JOIN {$wpdb->term_taxonomy} AS taxonomy
						ON taxonomy.term_id = term.term_id AND taxonomy.taxonomy = %s
					ORDER BY term.term_id DESC",
					$course_taxonomy
				)
			);

			$attributes = $payload;
			unset( $attributes['instructors'] );

			$payload = array(
				'show_filter' => $show_filter,
				'content'     => $content,
				'categories'  => $course_cats,
				'all_cats'    => $all_cats,
				'attributes'  => array_merge( $atts, $attributes ),
			);

			ob_start();

			tutor_load_template( 'shortcode.instructor-filter', $payload );

			$content = ob_get_clean();
		}

		return $content;
	}

	private function prepare_instructor_list( $current_page, $atts, $cat_ids = array(), $keyword = '' ) {
		$default_pagination = tutor_utils()->get_option( 'pagination_per_page', 9 );
		$limit              = (int) sanitize_text_field( tutor_utils()->array_get( 'count', $atts, $default_pagination ) );
		$page               = $current_page - 1;
		$rating_filter      = isset( $_POST['rating_filter'] ) ? $_POST['rating_filter'] : '';

		/**
		 * Short by Relevant | New | Popular
		 *
		 * @since v2.0.0
		 */
		$short_by = '';
		if ( isset( $_POST['short_by'] ) && $_POST['short_by'] === 'new' ) {
			$short_by = 'new';
		} elseif ( isset( $_POST['short_by'] ) && $_POST['short_by'] === 'popular' ) {
			$short_by = 'popular';
		} else {
			$short_by = 'ASC';
		}
		$instructors       = tutor_utils()->get_instructors( $limit * $page, $limit, $keyword, '', '', $short_by, 'approved', $cat_ids, $rating_filter );
		$instructors_count = tutor_utils()->get_instructors( $limit * $page, $limit, $keyword, '', '', $short_by, 'approved', $cat_ids, $rating_filter, true );

		$layout      = sanitize_text_field( tutor_utils()->array_get( 'layout', $atts, '' ) );
		$layout      = in_array( $layout, $this->instructor_layout ) ? $layout : tutor_utils()->get_option( 'instructor_list_layout', $this->instructor_layout[0] );
		$default_col = tutor_utils()->get_option( 'courses_col_per_row', 3 );

		$payload = array(
			'instructors'       => is_array( $instructors ) ? $instructors : array(),
			'instructors_count' => $instructors_count,
			'column_count'      => sanitize_text_field( tutor_utils()->array_get( 'column_per_row', $atts, $default_col ) ),
			'layout'            => $layout,
			'limit'             => $limit,
			'current_page'      => $current_page,
			'filter'            => $atts,
		);

		return $payload;
	}
}
