<!--
    ### STOCKHAWK ###
    allocateuser.php :
    Allocates all the new users who donot have any Portfolio manager assigned to them.

-->

<html>
<?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header.html' ?>
<body>
<?php
    /*
    Check if the existing session expired or not. If expired, redirect to index.php.
    */
    session_start();
    if(empty($_SESSION['login_user'])){
      header("location: land.php");exit();
    }
    if($_SESSION['user_type']=='user'){
      header("location: land.php");exit();
    }
    require_once './config.php';
    $con = mysqli_connect($hostname, $username, $password, $databasename);      // Setup connection with the database.
    if (mysqli_connect_errno()) {
      //die("Failed to connect");
      header("location: error.html");exit();
    }

    if($_SERVER["REQUEST_METHOD"]=="POST"){
        $uname=$_POST['uname'];
        $aname=$_POST['aname'];
        allocate($con,$uname,$aname);
    }

    /*
        Method - allocate
        Allocates a manager to an unallocated user one at a time.

        Arguements -
            $con   - Connection Variable. Checks if the connection is broken or not.
            $uname - Name of user who donot have any Manager alloted to them.
            $aname - Name of Manager who will be assigned to the present user.

        Returns -
            Null
    */
    function allocate($con,$uname,$aname){
      $q0="select uemail from user where uemail='$aname' and isAdmin=true or isPM=true";
      $rs0=mysqli_query($con,$q0);
      $cnt=mysqli_num_rows($rs0);
      if($cnt>0){
        $q1="update user set allotedto='$aname' where uemail='$uname'";
        $rs1=mysqli_query($con,$q1);
        if(mysqli_errno($con)){header("location: error.php");}
      }else{
         echo '<script type="text/javascript">alert("No such Admin/PM exists.");</script>';
      }


    }
?>

  <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'header_bar.html' ?>
    <?php require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'sidebar.php' ?>
      <!-- design here. call the allocate on clicking submit -->
      <main class="mdl-layout__content mdl-color--grey-100">
          <div class="mdl-grid demo--content">
          </div>

          <div class="demo-charts mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--12-col">
            <div class="mdl-card__supporting-text mdl-color-text--teal-500">
              <h2>Unalloted Users</h2>

              <table class="mdl-data-table mdl-js-data-table" id="allocate_table">
                <thead>
                  <tr>
                    <th class="mdl-data-table__cell--non-numeric">Email</th>
                    <th class="mdl-data-table__cell--non-numeric">Name</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                      /*
                        List all the unallocated users.
                      */
                      $q1="select uemail,uname from user where allotedto='no'";
                      $rs1=mysqli_query($con,$q1);
                      if(mysqli_errno($con)){
                        header("location: error.php");exit();
                      }
                      while($r1=mysqli_fetch_array($rs1)){
                        echo '<tr>
                          <td class="mdl-data-table__cell--non-numeric">'.$r1[0].'</td>
                          <td>'.$r1[1].'</td>
                        </tr>';
                      }
                      echo "</tbody>
                      </table>";?>
              </div>
          </div>

          <div class="demo-separator mdl-cell--1-col"></div>
          <div class="demo-options mdl-card mdl-color--white-500 mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--12-col-desktop">
            <div class="mdl-card__supporting-text mdl-color-text--teal-500">
              <h3>Stock Split</h3>
              <!-- Simple Textfield -->
            <form method="post">
              <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="cname" name="uname">
                <label class="mdl-textfield__label" for="sample1">User ID</label>
              </div>
              <div class="mdl-textfield mdl-js-textfield">
                <input class="mdl-textfield__input" type="text" id="newval" name="aname">
                <label class="mdl-textfield__label" for="sample1">Admin/PM ID</label>
              </div>

              <div class="mdl-card__actions mdl-card--border">
                <button type="submit" class="mdl-button mdl-button--raised mdl-js-button mdl-js-ripple-effect mdl-color-text--teal-500" name="allot">Allocate</button>
                <div class="mdl-layout-spacer"></div>
              </div>
            </form>
            </div>
          </div>
          <script type="text/javascript">
          function addRowHandlers() {
              var table = document.getElementById("allocate_table");
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
