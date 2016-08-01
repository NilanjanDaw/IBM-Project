<!--
    ### STOCKHAWK ###
    sentbox.php :
    List all the messages sent by the user.

-->
<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header.html' ?>
<body>
  <style>
  .demo-charts:hover {
    box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
  }
  </style>
<?php
      /*
        Check if session exists. If not, redirect to index.php
      */
      session_start();
      if(empty($_SESSION['login_user'])){
        header("location: index.php");exit();
      }
      require_once './config.php';
      $con = mysqli_connect($hostname, $username, $password, $databasename);
      if (mysqli_connect_errno()) {
        header("location: error.html");//die("Failed to connect");
      }
      
      /*
        Sending message to server.
      */
      /*if (array_key_exists('message', $_POST)) {
        # code...
        $fromuser = $_SESSION['login_user'];
        $query = "insert into message(msgbody, touser, fromuser) values('"
              .$_POST['message']."', '".$_POST['destination']."', '".$fromuser."');";
        $res=mysqli_query($con,$query);
        if(mysqli_errno($con)) {
            echo 'error occured';
            header("location: error.html");
        }
      }

      /*
          Query to list all sent messages.
      */
      $u=$_SESSION['login_user'];
      $query="select msgbody,touser from message where fromuser='$u';";
      $res=mysqli_query($con,$query);
      if(mysqli_errno($con)){
          header("location:error.php");exit();
      }

?>
<div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
  <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
  <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
  <main class="mdl-layout__content mdl-color--grey-100">
      <div class="mdl-layout__content">
        <div class="demo-cards mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-grid mdl-grid--no-spacing">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
              <h2 class="mdl-card__title-text">Sent Messages</h2>
            </div>
              <?php
              $row=0;
              // Printing all the messages
              while($row=mysqli_fetch_array($res)) {

                echo '
                <div class="demo-charts mdl-color--white mdl-shadow--8dp mdl-cell mdl-cell--12-col mdl-grid">
                  <div class="mdl-card__supporting-text mdl-color-text--black-500">'.$row['touser'].'
                    <br /><p>'.$row['msgbody'].'</p>
                  </div>
                </div>';
             } ?>
      </div>
    </div>
  </main>
  <script src="../../material.min.js"></script>
</body>
</html>
