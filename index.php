<?php

include "config/Database.php";
include "classes/Student.php";

$db = new Database();
$conn = $db->getConnection();

$student = new Student($conn);
$result = $student->read();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Student CRUD System</title>
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
    <h1>Student Management System</h1>
    <p>Manage, update, and track student records efficiently</p>
</div>

<!-- MAIN CONTENT -->
<div class="container">

    <h2>Student List</h2>

    <a href="add.php" class="add-btn">Add Student</a>

    <div class="table-container">

        <table>

            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Actions</th>
            </tr>

            <?php if ($result->rowCount() > 0) { ?>

                <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['fullname']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['course']) ?></td>
                    <td>

                        <a href="edit.php?id=<?= $row['id'] ?>" class="edit">Edit</a>

                        <a href="actions/delete.php?id=<?= $row['id'] ?>" 
                           class="delete"
                           onclick="return confirm('Are you sure you want to delete this student?')">
                           Delete
                        </a>

                    </td>
                </tr>
                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="5" style="text-align:center; padding:20px;">
                        No students found.
                    </td>
                </tr>

            <?php } ?>

        </table>

    </div>

</div>

</body>
</html>