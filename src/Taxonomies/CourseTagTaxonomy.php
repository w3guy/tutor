<?php
namespace Tutor\Taxonomies;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Contracts\RegisterContract;

/**
 * Class CourseTagTaxonomy
 */
class CourseTagTaxonomy implements RegisterContract {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register
	 *
	 * @return void
	 */
	public function register() {
		$labels = array(
			'name'                       => _x( 'Tags', 'taxonomy general name', 'tutor' ),
			'singular_name'              => _x( 'Tag', 'taxonomy singular name', 'tutor' ),
			'search_items'               => __( 'Search Tags', 'tutor' ),
			'popular_items'              => __( 'Popular Tags', 'tutor' ),
			'all_items'                  => __( 'All Tags', 'tutor' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Tag', 'tutor' ),
			'update_item'                => __( 'Update Tag', 'tutor' ),
			'add_new_item'               => __( 'Add New Tag', 'tutor' ),
			'new_item_name'              => __( 'New Tag Name', 'tutor' ),
			'separate_items_with_commas' => __( 'Separate Tags with commas', 'tutor' ),
			'add_or_remove_items'        => __( 'Add or remove Tags', 'tutor' ),
			'choose_from_most_used'      => __( 'Choose from the most used Tags', 'tutor' ),
			'not_found'                  => __( 'No Tags found.', 'tutor' ),
			'menu_name'                  => __( 'Tags', 'tutor' ),
		);

		$args = array(
			'hierarchical'          => false,
			'labels'                => $labels,
			'show_ui'               => true,
			'show_admin_column'     => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var'             => true,
			'show_in_rest'          => true,
			'rewrite'               => array( 'slug' => 'course-tag' ),
		);

		register_taxonomy( 'course-tag', tutor()->course_post_type, $args );
	}
}
