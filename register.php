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
      require_once '/config.php';
      $con=mysqli_connect($hostname,$username,$password,$databasename);
      if(mysqli_connect_errno()){
        die("Connection Error. Please try again in some time.");
      }else{
        //echo '<script type="text/javascript">alert("Connection Set.");</script>';
      }

      if($_SERVER["REQUEST_METHOD"]=="POST"){
        //include("config.php");
        $uemail=$_POST['useremail'];
        $uname=$_POST['username'];
        $repass=$_POST['repassword'];
        $pass=$_POST['password'];

        //$uname=mysqli_real_escape_string($databasename,$_POST['username']);
        //$pass=mysqli_real_escape_string($databasename,$_POST['password']);
        performRegister($uemail,$uname,$pass,$repass,$con);
      }

      function performRegister($uemail,$uname,$pass,$repass,$con){
        if($pass==$repass){
          $cash=0;$isadmin=false;$ispm=false;$allot='no';
          $query="select uemail from user where uemail='$uemail'";
          $res=mysqli_query($query);
          if(res>=1){
            echo '<script type="text/javascript">alert("Email ID is already registered.");</script>';
            header("refresh:5;url=register.php");
            exit();
          }else{
            $insquery="insert into `user` values('$uemail','$uname','$cash','$allot','$isadmin','$ispm','$pass')";
            $insres=mysqli_query($con,$insquery);
          }
          $retval=true;
          /*$to = $uemail;
          $subject = "Welcome";

          $message = "<b>Hope you will have a great time</b>";
          $message .= "<h1>This is headline.</h1>";

          $header = "From:nilanjandaw14@gmail.com \r\n";
          $header .= "MIME-Version: 1.0\r\n";
          $header .= "Content-type: text/html\r\n";

          $retval = mail ($to,$subject,$message,$header);*/

          if($retval==true){
            header("location: welcome.php");
            exit();
          }else{
            //$delquery="delete from user where uemail='$uemail'";
          }
        }else{
          echo '<script type="text/javascript">alert("Password Mismatch.");</script>';
          header("refresh:5;url=register.php");
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
