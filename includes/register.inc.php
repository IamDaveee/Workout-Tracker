<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username= $_POST['username'];
    $email= $_POST['email'];
    $pwd= $_POST['password'];
    $pwd_rep= $_POST['passwordRepeat'];
    $terms= isset($_POST['terms']) ? true : false;

    try {

        require_once 'dbh.inc.php';
        require_once 'register_model.inc.php';
        require_once 'register_contr.inc.php';

        $errors=[];

        if (is_input_emptiy($username, $pwd, $email)) {
            $errors["empty_input"] = "Fill in all fields!";
        }
        if (is_terms_unchecked($terms)) {
            $errors["terms_unchecked"] = "You must agree to the terms and conditions!";
        }
        if (password_match($pwd, $pwd_rep)) {
            $errors["password_mismatch"] = "Passwords do not match!";
        }
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Invalid email used!";
        }
        if (is_username_taken( $pdo, $username)) {
            $errors["username_taken"] = "Username already taken!";
        }
        if (is_email_registered($pdo, $email)) {
            $errors["email_used"] = "Email already registered!";
        }

        require_once 'config_session.inc.php';

        if($errors){
            $_SESSION["errors_signup"]=$errors;

            $signup_data=[
                "username"=>$username,
                "email"=>$email
            ];
            $_SESSION["signup_data"]=$signup_data;


            header("location: ../register.php");
            die();
        }

        create_user($pdo, $username, $pwd, $email);

        header("location: ../index.php?signup=success");

        $pdo=null;
        $stmt=null;

        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("location: ../index.php");
    die();
}