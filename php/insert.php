<?php
include ("config.php");
if(isset($_POST['otp']) && strlen($_POST['otp'])==6 && count($_POST)==1)
{
	$reply['response']="unsuccess";
	$otp =  input_check($_POST['otp']);
	$suroll=$_SESSION['uroll'];
	$semail=$_SESSION['email'];
	$ssalt=$_SESSION['salt'];
	$spassword=$_SESSION['password'];
	$sotp=$_SESSION['otp'];
	$_SESSION['login_status']=true;///It is hhelp to stay on registration page
	if(md5($otp)==$sotp)
	{
		SQL("insert into new_entry (uroll,email,salt,password) values ('$suroll','$semail','$ssalt','$spassword')");
		$reply['response']="success";
		unset($_SESSION['email']);
		unset($_SESSION['salt']);
		unset($_SESSION['password']);
		unset($_SESSION['otp']);
	}
	echo json_encode($reply);
}

else if(isset($_POST['email']) && isset($_POST['uroll']) && count($_POST)==4)
{
	$reply['message']="There are some error. Please try again later";
	$reply['response']="unsuccess";
	
    $uroll =  input_check($_POST['uroll']);
    $email =  input_check($_POST['email']);
    $password =  input_check($_POST['password']);
    $cpassword =  input_check($_POST['confirm_password']);

	if(filter_var($email, FILTER_VALIDATE_EMAIL) || preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password) )
	{
		$pass = md5($password);
		$cpass = md5($cpassword);
		//echo "SELECT email,uroll FROM students_information WHERE email = '$email' or uroll='$uroll' union all SELECT email,uroll FROM new_entry WHERE email = '$email' or uroll='$uroll'";
		$emailquery = SELECT("SELECT email FROM students_information WHERE email = '$email' or uroll='$uroll' union all SELECT email FROM new_entry WHERE email = '$email' or uroll='$uroll' union all SELECT email FROM admin_information WHERE email = '$email'");
		
		if(count($emailquery))
		{
			$reply['message']="This Email or University roll already exists";
		}
		else
		{
			if($pass === $cpass)
			{
				$salt=md5(time().rand(100001,999999));
				$password=md5($pass.$salt);
				$otp=rand(100000,999999);
				$_SESSION['uroll']=$uroll;
				$_SESSION['email']=$email;
				$_SESSION['salt']=$salt;
				$_SESSION['password']=$password;
				$_SESSION['otp']=md5($otp);
				$_=mail_send("80116725a97bbc695c162f3c44264f28","daitm.office.com",$email,"OTP FOR REGISTRATION","It is caution money refund system genarated email.\r\nYour University roll : $uroll\r\n\nYour OTP is : ".$otp."\r\n\nDo not share this otp to others\r\nThank you");
				$reply['message']="Check your mail box for OTP to verify your email";
				$reply['email']=$email;
				$reply['response']="success";
			}
			else
			{
				$reply['message']="Warning client side javascript is updated (Error)";
			}
		}
	}
	
	echo json_encode($reply);
}
?>