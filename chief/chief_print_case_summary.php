<?php
include '../db.php'; // Update this path if needed

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['case_id'])) {
    $caseId = intval($_GET['case_id']);

    try {
        // Get case info
        $stmt = $pdo->prepare("SELECT id, subject, full_name, contact_number AS contact, status, department, description, date_submitted 
                               FROM public_issues WHERE id = ?");
        $stmt->execute([$caseId]);
        $case = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($case) {
            // Get updates if they exist
            $updatesStmt = $pdo->prepare("SELECT notes, updated_at FROM public_issues WHERE id = ? ORDER BY updated_at ASC");
            $updatesStmt->execute([$caseId]);
            $updates = $updatesStmt->fetchAll(PDO::FETCH_ASSOC);

            $case['updates'] = $updates;
            header('Content-Type: application/json');
            echo json_encode($case);
        } else {
            echo json_encode(['error' => '❌ Case not found.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => '❌ Database error: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['error' => '❌ Invalid or missing case_id.']);
}
?>
