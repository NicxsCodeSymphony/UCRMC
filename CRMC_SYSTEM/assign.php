<?php
session_start();
include 'connection.php';


$conn = new Connection();
$pdo = $conn->openConnection();

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['teacherID'])){
    $teacherID = $_GET['teacherID'];

     $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("SELECT * FROM teacher WHERE teacherID = ?");
    $stmt->execute([$teacherID]);
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn->closeConnection();
}


// $stmtCourse = $pdo->query("SELECT * FROM course");
// $courses = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);

// $stmtCourse = $pdo->query("SELECT * FROM department");
// $courseses = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);
function getDepartmentName($departmentID)
{
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("SELECT departmentName FROM department WHERE departmentID = ?");
    $stmt->execute([$departmentID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn->closeConnection();

    return $result['departmentName'];
}




if ($conn) {
    // Get the department ID from the department table (replace 'department' with your actual department table name)
    $departmentID = $teacher['departmentID']; // Replace 2 with the actual department ID you want to retrieve courses for

    // Query to get courses based on the department ID using a JOIN
    $query = "SELECT course.* FROM course
              INNER JOIN department ON course.departmentID = department.departmentID
              WHERE department.departmentID = :departmentID";

    // Prepare the statement
    $statement = $pdo->prepare($query);

    // Bind the department ID parameter
    $statement->bindParam(':departmentID', $departmentID, PDO::PARAM_INT);

    // Execute the query
   $statement->execute();
}   


if ($conn) {
    // Get the department ID from the department table (replace 'department' with your actual department table name)
    $courseIDs = $_GET['courseID']; // Replace 2 with the actual department ID you want to retrieve courses for

    // Query to get courses based on the department ID using a JOIN
    $query1 = "SELECT subject.* FROM subject
              INNER JOIN course ON subject.courseID = course.courseID
              WHERE course.courseID = :courseID";

    // Prepare the statement
    $statement1 = $pdo->prepare($query1);

    // Bind the department ID parameter
    $statement1->bindParam(':courseID', $courseIDs, PDO::PARAM_INT);

    // Execute the query
   $statement1->execute();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignTeacher'])) {
    $teacherID = $_POST['teacherID'];
    $course = $_POST['course'];
    $subject = $_POST['subject'];

    // Update the course in the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("UPDATE teacher SET courseID = ?, subjectID = ? WHERE teacherID = ?");
    $stmt->execute([$course, $subject, $teacherID]);

    $conn->closeConnection();

    // Redirect back to the main page or perform any other action
    header("Location: manage.php");
    exit();
}

$stmtCourse = $pdo->query("SELECT * FROM subject");
$subject = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRMC | Update teacher</title>
    <link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>

    <style>
       
    body{
        font-family: 'Rubik', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            height: 100vh;
            color: #424241;
    }

    input{
        border: none;
        background: transparent;
        font-size: 16px;
        width: 20%;
        color: #424241;
    }

    .header{
        position: relative;
        top: 170px;
        left: 0;
    }


    .form-header{
        width: 100%;
        display: flex;
        /* flex-direction: column; */
        justify-content: center;
    }

    .form-header-second{
        width: 100%;
        display: flex;
        /* flex-direction: column; */
        justify-content: center;
        margin-top: 15px;
        margin-left: 10px;
    }

    .form-header input{
        font-size: 40px;
        text-align: center;
    }

    form{
        background-color: #dfe8f0;
            padding: 30px 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 50%;
            margin: 20px auto;
            height: 85vh;
    }

    .main-content{
        padding: 0 20px;
    }

    .circle{
        margin-top: 38vh;
        background: #4e4e4e;
        height: 5vh;
        width: 100%;
        display: flex;
        align-items: center;
        color: #fff;
        padding-left: 20px;
        border-radius: 30px;
    }

    .fcontainer,.container{
        margin: 20px 25px 10px 25px;
    }


    .container{
        margin-top: 30px;
    }


    .fcontainer input, .container input{
        width: 50%;
        font-size: 18px;
        z-index: 999;
    }
    .account{
        height: 10vh;
        width: 50%;
        position: absolute;
        top: 39%;
        left: 38%;
    }

    .account select{
        border: none;
        background: transparent;
        font-size: 18px;
    }

    .photo{
        position: absolute;
        top: 0;
        width: 0;
        right: 58%;
    }

    label{
        font-size: 18px;
    }

    .add-logo-container {
            text-align: center;
        }

        .add-logo-button {
            display: inline-block;
            padding: 5px;
            /* background-color: #007bff; */
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
        }

        .add-logo-preview {
            max-width: 170px;
            max-height: 170px;
            margin-top: 8px;
            border-radius: 50%;
        }
button {
  padding: 0.1em 0.25em;
  width: 10em;
  height: 4.2em;
  background-color: #212121;
  border: 0.08em solid #fff;
  border-radius: 0.3em;
  font-size: 12px;
  cursor: pointer;
  position: relative;
  bottom:80%;
  left: 80%;
}

button span {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  bottom: 0.4em;
  width: 6em;
  height: 2.5em;
  background-color: #212121;
  border-radius: 0.2em;
  font-size: 1.5em;
  color: #fff;
  border: 0.08em solid #fff;
  box-shadow: 0 0.4em 0.1em 0.019em #fff;
}

button span:hover {
  transition: all 0.5s;
  transform: translate(0, 0.4em);
  box-shadow: 0 0 0 0 #fff;
}

button span:not(hover) {
  transition: all 1s;
}


    </style>
</head>
<body>


<form method="POST" action="assign.php" enctype="multipart/form-data">

    <input type="hidden" name="teacherID" value="<?= $teacher['teacherID'] ?>">

    <div class="header">

    <div class="form-header">
    <div class="form-header">
    <input type="text" style="width: 100%;" name="fullName" value="<?= $teacher['firstName'] . ' ' . $teacher['lastName'] ?>">

</div>

    </div>

    <!-- <div class="form-header-second">
        <input style="width: 65px; margin-left: 10px" type="text" name="age" value="<?= $teacher['age']?>"> <span style="position: relative; right: 40px; top: 2px;">Years Old</span>
        <input style="position: relative; right: 30px;" type="text" name="age" value="(<?= $teacher['birthdate']?>)">
    </div> -->
    </div>


    <div class="main-content">
        <div class="circle">Assign Teacher</div>
        <h1></h1>

     <div class="container">
    <label for="courseSelect">Course:</label>
    <select name="course" id="course">
        <option value=""></option>
        <?php
        // Check if there's a courseID in the URL
        if (isset($_GET['courseID'])) {
            $selectedCourseID = $_GET['courseID'];
            // Fetch the course details based on the courseID
            $stmtCourse = $pdo->prepare("SELECT * FROM course WHERE courseID = ?");
            $stmtCourse->execute([$selectedCourseID]);
            $selectedCourse = $stmtCourse->fetch(PDO::FETCH_ASSOC);


        // Output the select tag with the populated options
echo '<option value="" disabled>Choose a Course</option>'; // Display an empty option

while ($row = $statement->fetch()) {
    $selected = ($teacher['courseID'] == $row['courseID']) ? 'selected' : '';
    echo '<option value="' . $row['courseID'] . '" ' . $selected . '>' . $row['courseName'] . '</option>';
}
}
        ?>
    </select>
</div>

    

  <div class="container">
    <label for="courseSelect">Subject:</label>
     <select name="subject">
         <?php foreach($subject as $subjects):?>
            <?php if($subjects['courseID'] == $teacher['subjectID']) ?>
            <option value="<?= $subjects['subjectID'] ?>"><?= $subjects['subjectName'] ?></option>
         <?php endforeach; ?>
     </select>
</div>



        <!-- Course select -->



    
        
   <div class="account" id="accountInfo">
    <div style="position: relative; top: 10px;" class="fcontainer">
        <?php
        // Display the departmentName based on the selected departmentID
        if (isset($teacher['departmentID'])) {
            $selectedDepartmentID = $teacher['departmentID'];
            $selectedDepartmentName = getDepartmentName($selectedDepartmentID);
            echo "$selectedDepartmentName";
        }
        ?>
    </div>
</div>


    <div class="photo">
            <input type="file" name="updateLogoInput" id="updateLogoInput" accept="image/*" onchange="handleUpdateLogoInputChange()">
            <label for="updateLogoInput" class="add-logo-button">
                <img src="<?= $teacher['photo']; ?>" alt="Department Logo" class="add-logo-preview" id="updateLogoPreview">
            </label>
        </div>



    <button name="assignTeacher"><span> Update</span></button>
    </form>


    






    <script>
         document.getElementById('updateLogoInput').addEventListener('change', handleUpdateLogoInputChange);

function handleUpdateLogoInputChange() {
    const logoInput = document.getElementById('updateLogoInput');
    const updateLogoPreview = document.getElementById('updateLogoPreview');

    if (logoInput.files.length > 0) {
        const selectedImage = URL.createObjectURL(logoInput.files[0]);
        updateLogoPreview.src = selectedImage;
        updateLogoPreview.style.display = 'block'; // Show the image
    }
}


// document.getElementById('course').addEventListener('change', function() {
//     // Get the selected value
//     var selectedValue = this.value;

//     // Get the current URL
//     var currentUrl = window.location.href;

//     // Check if there is already a teacherID parameter in the URL
//     var hasTeacherID = currentUrl.includes('teacherID');

//     // Construct the new URL based on the selected course and current teacherID
//     var newUrl;
//     if (hasTeacherID) {
//         newUrl = currentUrl.replace(/(courseID=)[^\&]+/, '$1' + selectedValue);
//     } else {
//         newUrl = currentUrl + '&courseID=' + selectedValue;
//     }

//     // Redirect to the new URL
//     window.location.href = newUrl;
// });

    </script>

</body>
</html>
