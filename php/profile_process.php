<?php
include("config.php");

if(!isset($_SESSION['login_status']) || $_SESSION['login_status']!=true || !isset($_SESSION['uroll']))
{
	header("Location: index.php");
}

$uroll=$_SESSION['uroll'];



if(isset($_POST["ch_pass1"]) && count($_POST)==3)
{
	$pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
	$prv_password=input_check($_POST['ch_pass1']);
	$password=input_check($_POST['ch_pass2']);
	$cf_password=input_check($_POST['ch_pass3']);
	if(preg_match($pattern,$prv_password) && preg_match($pattern,$password) && preg_match($pattern,$cf_password))
	{
		$pass=SELECT("select password,salt from students_information where uroll='$uroll'")[0];
		if(md5(md5($prv_password).$pass['salt'])==$pass['password'])
		{
			if(md5($password)==md5($cf_password))
				{
					$salt=md5(time().rand(11111,99999));
					$cf_password=md5(md5($cf_password).$salt);
					SQL("update students_information set password='$cf_password', salt='$salt' where uroll='$uroll'");
					echo 1;
				}
			else
				{echo 0;}
		}
		else {echo -1;}
	}
}

else if(isset($_POST["details_name"]))
{
	if(count($_POST)==3)
	{
		$name=input_check($_POST['details_name']);
		$email=input_check($_POST['details_email']);
		$phone=input_check($_POST['details_college']);
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			try
			{
				SQL("update students_information set name='$name',email='$email',phone='$phone' where uroll='$uroll'");
				echo 1;
			}
			catch(Exception $e)
			{
				echo 0;
			}
		}
		else
		{
			echo 2;
		}
	}
	else
	{
		echo -1;
	}
}


else if(isset($_POST['edit_data']) && $_POST['edit_data']==1)
{
	$reply['status']="unsuccess";
	// $reply['editable']=array();
	
	//$data=SELECT("SELECT * FROM students_information AS st JOIN academic_details AS ac ON st.uroll = ac.uroll WHERE st.uroll = '$uroll';");
	
	$error=SELECT("select admin_confirmation as cashier, bank_confirmation as bank from status where uroll='$uroll'")[0];
	
	if(strpos($error['cashier'],"incorrect") || strpos($error['bank'],"incorrect") || strpos($error['cashier'],"invalid") || strpos($error['bank'],"invalid"))
	{
	//	$reply['editable']=['bank_name','acholdername','ac_no','ifsc','micr_code','branch_name','p_img','last_grade','degriCertificate','fpage'];
		$_SESSION['editable']=true;
	}
	else
	{
		$_SESSION['noneditable']=true;
		$reply['status']="success";
	}
    
	//$reply['data']=$data;
	
	$_SESSION['registration']=true;
	
	
	echo json_encode($reply);
}



else if(isset($_FILES['ch_dp']))
{
	
	$photodata=input_check($_FILES['ch_dp']['full_path']);
	if($photodata=="")
	{
		$response['status']=-1;
	}
	else
	{
		try
		{
			$folder="../assets/photos/";
			$source_photo = $_FILES["ch_dp"]["tmp_name"];
			if (!file_exists($folder)) 
			{
				mkdir($folder, 0777, true);
			}
			$dest_photo= $folder.$uroll.date("YmdHis")."_pic.jpeg";
			$file=compress_image($source_photo, $dest_photo, 5);
			
			
			
			//$file=UPLOAD("../assets/images","ch_dp",1000000,['jpg','jpeg','png']);
			$file=substr($file,3);
			$photo=SELECT("SELECT photo FROM students_information where uroll='$uroll'")[0]['photo'];
			SQL("update students_information set photo='$file' where uroll='$uroll'");
			try{unlink("../$photo");}
			catch(Exception $e)
			{}
			$response['status']=1;
			$response['photo']=$file;
		}
		catch(Exception $e)
		{
			$response['status']=0;
		}
	}
	echo json_encode($response);
}


?>