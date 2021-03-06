<!--
    ### STOCKHAWK ###
    purchase.php :
    Allows user to buy stocks of a company.

-->
<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'chart_head.html' ?>
<body>
  <?php
    /*
        Check if session exists. If not, then redirect to index.php.
    */
    session_start();
    if(empty($_SESSION['login_user'])){
      header("location: index.php");exit();
    }
    require_once './config.php';
    $con = mysqli_connect($hostname, $username, $password, $databasename);      //Setup Connection with database.
    if (mysqli_connect_errno()) {
      header("location: error.php");
      exit();
    }
    //Error Checking
    if(isset($_GET['Message'])){
      $msg=$_GET['Message'];
      unset($_GET['Message']);
      echo '<script type="text/javascript">alert("'.$msg.'");</script>';
    }

    $cname=$_COOKIE['company'];
    $uname=$_SESSION['login_user'];
    if (array_key_exists('isPurchase', $_POST) && $_POST["isPurchase"] == "true") {
      # Run all your queries here...
      $numberOfStocks = $_POST["stock_num"];
      unset($_POST["isPurchase"]);
      echo '<script type= "text/javascript">console.log("Test");</script>';
      buystock($con,$cname,$uname,$numberOfStocks);
    }
    /*
      Method - buystock
      Perform stock transaction. Users buy stock.

      Arguements -
            $con      - Connection Variable
            $cname    - Name of company
            $uname    - Username of user
            $stocknum - Number of stocks.

      Returns -
            Null
    */
    function buystock($con,$cname,$uname,$stocknum){
        // company details.
        $qcompany="select * from company where cname='$cname'";
        $rscompany=mysqli_query($con,$qcompany);
        if(mysqli_errno($con)){
            header("location: error.html");exit();
        }
        $rowcompany=mysqli_fetch_array($rscompany);

        //Checking if Enough stock is available.
        if($rowcompany['totalstock'] < $stocknum){
            $msg="Enough stock not available";
            header("location: purchase.php?Message=".urlencode($msg));exit();
        }

        //Checking if enough cash is available.
        $totalcost=$stocknum * $rowcompany['baseprice'];
        $quser="select * from user where uemail='$uname'";
        $rsuser=mysqli_query($con,$quser);
        if(mysqli_errno($con)){
            header("location: error.html");
        }
        $rowuser=mysqli_fetch_array($rsuser);
        if($rowuser['cash'] <= $totalcost){
            $msg="Enough cash not available";
            header("location: purchase.php?Message=".urlencode($msg));exit();
        }
        if($rowuser['allotedto']=="no"){
          $msg="User not alloted to any manager";
          header("location: purchase.php?Message=".urlencode($msg));exit();
        }

        //Inserting record in utransaction table.
        $qtransaction="insert into utransaction values('$uname','$rowuser[allotedto]',now(),'$cname',1,'$stocknum','$rowcompany[baseprice]')";
        $rstransaction=mysqli_query($con,$qtransaction);
        if(mysqli_errno($con)){
            header("location: error.html");exit();
        }
        //Calculating new price per stock.
        $newstock=$rowcompany['totalstock']-$stocknum;
        $newprice=($rowcompany['ratio']*1000)/$newstock;
        $newcash=$rowuser['cash']-$totalcost;
        $qstocktran="insert into stockvalue values('$cname','$newprice',now())";
        $rsstocktran=mysqli_query($con,$qstocktran);
        if(mysqli_errno($con)){
            header("location: error.html");exit();
        }

        // Updating the user.
        $qupdateuser="update user set cash='$newcash' where uemail='$uname'";

        $rsupdateuser=mysqli_query($con,$qupdateuser);
        if(mysqli_errno($con)){
            header("location: error.html");exit();
        }

        //Updaing the company attributes.
        $qupdatecompany="update company set totalstock='$newstock',baseprice='$newprice' where cname='$cname'";
        $rsupdatecompany=mysqli_query($con,$qupdatecompany);
        if(mysqli_errno($con)){
            header("location: error.html");exit();
        }
        header("location: purchase.php");exit();
    }

  ?>
  <style>

    .mdl-dialog {
      border: none;
      box-shadow: 0 9px 46px 8px rgba(0, 0, 0, 0.14), 0 11px 15px -7px rgba(0, 0, 0, 0.12), 0 24px 38px 3px rgba(0, 0, 0, 0.2);
      width: 280px; }
      .mdl-dialog__title {
        padding: 24px 24px 0;
        margin: 0;
        font-size: 2.5rem; }
      .mdl-dialog__actions {
        padding: 8px 8px 8px 24px;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-flex-direction: row-reverse;
            -ms-flex-direction: row-reverse;
                flex-direction: row-reverse;
        -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
                flex-wrap: wrap; }
        .mdl-dialog__actions > * {
          margin-right: 8px;
          height: 36px; }
          .mdl-dialog__actions > *:first-child {
            margin-right: 0; }
        .mdl-dialog__actions--full-width {
          padding: 0 0 8px 0; }
          .mdl-dialog__actions--full-width > * {
            height: 48px;
            -webkit-flex: 0 0 100%;
                -ms-flex: 0 0 100%;
                    flex: 0 0 100%;
            padding-right: 16px;
            margin-right: 0;
            text-align: right; }
      .mdl-dialog__content {
        padding: 20px 24px 24px 24px;
        color: rgba(0,0,0, 0.54); }
    </style>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
    <main class="mdl-layout__content mdl-color--grey-100">
      <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <!--<label class="">ALL HAIL!!! Enter folio details </label>-->

      </div>
      <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
        <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
          <h1 class="mdl-card__title-text mdl-color-text--white"><b><?php echo $_COOKIE['company'] ?></b></h1>
        </div>
      </div>
      <div class="demo-separator mdl-cell--1-col"></div>
      <div class="demo-options mdl-card mdl-color--white-500 mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--12-col-desktop">
        <div class="mdl-card__supporting-text mdl-color-text--teal-500">
          <h3>Purchase Stock</h3>
        <?php
            //Display the stock details.
            $row = 0;
            $query = "select price from stockvalue where company ='".$_COOKIE['company']."' order by stime desc limit 1;";
            $res = mysqli_query($con, $query);
            while ($row = mysqli_fetch_assoc($res)) {
              echo '
                <div class="mdl-card__supporting-text mdl-color-text--teal-500">
                  <div class="mdl-cell mdl-cell--3-col"><h5>Current Price '.$row['price'].' </h5></div>';
             }
             $q1="select * from user where uemail='".$_SESSION['login_user']."'";
             $rs1=mysqli_query($con, $q1);
             if(mysqli_errno($con)){
                 header("location: error.html");exit();
             }
             while($row = mysqli_fetch_assoc($rs1)) {
               echo '
                   <div class="mdl-cell mdl-cell--3-col">Credit Balance: $'.$row['cash'].'</div>
                  </div>';

             }
         $_COOKIE['stock_price'] = $row['price'];
         ?>
           <form action="purchase.php" method="post" name="purchase_stocks">
             <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
               <input class="mdl-textfield__input" type="text" pattern="-?[0-9]*(\.[0-9]+)?" name="stock_num" onchange="calculate();">
               <label class="mdl-textfield__label" for="stock_num">Enter number of Stocks</label>
               <span class="mdl-textfield__error">Input is not a number!</span>
               <input type="hidden" name="isPurchase" id="isPurchase" value="false" />
             </div>
             <div class="mdl-card__actions mdl-card--border">
               <button type="button" name="pur" class="mdl-button mdl-button--raised mdl-js-button mdl-js-ripple-effect mdl-color-text--teal-500 show-modal">Purchase</button>
             </div>
             <div class="mdl-layout-spacer"></div>
         </form>
        </div>
        <dialog class="mdl-dialog">
          <h3 class="mdl-dialog__title">Purchase</h3>
          <div class="mdl-dialog__content">
            <p>
              Are you sure you want to buy the stocks?
            </p>
          </div>
         <div class="mdl-dialog__actions mdl-dialog__actions--full-width">
           <button type="button" class="mdl-button buy">Purchase</button>
           <button type="button" class="mdl-button close">Cancel</button>
         </div>
       </dialog>
       <script src='https://cdnjs.cloudflare.com/ajax/libs/dialog-polyfill/0.4.2/dialog-polyfill.min.js'></script>
       <script src='https://storage.googleapis.com/code.getmdl.io/1.0.6/material.min.js'></script>
       <script type="text/javascript">

         var dialog = document.querySelector('dialog');
         var showModalButton = document.querySelector('.show-modal');
         var ispurchase = document.getElementById("isPurchase");
         if (! dialog.showModal) {
           dialogPolyfill.registerDialog(dialog);
         }
         showModalButton.addEventListener('click', function() {
           dialog.showModal();
         });
         dialog.querySelector('.close').addEventListener('click', function() {
           dialog.close();
         });
         dialog.querySelector('.buy').addEventListener('click', function() {
           dialog.close();
           ispurchase.value = "true";
           document.purchase_stocks.submit();
         });

       </script>
      </div>
      <div class="mdl-grid demo-content" id="graph_grid">
      </div>
    </main>
  </div>
<script src="../../material.min.js"></script>
</body>
</html>
