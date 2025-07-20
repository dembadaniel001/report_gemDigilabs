<?php
// Include the database connection file
include '../db.php'; // Adjust this path if needed

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input from the form
    $reporterName = trim($_POST['reporterName'] ?? '');
    $contactInfo  = trim($_POST['contactInfo'] ?? '');
    $idNumber     = trim($_POST['idNumber'] ?? '');   // ✅ updated name
    $caseType     = trim($_POST['caseType'] ?? '');
    $otherType    = trim($_POST['otherCaseType'] ?? '');
    $description  = trim($_POST['description'] ?? '');
    $department   = "Chief"; // Set department as Chief

    // If 'Other' is selected as case type, use the value from 'otherCaseType'
    if ($caseType === 'Other' && !empty($otherType)) {
        $caseType = $otherType;
    }

    // Validate that all required fields are filled
    if (empty($reporterName) || empty($contactInfo) || empty($idNumber) || empty($caseType) || empty($description)) {
        echo "❌ Please fill in all required fields.";
        exit;
    }

    try {
        // Combine ID number and case type to form the subject
        $subject = $idNumber . " – " . $caseType;

        // Prepare SQL statement to insert the new case into the public_issues table
        $stmt = $pdo->prepare("
            INSERT INTO public_issues (
                full_name, contact_number, subject, department, description, status, notes, date_submitted, updated_at
            ) VALUES (
                :full_name, :contact_number, :subject, :department, :description, 'New', '', NOW(), NOW()
            )
        ");

        // Execute the prepared statement with the provided data
        $stmt->execute([
            ':full_name'      => $reporterName,
            ':contact_number' => $contactInfo,
            ':subject'        => $subject,
            ':department'     => $department,
            ':description'    => $description
        ]);

        // Redirect to the cases page with a success flag
        header("Location: chief_cases.html?success=1");
        exit;

    } catch (PDOException $e) {
        // Handle database errors
        echo "❌ Database error: " . $e->getMessage();
        exit;
    }

} else {
    // If the request method is not POST, show an error
    echo "❌ Invalid request method.";
}
?>
