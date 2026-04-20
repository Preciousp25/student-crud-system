<?php

session_start();

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../controllers/studentController.php';
require_once __DIR__ . '/../models/student.php';

$db = new \Database();
$conn = $db->getConnection();
$controller = new studentController($conn);

$action = $_GET['action'] ?? ($_POST['action'] ?? '');

function redirectTo($path) {
    header('Location: ' . $path);
    exit();
}

function withMessage($path, $message) {
    $separator = strpos($path, '?') === false ? '?' : '&';
    return $path . $separator . 'message=' . urlencode($message);
}

function isValidCsrfToken() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        return false;
    }

    if (!isset($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        return false;
    }

    return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

if ($action === 'create' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isValidCsrfToken()) {
        redirectTo(withMessage('../add.php', 'Invalid request token. Please try again.'));
    }

    $student = new \Student(
        $_POST['first_name'] ?? null,
        $_POST['last_name'] ?? null,
        $_POST['registration_number'] ?? null,
        $_POST['student_number'] ?? null,
        isset($_POST['age']) ? (int) $_POST['age'] : null,
        isset($_POST['cgpa']) ? (float) $_POST['cgpa'] : null
    );

    $created = $controller->create($student);

    if ($created) {
        redirectTo(withMessage('../index.php', 'Student added successfully.'));
    }

    redirectTo(withMessage('../add.php', $controller->getLastError() ?: 'Failed to add student.'));
}

if ($action === 'update' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isValidCsrfToken()) {
        $failedId = isset($_POST['id']) ? (int) $_POST['id'] : 0;
        redirectTo(withMessage('../edit.php?id=' . $failedId, 'Invalid request token. Please try again.'));
    }

    $id = isset($_POST['id']) ? (int) $_POST['id'] : null;

    $student = new \Student(
        $_POST['first_name'] ?? null,
        $_POST['last_name'] ?? null,
        $_POST['registration_number'] ?? null,
        $_POST['student_number'] ?? null,
        isset($_POST['age']) ? (int) $_POST['age'] : null,
        isset($_POST['cgpa']) ? (float) $_POST['cgpa'] : null
    );

    $updated = $controller->update($student, $id);

    if ($updated) {
        redirectTo(withMessage('../index.php', 'Student updated successfully.'));
    }

    redirectTo(withMessage('../edit.php?id=' . (int) $id, $controller->getLastError() ?: 'Failed to update student.'));
}

if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isValidCsrfToken()) {
        redirectTo(withMessage('../index.php', 'Invalid request token. Please try again.'));
    }

    $id = isset($_POST['id']) ? (int) $_POST['id'] : null;
    $deleted = $controller->destroy($id);

    if ($deleted) {
        redirectTo(withMessage('../index.php', 'Student deleted successfully.'));
    }

    redirectTo(withMessage('../index.php', $controller->getLastError() ?: 'Failed to delete student.'));
}

http_response_code(400);
echo 'Invalid action.';
