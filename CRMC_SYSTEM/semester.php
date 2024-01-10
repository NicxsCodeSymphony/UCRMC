<?php
session_start();
include 'connection.php';
include 'php/semesterCommands.php';
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

    <style type="text/css">
        
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
    <h1 style="font-size: 2.2rem;">Semester</h1>
    <p id="courses"><?= count($semesters); ?> total, <span style="opacity: 0.5;">departments</span></p>
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
            <th>Semester</th>
            <th>Year Level</th>
            <th>Subjects</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($semesters)): ?>
            <?php foreach ($semesters as $department): ?>
    <tr>
        <input name="semesterID" type="hidden" value="<?= $department['semesterID'];?>">
        <td><?= $department['semester']; ?></td>
        <td><?= $department['yearLevel']; ?></td>
        <?php foreach ($subjects as $dept): ?>
            <?php if ($department['subjectID'] == $dept['subjectID']): ?>
                <!-- Displaying the Subject Name instead of ID -->
                <td><?= $dept['subjectName']; ?></td>
            <?php endif; ?>
        <?php endforeach; ?>
        <!-- Add other columns as needed -->

        <!-- Add action buttons for update and delete -->
        <td>
            <a href="updateSemester.php?semesterID=<?= $department['semesterID']; ?>">Update</a>
            <button onclick="deleteDepartment(<?= $department['semesterID']; ?>)">Delete</button>
        </td>
    </tr>
<?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="2">No semester yet.</td>
                <!-- Add other columns as needed -->
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>


        </div>



    </div>



    <!-- *********************************** POP UPS *********************************** -->

    
   <div class="popup-container" id="popupContainer">
    <div class="popup">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h1>Add Course</h1>

        <form method="POST" action="semester.php" enctype="multipart/form-data" class="popup-form">
            <!-- Dropdown menu for selecting the department -->
           <div class="form-group">
            <label for="departmentID">Select Subject:</label>
            <select name="subject" id="departmentID" class="select-input">
                <?php foreach ($subjects as $dept): ?>
                    <option value="<?= $dept['subjectID']; ?>"><?= $dept['subjectName']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

            <!-- Input for course name -->
            <div class="form-group">
                <label for="courseName">Semester:</label>
                <input type="text" name="semester" id="semester" class="text-input" placeholder="Enter Semester as Number" required>
            </div>

            <div class="form-group">
                <label for="courseName">Year Level:</label>
                <input type="text" name="yearLevel" id="yearLevel" class="text-input" placeholder="Enter Year Level as Numbers" required>
            </div>

            <!-- Input field to indicate adding a course -->
            <input type="hidden" name="addCourse" value="1">

            <!-- Submit button -->
            <div class="form-group">
                <button name="cta" type="submit" class="submit-button">Add Course</button>
            </div>
        </form>
    </div>
</div>
   <script src="js/department.js"></script>

   <script>
        function deleteDepartment(departmentID) {
        if (confirm("Are you sure you want to delete this department?")) {
            // Send an AJAX request to delete_department.php
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "semester.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Reload the page after successful deletion
                    location.reload();
                }
            };

            // Send the department ID to the server
            xhr.send("semesterID=" + departmentID);
        }
    }

   </script>
</body>
</html>