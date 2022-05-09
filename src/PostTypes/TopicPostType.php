<?php
namespace Tutor\PostTypes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Contracts\RegisterContract;

/**
 * Class TopicPostType
 */
class TopicPostType implements RegisterContract {
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
		$this->post_type = 'topics';
	}


	/**
	 * Register post type
	 *
	 * @return void
	 */
	public function register() {
		$args = array(
			'label'              => 'Topics',
			'description'        => __( 'Description.', 'tutor' ),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => false,
			'query_var'          => false,
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
		);
		register_post_type( $this->post_type, $args );
	}
}
