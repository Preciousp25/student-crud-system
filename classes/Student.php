<?php

class Student {
    private $conn;
    private $table = "students";

    public $id;
    public $fullname;
    public $email;
    public $course;

    public function __construct($db) {
        $this->conn = $db;
    }

    // DATA SANITIZATION
   
    private function sanitize() {
        $this->fullname = htmlspecialchars(strip_tags($this->fullname));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->course = htmlspecialchars(strip_tags($this->course));
    }

    // CREATE
    
    public function create() {

        $this->sanitize();

        $query = "INSERT INTO " . $this->table . "
                  (fullname, email, course)
                  VALUES (:fullname, :email, :course)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":course", $this->course);

        return $stmt->execute();
    }

    // READ ALL
    
    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // GET ONE (IMPROVES SoC)
    
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE METHOD
    
    public function update() {

        $this->sanitize();

        $query = "UPDATE " . $this->table . "
                  SET fullname = :fullname,
                      email = :email,
                      course = :course
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":fullname", $this->fullname);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":course", $this->course);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    //DELETE METHOD

    public function delete() {

        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }
}