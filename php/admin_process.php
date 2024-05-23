<?php
//This is the page for CASHIER PROCESS PAGE to parocess bacground data for cshier

include("config.php");

if(!isset($_SESSION['login_status']) || $_SESSION['login_status']!=true || !isset($_SESSION['user']))
{
	header("Location: index.php");
}

//5 april 2023 //////////////////////////////////////////////////
function Calculate_numbers()
	{
		//This block is for count : no of student who are in state of pending or approved
		$row=SELECT("select count(id) from students_information ");
		$row=$row[0];
		$information['student_number']=$row['count(id)'];

		$row=SELECT("select count(id) from students_information where status <>'forwarding to bank' and status <>'transaction complete' and status = 'clearance done'");
		$row=$row[0];
		$information['pending_approval']=$row['count(id)'];
		
		$row=SELECT("select count(id) from students_information where status ='demote by admin'");
		$row=$row[0];
		$information['demoted']=$row['count(id)'];
		
		$row=SELECT("select count(id) from students_information where status ='forwarding to bank'");
		$row=$row[0];
		$information['wait_for_bank']=$row['count(id)'];
		
		return $information;
	}

function Fetch_data_firsttime()
	{			
		$query="select name,uroll,stream,status,batch from students_information where application_date like '".date('Y')."%' and status <> 'clearance missing' and status <> 'transaction complete' ORDER BY uroll ASC";
		$data=SELECT($query);
		$admin_info=SELECT("select name,email,college,photo,admin_type from admin_information where admin_type='cashier'");
		$information['data']=$data;
		$information['admin_data']=$admin_info[0];
		return $information;
	}

function get_stream_year()
	{
		$row=SELECT("select DISTINCT stream FROM students_information ORDER BY stream ASC");
		$information['stream']=$row;
		$row=SELECT("select DISTINCT batch FROM students_information ORDER BY batch ASC");
		$information['year']=$row;
		return $information;
	}



function Fetch_data_search()
	{	
		//Editable.....for future........
		if(isset($_POST['search_name'])){
			$name=input_check($_POST['search_name']);
			$roll=input_check($_POST['search_roll']);
			$year=input_check($_POST['search_batch']);
			$stream=input_check($_POST['search_stream']);
			$status=input_check($_POST['search_status']);
			$order=input_check($_POST['search_order']);
			if($order=="descending")
			{$order="DESC";}
			else
			{$order="ASC";}
			}
		else{
			$name="";
			$roll="";
			$stream="";
			$year="";
			$status="";
			$order="ASC";
			}
		
		$query="select name,uroll,stream,status,batch from students_information  where name like '%$name%' and stream like '%$stream%' and uroll like '%$roll%' and batch like '%$year%' and status like '%$status%' ORDER BY uroll $order";
		$data=SELECT($query);
		$information['data']=$data;
		return $information;
	}
	


//If session ia active and searching is not happening
if(isset($_POST['search_name']) && count($_POST)==6)
{
	$information=Fetch_data_search();
	echo json_encode($information);
}




else if(isset($_POST['delete_student']) && $_POST['delete_student']!='')
{
	$uroll=input_check($_POST['delete_student']);
	SQL("DELETE FROM `students_information` WHERE uroll='$uroll'");
	SQL("DELETE FROM `academic_details` WHERE uroll='$uroll'");
	SQL("DELETE FROM `status` WHERE uroll='$uroll'");
	echo true;
}

else if(isset($_POST['demote_student']) && $_POST['demote_student']!=''&& isset($_POST['cause']) && $_POST['cause']!='')
{
	$uroll=input_check($_POST['demote_student']);
	$cause=input_check($_POST['cause']);
	SQL("update students_information set status='demote by admin' where uroll='$uroll'");
	SQL("update status set admin_confirmation='$DATE/$cause' where uroll='$uroll'");
	echo 1;
}
else if(isset($_POST['promote_student']) && $_POST['promote_student']!='')
{
	$uroll=input_check($_POST['promote_student']);
	
	$row3=SELECT("select lib_clearance,lab_clearance,hod_clearance from status where uroll='$uroll'");
	
	if($row3[0]['lib_clearance']=='' || $row3[0]['lab_clearance']=='' || $row3[0]['hod_clearance']=='')
	{
		echo 0;
		die;
	}
	
	SQL("update students_information set status='forwarding to bank' where uroll='$uroll'");
	SQL("update status set admin_confirmation='$DATE/ok' where uroll='$uroll'");
	
	echo 1;
}
else if(isset($_POST['approve_student']) && $_POST['approve_student']!='')
{
	$uroll=input_check($_POST['approve_student']);
	SQL("update students_information set status='transaction complete' where uroll='$uroll'");
	SQL("update status set bank_confirmation='$DATE/ok' where uroll='$uroll'");
	
	$row=SELECT("select si.name,si.email,si.stream,ad.account_no from students_information si inner join academic_details ad on si.uroll=ad.uroll where si.uroll='$uroll'");
	$name=$row[0]['name'];
	$email=$row[0]['email'];
	$stream=$row[0]['stream'];
	$account=$row[0]['account_no'];
	$row2=SELECT("select money from caution_money where stream='$stream'");
	$money=$row2[0]['money'];
	$row3=SELECT("select lib_clearance,lab_clearance,hod_clearance from status where uroll='$uroll'");
	
	if($row3[0]['lib_clearance']=='' || $row3[0]['lab_clearance']=='' || $row3[0]['hod_clearance']=='')
	{
		echo 0;
		die;
	}
	
	$lib=(int)explode("/",$row3[0]['lib_clearance'])[2];
	$lab=(int)explode("/",$row3[0]['lab_clearance'])[2];
	$hod=(int)explode("/",$row3[0]['hod_clearance'])[2];
	
	$money-=$lib+$lab+$hod;
	
	$message="Dear ".$name."\r\nCongratulations your all rounds are cleared. So we have sent your caution money of amount $money on your bank account No :$account \r\nFor further query you can visit your status page.\r\nthank you";
	$r=mail_send("80116725a97bbc695c162f3c44264f28","daitm.office.com",$email,"YOUR CAUTION MONEY HAS BEEN SENT",$message);
	echo 1;
}
else if(isset($_POST['show_student']) && $_POST['show_student']!='')
{
	$uroll=input_check($_POST['show_student']);
	$data['student_details']=SELECT("select st.phone,st.dob,st.address,cm.money from students_information st inner join caution_money cm on st.stream=cm.stream where st.uroll='$uroll'");
	$data['academic_details']=SELECT("select bank_name,account_holder,account_no,ifsc_code,passbook,grade_card,degree_certificate from academic_details where uroll='$uroll'");
	$data['status']=SELECT("select hod_clearance,lib_clearance,lab_clearance,admin_confirmation,bank_confirmation from status where uroll='$uroll'");
	
	echo json_encode($data);
}


