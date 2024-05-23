<?php
include("config.php");
if(isset($_POST['email']) && count($_POST)==1)
{
	$response['status']=false;
	$email =  input_check($_POST['email']);
	if(filter_var($email, FILTER_VALIDATE_EMAIL))
	{
		$row=SELECT("select email from students_information where email='$email' union select email from admin_information where email='$email' union select email from new_entry where email='$email'");
		if(count($row))
		{
			$response['status']=true;
			$_SESSION['email']=$email;
			$_SESSION['otp']=md5("otp");
		}
		else
		{
			$response['message']="No account is linked with this email $email";
		}
	}
	else
	{
		$response['message']="Email is invalid";
	}
	echo json_encode($response);
}


else if(isset($_POST['password']) && count($_POST)==2)
{
	$response['status']=false;
	$password =  input_check($_POST['password']);
	$cpassword =  input_check($_POST['cpassword']);
	
	if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $password) && md5($password)==md5($cpassword))
	{
		$response['status']=true;
			$salt=md5(time().rand(100001,999999));
			$password=md5(md5($password).$salt);
			$otp=rand(100000,999999);
		$_SESSION['salt']=$salt;
		$_SESSION['password']=$password;
		$_SESSION['otp']=md5($otp);
		$email=$_SESSION['email'];
		$_=mail_send("80116725a97bbc695c162f3c44264f28","daitm.office.com",$email,"OTP FOR FORGOT PASSWORD","It is caution money refund system genarated email.\r\nYour OTP is : ".$otp."\r\n\nDo not share this otp to others\r\nThank you");
	}
	else
	{
		$response['message']="Invalid Input";
	}
	echo json_encode($response);
}

else if(isset($_POST['otp']) && strlen($_POST['otp'])==6)
{
	$reply['response']="unsuccess";
	$otp =  input_check($_POST['otp']);
	
	$sotp=$_SESSION['otp'];
	if(md5($otp)==$sotp)
	{
		$semail=$_SESSION['email'];
		$ssalt=$_SESSION['salt'];
		$spassword=$_SESSION['password'];
		
		if(count(SELECT("select name from admin_information where email='$semail'")))
		{
			SQL("update admin_information set salt='$ssalt',password='$spassword' where email='$semail'");
			$reply['user']='admin';
		}
		//SQL("update admin_information set salt='$ssalt',password='$spassword' where email='$semail'");
		else
		{
			SQL("update new_entry set salt='$ssalt',password='$spassword' where email='$semail'");
			SQL("update students_information set salt='$ssalt',password='$spassword' where email='$semail'");
			$reply['user']='student';
		}
		
		$reply['response']="success";
		unset($_SESSION['email']);
		unset($_SESSION['salt']);
		unset($_SESSION['password']);
		unset($_SESSION['otp']);
	}
	echo json_encode($reply);
}

?>