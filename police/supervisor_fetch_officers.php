<?php
require '../db.php';
session_start();



try {
    // Only select officers who are active
    $stmt = $pdo->query("SELECT badge_number, fullname, rank FROM users WHERE status = 'active' ORDER BY rank DESC, fullname ASC");
    $officers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($officers);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
