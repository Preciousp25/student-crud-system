<?php
session_start();

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = $_GET['message'] ?? null;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Student</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/style.css">
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <div><strong>Student CRUD System</strong></div>
        <div>
            <a href="../index.php">Home</a>
            <a href="add.php">Add Student</a>
        </div>
    </div>

    <!-- BANNER -->
    <div class="banner">
    </div>

    <!-- MAIN CONTENT -->
    <div class="container">

        <div class="form-container">

            <h2>Student Registration</h2>

            <?php if ($message) { ?>
            <div class="alert alert-error" role="alert">
                <span class="alert-message"><?= htmlspecialchars($message) ?></span>
                <button type="button" class="alert-close" aria-label="Close message"
                    onclick="this.parentElement.style.display='none';">&times;</button>
            </div>
            <?php } ?>

            <form method="POST" action="../actions/student.php?action=create">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" placeholder="Enter first name" required>

                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" placeholder="Enter last name" required>

                <label for="registration_number">Registration Number</label>
                <input type="text" id="registration_number" name="registration_number"
                    placeholder="Enter registration number" required>

                <label for="student_number">Student Number</label>
                <input type="text" id="student_number" name="student_number" placeholder="Enter student number"
                    required>

                <label for="age">Age</label>
                <input type="number" id="age" name="age" min="1" placeholder="Enter age" required>

                <label for="cgpa">CGPA</label>
                <input type="number" id="cgpa" name="cgpa" step="0.01" min="0" max="4" placeholder="Enter CGPA"
                    required>

                <!-- ACTION BUTTONS -->
                <div class="form-actions">

                    <button type="submit">Save Student</button>

                    <a href="../index.php" class="back-btn">← Back to List</a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>