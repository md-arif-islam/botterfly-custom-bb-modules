<?php
if ( $_SERVER["REQUEST_METHOD"] == "POST" ) {
	// Get params
	$acfWad        = $_POST['acfWad'];
	$acfResolution = $_POST['acfResolution'];
	$acfSamples    = $_POST['acfSamples'];
	$acfWoum       = $_POST['acfWoum'];

	// Create an array with all params
	$params = array(
		'acfWad'        => $acfWad,
		'acfResolution' => $acfResolution,
		'acfSamples'    => $acfSamples,
		'acfWoum'       => $acfWoum
	);

	// Accessing individual params
	print_r( $params );
}
?>
