# Student CRUD System

Database-driven student management system built with pure PHP, MySQL, PDO, and Object-Oriented design.

## Assignment Objective Coverage

- Applies PHP fundamentals through real request/response handling and server-side logic.
- Implements full CRUD operations: create, read, update, delete.
- Uses PDO prepared statements for secure DB interaction.
- Follows Object-Oriented PHP with model/controller separation.
- Handles form data with validation, sanitization, and safe output escaping.

## Architecture

- config/Database.php: PDO connection and automatic schema/bootstrap checks.
- models/student.php: Student entity with getters/setters.
- controllers/studentController.php: CRUD business logic, validation, duplicate checks.
- actions/student.php: Unified HTTP endpoint for create/update/delete flows.
- index.php: Tabular student listing and delete action.
- add.php: Student creation form.
- edit.php: Student update form.

## Data Model

Table: students

- id (INT, PK, AUTO_INCREMENT)
- first_name (VARCHAR(100), NOT NULL)
- last_name (VARCHAR(100), NOT NULL)
- registration_number (VARCHAR(100), NOT NULL, UNIQUE)
- student_number (VARCHAR(100), NOT NULL, UNIQUE)
- age (INT, NOT NULL)
- cgpa (DECIMAL(3,2), NOT NULL)
- created_at (TIMESTAMP, default CURRENT_TIMESTAMP)

The app automatically creates the table and missing columns/indexes if needed.

## Security and Integrity Practices

- PDO prepared statements for all SQL writes/reads.
- Output escaping with htmlspecialchars() in views.
- Server-side validation for required fields, age range, and CGPA range.
- Data sanitization (trim/strip_tags) before persistence.
- Duplicate prevention with controller checks and database unique indexes.
- CSRF token verification for create/update/delete POST requests.
- POST-Redirect-GET flow to reduce accidental resubmission on refresh.

## Run Instructions (Podman on Fedora)

1. From the project root, start the containers:
   `podman compose up --build`
2. Open `http://localhost:8080`.
3. Stop containers with:
   `podman compose down`

The MySQL database (`student_db`) is created automatically by the database container, and the app auto-creates/updates the `students` table schema on startup.

## Alternative Local Setup (XAMPP)

1. Start Apache and MySQL in XAMPP.
2. Create database named student_db.
3. Place project in htdocs/student-crud-system.
4. Open http://localhost/student-crud-system.


