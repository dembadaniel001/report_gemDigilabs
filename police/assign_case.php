<?php
session_start();
require '../db.php';
header('Content-Type: application/json');

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
    exit;
}

// Collect input
$ob_number     = $_POST['obNumber'] ?? '';
$nature        = $_POST['occurrenceNature'] ?? '';
$badge_number  = $_POST['officerId'] ?? '';
$remarks       = $_POST['assignmentRemarks'] ?? '';

// Validate required fields
if (empty($ob_number) || empty($nature) || empty($badge_number)) {
    echo json_encode(["success" => false, "message" => "All required fields must be filled"]);
    exit;
}

// Fetch officer's full name
$stmt = $pdo->prepare("SELECT fullname FROM users WHERE badge_number = :badge AND status = 'active'");
$stmt->execute(['badge' => $badge_number]);
$officer = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$officer) {
    echo json_encode(["success" => false, "message" => "Officer not found"]);
    exit;
}

$officer_name = $officer['fullname'];

// Insert into assignments table
$insert = $pdo->prepare("
    INSERT INTO assignments (ob_number, nature, badge_number, officer_name, remarks)
    VALUES (:ob_number, :nature, :badge_number, :officer_name, :remarks)
");

$success = $insert->execute([
    'ob_number'    => $ob_number,
    'nature'       => $nature,
    'badge_number' => $badge_number,
    'officer_name' => $officer_name,
    'remarks'      => $remarks
]);

// === Audit Logging if success ===
if ($success) {
    // Ensure session is valid
    if (isset($_SESSION['user_id'], $_SESSION['fullname'], $_SESSION['rank'])) {
        // Get assigner's badge number
        $stmt = $pdo->prepare("SELECT badge_number FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $assigner_badge = $stmt->fetchColumn();

        // Log function
        function log_action($pdo, $officer_id, $fullname, $badge_number, $rank, $action, $description) {
            try {
                $stmt = $pdo->prepare("INSERT INTO audit_logs (officer_id, fullname, badge_number, rank, action, description)
                                       VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$officer_id, $fullname, $badge_number, $rank, $action, $description]);
            } catch (PDOException $e) {
                error_log("Audit log error (assign_case): " . $e->getMessage());
            }
        }

        log_action(
            $pdo,
            $_SESSION['user_id'],
            $_SESSION['fullname'],
            $assigner_badge,
            $_SESSION['rank'],
            'Assign Case',
            "Assigned OB No. $ob_number to $officer_name (Badge: $badge_number) with remarks: $remarks"
        );
    }

    echo json_encode(["success" => true, "message" => "Case successfully assigned"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to assign case"]);
}
?>
