<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'chart_head.html' ?>
<body>
  <script type="text/javascript"></script>
  <?php
    session_start();
    if(empty($_SESSION['login_user'])){
      header("location: index.php");
    }
    require_once './config.php';
    $con = mysqli_connect($hostname, $username, $password, $databasename);
    if (mysqli_connect_errno()) {
      die("Failed to connect");
    }


  ?>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
    <main class="mdl-layout__content mdl-color--grey-100">
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
        $row = 0;
        $query = "select price from stockvalue where company ='".$_COOKIE['company']."' order by stime desc limit 1;";
        $res = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($res)) {
          echo '
            <div class="mdl-card__supporting-text mdl-color-text--teal-500">
              <div class="mdl-cell mdl-cell--3-col"><h5>Current Price '.$row['price'].' </h5></div>
            </div>';
         }
         ?>
         </div>
      </div>
      <div class="mdl-grid demo-content" id="graph_grid">

      </div>
    </main>
  </div>
<script src="../../material.min.js"></script>
</body>
</html>
