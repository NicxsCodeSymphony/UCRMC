<?php

// Fetch semesters from the database
$conn = new Connection();
$pdo = $conn->openConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the request is made using POST method

    // Get the semester ID from the POST data
    $semesterID = $_POST['semesterID'];

    // Delete the semester from the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("DELETE FROM semester WHERE semesterID = ?");
    $stmt->execute([$semesterID]);

    $conn->closeConnection();
}

$stmt = $pdo->query("SELECT * FROM semester");
$semesters = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn->closeConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form is submitted using POST method

    $semester = $_POST['semester'];

    // Handle image upload

    // Insert data into the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("INSERT INTO semester (semester) VALUES (?)");
    $stmt->execute([$semester, $imageURL]);
    $conn->closeConnection();

    // Store information for displaying after the redirect
    $_SESSION['semesterAdded'] = true;

    // Redirect back to the main page or perform any other action
    header("Location: semester.php");
    exit();
}