
<?php  
    //login_success.php  
    session_start();
    include 'connection.php';
    
    
  
    
    function getUserData($email) {
        $conn = new Connection();
    $pdo = $conn->openConnection();
    
        $stmt = $pdo->prepare("SELECT * FROM student WHERE email = ?");
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

    function getStudentsByCriteria($studentID, $courseID) {
        $conn = new Connection();
        $pdo = $conn->openConnection();
    
        $stmt = $pdo->prepare("
        SELECT s.*, g.prelim, g.midterm, g.semifinal, g.final, sub.subjectName, sub.subjectID, c.courseName
        FROM student s
        JOIN grade g ON s.studentID = g.studentID
        JOIN subject sub ON g.subjectID = sub.subjectID
        JOIN course c ON s.courseID = c.courseID
        WHERE s.studentID = ? AND s.courseID = ?
        ");
        $stmt->execute([$studentID, $courseID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // ...
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $studentID = $_POST["studentID"];
        $courseID = $_POST["courseID"];
    
        $students = getStudentsByCriteria($studentID, $courseID);
    }
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
                overflow: auto;
            }

            .container{
                background-color: #d0ee82;
            }

            .sidebar{
                background: #161f00;
                color: #fff;
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
                width: 200px;
                border-radius: 50%;
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
                display: flex;
                align-items: center;
                padding: 0 30px;
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

        </style>
    </head>
    <body>

        <div class="container">
            <div class="sidebar" style=" height: 150vh;">
            <?php echo '<br /><br /><a href="logout.php">Logout</a>';   ?>
                <div class="logo">
                    <img src="" alt="">
                    <h3>UCRMC</h3>
                </div>


                <!-- Account Section -->
                <div class="account">
                    <img src="assets/nico.jpg" alt="Profile Picture">
                    <div class="account-info">
                        <p>John Nico edisan</p>
                        <p>nicxsician@gmail.com</p>
                    </div>
                </div>
            </div>



            <div class="table-container" style="position: relative; bottom: 160%; height: 150vh;">

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
                <!-- <h5><?php echo $_SESSION["user_data"]["courseID"]; ?></h5>
                <h5><?php echo $_SESSION["user_data"]["subjectID"]; ?></h5> -->

                <h5>College of Computer Studies</h5>
                <div class="inline" style="display: flex; gap: 20px;">
                <h5 style="width: 70%"><? echo $_SESSION["user_data"]["courseID"];</h5>
                <h5 style="width: 30%">1 sem</h5>
                </div>
            </div>
        </div>

        <div class="filter-container">
    <h4 style="font-size: 30px;">Grade</h4>

    <form method="post">
        <input type="hidden" name="studentID" value="<?php echo $_SESSION["user_data"]["studentID"]; ?>">
        <input type="hidden" name="courseID" value="<?php echo $_SESSION["user_data"]["courseID"]; ?>">
        <button type="submit">Filter</button>
    </form>
</div>

<div class="list">
    <?php if (!empty($students)) : ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Subject ID</th>
                    <th>Email</th>
                    <th>Prelim</th>
                    <th>Midterm</th>
                    <th>Semifinals</th>
                    <th>Finals</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student) : ?>
                    <tr>
                        <td><?php echo $student['subjectName']; ?></td>
                        <td><?php echo $student['email']; ?></td>
                        <td><?php echo $student['prelim']; ?></td>
                        <td><?php echo $student['midterm']; ?></td>
                        <td><?php echo $student['semifinal']; ?></td>
                        <td><?php echo $student['final']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No students found with the specified criteria.</p>
    <?php endif; ?>
</div>



</div>


    </div>

            </div>
        </div>

        <script src="js/dashboard.js"></script>

    </body>
    </html>

