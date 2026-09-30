# DVWA Security Remediation Validation

## Purpose

This document records the validation performed after remediation of four
application-level vulnerabilities in the DVWA test environment.

## Validated Vulnerabilities

### 1. SQL Injection

The original SQL injection behaviour was tested using a controlled injection
payload. After remediation, integer validation and prepared statements were
implemented.

Validation result: the injection input was rejected as an invalid user ID.

### 2. Reflected Cross-Site Scripting

The original reflected XSS behaviour was tested using a controlled script
payload. After remediation, reflected input was encoded using
`htmlspecialchars()` with UTF-8 handling.

Validation result: the payload was displayed as text and was not executed.

### 3. Command Injection

The original command injection behaviour was tested using a controlled
command-separator payload. After remediation, target validation and safe
shell argument handling were implemented.

Validation result: the malicious input was rejected as an invalid target.

### 4. Malicious File Upload

The original upload functionality accepted a PHP proof-of-concept file.
After remediation, upload status, size, MIME type, extension and filename
controls were implemented.

Validation result: the PHP proof-of-concept upload was rejected because the
file type was not permitted.

## Validation Conclusion

The same controlled proof-of-concept inputs were retested after remediation.
The application no longer accepted the four tested attack inputs in their
original form. The validation results support the secure-coding changes
implemented in the project.
