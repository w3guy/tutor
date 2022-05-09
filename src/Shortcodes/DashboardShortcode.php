<?php
namespace Tutor\Shortcodes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Tutor\Core\Contracts\ShortcodeContract;

/**
 * Class DashboardShortcode
 */
class DashboardShortcode implements ShortcodeContract {
	/**
	 * Shortcode tag name
	 *
	 * @var string
	 */
	protected $tag = 'tutor_dashboard';

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
		global $wp_query;

		ob_start();
		if ( is_user_logged_in() ) {
			/**
			 * Added isset() Condition to avoid infinite loop since v.1.5.4
			 * This has cause error by others plugin, Such AS SEO
			 */

			if ( ! isset( $wp_query->query_vars['tutor_dashboard_page'] ) ) {
				tutor_load_template( 'dashboard', array( 'is_shortcode' => true ) );
			}
		} else {
			$login_url = tutor_utils()->get_option( 'enable_tutor_native_login', null, true, true ) ? '' : wp_login_url( tutor()->current_url );
			echo sprintf( __( 'Please %1$sSign-In%2$s to view this page', 'tutor' ), '<a data-login_url="' . $login_url . '" href="#" class="tutor-open-login-modal">', '</a>' );
		}
		return apply_filters( 'tutor_dashboard/index', ob_get_clean() );
	}
}
