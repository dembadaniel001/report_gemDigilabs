<?php
session_start();
require_once '../db.php';
header('Content-Type: application/json');


try {
    $stmt = $pdo->query("
        SELECT 
            ob_number, 
            occurrence_date, 
            nature_of_occurrence, 
            remarks
        FROM occurrences
        ORDER BY created_at DESC
    ");

    $occurrences = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($occurrences);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
?>
