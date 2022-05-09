<?php
/**
 * Topic related API routes
 */

use Tutor\API\TopicApi;

$topicObj = new TopicApi();

// Course topic
register_rest_route(
	$namespace,
	'/course-topic/(?P<id>\d+)',
	array(
		'methods'             => 'GET',
		'callback'            => array( $topicObj, 'course_topic' ),
		'args'                => array( 'id' => array( 'type' => 'number' ) ),
		'permission_callback' => '__return_true',
	)
);
