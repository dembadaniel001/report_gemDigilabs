<?php
include '../db.php';

$id = $_GET['id'] ?? '';
$role = $_GET['role'] ?? '';

if (!is_numeric($id) || empty($role)) {
    http_response_code(400);
    echo "Invalid request";
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->execute([$role, $id]);
    echo "Role updated";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
}
?>
