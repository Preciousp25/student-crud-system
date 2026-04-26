<?php

class Student
{
  private ?int $id;
  private ?string $firstName;
  private ?string $lastName;
  private ?string $registrationNumber;
  private ?string $studentNumber;
  private ?int $age;
  private ?float $cgpa;

  public function __construct(
    ?string $firstName = null,
    ?string $lastName = null,
    ?string $registrationNumber = null,
    ?string $studentNumber = null,
    ?int $age = null,
    ?float $cgpa = null
  ) {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->registrationNumber = $registrationNumber;
    $this->studentNumber = $studentNumber;
    $this->age = $age;
    $this->cgpa = $cgpa;
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(int $id): void
  {
    $this->id = $id;
  }

  public function getFirstName(): ?string
  {
    return $this->firstName;
  }

  public function setFirstName(string $firstName): void
  {
    $this->firstName = $firstName;
  }

  public function getLastName(): ?string
  {
    return $this->lastName;
  }

  public function setLastName(string $lastName): void
  {
    $this->lastName = $lastName;
  }

  public function getRegistrationNumber(): ?string
  {
    return $this->registrationNumber;
  }

  public function setRegistrationNumber(string $registrationNumber): void
  {
    $this->registrationNumber = $registrationNumber;
  }

  public function getStudentNumber(): ?string
  {
    return $this->studentNumber;
  }

  public function setStudentNumber(string $studentNumber): void
  {
    $this->studentNumber = $studentNumber;
  }

  public function getAge(): ?int
  {
    return $this->age;
  }

  public function setAge(int $age): void
  {
    $this->age = $age;
  }

  public function getCgpa(): ?float
  {
    return $this->cgpa;
  }

  public function setCgpa(float $cgpa): void
  {
    $this->cgpa = $cgpa;
  }
}
