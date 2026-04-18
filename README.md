# Student CRUD System

A simple, secure, and responsive **Student Management System** built using **pure PHP (OOP)** and **MySQL (PDO)**.  
This project demonstrates CRUD operations, database interaction, and basic web security principles without using any frameworks.

---

## Features

- Add new students
- View all students
- Edit student details
- Delete student records
- Secure database interactions using PDO (Prepared Statements)
- Object-Oriented PHP (OOP) structure
- Clean and responsive user interface
- Lightweight system (no frameworks used)

---

## Technologies Used

- PHP (OOP)
- MySQL
- PDO (Prepared Statements)
- HTML5
- CSS3
- XAMPP (Local Server)

---

## Project Overview

This system follows a simple MVC-like structure to show separation of concerns

- **config/** → Database connection
- **classes/** → Core logic (Student class)
- **actions/** → CRUD operations (Create, Update, Delete)
- **index.php** → Display all students
- **add.php** → Add new student form
- **edit.php** → Update student data

---

##  Security Features

- Uses **PDO prepared statements** to prevent SQL injection
- Output sanitization using `htmlspecialchars()`
- Basic input validation
- Separation of logic using OOP principles

---
Database Setup

This project requires a MySQL database to run correctly. Without this setup, the system will not function.

 Step 1: Create Database

Open phpMyAdmin:

http://localhost/phpmyadmin

Create a database named:student_db


 Step 2: Create Table

Run the following SQL query inside the database:

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    course VARCHAR(100) NOT NULL
);

---
## Learning Objectives

This project was developed to demonstrate:

- PHP CRUD operations
- Object-Oriented Programming (OOP)
- Database connectivity using PDO
- Form handling in PHP
- Basic web application architecture
- Secure coding practices



