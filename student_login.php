<?php
include('php/config.php');
if(isset($_SESSION['login_status']) && $_SESSION['login_status']==true)
{
	//header("Location: profile.php");
}
// if(isset($_COOKIE['remember_token']) && $_COOKIE['remember_token']) {
	
	// $remember_token=$_COOKIE['remember_token'];
	
	// $sqll="SELECT * FROM students_information WHERE remember_token='$remember_token'";
	// $qr1=mysqli_query($conn,$sqll) or die(mysqli_error($conn));
	// $noc=mysqli_num_rows($qr1);
	// if($noc){
		// $row=mysqli_fetch_array($qr1);
		// $email=$row['email'];
		// $dttm=date('Y-m-d H:i:s');
		// $token=md5(rand(0,9999).time());
		// $_SESSION['login_status']=true;
		// $_SESSION['login_token']=$token;
		// $_SESSION['uroll']=$uroll;
		
		// $sql="UPDATE students_information SET
			// login_token='$token',
			// login_dttm='$dttm'
			// WHERE uroll='$uroll'";
			
		// $qrr=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		//header("Location: profile.php");
	// }
// }


?>
 


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<title>Sign in</title>
	<link rel="icon" href="assets/images/daitm.ico" type="image/x-icon">
	<link rel="stylesheet" href="css/style01.css">
	<script src="script/ajax.js"></script>
	<script async defer src="script/script01.js"></script>
</head>
<body>
	<div class="container">
		<div class="left">
			<div id="back_img">
				<span><img src="assets/images/clg_logo.png" alt="" srcset=""></span>
			</div>
		</div>
		<div class="right">
			
			<form id="myForm">
				<h2 id="log_text">Sign in to your account</h2>
				<input type="text" id="university_roll" name="uroll" placeholder="University Roll" ><br>
				<input type="password" id="password" name="password" placeholder="Password" ><br>
				<div>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="checkbox" name= "remember" id="rememberme" value="1">
					<span><label for="rememberme" style="font-size: 14px;">remember me </label>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="forgot_password.html" style="color: black;">forgot password?</a></span>
				</div><br>
				<input type="submit" value="Sign in" id="submitBtm">
				<p>&nbsp;&nbsp;&nbsp;&nbsp;-------------------------------&nbsp;&nbsp; or &nbsp;&nbsp;------------------------------</p>	
			</form>
			
			<div >
				<p style="font-size: 14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;<a href="signup.html">Don't hava an account?</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				</p>
			</div>
		</div>
	</div>
</body>
</html>