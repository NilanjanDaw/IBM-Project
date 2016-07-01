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

      $query = "select price from stockvalue where company ='".$_POST['company']."' order by stime desc;";
      $result = mysqli_query($con, $query);
      if(mysqli_errno($con)){
        header("location: error.php");exit();
      }

      $parameter = "select max(price) max, min(price) min, count(price) count from stockvalue where company ='".$_POST['company']."' order by stime desc;";
      $result_para = mysqli_query($con, $parameter);
      if(mysqli_errno($con)){
        header("location: error.php");exit();
      }
      $para = mysqli_fetch_array($result_para);

  ?>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once '/header_bar.html' ?>
    <?php require_once '/sidebar.html' ?>
    <main class="mdl-layout__content mdl-color--grey-100">
      <div class="mdl-grid demo-content">
        <div class="demo-graphs mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--8-col">
          <svg fill="currentColor" viewBox=
          <?php
            echo '"0 ';
            echo $para["min"].' '.($para["count"] * 100).' '.$para["max"].'"';
           ?>
           class="demo-graph">
            <use xlink:href="#chart">
          </svg>
        </div>
      </div>
    </main>
  </div>
  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 250" style="position: fixed; left: -1000px; height: -1000px;">
    <defs>
      <g id="chart">

        <g id="Layer_4">
          <polyline fill = "none"
          stroke = "teal"
          stroke-width="3" points=
          <?php
            $count = 0;
            echo '"';
            while ($row = mysqli_fetch_array($result)) {
              echo $count.",".$row['price']." ";
              $count += 50;
            }
            echo '"';
           ?>
          >
        </g>
      </g>
    </defs>
  </svg>
<script src="../../material.min.js"></script>
</body>
</html>
