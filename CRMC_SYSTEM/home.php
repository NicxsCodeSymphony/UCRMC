<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UCRMC</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/script2.js" defer></script>
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

             <div class="button-container">
                <button class="login-btn">LOG IN</button>
                <button class="signup-btn">SIGN UP</button>
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

                <div class="button-container-1">
                    <a href="#">GET STARTED</a>
                </div>
            </div>
        </div>
   </div>

    <div class="blur-bg-overlay"></div>
    <div class="form-popup">
        <span class="close-btn material-symbols-rounded">close</span>
        <div class="form-box login">
            <div class="form-details">
                <h2>Welcome Back</h2>
                <p>Please log in using your personal information to stay connected with us.</p>
            </div>
            <div class="form-content">
                <h2>LOGIN</h2>
                <form action="#">
                    <div class="input-field">
                        <input type="text" required>
                        <label>Email</label>
                    </div>
                    <div class="input-field">
                        <input type="password" required>
                        <label>Password</label>
                    </div>
                    <a href="#" class="forgot-pass-link">Forgot password?</a>
                    <button type="submit">Log In</button>
                </form>
                <div class="bottom-link">
                    Don't have an account?
                    <a href="#" id="signup-link">Signup</a>
                </div>
            </div>
        </div>
        <div class="form-box1 signup">
            <div class="form-content1">
                <h2>WELCOME ABOARD!</h2>
                <p>How do you like to Sign Up?</p>
                <form action="#">
                    <div class="btn-cta">
                        <button type="submit">Teacher</button>
                        <button type="submit">Student</button>
                    </div>
                </form>
                <div class="bottom-link">
                    Already have an account? 
                    <a href="#" id="login-link">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
