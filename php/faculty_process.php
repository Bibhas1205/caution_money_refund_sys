<?php
include("config.php");

if(!isset($_SESSION['login_status']) || $_SESSION['login_status']!=true || !isset($_SESSION['user']))
{
	header("Location: index.php");
}

$USER=$_SESSION['user'];

//5 april 2023 //////////////////////////////////////////////////
function Calculate_numbers()
	{
		global $USER;
		//This block is for count : no of student who are in state of pending or approved
		$row=SELECT("select count(id) from students_information ");
		$row=$row[0];
		$information['student_number']=$row['count(id)'];

		if($USER=='hod')
			$query="select count(uroll) from status where hod_clearance ='' or hod_clearance like '__________/demote/%'";
		else if($USER=='librarian')
			$query="select count(uroll) from status where lib_clearance ='' or lib_clearance like '__________/demote/%'";
		else if($USER=='lab technician')
			$query="select count(uroll) from status where lab_clearance ='' or lab_clearance like '__________/demote/%'";
		$row=SELECT($query);
		$row=$row[0];
		$information['pending_approval']=$row['count(uroll)'];
		
		if($USER=='hod')
		$query="select count(uroll) from status where hod_clearance like '__________/demote/%'";
		else if($USER=='librarian')
		$query="select count(uroll) from status where lib_clearance like '__________/demote/%'";
		else if($USER=='lab technician')
		$query="select count(uroll) from status where lab_clearance like '__________/demote/%'";
		
		$row=SELECT($query);
		$row=$row[0];
		$information['demoted']=$row['count(uroll)'];
		
		return $information;
	}

