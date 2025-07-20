<?php
require '../db.php';
header('Content-Type: application/json');

try {
    $searchTerm = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : null;

    if ($searchTerm) {
        // Search by fullname or action if search term is provided
        $sql = "SELECT * FROM audit_logs 
                WHERE fullname LIKE :search OR action LIKE :search
                ORDER BY timestamp DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['search' => $searchTerm]);
    } else {
        // Fetch all logs if no search term is provided
        $sql = "SELECT * FROM audit_logs ORDER BY timestamp DESC";
        $stmt = $pdo->query($sql);
    }

    $logs = $stmt->fetchAll();

    echo json_encode(["success" => true, "logs" => $logs]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Error fetching audit logs.",
        "details" => $e->getMessage()
    ]);
}
?>
