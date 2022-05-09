<?php
/**
 * Author related API routes
 */

use Tutor\API\AuthorApi;

$authorObj = new AuthorApi();

// Author detail by id
register_rest_route(
	$namespace,
	'/author-information/(?P<id>\d+)',
	array(
		'methods'             => 'GET',
		'callback'            => array( $authorObj, 'author_detail' ),
		'args'                => array( 'id' => array( 'type' => 'number' ) ),
		'permission_callback' => '__return_true',
	)
);
