<?php
require_once '../db.php'; // adjust path as needed
session_start();

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'] ?? '';

    if (!$email || !$password) {
        echo "Email and password are required.";
        exit;
    }

    // Fetch user from database
    $stmt = $pdo->prepare("SELECT id, fullname, id_number, phone, password_hash, user_type FROM users WHERE email = ? AND user_type = 'Chief'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['email'] = $email;
        $_SESSION['national_id'] = $user['id_number'];
        $_SESSION['user_type'] = 'Chief';

        // ✅ Redirect to chief dashboard
        header("Location:chief_dashboard.html");
        exit;
    } else {
        echo "Invalid email or password, or you're not registered as a Chief.";
        exit;
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}
