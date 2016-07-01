<?php
      session_start();
      if(empty($_SESSION['login_user'])){
        header("location: land.php");exit();
      }
      require_once '/config.php';
      $con = mysqli_connect($hostname, $username, $password, $databasename);
      if (mysqli_connect_errno()) {
        die("Failed to connect");
      }
      echo "hey nilanjan/priyangbada please design me";
?>
