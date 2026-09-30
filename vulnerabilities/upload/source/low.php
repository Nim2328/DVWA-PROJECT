<?php

if( isset( $_POST[ 'Upload' ] ) ) {
	// Where are we going to be writing to?
	$upload_dir = DVWA_WEB_PAGE_TO_ROOT . "hackable/uploads/";

	// Validate that a file was uploaded successfully.
	if( !isset( $_FILES[ 'uploaded' ] ) ||
		$_FILES[ 'uploaded' ][ 'error' ] !== UPLOAD_ERR_OK ) {
		$html .= '<pre>File upload failed.</pre>';
	}
	else {
		$original_name = $_FILES[ 'uploaded' ][ 'name' ];
		$tmp_name      = $_FILES[ 'uploaded' ][ 'tmp_name' ];
		$file_size     = $_FILES[ 'uploaded' ][ 'size' ];

		// Restrict file size.
		$max_size = 2 * 1024 * 1024;

		// Allow only safe image extensions.
		$allowed_extensions = array( 'jpg', 'jpeg', 'png', 'gif' );
		$extension = strtolower( pathinfo( $original_name, PATHINFO_EXTENSION ) );

		// Validate the actual MIME type of the uploaded file.
		$finfo = new finfo( FILEINFO_MIME_TYPE );
		$mime_type = $finfo->file( $tmp_name );

		$allowed_mime_types = array(
			'jpg'  => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png'  => 'image/png',
			'gif'  => 'image/gif'
		);

		if( $file_size > $max_size ) {
			$html .= '<pre>File is too large.</pre>';
		}
		elseif( !array_key_exists( $extension, $allowed_mime_types ) ||
			$allowed_mime_types[ $extension ] !== $mime_type ) {
			$html .= '<pre>Invalid file type. Only JPG, JPEG, PNG and GIF images are allowed.</pre>';
		}
		else {
			// Generate a safe server-side filename.
			$safe_name = bin2hex( random_bytes( 16 ) ) . '.' . $extension;
			$target_path = $upload_dir . $safe_name;

			// Store only validated files.
			if( !move_uploaded_file( $tmp_name, $target_path ) ) {
				$html .= '<pre>Your image was not uploaded.</pre>';
			}
			else {
				$html .= '<pre>Image successfully uploaded.</pre>';
			}
		}
	}
}

?>
