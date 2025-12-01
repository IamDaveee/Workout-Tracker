<?php

declare(strict_types=1);

function is_input_emptiy(string $username, string $pwd, string $email){
    if (empty($username) || empty($pwd) || empty($email)) {
        return true;
    }
    else{
        return false;
    }
}

function is_terms_unchecked(bool $terms){
    if (!$terms) {
        return true;
    }
    else{
        return false;
    }
}

function password_match(string $pwd, string $pwd_rep){
    if ($pwd !== $pwd_rep) {
        return true;
    }
    else{
        return false;
    }
}

function is_email_invalid(string $email){
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else{
        return false;
    }
}

function is_username_taken(object $pdo, string $username){
    if (get_username( $pdo, $username)) {
        return true;
    }
    else{
        return false;
    }
}

function is_email_registered(object $pdo, string $email){
    if (get_email($pdo, $email)) {
        return true;
    }
    else{
        return false;
    }
}

function create_user (object $pdo, string $username, string $pwd, string $email){
    set_user($pdo, $username, $pwd, $email);
}