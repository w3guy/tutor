<?php
namespace Tutor\API;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class ApiManager
 *
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */
class ApiManager {

	/**
	 * API namespace
	 * Base endpint: example.com/wp-json/tutor/v1
	 *
	 * @var string
	 */
	private $namespace = 'tutor/v1';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'routes' ) );
	}

	/**
	 * Define routes
	 *
	 * @return void
	 */
	public function routes() {
		$namespace = $this->namespace;
		include_once 'routes/course.php';
		include_once 'routes/lesson.php';
		include_once 'routes/topic.php';
		include_once 'routes/course-annoucement.php';
		include_once 'routes/quiz.php';
		include_once 'routes/author.php';
		include_once 'routes/rating.php';
	}
}
