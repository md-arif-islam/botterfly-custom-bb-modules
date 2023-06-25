<?php

$path = preg_replace( '/wp-content.*$/', '', __DIR__ );
require_once( $path . 'wp-load.php' );

if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
	// Get params
	$whats_on_your_mind         = $_POST['whats_on_your_mind'];
	$choose_your_tone          = $_POST['choose_your_tone'];
	$context_corner           = $_POST['context_corner'];
	$add_on_emotion          = $_POST['add_on_emotion'];
	$personal_touch           = $_POST['personal_touch'];
	$personalized_greetings_signoffs         = $_POST['personalized_greetings_signoffs'];
	$letter_content = $_POST['letter_content'];

	// Get the logged-in user's username
	$current_user = wp_get_current_user();
	$username     = $current_user->user_login;

	$params = array(
		'username' => $username,
		'whats_on_your_mind'     => $whats_on_your_mind,
		'choose_your_tone'      => $choose_your_tone,
		'context_corner'       => $context_corner,
		'add_on_emotion'      => $add_on_emotion,
		'personal_touch'       => $personal_touch,
		'personalized_greetings_signoffs'     => $personalized_greetings_signoffs,
	);

	// Query to count existing posts for the given username
	$existing_posts = new WP_Query( array(
		'post_type'      => 'letters',
		'post_status'    => 'publish',
		'meta_query'     => array(
			array(
				'key'     => 'username',
				'value'   => $username,
				'compare' => '=',
			),
		),
		'posts_per_page' => - 1,
	) );

	// Get the count
	$letters_count = $existing_posts->found_posts;


	$letters_arguments = array(
		'post_type'    => 'letters',
		'post_author'  => 1,
		'post_date'    => date( 'Y-m-d H:i:s' ),
		'post_status'  => 'publish',
		'post_title'   => sprintf( '%s - [%s]', $username, $letters_count > 0 ? $letters_count + 1 : '1' ),
		'post_content' => $letter_content,
		'meta_input'   => $params
	);

	$wp_error = '';


	$letters_count = get_transient( 'letters_count' ) ? get_transient( 'letters_count' ) : 0;
	wp_insert_post( $letters_arguments, $wp_error );

	if ( ! $wp_error ) {
		$letters_count ++;
		set_transient( 'letters_count', $letters_count, 0 );
		echo "sucontext_corneress";
	}

}