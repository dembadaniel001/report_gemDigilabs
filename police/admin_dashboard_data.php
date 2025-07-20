<?php
// admin_dashboard_data.php
header('Content-Type: application/json');
require_once '../db.php';

$response = [
  'total_officers' => 0,
  'active_cases' => 0,
  'pending_reports' => 0,
  'system_alerts' => 0,
  'notifications' => []
];

try {
  // 1. Count total officers (assumes status column exists and active means logged in users or valid accounts)
  $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE status = 'active'");
  $response['total_officers'] = (int) $stmt->fetchColumn();

  // 2. Count active cases (pending occurrences)
  $stmt = $pdo->query("SELECT COUNT(*) FROM occurrences WHERE status = 'pending'");
  $activeCases = (int) $stmt->fetchColumn();
  $response['active_cases'] = $activeCases;
  $response['pending_reports'] = $activeCases; // same as active cases

  // 3. System alerts today (audit_logs entries with today's date)
  $today = date('Y-m-d');
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM audit_logs WHERE DATE(timestamp) = ?");
  $stmt->execute([$today]);
  $response['system_alerts'] = (int) $stmt->fetchColumn();

  // 4. Latest notifications (activity_logs joined with users table)
  $stmt = $pdo->query(
    "SELECT u.fullname, a.ob_number, a.activity, a.timestamp 
     FROM activity_logs a 
     JOIN users u ON a.user_id = u.id 
     ORDER BY a.timestamp DESC 
     LIMIT 5"
  );

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $response['notifications'][] = [
      'fullname' => $row['fullname'],
      'ob_number' => $row['ob_number'],
      'activity' => $row['activity'],
      'timestamp' => $row['timestamp']
    ];
  }

  echo json_encode($response);

} catch (PDOException $e) {
  echo json_encode([
    'error' => 'Database error',
    'details' => $e->getMessage()
  ]);
  exit;
}
