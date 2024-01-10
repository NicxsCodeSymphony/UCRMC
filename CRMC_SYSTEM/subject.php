<?php
include_once 'connection.php';

$newconnection = new Connection();
$pdo = $newconnection->openConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departmentID = $_POST['courseID'];

    // Delete the department from the database
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("DELETE FROM course WHERE courseID = ?");
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

$stmt = $pdo->query("SELECT * FROM subject");
$subject = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
          .table-wrapper {
            display: flex;
            flex-wrap: wrap;
            height: 80%;
            margin: -10px; /* Adjust the margin based on your preference */
            margin-top: 20px;
        }

        .department-container {
            width: calc(33.33% - 20px); /* Adjust the width based on your preference */
            height: 150px; /* Adjust the height based on your preference */
            box-sizing: border-box;
            border: 1px #c0c0c0 solid;
            margin: 10px; /* Adjust the margin based on your preference */
            font-size: 1.2rem;
            padding: 5px;
        }

        .course-list {
            position: absolute;
            top: 70px; /* Adjust the distance from the bottom */
            left: 20px; /* Adjust the horizontal position */
            font-size: 0.7rem; /* Adjust the font size */
            list-style: none;
            padding: 0;
            color: #555; /* Adjust the color */
            filter: saturate(70%); /* Adjust the saturation */
            max-height: 80px; /* Adjust the maximum height */
            overflow-y: auto; /* Add scroll for overflow */
        }

        .course-list li {
            margin-bottom: 4px; /* Adjust the spacing between list items */
        }

         .popup-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
    }

    .popup {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        cursor: pointer;
    }

    h1 {
        font-size: 1.5rem;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .select-input,
    .text-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        font-size: 14px;
    }

    .submit-button {
        background-color: #4caf50;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }
    .popup-container .anotherTable {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.anotherTable .popup {
    background: #fff; /* Set the background color to white */
    padding: 20px;
    border-radius: 10px;
    width: 90%; /* Set width to 90% */
    height: 85%; /* Set height to 85% */
    max-width: 90%;
    max-height: 85%;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    position: relative;
}


/* Adjust the close button position */
.close-btn.anotherTable {
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}

/* Adjust the form styles as needed */
.popup-form.anotherTable {
    /* Add your styles here */
}

/* Adjust the input styles as needed */
.text-input.anotherTable {
    /* Add your styles here */
}

/* Adjust the button styles as needed */
.submit-button.anotherTable {
    /* Add your styles here */
}

.popup-content {
    background: #fff;
    width: 100%;
    height: 85%;
    border-radius: 15px;
    padding: 30px;
    overflow: auto; /* Add overflow property for scrolling */
}

.popup-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.popup-table th,
.popup-table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
}

.popup-table th {
    background-color: #f2f2f2;
}

.popup-table td button {
    margin-right: 5px;
    cursor: pointer;
}

.popup-table td button:last-child {
    margin-right: 0;
}

/* Adjust the close button position for the "Edit Course" popup */
.close-btn.anotherTable {
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
}

/* Adjust the form styles for the "Edit Course" popup */
.popup-form.anotherTable {
    /* Add your styles here */
}

/* Adjust the input styles for the "Edit Course" popup */
.text-input.anotherTable {
    /* Add your styles here */
}

/* Adjust the button styles for the "Edit Course" popup */
.submit-button.anotherTable {
    /* Add your styles here */
}

#editCourseList li{
    text-align: left;
    margin-top: 10px;
    border: 1px #ddd solid;
    padding: 15px 5px;
}

