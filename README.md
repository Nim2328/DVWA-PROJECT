## Command Injection Remediation

The Command Injection vulnerability in the DVWA Command Injection module was remediated by modifying:

`vulnerabilities/exec/source/low.php`

### Changes Implemented

The original implementation directly passed user-controlled input to an operating system command using `shell_exec()`. This allowed an attacker to inject and execute additional system commands.

The following security controls were implemented:

- Strict IPv4 input validation using `FILTER_VALIDATE_IP`
- Restriction to IPv4 addresses using `FILTER_FLAG_IPV4`
- Rejection of invalid or malicious input
- Shell argument escaping using `escapeshellarg()`
- Operating-system-specific ping command handling

### Before

The vulnerable implementation directly concatenated the user input into the operating system command:

```php
$target = $_REQUEST['ip'] ?? '';

$cmd = "ping -c 4 " . $target;

$output = shell_exec($cmd);
