<?php


$newconnection = new Connection();
$pdo = $newconnection->openConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departmentID = $_POST['courseID'];

    // Delete the department from the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("DELETE FROM course WHERE courseName = ?");
    $stmt->execute([$departmentID]);

    $conn->closeConnection();
}

// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted for adding a course
    if (isset($_POST['addCourse'])) {
        // Get the department ID and course name from the POST data
        $departmentID = $_POST['departmentID'];
        $courseName = $_POST['courseName'];

        // Insert data into the database
        $stmt = $pdo->prepare("INSERT INTO course (departmentID, courseName) VALUES (?, ?)");
        $stmt->execute([$departmentID, $courseName]);
    }

    // Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted for deleting a course
    if (isset($_POST['deleteCourse'])) {
        // Get the course ID from the POST data
        $courseID = $_POST['courseID'];

        // Delete the course from the database
        $stmt = $pdo->prepare("DELETE FROM course WHERE courseID = ?");
        $stmt->execute([$courseID]);
    }

    // ... (your existing code for adding a department, handling image upload, etc.)

    // Redirect back to the main page or perform any other action
    header("Location: course.php");
    exit();
}


    // ... (your existing code for adding a department, handling image upload, etc.)

    // Redirect back to the main page or perform any other action
    header("Location: course.php");
    exit();
}

// Function to fetch departments and courses from the database
function getDepartmentsAndCoursesFromDatabase($connection)
{
    try {
        $conn = $connection->openConnection();

        $sql = "SELECT d.departmentID, d.departmentName, d.departmentLogo, c.courseID, c.courseName
                FROM department d
                LEFT JOIN course c ON d.departmentID = c.departmentID";
        $result = $conn->query($sql);

        $departmentsWithCourses = [];

        if ($result->rowCount() > 0) {
            // Fetch data and store it in an array
            while ($row = $result->fetch()) {
                $departmentsWithCourses[$row['departmentID']][] = $row;
            }
        }

        $connection->closeConnection();

        return $departmentsWithCourses;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

$departmentsWithCourses = getDepartmentsAndCoursesFromDatabase($newconnection);
$stmt = $pdo->query("SELECT departmentID, departmentName FROM department");
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT * FROM course");
$course = $stmt->fetchAll(PDO::FETCH_ASSOC);