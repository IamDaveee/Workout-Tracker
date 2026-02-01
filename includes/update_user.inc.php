<?php

declare(strict_types=1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        require_once 'dbh.inc.php';
        require_once 'config_session.inc.php';
        require_once 'register_contr.inc.php';
        require_once 'register_model.inc.php';
        require_once 'login_model.inc.php';

        $email = $_POST['email'];
        $username = $_POST['username'];
        $userId = $_SESSION['user_id'];
        $oldemail = $_SESSION['user_email'];
        $oldusername = $_SESSION['user_username'];

        if (empty($_POST["username"])) {
            $username = $_SESSION['user_username'];
        } else {
            $username = trim($_POST["username"]);
        }
        if (empty($_POST["email"])) {
            $email = $_SESSION['user_email'];
        } else {
            $email = trim($_POST["email"]);
        }

        if (is_empty_secondary($username, $email)) {
            header("location: ../index.php?error=emptyfields");
            exit();
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("location: ../index.php?error=invalidemail");
            die();
        } else if(is_username_taken($pdo, $username) && $username !== $oldusername) {
            header("location: ../index.php?error=usernametaken");
            die();
        } else if (is_email_registered($pdo, $email) && $email !== $oldemail) {
            header("location: ../index.php?error=emailregistered");
            die();
        } else {
            update_user($pdo, $userId, $username, $email);
    
            // Update session variables
            $_SESSION['user_email'] = $email;
            $_SESSION['user_username'] = $username;
    
            header("location: ../index.php?update=success");
            die();
        }
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
    
} else {
    header("location: ../index.php");
    die();
}