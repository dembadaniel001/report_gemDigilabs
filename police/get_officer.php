<?php
// === get_officer.php ===
session_start();
require_once '../db.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session + role check
if (!isset($_SESSION['user_id']) || $_SESSION['rank'] !== 'Chief Inspector') {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied.']);
    exit;
}

// Check for ID
$id = $_GET['id'] ?? null;
if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing officer ID.']);
    exit;
}

// Query the officer
try {
    $stmt = $pdo->prepare("SELECT id, fullname, badge_number, id_number AS national_id, rank, email, phone FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $officer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($officer) {
        echo json_encode($officer);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Officer not found.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
