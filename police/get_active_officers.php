<?php
// === get_active_officers.php ===

session_start();
require_once '../db.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only accessible if logged in and user has permission
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT badge_number, fullname FROM users WHERE status = 'active' ORDER BY fullname ASC");
    $stmt->execute();
    $officers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($officers);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
