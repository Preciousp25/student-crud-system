<?php
session_start();

include "config/Database.php";
require_once "controllers/studentController.php";

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = $_GET['message'] ?? null;

$db = new \Database();
$conn = $db->getConnection();

$controller = new studentController($conn);

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid request: No student ID provided.");
}

// Fetch student through controller
$student = $controller->get($id);

if (!$student) {
    die("Student not found.");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="CSS/style.css">
</head>

<body>

<!-- NAVBAR -->
<div class="navbar">
    <div><strong>Student CRUD System</strong></div>
    <div>
        <a href="index.php">Home</a>
        <a href="add.php">Add Student</a>
    </div>
</div>

<!-- BANNER -->
<div class="banner">
    <h1>Edit Student</h1>
    <p>Update student information safely and efficiently</p>
</div>

<!-- MAIN CONTENT -->
<div class="container">

    <div class="form-container">

        <h2>Edit Student</h2>

        <?php if ($message) { ?>
            <div class="alert alert-error" role="alert">
                <span class="alert-message"><?= htmlspecialchars($message) ?></span>
                <button type="button" class="alert-close" aria-label="Close message" onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
        <?php } ?>

        <form method="POST" action="actions/student.php?action=update">

            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <input type="hidden" name="id" value="<?= htmlspecialchars($student->getId()) ?>">

            <label for="first_name">First Name</label>
            <input 
                type="text" 
                id="first_name"
                name="first_name" 
                value="<?= htmlspecialchars($student->getFirstName()) ?>" 
                required
            >

            <label for="last_name">Last Name</label>
            <input 
                type="text" 
                id="last_name"
                name="last_name" 
                value="<?= htmlspecialchars($student->getLastName()) ?>" 
                required
            >

            <label for="registration_number">Registration Number</label>
            <input 
                type="text" 
                id="registration_number"
                name="registration_number" 
                value="<?= htmlspecialchars($student->getRegistrationNumber()) ?>" 
                required
            >

            <label for="student_number">Student Number</label>
            <input 
                type="text" 
                id="student_number"
                name="student_number" 
                value="<?= htmlspecialchars($student->getStudentNumber()) ?>" 
                required
            >

            <label for="age">Age</label>
            <input 
                type="number" 
                id="age"
                name="age" 
                min="1"
                value="<?= htmlspecialchars($student->getAge()) ?>" 
                required
            >

            <label for="cgpa">CGPA</label>
            <input 
                type="number" 
                id="cgpa"
                name="cgpa" 
                min="0"
                max="4"
                step="0.01"
                value="<?= htmlspecialchars($student->getCgpa()) ?>" 
                required
            >

            <!-- ACTION BUTTONS -->
            <div class="form-actions">

                <button type="submit">Update Student</button>

                <a href="index.php" class="back-btn">← Back to List</a>

            </div>

        </form>

    </div>

</div>

</body>
</html>