<?php
session_start();
require '../db.php';
header('Content-Type: application/json');



try {
    $stmt = $pdo->query("
        SELECT 
            a.ob_number,
            a.nature,
            a.badge_number,
            a.officer_name,
            a.remarks,
            a.assigned_at,
            o.status
        FROM assignments a
        LEFT JOIN occurrences o ON a.ob_number = o.ob_number
        ORDER BY a.assigned_at DESC
    ");

    $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "assignments" => $assignments
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
