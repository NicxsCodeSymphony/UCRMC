
<?php  
    //login_success.php  
    session_start();
    include 'connection.php';
    
    
  
    
function getUserData($email) {
    $conn = new Connection();
    $pdo = $conn->openConnection();

    $stmt = $pdo->prepare("
        SELECT s.*, c.courseName, d.departmentName
        FROM student s
        JOIN course c ON s.courseID = c.courseID
        JOIN department d ON c.departmentID = d.departmentID
        WHERE email = ?");
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
        SELECT s.*, g.prelim, g.midterm, g.semifinal, g.final, g.total, g.gwa, g.remark, sub.subjectName, sub.subjectID, c.courseName
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
                max-height: 150px;
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
  top: 90%;
  left: 10px;
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

        </style>
    </head>
    <body>

        <div class="container">
            <div class="sidebar" style=" height: 150vh;">
           <button class="Btn">
  
  <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
  
  <div class="text">Logout</div>
</button>



                <div class="logo">
                    <img src="assets/crmc-logo.png" alt="">
                    <h3>UCRMC</h3>
                </div>


                <div class="account">
                    <!-- <img src="assets/nico.jpg" alt="Profile Picture"> -->
                    <div class="account-info">
                       <!--  <p>John Nico edisan</p>
                        <p>nicxsician@gmail.com</p> -->
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
                <h3>Student details</h3>
                <!-- <h5><?php echo $_SESSION["user_data"]["courseID"]; ?></h5>
                <h5><?php echo $_SESSION["user_data"]["subjectID"]; ?></h5> -->

                <h5 style=""><?php echo $_SESSION["user_data"]["courseName"]; ?></h5>
                <div class="inline" style="display: flex; gap: 20px;">
                <h5 style="width: 70%"><?php echo $_SESSION["user_data"]["departmentName"]; ?></h5>
                <h5 style="width: 30%"><?php echo $_SESSION["user_data"]["age"]; ?> Years old</h5>
                </div>
            </div>
        </div>

        <div class="filter-container">
    <h4 style="font-size: 30px;">Grade</h4>

    <form method="post">
        <input type="hidden" name="studentID" value="<?php echo $_SESSION["user_data"]["studentID"]; ?>">
        <input type="hidden" name="courseID" value="<?php echo $_SESSION["user_data"]["courseID"]; ?>">
        <button style="margin-left: 30px;" type="submit">VIEW GRADE</button>
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
                    <th>Semi Finals</th>
                    <th>Finals</th>
                    <th>Grade</th>
                    <th>GWA</th>
                    <th>Remarks</th>
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
                        <td><?php echo $student['total']; ?></td>
                        <td><?php echo $student['gwa']; ?></td>
                        <td><?php echo $student['remark']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No grades yet</p>
    <?php endif; ?>
</div>



</div>


    </div>

            </div>
        </div>

        <script src="js/dashboard.js"></script>

        <script>
                
            const logoutBtn = document.querySelector('.Btn');

            logoutBtn.addEventListener('click', () => {
                window.location.href = 'logout.php';
            })

        </script>

    </body>
    </html>