.course-grids{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 10px;
            height: 200px;
            font-size: 14px;
        }

        .course-grid-items {
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .course-grid-items:hover {
            background-color: #f5f5f5;
        }


        .add-button-container {
    position: absolute;
    bottom: 100px; /* Adjust the top distance as needed */
    right: 20vh; /* Adjust the right distance as needed */
}

        
    </style>





</head>
<body>

    <div class="container">
        <div class="sidebar">
            <div class="logo">
                <img src="assets/crmc-logo.png" alt="">
                <h3>UCRMC</h3>
            </div>

            <!-- Navbar List with Icons -->
            <ul class="navbar">
                <li><a href="department.php"><i class="fas fa-building"></i> Department</a></li>
                <li><a href="course.php"><i class="fas fa-book"></i> Course</a></li>
                <li><a href="semester.php"><i class="fas fa-calendar-alt"></i> Semester</a></li>
                <li><a href="subject.php"><i class="fas fa-flask"></i> Subjects</a></li>
                <li><a href="teacherInfo.php"><i class="fas fa-chalkboard-teacher"></i> Teachers</a></li>
                <li><a href="studentInfo.php"><i class="fas fa-user-graduate"></i> Student Info</a></li>
                <li><a href="manage.php"><i class="fas fa-users-cog"></i> Manage Faculty</a></li>
            </ul>

            <!-- Account Section -->
            <div class="account">
                <img src="assets/nico.jpg" alt="Profile Picture">
                <div class="account-info">
                    <p>John Nico edisan</p>
                    <p>nicxsician@gmail.com</p>

                    <a style="position: relative; left: 38%; font-size: 12px;" href="home.php">Logout</a>
                    
                </div>
            </div>
        </div>

        <div class="header">
            
        <div class="InputContainer">
  <input type="text" name="text" class="input" id="input" placeholder="Search">
  
  <label for="input" class="labelforsearch">
<svg viewBox="0 0 512 512" class="searchIcon"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
</label>
<div class="border"></div>

<button class="micButton"><svg viewBox="0 0 384 512" class="micIcon"><path d="M192 0C139 0 96 43 96 96V256c0 53 43 96 96 96s96-43 96-96V96c0-53-43-96-96-96zM64 216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 89.1 66.2 162.7 152 174.4V464H120c-13.3 0-24 10.7-24 24s10.7 24 24 24h72 72c13.3 0 24-10.7 24-24s-10.7-24-24-24H216V430.4c85.8-11.7 152-85.3 152-174.4V216c0-13.3-10.7-24-24-24s-24 10.7-24 24v40c0 70.7-57.3 128-128 128s-128-57.3-128-128V216z"></path></svg>
</button>

</div>

<div class="time-container">
                <span id="current-date" class="date-text"></span>
                <div class="calendar-dropdown" id="calendar-dropdown">
                    <!-- Calendar content goes here (you may use a library or custom implementation) -->
                </div>
                   </div>


<div class="cta-container">
    
<button class="button" type="button" onclick="openPopup()">
    <span class="button__text">Add Subject</span>
    <span class="button__icon"><svg class="svg" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><line x1="12" x2="12" y1="5" y2="19"></line><line x1="5" x2="19" y1="12" y2="12"></line></svg></span>
</button>



</div>
</div>



<div class="table-container">
<div class="table-heading">
           <div class="left-head">
    <h1 style="font-size: 2.2rem;">Subjects</h1>
    <p id="courses"><?= count($subject); ?> total, <span style="opacity: 0.5;">subjects</span></p>

</div>




            <div class="right-head">
                <div class="right-header-content">
                    <h1 id="teachers">94</h1>
                    <p style="margin-top: 10px;font-size: 14px;">Teachers</p>
                </div>

                <div class="right-header-content">
                    <h1 id="students">94</h1>
                    <p style="margin-top: 10px;font-size: 14px;">Students</p>
                </div>
            </div>
           </div>

           <div class="table-wrapper">
                <?php foreach ($departmentsWithCourses as $departmentID => $departmentData): ?>
                <div class="department-container" style="position: relative;"
                data-department-id="<?= $departmentData[0]['departmentID']; ?>"
                data-department-name="<?= $departmentData[0]['departmentName']; ?>"
                data-course-id="<?= $departmentData[0]['courseID']; ?>">
                    <div class="department-logo"
                        style="position: absolute; top: 10px; left: 15px; width: 50px; height: 50px; background: url('<?= $departmentData[0]['departmentLogo']; ?>') center/cover;">
                    </div>
                    <div class="department-name"
                        style="position: relative; top: 12px; left: 70px; font-size: 0.8rem; width: 50%;margin-bottom: 5px;">
                        <?= $departmentData[0]['departmentName']; ?></div>
                        <ul class="course-list course-grid">
    <?php foreach ($departmentData as $course): ?>
        <li class="course-grid-item"><?= $course['courseName']; ?></li>
    <?php endforeach; ?>
</ul>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <!-- *********************************** POP UPS *********************************** -->


    
     <div class="popup-container" id="popupContainer">
    <div class="popup">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h1>Add Course</h1>


        <form method="POST" action="course.php" enctype="multipart/form-data" class="popup-form">
            <!-- Dropdown menu for selecting the department -->
            <div class="form-group">
                <label for="departmentID">Select Department:</label>
                <select name="departmentID" id="departmentID" class="select-input">
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= $dept['departmentID']; ?>"><?= $dept['departmentName']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>  

            <!-- Input for course name -->
            <div class="form-group">
                <label for="courseName">Course Name:</label>
                <input type="text" name="courseName" id="courseName" class="text-input" placeholder="Enter Course Name" required>
            </div>

            <!-- Input field to indicate adding a course -->
            <input type="hidden" name="addCourse" value="1">

            <!-- Submit button -->
            <div class="form-group">
                <button type="submit" class="submit-button">Add Course</button>
            </div>
        </form>
    </div>
</div>

<div class="popup-container anotherTable" id="editPopupContainer">
    <div class="popup">
        <span class="close-btn" onclick="closeEditPopup()">&times;</span>
        <h1>UCRMC</h1>

        <div class="popup-content">
    <h1 id="editCourseTitle"></h1>
    <table id="editCourseTable" class="popup-table">
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="editCourseList">
            <?php foreach ($departmentData as $course): ?>
                <!-- Loop through each course and display it in a row -->
                <tr>
                    <td><?= $course['courseName']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    
</div>

        <form id="editCourseForm" class="popup-form anotherTable" method="POST" action="course.php">
            <!-- Add your form elements here -->
            <div class="form-group">
                <label for="editCourseName">Edit Course Name:</label>
                <input type="text" name="editCourseName" id="editCourseName" class="text-input" required>
            </div>
            <input type="hidden" id="editCourseID" name="editCourseID">

            <!-- Add any additional form elements as needed -->

            <!-- Submit button -->
            <div class="form-group">
                <button type="submit" class="submit-button">Update Course</button>
            </div>
        </form>
    </div>
</div>

    
    

    <script src="js/script.js"></script>
    
    <script>

const closeButton = document.getElementById('closeBtn');
    const closeEditButton = document.getElementById('closeEditBtn');

document.addEventListener('DOMContentLoaded', function () {
    const popupContainer = document.getElementById('popupContainer');
    const editPopupContainer = document.getElementById('editPopupContainer');
    const editCourseTitle = document.getElementById('editCourseTitle');
    const editCourseList = document.getElementById('editCourseList');
    const departmentContainers = document.querySelectorAll('.department-container');
   

    function openPopup() {
        popupContainer.style.display = 'flex';
    }

    function openEditPopup(departmentID, departmentName, courses, courseID) {
    editCourseTitle.textContent = `Courses for ${departmentName}`;
    editCourseList.innerHTML = ""; // Clear existing courses
    

    // Create a new div element for the course grid
    const courseGrid = document.createElement('div');
    courseGrid.classList.add('course-grids');

    // Add each course as a grid item
// Add each course as a grid item
courses.forEach(course => {
        const courseItem = document.createElement('div');
        courseItem.classList.add('course-grid-items');
        courseItem.textContent = course;
        
        // Add a click event listener to each course item
        courseItem.addEventListener('click', () => {
            const link = document.createElement('a');
            link.href = `addSubject.php?courseID=${courseID}&course=${encodeURIComponent(course)}`;
            link.click();
        });

        courseGrid.appendChild(courseItem);
    });


    // Append the course grid to the editCourseList
    editCourseList.appendChild(courseGrid);
    // Display the edit popup
    editPopupContainer.style.display = 'flex';
}

    // Open the popup when clicking the "Add Course" button
    const addButton = document.querySelector('.button');
    addButton.addEventListener('click', openPopup);

    departmentContainers.forEach(container => {
    container.addEventListener('click', () => {
        const courseID = container.getAttribute('data-course-id');
        const departmentName = container.getAttribute('data-department-name');
        const courses = Array.from(container.querySelectorAll('.course-list li')).map(course => course.textContent);
        openEditPopup(courseID, departmentName, courses);
    });
});


    // Close the main popup when clicking the close button
   
});

closeButton.addEventListener('click', closePopup);

// Close the edit popup when clicking the close button
closeEditButton.addEventListener('click', closeEditPopup);

function closePopup() {
    popupContainer.style.display = 'none';
}

function closeEditPopup() {
    editPopupContainer.style.display = 'none';
}

</script>


</body>
</html>
