<?php
// get_slides.php

// Set the response content type to JSON
header('Content-Type: application/json');

// Include the database connection file
require_once '../db.php'; // adjust path if needed

try {
    // Prepare SQL query to select image paths and captions, ordered by display_order
    $query = $pdo->prepare("SELECT image_path, caption FROM slideshow_images ORDER BY display_order ASC");
    
    // Execute the query
    $query->execute();
    
    // Fetch all results as an associative array
    $slides = $query->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the slides in a JSON response with success status
    echo json_encode([
        'success' => true,
        'slides' => $slides
    ]);
} catch (PDOException $e) {
    // If a database error occurs, return an error response with details
    echo json_encode([
        'success' => false,
        'error' => 'Database error',
        'details' => $e->getMessage()
    ]);
}
?>
