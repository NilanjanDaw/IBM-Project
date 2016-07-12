<?php
    session_start();
    if(empty($_SESSION['login_user'])){
      header("location: index.php");
    }
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';
    $con = mysqli_connect($hostname, $username, $password, $databasename);
    if (mysqli_connect_errno()) {
      die("Failed to connect");
    }
   $queryLabel = "select distinct company from utransaction where uemail = '".$_SESSION['login_user']."';";
   $labels = mysqli_query($con, $queryLabel);
   if (mysqli_errno($con)) {
     header("location: error.php");
     exit();
   }
   $temp = array();
   $temp[] = array('label' => 'Transaction Date', 'type' => 'number');
   $company = array();
   while ($row = mysqli_fetch_assoc($labels)) {
     $temp[] = array('label' => $row['company'], 'type' => "number");
     $company[] = $row['company'];
   }
   $table['cols'] = $temp;

   $query = "select t.company company, s.stime time, s.price price from stockvalue s
                inner join utransaction t where s.company = t.company
                and uemail = '".$_SESSION['login_user']."' order by time asc;";
   $result = mysqli_query($con, $query);
   if(mysqli_errno($con)){
     header("location: error.php");exit();
   }

   $countQuery = "select count('company') as c from utransaction where uemail = '".$_SESSION['login_user']."';";
   $cResult = mysqli_query($con, $countQuery);
   if (mysqli_errno($con)) {
     header("location: error.php");
     exit();
   }
   while ($row = mysqli_fetch_assoc($cResult)) {
     $count = (int)$row['c'];
   }

    $rows = array();
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $temp = array();
      $t = array();
      $t[] = array('v' => (int)$i);
      for ($j = 0; $j < count($company); $j++) {
        if (array_search($row['company'], $company) == $j)
          $t[] = array('v' => (float)$row['price']);
        else {
          $t[] = array('v' => null);
        }
      }
      $temp = $t;
      $rows[] = array('c' => $temp);
      $i++;
    }
    $table['rows'] = $rows;
    $jsonData = json_encode($table);
    echo $jsonData;
?>
