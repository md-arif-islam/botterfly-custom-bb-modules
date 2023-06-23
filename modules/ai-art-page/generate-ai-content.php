<?php

$path = preg_replace( '/wp-content.*$/', '', __DIR__ );
require_once( $path . 'wp-load.php' );

if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
	// Get params
	$acfWad        = $_POST['acfWad'];
	$acfResolution = $_POST['acfResolution'];
	$acfSamples    = $_POST['acfSamples'];
	$acfWoum       = $_POST['acfWoum'];

	// Get the logged-in user's username
	$current_user = wp_get_current_user();
	$username     = $current_user->user_login;

	// Create an array with all params
	$params = array(
		'username'      => $username,
		'acfWad'        => $acfWad,
		'acfResolution' => $acfResolution,
		'acfSamples'    => $acfSamples,
		'acfWoum'       => $acfWoum
	);

	$art_req_arguments = array(
		'post_type'   => 'art_request',
		'post_author' => 1,
		'post_date'   => date( 'Y-m-d H:i:s' ),
		'post_status' => 'publish',
		'post_title'  => sprintf( 'New Request from - %s ', $username ),
		'meta_input'  => $params
	);

	$wp_error = '';
	wp_insert_post( $art_req_arguments, $wp_error );
	if ( ! $wp_error ) {
		echo "Successful";
	}
}
