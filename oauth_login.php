<?php
declare(strict_types=1);

// While debugging – optional:
// Disable HTML error output so we always return valid JSON to the client.
// For debugging we capture any unexpected output in a buffer and include it
// in the JSON response instead of letting PHP emit HTML.
ini_set('display_errors', '0');
ini_set('display_startup_errors', '0');
error_reporting(E_ALL);

// Capture any unexpected output (warnings, notices, etc.) so we can
// return it inside a JSON payload rather than as raw HTML that breaks
// the client's JSON parsing.
ob_start();

// This matches what register.php does: it includes the session file from /includes
require_once __DIR__ . '/includes/config_session.inc.php';
require_once __DIR__ . '/includes/dbh.inc.php';
// config_session.inc.php already requires dbh.inc.php and login_contr.inc.php,
// so we get $pdo and session for free.

header('Content-Type: application/json');

// Read JSON from fetch()
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!$data) {
    echo json_encode(['success' => false, 'error' => 'No JSON payload']);
    exit;
}

$appwriteId = $data['appwrite_id'] ?? null;
$email      = $data['email'] ?? null;
$name       = $data['name'] ?? null;

if (!$appwriteId || !$email) {
    echo json_encode(['success' => false, 'error' => 'Missing appwrite_id or email']);
    exit;
}

try {
    // 1) Look for existing user by appwrite_id first (preferred), then by email.
    // This avoids ambiguous matches when multiple users share similar data.
    $stmt = $pdo->prepare("SELECT * FROM users WHERE appwrite_id = :appwrite_id LIMIT 1");
    $stmt->execute([':appwrite_id' => $appwriteId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if ($user) {
        // If the user exists but appwrite_id is missing, update it
        if (empty($user['appwrite_id'])) {
            $update = $pdo->prepare("UPDATE users SET appwrite_id = :appwrite_id WHERE user_id = :id");
            $update->execute([
                ':appwrite_id' => $appwriteId,
                ':id'          => $user['user_id'],
            ]);
        }

        $userId   = $user['user_id'];
        $username = $user['username'];
    } else {
        // 2) Create a new user from Google data
        $baseUsername = $name ?: explode('@', $email)[0] ?: 'user';

        // Make sure username is unique, but only treat it as a conflict
        // when a row exists with the same username AND the same appwrite_id
        // or the same email. That allows identical usernames across
        // different providers/emails while preventing duplicates for the
        // same account.
        $username = $baseUsername;
        $i = 1;
        $check = $pdo->prepare(
            "SELECT user_id FROM users WHERE username = :u AND (appwrite_id = :appwrite_id OR email = :email) LIMIT 1"
        );
        while (true) {
            $check->execute([
                ':u' => $username,
                ':appwrite_id' => $appwriteId,
                ':email' => $email,
            ]);
            if (!$check->fetch()) break;
            $username = $baseUsername . $i;
            $i++;
        }

        // Random password (not actually used for login, just to satisfy your schema)
        $randomPassword = bin2hex(random_bytes(16));
        $passwordHash   = password_hash($randomPassword, PASSWORD_BCRYPT, ['cost' => 12]);

        $insert = $pdo->prepare(
            "INSERT INTO users (username, email, password_hash, appwrite_id)
             VALUES (:username, :email, :password_hash, :appwrite_id)"
        );
        $insert->execute([
            ':username'      => $username,
            ':email'         => $email,
            ':password_hash' => $passwordHash,
            ':appwrite_id'   => $appwriteId,
        ]);

        $userId = (int)$pdo->lastInsertId();
    }

    // 3) Log the user in via PHP session
    $_SESSION['user_id']   = $userId;
    $_SESSION['user_username']  = $username;
    $_SESSION['user_email'] = $email;
    $_SESSION['logged_in'] = true;
    
    // 4) Regenerate session ID for security (same as register flow)
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
    
    $buffer = ob_get_clean();

    $response = ['success' => true];
    if ($buffer !== '') {
        // include captured output for debugging
        $response['debug_output'] = $buffer;
    }

    echo json_encode($response);
} catch (Throwable $e) {
    $buffer = ob_get_clean();

    $response = [
        'success' => false,
        'error'   => 'Server error: ' . $e->getMessage(),
    ];

    if ($buffer !== '') {
        $response['debug_output'] = $buffer;
    }

    echo json_encode($response);
}
