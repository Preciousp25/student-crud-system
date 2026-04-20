<?php

class Database {
    private $host = "localhost";
    private $db_name = "student_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnection() {
        $this->conn = null;
 
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->ensureStudentsSchema();

        } catch (PDOException $e) {
            echo "Connection error: " . $e->getMessage();
        }

        return $this->conn;
    }

    private function ensureStudentsSchema() {
        $query = "CREATE TABLE IF NOT EXISTS students (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    first_name VARCHAR(100) NOT NULL,
                    last_name VARCHAR(100) NOT NULL,
                    registration_number VARCHAR(100) NOT NULL,
                    student_number VARCHAR(100) NOT NULL,
                    age INT NOT NULL,
                    cgpa DECIMAL(3,2) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

        $this->conn->exec($query);

        $columns = [
            "first_name" => "ALTER TABLE students ADD COLUMN first_name VARCHAR(100) NOT NULL DEFAULT ''",
            "last_name" => "ALTER TABLE students ADD COLUMN last_name VARCHAR(100) NOT NULL DEFAULT ''",
            "registration_number" => "ALTER TABLE students ADD COLUMN registration_number VARCHAR(100) NOT NULL DEFAULT ''",
            "student_number" => "ALTER TABLE students ADD COLUMN student_number VARCHAR(100) NOT NULL DEFAULT ''",
            "age" => "ALTER TABLE students ADD COLUMN age INT NOT NULL DEFAULT 0",
            "cgpa" => "ALTER TABLE students ADD COLUMN cgpa DECIMAL(3,2) NOT NULL DEFAULT 0.00"
        ];

        foreach ($columns as $columnName => $alterQuery) {
            $checkQuery = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
                           WHERE TABLE_SCHEMA = :db_name
                             AND TABLE_NAME = 'students'
                             AND COLUMN_NAME = :column_name";

            $stmt = $this->conn->prepare($checkQuery);
            $stmt->bindParam(':db_name', $this->db_name);
            $stmt->bindParam(':column_name', $columnName);
            $stmt->execute();

            if ((int) $stmt->fetchColumn() === 0) {
                $this->conn->exec($alterQuery);
            }
        }

        $this->ensureUniqueIndex('students', 'registration_number', 'uq_students_registration_number');
        $this->ensureUniqueIndex('students', 'student_number', 'uq_students_student_number');
    }

    private function ensureUniqueIndex($tableName, $columnName, $indexName) {
        $checkQuery = "SELECT COUNT(*) FROM INFORMATION_SCHEMA.STATISTICS
                       WHERE TABLE_SCHEMA = :db_name
                         AND TABLE_NAME = :table_name
                         AND INDEX_NAME = :index_name";

        $stmt = $this->conn->prepare($checkQuery);
        $stmt->bindParam(':db_name', $this->db_name);
        $stmt->bindParam(':table_name', $tableName);
        $stmt->bindParam(':index_name', $indexName);
        $stmt->execute();

        if ((int) $stmt->fetchColumn() === 0) {
            $this->conn->exec("CREATE UNIQUE INDEX " . $indexName . " ON " . $tableName . " (" . $columnName . ")");
        }
    }
}