<!--
    ### STOCKHAWK ###
    managecash.php :
    Withdraw or Deposit cash to/from user's account.

-->


<html>
<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'land_chart.html' ?>
<body>
    <?php
        /*
            Check if session exists or not. If not then redirect to index.php
        */
        session_start();
        if(empty($_SESSION['login_user'])){
          header("location: index.php");exit();
        }
        require_once './config.php';
        $con = mysqli_connect($hostname, $username, $password, $databasename);  // Setup Connection with the database.
        if (mysqli_connect_errno()) {
          header("location: error.html");exit();
        }

        $q="select cash from user where uemail='$_SESSION[login_user]'";        // Get the present cash balance of user.
        $rs=mysqli_query($con,$q);
        $curcash=mysqli_fetch_array($rs);

        //Check if any error occured.
        if(isset($_GET['Message'])){
            echo '<script type="text/javascript">alert("Invalid Amount. Please try again.");</script>';
            unset($_GET['Message']);
        }
                                                                                // On clicking deposit button.
        if(isset($_POST['deposit'])){
            $val=$_POST['amount'];
            unset($_POST['deposit']);
            depositcash($con,$_SESSION['login_user'],$val);
        }
                                                                                //On clicking withdraw button
        if(isset($_POST['withdraw'])){
            $val=$_POST['amount'];
            unset($_POST['withdraw']);
            withdrawcash($con,$_SESSION['login_user'],$val);
        }


        /*
            Method - depositcash
            Adds cash to user's present cash balance.

            Arguements -
                  $con   - Connection Variable.
                  $uname - Username of current user.
                  $val   - Amount to deposit.

            Returns -
                  Null
        */
        function depositcash($con,$uname,$val){
            if(is_numeric($val)){
              $q1="update user set cash=cash+'$val' where uemail='$uname'";
              $rs1=mysqli_query($con,$q1);
              if(mysqli_errno($con)){
                  header("location: error.html");exit();
              }
              header("location: managecash.php");exit();
            }else{
              $msg="Invalid Input";
              header("location:managecash.php?Message=".urlencode($msg));exit();
            }
        }

        /*
            Method - withdrawcash
            withdraw cash from user's account.

            Arguements -
                  $con   - Connection Variable.
                  $uname - Username of current user.
                  $val   - Amount to deposit.

            Returns -
                Null
        */
        function withdrawcash($con,$uname,$val){
            // Check if enough cash is available.
            if(is_numeric($val)){
                $q1="select cash from user where uemail='$uname'";
                $rs1=mysqli_query($con,$q1);
                if(mysqli_errno($con)){
                    header("location: error.html");exit();
                }
                $row=mysqli_fetch_array($rs1);
                if($val>$row['cash']){
                    $val=$row['cash'];
                }
                //Update cash.
                $q2="update user set cash=cash-'$val' where uemail='$uname'";
                $rs2=mysqli_query($con,$q2);
                if(mysqli_errno($con)){
                    header("location: error.html");exit();
                }
                header("location: managecash.php");exit();
          }else{
            $msg="Invalid Input";
            header("location:managecash.php?Message=".urlencode($msg));exit();
          }
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
            <?php echo '<h5> Your Current cash balance is '.$curcash[0].'.</h6>'; ?>
            <!-- Simple Textfield -->
          <form method="post" name="manage_cash">
            <div class="mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="number" id="cname" name="amount">
              <label class="mdl-textfield__label" for="sample1">Amount</label>
            </div>

            <div class="mdl-card__actions mdl-card--border">
              <button type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--teal-500" name="deposit" >Deposit</button>
              <button type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--teal-500" name="withdraw" >Withdraw</button>
              <div class="mdl-layout-spacer"></div>
            </div>

          </form>
          </div>
        </div>
        <div id="toast" class="mdl-js-snackbar mdl-snackbar">
          <div class="mdl-snackbar__text"></div>
          <button class="mdl-snackbar__action" type="button"></button>
        </div>

        <script type="text/javascript">
          function manageCash(){
            var cash=document.getElementById('cname').value;
            var snackbarContainer=document.getElementById('toast');
            cash=cash.trim();
            if(!Number.isNaN(parseInt(cash))){
                document.manage_cash.submit();
                //return true;
            }else {
                document.getElementById('cname').value="";
                var data="Invalid Input! Please try again!";
                alert(data);
                //return false;
            }
          }
        </script>
      </main>
    </div>
    <script src="../../material.min.js"></script>
</body>
</html>
