<?php
require_once '../db.php'; // Adjust the path as necessary
session_start();

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = sanitize($_POST['fullName'] ?? '');
    $nationalId = sanitize($_POST['nationalId'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $phone = sanitize($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    // Basic validation
    if (!$fullName || !$nationalId || !$email || !$phone || !$password || !$confirmPassword) {
        echo "All fields are required.";
        exit;
    }

    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit;
    }

    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters.";
        exit;
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo "This email is already registered.";
        exit;
    }

    // Hash password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insert into users table as Chief
        $stmt = $pdo->prepare("INSERT INTO users (fullname, id_number, email, phone, password_hash, user_type)
                               VALUES (?, ?, ?, ?, ?, 'Chief')");
        $stmt->execute([$fullName, $nationalId, $email, $phone, $passwordHash]);

        // ✅ Redirect to login page instead of auto-login
        header("Location: chief_login.html?registered=success");
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
