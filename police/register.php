<?php
// register.php

require_once '../db.php'; // include database connection

// Helper: clean input
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

// Receive POST data
$fullname        = sanitize($_POST['fullname'] ?? '');
$idNumber        = sanitize($_POST['idNumber'] ?? '');
$badgeNumber     = sanitize($_POST['badgeNumber'] ?? '');
$rank            = sanitize($_POST['rank'] ?? '');
$email           = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$phone           = sanitize($_POST['phone'] ?? '');
$password        = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';

// Check required fields
if (!$fullname || !$idNumber || !$badgeNumber || !$rank || !$email || !$phone || !$password || !$confirmPassword) {
    http_response_code(400);
    echo "All fields are required.";
    exit;
}

// Confirm password match
if ($password !== $confirmPassword) {
    http_response_code(400);
    echo "Passwords do not match.";
    exit;
}

// Check for existing user
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR id_number = ? OR badge_number = ?");
$stmt->execute([$email, $idNumber, $badgeNumber]);

if ($stmt->fetch()) {
    http_response_code(409);
    echo "User with provided email, ID number, or badge number already exists.";
    exit;
}

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user into database
try {
    $stmt = $pdo->prepare("
        INSERT INTO users (fullname, id_number, badge_number, rank, email, phone, password_hash)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([$fullname, $idNumber, $badgeNumber, $rank, $email, $phone, $hashedPassword]);

    // === Audit Log Entry ===
    $userId = $pdo->lastInsertId();
    $logStmt = $pdo->prepare("INSERT INTO audit_logs (officer_id, fullname, badge_number, rank, action, description)
                              VALUES (?, ?, ?, ?, ?, ?)");
    $logStmt->execute([
        $userId,
        $fullname,
        $badgeNumber,
        $rank,
        'Register Account',
        "New officer account created: $fullname ($badgeNumber)"
    ]);

    // Redirect after successful registration
    header("Location: login.html");
    exit;
} catch (PDOException $e) {
    http_response_code(500);
    echo "Database error.";
    exit;
}
