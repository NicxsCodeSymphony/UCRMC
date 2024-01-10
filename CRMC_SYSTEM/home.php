<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRMC</title>
    <link rel="stylesheet" href="css/home.css">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Marko One' rel='stylesheet'>
</head>

<body>

   <div class="container">
   <div class="header">
        <div class="left-head">
            <div class="logo">
                <img src="assets/crmc-logo.png" alt="">
                <p>Univesity of <span>CRMC</span></p>
            </div>

            <div class="navbar">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About School</a></li>
                    <li><a href="#">Classes</a></li>
                    <li><a href="#">Programs</a></li>
                </ul>
            </div>
        </div>


        <div class="right-head">
            <a href="loginStudent.php">Student</a>
            <a href="login.php">Teacher</a>
        </div>
    </div>

    <!-- END OF HEADER -->

    <!-- Start of Hero -->

        <div class="hero">
            <div class="left-hero">
                <h5>Explore the vast expanse of what you know</h5>
                <h1>Empower <span>Your Future</span>, Enroll Today </h1>
                <p>Explore interests, discover diverse opportunities. Gain knowledge and practical skills in
                    engaging sessions. Join us for hands-on learning experiences at our
                    orientation session for prospective students</p>

                <div class="button-container">
                    <a href="#">GET STARTED</a>
                </div>
            </div>
            <div class="right-hero"></div>
        </div>
   </div>


    <script>
          const correctPassword = 'admin';

document.addEventListener('keydown', function(event) {
    // Check if the pressed key is 'F' (you can change this to any key you want)
    if (event.key === '-' || event.key === '-') {
        // Prompt the user for a password
        const userPassword = prompt('Enter password:');
        
        // Check if the entered password is correct
        if (userPassword === correctPassword) {
            // Open a file (you can replace 'file.txt' with the path to your file)
            window.open('department.php');
        } else {
            alert('Incorrect password. File not opened.');
        }
    }
});
    </script>

</body>

</html>