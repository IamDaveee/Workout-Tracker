<?php

declare(strict_types=1);

function get_user(object $pdo, string $email) {
    $query = "SELECT * FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Get a user row by id.
 */
function get_user_by_id(object $pdo, int $userId): array|false {
    $query = "SELECT * FROM users WHERE user_id = :uid LIMIT 1;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':uid', $userId, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Delete all remember tokens for a given user (used on login / logout).
 */
function delete_tokens_by_user_id(object $pdo, int $userId): void {
    $query = "DELETE FROM remember_tokens WHERE user_id = :uid;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':uid', $userId, PDO::PARAM_INT);
    $stmt->execute();
}

/**
 * Insert a new remember token row.
 */
function insert_token(
    object $pdo,
    int $userId,
    string $selector,
    string $tokenHash,
    string $expires
): void {
    $query = "INSERT INTO remember_tokens (user_id, selector, token_hash, expires, created_at)
              VALUES (:uid, :selector, :token_hash, :expires, NOW())";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':uid',        $userId,    PDO::PARAM_INT);
    $stmt->bindParam(':selector',   $selector);
    $stmt->bindParam(':token_hash', $tokenHash);
    $stmt->bindParam(':expires',    $expires);
    $stmt->execute();
}

/**
 * Get a remember token row by selector (used when auto-logging in).
 */
function get_token_by_selector(object $pdo, string $selector): array|false {
    $query = "SELECT * FROM remember_tokens WHERE selector = :selector LIMIT 1;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':selector', $selector);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Update token hash + expiry (token rotation).
 */
function update_token(
    object $pdo,
    string $selector,
    string $tokenHash,
    string $expires
): void {
    $query = "UPDATE remember_tokens
              SET token_hash = :token_hash, expires = :expires
              WHERE selector = :selector;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':token_hash', $tokenHash);
    $stmt->bindParam(':expires',    $expires);
    $stmt->bindParam(':selector',   $selector);
    $stmt->execute();
}

/**
 * Delete a single token by selector (used if token is invalid / expired).
 */
function delete_token_by_selector(object $pdo, string $selector): void {
    $query = "DELETE FROM remember_tokens WHERE selector = :selector;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':selector', $selector);
    $stmt->execute();
}
