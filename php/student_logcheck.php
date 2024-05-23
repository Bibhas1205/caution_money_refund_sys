<?php
include('config.php');
$uroll=$password="";

function valid($row, $a){
	$msg='';
	
	global $conn;
	if(empty($_POST['uroll'])) {
		$msg='uroll is missing';
	} else {
		$uroll =  input_check($_POST['uroll']);
		if(!preg_match('/^[0-9]+$/', $uroll)) {
			$msg='Invalid uroll';
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
	
	
	if(md5(md5($password).$row['salt'])==$row['password'])
		{
			$dttm=date('Y-m-d H:i:s');
			$token=md5(rand(0,9999).time());
			$_SESSION['login_status']=true;
			$_SESSION['login_token']=$token;
			$_SESSION['uroll']=$uroll;
			
			$qry='';
			if(isset($_POST['remember']))
			{
				$remember_token=md5(rand(100000,999999999999).time());
				$exp_remember =time() + (86400*30);
				
				setcookie('remember_token', $remember_token, $exp_remember, "/"); // 86400 = 1 day
				$qry=",remember_token='$remember_token',exp_remember='$exp_remember'";
				//setcookie('exp_remember', $exp_remember, $exp_remember, "/"); // 86400 = 1 day
			}
			if($a==1){
				$sql= "UPDATE new_entry SET
				login_token='$token',
				date='$dttm' $qry
				WHERE uroll='$uroll'";
				$qrr=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			}else if($a==2){
				$sql= "UPDATE students_information SET
				login_token='$token',
				log_dttm='$dttm'  $qry
				WHERE uroll='$uroll'";
				$qrr=mysqli_query($conn,$sql) or die(mysqli_error($conn));
			}
			
			
			$msg='login Success';
		
		}else{
			$msg= 'Wrong Password';
		}
		
	return $msg;
}
if(empty($_POST['uroll'])) {
		$msg='uroll is missing';
	} else {
		$uroll =  input_check($_POST['uroll']);
		if(!preg_match('/^[0-9]+$/', $uroll)) {
			$msg='Invalid uroll';
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
$msg='';
$status=0;
$data['login']=0;
$sqll="select * from new_entry where uroll = '".$uroll."'";
$qr1=mysqli_query($conn,$sqll) or die(mysqli_error($conn));
$noc=mysqli_num_rows($qr1);
if($noc){
	$row=mysqli_fetch_array($qr1);
	$msg=valid($row,1);
	$data['login']=1;
	$_SESSION['registration']=true;
}else
{
	$sqll="select * from students_information where uroll = '".$uroll."'";
	$qr1=mysqli_query($conn,$sqll) or die(mysqli_error($conn));
	$noc=mysqli_num_rows($qr1);
	if($noc){
		$row=mysqli_fetch_array($qr1);
		$msg=valid($row,2);
		$data['login']=2;
	}else{
		$msg= 'User Not Found';
	}
}

if($data['login']==1)
{
	$data['file']='registration.php';
	$data['msg']=$msg;
	echo json_encode($data);
}else if($data['login']==2){
	$data['file']='profile.php';
	$data['msg']=$msg;
	echo json_encode($data);
}

?>