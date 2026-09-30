# Malicious File Upload Remediation

The Malicious File Upload vulnerability in the DVWA File Upload module was remediated by modifying:
`vulnerabilities/upload/source/low.php`

## Changes Implemented

The original implementation directly passed user-uploaded files to `move_uploaded_file()` without checking the file type, extension, or actual content. This allowed an attacker to upload an arbitrary PHP web shell and achieve remote code execution (RCE) on the server.

The following security controls were implemented:
* Strict file extension whitelisting (only allowing `.jpg`, `.jpeg`, and `.png`)
* Server-side MIME type verification using PHP's `finfo` class to inspect magic bytes directly
* Cryptographically secure file renaming using `random_bytes()` to neutralize direct path access and prevent directory traversal
* Maximum file size restriction (2 MB) to prevent denial of service
* Clean error handling to prevent leaking server directory paths

## Before

The vulnerable implementation directly accepted the uploaded file and saved it under the user-supplied filename into an accessible web directory:

```php
$target_path  = DVWA_WEB_PAGE_TO_ROOT . "hackable/uploads/";
$target_path .= basename( $_FILES[ 'uploaded' ][ 'name' ] );

if( !move_uploaded_file( $_FILES[ 'uploaded' ][ 'tmp_name' ], $target_path ) ) {
    echo '<pre>Your image was not uploaded.</pre>';
} else {
    echo "<pre>{$target_path} successfully uploaded!</pre>";
}

