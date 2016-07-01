<?php require_once '/header.html' ?>
<body>
  <script type="text/javascript">

  </script>
  <?php
      session_start();
      if(empty($_SESSION['login_user'])){
        header("location: index.php");
      }
      require_once '/config.php';
      $con = mysqli_connect($hostname, $username, $password, $databasename);
      if (mysqli_connect_errno()) {
        die("Failed to connect");
      }

      $q1="select distinct company from stockvalue";
      $rs1=mysqli_query($con,$q1);
      if(mysqli_errno($con)){
        header("location: error.php");exit();
      }

      while($r1=mysqli_fetch_array($rs1)){
        $q2="select price from stockvalue where company='$r1[0]' order by stime desc";
        $rs2=mysqli_query($con,$q2);
        $cnt=0;$prev=0.00;$cur=0.00;
        if(mysqli_errno($con)){
          header("location: error.php");exit();
        }
        while($r2=mysqli_fetch_array($rs2)){
          if($cnt==0){
            $cur=$r2[0];
          }else if($cnt==1){
            $prev=$r2[0];
          }else{
            break;
          }
          $cnt++;
        }
        if($prev==0.00){
          $prev=$cur;
        }
        /*
              Now you have the following information:
              1.Name of Company=                stored in $r1[0]
              2.Present value of company share= stored in $cur
              3.Previous value of share=        stored in $prev. (Use $cur- $prev to show change in stock value.)

              print all this values.
        */
      }

  ?>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once '/header_bar.html' ?>
    <?php require_once '/sidebar.html' ?>
    <main class="mdl-layout__content mdl-color--grey-100">
      <div class="mdl-grid demo-content">
        <div class="demo-graphs mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--6-col">
          <div class="demo-cards mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-grid mdl-grid--no-spacing">
            <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
              <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <h2 class="mdl-card__title-text">FB</h2>
              </div>
              <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Non dolore elit adipisicing ea reprehenderit consectetur culpa.
              </div>
              <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Purchase</a>
              </div>
            </div>
          </div>
        </div>
        <div class="demo-graphs mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--6-col">
          <div class="demo-cards mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-grid mdl-grid--no-spacing">
            <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
              <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <h2 class="mdl-card__title-text">INFY</h2>
              </div>
              <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Non dolore elit adipisicing ea reprehenderit consectetur culpa.
              </div>
              <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Purchase</a>
              </div>
            </div>
          </div>
        </div>
        <div class="demo-graphs mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--6-col">
          <div class="demo-cards mdl-cell mdl-cell--12-col mdl-cell--12-col-tablet mdl-grid mdl-grid--no-spacing">
            <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
              <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <h2 class="mdl-card__title-text">Updates</h2>
              </div>
              <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Non dolore elit adipisicing ea reprehenderit consectetur culpa.
              </div>
              <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Read More</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
  <script src="../../material.min.js"></script>
</body>
</html>
