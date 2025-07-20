<?php
include '../db.php'; // Adjust path to match your folder structure
session_start(); // Optional: only if you use session-based authentication

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $caseId = trim($_POST['caseId'] ?? '');
    $status = trim($_POST['status'] ?? '');
    $notes  = trim($_POST['notes'] ?? '');

    // Validate required fields
    if (empty($caseId) || empty($status)) {
        echo "❌ Case ID and Status are required.";
        exit;
    }

    try {
        // Step 1: Update the case
        $stmt = $pdo->prepare("
            UPDATE public_issues 
            SET status = :status, notes = :notes, updated_at = NOW() 
            WHERE id = :id
        ");
        $stmt->execute([
            ':status' => $status,
            ':notes'  => $notes,
            ':id'     => $caseId
        ]);

        // Step 2: (Optional) Log the action
        $actor = 'Chief'; // You can use $_SESSION['fullname'] if logged in
        $logAction = 'Updated Issue';
        $logDescription = "Status of Issue {$caseId} changed to '{$status}'. Notes: {$notes}";

       
    

        // Redirect with success
        header("Location: chief_cases.html?update=success");
        exit;

    } catch (PDOException $e) {
        echo "❌ Database error: " . $e->getMessage();
        exit;
    }
} else {
    echo "❌ Invalid request method.";
}
?>
