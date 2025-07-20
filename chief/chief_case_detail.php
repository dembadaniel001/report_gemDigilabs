<?php
// Include the database connection file
include '../db.php'; // adjust if needed

// Set the response content type to JSON
header('Content-Type: application/json');

// Get the case_id from the GET request, or set to empty string if not provided
$case_id = $_GET['case_id'] ?? '';

// Validate the case_id: must be present and numeric
if (!$case_id || !is_numeric($case_id)) {
    echo json_encode(['error' => 'Invalid case ID']);
    exit;
}

try {
    // Prepare a SQL statement to fetch the case details by ID
    $stmt = $pdo->prepare("SELECT id, subject, full_name, contact_number, date_submitted, status, description FROM public_issues WHERE id = ?");
    // Execute the statement with the provided case_id
    $stmt->execute([$case_id]);
    // Fetch the result as an associative array
    $case = $stmt->fetch(PDO::FETCH_ASSOC);

    // If no case is found, return an error message
    if (!$case) {
        echo json_encode(['error' => 'Case not found']);
        exit;
    }

    // Return the case details as a JSON response
    echo json_encode([
        'id' => $case['id'],
        'subject' => $case['subject'],
        'full_name' => $case['full_name'],
        'contact' => $case['contact_number'],
        'date_submitted' => $case['date_submitted'],
        'status' => $case['status'],
        'description' => $case['description']
    ]);

} catch (PDOException $e) {
    // Handle any database errors and return an error message
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
}
