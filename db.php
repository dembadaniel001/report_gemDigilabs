<?php
// db.php

// Database connection settings
$host = 'localhost';        // Database server host (usually 'localhost')
$db   = 'occurrence_book';  // Name of the database to connect to
$user = 'root';             // Database username
$pass = '';                 // Database password (leave empty if not set)
$charset = 'utf8mb4';       // Character set for the connection

// Data Source Name (DSN) string for PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// PDO options for error handling and fetch mode
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch results as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use native prepared statements
];

try {
    // Create a new PDO instance (connect to the database)
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Uncomment below line for debug confirmation
    // echo "Connected to database successfully.";
} catch (PDOException $e) {
    // If connection fails, return a 500 error and output JSON error message
    http_response_code(500); // Set HTTP response code to 500 (Internal Server Error)
    echo json_encode(['error' => 'Database connection failed.']); // Output error as JSON
    exit('Database connection error: ' . $e->getMessage()); // Stop script and output error message
}
?>
