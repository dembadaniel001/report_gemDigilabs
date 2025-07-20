<?php
include '../db.php'; // Adjust this path as necessary

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $reporterName = trim($_POST['reporterName'] ?? '');
    $contactInfo  = trim($_POST['contactInfo'] ?? '');
    $subject      = trim($_POST['subject'] ?? '');
    $otherType    = trim($_POST['otherType'] ?? '');
    $description  = trim($_POST['description'] ?? '');
    $department   = trim($_POST['department'] ?? '');

    // Use value from 'otherType' if 'Other' was selected
    if ($subject === 'Other' && !empty($otherType)) {
        $subject = $otherType;
    }

    // Validate input
    if (empty($reporterName) || empty($contactInfo) || empty($subject) || empty($description) || empty($department)) {
        echo "❌ Please fill in all required fields.";
        exit;
    }

    try {
        // Insert data into public_issues
        $stmt = $pdo->prepare("
            INSERT INTO public_issues (
                full_name, contact_number, department, subject, description, status, updated_at
            ) VALUES (
                :full_name, :contact_number, :department, :subject, :description, 'New', NOW()
            )
        ");

        $stmt->execute([
            ':full_name'      => $reporterName,
            ':contact_number' => $contactInfo,
            ':department'     => $department,
            ':subject'        => $subject,
            ':description'    => $description
        ]);

        // Redirect to cases page
        header("Location: mp_cases.html?success=1");
        exit;

    } catch (PDOException $e) {
        echo "❌ Database error: " . $e->getMessage();
        exit;
    }

} else {
    echo "❌ Invalid request method.";
}
?>
