<?php
// mp_fetch_issues.php
include '../db.php'; // adjust path as necessary

header('Content-Type: application/json');

try {
    // Prepare and execute the query
    $stmt = $pdo->prepare("SELECT id, subject, updated_at, status FROM public_issues WHERE department = 'mp' ORDER BY updated_at DESC");
    $stmt->execute();

    $issues = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'issues' => $issues
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
