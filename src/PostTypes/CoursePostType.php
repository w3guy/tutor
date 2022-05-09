<?php
namespace Tutor\PostTypes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Contracts\RegisterContract;

/**
 * Class CoursePostType
 */
class CoursePostType implements RegisterContract {
	/**
	 * Post type name
	 *
	 * @var string
	 */
	protected $post_type;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->post_type = tutor()->course_post_type;
		add_action( 'init', array( $this, 'register' ) );

		add_filter( 'gutenberg_can_edit_post_type', array( $this, 'gutenberg_can_edit_post_type' ), 10, 2 );
		add_filter( 'use_block_editor_for_post_type', array( $this, 'gutenberg_can_edit_post_type' ), 10, 2 );
		add_filter( 'post_updated_messages', array( $this, 'course_updated_messages' ) );
	}

	/**
	 * @param $can_edit
	 * @param $post_type
	 *
	 * @return bool
	 *
	 * Enable / Disable Gutenberg Editor
	 * @since v.1.3.4
	 */
	public function gutenberg_can_edit_post_type( $can_edit, $post_type ) {
		$enable_gutenberg = (bool) tutor_utils()->get_option( 'enable_gutenberg_course_edit' );
		return $this->post_type === $post_type ? $enable_gutenberg : $can_edit;
	}

	/**
	 * Register post type
	 *
	 * @return void
	 */
	public function register() {
		$courses_base_slug = apply_filters( 'tutor_courses_base_slug', $this->post_type );

		$labels = array(
			'name'               => _x( 'Courses', 'post type general name', 'tutor' ),
			'singular_name'      => _x( 'Course', 'post type singular name', 'tutor' ),
			'menu_name'          => _x( 'Courses', 'admin menu', 'tutor' ),
			'name_admin_bar'     => _x( 'Course', 'add new on admin bar', 'tutor' ),
			'add_new'            => _x( 'Add New', 'tutor course add', 'tutor' ),
			'add_new_item'       => __( 'Add New Course', 'tutor' ),
			'new_item'           => __( 'New Course', 'tutor' ),
			'edit_item'          => __( 'Edit Course', 'tutor' ),
			'view_item'          => __( 'View Course', 'tutor' ),
			'all_items'          => __( 'Courses', 'tutor' ),
			'search_items'       => __( 'Search Courses', 'tutor' ),
			'parent_item_colon'  => __( 'Parent Courses:', 'tutor' ),
			'not_found'          => __( 'No courses found.', 'tutor' ),
			'not_found_in_trash' => __( 'No courses found in Trash.', 'tutor' ),
		);

		$args = array(
			'labels'             => $labels,
			'description'        => __( 'Description.', 'tutor' ),
			'public'             => true,
			'publicly_queryable' => true,
			'show_in_menu'       => false,
			'query_var'          => true,
			'rewrite'            => array(
				'slug'       => $courses_base_slug,
				'with_front' => false,
			),
			'menu_icon'          => 'dashicons-book-alt',
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'taxonomies'         => array( 'course-category', 'course-tag' ),
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'author' ),
			'show_in_rest'       => true,
			'capabilities'       => array(
				'edit_post'          => 'edit_tutor_course',
				'read_post'          => 'read_tutor_course',
				'delete_post'        => 'delete_tutor_course',
				'delete_posts'       => 'delete_tutor_courses',
				'edit_posts'         => 'edit_tutor_courses',
				'edit_others_posts'  => 'edit_others_tutor_courses',
				'publish_posts'      => 'publish_tutor_courses',
				'read_private_posts' => 'read_private_tutor_courses',
				'create_posts'       => 'edit_tutor_courses',
			),

		);

		register_post_type( $this->post_type, $args );
	}

	function course_updated_messages( $messages ) {
		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$course_post_type = tutor()->course_post_type;

		$messages[ $course_post_type ] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Course updated.', 'tutor' ),
			2  => __( 'Custom field updated.', 'tutor' ),
			3  => __( 'Custom field deleted.', 'tutor' ),
			4  => __( 'Course updated.', 'tutor' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Course restored to revision from %s', 'tutor' ), wp_post_revision_title( (int) tutor_sanitize_data( $_GET['revision'] ), false ) ) : false,
			6  => __( 'Course published.', 'tutor' ),
			7  => __( 'Course saved.', 'tutor' ),
			8  => __( 'Course submitted.', 'tutor' ),
			9  => sprintf(
				__( 'Course scheduled for: <strong>%1$s</strong>.', 'tutor' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', 'tutor' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Course draft updated.', 'tutor' ),
		);

		if ( $post_type_object->publicly_queryable && $course_post_type === $post_type ) {
			$permalink = get_permalink( $post->ID );

			$view_link                  = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View course', 'tutor' ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			$preview_permalink           = add_query_arg( 'preview', 'true', $permalink );
			$preview_link                = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview course', 'tutor' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}

		return $messages;
	}
}
