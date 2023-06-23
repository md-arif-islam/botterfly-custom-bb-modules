<?php
<<<<<<< HEAD
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
=======

@ini_set( 'zlib.output_compression', 0 );
@ini_set( 'implicit_flush', 1 );
@ob_end_clean();

header( 'Content-Type: text/event-stream' );
header( 'Cache-Control: no-cache' );
header( 'Content-Encoding: none' );

// Get all parameters
$wadValue           = checkParam( 'wadValue' );
$aoeResolutionValue = checkParam( 'aoeResolutionValue' );
$aoeSamplesValue    = checkParam( 'aoeSamplesValue' );
$woumValue          = checkParam( 'woumValue' );

// Create an array to hold the parameter values
$data = array(
	'wadValue'           => $wadValue,
	'aoeResolutionValue' => $aoeResolutionValue,
	'aoeSamplesValue'    => $aoeSamplesValue,
	'woumValue'          => $woumValue
);

// Check if all parameters are present
if ( empty( $wadValue ) || empty( $aoeResolutionValue ) || empty( $aoeSamplesValue ) || empty( $woumValue ) ) {
	// Some parameters are missing
	$errorData = array(
		'error' => 'One or more parameters are missing.'
	);
	echo "data: " . json_encode( $errorData ) . "\n\n";
} else {
	// All parameters are present
	$jsonData = json_encode( $data );
	echo "data: " . $jsonData . "\n\n";
}


>>>>>>> 6b59724ec650233050a78c1fd30abd2433afb0e5
