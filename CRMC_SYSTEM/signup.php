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
                    <li><a href="home.php">Home</a></li>
                    <li><a href="#">About School</a></li>
                    <li><a href="#">Classes</a></li>
                    <li><a href="#">Programs</a></li>
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
        </div>
    </div>


    <div class="section1">
        <div class="first-sec">
            <h4>SIGN UP FOR OUR INSTITUTION</h4>
            <h2>Welcome you to  our <br> best school</h2>
            <p>To apply for one of our programs, simply fill out the online application form below. 
                We require some basic information such as your name, contact details, and background.</p>
        </div>

        <form action="" method="post">
        
        <div class="field-form-wrapper">
            <div class="inputs"> <label for="">First Name*</label> <br> <input type="text" name="fname"></div>
            <div class="inputs">   <label for="">Last Name*</label> <br> <input type="text" name="lname"></div>
        </div>

        <div class="field-form-wrapper">
            <div class="inputs"> <label for="">Phone*</label> <br> <input type="text" name="fname"></div>
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
            <div class="inputs"> <label for="">Age*</label> <br> <input type="number" name="fname"></div>
            <div class="inputs">   <label for="">Year Level*</label> <br>
                <select id="schoolYear" name="schoolYear">
                    <option value="#"></option>
                    <option value="First Year">First Year</option>
                    <option value="Second Year">Second Year</option>
                    <option value="Third Year">Third Year</option>
                    <option value="Fourth Year">Fourth Year</option>
                </select>
            </div>
        </div>

        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs">   <label for="">Which Program are you registering for? *</label> <br>
                <select id="schoolYear" name="schoolYear">
                    <option value="#"></option>
                    <option value="First Year">College of Computer Studies</option>
                    <option value="Second Year">College of Commerce</option>
                    <option value="Third Year">College of Teacher Education</option>
                    <option value="Fourth Year">Psychology Program</option>
                    <option value="Fourth Year">College of Criminal Justice Education</option>
                </select>
            </div>
        </div>

        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs">   <label for="">Address*</label> <br>
                <input type="text" name="address">
            </div>
        </div>

        <div class="field-form-wrapper" style="display: block;">
            <div class="inputs" style="width: 100%; display:flex; justify-content: center;"> 
                <input type="submit" name="cta" value="Submit">
            </div>
        </div>

        

    </form>
        
    </div>


    


</body>
</html>