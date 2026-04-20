<?php

class Student {
    private $id;
    private $firstName;
    private $lastName;
    private $registrationNumber;
    private $studentNumber;
    private $age;
    private $cgpa;

    public function __construct(
        $firstName = null,
        $lastName = null,
        $registrationNumber = null,
        $studentNumber = null,
        $age = null,
        $cgpa = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->registrationNumber = $registrationNumber;
        $this->studentNumber = $studentNumber;
        $this->age = $age;
        $this->cgpa = $cgpa;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFirstName() {
        return $this->firstName;
    }

    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    public function getRegistrationNumber() {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber($registrationNumber) {
        $this->registrationNumber = $registrationNumber;
    }

    public function getStudentNumber() {
        return $this->studentNumber;
    }

    public function setStudentNumber($studentNumber) {
        $this->studentNumber = $studentNumber;
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function getCgpa() {
        return $this->cgpa;
    }

    public function setCgpa($cgpa) {
        $this->cgpa = $cgpa;
    }
}
