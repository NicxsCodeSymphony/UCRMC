<?php

// Fetch departments from the database
$conn = new Connection();
$pdo = $conn->openConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the request is made using POST method

    // Get the department ID from the POST data
    $departmentID = $_POST['departmentID'];

    // Delete the department from the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("DELETE FROM department WHERE departmentID = ?");
    $stmt->execute([$departmentID]);

    $conn->closeConnection();
}

$stmt = $pdo->query("SELECT * FROM department");
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn->closeConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form is submitted using POST method

    $departmentName = $_POST['departmentName'];

    // Handle image upload
    $imageURL = ''; // Default value
    if (isset($_FILES['logoInput']) && $_FILES['logoInput']['error'] == 0) {
        $targetDir = "uploads/"; // Directory where you want to store the uploaded images
        $targetFile = $targetDir . basename($_FILES['logoInput']['name']);
        
        // Ensure the target directory exists, create it if not
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['logoInput']['tmp_name'], $targetFile)) {
            $imageURL = $targetFile;
        }
    }

    // Insert data into the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("INSERT INTO department (departmentName, departmentLogo) VALUES (?, ?)");
    $stmt->execute([$departmentName, $imageURL]);
    $conn->closeConnection();

    // Store information for displaying after the redirect
    $_SESSION['departmentAdded'] = true;
    $_SESSION['newDepartmentLogo'] = $imageURL;

    // Redirect back to the main page or perform any other action
    header("Location: department.php");
    exit();
}