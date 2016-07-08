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

    $query = "select stime, price from stockvalue where company ='".$_COOKIE['company']."' order by stime asc;";
    $result = mysqli_query($con, $query);
    if(mysqli_errno($con)){
      header("location: error.php");exit();
    }
   $table['cols'] = array(
   array('label' => 'Transaction Date', 'type' => 'number'),
   array('label' => 'Total Count', 'type' => 'number'),
   );
    $rows = array();
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $temp = array();
      $temp = array(
        array('v' => (int)$i),
        array('v' => (int)$row['price'])
      );
      $rows[] = array('c' => $temp);
      $i++;
    }
    $table['rows'] = $rows;
    $jsonData = json_encode($table);
    echo $jsonData;
?>
