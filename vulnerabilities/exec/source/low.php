<?php

if( isset( $_POST[ 'Submit' ]  ) ) {
	// Get input
	$target = $_REQUEST[ 'ip' ] ?? '';

	// Validate the target as an IPv4 address or hostname.
	if( filter_var( $target, FILTER_VALIDATE_IP ) === false &&
		!preg_match( '/^(?=.{1,253}$)[A-Za-z0-9](?:[A-Za-z0-9.-]*[A-Za-z0-9])?$/', $target ) ) {
		$html .= "<pre>Invalid target.</pre>";
	}
	else {
		// Determine OS and execute the ping command safely.
		$safe_target = escapeshellarg( $target );

		if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
			// Windows
			$cmd = shell_exec( 'ping ' . $safe_target );
		}
		else {
			// *nix
			$cmd = shell_exec( 'ping -c 4 ' . $safe_target );
		}

		// Feedback for the end user
		$html .= "<pre>" . htmlspecialchars( $cmd, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8' ) . "</pre>";
	}
}

?>
