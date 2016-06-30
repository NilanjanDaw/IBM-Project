<?php
    session_start();
    echo 'so you are here finally.prepare to die';
    if(empty($_SESSION['login_user'])){
      header("location: index.php");
      exit();
    }else {
      session_destroy();
      header("location: index.php");
      exit();
    }
 ?>
