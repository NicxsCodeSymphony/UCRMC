<?php

  include "connection1.php";

  session_start();

  if(!isset($_REQUEST['user'])){
    header('Location: authentication.php');
    exit;
  }

  if(isset($_POST['but_logout'])){
    session_destroy();
    header("Location: authentication.php");
  }

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/hero.css">
  </head>
  <body>

    <form method='post' action="">
        <button type="submit" name="but_logout">Logout</button>
    </form>

  </body>
</html>
