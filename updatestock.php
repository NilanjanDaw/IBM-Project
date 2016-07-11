<html>
<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header.html' ?>

<?php
      session_start();
      if(empty($_SESSION['login_user'])){
        header("location: land.php");exit();
      }
      if($_SESSION['user_type']=='user'){
        header("location: land.php");exit();
      }
      require_once './config.php';
      $con = mysqli_connect($hostname, $username, $password, $databasename);
      if (mysqli_connect_errno()) {
        header("location: error.html");//die("Failed to connect");
      }

      if(isset($_POST['split'])){
          $cname=$_POST['cname'];
          $val=$_POST['newval'];
          unset($_POST['split']);$_POST=array();
          splitStock($con,$cname,$val);
      }

      if(isset($_POST['addco'])){
          $cname=$_POST['cname2'];
          $totalstock=$_POST['totalstock'];
          $baseprice=$_POST['baseprice'];
          $rat=($totalstock*$baseprice)/1000;
          unset($_POST['addco']);$_POST=array();
          addcompany($con,$cname,$totalstock,$rat,$baseprice);
      }

      function addcompany($con,$cname,$tot,$rat,$base){
          $q1="insert into company values('$cname','$tot','$rat','$base')";
          $rs1=mysqli_query($con,$q1);
          if(mysqli_errno($con)){
              header("location:error.html");
              exit();
          }
          header("location: updatestock.php");
      }


      function splitStock($con,$cname,$val){
          $q1="update company set totalstock=totalstock* '$val' where cname='$cname'";
          $rs1=mysqli_query($con,$q1);
          if(mysqli_errno($con)){
            header("location: error.php");exit();
          }else {
            $q2="select totalstock,ratio from company where cname='$cname'";
            $rs2=mysqli_query($con,$q2);
            if(mysqli_errno($con)){
              //do it;
            }
            $count=mysqli_num_rows($rs2);
            if($count>0){
              $r2=mysqli_fetch_array($rs2);
              $newprice=($r2['ratio']*1000)/$r2['totalstock'];
              $q3="insert into `stockvalue` values('$cname','$newprice',now())";
              $rs3=mysqli_query($con,$q3);
              if(mysqli_errno($con)){
                //do it;
              }
              $q4="update company set baseprice='$newprice' where cname='$cname'";
              $rs4=mysqli_query($con,$q4);
              if(mysqli_errno($con)){
                //do it;
              }
            }
            header("location: updatestock.php");exit();
          }
      }
      function updateValue($cname,$newval){
        $q1="insert into stockvalue values('$cname','$newval',now())";
        $r1=mysqli_query($con,$q1);
      }
?>
<body>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
    <main class="mdl-layout__content mdl-color--grey-100">
      <div class="mdl-grid demo-content">
      </div>

  <div class="demo-charts mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
    <div class="mdl-card__supporting-text mdl-color-text--teal-500">
      <h2>Company Shares</h2>
    </div>
      <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
        <thead>
          <tr>
            <th class="mdl-data-table__cell--non-numeric">Company</th>
            <th class="mdl-data-table__cell--non-numeric">Total Share</th>
            <th class="mdl-data-table__cell--non-numeric">Ratio</th>
            <th class="mdl-data-table__cell--non-numeric">Price</th>
          </tr>
        </thead>
        <tbody>
        <?php $q1="select * from company";
              $rs1=mysqli_query($con,$q1);
              if(mysqli_errno($con)){
                header("location: error.php");exit();
              }
              while($r1=mysqli_fetch_array($rs1)){
                echo '<tr>
                  <td class="mdl-data-table__cell--non-numeric">'.$r1[0].'</td>
                  <td>'.$r1[1].'</td>
                  <td>'.$r1[2].'</td>
                  <td>'.$r1[3].'</td>
                </tr>';
              }
              echo "</tbody>
              </table>";?>
        </div>

        <div class="demo-separator mdl-cell--1-col"></div>
        <div class="demo-options mdl-card mdl-color--white-500 mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--12-col-desktop">
          <div class="mdl-card__supporting-text mdl-color-text--teal-500">
            <h3>Stock Split</h3>
            <!-- Simple Textfield -->
          <form method="post">
            <div class="mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="text" id="cname" name="cname">
              <label class="mdl-textfield__label" for="sample1">Company</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="text" id="newval" name="newval">
              <label class="mdl-textfield__label" for="sample1">Split Share</label>
            </div>

            <div class="mdl-card__actions mdl-card--border">
              <button type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--teal-500" name="split">Spilt</button>
              <div class="mdl-layout-spacer"></div>
            </div>
          </form>
          </div>
        </div>

        <div class="demo-separator mdl-cell--1-col"></div>
        <div class="demo-options mdl-card mdl-color--white-500 mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--12-col-desktop">
          <div class="mdl-card__supporting-text mdl-color-text--teal-500">
            <h3>Add Stock</h3>
            <!-- Simple Textfield -->
          <form method="post">
            <div class="mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="text" id="cname2" name="cname2">
              <label class="mdl-textfield__label" for="sample2">Company</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="text" id="totalstock" name="totalstock">
              <label class="mdl-textfield__label" for="sample2">Total Stock</label>
            </div>
            <div class="mdl-textfield mdl-js-textfield">
              <input class="mdl-textfield__input" type="text" id="baseprice" name="baseprice">
              <label class="mdl-textfield__label" for="sample2">Base Price</label>
            </div>

            <div class="mdl-card__actions mdl-card--border">
              <button type="submit" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--teal-500" name="addco">Add</button>
              <div class="mdl-layout-spacer"></div>
            </div>
          </form>
          </div>
        </div>

    </main>
  </div>
  <script src="../../material.min.js"></script>
</body>
