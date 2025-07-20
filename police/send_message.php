<?php
require_once '../db.php';
session_start();
header('Content-Type: application/json');

// Ensure the sender is logged in
if (!isset($_SESSION['badge_number'], $_SESSION['fullname'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

// Validate input
if (empty($_POST['recipient_id']) || empty($_POST['message'])) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

$sender_badge = $_SESSION['badge_number'];
$sender_name = $_SESSION['fullname'];
$recipient_badge = $_POST['recipient_id'];
$message = trim($_POST['message']);

try {
    $stmt = $pdo->prepare("INSERT INTO messages (sender_badge, recipient_badge, sender_name, message, sent_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$sender_badge, $recipient_badge, $sender_name, $message]);

    echo json_encode(["success" => true, "message" => "Message sent successfully."]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}
?>
<?php
require_once 'db.php';
session_start();
header('Content-Type: application/json');

// Ensure the sender is logged in
if (!isset($_SESSION['badge_number'], $_SESSION['fullname'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

// Validate input
if (empty($_POST['recipient_id']) || empty($_POST['message'])) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

$sender_badge = $_SESSION['badge_number'];
$sender_name = $_SESSION['fullname'];
$recipient_badge = $_POST['recipient_id'];
$message = trim($_POST['message']);

try {
    $stmt = $pdo->prepare("INSERT INTO messages (sender_badge, recipient_badge, sender_name, message, sent_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->execute([$sender_badge, $recipient_badge, $sender_name, $message]);

    echo json_encode(["success" => true, "message" => "Message sent successfully."]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
}
?>
