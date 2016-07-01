<?php
      session_start();
      if(empty($_SESSION['login_user'])){
        header("location: index.php");
      }
      require_once '/config.php';
      $con = mysqli_connect($hostname, $username, $password, $databasename);
      if (mysqli_connect_errno()) {
        die("Failed to connect");
      }

      $u=$_SESSION['login_user'];
      $query="select msgbody,touser from message where fromuser='$u'";
      $res=mysqli_query($con,$query);
      if(mysqli_errno($con)){
        echo mysqli_errno($con).": ".mysqli_error($con);
        //header("location: error.php");exit();
      }
      while($row=mysqli_fetch_array($res)){
        //print the message in the boxes.
      }
      echo "Hey nilanjan/priyangbada please design me.";
?>
