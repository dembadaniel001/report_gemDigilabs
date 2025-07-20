<?php
header('Content-Type: application/json');
include '../db.php'; // your database connection file

$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : '';

try {
    // Base query
    $sql = "SELECT id, subject, contact_number AS reporter, date_submitted, status 
            FROM public_issues 
            WHERE department = 'Chief'";

    $params = [];

    // Add keyword filter (search in subject or reporter/contact_number)
    if (!empty($keyword)) {
        $sql .= " AND (subject LIKE :keyword OR contact_number LIKE :keyword)";
        $params[':keyword'] = '%' . $keyword . '%';
    }

    // Add status filter
    if (!empty($status)) {
        $sql .= " AND status = :status";
        $params[':status'] = $status;
    }

    $sql .= " ORDER BY date_submitted DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $cases = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($cases);
} catch (PDOException $e) {
    echo json_encode([
        "error" => "Failed to fetch chief cases",
        "details" => $e->getMessage()
    ]);
}
?>
