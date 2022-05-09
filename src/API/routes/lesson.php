<?php
/**
 * Lesson related API routes
 */

use Tutor\API\LessonApi;

$lessonObj = new LessonApi();

// Lesson by topic
register_rest_route(
	$namespace,
	'/lesson/(?P<id>\d+)',
	array(
		'methods'             => 'GET',
		'callback'            => array( $lessonObj, 'topic_lesson' ),
		'args'                => array( 'id' => array( 'type' => 'number' ) ),
		'permission_callback' => '__return_true',
	)
);
