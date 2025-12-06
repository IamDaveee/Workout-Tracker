<?php
require_once 'config_session.inc.php';
require_once 'dbh.inc.php';
require_once 'login_model.inc.php';

// If user is logged in, remove their remember tokens:
if (isset($_SESSION['user_id'])) {
    delete_tokens_by_user_id($pdo, (int)$_SESSION['user_id']);
}

// Destroy PHP session completely
$_SESSION = [];
session_unset();
session_destroy();

// Delete PHP session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Delete remember_me cookie
set_cookie_without_remember();

// Redirect after logout
header("Location: ../index.php?logout=success");
exit();
