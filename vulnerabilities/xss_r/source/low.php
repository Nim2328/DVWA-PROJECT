<?php

header ("X-XSS-Protection: 0");

// Is there any input?
if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
	// Safely encode user input before displaying it
	$name = htmlspecialchars( $_GET[ 'name' ], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' );

	// Feedback for end user
	$html .= '<pre>Hello ' . $name . '</pre>';
}

?>
