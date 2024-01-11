<?php

include 'connection.php';
$conn = new Connection();
$pdo = $conn->openConnection();
$stmt = $pdo->query("SELECT * FROM subject");
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['course'])) {
    $courseName = $_GET['course'];

    // Retrieve the corresponding courseID from the database
    $stmt = $pdo->prepare("SELECT courseID FROM course WHERE courseName = ?");
    $stmt->execute([$courseName]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set the courseID to be used in the HTML form
    $courseID = $result['courseID'];

    $stmt = $pdo->prepare("SELECT * FROM subject WHERE courseID = ?");
    $stmt->execute([$courseID]);
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is submitted for adding a subject
    if (isset($_POST['addSubject'])) {
        $courseID = $_POST['courseID'];
        $subjectName = $_POST['subjectName'];

        $stmt = $pdo->prepare("INSERT INTO subject (subjectName, courseID) VALUES (?, ?)");
        $stmt->execute([$subjectName, $courseID]);

        // Redirect to a different URL with the course parameter
        header("Location: subject.php");
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
        header("Location: subject.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link href='https://fonts.googleapis.com/css?family=Rubik' rel='stylesheet'>

    <style>
        body {
            padding: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }

        .courseTag {
            font-size: 1.5rem;
        }

        .cta-containers {
            margin-top: 20px;
        }

        .table-containers {
            width: 100%;
            max-width: 800px;
        }

        .table-headings {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table {
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .popup-container {
            /* Add your styles for the popup container */
        }
    </style>
</head>

        <a style="position: absolute; top: 30px; left: 20px;" href="subject.php">&larr; Go Back</a>

<body>
    <?php
    // Ensure that the course parameter is present in the URL
    if (isset($_GET['course'])) {
        $subjectName = $_GET['course'];
    }else{
        header("addSubject.php");
    }
    ?>

    <h1 class="courseTag">Subjects for Course: <?php echo htmlspecialchars($subjectName); ?></h1>

    <div class="cta-containers">
        <button class="button" type="button" onclick="openPopup()">
            <span class="button__text">Add Subject</span>
            <span class="button__icon"><svg class="svg" fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><line x1="12" x2="12" y1="5" y2="19"></line><line x1="5" x2="19" y1="12" y2="12"></line></svg></span>
        </button>
    </div>

    <div class="table-containers">
        <div class="table-headings">
            <div class="left-head">
                <h1 style="font-size: 2.2rem;">Subjects</h1>
                <p id="courses"><?= count($courses); ?> total, <span style="opacity: 0.5;">subjects</span></p>
            </div>
            <div class="right-head">
                <!-- Your existing right header content -->
            </div>
        </div>
        <div class="table">
    <table>
        <thead>
            <tr>
                <th>Subject</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($subjects)) : ?>
                <?php foreach ($subjects as $subject) : ?>
                    <tr>
                        <td><?= $subject['subjectName']; ?></td>
                        <td>
                            <form action="addSubject.php" method="post">
                                <a href="updateSubject.php?subjectName=<?= $subject['subjectName']; ?>">Update</a>
                                <input type="hidden" name="subjectID" value="<?= $subject['subjectID']; ?>">
                                <button type="submit" name="deleteSubject">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="2">No subjects found for this course.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
    </div>


        <div class="popup-container" id="popupContainer">
            <div class="popup" style="width: 50vh;">
                <span class="close-btn" onclick="closePopup()">&times;</span>
                <h1 style="margin-bottom: 20px;">Add Subject</h1>

                <form method="POST" action="addSubject.php" enctype="multipart/form-data" class="popup-form">
                    <div class="form-group">
                        <input type="text" name="subjectName" id="subjectName" class="text-input" placeholder="Enter Subject Name" required>
                    </div>

                    <input type="hidden" name="courseID" value="<?php echo htmlspecialchars($courseID); ?>">

                    <input type="hidden" name="addSubject" value="1">

                    <div class="form-group">
                        <input type="submit" class="submit-button" name="addSubject" value="Add Subject">
                    </div>
                </form>
            </div>
        </div>

    <script>
        function openPopup() {
            popupContainer.style.display = 'flex';
        }

        function closePopup() {
            popupContainer.style.display = 'none';
        }

        function closeEditPopup() {
            editPopupContainer.style.display = 'none';
        }


        document.addEventListener('DOMContentLoaded', function () {
            // Function to update the URL without page reload
            function updateURL(courseName) {
                if (courseName) {
                    // Update the URL using pushState
                    history.pushState({ course: courseName }, '', '?course=' + encodeURIComponent(courseName));
                } else {
                    // If no courseName, remove the parameter from the URL
                    history.pushState({}, '', window.location.pathname);
                }
            }

            function openPopup() {
                popupContainer.style.display = 'flex';
            }

            function closePopup() {
                popupContainer.style.display = 'none';
            }

            function closeEditPopup() {
                editPopupContainer.style.display = 'none';
            }

            // Call updateURL when the page loads to handle initial state
            updateURL('<?php echo htmlspecialchars($courseName); ?>');

            // Attach event listener to the Add Subject button to update the URL
            document.querySelector('.button').addEventListener('click', function () {
                openPopup();
                updateURL('<?php echo htmlspecialchars($courseName); ?>');
            });

            // Add event listener to handle browser back/forward button
            window.addEventListener('popstate', function (event) {
                // Check if there's a course parameter in the state
                if (event.state && event.state.course) {
                    // Use the course parameter from the state
                    updateURL(event.state.course);
                    // You may also want to update the page content based on the course parameter
                } else {
                    // If no course parameter, remove it from the URL
                    updateURL('');
                    // You may also want to handle the default state or update page content accordingly
                }
            });
        });


    </script>

</body>

</html>

