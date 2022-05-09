<?php
namespace Tutor\PostTypes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Contracts\RegisterContract;

/**
 * Class LessonPostType
 */
class LessonPostType implements RegisterContract {
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
		$this->post_type = tutor()->lesson_post_type;
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register post type
	 *
	 * @return void
	 */
	public function register() {
		$lesson_base_slug = apply_filters( 'tutor_lesson_base_slug', $this->post_type );

		$labels = array(
			'name'               => _x( 'Lessons', 'post type general name', 'tutor' ),
			'singular_name'      => _x( 'Lesson', 'post type singular name', 'tutor' ),
			'menu_name'          => _x( 'Lessons', 'admin menu', 'tutor' ),
			'name_admin_bar'     => _x( 'Lesson', 'add new on admin bar', 'tutor' ),
			'add_new'            => _x( 'Add New', 'tutor lesson add', 'tutor' ),
			'add_new_item'       => __( 'Add New Lesson', 'tutor' ),
			'new_item'           => __( 'New Lesson', 'tutor' ),
			'edit_item'          => __( 'Edit Lesson', 'tutor' ),
			'view_item'          => __( 'View Lesson', 'tutor' ),
			'all_items'          => __( 'Lessons', 'tutor' ),
			'search_items'       => __( 'Search Lessons', 'tutor' ),
			'parent_item_colon'  => __( 'Parent Lessons:', 'tutor' ),
			'not_found'          => __( 'No lessons found.', 'tutor' ),
			'not_found_in_trash' => __( 'No lessons found in Trash.', 'tutor' ),
		);

		$args = array(
			'labels'              => $labels,
			'description'         => __( 'Description.', 'tutor' ),
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => false,
			'query_var'           => true,
			'rewrite'             => array( 'slug' => $lesson_base_slug ),
			'menu_icon'           => 'dashicons-list-view',
			'capability_type'     => 'post',
			'has_archive'         => true,
			'hierarchical'        => false,
			'menu_position'       => null,
			'supports'            => array( 'title', 'editor', 'comments' ),
			'exclude_from_search' => apply_filters( 'tutor_lesson_exclude_from_search', true ),
			'capabilities'        => array(
				'edit_post'          => 'edit_tutor_lesson',
				'read_post'          => 'read_tutor_lesson',
				'delete_post'        => 'delete_tutor_lesson',
				'delete_posts'       => 'delete_tutor_lessons',
				'edit_posts'         => 'edit_tutor_lessons',
				'edit_others_posts'  => 'edit_others_tutor_lessons',
				'publish_posts'      => 'publish_tutor_lessons',
				'read_private_posts' => 'read_private_tutor_lessons',
				'create_posts'       => 'edit_tutor_lessons',
			),
		);

		register_post_type( $this->post_type, $args );
	}
}
