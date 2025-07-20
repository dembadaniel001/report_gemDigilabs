<?php
// get_summary_stats.php
session_start();
require_once '../db.php';
header('Content-Type: application/json');

try {
    // Ensure officer is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["error" => "Not authenticated"]);
        exit;
    }

    $userId = $_SESSION['user_id'];

    // 1. Total Occurrences for today
    $stmt1 = $pdo->prepare("SELECT COUNT(*) FROM occurrences WHERE DATE(created_at) = CURDATE()");
    $stmt1->execute();
    $totalOccurrencesToday = $stmt1->fetchColumn();

    // 2. Pending Actions (status = 'Pending')
    $stmt2 = $pdo->prepare("SELECT COUNT(*) FROM occurrences WHERE status = 'Pending'");
    $stmt2->execute();
    $pendingActions = $stmt2->fetchColumn();

    // 3. Fetch officer name and rank
    $stmt3 = $pdo->prepare("SELECT fullname, rank FROM users WHERE id = ?");
    $stmt3->execute([$userId]);
    $user = $stmt3->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        'total_occurrences_today' => $totalOccurrencesToday,
        'pending_actions' => $pendingActions,
        'officer_name' => $user['fullname'],
        'rank' => $user['rank']
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
}
