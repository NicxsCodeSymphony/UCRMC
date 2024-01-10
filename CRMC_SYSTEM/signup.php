<?php

include 'connection.php';

$conn = new Connection();
$pdo = $conn->OpenConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form is submitted using POST method

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

    if (isset($_POST['cta'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $contact = $_POST['phone'];
        $gender = $_POST['gender'];
        $schoolYear = $_POST['schoolYear'];
        $department = $_POST['department'];
        $courseID = $_POST['course'];
        $address = $_POST['address'];
        $birthdate = $_POST['birthdate'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $yearLevel = $_POST['yearLevel'];


        $stmt = $pdo->prepare("INSERT INTO student (firstName, lastName, photo, birthdate, age, email, password, contact, address, departmentID, courseID, yearLevel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$fname, $lname, $imageURL, $birthdate, $age, $email, $password, $contact, $address, $department, $courseID, $yearLevel]);

        // Redirect to a different URL with the course parameter
        header("Location: studentInfo.php");
        exit();
    }

    // Check if the form is submitted for deleting a subject
    elseif (isset($_POST['deleteSubject'])) {
        // Get the subject ID from the POST data
        $subjectID = $_POST['subjectID'];

        // Delete the subject from the database based on subjectID
        $stmt = $pdo->prepare("DELETE FROM subject WHERE subjectID = ?");
        $stmt->execute([$subjectID]);

        // Redirect to a different URL with the course parameter
        header("Location: home.php");
        exit();
    }
}




$stmtCourse = $pdo->query("SELECT * FROM student");
$student = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);

$stmtCourse = $pdo->query("SELECT * FROM department");
$department = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);

$stmtCourse = $pdo->query("SELECT * FROM semester");
$semester = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);

$stmtCourse = $pdo->query("SELECT * FROM course");
$course = $stmtCourse->fetchAll(PDO::FETCH_ASSOC);



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRMC</title>
    <link rel="stylesheet" href="css/signup.css">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Marko One' rel='stylesheet'>
</head>
<body>
    
    <div class="header">
        <div class="left-head">
            <div class="logo">
                <img src="assets/crmc-logo.png" alt="">
            </div>

            <div class="navbar">
                <ul>
                    
                </ul>
            </div>
        </div>


        <div class="right-head">
            <a href="#">Start Learning</a>
        </div>
    </div>

    <!-- END OF HEADER -->

    <!-- Start of Hero -->

    <div class="hero">
        <h1>Online <br> Application</h1>
        
       <!--  <button id="teacher">Teacher</button>
        <button id="student">Student</button> -->
        </div>
    </div>


    <div class="section1">
        <div class="first-sec">
            <h4>SIGN UP FOR OUR INSTITUTION</h4>
            <h2>Welcome you to  our <br> best school</h2>
            <p>To apply for one of our programs, simply fill out the online application form below. 
                We require some basic information such as your name, contact details, and background.</p>
        </div>

        <form method="POST" action="signup.php" enctype="multipart/form-data">
        
        <div class="field-form-wrapper">
            <div class="inputs"> <label for="">First Name*</label> <br> <input type="text" name="fname"></div>
            <div class="inputs">   <label for="">Last Name*</label> <br> <input type="text" name="lname"></div>
        </div>

        <div class="field-form-wrapper">
            <div class="inputs"> <label for="">Phone*</label> <br> <input type="text" name="phone"></div>
            <div class="inputs">   <label for="">Gender*</label> <br>
                <select id="genders" name="gender">
                    <option value="#"></option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Gay">Gay</option>
                    <option value="Lesbian">Lesbian</option>
                </select>
            </div>
        </div>

        <div class="field-form-wrapper">
        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs">   <label for="">Birthdate*</label> <br>
            <input id="birthdate" type="date" onchange="calculateAge()" name="birthdate">
            <input type="hidden" id="age" name="age">
            </div>
        </div>
            <div class="inputs">   <label for="">Year Level*</label> <br>
                <select id="schoolYear" name="yearLevel">
                <!-- <?php foreach ($semester as $semesters): ?>
                <option value="<?= $semesters['yearLevel']; ?>"><?= $semesters['yearLevel']; ?></option>
        <?php endforeach; ?> -->

                    <option value="#"></option>
                    <option value="1">First Year</option>
                    <option value="2">Second Year</option>
                    <option value="3">Third Year</option>
                    <option value="4">Fourth Year</option>
                </select>
            </div>
        </div>

        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs">   <label for="">Which Program are you registering for? *</label> <br>
                <select id="schoolYear" name="department">
                <?php foreach ($department as $departments): ?>
                <option value="<?= $departments['departmentID']; ?>"><?= $departments['departmentName']; ?></option>
        <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs">   <label for="">Select Course *</label> <br>
                <select id="schoolYear" name="course">
                <?php foreach ($course as $courses): ?>
                <option value="<?= $courses['courseID']; ?>"><?= $courses['courseName']; ?></option>
        <?php endforeach; ?>
                </select>
            </div>
        </div>



        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs">   <label for="">Address*</label> <br>
                <input type="text" name="address">
            </div>
        </div>

        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs">   <label for="">Image*</label> <br>
            <input style="width: 100%;" type="file" name="logoInput" id="logoInput" accept="image/*" style="display: none" onchange="handleLogoInputChange()">
            </div>
        </div>

        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs">   <label for="">email*</label> <br>
                <input type="text" name="email">
            </div>
        </div>

        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs">   <label for="">password*</label> <br>
                <input type="password" name="password">
            </div>
        </div>
        

        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs" style="width: 100%; display:flex; justify-content: center;"> 
                <input type="submit" name="cta" value="Submit">
            </div>
        </div>

        

    </form>
        
    </div>

<script>
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