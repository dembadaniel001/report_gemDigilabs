<?php
session_start();
require '../db.php';
header('Content-Type: application/json');



// Get JSON input
$input = json_decode(file_get_contents("php://input"), true);
$ob_number = $input['ob_number'] ?? '';
$status = $input['status'] ?? '';

if (!$ob_number || !$status) {
    echo json_encode(["success" => false, "message" => "Missing OB number or status"]);
    exit;
}

try {
    // Update status in occurrences table
    $stmt = $pdo->prepare("UPDATE occurrences SET status = :status WHERE ob_number = :ob_number");
    $stmt->execute([
        'status' => $status,
        'ob_number' => $ob_number
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Status updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "No changes made or OB not found"]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database error: " . $e->getMessage()
    ]);
}
