<?php

// Fetch departments from the database
$conn = new Connection();
$pdo = $conn->openConnection();


$stmt = $pdo->query("SELECT * FROM student");
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtSubjects = $pdo->query("SELECT * FROM subject");
$subjects = $stmtSubjects->fetchAll(PDO::FETCH_ASSOC);

$stmtCourse = $pdo->query("SELECT * FROM course");
$courseses = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);




$conn->closeConnection();

if (isset($_POST['updatestudentForm'])) {
    $departmentID = $_POST['studentID'];
    $conn = new Connection();
    $pdo = $conn->openConnection();
    $stmt = $pdo->prepare("DELETE FROM student WHERE studentID = ?");
    $stmt->execute([$departmentID]);
    $conn->closeConnection();
}


$stmt = $pdo->query("SELECT student.*, department.departmentName 
                    FROM student 
                    JOIN department ON student.departmentID = department.departmentID");
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn->closeConnection();




// In studentCommands.php or a relevant file
function getCourseNameById($courseID, $courses) {
    // Iterate through the fetched courses to find the matching courseID
    foreach ($courses as $course) {
        if ($course['courseID'] == $courseID) {
            return $course['courseName']; // Assuming 'courseName' is the column name for the course name
        }
    }

    // Return a default value or handle the case where the courseID is not found
    return "Unknown Course";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteTeacher'])) {
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the request is made using POST method

    // Get the department ID from the POST data
    $studentID = $_POST['studentID'];

    // Delete the department from the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("DELETE FROM student WHERE studentID = ?");
    $stmt->execute([$studentID]);

    $conn->closeConnection();
}
