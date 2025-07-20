<?php
require_once '../db.php'; // Your DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $caption = htmlspecialchars($_POST['caption']);
    $order = (int)$_POST['order'];

    // Handle file upload
    if (isset($_FILES['slideImage']) && $_FILES['slideImage']['error'] === 0) {
        $uploadDir = 'images/';
        $fileName = basename($_FILES['slideImage']['name']);
        $targetPath = $uploadDir . time() . "_" . $fileName;

        if (move_uploaded_file($_FILES['slideImage']['tmp_name'], $targetPath)) {
            $stmt = $pdo->prepare("INSERT INTO slideshow_images (image_path, caption, display_order) VALUES (?, ?, ?)");
            $stmt->execute([$targetPath, $caption, $order]);
            echo "Image uploaded successfully.";
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "No valid image selected.";
    }
}
?>
