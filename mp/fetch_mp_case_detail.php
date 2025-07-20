<?php
require_once '../db.php';

if (!isset($_GET['id'])) {
  echo json_encode(['status' => 'error', 'message' => 'Missing ID']);
  exit;
}

$id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM public_issues WHERE id = ? AND department = 'MP'");
$stmt->execute([$id]);
$issue = $stmt->fetch(PDO::FETCH_ASSOC);

if ($issue) {
  echo json_encode(['status' => 'success', 'issue' => $issue]);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Issue not found']);
}
