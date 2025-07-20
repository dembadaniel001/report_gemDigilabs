<?php
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = trim($_POST['token']);
    $newPassword = trim($_POST['new_password']);
    $confirmPassword = trim($_POST['confirm_password']);

    if ($newPassword !== $confirmPassword) {
        echo json_encode(["success" => false, "message" => "Passwords do not match."]);
        exit;
    }

    // Validate token
    $stmt = $pdo->prepare("SELECT user_id FROM password_resets WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if ($reset) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update user password
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $reset['user_id']]);

        // Delete used token
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->execute([$token]);

        echo json_encode(["success" => true, "message" => "Password reset successful."]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid or expired token."]);
    }
}
?>
