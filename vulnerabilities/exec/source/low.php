<?php

if( isset( $_POST[ 'Submit' ]  ) ) {
    // Get input
    $target = trim($_REQUEST[ 'ip' ]);

    // Validate strictly as an IPv4 / IPv6 address or standard hostname
    if( filter_var( $target, FILTER_VALIDATE_IP ) || preg_match( '/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$/', $target ) ) {
        // Safe escaping to satisfy static analysis and prevent injection
        $safe_target = escapeshellarg( $target );

        // Determine OS and execute
        if( stristr( php_uname( 's' ), 'Windows NT' ) ) {
            $cmd = shell_exec( 'ping ' . $safe_target );
        } else {
            $cmd = shell_exec( 'ping -c 4 ' . $safe_target );
        }

        echo "<pre>{$cmd}</pre>";
    } else {
        echo '<pre>Invalid target.</pre>';
    }
}

?>
