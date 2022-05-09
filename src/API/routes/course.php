<?php
/**
 * Course Related API routes
 */

use Tutor\API\CourseApi;
use Tutor\Validations\Validator;

$courseObj = new CourseApi();

// Courses
register_rest_route(
	$namespace,
	'/courses',
	array(
		'methods'             => 'GET',
		'callback'            => array( $courseObj, 'course' ),
		'permission_callback' => '__return_true',
	)
);

// Courses by terms cat and tag.
register_rest_route(
	$namespace,
	'/course-by-terms',
	array(
		'methods'             => 'POST',
		'callback'            => array( $courseObj, 'course_by_terms' ),
		'permission_callback' => '__return_true',
	)
);

// Courses by terms cat and tag.
register_rest_route(
	$namespace,
	'/course-sorting-by-price',
	array(
		'methods'             => 'GET',
		'callback'            => array( $courseObj, 'course_sort_by_price' ),
		'args'                => array(
			'order' => array(
				'required'          => true,
				'type'              => 'string',
				'validate_callback' => function( $order ) {
					return Validator::is_valid_order( $order );
				},
			),
			'page'  => array(
				'required' => false,
				'type'     => 'number',
			),
		),
		'permission_callback' => '__return_true',
	)
);

// Course details.
register_rest_route(
	$namespace,
	'/course-detail/(?P<id>\d+)',
	array(
		'methods'             => 'GET',
		'callback'            => array( $courseObj, 'course_detail' ),
		'args'                => array( 'id' => array( 'type' => 'number' ) ),
		'permission_callback' => '__return_true',
	)
);
