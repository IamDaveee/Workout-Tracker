<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $pwd = $_POST['password'];
    $remember = isset($_POST['remember']);  

    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        // ERROR HANDLERS

        $errors = [];

        if (is_input_empty($email, $pwd)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $email);

        if (is_email_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        if (!is_email_wrong($result) && is_password_wrong($pwd, $result["password_hash"])) {
            $errors["login_incorrect"] = "Incorrect login info!";
        }

        require_once 'config_session.inc.php';

        if ($errors) {
            $_SESSION["errors_login"] = $errors;

            header("location: ../login.php");
            die();
        }

        // Remember Me
        if ($remember) {
            $selector  = bin2hex(random_bytes(9));    // short ID
            $token     = bin2hex(random_bytes(33));   // secret
            $tokenHash = hash('sha256', $token);
            $expires   = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 14); // 14 days

            // ✅ use correct model function + user_id
            delete_tokens_by_user_id($pdo, (int)$result["user_id"]);
            insert_token($pdo, (int)$result["user_id"], $selector, $tokenHash, $expires);

            // Store selector + *plain* token in a cookie
            $cookieValue = $selector . ':' . $token;

            // Uses helper from config_session.inc.php
            set_cookie($cookieValue);
        } else {
            // If user didn't choose remember, remove old cookie & DB tokens
            set_cookie_without_remember();
            delete_tokens_by_user_id($pdo, (int)$result["user_id"]);
        }

        // Regenerate session id to prevent session fixation
        session_regenerate_id(true);

        $_SESSION["user_id"]       = $result["user_id"];
        $_SESSION["user_email"]    = htmlspecialchars($result["email"]);
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);

        $_SESSION['last_regeneration'] = time();

        header("location: ../index.php?login=success");

        $pdo  = null;
        $stmt = null;
        die();
    }
    catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}
else {
    header("location: ../index.php");
    die();
}
