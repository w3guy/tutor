<?php
/**
 * Handle user cache data
 *
 * @package  Tutor\Cache
 *
 * @author   Themeum
 *
 * @since    v2.0.6
 */

namespace Tutor\Cache;

use Tutor\Cache\AbstractCache;

if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * User data caching
 * Get Set & check
 *
 * @package  PluginStarter\Cache
 *
 * @author   Shewa <shewa12kpi@gmail.com>
 *
 * @since    v2.0.6
 */
class QuizAttempts extends AbstractCache {

	/**
	 * Key for cache identifier
	 *
	 * @var string
	 *
	 * @since v2.0.6
	 */
	private const KEY = 'tutor_quiz_attempts_count';

	/**
	 * Cache expire time
	 *
	 * @var string
	 *
	 * @since v2.0.6
	 */
	private const HOUR_IN_SECONDS = 3600;

	/**
	 * Data for caching
	 *
	 * @var string
	 *
	 * @since v2.0.6
	 */
	public $data;

	/**
	 * Key
	 *
	 * @return string
	 */
	public function key(): string {
		return self::KEY;
	}

	/**
	 * Cache data
	 *
	 * @return object
	 */
	public function cache_data() {
		return $this->data;
	}

	/**
	 * Cache time
	 *
	 * @return int
	 */
	public function cache_time(): int {
		$cache_time = self::HOUR_IN_SECONDS;
		return $cache_time;
	}
}