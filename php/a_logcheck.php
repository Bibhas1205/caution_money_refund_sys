<?php
include('config.php');
$email=$password=$admin_type="";
if (empty($_POST["email"])) {
		$msg='Email is missing';
	} else {
		$email = input_check($_POST["email"]);
			// check if e-mail address is well-formed
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$msg='Invalid email';
		}
	}
if (empty($_POST['password'])) {
		$msg='Password is missing';
	} else {
		$password =  input_check($_POST['password']);
		if(!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/', $password)) {
			$msg='Invalid Password';
		}
	}

if (empty($_POST["l-type"])) {
	$msg='Depertment is missing';
} else {
	$admin_type = input_check($_POST["l-type"]);
}

$msg='';
$status=0;
$sqll="SELECT * FROM admin_information WHERE email='$email' and admin_type='$admin_type'";
$qr1=mysqli_query($conn,$sqll) or die(mysqli_error($conn));
$noc=mysqli_num_rows($qr1);
if($noc){
	$row=mysqli_fetch_array($qr1);
	
	// echo "salt: ".$row['salt']."<br>";
	// echo "user passw: ".$password."<br>";
	// echo "user1: ".md5($password)."<br>";
	// echo "user2: ".md5(md5($password).$row['salt'])."<br>";
	
	
	// echo "data passw: ".$row['password']."<br>";
	// echo "user_pass_to_server: ".md5(md5($password).$row['salt'])."<br>";
	
	if(md5(md5($password).$row['salt'])==$row['password'])
	{
		$dttm=date('Y-m-d H:i:s');
		$token=md5(rand(0,9999).time());
		$_SESSION['login_status']=true;
		$_SESSION['login_token']=$token;
		$_SESSION['user']=$row['admin_type'];
		
		$qry='';
		if(isset($_POST['remember']))
		{
			$remember_token=md5(rand(100000,999999999999).time());
			$exp_remember =time() + (86400);
			
			setcookie('remember_token', $remember_token, $exp_remember, "/"); // 86400 = 1 day
			$qry=",remember_token='$remember_token',exp_remember='$exp_remember'";
			//setcookie('exp_remember', $exp_remember, $exp_remember, "/"); // 86400 = 1 day
		}
		
		$sql= "UPDATE admin_information SET
			login_token='$token',
			log_dttm='$dttm' $qry
			WHERE email='$email'";
		$qrr=mysqli_query($conn,$sql) or die(mysqli_error($conn));
		$status=1;
		$msg='login Success.';
		
	}
	else
	{
		$msg= 'Wrong Password';
	}
}else
{
	$msg= 'User Not Found';
}

if($status==1)
{
	$data['msg']=$msg;
	$data['admin_type']=$admin_type;
	echo json_encode($data);
}else{
	$data['msg']=$msg;
	$data['admin_type']=$admin_type;
	echo json_encode($data);
}

?>