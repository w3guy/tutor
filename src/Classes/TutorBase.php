<?php
namespace Tutor\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class TutorBase
 * 
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */
class TutorBase {
	public $course_post_type;
	public $lesson_post_type;

	public $lesson_base_permalink;

	public function __construct() {
		$this->course_post_type = tutor()->course_post_type;
		$this->lesson_post_type = tutor()->lesson_post_type;

		// Lesson Permalink
		$this->lesson_base_permalink = tutor_utils()->get_option( 'lesson_permalink_base' );
		if ( ! $this->lesson_base_permalink ) {
			$this->lesson_base_permalink = $this->lesson_post_type;
		}
	}
}
