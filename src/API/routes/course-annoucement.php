<?php
/**
 * Announcement related API routes
 */

use Tutor\API\AnnouncementApi;

$annoucementObj = new AnnouncementApi();

// Get course announcement by course ID.
register_rest_route(
	$namespace,
	'/course-annoucement/(?P<id>\d+)',
	array(
		'methods'             => 'GET',
		'callback'            => array( $annoucementObj, 'course_annoucement' ),
		'args'                => array( 'id' => array( 'type' => 'number' ) ),
		'permission_callback' => '__return_true',
	)
);
