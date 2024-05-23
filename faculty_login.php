<?php
include('php/config.php');
if(isset($_SESSION['login_status']) && $_SESSION['login_status']==true && isset($_SESSION['user']))
{
	if($_SESSION['user']=='cashier'){
		header("Location: cashier.php");
	}else{
		header("Location: faculty.php");
	}
}
if(isset($_COOKIE['remember_token']) && $_COOKIE['remember_token']) {
	
	$remember_token=$_COOKIE['remember_token'];
	
	$sqll="SELECT * FROM admin_information WHERE remember_token='$remember_token'";
	$qr1=mysqli_query($conn,$sqll) or die(mysqli_error($conn));
	$noc=mysqli_num_rows($qr1);
	if($noc){
		$row=mysqli_fetch_array($qr1);
		$email=$row['email'];
		$dttm=date('Y-m-d H:i:s');
		$token=md5(rand(0,9999).time());
		$_SESSION['login_status']=true;
		$_SESSION['login_token']=$token;
		$_SESSION['user']=$row['admin_type'];
		
		$sql="UPDATE admin_information SET
			login_token='$token',
			log_dttm='$dttm'
			WHERE email='$email'";
			
		$qrr=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		if($_SESSION['user']=='cashier'){
		header("Location: cashier.php");
		}else{
			header("Location: faculty.php");
		}
	}
}

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Sign in</title>
	<link rel="icon" href="assets/images/daitm.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/a-_login.css">
	<script src="script/ajax.js"></script>
    <script async defer src="script/a-script01.js"></script>
</head>

<body>
    <div class="container">
        <div class="left">
			<div class="back-img">
				<span><img src="assets/images/clg_logo.png" alt="" srcset=""></span>
			</div>
		</div>
        
		<div class="right">

            <form name="myForm" onsubmit="return validateForm()" id="a_log">
                <h2>Admin Login</h2>
                <input type="text" id="email" name="email" placeholder="Email"><br>
                <input type="password" id="password" name="password" placeholder="Password"><br>
                <select name="l-type" id="l-type">
                    <option value="">Select Role</option>
                    <option value="librarian">Library</option>
                    <option value="lab technician">Lab</option>
                    <option value="hod">HOD</option>
                    <option value="cashier">Cashier</option>
                </select><br>
                <div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" id="rememberme" value="1" name='remember'>
                    <span><label for="rememberme" style="font-size: 14px;;">remember me </label>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="forgot_password.html" style="color: black;">forgot password?</a></span>
                </div><br>
                <button type="submit" value="Sign in" id='submitBtn'>Submit</button>
                <p>&nbsp;&nbsp;&nbsp;&nbsp;-------------------------------&nbsp;&nbsp; or
                    &nbsp;&nbsp;------------------------------</p>
                <div>
                    <p style="font-size: 14px;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="student_login.php">Not an Admin?</a>
					
					
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>