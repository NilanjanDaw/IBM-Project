<html>
<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'land_chart.html' ?>
<body>
  <?php
      session_start();
      if(empty($_SESSION['login_user'])){
        header("location: index.php");
      }
      require_once './config.php';
      $con = mysqli_connect($hostname, $username, $password, $databasename);
      if (mysqli_connect_errno()) {
        //die("Failed to connect");
        header("location: error.html");exit();
      }

      if($_SERVER["REQUEST_METHOD"]=="POST"){
          $cname=$_POST['cname'];
          $stocksell=$_POST['newval'];
          perfomSell($con,$_SESSION['login_user'],$cname,$stocksell);
      }

      function perfomSell($con,$uname,$cname,$stocksell){
          $q1="select quantity,ttype from utransaction where uemail='$uname' and company='$cname'";
          $rs1=mysqli_query($con,$q1);
          if(mysqli_errno($con)){
              header("location: error.html");exit();
          }
          $curstock=0;
          while($r1=mysqli_fetch_array($rs1)){
              if($r1['ttype']==1){
                  $curstock=$curstock+$r1['quantity'];
              }else if($r1['ttype']==0){
                  $curstock=$curstock-$r1['quantity'];
              }
          }
          if($curstock<$stocksell){
              $stocksell=$curstock;
          }
          if($stocksell==0){
              header("location: sellstock.php");exit();
          }
          $qcompany="select * from company where cname='$cname'";
          $rscompany=mysqli_query($con,$qcompany);
          if(mysqli_errno($con)){
              header("location: error.html");exit();
          }
          $rowcompany=mysqli_fetch_array($rscompany);
          $newcash=$rowcompany['baseprice']*$stocksell;
          $newstock=$rowcompany['totalstock']+$stocksell;
          $newprice=($rowcompany['ratio']*1000)/$newstock;

          $quser="select * from user where uemail='$uname'";
          $rsuser=mysqli_query($con,$quser);
          if(mysqli_errno($con)){
              header("location: error.html");exit();
          }
          $rowuser=mysqli_fetch_array($rsuser);
          if($rowuser['allotedto']=="no"){
            echo '<script type="text/javascript">alert("User not alloted to any Manager.");</script>';
            header("location: sellstock.php");exit();
          }

          $qtransaction="insert into utransaction values('$uname','$rowuser[allotedto]',now(),'$cname',0,'$stocksell','$rowcompany[baseprice]')";
          $rstransaction=mysqli_query($con,$qtransaction);
          if(mysqli_errno($con)){
              header("location: error.html");exit();
          }

          $qupdateuser="update user set cash='$newcash' where uemail='$uname'";
          $rsupdateuser=mysqli_query($con,$quser);
          if(mysqli_errno($con)){
              header("location: error.html");exit();
          }

          $qupdatecompany="update company set totalstock='$newstock',baseprice='$newprice' where cname='$cname'";
          $rsupdatecompany=mysqli_query($con,$qupdatecompany);
          if(mysqli_errno($con)){
              header("location: error.html");exit();
          }

          $qstocktran="insert into stockvalue values('$cname','$newprice',now())";
          $rsstocktran=mysqli_query($con,$qstocktran);
          if(mysqli_errno($con)){
              header("location: error.html");exit();
          }
          header("location: sellstock.php");exit();
      }
  ?>

  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
    <main class="mdl-layout__content mdl-color--grey-100">
      <div class="demo-charts mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
        <div class="mdl-card__supporting-text mdl-color-text--teal-500">
          <h2>Your Shares</h2>
          <div class="mdl-cell mdl-cell--3"></div>
          <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp mdl-cell mdl-cell--6" id="sell">
            <thead>
              <tr>
                <th class="mdl-data-table__cell--non-numeric">Company</th>
                <th class="mdl-data-table__cell--non-numeric">Share</th>
              </tr>
            </thead>
            <tbody>
            <?php $q1="select cname from company";
                  $rs1=mysqli_query($con,$q1);
                  if(mysqli_errno($con)){
                    header("location: error.php");exit();
                  }
                  while($r1=mysqli_fetch_array($rs1)){
                      $q2="select quantity,ttype from utransaction where uemail='$_SESSION[login_user]' and company='$r1[0]'";
                      $rs2=mysqli_query($con,$q2);
                      if(mysqli_errno($con)){
                          header("location: error.html");exit();
                      }
                      $cur=0;
                      while($r2=mysqli_fetch_array($rs2)){
                          if($r2['ttype']==1){
                              $cur=$cur+$r2['quantity'];
                          }else if($r2['ttype']==0){
                              $cur=$cur-$r2['quantity'];
                          }
                      }
                      if($cur>0){
                        echo '<tr>
                          <td class="mdl-data-table__cell--non-numeric">'.$r1[0].'</td>
                          <td>'.$cur.'</td>
                        </tr>';
                      }
                  }
                  echo "</tbody>
                  </table>";
            ?>
            <div class="mdl-cell mdl-cell--3"></div>
          </div>
        </div>

        <div class="demo-separator mdl-cell--1-col"></div>
        <div class="demo-options mdl-card mdl-color--white-500 mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--12-col-desktop">
          <div class="mdl-card__supporting-text mdl-color-text--teal-500">
            <h3>Sell Stock</h3>
            <!-- Simple Textfield -->
          <form method="post">
            <div class="mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="text" id="cname" name="cname">
              <label class="mdl-textfield__label" for="sample1">Company</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="text" id="newval" name="newval">
              <label class="mdl-textfield__label" for="sample1">Stock to Sell</label>
            </div>

            <div class="mdl-card__actions mdl-card--border">
              <button type="submit" class="mdl-button mdl-button--raised mdl-js-button mdl-js-ripple-effect mdl-color-text--teal-500" name="split">Sell</button>
              <div class="mdl-layout-spacer"></div>
            </div>
          </form>
          </div>
        </div>
        <script type="text/javascript">
        function addRowHandlers() {
            var table = document.getElementById("sell");
            var rows = table.getElementsByTagName("tr");
            var customerAllocate = document.getElementById("cname");
            for (i = 0; i < rows.length; i++) {
                var currentRow = table.rows[i];
                var createClickHandler =
                    function(row)
                    {
                        return function() {
                                                var cell = row.getElementsByTagName("td")[0];
                                                var id = cell.innerHTML;
                                                customerAllocate.value = id;
                                                customerAllocate.label = false;
                                         };
                    };

                currentRow.onclick = createClickHandler(currentRow);
            }
          }
          window.onload = addRowHandlers();
        </script>
    </main>
  </div>
  <script src="../../material.min.js"></script>
</body>
</html>
