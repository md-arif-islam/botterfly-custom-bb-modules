<?php

$path = preg_replace('/wp-content.*$/', '', __DIR__);
require_once($path . 'wp-load.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Get params
	$amfWad = $_POST['amfWad'];
	$amfNof = $_POST['amfNof'];

	$current_user = wp_get_current_user();
	$username = $current_user->user_login;

	$amfImageFile = $_FILES['amfImageFile'];
	$image_file_path = '';

	// Handle the uploaded file
	if (!empty($amfImageFile['tmp_name'])) {
		$upload_dir = wp_upload_dir(); // Get the upload directory
		$file_name = sanitize_file_name($username . '-' . time() . '-' . strtolower(str_replace(' ', '-', $amfImageFile['name'])));
		$file_path = $upload_dir['path'] . '/' . $file_name;

		// Move the file to the upload directory
		if (move_uploaded_file($amfImageFile['tmp_name'], $file_path)) {
			$image_file_path = $upload_dir['url'] . '/' . $file_name; // Set the file path for metadata
		}
	}

	// Create an array with all params
	$params = array(
		'username' => $username,
		'amfWad' => $amfWad,
		'amfNof' => $amfNof,
		'amfImageFile' => $image_file_path, // Include the image file path as metadata
	);

	$art_req_arguments = array(
		'post_type' => 'art_request',
		'post_author' => 1,
		'post_date' => date('Y-m-d H:i:s'),
		'post_status' => 'pending',
		'post_title' => sprintf('Modify Request from - %s ', $username),
		'meta_input' => $params,
	);

	$wp_error = '';

	// Transient check
	$art_req_count = get_transient('art_req_count') ? get_transient('art_req_count') : 0;
	wp_insert_post($art_req_arguments, $wp_error);

	if (!$wp_error) {
		$art_req_count++;
		set_transient('art_req_count', $art_req_count, 0);

		echo "success";
	}
}
