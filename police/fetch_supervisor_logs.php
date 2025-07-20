<?php
session_start();
require_once '../db.php';
header('Content-Type: application/json');



try {
    // Fetch latest 100 logs (you can adjust this number or remove the LIMIT)
    $stmt = $pdo->query("
        SELECT 
            timestamp,
            fullname,
            badge_number,
            rank,
            action,
            description
        FROM audit_logs
        ORDER BY timestamp DESC
        LIMIT 100
    ");

    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($logs);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
