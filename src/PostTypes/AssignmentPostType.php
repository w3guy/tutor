<?php
namespace Tutor\PostTypes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Contracts\RegisterContract;

/**
 * Class AssignmentPostType
 */
class AssignmentPostType implements RegisterContract {
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
		$this->post_type = 'tutor_assignments';
	}

	/**
	 * Register post type
	 *
	 * @return void
	 */
	public function register() {
		$labels = array(
			'name'               => _x( 'Assignments', 'post type general name', 'tutor' ),
			'singular_name'      => _x( 'Assignment', 'post type singular name', 'tutor' ),
			'menu_name'          => _x( 'Assignments', 'admin menu', 'tutor' ),
			'name_admin_bar'     => _x( 'Assignment', 'add new on admin bar', 'tutor' ),
			'add_new'            => _x( 'Add New', 'tutor assignment add', 'tutor' ),
			'add_new_item'       => __( 'Add New Assignment', 'tutor' ),
			'new_item'           => __( 'New Assignment', 'tutor' ),
			'edit_item'          => __( 'Edit Assignment', 'tutor' ),
			'view_item'          => __( 'View Assignment', 'tutor' ),
			'all_items'          => __( 'Assignments', 'tutor' ),
			'search_items'       => __( 'Search Assignments', 'tutor' ),
			'parent_item_colon'  => __( 'Parent Assignments:', 'tutor' ),
			'not_found'          => __( 'No Assignments found.', 'tutor' ),
			'not_found_in_trash' => __( 'No Assignments found in Trash.', 'tutor' ),
		);

		$args = array(
			'labels'              => $labels,
			'description'         => __( 'Description.', 'tutor' ),
			'public'              => true,
			'publicly_queryable'  => true,
			'show_ui'             => false,
			'show_in_menu'        => 'tutor',
			'query_var'           => true,
			'rewrite'             => array( 'slug' => $this->lesson_post_type ),
			'menu_icon'           => 'dashicons-editor-help',
			'capability_type'     => 'post',
			'has_archive'         => true,
			'hierarchical'        => false,
			'menu_position'       => null,
			'supports'            => array( 'title', 'editor' ),
			'exclude_from_search' => apply_filters( 'tutor_assignment_exclude_from_search', true ),
			'capabilities'        => array(
				'edit_post'          => 'edit_tutor_assignment',
				'read_post'          => 'read_tutor_assignment',
				'delete_post'        => 'delete_tutor_assignment',
				'delete_posts'       => 'delete_tutor_assignments',
				'edit_posts'         => 'edit_tutor_assignments',
				'edit_others_posts'  => 'edit_others_tutor_assignments',
				'publish_posts'      => 'publish_tutor_assignments',
				'read_private_posts' => 'read_private_tutor_assignments',
				'create_posts'       => 'edit_tutor_assignments',
			),
		);

		register_post_type( $this->post_type, $args );
	}
}
