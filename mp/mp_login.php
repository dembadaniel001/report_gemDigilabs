<?php
require_once '../db.php';
session_start();

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        echo "Email and password are required.";
        exit;
    }

    try {
        // Fetch user from database
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND user_type = 'MP'");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];

            // Redirect to MP dashboard
            header("Location: mp_dashboard.html");
            exit;
        } else {
            echo "Invalid credentials or unauthorized access.";
            exit;
        }
    } catch (PDOException $e) {
        echo "Login error: " . $e->getMessage();
        exit;
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}
