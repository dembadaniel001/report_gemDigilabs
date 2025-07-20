<?php
// Include the database connection file
include '../db.php'; // Adjust path if needed

// Set the response content type to JSON
header('Content-Type: application/json');

try {
    // Prepare and execute SQL to fetch all cases for the 'chief' department
    $stmt = $pdo->prepare("
        SELECT id, subject, full_name, date_submitted, status 
        FROM public_issues 
        WHERE department = 'chief'
        ORDER BY date_submitted DESC
    ");
    $stmt->execute();

    // Fetch all matching cases as an associative array
    $cases = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize category counts for statistics
    $category_counts = [
        "Land Dispute" => 0,
        "Livestock Theft" => 0,
        "Abuse" => 0,
        "Other" => 0
    ];

    // Count cases by category (subject)
    foreach ($cases as $case) {
        $subject = $case['subject'];

        // If the subject matches a known category, increment its count
        if (isset($category_counts[$subject])) {
            $category_counts[$subject]++;
            $case['category'] = $subject;
        } else {
            // Otherwise, increment the 'Other' category
            $category_counts['Other']++;
            $case['category'] = "Other";
        }
    }

    // Output the statistics and cases as JSON
    echo json_encode([
        'stats' => $category_counts,
        'cases' => $cases
    ]);

} catch (PDOException $e) {
    // Handle database errors and output as JSON
    echo json_encode([
        'error' => 'Database error',
        'details' => $e->getMessage()
    ]);
}
