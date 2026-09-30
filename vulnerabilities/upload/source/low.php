<?php
if (isset($_POST['Upload'])) {
    $upload_dir = DVWA_WEB_PAGE_TO_ROOT . "hackable/uploads/";
    $file = $_FILES['uploaded'];

    // 1. Verify file was uploaded without standard HTTP upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo "<pre>Upload error occurred.</pre>";
        exit;
    }

    // 2. Enforce file size limit (e.g., 2 MB maximum)
    if ($file['size'] > 2097152) {
        echo "<pre>File exceeds the maximum 2MB size limit.</pre>";
        exit;
    }

    // 3. Strict extension whitelist check
    $allowed_extensions = ['jpg', 'jpeg', 'png'];
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed_extensions, true)) {
        echo "<pre>Invalid file type. Only JPG and PNG images are allowed.</pre>";
        exit;
    }

    // 4. Server-side MIME type inspection via file signatures (magic bytes)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($file['tmp_name']);
    $allowed_mimes = ['image/jpeg', 'image/png'];

    if (!in_array($mime_type, $allowed_mimes, true)) {
        echo "<pre>Security Error: File content does not match allowed image formats.</pre>";
        exit;
    }

    // 5. Neutralize filename to prevent path traversal and script execution
    $safe_filename = bin2hex(random_bytes(16)) . '.' . $extension;
    $target_path = $upload_dir . $safe_filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        echo "<pre>File uploaded successfully as: " . htmlspecialchars($safe_filename) . "</pre>";
    } else {
        echo "<pre>Error processing upload.</pre>";
    }
}
?>
