<?php
namespace Tutor\PostTypes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Contracts\RegisterContract;

/**
 * Class QuizPostType
 */
class QuizPostType implements RegisterContract {
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
		$this->post_type = 'tutor_quiz';
	}

	/**
	 * Register post type
	 *
	 * @return void
	 */
	public function register() {
		$labels = array(
			'name'               => _x( 'Quizzes', 'post type general name', 'tutor' ),
			'singular_name'      => _x( 'Quiz', 'post type singular name', 'tutor' ),
			'menu_name'          => _x( 'Quizzes', 'admin menu', 'tutor' ),
			'name_admin_bar'     => _x( 'Quiz', 'add new on admin bar', 'tutor' ),
			'add_new'            => _x( 'Add New', 'tutor quiz add', 'tutor' ),
			'add_new_item'       => __( 'Add New Quiz', 'tutor' ),
			'new_item'           => __( 'New Quiz', 'tutor' ),
			'edit_item'          => __( 'Edit Quiz', 'tutor' ),
			'view_item'          => __( 'View Quiz', 'tutor' ),
			'all_items'          => __( 'Quizzes', 'tutor' ),
			'search_items'       => __( 'Search Quizzes', 'tutor' ),
			'parent_item_colon'  => __( 'Parent Quizzes:', 'tutor' ),
			'not_found'          => __( 'No quizzes found.', 'tutor' ),
			'not_found_in_trash' => __( 'No quizzes found in Trash.', 'tutor' ),
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
			'exclude_from_search' => apply_filters( 'tutor_quiz_exclude_from_search', true ),
			'capabilities'        => array(
				'edit_post'          => 'edit_tutor_quiz',
				'read_post'          => 'read_tutor_quiz',
				'delete_post'        => 'delete_tutor_quiz',
				'delete_posts'       => 'delete_tutor_quizzes',
				'edit_posts'         => 'edit_tutor_quizzes',
				'edit_others_posts'  => 'edit_others_tutor_quizzes',
				'publish_posts'      => 'publish_tutor_quizzes',
				'read_private_posts' => 'read_private_tutor_quizzes',
				'create_posts'       => 'edit_tutor_quizzes',
			),
		);

		register_post_type( $this->post_type, $args );
	}
}
