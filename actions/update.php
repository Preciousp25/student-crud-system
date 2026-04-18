<?php

include "../config/Database.php";
include "../classes/Student.php";

$db = new Database();
$conn = $db->getConnection();

$student = new Student($conn);

// Get form data
$student->id = $_POST['id'];
$student->fullname = $_POST['fullname'];
$student->email = $_POST['email'];
$student->course = $_POST['course'];

// Update record
$student->update();

header("Location: ../index.php");
exit();