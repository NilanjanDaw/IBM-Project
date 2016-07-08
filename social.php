<html>
<?php require_once '/header.html' ?>
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

?>
<body>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once '/header_bar.html' ?>
    <?php require_once '/sidebar.php' ?>
    <?php
          $q1="select uname from user where isPm=true";
          $rs1=mysqli_query($con,$q1);
          if(mysqli_errno($con)){
            header("location: error.php");exit();
          }
          while($r1=mysqli_fetch_array($rs1)){
              $q2="select uname from user where allotedto='$r1[0]'";
              $rs2=mysqli_query($con,$q2);
              if(mysqli_errno($con)){
                  header("location: error.php");exit();
              }
              while($r2=mysqli_fetch_array($rs2)){
                  // print here.
              }
          }
    ?>
    <main class="mdl-layout__content mdl-color--grey-100">
      <div class="mdl-grid demo-content">
      </div>
    </main>
  </div>
  <script src="../../material.min.js"></script>
</body>
</html>
