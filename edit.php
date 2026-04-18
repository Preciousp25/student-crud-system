<?php

include "config/Database.php";
include "classes/Student.php";

$db = new Database();
$conn = $db->getConnection();

$student = new Student($conn);

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Invalid request: No student ID provided.");
}

// Fetch student using OOP method (SoC improved)
$row = $student->getById($id);

if (!$row) {
    die("Student not found.");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link rel="stylesheet" href="css/style.css">
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

        <form method="POST" action="actions/update.php">

            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">

            <!-- FULL NAME -->
            <label for="fullname">Full Name</label>
            <input 
                type="text" 
                id="fullname"
                name="fullname" 
                value="<?= htmlspecialchars($row['fullname']) ?>" 
                required
            >

            <!-- EMAIL -->
            <label for="email">Email</label>
            <input 
                type="email" 
                id="email"
                name="email" 
                value="<?= htmlspecialchars($row['email']) ?>" 
                required
            >

            <!-- COURSE -->
            <label for="course">Course</label>
            <input 
                type="text" 
                id="course"
                name="course" 
                value="<?= htmlspecialchars($row['course']) ?>" 
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