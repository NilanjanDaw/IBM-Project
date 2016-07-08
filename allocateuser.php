<html>
<?php require_once '/header.html' ?>
<body>
<?php
    session_start();
    if(empty($_SESSION['login_user'])){
      header("location: land.php");exit();
    }
    if($_SESSION['user_type']=='user'){
      header("location: land.php");exit();
    }
    require_once '/config.php';
    $con = mysqli_connect($hostname, $username, $password, $databasename);
    if (mysqli_connect_errno()) {
      die("Failed to connect");
    }

    function allocate($uname,$aname){
      $q1="select * from user where uemail='$aname'";
      $rs1=mysqli_query($con,$q1);
      $r1=mysqli_fetch_array($rs1);
      if($rs1['isAdmin'] || $rs1['isPM']){
        $q2="update user set allotedto='$aname' where uname='$uname'";
        $rs2=mysqli_query($con,$q2);
      }
    }
?>

  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <?php require_once '/header_bar.html' ?>
      <?php require_once '/sidebar.php' ?>
      <!-- design here. call the allocate on clicking submit -->
      <main class="mdl-layout__content mdl-color--grey-100">
          <div class="mdl-grid demo--content">
          </div>
      </main>
  </div>
<script src="../../material.min.js"></script>
</body>
</html>
