<?php
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Validate user
    $stmt = $pdo->prepare("SELECT id, fullname FROM users WHERE email = ? AND phone = ?");
    $stmt->execute([$email, $phone]);
    $user = $stmt->fetch();

    if ($user) {
        // Generate secure token
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Save token
        $stmt = $pdo->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$user['id'], $token, $expires]);

        // Construct reset URL
        $resetLink = "http://davidochieng.free.nf/reset_password.html?token=" . urlencode($token);

        // Email or log link
        // You should use a mailer in production
        file_put_contents("reset_links.log", "Reset link for {$user['fullname']} ({$email}): $resetLink\n", FILE_APPEND);
        
        echo json_encode(["success" => true, "message" => "A reset link has been sent to your email."]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid email or phone number."]);
    }
}
?>
