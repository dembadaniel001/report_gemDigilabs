<?php
session_start();
require_once '../db.php'; // Uses $pdo (PDO object) from db.php

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION['user_id'];
$fullname = $_SESSION['fullname'] ?? 'Unknown';
$rank = $_SESSION['rank'] ?? 'Unknown';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize form inputs
    $referenceNumber = trim($_POST['referenceNumber']);
    $occurrenceDate = $_POST['occurrenceDate'];
    $occurrenceTime = $_POST['occurrenceTime'];
    $caseFileNumber = trim($_POST['caseFileNumber']);
    $natureOfOccurrence = trim($_POST['natureOfOccurrence']);
    $remarks = trim($_POST['remarks']);

    // Use the current system date as entry date for OB number
    $entryDate = date('Y-m-d'); // e.g., "2025-06-13"
    $day = date('d');
    $month = date('m');
    $year = date('Y');

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Lock the row or insert new one for today's sequence
        $stmt = $pdo->prepare("SELECT last_sequence FROM ob_sequence WHERE ob_date = ? FOR UPDATE");
        $stmt->execute([$entryDate]);
        $row = $stmt->fetch();

        if ($row) {
            $sequence = $row['last_sequence'] + 1;
            $update = $pdo->prepare("UPDATE ob_sequence SET last_sequence = ? WHERE ob_date = ?");
            $update->execute([$sequence, $entryDate]);
        } else {
            $sequence = 1;
            $insert = $pdo->prepare("INSERT INTO ob_sequence (ob_date, last_sequence) VALUES (?, ?)");
            $insert->execute([$entryDate, $sequence]);
        }

        // Construct OB number
        $obNumber = "OB{$sequence}/{$day}/{$month}/{$year}";

        // Insert into occurrences table
        $stmt = $pdo->prepare("
            INSERT INTO occurrences (
                ob_number, reference_number, occurrence_date, occurrence_time,
                case_file_number, nature_of_occurrence, remarks, user_id
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $obNumber,
            $referenceNumber,
            $occurrenceDate,
            $occurrenceTime,
            $caseFileNumber,
            $natureOfOccurrence,
            $remarks,
            $user_id
        ]);

        // === Audit Log Entry ===
        $stmt = $pdo->prepare("SELECT badge_number FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $badge = $stmt->fetchColumn();

        $logStmt = $pdo->prepare("INSERT INTO audit_logs (officer_id, fullname, badge_number, rank, action, description)
                                  VALUES (?, ?, ?, ?, ?, ?)");
        $logStmt->execute([
            $user_id,
            $fullname,
            $badge,
            $rank,
            'Submit Occurrence',
            "Submitted a new occurrence with OB number {$obNumber}"
        ]);

        // Commit transaction
        $pdo->commit();

        // Redirect to dashboard
        header("Location: officer_dashboard.html");
        exit;

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error submitting occurrence: " . $e->getMessage();
    }

} else {
    echo "Invalid request method.";
}
