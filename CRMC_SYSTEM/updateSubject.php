<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['subjectName'])) {
    $subjectName = $_GET['subjectName'];

    // Fetch the existing course data
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("SELECT * FROM subject WHERE subjectName = ?");
    $stmt->execute([$subjectName]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn->closeConnection();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateCourse'])) {
    $subjectName = $_POST['subjectName'];
    $updatesubjectName = $_POST['updatesubjectName'];

    // Update the course in the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("UPDATE subject SET subjectName = ? WHERE subjectName = ?");
    $stmt->execute([$updatesubjectName, $subjectName]);

    $conn->closeConnection();

    // Redirect back to the main page or perform any other action
    header("Location: subject.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRMC | Update course</title>
    <style>
        body {
            font-family: 'Rubik', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .add-logo-container {
            text-align: center;
        }

        .add-logo-button {
            display: inline-block;
            padding: 8px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-logo-preview {
            max-width: 100px;
            max-height: 100px;
            margin-top: 8px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h1>Update course</h1>

    <form method="POST" action="updateSubject.php" enctype="multipart/form-data">
        <input type="hidden" name="subjectName" value="<?= $course['subjectName']; ?>">
        <label for="updatesubjectName">Update Subject Name:</label>
        <input type="text" name="updatesubjectName" value="<?= $course['subjectName']; ?>" required>

        <button type="submit" name="updateCourse">Update</button>
    </form>


</body>
</html>
