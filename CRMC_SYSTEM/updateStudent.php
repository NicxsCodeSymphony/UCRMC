<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['studentID'])) {
    $studentID = $_GET['studentID'];

    // Fetch the existing department data
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("SELECT * FROM student WHERE studentID = ?");
    $stmt->execute([$studentID]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    $conn->closeConnection();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateStudent'])) {
    $studentID = $_POST['studentID'];
    $fullName = $_POST['fullName'];
    $departmentID = $_POST['departmentID'];
    $courseID = $_POST['courseID'];
    $birthdate = $_POST['birthdate'];
    $age = $_POST['age'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];

// Separate full name into first name and last name
list($updateStudentFirstName, $updateStudentLastName) = explode(' ', $fullName, 2);

// Check if both first name and last name are set
if (!$updateStudentFirstName || !$updateStudentLastName) {
    // Handle the error or redirect as needed
    header("Location: studentInfo.php?error=InvalidFullName");
    exit();
}


    // Check if a new logo is being uploaded
    if (isset($_FILES['updateLogoInput']) && $_FILES['updateLogoInput']['size'] > 0) {
        // New logo is uploaded
        $updateImageName = $_FILES['updateLogoInput']['name'];
        $updateImageTmpName = $_FILES['updateLogoInput']['tmp_name'];
        $updateImageURL = 'uploads/' . $updateImageName;

        // Move the uploaded file to the desired directory
        move_uploaded_file($updateImageTmpName, $updateImageURL);

        $conn = new Connection();
        $pdo = $conn->openConnection();

        $stmt = $pdo->prepare("UPDATE student SET firstName = ?, lastName = ?, photo = ?, birthdate = ?, age = ?, email = ?, password = ?, contact = ?, address = ?, departmentID = ?, courseID = ? WHERE studentID = ?");
        $stmt->execute([$updateStudentFirstName, $updateStudentLastName, $updateImageURL, 
        $birthdate, $age, $email, $password, $contact, $address, $departmentID, $courseID, $studentID]);

        $conn->closeConnection();
    } else {
        // No new logo is uploaded, update only the department name
        $conn = new Connection();
        $pdo = $conn->openConnection();

        $stmt = $pdo->prepare("UPDATE student SET firstName = ?, lastName = ?, birthdate = ?, age = ?, email = ?, password = ?, contact = ?, address = ?, departmentID = ?, courseID = ? WHERE studentID = ?");
        $stmt->execute([$updateStudentFirstName, $updateStudentLastName,
        $birthdate, $age, $email, $password, $contact, $address, $departmentID, $courseID, $studentID]);

        $conn->closeConnection();
    }

    // Redirect back to the main page or perform any other action
    header("Location: studentInfo.php");
    exit();
} else {
    // Invalid request, redirect to the main page or handle the error
    header("Location: studentInfo.php");
    exit();
}

$stmt = $pdo->query("SELECT student.*, department.departmentName 
                    FROM student 
                    JOIN department ON student.departmentID = department.departmentID");
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtCourse = $pdo->query("SELECT * FROM department");
$courseses = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);

$stmtCourse = $pdo->query("SELECT * FROM course");
$course = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRMC | Update student</title>
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
        margin-top: 15px;
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
        top: 43%;
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
  bottom:95%;
  left: 85%;
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


<form method="POST" action="updateStudent.php" enctype="multipart/form-data">

    <input type="hidden" name="studentID" value="<?= $student['studentID'] ?>">

    <div class="header">

    <div class="form-header">
    <div class="form-header">
    <input type="text" style="width: 100%;" name="fullName" value="<?= $student['firstName'] . ' ' . $student['lastName'] ?>">

</div>

    </div>

    <!-- <div class="form-header-second">
        <input style="width: 65px; margin-left: 10px" type="text" name="age" value="<?= $student['age']?>"> <span style="position: relative; right: 40px; top: 2px;">Years Old</span>
        <input style="position: relative; right: 30px;" type="text" name="age" value="(<?= $student['birthdate']?>)">
    </div> -->
    </div>


    <div class="main-content">
        <div class="circle">About Myself</div>
    

  
        <div class="container">
        <label for="">Birthday:</label>
        <input style="margin-left: 21%;" id="birthdate" type="date" onchange="calculateAge()" name="birthdate" value="<?= $student['birthdate'] ?>">
    </div>
    <div class="container">
        <label for="">Age:</label>
        <input style="margin-left: 27%;" type="number" id="age" name="age" value="<?= $student['age'] ?>">
    </div>

    <div class="container">
        <label for="">Email:</label>
        <input style="margin-left: 25%;" type="text" name="email" value="<?= $student['email'] ?>">
    </div>

    <div class="container">
        <label for="">Password:</label>
        <input type="text" style="margin-left: 20%;" name="password" value="<?= $student['password'] ?>">
    </div>

    <div class="container">
        <label for="">Contact Number:</label>
        <input style="margin-left: 12%;" type="text" name="contact" value="<?= $student['contact'] ?>">
    </div>

    <div class="container">
        <label for="">Address:</label>
        <input style="margin-left: 22%;" type="text" name="address" value="<?= $student['address'] ?>">
    </div>

   </div>


    
        
   <div class="account">
    <div style="position: relative; top: 10px; right: 150px;" class="fcontainer">
    <select name="departmentID" onchange="updateCourseID(this)">
        <?php foreach ($courseses as $department): ?>
            <?php if ($student['departmentID'] == $department['departmentID']): ?>
                <option value="<?= $department['departmentID']; ?>" selected><?= $department['departmentName']; ?></option>
            <?php else: ?>
                <option value="<?= $department['departmentID']; ?>"><?= $department['departmentName']; ?></option>
            <?php endif; ?>
        <?php endforeach; ?>
    </select>
    </div>
</div>

<div class="account">
    <div style="position: relative; top: 10px; left: 180px;" class="fcontainer">
        <select style="width: 250px;" name="courseID" onchange="updateCourseID(this)">
            <?php foreach ($course as $courses): ?>
                <?php $courseName = str_replace('Bachelor of Science in ', '', $courses['courseName']); ?>
                <?php if ($student['courseID'] == $courses['courseID']): ?>
                    <option value="<?= $courses['courseID']; ?>" selected><?= $courseName; ?></option>
                <?php else: ?>
                    <option value="<?= $courses['courseID']; ?>"><?= $courseName; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>


    <div class="photo">
            <input type="file" name="updateLogoInput" id="updateLogoInput" accept="image/*" onchange="handleUpdateLogoInputChange()">
            <label for="updateLogoInput" class="add-logo-button">
                <img src="<?= $student['photo']; ?>" alt="Department Logo" class="add-logo-preview" id="updateLogoPreview">
            </label>
        </div>



    <button name="updateStudent"><span> Update</span></button>
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

function calculateAge() {
        var birthdateInput = document.getElementById('birthdate').value;
        var birthdate = new Date(birthdateInput);
        var today = new Date();

        var age = today.getFullYear() - birthdate.getFullYear();

        // Adjust age if birthday hasn't occurred yet this year
        if (today.getMonth() < birthdate.getMonth() || (today.getMonth() === birthdate.getMonth() && today.getDate() < birthdate.getDate())) {
            age--;
        }

        // Display the calculated age
        document.getElementById('age').value = age;
    }
    </script>


</body>
</html>
