<?php
// chief_dashboard.php
include '../db.php';
header('Content-Type: application/json');

try {
    // Fetch counts
    $counts = [
        'total' => 0,
        'pending' => 0,
        'resolved' => 0
    ];

    $stmt = $pdo->prepare("SELECT status, COUNT(*) as count FROM public_issues WHERE department = 'Chief' GROUP BY status");
    $stmt->execute();
    $statusCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($statusCounts as $row) {
        $counts['total'] += $row['count'];
        if ($row['status'] === 'Pending') {
            $counts['pending'] = $row['count'];
        }
        if ($row['status'] === 'Resolved') {
            $counts['resolved'] = $row['count'];
        }
    }

    // Fetch recent cases (latest 5)
    $stmt = $pdo->prepare("SELECT id, subject, contact_number, status, DATE(updated_at) AS date_submitted FROM public_issues WHERE department = 'Chief' ORDER BY updated_at DESC LIMIT 5");
    $stmt->execute();
    $recentCases = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'stats' => $counts,
        'recent' => $recentCases
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
