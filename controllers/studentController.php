<?php

require_once __DIR__ . '/../models/student.php';


class studentController
{
  private $conn;
  private $lastError = '';

  public function __construct(PDO $conn)
  {
    $this->conn = $conn;
  }

  public function getLastError(): string
  {
    return $this->lastError;
  }

  public function get(int $id): ?\Student
  {
    $stmt = $this->conn->prepare("SELECT * FROM students WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
      return null;
    }

    $student = new \Student(
      $result['first_name'],
      $result['last_name'],
      $result['registration_number'],
      $result['student_number'],
      $result['age'],
      $result['cgpa']
    );
    $student->setId($result['id']);

    return $student;
  }

  /**
   * Get all students from the database.
   *
   * @return \Student[] Array of \Student objects
   */
  public function getAll(): array
  {
    $stmt = $this->conn->query("SELECT * FROM students ORDER BY id ASC");
    $students = [];

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $student = new \Student(
        $row['first_name'],
        $row['last_name'],
        $row['registration_number'],
        $row['student_number'],
        $row['age'],
        $row['cgpa']
      );
      $student->setId($row['id']);
      $students[] = $student;
    }

    return $students;
  }

  public function create(\Student $student): ?bool
  {
    $this->lastError = '';
    $this->sanitizeStudentData($student);

    $validationError = $this->validateStudentData($student);
    if ($validationError !== null) {
      $this->lastError = $validationError;
      return false;
    }

    if ($this->isRegistrationNumberTaken($student->getRegistrationNumber())) {
      $this->lastError = 'Registration number already exists.';
      return false;
    }

    if ($this->isStudentNumberTaken($student->getStudentNumber())) {
      $this->lastError = 'Student number already exists.';
      return false;
    }

    $stmt = $this->conn->prepare(
      "INSERT INTO students (first_name, last_name, registration_number, student_number, age, cgpa)
             VALUES (:first_name, :last_name, :registration_number, :student_number, :age, :cgpa)"
    );

    try {
      return $stmt->execute([
        ':first_name' => $student->getFirstName(),
        ':last_name' => $student->getLastName(),
        ':registration_number' => $student->getRegistrationNumber(),
        ':student_number' => $student->getStudentNumber(),
        ':age' => $student->getAge(),
        ':cgpa' => $student->getCgpa(),
      ]);
    } catch (PDOException) {
      $this->lastError = 'Failed to create student record.';
      return false;
    }
  }

  public function update(\Student $student, int|string $id): ?bool
  {
    $this->lastError = '';

    if ($id === null) {
      $this->lastError = 'Student id is required.';
      return false;
    }

    $existingStudent = $this->get($id);

    if (!$existingStudent) {
      $this->lastError = 'Student not found.';
      return false;
    }

    $this->sanitizeStudentData($student);

    $firstName = $student->getFirstName() !== null ? $student->getFirstName() : $existingStudent->getFirstName();
    $lastName = $student->getLastName() !== null ? $student->getLastName() : $existingStudent->getLastName();
    $registrationNumber = $student->getRegistrationNumber() !== null ? $student->getRegistrationNumber() : $existingStudent->getRegistrationNumber();
    $studentNumber = $student->getStudentNumber() !== null ? $student->getStudentNumber() : $existingStudent->getStudentNumber();
    $age = $student->getAge() !== null ? $student->getAge() : $existingStudent->getAge();
    $cgpa = $student->getCgpa() !== null ? $student->getCgpa() : $existingStudent->getCgpa();

    $updatedStudent = new \Student(
      $firstName,
      $lastName,
      $registrationNumber,
      $studentNumber,
      $age,
      $cgpa
    );

    $validationError = $this->validateStudentData($updatedStudent);
    if ($validationError !== null) {
      $this->lastError = $validationError;
      return false;
    }

    if ($this->isRegistrationNumberTaken($registrationNumber, (int) $id)) {
      $this->lastError = 'Registration number already exists.';
      return false;
    }

    if ($this->isStudentNumberTaken($studentNumber, (int) $id)) {
      $this->lastError = 'Student number already exists.';
      return false;
    }

    $stmt = $this->conn->prepare(
      "UPDATE students
             SET first_name = :first_name,
                 last_name = :last_name,
                 registration_number = :registration_number,
                 student_number = :student_number,
                 age = :age,
                 cgpa = :cgpa
             WHERE id = :id"
    );

    try {
      return $stmt->execute([
        ':first_name' => $firstName,
        ':last_name' => $lastName,
        ':registration_number' => $registrationNumber,
        ':student_number' => $studentNumber,
        ':age' => $age,
        ':cgpa' => $cgpa,
        ':id' => $id,
      ]);
    } catch (PDOException $e) {
      $this->lastError = 'Failed to update student record.';
      return false;
    }
  }

  public function destroy(int $id): ?bool
  {
    $this->lastError = '';

    if ($id === null || !is_numeric($id) || (int) $id <= 0) {
      $this->lastError = 'Valid student id is required.';
      return false;
    }

    $stmt = $this->conn->prepare("DELETE FROM students WHERE id = :id");
    $studentId = (int) $id;
    $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);

    try {
      return $stmt->execute();
    } catch (PDOException $e) {
      $this->lastError = 'Failed to delete student record.';
      return false;
    }
  }

  private function sanitizeStudentData(\Student $student): void
  {
    if ($student->getFirstName() !== null) {
      $student->setFirstName($this->sanitizeText($student->getFirstName()));
    }
    if ($student->getLastName() !== null) {
      $student->setLastName($this->sanitizeText($student->getLastName()));
    }
    if ($student->getRegistrationNumber() !== null) {
      $student->setRegistrationNumber($this->sanitizeText($student->getRegistrationNumber()));
    }
    if ($student->getStudentNumber() !== null) {
      $student->setStudentNumber($this->sanitizeText($student->getStudentNumber()));
    }
    if ($student->getAge() !== null) {
      $student->setAge((int) $student->getAge());
    }
    if ($student->getCgpa() !== null) {
      $student->setCgpa((float) $student->getCgpa());
    }
  }

  private function sanitizeText(int|string $value): string
  {
    return trim(strip_tags((string) $value));
  }

  private function validateStudentData(\Student $student): ?string
  {
    if ($student->getFirstName() === '' || $student->getLastName() === '') {
      return 'First name and last name are required.';
    }

    if ($student->getRegistrationNumber() === '' || $student->getStudentNumber() === '') {
      return 'Registration number and student number are required.';
    }

    $age = $student->getAge();
    if (!is_int($age) || $age < 1 || $age > 120) {
      return 'Age must be between 1 and 120.';
    }

    $cgpa = $student->getCgpa();
    if (!is_numeric($cgpa) || $cgpa < 0 || $cgpa > 4) {
      return 'CGPA must be between 0.00 and 4.00.';
    }

    return null;
  }

  /**
   * Get all students from the database.
   *
   * @param $excludeId=null 
   */
  private function isRegistrationNumberTaken(int|string $registrationNumber, $excludeId = null): bool
  {
    $query = "SELECT COUNT(*) FROM students WHERE registration_number = :registration_number";
    if ($excludeId !== null) {
      $query .= " AND id <> :exclude_id";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':registration_number', $registrationNumber);
    if ($excludeId !== null) {
      $stmt->bindParam(':exclude_id', $excludeId, PDO::PARAM_INT);
    }
    $stmt->execute();

    return (int) $stmt->fetchColumn() > 0;
  }
  /**
   * Get all students from the database.
   *
   * @param $excludeId=null
   */
  private function isStudentNumberTaken(int|string $studentNumber, $excludeId = null): bool
  {
    $query = "SELECT COUNT(*) FROM students WHERE student_number = :student_number";
    if ($excludeId !== null) {
      $query .= " AND id <> :exclude_id";
    }

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':student_number', $studentNumber);
    if ($excludeId !== null) {
      $stmt->bindParam(':exclude_id', $excludeId, PDO::PARAM_INT);
    }
    $stmt->execute();

    return (int) $stmt->fetchColumn() > 0;
  }
}