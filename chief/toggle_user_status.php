<?php
include '../db.php';

$id = $_GET['id'] ?? '';

if (!is_numeric($id)) {
    http_response_code(400);
    echo "Invalid ID";
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT status FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "User not found";
        exit;
    }

    $newStatus = $user['status'] == 1 ? 0 : 1;

    $update = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
    $update->execute([$newStatus, $id]);

    echo "Status updated";
} catch (PDOException $e) {
    http_response_code(500);
    echo "Database error: " . $e->getMessage();
}
?>
