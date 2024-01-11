
<?php  
// login_success.php  
session_start();
include 'connection.php';

$conn = new Connection();
$pdo = $conn->openConnection();

function getUserData($email) {
    $conn = new Connection();
    $pdo = $conn->openConnection();
    
    $stmt = $pdo->prepare("SELECT * FROM teacher WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_SESSION["username"])) {
    // Fetch user data from the database based on the email stored in the session
    $userData = getUserData($_SESSION["username"]);
    
    // Store user data in the session
    $_SESSION["user_data"] = $userData;
} else {
    header("location: pdo_login.php");
}

function getStudentsByCriteria($teacherDepartmentID, $yearLevel) {
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("SELECT s.*, g.prelim, g.midterm, g.semifinal, g.final
                          FROM student s
                          JOIN teacher t ON s.departmentID = t.departmentID
                          LEFT JOIN grade g ON s.studentID = g.studentID
                          WHERE t.departmentID = ? AND s.yearLevel = ?");
    $stmt->execute([$teacherDepartmentID, $yearLevel]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $students;
}

function fetchGrades($students, $pdo) {
    foreach ($students as &$student) {
        $stmt = $pdo->prepare("SELECT prelim, midterm, semifinal, final
                              FROM grade
                              WHERE studentID = ?");
        $stmt->execute([$student['studentID']]);
        $grades = $stmt->fetch(PDO::FETCH_ASSOC);

        // Merge grades into the student array
        $student = array_merge($student, $grades);
    }

    return $students;
}

function getDepartmentNameById($departmentID) {
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("SELECT departmentName FROM department WHERE departmentID = ?");
    $stmt->execute([$departmentID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['departmentName'];
}

function getCourseNameById($courseID) {
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("SELECT courseName FROM course WHERE courseID = ?");
    $stmt->execute([$courseID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['courseName'];
}


function getAllStudents() {
    $conn = new Connection();
    $pdo = $conn->openConnection();
    
    $stmt = $pdo->prepare("SELECT * FROM student");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$stmt = $pdo->prepare("SELECT DISTINCT prelim, midterm, semifinal, final
                      FROM grades
                      WHERE studentID = ?");


function getAllDepartments() {
    $conn = new Connection();
    $pdo = $conn->openConnection();
    
    $stmt = $pdo->prepare("SELECT DISTINCT departmentName FROM department");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

function getSubjectNameById($subjectID) {
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("SELECT subjectName FROM subject WHERE subjectID = ?");
    $stmt->execute([$subjectID]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result['subjectName'];
}

$departments = getAllDepartments();

// Inside the head tag, add the following PHP code to fetch year levels
function getAllYearLevels() {
    $conn = new Connection();
    $pdo = $conn->openConnection();
    
    $stmt = $pdo->prepare("SELECT DISTINCT yearLevel FROM semester");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

$yearLevels = getAllYearLevels();

// Fetch students only when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacherDepartmentID = $_SESSION["user_data"]["departmentID"];
    $yearLevel = $_POST["yearLevel"];

    $students = getStudentsByCriteria($teacherDepartmentID, $yearLevel);
} else {
    // If no filters are applied, get all students
    $students = getAllStudents();
}


    $teacherDepartmentID = $_SESSION["user_data"]["departmentID"];

// Fetch department name based on teacher's departmentID
$departmentName = getDepartmentNameById($teacherDepartmentID);

$teacherCourseID = $_SESSION["user_data"]["courseID"];

// Fetch course name based on teacher's courseID
$courseName = getCourseNameById($teacherCourseID);

$teacherSubjectID = $_SESSION["user_data"]["subjectID"];

// Fetch subject name based on teacher's subjectID
$subjectName = getSubjectNameById($teacherSubjectID);

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>UCRMC | Admin</title>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>
        <link rel="stylesheet" href="css/dashboard.css">

        <style>

*{
                overflow: none;
            }

            .container{
                background-color: #b5c2ca;
            }

            .navbar{
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4); 
                background: #fff;
                color: black;
                height: 10vh;
                border-radius: 10px;
            }

            .logo {
                display: flex;
                justify-content: center;
                align-items: center;
                padding-bottom: 58px;
                gap: 10px;
            }

            .logo img {
                width: 83px;
                height: 60px;
            }

            .logo h3 {
                font-size: 4vh;
            }

            .table-container{
                overflow: auto;
                height: 82vh;
                width: 96.5%;
                position: relative;
                bottom: 85vh;
                left: 4vh;
            }

            .heading{
                display: flex;
                justify-content: space-between;
            }

            .info-grid{
                display: grid;
                grid-template-columns: 35% 3fr;
                width: 100%;
                height: 30vh;
                margin-top: 20px;
                grid-gap: 20px;
            }

            .info-grid > div{
                height: 100%;
                border-radius: 15px;
            }

            .teacherInfo{
                background: #d0ee82;
                display: flex;
                align-items: center;
                padding: 20px;
            }

            .status{
                background: #dfe6c4;
                padding: 20px;
            }

            .filter-container{
                margin-top: 30px;
                border-radius: 20px;
                height: 15vh;
                background: #dfe6c4;
            }

            .list{
                height: 55%;
                background: #dfe6c4;
                margin-top: 30px;
                border-radius: 20px;
                padding: 20px;
            }

            img{
                width: 150px;
                border-radius: 50%;
                max-height: 140px;
            }

            .info-wrapper{
                margin-left: 20px;
                height: 70%;
                overflow: hidden;
            }

            .info-wrapper h3{
                font-size: 25px;
            }

            .info-wrapper h5{
                font-size: 18px;
                margin-top: 10px;
                width: 100%;
            }
            
            .status h5{
                margin-top: 20px;
                font-size: 20px;
                width: 100%;
                padding: 10px 15px;
                background: #151e00;
                color: #fff;
                /* text-align: center; */
                border-radius: 10px;
            }
        
            .filter-container{
                padding: 15px;
            }

            .filter-select{
                display: flex;
                justify-content: space-between;
                width: 100%;
                margin-top: 10px;
            }

            .filter-select select{
                width: 50%;
                padding: 5px 10px;
                background: transparent;
                border: 1px #c0c0c0 solid;
            }

            .label-container{
                width: 100%;
            }

            button{
                height: 30px;
                width: 100px;
            }

            .Btn {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 45px;
  height: 45px;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition-duration: .3s;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
  background-color: rgb(5, 65, 65);
  position: relative;
  bottom: 8.8%;
  left: 90%;
}

/* plus sign */
.sign {
  width: 100%;
  transition-duration: .3s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.sign svg {
  width: 17px;
}

.sign svg path {
  fill: white;
}
/* text */
.text {
  position: absolute;
  right: 0%;
  width: 0%;
  opacity: 0;
  color: white;
  font-size: 1.2em;
  font-weight: 600;
  transition-duration: .3s;
}
/* hover effect on button width */
.Btn:hover {
  width: 125px;
  border-radius: 40px;
  transition-duration: .3s;
}

.Btn:hover .sign {
  width: 30%;
  transition-duration: .3s;
  padding-left: 20px;
}
/* hover effect button's text */
.Btn:hover .text {
  opacity: 1;
  width: 70%;
  transition-duration: .3s;
  padding-right: 10px;
}
/* button click effect*/
.Btn:active {
  transform: translate(2px ,2px);
}



.download-btn {
  border: 2px solid #161f00;
  background-color: white;
  width: 35px;
  height: 35px;
  border-radius: 10px;
  position: relative;
  z-index: 1;
  transition: all 0.2s ease;
  cursor: pointer;
  position: relative;
  left: 95%;
  bottom: 35%;
}
.download-btn svg {
  width: 25px;
  height: 25px;
  transition: all 0.3s ease;
}
.download-btn:hover svg {
  fill: white;
}
.download-btn:hover {
  background-color: #161f00;
}


        </style>
    </head>
    <body>


        <div class="container">
        <div class="navbar">
            <div class="logo">
                        <img src="assets/crmc-logo.png" alt="">
                        <h3>University of CRMC</h3>
            </div>

        </div>
        
        <button class="Btn">
  
  <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
  
  <div class="text">Logout</div>
</button>



                <!-- Account Section -->
                <div class="account">
                    <!-- <img src="assets/nico.jpg" alt="Profile Picture"> -->
                    <div class="account-info">
                        <!-- <p>John Nico edisan</p>
                        <p>nicxsician@gmail.com</p> -->
                    </div>
                </div>
            </div>



            <div class="table-container" style="">

        <div class="heading">
            <h1>Dashboard</h1>
            <h4>Academic Year</h4>
        </div>         

        <div class="info-grid">
            <div class="teacherInfo">
                <img src="<?php echo $_SESSION["user_data"]["photo"]; ?>" alt="">
                <div class="info-wrapper">
                <h3><?php echo $_SESSION["user_data"]["firstName"]; ?> <?php echo $_SESSION["user_data"]["lastName"]; ?></h3>
                <h5>Email:</h5>
                <p><?php echo $_SESSION["username"]; ?></p>
                </div>
            </div>


            <div class="status">
               <h3>Teacher details</h3>
     <h5><?php echo $courseName; ?></h5>
    <div class="inline" style="display: flex; gap: 10px;">
      <h5  style="width: 70%"><?php echo $departmentName; ?></h5>
        <h5 style="width: 30%"><?php echo $subjectName; ?></h5>
    </div>
            </div>
        </div>

        <div class="filter-container">
    <h4>Filtering Section</h4>

    <div class="filter-select">
        <div class="label-container">
            <label for="department">Department:</label>
            <select name="department" id="department">
                <?php
                foreach ($departments as $department) {
                    echo "<option value='$department'>$department</option>";
                }
                ?>
            </select>
        </div>

        <div class="label-container">
            <label for="yearLevel">Year Level:</label>
            <select name="yearLevel" id="yearLevel">
                <?php
                foreach ($yearLevels as $yearLevel) {
                    echo "<option value='$yearLevel'>$yearLevel</option>";
                }
                ?>
            </select>
        </div>

        <button type="button" id="applyFilters">Apply Filters</button>
    </div>
</div>

<div class="list">

    <h1 style="margin: 20px 0;">List of Students</h1>

    <?php
   $teacherDepartmentID = $_SESSION["user_data"]["departmentID"];

$students = getStudentsByCriteria($teacherDepartmentID, $yearLevel);

// Display the students with grades
$displayedStudentIDs = array();  // Array to store displayed student IDs

if (isset($students) && !empty($students)) {
    echo "<table id='studentsTable'>";
    echo "<thead><tr><th>First Name</th><th>Last Name</th><th>Year Level</th><th>Action</th></tr></thead>";
    echo "<tbody id='studentTableBody'>";

    foreach ($students as $student) {
        // Check if the student's departmentID matches the teacher's departmentID
        if ($student['departmentID'] == $_SESSION['user_data']['departmentID'] && !in_array($student['studentID'], $displayedStudentIDs)) {
            echo "<input type='hidden' name='studentID' value='{$student['studentID']}' >";
            echo "<tr>";
            // echo "<td>{$student['studentID']}</td>";
            echo "<td>{$student['firstName']}</td>";
            echo "<td>{$student['lastName']}</td>";
            echo "<td>{$student['yearLevel']}</td>";
            // echo "<td>{$student['prelim']}</td>";
            // echo "<td>{$student['midterm']}</td>";
            // echo "<td>{$student['semifinal']}</td>";
            // echo "<td>{$student['final']}</td>";
            
            // Add a button in the last column
            echo "<td><a href=\"grade.php?courseID={$_SESSION['user_data']['courseID']}&studentID={$student['studentID']}&subjectID={$_SESSION['user_data']['subjectID']}\">Add Score</a></td>";

            echo "</tr>";

            // Add the displayed student's ID to the array
            $displayedStudentIDs[] = $student['studentID'];
        }
    }

    echo "</tbody></table>";

    if (empty($students)) {
        echo "<p>No students found.</p>";
    }
}

    ?>

    <!-- <button  style="width: 20%; position: absolute; top: 90%; left:75%;" type="button" id="downloadListImage">Download Grades</button> -->

    <button class="download-btn" onclick="download()">
  <svg
    id="download"
    viewBox="0 0 24 24"
    data-name="Layer 1"
    xmlns="http://www.w3.org/2000/svg"
  >
    <path
      d="M14.29,17.29,13,18.59V13a1,1,0,0,0-2,0v5.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l3,3a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l3-3a1,1,0,0,0-1.42-1.42ZM18.42,6.22A7,7,0,0,0,5.06,8.11,4,4,0,0,0,6,16a1,1,0,0,0,0-2,2,2,0,0,1,0-4A1,1,0,0,0,7,9a5,5,0,0,1,9.73-1.61,1,1,0,0,0,.78.67,3,3,0,0,1,.24,5.84,1,1,0,1,0,.5,1.94,5,5,0,0,0,.17-9.62Z"
    ></path>
  </svg>
</button>

</div>



</div>


    </div>

            </div>
        </div>

        <script src="js/dashboard.js"></script>

        <script>

        function updateStudentTable(students) {
            var tableBody = document.getElementById('studentsTableBody');
            // Clear the existing table body
            tableBody.innerHTML = '';

            if (students.length > 0) {
                students.forEach(function (student) {
                    // Create a new table row for each student
                    var row = tableBody.insertRow();
                    var firstNameCell = row.insertCell(0);
                    var lastNameCell = row.insertCell(1);
                    var yearLevelCell = row.insertCell(2);
                    var actionCell = row.insertCell(3);

                    // Set the cell values
                    firstNameCell.textContent = student.firstName;
                    lastNameCell.textContent = student.lastName;
                    yearLevelCell.textContent = student.yearLevel;

                    // Add a link to "Add Score" with the appropriate student and course data
                    var addScoreLink = document.createElement('a');
                    addScoreLink.href = 'grade.php?courseID=' + student.courseID + '&studentID=' + student.studentID + '&subjectID=' + student.subjectID;
                    addScoreLink.textContent = 'Add Score';
                    actionCell.appendChild(addScoreLink);
                });
            } else {
                // Display a message if no students are found
                var row = tableBody.insertRow();
                var noDataCell = row.insertCell(0);
                noDataCell.colSpan = 4;
                noDataCell.textContent = 'No students found.';
            }
        }

        fconst logoutBtn = document.querySelector('.Btn');

            logoutBtn.addEventListener('click', () => {
                window.location.href = 'logout.php';
            })


</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
            const logoutBtn = document.querySelector('.Btn');

            logoutBtn.addEventListener('click', () => {
                window.location.href = 'logout.php';
            });

            document.getElementById('downloadListImage').addEventListener('click', function () {
                var table = document.getElementById('studentsTable');

                if (table) {
                    html2canvas(table).then(function (canvas) {
                        var link = document.createElement('a');
                        link.download = 'list_image.png';
                        link.href = canvas.toDataURL('image/png');
                        link.click();
                    });
                } else {
                    console.error("Table not found.");
                }
            });

            function download() {
                var subjectID = <?php echo $_SESSION["user_data"]["subjectID"]; ?>;
                var teacherName = "<?php echo $_SESSION["user_data"]["firstName"] . ' ' . $_SESSION["user_data"]["lastName"]; ?>";
                var subjectName = "<?php echo $subjectName; ?>";

                // Check if subjectID is valid
                if (subjectID) {
                    // Include teacherName and subjectName in the URL
                    window.location.href = "downloadGrade.php?subjectID=" + subjectID + "&teacherName=" + encodeURIComponent(teacherName) + "&subjectName=" + encodeURIComponent(subjectName);
                } else {
                    console.error("Invalid subjectID");
                }
            }
        });
</script>





    </body>
    </html>

