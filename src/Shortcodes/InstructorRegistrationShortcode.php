<?php
namespace Tutor\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Contracts\ShortcodeContract;

/**
 * Class InstructorRegistrationShortcode
 */
class InstructorRegistrationShortcode implements ShortcodeContract {
	/**
	 * Shortcode tag name
	 *
	 * @var string
	 */
	protected $tag = 'tutor_instructor_registration_form';

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_shortcode( $this->tag, array( $this, 'add' ) );
	}

	/**
	 * Add shortcode
	 *
	 * @param array $atts
	 * @return mixed
	 */
	public function add( $atts ) {
		ob_start();
		if ( is_user_logged_in() ) {
			tutor_load_template( 'dashboard.instructor.logged-in' );
		} else {
			tutor_load_template( 'dashboard.instructor.registration' );
		}
		return apply_filters( 'tutor_dashboard/student/index', ob_get_clean() );
	}
}
