<?php
header('Content-Type: application/json');
include '../db.php';

// Handle GET: Return issue by ID
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid or missing issue ID']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("SELECT id, status, proposed_solution FROM public_issues WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $issue = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($issue) {
            echo json_encode(['status' => 'success', 'issue' => $issue]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Issue not found']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// Handle POST: Update issue
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data['id']) || !isset($data['status'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        exit;
    }

    $id = intval($data['id']);
    $status = trim($data['status']);
    $solution = trim($data['notes'] ?? '');

    if ($id <= 0 || $status === '') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE public_issues SET 
            status = :status, 
            proposed_solution = :solution, 
            updated_at = NOW() 
            WHERE id = :id
        ");
        $stmt->execute([
            ':status' => $status,
            ':solution' => $solution,
            ':id' => $id
        ]);

        echo json_encode(['status' => 'success']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// If not GET or POST
http_response_code(405);
echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
