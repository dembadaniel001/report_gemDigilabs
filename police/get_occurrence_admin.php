<?php
require '../db.php';
header('Content-Type: application/json');

if (!isset($_GET['ob']) || empty($_GET['ob'])) {
    echo json_encode(["success" => false, "message" => "OB number not provided."]);
    exit;
}

$ob_number = $_GET['ob'];

$stmt = $pdo->prepare("SELECT * FROM occurrences WHERE ob_number = :ob_number");
$stmt->execute(['ob_number' => $ob_number]);
$occurrence = $stmt->fetch(PDO::FETCH_ASSOC);

if ($occurrence) {
    echo json_encode(["success" => true, "data" => $occurrence]);
} else {
    echo json_encode(["success" => false, "message" => "Occurrence not found."]);
}
?>
