<?php

if( isset( $_REQUEST[ 'Submit' ] ) ) {
	// Get and validate input
	$raw_id = $_REQUEST[ 'id' ] ?? '';

	if( filter_var( $raw_id, FILTER_VALIDATE_INT ) === false ) {
		$html .= "<pre>Invalid user ID.</pre>";
	} else {
		$id = (int)$raw_id;

		switch ($_DVWA['SQLI_DB']) {
			case MYSQL:
				// Use a prepared statement to prevent SQL injection
				$stmt = mysqli_prepare(
					$GLOBALS["___mysqli_ston"],
					"SELECT first_name, last_name FROM users WHERE user_id = ?"
				);

				if( $stmt === false ) {
					$html .= "<pre>Database query preparation failed.</pre>";
					break;
				}

				mysqli_stmt_bind_param( $stmt, "i", $id );
				mysqli_stmt_execute( $stmt );
				mysqli_stmt_bind_result( $stmt, $first, $last );

				// Get results
				while( mysqli_stmt_fetch( $stmt ) ) {
					// Feedback for end user
					$html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
				}

				mysqli_stmt_close( $stmt );
				mysqli_close( $GLOBALS["___mysqli_ston"] );
				break;

			case SQLITE:
				global $sqlite_db_connection;

				// Use a prepared statement to prevent SQL injection
				$stmt = $sqlite_db_connection->prepare(
					"SELECT first_name, last_name FROM users WHERE user_id = :id"
				);

				$stmt->bindValue( ':id', $id, SQLITE3_INTEGER );
				$results = $stmt->execute();

				if ($results) {
					while ($row = $results->fetchArray()) {
						$first = $row["first_name"];
						$last  = $row["last_name"];

						// Feedback for end user
						$html .= "<pre>ID: {$id}<br />First name: {$first}<br />Surname: {$last}</pre>";
					}
				} else {
					$html .= "<pre>Database query failed.</pre>";
				}

				$stmt->close();
				break;
		}
	}
}

?>
