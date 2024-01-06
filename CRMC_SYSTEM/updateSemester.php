<?php


session_start();
include 'connection.php';
    // Fetch the existing course data
    $conn = new Connection();
    $pdo = $conn->openConnection();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['semesterID'])) {
    $semesterID = $_GET['semesterID'];



    $stmt = $pdo->prepare("SELECT * FROM semester WHERE semesterID = ?");
    $stmt->execute([$semesterID]);
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn->closeConnection();
}

$stmtCourse = $pdo->query("SELECT * FROM subject");
$subjects = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateCourse'])) {
    $semesterID = $_POST['semesterID'];
    $semester = $_POST['semester'];
    $yearLevel = $_POST['level'];
    $subject = $_POST['subject'];

    // Update the course in the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("UPDATE semester SET semester = ?, yearLevel = ?, subjectID = ? WHERE semesterID  = ?");
    $stmt->execute([$semester, $yearLevel, $subject, $semesterID]);

    $conn->closeConnection();

    // Redirect back to the main page or perform any other action
    header("Location: semester.php");
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

    <form method="POST" action="updateSemester.php" enctype="multipart/form-data">
        <input type="hidden" name="semesterID" value="<?= $course['semesterID']; ?>">
        <label for="updatesemesterID">Semester:</label>
        <input type="text" name="semester" value="<?= $course['semester']; ?>" required>

        <label for="updatesemesterID">Year Label</label>
        <input type="text" name="level" value="<?= $course['yearLevel']; ?>" required>

                    <label for="departmentID">Select Subject:</label>
            <select name="subject" id="departmentID" class="select-input">
                <?php foreach ($subjects as $dept): ?>
                    <option value="<?= $dept['subjectID']; ?>"><?= $dept['subjectName']; ?></option>
                <?php endforeach; ?>
            </select>

        <button type="submit" name="updateCourse">Update</button>
    </form>


</body>
</html>
