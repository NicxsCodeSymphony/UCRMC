<?php

// Fetch departments from the database
$conn = new Connection();
$pdo = $conn->openConnection();


$stmt = $pdo->query("SELECT * FROM teacher");
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtSubjects = $pdo->query("SELECT * FROM subject");
$subjects = $stmtSubjects->fetchAll(PDO::FETCH_ASSOC);

$stmtCourse = $pdo->query("SELECT * FROM course");
$courseses = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);




$conn->closeConnection();

if (isset($_POST['updateTeacherForm'])) {
    $departmentID = $_POST['teacherID'];
    $conn = new Connection();
    $pdo = $conn->openConnection();
    $stmt = $pdo->prepare("DELETE FROM teacher WHERE teacherID = ?");
    $stmt->execute([$departmentID]);
    $conn->closeConnection();
}


$stmt = $pdo->query("SELECT teacher.*, department.departmentName 
                    FROM teacher 
                    JOIN department ON teacher.departmentID = department.departmentID");
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn->closeConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the request is made using POST method

    // Get the department ID from the POST data
    $teacherID = $_POST['teacherID'];

    // Delete the department from the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("DELETE FROM teacher WHERE teacherID = ?");
    $stmt->execute([$teacherID]);

    $conn->closeConnection();
}