else if(isset($_POST["ch_pass1"]) && count($_POST)==3)
{
	$pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/";
	$prv_password=input_check($_POST['ch_pass1']);
	$password=input_check($_POST['ch_pass2']);
	$cf_password=input_check($_POST['ch_pass3']);
	if(preg_match($pattern,$prv_password) && preg_match($pattern,$password) && preg_match($pattern,$cf_password))
	{
		$pass=SELECT("select password,salt from admin_information where admin_type='cashier'")[0];
		if(md5(md5($prv_password).$pass['salt'])==$pass['password'])
		{
			if(md5($password)==md5($cf_password))
				{
					$salt=md5(time().rand(11111,99999));
					$cf_password=md5(md5($cf_password).$salt);
					SQL("update admin_information set password='$cf_password', salt='$salt' where admin_type='cashier'");
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
		$college=input_check($_POST['details_college']);
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			try
			{
				SQL("update admin_information set name='$name',email='$email',college='$college' where admin_type='cashier'");
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

else if(isset($_POST["print_name"]) && isset($_POST["print_uroll"]) && isset($_POST["print_session"]) && isset($_POST["print_stream"]))
{
	if(count($_POST)==4)
	{
		$name=input_check($_POST['print_name']);
		$uroll=input_check($_POST['print_uroll']);
		$session=input_check($_POST['print_session']);
		$stream=input_check($_POST['print_stream']);
		
		$data=SELECT("SELECT si.name, si.stream, si.uroll, si.batch, ad.account_holder, ad.bank_name, ad.branch_name, ad.account_no, ad.ifsc_code, c.money,s.lib_clearance,s.lab_clearance,s.hod_clearance FROM students_information si INNER JOIN academic_details ad ON ad.uroll = si.uroll INNER JOIN caution_money c ON c.stream = si.stream Inner JOIN status s ON si.uroll = s.uroll WHERE si.name LIKE '%$name%' AND si.stream LIKE '%$stream%' AND si.uroll LIKE '%$uroll%' AND si.batch LIKE '%$session%' AND si.status = 'forwarding to bank' ORDER BY si.uroll");
		
		$count=count($data);
		if($count)
		{
			for($i=0;$i<$count;$i++)
			{
				$ar=$data[$i];
				$lib=$ar['lib_clearance'];
				$lab=$ar['lab_clearance'];
				$hod=$ar['hod_clearance'];
				$money=(int)$ar['money'];
				$libfine=(int)explode("/",$lib)[2];
				$labfine=(int)explode("/",$lab)[2];
				$hodfine=(int)explode("/",$hod)[2];
				$money-=($libfine+$labfine+$hodfine);
				$data[$i]['money']=$money;
			}
			$res['data']=$data;
		}
		else
			$res['data']="0";	
		
		echo json_encode($res);
	}
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
			$uroll="faculty";
			$source_photo = $_FILES["ch_dp"]["tmp_name"];
			if (!file_exists($folder)) 
			{
				mkdir($folder, 0777, true);
			}
			$dest_photo= $folder.$uroll.date("YmdHis")."_pic.jpeg";
			$file=compress_image($source_photo, $dest_photo, 5);
			
			
			
			//$file=UPLOAD("../assets/images","ch_dp",1000000,['jpg','jpeg','png']);
			$file=substr($file,3);
			$photo=SELECT("SELECT photo FROM admin_information where admin_type='cashier'")[0]['photo'];
			SQL("update admin_information set photo='$file' where admin_type='cashier'");
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

else
{
$information=array_merge(Calculate_numbers(),Fetch_data_firsttime(),get_stream_year());
echo json_encode($information);
}


?>