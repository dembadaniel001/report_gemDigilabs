<?php
include '../db.php'; // Adjust path if needed

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("SELECT id, fullname, role, status FROM users WHERE user_type = 'chief'");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error', 'details' => $e->getMessage()]);
}
?>
