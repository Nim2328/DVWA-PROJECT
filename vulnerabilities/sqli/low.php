<?php

if( isset( $_REQUEST[ 'Submit' ] ) ) {
    // Get input
    $id = $_REQUEST[ 'id' ];

    // Check database securely using Prepared Statements
    $stmt = mysqli_prepare($GLOBALS["___mysqli_ston"], "SELECT first_name, last_name FROM users WHERE user_id = ?;");
    
    if ($stmt) {
        // Bind input parameter ($id)
        mysqli_stmt_bind_param($stmt, "s", $id);
        
        // Execute the query safely
        mysqli_stmt_execute($stmt);
        
        // Bind result variables
        mysqli_stmt_bind_result($stmt, $first, $last);
        
        // Fetch records
        while( mysqli_stmt_fetch($stmt) ) {
            $html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
        }
        
        mysqli_stmt_close($stmt);
    }

    mysqli_close($GLOBALS["___mysqli_ston"]);
}

?>
