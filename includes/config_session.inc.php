<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);

// If you want NON-remember users to be logged out when the browser closes,
// set lifetime to 0 (session cookie):
session_set_cookie_params([
    'lifetime' => 0,          // 0 = until browser close
    'path'     => '/',
    'secure'   => false,      // true only if you're on HTTPS
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_start();

/*
 |----------------------------------------------------
 | SESSION REGENERATION (your old logic)
 |----------------------------------------------------
*/

if (isset($_SESSION["user_id"])) {
    if (!isset($_SESSION['last_regeneration'])) {
        regenerate_session_id_loggedin();
    } else {
        $interval = 60 * 30; // 30 minutes
        if (time() - $_SESSION['last_regeneration'] >= $interval) {
            regenerate_session_id_loggedin();
        }
    }
} else {
    if (!isset($_SESSION['last_regeneration'])) {
        regenerate_session_id();
    } else {
        $interval = 60 * 30;
        if (time() - $_SESSION['last_regeneration'] >= $interval) {
            regenerate_session_id();
        }
    }
}

function regenerate_session_id_loggedin() {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

function set_cookie(string $value): void {

    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

    setcookie(
        'remember_me',
        $value,
        [
            'expires'  => time() + 60 * 60 * 24 * 14,
            'path'     => '/',
            'secure'   => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax',
        ]
    );
}

function set_cookie_without_remember(): void {

    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

    setcookie(
        'remember_me',
        '',
        [
            'expires'  => time() - 3600,  // delete cookie
            'path'     => '/',
            'secure'   => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax',
        ]
    );
}

/*
 |----------------------------------------------------
 | AUTO LOGIN FROM REMEMBER-ME COOKIE (EVERY REQUEST)
 |----------------------------------------------------
*/

if (!isset($_SESSION['user_id'])) {
    require_once 'dbh.inc.php';
    require_once 'login_contr.inc.php';

    attempt_auto_login_from_cookie($pdo);
}
