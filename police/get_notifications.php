<?php
session_start();
require_once '../db.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure officer is logged in
if (!isset($_SESSION['badge_number'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Not authorized']);
    exit;
}

$badge_number = $_SESSION['badge_number'];

try {
    $stmt = $pdo->prepare("
        SELECT ob_number, remarks
        FROM assignments
        WHERE badge_number = :badge
        ORDER BY id DESC
        LIMIT 10
    ");
    $stmt->execute(['badge' => $badge_number]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($notifications);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
