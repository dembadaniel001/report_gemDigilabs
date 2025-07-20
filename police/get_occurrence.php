<?php
require '../db.php';

if (!isset($_GET['ob_number'])) {
    echo json_encode(['success' => false, 'message' => 'Missing OB number']);
    exit;
}

$obNumber = $_GET['ob_number'];

$stmt = $pdo->prepare("SELECT nature_of_occurrence FROM occurrences WHERE ob_number = :ob_number");
$stmt->execute([':ob_number' => $obNumber]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    echo json_encode(['success' => true, 'nature' => $row['nature_of_occurrence']]);
} else {
    echo json_encode(['success' => false, 'message' => 'No record found']);
}
?>
