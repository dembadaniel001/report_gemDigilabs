<?php
// login.php

require_once '../db.php';
session_start();

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(trim($data));
}

// Audit log function
function log_action($pdo, $officer_id, $fullname, $badge_number, $rank, $action, $description) {
    try {
        $stmt = $pdo->prepare("INSERT INTO audit_logs (officer_id, fullname, badge_number, rank, action, description)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$officer_id, $fullname, $badge_number, $rank, $action, $description]);
    } catch (PDOException $e) {
        error_log("Audit log error (login): " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $badgeNumber = sanitize($_POST['badgeNumber'] ?? '');
    $idNumber    = sanitize($_POST['idNumber'] ?? '');
    $email       = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password    = $_POST['password'] ?? '';

    if (!$badgeNumber || !$idNumber || !$email || !$password) {
        http_response_code(400);
        echo "All fields are required.";
        exit;
    }

    // Fetch user data including role
    $stmt = $pdo->prepare("SELECT id, fullname, rank, role, badge_number, password_hash FROM users WHERE email = ? AND badge_number = ? AND id_number = ?");
    $stmt->execute([$email, $badgeNumber, $idNumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        // Store session variables
        $_SESSION['user_id']      = $user['id'];
        $_SESSION['fullname']     = $user['fullname'];
        $_SESSION['rank']         = $user['rank'];
        $_SESSION['badge_number'] = $user['badge_number'];
        $_SESSION['role']         = strtolower($user['role']); // normalize role to lowercase

        // Log login event
        log_action(
            $pdo,
            $user['id'],
            $user['fullname'],
            $user['badge_number'],
            $user['rank'],
            'Login',
            'Successful login'
        );

        // Redirect based on role
        switch ($_SESSION['role']) {
            case 'admin':
                header("Location: admin_dashboard.html");
                break;
            case 'supervisor':
                header("Location: supervisor_dashboard.html");
                break;
            case 'officer':
                header("Location: officer_dashboard.html");
                break;
            default:
                echo "Unrecognized role.";
                exit;
        }

        exit;
    } else {
        http_response_code(401);
        echo "Invalid credentials. Please check and try again.";
        exit;
    }
} else {
    http_response_code(405);
    echo "Method Not Allowed";
    exit;
}
