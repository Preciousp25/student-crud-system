<?php

include "../config/Database.php";
include "../classes/Student.php";

$db = new Database();
$conn = $db->getConnection();

$student = new Student($conn);

// get ID from URL
if (isset($_GET['id'])) {
    $student->id = $_GET['id'];

    $student->delete();
}

header("Location: ../index.php");
exit();