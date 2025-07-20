<?php
require_once '../db.php'; // Adjust the path if needed

header('Content-Type: application/json');

try {
    // New issues (last 7 days)
    $stmtNew = $pdo->prepare("
        SELECT * FROM public_issues 
        WHERE department = 'MP' 
          AND date_submitted >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
        ORDER BY date_submitted DESC
    ");
    $stmtNew->execute();
    $recentIssues = $stmtNew->fetchAll(PDO::FETCH_ASSOC);
    $newCount = count($recentIssues);

    // Pending issues
    $stmtPending = $pdo->prepare("
        SELECT COUNT(*) FROM public_issues 
        WHERE department = 'MP' 
          AND status = 'Pending'
    ");
    $stmtPending->execute();
    $pendingCount = $stmtPending->fetchColumn();

    // Resolved issues
    $stmtResolved = $pdo->prepare("
        SELECT COUNT(*) FROM public_issues 
        WHERE department = 'MP' 
          AND status = 'Resolved'
    ");
    $stmtResolved->execute();
    $resolvedCount = $stmtResolved->fetchColumn();

    echo json_encode([
        'status' => 'success',
        'new_count' => $newCount,
        'pending_count' => $pendingCount,
        'resolved_count' => $resolvedCount,
        'recent_issues' => $recentIssues
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error',
        'details' => $e->getMessage()
    ]);
}
?>
