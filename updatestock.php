<html>
<?php require_once '/header.html' ?>
<?php
      session_start();
      if(empty($_SESSION['login_user'])){
        header("location: land.php");exit();
      }
      if($_SESSION['user_type']=='user'){
        header("location: land.php");exit();
      }
      require_once '/config.php';
      $con = mysqli_connect($hostname, $username, $password, $databasename);
      if (mysqli_connect_errno()) {
        header("location: error.html");//die("Failed to connect");
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

              print all this values in tabular form.
        */
      }
      function updateValue($cname,$newval){
        $q1="insert into stockvalue values('$cname','$newval',now())";
        $r1=mysqli_query($con,$q1);
      }
?>
<body>
  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once '/header_bar.html' ?>
    <?php require_once '/sidebar.php' ?>
    <main class="mdl-layout__content mdl-color--grey-100">
      <div class="mdl-grid demo-content">
      </div>
    </main>
  </div>
  <script src="../../material.min.js"></script>
</body>
