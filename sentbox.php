<html>
<?php require_once './header.html' ?>
<body>
<?php
      session_start();
      if(empty($_SESSION['login_user'])){
        header("location: index.php");
      }
      require_once './config.php';
      $con = mysqli_connect($hostname, $username, $password, $databasename);
      if (mysqli_connect_errno()) {
        header("location: error.html");//die("Failed to connect");
      }
      $u=$_SESSION['login_user'];
      $query="select msgbody,touser from message where fromuser='$u';";
      $res=mysqli_query($con,$query);
      if(mysqli_errno($con)){
          echo 'error occured';
      }
      /*
        Sending message to server. Nilanjan Says Hello! :p
      */

?>
<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
  <?php require_once './header_bar.html' ?>
  <?php require_once './sidebar.php' ?>
  <main class="mdl-layout__content mdl-color--grey-100">
      <div class="mdl-layout__content mdl-color--grey-100">
          <!--<div class="demo-cards mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-grid mdl-grid--no-spacing">-->
              <?php
              $row=0;
              while($row=mysqli_fetch_array($res)) {
                echo '
                <div class="demo-cards mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-grid mdl-grid--no-spacing">
                  <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                      <h2 class="mdl-card__title-text">'.$row['touser'].'</h2>
                  </div>
                  <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                      <div class="mdl-cell mdl-cell--3-col">'.$row['msgbody'].'</div>
                  </div>
                </div> ';
             } ?>
          <!--</div>-->
      </div>
  </main>
  <script src="../../material.min.js"></script>
</body>
</html>
