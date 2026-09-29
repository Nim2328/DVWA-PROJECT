<?php

if (isset($_POST['Submit'])) {

    $target = $_REQUEST['ip'] ?? '';

    // Vulnerable: user input is directly passed to the OS command.
    $cmd = "ping -c 4 " . $target;

    $output = shell_exec($cmd);

    $html .= "<pre>" . htmlspecialchars($output ?? '') . "</pre>";
}

?>
