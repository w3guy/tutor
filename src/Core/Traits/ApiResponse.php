<?php

namespace Tutor\Core\Traits;

/**
 * API response trait
 *
 * @since 1.0.0
 */
trait ApiResponse {
	/**
	 * API success response
	 *
	 * @param string $message success message.
	 * @return void
	 */
	public function api_success( $message ) {
		wp_send_json(
			array(
				'success' => true,
				'message' => $message,
			),
			200
		);
	}

	/**
	 * API fail response
	 *
	 * @param string $message fail message.
	 * @return void
	 */
	public function api_fail( $message ) {
		wp_send_json(
			array(
				'success' => false,
				'message' => $message,
			),
			200
		);
	}

	/**
	 * API data response
	 *
	 * @param string $data response data.
	 * @return void
	 */
	public function api_data( $data ) {
		wp_send_json(
			array(
				'success' => true,
				'data'    => $data,
			),
			200
		);
	}
}
