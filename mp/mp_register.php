<?php
require_once '../db.php';
session_start();

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = sanitize($_POST['fullName'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $nationalId = sanitize($_POST['nationalId'] ?? '');
    $phone = sanitize($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Validation
    if (!$fullName || !$email || !$nationalId || !$phone || !$password || !$confirmPassword) {
        echo "All fields are required.";
        exit;
    }

    if (!$email) {
        echo "Invalid email address.";
        exit;
    }

    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    if (strlen($password) < 6) {
        echo "Password should be at least 6 characters long.";
        exit;
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo "This email is already registered.";
        exit;
    }

    // Hash the password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Insert MP into users table
    try {
        $stmt = $pdo->prepare("INSERT INTO users (fullname, id_number, email, phone, password_hash, user_type)
                               VALUES (?, ?, ?, ?, ?, 'MP')");
        $stmt->execute([$fullName, $nationalId, $email, $phone, $passwordHash]);

        // Optionally, you can auto-login here or just redirect
        header("Location: mp_login.html");
        exit;
    } catch (PDOException $e) {
        echo "Registration failed: " . $e->getMessage();
        exit;
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}