function Fetch_data_firsttime()
	{			
		global $USER;

		$q1="select st.name,st.uroll,st.stream,";
		$q2=",st.batch from students_information st inner join status s on st.uroll=s.uroll where  st.application_date like '".date('Y')."%' ";
		$q3="ORDER BY st.uroll ASC";
		$query='';
		if($USER=="hod")
			$query=$q1."s.hod_clearance as status".$q2." and s.hod_clearance='' or s.hod_clearance like '__________/demote/%'".$q3;
		if($USER=="lab technician")
			$query=$q1."s.lab_clearance as status".$q2." and s.lab_clearance='' or s.lab_clearance like '__________/demote/%'".$q3;
		if($USER=="librarian")
			$query=$q1."s.lib_clearance as status".$q2." and s.lib_clearance='' or s.lib_clearance like '__________/demote/%'".$q3;
		//echo $query;
		$data=SELECT($query);
		$admin_info=SELECT("select name,email,college,photo,admin_type from admin_information where admin_type='$USER'");
		$information['data']=$data;
		$information['admin_data']=$admin_info[0];
		$information['user']=$USER;
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
			$status=input_check($_POST['search_status']);//promoted/ demoted/ pennding
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
		
		
		$q0="SELECT a.name, a.uroll, a.stream, b.";
		$q1=" as status, a.batch FROM students_information a inner join status b on a.uroll=b.uroll WHERE a.name LIKE '%$name%' AND a.stream LIKE '%$stream%' AND a.batch LIKE '%$year%' AND a.uroll IN ( SELECT uroll FROM status WHERE ";
		$q2=" LIKE '__________/demote/%') ORDER BY a.uroll $order";
		$q3=" ='') ORDER BY a.uroll $order";

		global $USER;
		$query='';
		//It is for demote
		if($USER=="hod" && $status=="demoted")
		{
			$query=$q0."hod_clearance".$q1."hod_clearance".$q2;
		}
		else if($USER=="librarian" && $status=="demoted")
		{
			$query=$q0."lib_clearance".$q1."lib_clearance".$q2;
		}
		else if($USER=="lab technician" && $status=="demoted")
		{
			$query=$q0."lab_clearance".$q1."lab_clearance".$q2;
		}
		//It is for pending
		if($USER=="hod" && $status=="pending")
		{
			$query=$q0."hod_clearance".$q1."hod_clearance".$q3;
		}
		else if($USER=="librarian" && $status=="pending")
		{
			$query=$q0."lib_clearance".$q1."lib_clearance".$q3;
		}
		else if($USER=="lab technician" && $status=="pending")
		{
			$query=$q0."lab_clearance".$q1."lab_clearance".$q3;
		}
		//It is for peomoted
		if($USER=="hod" && $status=="promoted")
		{
			$query=$q0."hod_clearance".$q1."hod_clearance <> '' and hod_clearance NOT  ".$q2;
		}
		else if($USER=="librarian" && $status=="promoted")
		{
			$query=$q0."lib_clearance".$q1."lib_clearance <> '' and lib_clearance NOT  ".$q2;
		}
		else if($USER=="lab technician" && $status=="promoted")
		{
			$query=$q0."lab_clearance".$q1."lab_clearance <> '' and lab_clearance NOT  ".$q2;
		}
		
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



else if(isset($_POST['demote_student']) && $_POST['demote_student']!=''&& isset($_POST['cause']) && $_POST['cause']!='')
{
	$uroll=input_check($_POST['demote_student']);
	$cause=input_check($_POST['cause']);
	
	if($USER=='hod')
	{
		SQL("update students_information set status='clearance missing' where uroll='$uroll'");
		SQL("update status set hod_clearance='$DATE/demote/$cause' where uroll='$uroll'");
	}
	else if($USER=='librarian')
	{
		SQL("update students_information set status='clearance missing' where uroll='$uroll'");
		SQL("update status set lib_clearance='$DATE/demote/$cause' where uroll='$uroll'");
	}
	else if($USER=='lab technician')
	{
		SQL("update students_information set status='clearance missing' where uroll='$uroll'");
		SQL("update status set lab_clearance='$DATE/demote/$cause' where uroll='$uroll'");
	}
	echo 1;
}



else if(isset($_POST['promote_student']) && $_POST['promote_student']!='' && isset($_POST['fine']))
{
	$uroll=input_check($_POST['promote_student']);
	$fine=input_check($_POST['fine']);
	$cause=input_check($_POST['cause']);
	
	if($fine>=0)
	{
		
		$cau=$cause;
		if($cause == 'undefined')
			$cau='ok';
		
		if($USER=='hod')
		{
			SQL("update status set hod_clearance='$DATE/$cau/$fine' where uroll='$uroll'");
		}
		else if($USER=='librarian')
		{
			SQL("update status set lib_clearance='$DATE/$cau/$fine' where uroll='$uroll'");
		}
		if($USER=='lab technician')
		{	
			SQL("update status set lab_clearance='$DATE/$cau/$fine' where uroll='$uroll'");
		}
		
		
		$st=SELECT("select lib_clearance as lib,lab_clearance as lab,hod_clearance as hod from status where uroll='$uroll'")[0];
		

		if($st['lib']=='' || $st['lab']=='' || $st['hod']=='')
			SQL("update students_information set status='clearance missing' where uroll='$uroll'");
		else if(strpos($st['lib'],'demote')!=false || strpos($st['lab'],'demote')!=false || strpos($st['hod'],'demote')!=false)
		{
			SQL("update students_information set status='clearance missing' where uroll='$uroll'");
		}
		else
		{
			SQL("update students_information set status='clearance done' where uroll='$uroll'");
		}
	echo 1;
	}
	else
		echo 0;
}




else if(isset($_POST['show_student']) && $_POST['show_student']!='')
{
	$uroll=input_check($_POST['show_student']);
	$data['student_details']=SELECT("select phone,dob,address from students_information");
	$data['documents']=SELECT("select passbook,grade_card,degree_certificate from academic_details where uroll='$uroll'");
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
		$pass=SELECT("select password,salt from admin_information where admin_type='$USER'")[0];
		if(md5(md5($prv_password).$pass['salt'])==$pass['password'])
		{
			if(md5($password)==md5($cf_password))
				{
					$salt=md5(time().rand(11111,99999));
					$cf_password=md5(md5($cf_password).$salt);
					SQL("update admin_information set password='$cf_password', salt='$salt' where admin_type='$USER'");
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
				SQL("update admin_information set name='$name',email='$email',college='$college' where admin_type='$USER'");
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
			$photo=SELECT("SELECT photo FROM admin_information where admin_type='$USER'")[0]['photo'];
			SQL("update admin_information set photo='$file' where admin_type='$USER'");
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