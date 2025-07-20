<?php
include '../db.php'; // adjust the path to your DB connection

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("SELECT id, user, action, description, log_time FROM audit_logs WHERE department = 'mp' ORDER BY log_time DESC");
    $stmt->execute();
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'logs' => $logs
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
