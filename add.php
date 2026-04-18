<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
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
    <h1>Add New Student</h1>
    <p>Fill in the form below to create a new student record</p>
</div>

<!-- MAIN CONTENT -->
<div class="container">

    <div class="form-container">

        <h2>Student Registration</h2>

        <form method="POST" action="actions/create.php">

            <!-- FULL NAME -->
            <label for="fullname">Full Name</label>
            <input 
                type="text" 
                id="fullname"
                name="fullname" 
                placeholder="Enter full name"
                required
            >

            <!-- EMAIL -->
            <label for="email">Email</label>
            <input 
                type="email" 
                id="email"
                name="email" 
                placeholder="Enter email address"
                required
            >

            <!-- COURSE -->
            <label for="course">Course</label>
            <input 
                type="text" 
                id="course"
                name="course" 
                placeholder="Enter course"
                required
            >

            <!-- ACTION BUTTONS -->
            <div class="form-actions">

                <button type="submit">Save Student</button>

                <a href="index.php" class="back-btn">← Back to List</a>

            </div>

        </form>

    </div>

</div>

</body>
</html>