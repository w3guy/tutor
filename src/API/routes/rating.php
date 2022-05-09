<?php
/**
 * Rating related API routes
 */

use Tutor\API\RatingApi;

$ratingObj = new RatingApi();

// Reviews by course id
register_rest_route(
	$namespace,
	'/course-rating/(?P<id>\d+)',
	array(
		'methods'             => 'GET',
		'callback'            => array( $ratingObj, 'course_rating' ),
		'args'                => array( 'id' => array( 'type' => 'number' ) ),
		'permission_callback' => '__return_true',
	)
);
