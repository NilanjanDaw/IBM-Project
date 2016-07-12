<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header.html' ?>
<body>
  <script type="text/javascript">

  </script>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
    <main class="mdl-layout__content mdl-color--grey-100">
      <div class="mdl-grid demo-content">
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
  ?>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
    <main class="mdl-layout__content mdl-color--grey-100">
      <div class="mdl-grid demo-content">
        <?php
        $q1="select cname,baseprice from company";
        $rs1=mysqli_query($con,$q1);
        if(mysqli_errno($con)){
          header("location: error.html");exit();
        }
            while($r1=mysqli_fetch_array($rs1)) {
                $q2="select price from stockvalue where company='$r1[0]' order by stime desc";
                $rs2=mysqli_query($con,$q2);
                $cnt=0;$prev=0.00;$cur=$r1['baseprice'];
                if(mysqli_errno($con)){
                  header("location: error.html");exit();
                }
              while($r2=mysqli_fetch_array($rs2)) {
                if($cnt==0) {
                  continue;
                }else if($cnt==1){
                  $prev=$r2[0];break;
                }
                $cnt++;
              }
              if($prev==0){
                $prev=$cur;
              }
         ?>
        <div class="demo-graphs mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--6-col">
          <div class="demo-cards mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-grid mdl-grid--no-spacing">
            <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--6-col mdl-cell--6-col-tablet mdl-cell--12-col-desktop">
              <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                  <h2 class="mdl-card__title-text"><?php echo $r1[0] ?></h2>
                  <h6 class="mdl-card__title-text">&nbsp;&nbsp;&nbsp;
                    <?php echo round((($cur - $prev)/$prev * 100), 2)."%"; ?>
                  </h6>
              </div>
              <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Current Value: <?php echo $cur; ?>
              </div>
              <div class="mdl-card__actions mdl-card--border">
                <button name="company" value=<?php echo '"'.$r1[0].'"'; ?>
                  class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--teal-500" onclick="setData(this);">
                  Purchase
                </button>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
    </main>
  </div>
  <script type="text/javascript">
    function setData(object) {
      document.cookie = "company=" + object.value;
      window.location = "purchase.php";
    }
  </script>
  <script src="../../material.min.js"></script>
</body>
</html>
