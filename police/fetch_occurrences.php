<?php
session_start();
require_once '../db.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Security check
if (!isset($_SESSION['user_id']) || $_SESSION['rank'] !== 'Chief Inspector') {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT 
            o.ob_number,
            u.fullname AS officer_name,
            u.badge_number,
            o.occurrence_date,
            o.occurrence_time,
            o.nature_of_occurrence AS nature,
            o.status
        FROM occurrences o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.occurrence_date DESC
    ");
    $stmt->execute();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($records);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error',
        'details' => $e->getMessage()
    ]);
}
