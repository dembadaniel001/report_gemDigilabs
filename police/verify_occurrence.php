<?php
require '../db.php';
session_start();

// Ensure only Chief Inspectors can verify
if (!isset($_SESSION['rank']) || $_SESSION['rank'] !== 'Chief Inspector') {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied']);
    exit;
}

// Safely get POST values
$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;

// Validate required input
if (!$id || !$status) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing id or status']);
    exit;
}

try {
    // Update the occurrence status
    $stmt = $pdo->prepare("UPDATE occurrences SET status = :status WHERE id = :id");
    $success = $stmt->execute([
        ':status' => $status,
        ':id' => $id
    ]);

    echo json_encode(['success' => $success]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error', 'error' => $e->getMessage()]);
}
?>
