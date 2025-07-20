<?php
require '../db.php';
session_start();

// Check if the user is logged in and has permission
if (!isset($_SESSION['rank']) || ($_SESSION['rank'] !== 'Chief Inspector' && $_SESSION['rank'] !== 'Inspector')) {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied']);
    exit;
}

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
