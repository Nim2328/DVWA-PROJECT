<?php

if( isset( $_POST[ 'Submit' ] ) ) {

    // Get input
    $target = $_REQUEST[ 'ip' ]??'';

    // Allow only a valid IPv4 address
    if( filter_var( $target, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {

        // Determine OS and execute the ping command
        if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
            // Windows
            $cmd = shell_exec( 'ping -n 4 ' . escapeshellarg( $target ) );
        }
        else {
            // Linux/Unix
            $cmd = shell_exec( 'ping -c 4 ' . escapeshellarg( $target ) );
        }

        // Feedback for the end user
        $html .= "<pre>{$cmd}</pre>";
    }
    else {
        $html .= "<pre>Invalid IP address.</pre>";
    }
}

?>
