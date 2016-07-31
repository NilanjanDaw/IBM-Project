<?php
/*
### STOCKHAWK ###
landing_graph_gen.php :
JSON object generator for user graph in landing page.
For more information on Google Charts visit: https://developers.google.com/chart/
*/
    session_start();
    /*
      Checking for available user session
    */
    if(empty($_SESSION['login_user'])){
      header("location: index.php");
    }
    require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';
    $con = mysqli_connect($hostname, $username, $password, $databasename);
    /*
    Connecting to database and checking for error in correction
    */
    if (mysqli_connect_errno()) {
      header("location: error.php");
      die("Failed to connect");
    }
    /*
    Getting information about user's stocks currently trading
    */
   $queryLabel = "select distinct company from utransaction where uemail = '".$_SESSION['login_user']."';";
   $labels = mysqli_query($con, $queryLabel);
   if (mysqli_errno($con)) {
     header("location: error.php");
     exit();
   }
   /*
   forming a temporary array to hold data according to the JSON format required by Google Area Charts API
   */
   $temp = array();
   $temp[] = array('label' => 'Transaction Date', 'type' => 'number');
   $company = array(); // Creating Labels for available companies
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
   /*
   Counting number of companies user have stakes
   */
   while ($row = mysqli_fetch_assoc($cResult)) {
     $count = (int)$row['c'];
   }
   /*
   Forming final data array
   */
    $rows = array();
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $temp = array();
      $t = array();
      $t[] = array('v' => (int)$i); // creating key value tuples
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
    /*
    JSONifying data array and echoing back to caller
    */
    $jsonData = json_encode($table);
    echo $jsonData;
?>
