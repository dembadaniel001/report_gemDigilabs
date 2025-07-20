<?php
// filepath: c:\xampp\htdocs\North_gem_digihub\fetch_report_data.php
require_once '../db.php'; // Make sure this file sets up $pdo (PDO connection)

header('Content-Type: application/json');

$from = $_GET['from'] ?? null;
$to = $_GET['to'] ?? null;
$nature = $_GET['nature'] ?? null;

$where = [];
$params = [];

if ($from) {
    $where[] = 'occurrence_date >= ?';
    $params[] = $from;
}
if ($to) {
    $where[] = 'occurrence_date <= ?';
    $params[] = $to;
}
if ($nature) {
    $where[] = 'nature_of_occurrence LIKE ?';
    $params[] = '%' . $nature . '%';
}

$sql = "SELECT ob_number, occurrence_date, occurrence_time, nature_of_occurrence, remarks FROM occurrence_reports";
if ($where) {
    $sql .= " WHERE " . implode(' AND ', $where);
}
$sql .= " ORDER BY occurrence_date DESC, occurrence_time DESC";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($data);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}