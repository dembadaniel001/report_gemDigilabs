<?php
session_start();
require_once '../db.php';

// Allow only Chief Inspectors to add new officers
if (!isset($_SESSION['user_id']) || $_SESSION['rank'] !== 'Chief Inspector') {
    http_response_code(403);
    die('Access denied.');
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('Method not allowed.');
}

// Sanitize input
$fullname     = trim($_POST['fullname'] ?? '');
$badge_number = trim($_POST['badge_number'] ?? '');
$national_id  = trim($_POST['national_id'] ?? '');
$rank         = trim($_POST['rank'] ?? '');
$email        = trim($_POST['email'] ?? '');
$phone        = trim($_POST['phone'] ?? '');
$password     = $_POST['password'] ?? '';
$confirm_pass = $_POST['confirm_password'] ?? '';

// Validate input
if (
    !$fullname || !$badge_number || !$national_id || !$rank ||
    !$email || !$phone || !$password || !$confirm_pass
) {
    die('All fields are required.');
}

if ($password !== $confirm_pass) {
    die('Passwords do not match.');
}

// Check for duplicates
$stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE badge_number = ? OR id_number = ? OR email = ?");
$stmt->execute([$badge_number, $national_id, $email]);
if ($stmt->fetchColumn() > 0) {
    die('Officer with the same badge number, ID number, or email already exists.');
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert officer
$stmt = $pdo->prepare("
    INSERT INTO users (fullname, badge_number, id_number, rank, email, phone, password_hash)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");

$success = $stmt->execute([
    $fullname, $badge_number, $national_id,
    $rank, $email, $phone, $hashed_password
]);

// === Audit Logging ===
if ($success) {
    function log_action($pdo, $officer_id, $fullname, $badge_number, $rank, $action, $description) {
        try {
            $stmt = $pdo->prepare("INSERT INTO audit_logs (officer_id, fullname, badge_number, rank, action, description)
                                   VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$officer_id, $fullname, $badge_number, $rank, $action, $description]);
        } catch (PDOException $e) {
            error_log("Audit log error (add_officer): " . $e->getMessage());
        }
    }

    // Session values of the current admin
    $admin_id = $_SESSION['user_id'];
    $admin_name = $_SESSION['fullname'];
    $admin_rank = $_SESSION['rank'];

    // Get admin badge number
    $stmt = $pdo->prepare("SELECT badge_number FROM users WHERE id = ?");
    $stmt->execute([$admin_id]);
    $admin_badge = $stmt->fetchColumn();

    // Log the addition
    log_action(
        $pdo,
        $admin_id,
        $admin_name,
        $admin_badge,
        $admin_rank,
        'Add Officer',
        "Added new officer: $fullname (Badge: $badge_number, Rank: $rank)"
    );

    // Redirect with success
    header("Location: manage_officers.html?success=1");
    exit;
} else {
    die('Failed to add officer. Please try again.');
}
?>
