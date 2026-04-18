<?php

include "../config/Database.php";
include "../classes/Student.php";

$db = new Database();
$conn = $db->getConnection();

$student = new Student($conn);

// Get form data safely
$student->fullname = $_POST['fullname'];
$student->email = $_POST['email'];
$student->course = $_POST['course'];

// Save to database
if ($student->create()) {
    header("Location: ../index.php");
    exit();
} else {
    echo "Failed to add student.";
}