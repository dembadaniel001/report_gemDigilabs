<?php
// get_recent_occurrences.php
require_once '../db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("
        SELECT ob_number, nature_of_occurrence AS nature
        FROM occurrences
        WHERE DATE(created_at) = CURDATE()
        ORDER BY created_at DESC
    ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($results);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
