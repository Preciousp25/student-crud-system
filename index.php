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
$students = $controller->getAll();

?>

<!DOCTYPE html>
<html>

<head>
    <title>Student CRUD System</title>
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
            <a href="views/add.php">Add Student</a>
        </div>
    </div>

    <!-- BANNER -->
    <div class="banner">
    </div>

    <!-- MAIN CONTENT -->
    <div class="container">

        <h2>Student List</h2>

        <?php if ($message) { ?>
        <div class="alert alert-success" role="status" aria-live="polite">
            <span class="alert-message"><?= htmlspecialchars($message) ?></span>
            <button type="button" class="alert-close" aria-label="Close message"
                onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
        <?php } ?>

        <a href="views/add.php" class="add-btn">Add Student</a>

        <div class="table-container">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Registration No.</th>
                        <th>Student No.</th>
                        <th>Age</th>
                        <th>CGPA</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (count($students) > 0) { ?>

                    <?php foreach ($students as $student) { ?>
                    <tr>
                        <td><?= htmlspecialchars($student->getId()) ?></td>
                        <td><?= htmlspecialchars($student->getFirstName()) ?></td>
                        <td><?= htmlspecialchars($student->getLastName()) ?></td>
                        <td><?= htmlspecialchars($student->getRegistrationNumber()) ?></td>
                        <td><?= htmlspecialchars($student->getStudentNumber()) ?></td>
                        <td><?= htmlspecialchars($student->getAge()) ?></td>
                        <td><?= htmlspecialchars($student->getCgpa()) ?></td>
                        <td class="actions-cell">

                            <a href="views/edit.php?id=<?= $student->getId() ?>" class="edit">Edit</a>

                            <form method="POST" action="actions/student.php?action=delete" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($student->getId()) ?>">
                                <input type="hidden" name="csrf_token"
                                    value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                                <button type="submit" class="delete"
                                    onclick="return confirm('Are you sure you want to delete this student?')">Delete</button>
                            </form>

                        </td>
                    </tr>
                    <?php } ?>

                    <?php } else { ?>

                    <tr>
                        <td colspan="8" style="text-align:center; padding:20px;">
                            No students found.
                        </td>
                    </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</body>

</html>