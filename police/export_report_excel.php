<?php
require_once '../db.php';
session_start();



header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=occurrence_report.csv");

$stmt = $pdo->query("SELECT ob_number, occurrence_date, occurrence_time, nature_of_occurrence, remarks FROM occurrences ORDER BY occurrence_date DESC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Print headers
echo "OB Number,Date,Time,Nature of Occurrence,Remarks\n";

// Print rows
foreach ($data as $row) {
    echo "\"{$row['ob_number']}\",\"{$row['occurrence_date']}\",\"{$row['occurrence_time']}\",\"{$row['nature_of_occurrence']}\",\"{$row['remarks']}\"\n";
}
?>
