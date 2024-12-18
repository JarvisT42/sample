<?php
// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// If it's desired to kill the session cookie, also delete it
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session
session_start();
session_unset();
session_destroy();

// Redirect to index.php
header("Location: ../index.php");
exit();
?>
