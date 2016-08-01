<!--
    ### STOCKHAWK ###
    error_submit.php :
    Allows user to report any error in the website.

-->


<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header.html' ?>
<body>
  <script type="text/javascript">

  </script>
  <?php
      /*
          Check if the existing session expired or not. If expired, redirect to index.php
      */
      session_start();
      if(empty($_SESSION['login_user'])){
        header("location: index.php");exit();
      }
      require_once './config.php';
      $con = mysqli_connect($hostname, $username, $password, $databasename);    // Setup connection with the database
      if (mysqli_connect_errno()) {
        //die("Failed to connect");
        header("location: error.html");
      }

      //checking for error
      if(isset($_GET['Message'])){
        $msg=$_GET['Message'];
        unset($_GET['Message']);
        echo '<script type="text/javascript">alert("'.$msg.'");</script>';
      }

      $u=$_SESSION['login_user'];


      /*
          Checks if the button is set or not. If set, a query is executed to insert error message into the database.
      */
      if (isset($_POST["error_button"])) {
        $message = $_POST["error_msg"];
        $time = time();
        $query = "insert into error_tracker(uname, message, time_stamp)
          values('".$_SESSION["login_user"]."', '$message', FROM_UNIXTIME($time));";
        if (!mysqli_query($con, $query)) {
          header("location: error.php");exit();
        }
      }

  ?>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
    <main class="mdl-layout__content mdl-color--red-50">
        <div class="mdl-grid demo-content">
          <div class="demo-separator mdl-cell--1-col"></div>
          <div class="demo-options mdl-card mdl-color--white-500 mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--12-col-desktop">
            <div class="mdl-card__supporting-text mdl-color-text--red-500">
              <h3>Report Error</h3>
              <!-- Simple Textfield -->
              <form action="error_submit.php" name="err" method="post">

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--12-col">
                  <textarea class="mdl-textfield__input" type="text" id="msgbody" rows="10" name="error_msg"></textarea>
                  <label class="mdl-textfield__label" for="error_msg">Describe the issue within 500 characters</label>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                  <input type="button" name="error_button" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--red-500" value="Send" onclick="check()">
                  <div class="mdl-layout-spacer"></div>
                </div>
              </form>
            </div>

          </div>
        </div>
        <script type="text/javascript">
          function check(){
            var msg=document.getElementById('msgbody').value;
            msg.trim();
            if(msg==''){
              alert('Message cannot be empty');
            }else{
              document.err.submit();
            }
          }
        </script>
    </main>
          <!--<a href="https://github.com/google/material-design-lite/blob/master/templates/dashboard/" target="_blank" id="view-source" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--accent mdl-color-text--accent-contrast">View Source</a> -->
  <script src="../../material.min.js"></script>
</body>
</html>
