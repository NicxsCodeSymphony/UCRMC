<?php
session_start();
include 'connection.php';
include 'php/studentCommands.php';
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
    <link rel="stylesheet" href="css/teacher.css">


    <style>
        select{
            width: 150px;
            font-size: 16px;
            border: none;
            background: transparent;
            font-family: 'Rubik';
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
                <li><a href=""><i class="fas fa-user-graduate"></i> Student Info</a></li>
                <li><a href="manage.php"><i class="fas fa-users-cog"></i> Manage Faculty</a></li>
            </ul>

            <!-- Account Section -->
            <div class="account">
                <img src="assets/nico.jpg" alt="Profile Picture">
                <div class="account-info">
                    <p>John Nico edisan</p>
                    <p>nicxsician@gmail.com</p>
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
                <span id="current-time" class="date-text">Monday, 6th March</span>
                <div class="calendar-dropdown" id="calendar-dropdown">
                    <!-- Calendar content goes here (you may use a library or custom implementation) -->
                </div>
                   </div>


<div class="cta-container">
    
<button class="button" type="button" onclick="openPopup()">
    <span class="button__text">Add Dept</span>
    <span class="button__icon"><svg class="svg" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><line x1="12" x2="12" y1="5" y2="19"></line><line x1="5" x2="19" y1="12" y2="12"></line></svg></span>
</button>



</div>
</div>



        <div class="table-container">

           <div class="table-heading">
           <div class="left-head">
    <h1 style="font-size: 2.2rem;">Student</h1>
    <p id="courses"><?= count($departments); ?> total, <span style="opacity: 0.5;">students</span></p>
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

           <div class="table">
           <table>
    <thead>
        <tr>
            <th>Full Name</th>
            <th>Photo</th>
            <th>Birthdate</th>
            <th>Age</th>
            <th>Email</th>
            <th>Password</th>
            <th>Contact</th>
            <th>Address</th>
            <td>Department</td>
            <td>Course</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>

    <form action="studentInfo.php" method="post" name="updateTeacherForm">

        <?php if (!empty($departments)): ?>
            <?php foreach ($departments as $studentInfo): ?>
                <tr>
                <input type="hidden" name="studentID" value="<?= $studentInfo['studentID']?>">
                    <td><?= $studentInfo['firstName'], $studentInfo['lastName']; ?></td>
                    <td>
                        <!-- Display the logo if available -->
                        <?php if (!empty($studentInfo['photo'])): ?>
                            <img src="<?= $studentInfo['photo']; ?>" alt="Department Logo" style="width: 50px; height: 50px;">
                        <?php endif; ?>
                    </td>
                    <td><?= date('F j, Y', strtotime($studentInfo['birthdate'])); ?></td>
                    <td><?= $studentInfo['age']?></td>
                    <td><?= $studentInfo['email']?></td>
                    <td><?= $studentInfo['password']?></td>
                    <td><?= $studentInfo['contact']?></td>
                    <td><?= str_replace('Bogo City, Cebu', '', $studentInfo['address']); ?></td>
                    <td><?= ($studentInfo['departmentName'] == '') ? 'CCS' : $studentInfo['departmentName']; ?></td>
                    <td><?= getCourseNameById($studentInfo['courseID'], $courseses) ?></td>
                    <td>
                    <a href="updateStudent.php?studentID=<?= $studentInfo['studentID']; ?>">Update</a>
                    <button onclick="deleteDepartment(<?= $department['studentID']; ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No student found.</td>
                <!-- Add other columns as needed -->
            </tr>
        <?php endif; ?>
        </form>
    </tbody>
</table>
</div>


        </div>



    </div>

    <!-- *********************************** POP UPS *********************************** -->
    <div class="popup-container" id="popupContainer">
        <div class="popup">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <h1>ADD DEPARTMENT</h1>

            

            <!-- Add this attribute to enable file uploads -->
<form method="POST" action="department.php" enctype="multipart/form-data">
    <!-- Your existing form elements -->

    <!-- Add the file input for the image -->
    <div class="add-logo-container">
        <input type="file" name="logoInput" id="logoInput" accept="image/*" style="display: none" onchange="handleLogoInputChange()">
        <label for="logoInput" class="add-logo-button">
            <img src="add-logo.png" alt="" class="add-logo-preview" id="addLogoPreview">
            <i class="fas fa-plus">Add Logo</i>
        </label>
    </div>

    <input type="text" name="departmentName" id="departmentName" placeholder="Enter Department Name">
    <button type="submit">Submit</button>
</form>

        </div>
    </div>


    <div class="custom-alert" id="customAlert">Department added successfully!</div>
   <script src="js/department.js"></script>

   <script>
     function updateSubjectID(select) {
        var selectedSubjectID = select.value;
        document.getElementById('selectedSubjectID').value = selectedSubjectID;
        document.updateTeacherForm.submit();
    }

    function updateCourseID(select) {
    var selectedCourseID = select.value;
    document.getElementById('selectedCourseID').value = selectedCourseID;
    document.updateTeacherForm.submit();
}


function deleteDepartment(departmentID) {
        if (confirm("Are you sure you want to delete this department?")) {
            // Send an AJAX request to delete_department.php
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "teacherInfo.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Reload the page after successful deletion
                    location.reload();
                }
            };
            

            // Send the department ID to the server
            xhr.send("departmentID=" + departmentID);
        }
    }
   </script>
</body>
</html>


