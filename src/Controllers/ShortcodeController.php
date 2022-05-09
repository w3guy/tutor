<?php
namespace Tutor\Controllers;

/**
 * Class ShortcodeController
 * 
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */
class ShortcodeController {

	public $instructor_layout = array(
		'default',
		'cover',
		'minimal',
		'portrait-horizontal',
		'minimal-horizontal',
	);

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'tutor_options_after_instructors', array( $this, 'tutor_instructor_layout' ) );
		add_action( 'wp_ajax_load_filtered_instructor', array( $this, 'load_filtered_instructor' ) );
		add_action( 'wp_ajax_nopriv_load_filtered_instructor', array( $this, 'load_filtered_instructor' ) );

		/**
		 * Load more categories
		 *
		 * @since 2.0.0
		 */
		add_action( 'wp_ajax_show_more', array( $this, 'show_more' ) );
		add_action( 'wp_ajax_nopriv_show_more', array( $this, 'show_more' ) );
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

	/**
	 * Show layout selection dashboard in instructor setting
	 */
	public function tutor_instructor_layout() {
		tutor_load_template( 'instructor-setting', array( 'templates' => $this->instructor_layout ) );
	}

	/**
	 * Filter instructor
	 */
	public function load_filtered_instructor() {
		tutor_utils()->checking_nonce();

		$_post        = tutor_sanitize_data( $_POST );
		$current_page = (int) sanitize_text_field( tutor_utils()->array_get( 'current_page', $_post, 1 ) );
		$keyword      = (string) sanitize_text_field( tutor_utils()->array_get( 'keyword', $_post, '' ) );

		$category = (array) tutor_utils()->array_get( 'category', $_post, array() );
		$category = array_filter(
			$category,
			function( $cat ) {
				return is_numeric( $cat );
			}
		);

		$data = $this->prepare_instructor_list( $current_page, $_post, $category, $keyword );

		ob_start();
		tutor_load_template( 'shortcode.tutor-instructor', $data );
		wp_send_json_success( array( 'html' => ob_get_clean() ) );
		exit;
	}

	/**
	 * Load more categories
	 * handle ajax request
	 *
	 * @package Instructor List
	 * @return string
	 * @since v2.0.0
	 */
	public function show_more() {
		global $wpdb;
		tutor_utils()->checking_nonce();
		$term_id         = isset( $_POST['term_id'] ) ? sanitize_text_field( $_POST['term_id'] ) : 0;
		$limit           = 8;
		$course_taxonomy = 'course-category';

		$remaining_categories = $wpdb->get_var(
			$wpdb->prepare(
				" SElECT COUNT(*) AS total FROM {$wpdb->terms} AS term
					INNER JOIN {$wpdb->term_taxonomy} AS taxonomy
						ON taxonomy.term_id = term.term_id AND taxonomy.taxonomy = %s
				WHERE term.term_id < %d
				ORDER BY term.term_id DESC
			",
				$course_taxonomy,
				$term_id
			)
		);

		$add_categories = $wpdb->get_results(
			$wpdb->prepare(
				" SElECT * FROM {$wpdb->terms} term
					INNER JOIN {$wpdb->term_taxonomy} as taxonomy
						ON taxonomy.term_id = term.term_id AND taxonomy.taxonomy = %s
				WHERE term.term_id < %d
				ORDER BY term.term_id DESC
				LIMIT %d
			",
				$course_taxonomy,
				$term_id,
				$limit
			)
		);
		$show_more      = false;
		if ( $remaining_categories > $limit ) {
			$show_more = true;
		}
		$response = array(
			'categories' => $add_categories,
			'show_more'  => $show_more,
			'remaining'  => $remaining_categories,
		);
		wp_send_json_success( $response );
		exit;
	}
}
