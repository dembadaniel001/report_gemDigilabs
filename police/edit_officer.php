<?php
// === edit_officer.php ===
session_start();
require_once '../db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only Chief Inspectors can proceed
if (!isset($_SESSION['user_id']) || $_SESSION['rank'] !== 'Chief Inspector') {
    http_response_code(403);
    die('Access denied.');
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id           = $_POST['id'] ?? '';
    $fullname     = trim($_POST['fullname'] ?? '');
    $badge_number = trim($_POST['badge_number'] ?? '');
    $national_id  = trim($_POST['national_id'] ?? '');
    $rank         = trim($_POST['rank'] ?? '');
    $role         = trim($_POST['role'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $phone        = trim($_POST['phone'] ?? '');

    // Validate required fields
    if (!$id || !$fullname || !$badge_number || !$national_id || !$rank || !$role || !$email || !$phone) {
        die('Missing required fields.');
    }

    try {
        // Update officer details including role
        $stmt = $pdo->prepare("UPDATE users SET fullname = ?, badge_number = ?, id_number = ?, rank = ?, role = ?, email = ?, phone = ? WHERE id = ?");
        $result = $stmt->execute([$fullname, $badge_number, $national_id, $rank, $role, $email, $phone, $id]);

        if ($result) {
            // === Audit Logging ===
            if (isset($_SESSION['user_id'], $_SESSION['fullname'], $_SESSION['rank'])) {
                $stmt = $pdo->prepare("SELECT badge_number FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $admin_badge = $stmt->fetchColumn();

                $logStmt = $pdo->prepare("INSERT INTO audit_logs (officer_id, fullname, badge_number, rank, action, description)
                                          VALUES (?, ?, ?, ?, ?, ?)");
                $logStmt->execute([
                    $_SESSION['user_id'],
                    $_SESSION['fullname'],
                    $admin_badge,
                    $_SESSION['rank'],
                    'Update Officer',
                    "Updated officer ID $id: $fullname (Badge: $badge_number, Rank: $rank, Role: $role)"
                ]);
            }

            header("Location: manage_officers.html?success=1");
            exit;
        } else {
            throw new Exception("Database failed to update officer.");
        }
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
} else {
    http_response_code(405);
    echo 'Method not allowed.';
    exit;
}
