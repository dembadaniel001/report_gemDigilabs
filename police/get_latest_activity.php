<?php
require_once '../db.php';
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    http_response_code(401);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT ob_number, activity, timestamp FROM activity_logs WHERE user_id = ? ORDER BY timestamp DESC LIMIT 1");
    $stmt->execute([$_SESSION['user_id']]);
    $activity = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($activity ?: []);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
