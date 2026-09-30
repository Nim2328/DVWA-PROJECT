<?php

if( isset( $_POST[ 'Upload' ] ) ) {
    $upload_dir = DVWA_WEB_PAGE_TO_ROOT . "hackable/uploads/";
    $file = $_FILES[ 'uploaded' ];

    // 1. Verify upload status
    if( $file['error'] !== UPLOAD_ERR_OK ) {
        echo '<pre>Upload error occurred.</pre>';
        return;
    }

    // 2. Enforce 2MB size limit
    if( $file['size'] > 2097152 ) {
        echo '<pre>File exceeds the maximum 2MB size limit.</pre>';
        return;
    }

    // 3. Strict extension whitelist check (Matches Figure 10)
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if( !in_array($extension, $allowed_extensions, true) ) {
        echo '<pre>Invalid file type. Only JPG, JPEG, PNG and GIF images are allowed.</pre>';
        return;
    }

    // 4. Server-side MIME & Magic Byte inspection
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);
    $allowed_mimes = ['image/jpeg', 'image/png', 'image/gif'];

    if( !in_array($mime_type, $allowed_mimes, true) ) {
        echo '<pre>Security Error: File content does not match allowed image formats.</pre>';
        return;
    }

    // 5. Neutralize filename to prevent path traversal and script execution
    $safe_filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $target_path = $upload_dir . $safe_filename;

    if( move_uploaded_file( $file['tmp_name'], $target_path ) ) {
        echo "<pre>File uploaded successfully as: " . htmlspecialchars($safe_filename) . "</pre>";
    } else {
        echo '<pre>Error processing upload.</pre>';
    }
}

?>
