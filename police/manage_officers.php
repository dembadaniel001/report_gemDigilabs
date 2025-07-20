<?php
session_start();
require_once '../db.php';
header('Content-Type: application/json');

// Check login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['rank'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Session expired or not logged in.']);
    exit;
}

// Restrict access
if ($_SESSION['rank'] !== 'Chief Inspector') {
    http_response_code(403);
    echo json_encode(['error' => 'Access denied. Only Chief Inspectors can manage officers.']);
    exit;
}

// === DELETE (Soft Delete) ===
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data['id'] ?? null;

        if (!$id || !is_numeric($id)) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing or invalid officer ID.']);
            exit;
        }

        if ($_SESSION['user_id'] == $id) {
            http_response_code(403);
            echo json_encode(['error' => 'You cannot delete your own account.']);
            exit;
        }

        // Soft delete officer
        $stmt = $pdo->prepare("UPDATE users SET status = 'inactive' WHERE id = ?");
        $success = $stmt->execute([$id]);

        if ($success) {
            // Audit log
            $audit = $pdo->prepare("INSERT INTO audit_logs (action, user_id, description) VALUES (?, ?, ?)");
            $audit->execute([
                'Deleted Officer',
                $_SESSION['user_id'],
                "Deactivated officer with ID: $id"
            ]);

            header('Content-Type: application/json');
echo json_encode(['message' => 'Officer deleted successfully.']);
exit;

        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to deactivate officer.']);
        }

    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }

    exit;
}

// === GET (List active officers) ===
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $stmt = $pdo->prepare("SELECT id, fullname, badge_number, id_number AS national_id, rank, email, phone 
                               FROM users 
                               WHERE status = 'active'
                               ORDER BY rank DESC");
        $stmt->execute();
        $officers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($officers);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error retrieving officers: ' . $e->getMessage()]);
    }
    exit;
}

// === POST (Update officer info) ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = intval($_POST['id']);
    $fullname = trim($_POST['fullname']);
    $rank = trim($_POST['rank']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if (!$fullname || !$rank || !$email || !$phone) {
        http_response_code(400);
        echo json_encode(['error' => 'All fields are required.']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("UPDATE users SET fullname = ?, rank = ?, email = ?, phone = ? WHERE id = ?");
        $stmt->execute([$fullname, $rank, $email, $phone, $id]);

        // Redirect back to manage page
        header("Location: manage_officers_page.php?success=1");
        exit;
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to update officer: ' . $e->getMessage()]);
    }
    exit;
}

// === Fallback for unsupported methods ===
http_response_code(405);
echo json_encode(['error' => 'Method not allowed.']);
exit;
