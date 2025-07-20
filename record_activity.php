<?php
require_once 'db.php'; // Include database connection
session_start(); // Start the session
header('Content-Type: application/json'); // Set response type to JSON

// Check if user is authenticated
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    http_response_code(401);
    exit;
}

// Retrieve and sanitize POST data
$ob_number = trim($_POST['ob_number'] ?? '');
$activity = trim($_POST['activity'] ?? '');

// Validate required fields
if (empty($ob_number) || empty($activity)) {
    echo json_encode(['error' => 'Both OB Number and Activity are required']);
    http_response_code(400);
    exit;
}

try {
    // Insert activity log into the database
    $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, ob_number, activity, timestamp) VALUES (?, ?, ?, NOW())");
    $stmt->execute([
        $_SESSION['user_id'],
        $ob_number,
        $activity
    ]);

    // Fetch the most recent activity for this user
    $latest = $pdo->prepare("SELECT ob_number, activity, timestamp FROM activity_logs WHERE user_id = ? ORDER BY timestamp DESC LIMIT 1");
    $latest->execute([$_SESSION['user_id']]);
    $latestActivity = $latest->fetch(PDO::FETCH_ASSOC);

    // Return success message and latest activity
    echo json_encode([
        'message' => 'Activity logged successfully',
        'latest' => $latestActivity
    ]);
} catch (PDOException $e) {
    // Handle database errors
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
