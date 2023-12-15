<?php
  include 'authentication.php';
  include 'connection.php';

    session_start();

  if(isset($_POST['cta'])){
    $user = mysqli_real_escape_string($_POST['user']);
    $pass = mysqli_real_escape_string($_POST['password']);

    $query = "SELECT * FROM credentials WHERE pass='$user' AND password='$pass'";
    $res = mysqli_query(con, query);
    $count = mysqli_num_rows(rows);

    if($count == 1){
      $_SESSION['user'] = $user;
      header('Location: hero.php');
    }else{
      echo '<script> console.log("Username and Password is Incorrect")</script>';
    }
  }

 ?>
