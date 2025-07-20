<?php
// logout.php

require_once '../db.php';
session_start();  // Resume session to access user data

// Function to log audit actions
function log_action($pdo, $officer_id, $fullname, $badge_number, $rank, $action, $description) {
    try {
        $stmt = $pdo->prepare("INSERT INTO audit_logs (officer_id, fullname, badge_number, rank, action, description)
                               VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$officer_id, $fullname, $badge_number, $rank, $action, $description]);
    } catch (PDOException $e) {
        error_log("Audit log error (logout): " . $e->getMessage());
    }
}

// Only log if session has user info
if (isset($_SESSION['user_id'], $_SESSION['fullname'], $_SESSION['rank'])) {
    $officer_id   = $_SESSION['user_id'];
    $fullname     = $_SESSION['fullname'];
    $rank         = $_SESSION['rank'];

    // Fetch badge number from DB (optional but safer)
    $stmt = $pdo->prepare("SELECT badge_number FROM users WHERE id = ?");
    $stmt->execute([$officer_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $badge_number = $user['badge_number'] ?? 'Unknown';

    log_action(
        $pdo,
        $officer_id,
        $fullname,
        $badge_number,
        $rank,
        'Logout',
        'User logged out successfully'
    );
}

// End the session
session_unset();
session_destroy();

// Redirect to login page
header("Location: login.html");
exit;
