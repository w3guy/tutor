<?php
/**
 * Quiz related API routes
 */

use Tutor\API\QuizApi;

$quizObj = new QuizApi();

// quiz by topic id
register_rest_route(
	$namespace,
	'/quiz/(?P<id>\d+)',
	array(
		'methods'             => 'GET',
		'callback'            => array( $quizObj, 'quiz_with_settings' ),
		'args'                => array( 'id' => array( 'type' => 'number' ) ),
		'permission_callback' => '__return_true',
	)
);

// quiz question answer by quiz id
register_rest_route(
	$namespace,
	'/quiz-question-answer/(?P<id>\d+)',
	array(
		'methods'             => 'GET',
		'callback'            => array( $quizObj, 'quiz_question_ans' ),
		'args'                => array( 'id' => array( 'type' => 'number' ) ),
		'permission_callback' => '__return_true',
	)
);

// quiz attempt details by quiz id
register_rest_route(
	$namespace,
	'/quiz-attempt-details/(?P<id>\d+)',
	array(
		'methods'             => 'GET',
		'callback'            => array( $quizObj, 'quiz_attempt_details' ),
		'args'                => array( 'id' => array( 'type' => 'number' ) ),
		'permission_callback' => '__return_true',
	)
);
