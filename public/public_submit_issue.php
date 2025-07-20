<?php
// public_submit_issue.php
header("Content-Type: application/json");
require_once '../db.php'; // your working DB connection

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "No data received."]);
    exit;
}

$department     = trim($data['department'] ?? '');
$subject        = trim($data['subject'] ?? '');
$full_name      = trim($data['fullName'] ?? '');
$contact_number = trim($data['contactNumber'] ?? '');
$id_number      = trim($data['idNumber'] ?? '');
$ward           = trim($data['ward'] ?? '');
$sub_location   = trim($data['subLocation'] ?? '');
$village        = trim($data['village'] ?? '');
$description    = trim($data['description'] ?? '');

if (!$department || !$subject || !$full_name || !$contact_number || !$description) {
    echo json_encode(["status" => "error", "message" => "Please fill all required fields."]);
    exit;
}

try {
    $stmt = $pdo->prepare("INSERT INTO public_issues 
        (department, subject, full_name, contact_number, id_number, ward, sub_location, village, description)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
    $stmt->execute([
        $department,
        $subject,
        $full_name,
        $contact_number,
        $id_number,
        $ward,
        $sub_location,
        $village,
        $description
    ]);

    echo json_encode(["status" => "success", "message" => "Issue submitted successfully."]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => "Database error", "details" => $e->getMessage()]);
}
?>
