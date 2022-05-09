<?php
namespace Tutor\API;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use WP_REST_Request;
use Tutor\Core\Input;
use Tutor\Core\Traits\ApiResponse;

 /**
  * Class CourseApi
  *
  * @author: themeum
  * @link: https://themeum.com
  * @package tutor
  */
class CourseApi {
	use ApiResponse;

	/**
	 * Post Type
	 *
	 * @var string
	 */
	private $post_type;

	/**
	 * Course Category taxonomy name
	 *
	 * @var string
	 */
	private $course_cat_tax = 'course-category';

	/**
	 * Course tag name
	 *
	 * @var string
	 */
	private $course_tag_tax = 'course-tag';

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->post_type = tutor()->course_post_type;
	}

	/**
	 * Get course info
	 *
	 * @return mixed
	 */
	public function course() {
		$order   = Input::get( 'order', 'ASC' );
		$orderby = Input::get( 'orderby', 'title' );
		$paged   = Input::get( 'paged', 1 );

		$args = array(
			'post_type'      => $this->post_type,
			'post_status'    => 'publish',
			'posts_per_page' => 10,
			'paged'          => $paged,
			'order'          => $order,
			'orderby'        => $orderby,
		);

		$query = new \WP_Query( $args );

		if ( count( $query->posts ) > 0 ) {
			// Unset filter properpty.
			array_map(
				function( $post ) {
					unset( $post->filter );
				},
				$query->posts
			);

			$data = array(
				'posts'        => array(),
				'total_course' => $query->found_posts,
				'total_page'   => $query->max_num_pages,
			);

			foreach ( $query->posts as $post ) {
				$category = wp_get_post_terms( $post->ID, $this->course_cat_tax );

				$tag                   = wp_get_post_terms( $post->ID, $this->course_tag_tax );
				$post->course_category = $category;
				$post->course_tag      = $tag;

				array_push( $data['posts'], $post );
			}

			return $this->api_data( $data );
		}

		return $this->api_fail( __( 'Course not found', 'tutor' ) );
	}

	/**
	 * Get course details by ID
	 *
	 * @return mixed
	 */
	public function course_detail() {
		$post_id = Input::get( 'id', 0, Input::TYPE_INT );

		$detail = array(

			'course_settings'          => get_post_meta( $post_id, '_tutor_course_settings', false ),

			'course_price_type'        => get_post_meta( $post_id, '_tutor_course_price_type', false ),

			'course_duration'          => get_post_meta( $post_id, '_course_duration', false ),

			'course_level'             => get_post_meta( $post_id, '_tutor_course_level', false ),

			'course_benefits'          => get_post_meta( $post_id, '_tutor_course_benefits', false ),

			'course_requirements'      => get_post_meta( $post_id, '_tutor_course_requirements', false ),

			'course_target_audience'   => get_post_meta( $post_id, '_tutor_course_target_audience', false ),

			'course_material_includes' => get_post_meta( $post_id, '_tutor_course_material_includes', false ),

			'video'                    => get_post_meta( $post_id, '_video', false ),

			'disable_qa'               => get_post_meta( $post_id, '_tutor_enable_qa', true ) !== 'yes',
		);

		if ( $detail ) {
			return $this->api_data( $detail );
		}

		return $this->api_fail( __( 'Detail not found for given ID', 'tutor' ) );
	}

	/**
	 * Get course data by terms
	 *
	 * @param WP_REST_Request $request request.
	 * @return mixed
	 */
	public function course_by_terms( WP_REST_Request $request ) {
		$post_fields  = $request->get_params();
		$validate_err = $this->validate_terms( $post_fields );

		if ( count( $validate_err ) > 0 ) {
			return $this->api_fail( $validate_err );
		}

		// Sanitize terms.
		$categories = sanitize_term( $request['categories'], $this->course_cat_tax, $context = 'db' );
		$tags       = sanitize_term( $request['tags'], $this->course_tag_tax, $context = 'db' );

		$args = array(
			'post_type' => $this->post_type,
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => $this->course_cat_tax,
					'field'    => 'name',
					'terms'    => $categories,
				),
				array(
					'taxonomy' => $this->course_tag_tax,
					'field'    => 'name',
					'terms'    => $tags,
				),
			),
		);

		$query = new \WP_Query( $args );

		if ( count( $query->posts ) > 0 ) {
			array_map(
				function( $post ) {
					unset( $post->filter );
				},
				$query->posts
			);

			return $this->api_data( $query->posts );
		}

		return $this->api_fail( __( 'Course not found for given terms', 'tutor' ) );
	}

	/**
	 * Validate terms
	 *
	 * @param array $post Post request.
	 * @return array
	 */
	public function validate_terms( array $post ) {
		$categories = $post['categories'];
		$tags       = $post['tags'];

		$error = array();

		if ( ! is_array( $categories ) ) {
			array_push( $error, __( 'Categories field is not an array', 'tutor' ) );
		}

		if ( ! is_array( $tags ) ) {
			array_push( $error, __( 'Tags field is not an array', 'tutor' ) );
		}

		return $error;
	}

	/**
	 * Sort course by price
	 *
	 * @return mixed
	 */
	public function course_sort_by_price() {
		$order = Input::get( 'order', 'ASC' );
		$paged = Input::get( 'page', 1, Input::TYPE_INT );

		$args = array(
			'post_type'      => 'product',
			'post_status'    => 'publish',
			'posts_per_page' => 10,
			'paged'          => $paged,

			'meta_key'       => '_regular_price',
			'orderby'        => 'meta_value_num',
			'order'          => $order,
			'meta_query'     => array(
				'relation' => 'AND',
				array(
					'key'   => '_tutor_product',
					'value' => 'yes',
				),
			),
		);

		$query = new \WP_Query( $args );

		if ( count( $query->posts ) > 0 ) {
			// Unset filter property.
			array_map(
				function( $post ) {
					unset( $post->filter );
				},
				$query->posts
			);

			$posts = array();

			foreach ( $query->posts as $post ) {
				$post->price = get_post_meta( $post->ID, '_regular_price', true );
				array_push( $posts, $post );
			}

			$data = array(
				'posts'        => $posts,
				'total_course' => $query->found_posts,
				'total_page'   => $query->max_num_pages,
			);

			return $this->api_data( $data );
		}

		return $this->api_fail( __( 'Course not found', 'tutor' ) );
	}
}
