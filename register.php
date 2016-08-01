<!--
    ### STOCKHAWK ###
    register.php :
    New user registration page.

-->

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>StockHAWK</title>

	<!-- Google Fonts -->
	<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700|Lato:400,100,300,700,900' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/animate.css">
	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="css/style.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
</head>

<body>
  <?php

      require_once dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';
      $con=mysqli_connect($hostname,$username,$password,$databasename);         //Setup connection with database.
      if(mysqli_connect_errno()){
        header("location: error.html");exit();
      }

			//Check for error.
			if(isset($_GET['Message'])){
				$msg=$_GET['Message'];
        unset($_GET['Message']);
        echo '<script type="text/javascript">alert("'.$msg.'");</script>';
			}

      if($_SERVER["REQUEST_METHOD"]=="POST"){
        $uemail=$_POST['useremail'];
        $uname=$_POST['username'];
        $repass=$_POST['repassword'];
        $pass=$_POST['password'];

        performRegister($uemail,$uname,$pass,$repass,$con);
      }

      /*
          Method - performRegister
          Registers a new user.

          Arguements -
                $con        - Connection Variable
                $uemail     - User Email
                $uname      - User Name
                $pass       - password
                $repass     - password

          Returns -
                Null
      */
      function performRegister($uemail,$uname,$pass,$repass,$con){
        if($pass==$repass){
          $cash=0;$isadmin=false;$ispm=false;$allot='no';
          $query="select uemail from user where uemail='$uemail'";
          $res=mysqli_query($query);
          // Checking if username already exists.
          if(res>=1){
						$m="User already exists";
            header("location=register.php?Message=".urlencode($m));
            exit();
          }else{
            $insquery="insert into `user` values('$uemail','$uname','$cash','$allot','$isadmin','$ispm','$pass')";
            $insres=mysqli_query($con,$insquery);
          }
          $retval=true;

          if($retval==true){
            header("location: land.php");
            exit();
          }else{
            //$delquery="delete from user where uemail='$uemail'";
          }
        }else{
          $m="Password Mismatch";
          header("location=register.php?Message=".urlencode($m));
          exit();
        }
      }
   ?>


	<div class="container">
		<div class="top">
			<h1 id="title" class="hidden"><span id="logo">Stock <span>HAWK</span></span></h1>
		</div>
		<div class="login-box animated fadeInUp">
			<div class="box-header">
				<h2>Sign Up</h2>
			</div>
			<!--<form method="post" action="land.php">-->
			<form method="post">
				<label for="useremail">Email</label>
				<br/>
				<input type="text" id="useremail" name="useremail">
				<br/>

        <label for="username">Name</label>
				<br/>
				<input type="text" id="username" name="username">
				<br/>

				<label for="password">Password</label>
				<br/>
				<input type="password" id="password" name="password">
        <br/>

        <label for="repassword">Re-Enter Password</label>
				<br/>
				<input type="password" id="repassword" name="repassword">
				<br/>

        <button type="submit">Register</button>
				<br/>
				<!--<a href="land.php"><p class="small">Forgot your password?</p></a>
				<a href="#"><p class="small">New User?Register here</p></a>-->
		</form>
		</div>
	</div>
</body>

<script>
	$(document).ready(function () {
    	$('#logo').addClass('animated fadeInDown');
    	$("input:text:visible:first").focus();
	});
	$('#username').focus(function() {
		$('label[for="username"]').addClass('selected');
	});
	$('#username').blur(function() {
		$('label[for="username"]').removeClass('selected');
	});
	$('#password').focus(function() {
		$('label[for="password"]').addClass('selected');
	});
	$('#password').blur(function() {
		$('label[for="password"]').removeClass('selected');
	});
</script>

</html>
