<?php

declare(strict_types=1);

function is_input_empty(string $email, string $pwd) {
    return empty($email) || empty($pwd);
}

function is_email_wrong(bool|array $result) {
    return !$result;
}

function is_password_wrong(string $pwd, string $hashedPwd) {
    return !password_verify($pwd, $hashedPwd);
}

/**
 * Try to restore login from the "remember_me" cookie.
 * Called on every request from config_session.inc.php.
 */
function attempt_auto_login_from_cookie(object $pdo): void {

    // If already logged in, do nothing
    if (isset($_SESSION['user_id'])) {
        return;
    }

    // If no cookie, nothing to do
    if (empty($_COOKIE['remember_me'])) {
        return;
    }

    $cookieValue = $_COOKIE['remember_me'];

    $isHttps = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';

    // Cookie format: "selector:token"
    if (!str_contains($cookieValue, ':')) {
        return;
    }

    [$selector, $token] = explode(':', $cookieValue, 2);

    require_once 'login_model.inc.php';

    $row = get_token_by_selector($pdo, $selector);

    if ($row === false) {
        // No token in DB, remove cookie
        setcookie(
            'remember_me',
            '',
            [
                'expires'  => time() - 3600,
                'path'     => '/',
                'secure'   => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
        // Also clear any cookie that was created with a Domain attribute (localhost)
        setcookie(
            'remember_me',
            '',
            [
                'expires'  => time() - 3600,
                'path'     => '/',
                'domain'   => 'localhost',
                'secure'   => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
        return;
    }

    // Check expiry
    if (strtotime($row['expires']) < time()) {
        // Token expired → remove from DB and cookie
        delete_token_by_selector($pdo, $selector);
        setcookie(
            'remember_me',
            '',
            [
                'expires'  => time() - 3600,
                'path'     => '/',
                'secure'   => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
        // Also clear any cookie that was created with a Domain attribute (localhost)
        setcookie(
            'remember_me',
            '',
            [
                'expires'  => time() - 3600,
                'path'     => '/',
                'domain'   => 'localhost',
                'secure'   => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
        return;
    }

    // Verify token
    $calculatedHash = hash('sha256', $token);

    if (!hash_equals($row['token_hash'], $calculatedHash)) {
        // Possible theft → delete this token and cookie
        delete_token_by_selector($pdo, $selector);
        setcookie(
            'remember_me',
            '',
            [
                'expires'  => time() - 3600,
                'path'     => '/',
                'secure'   => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
        // Also clear any cookie that was created with a Domain attribute (localhost)
        setcookie(
            'remember_me',
            '',
            [
                'expires'  => time() - 3600,
                'path'     => '/',
                'domain'   => 'localhost',
                'secure'   => $isHttps,
                'httponly' => true,
                'samesite' => 'Lax',
            ]
        );
        return;
    }

    // Token is valid → log user in (create new session data)
    $_SESSION['user_id'] = (int)$row['user_id'];
    $_SESSION['last_regeneration'] = time();

    // Load extra user data (email, username) so pages that check these see the user as logged in
    require_once 'login_model.inc.php';
    $userRow = get_user_by_id($pdo, (int)$row['user_id']);
    if ($userRow !== false) {
        $_SESSION['user_email'] = htmlspecialchars($userRow['email']);
        $_SESSION['user_username'] = htmlspecialchars($userRow['username']);
    }

    // Regenerate session id for security now that we've logged the user in
    session_regenerate_id(true);

    // Rotate token: new token & hash but same selector
    $newToken   = bin2hex(random_bytes(33));
    $newHash    = hash('sha256', $newToken);
    $newExpires = date('Y-m-d H:i:s', time() + 60 * 60 * 24 * 14); // 14 days

    update_token($pdo, $selector, $newHash, $newExpires);

    $newCookieValue = $selector . ':' . $newToken;

    // Ensure any legacy cookie set with Domain=localhost is removed first
    setcookie(
        'remember_me',
        '',
        [
            'expires'  => time() - 3600,
            'path'     => '/',
            'domain'   => 'localhost',
            'secure'   => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax',
        ]
    );

    // Set the new host-only cookie (no Domain) so it works correctly on localhost
    setcookie(
        'remember_me',
        $newCookieValue,
        [
            'expires'  => time() + 60 * 60 * 24 * 14,
            'path'     => '/',
            'secure'   => $isHttps,
            'httponly' => true,
            'samesite' => 'Lax',
        ]
    );
}
