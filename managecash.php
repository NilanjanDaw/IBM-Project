<html>
<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'land_chart.html' ?>
<body>
    <?php
        session_start();
        if(empty($_SESSION['login_user'])){
          header("location: index.php");exit();
        }
        require_once './config.php';
        $con = mysqli_connect($hostname, $username, $password, $databasename);
        if (mysqli_connect_errno()) {
          //die("Failed to connect");
          header("location: error.html");exit();
        }

        if(isset($_POST['deposit'])){
            $val=$_POST['amount'];
            unset($_POST['deposit']);
            depositcash($con,$_SESSION['login_user'],$val);
        }
        if(isset($_POST['withdraw'])){
            $val=$_POST['amount'];
            unset($_POST['withdraw']);
            withdrawcash($con,$_SESSION['login_user'],$val);
        }

        function depositcash($con,$uname,$val){
            $q1="update user set cash=cash+'$val' where uemail='$uname'";
            $rs1=mysqli_query($con,$q1);
            if(mysqli_errno($con)){
                header("location: error.html");exit();
            }
            header("location: managecash.php");exit();
        }

        function withdrawcash($con,$uname,$val){
            $q1="select cash from user where uemail='$uname'";
            $rs1=mysqli_query($con,$q1);
            if(mysqli_errno($con)){
                header("location: error.html");exit();
            }
            $row=mysqli_fetch_array($rs1);
            if($val>$row['cash']){
                $val=$row['cash'];
            }
            $q2="update user set cash=cash-'$val' where uemail='$uname'";
            $rs2=mysqli_query($con,$q2);
            if(mysqli_errno($con)){
                header("location: error.html");exit();
            }
            header("location: managecash.php");exit();
        }
    ?>

    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
      <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
      <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
      <main class="mdl-layout__content mdl-color--grey-100">

        <div class="demo-separator mdl-cell--1-col"></div>
        <div class="demo-options mdl-card mdl-color--white-500 mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--12-col-desktop">
          <div class="mdl-card__supporting-text mdl-color-text--teal-500">
            <h3>Manage Cash</h3>
            <!-- Simple Textfield -->
          <form method="post">
            <div class="mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="text" id="cname" name="amount">
              <label class="mdl-textfield__label" for="sample1">Amount</label>
            </div>

            <div class="mdl-card__actions mdl-card--border">
              <button type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--teal-500" name="deposit">Deposit</button>
              <button type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--teal-500" name="withdraw">Withdraw</button>
              <div class="mdl-layout-spacer"></div>
            </div>

          </form>
          </div>
        </div>

      </main>
    </div>
    <script src="../../material.min.js"></script>
</body>
</html>
