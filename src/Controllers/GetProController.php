<?php
namespace Tutor\Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class GetProController
 * 
 * @author: themeum
 * @link: https://themeum.com
 * @package tutor
 */
class GetProController {
	/**
	 * Get pro page
	 *
	 * @return void
	 */
	public function show_get_pro_page() {
		include tutor()->path . 'views/pages/get-pro.php';
	}
}
