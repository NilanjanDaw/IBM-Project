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
		session_start();
		if(!empty($_SESSION['login_user'])){
			header("location: land.php");
			exit();
		}

		require_once '/config.php';
		$con=mysqli_connect($hostname,$username,$password,$databasename);
		if(mysqli_connect_errno()){
			die("Connection Error. Please try again in some time.");
		}else{
			//echo '<script type="text/javascript">alert("Connection Set.");</script>';
		}

		if($_SERVER["REQUEST_METHOD"]=="POST"){
			//include("config.php");
			$uname=$_POST['username'];
			$pass=$_POST['password'];
			//$uname=mysqli_real_escape_string($databasename,$_POST['username']);
			//$pass=mysqli_real_escape_string($databasename,$_POST['password']);
			performLogin($uname,$pass,$con);
		}


		function performLogin($uname,$pass,$con){
			$query="select * from user where uemail='$uname' and upassword='$pass'";
			$result=mysqli_query($con,$query);
			$row=mysqli_fetch_array($result);
			$count=mysqli_num_rows($result);

			if($count==1){
				$_SESSION['login_user']=$uname;
				header("location: land.php");
				exit();
			}else{
				echo '<script type="text/javascript">alert("Username/Password Invalid.");</script>';
			}
		}

	?>
	<div class="container">
		<div class="top">
			<h1 id="title" class="hidden"><span id="logo">Stock <span>HAWK</span></span></h1>
		</div>
		<div class="login-box animated fadeInUp">
			<div class="box-header">
				<h2>Log In</h2>
			</div>
			<!--<form method="post" action="land.php">-->
			<form method="post">
				<label for="username">Username</label>
				<br/>
				<input type="text" id="username" name="username">
				<br/>
				<label for="password">Password</label>
				<br/>
				<input type="password" id="password" name="password">
				<br/>
				<button type="submit">Sign In</button>
				<br/>
				<a href="land.php"><p class="small">Forgot your password?</p></a>
				<a href="register.php"><p class="small">New User?Register here</p></a>
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
