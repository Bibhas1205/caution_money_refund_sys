<?php
include("config.php");
// define variables and set to empty values
$fname=$mname=$lname=$ph_no=$email=$dob=$h_no=$add=$pincode=$dep=$startYear=$greadCard_file=$fpage_file="";
$endYear=$uroll=$classRoll=$bank_name=$ifsc=$ac_no=$branch_name=$micr_code=$dept=$acholdername=$degriCertificate_file="";



if(isset($_SESSION['editable']))
{
	//print_r($_POST);
	$reply['status']='true';
	$field=array();

	//form3
	if (empty($_POST['bank_name'])) {
		$reply['status']="false";
		$field[]=14;
	} else {
		$bank_name =  input_check($_POST['bank_name']);
	// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z-' ]*$/",$bank_name)) {
		  $reply['status']="false";
		  $field[]=14;
		}
	}
	if (empty($_POST['acholdername'])) {
			$reply['status']="false";
		    $field[]=15;
	} else {
	$acholdername =  input_check($_POST['acholdername']);
	// check if name only contains letters and whitespace
	if (!preg_match("/^[a-zA-Z-' ]*$/",$acholdername)) {
			$reply['status']="false";
		    $field[]=15;
	}
	}
	
	
	if(empty($_POST['ac_no'])) {
		$reply['status']="false";
		$field[]=16;
	} else {
	$ac_no =  input_check($_POST['ac_no']);
    // check if the pone_no only contain numbers
	if(!preg_match('/^[0-9]+$/', $ac_no)) {
		$reply['status']="false";
		$field[]=16; 
		}
	}
	
	
	if (empty($_POST['ifsc'])) {
		$reply['status']="false";
		$field[]=17;
	} else {
		$ifsc = input_check($_POST['ifsc']);
	}  
	
	
	
	
	if(isset($_POST['micr_code']) && $_POST['micr_code'] != ""){
	$micr_code =  input_check($_POST['micr_code']);
    // check if the pone_no only contain numbers
	if(!preg_match('/^[0-9]+$/', $micr_code)) {
		$reply['status']="false";
		$field[]=18; 
		}
	}
	
	
    if (empty($_POST['branch_name'])) {
		$reply['status']="false";
		$field[]=19;
	} else {
	$branch_name =  input_check($_POST['branch_name']);
	// check if name only contains letters and whitespace
	if (!preg_match("/^[a-zA-Z-' ]*$/",$branch_name)) {
		$reply['status']="false";
		$field[]=19;
	}
	}
	
	/*
	if($reply['status']=='false')
	{
		
		$reply['field']=$field;
		echo json_encode($reply);
		return false;
	}*/
	
		
	$Upload_path="../assets/photos/";
	
	
	$fullname = $fname .' '.$mname. ' '. $lname;
	$sesion = $startYear.'-'.$endYear;
	$dttm=date('Y-m-d H:i:s');		
	$uroll=$_SESSION['uroll'];
	$sqll="SELECT id FROM students_information where uroll='$uroll'";
	$qr1=mysqli_query($conn,$sqll) or die(mysqli_error($conn));
	$noc=mysqli_num_rows($qr1);
	//University Roll Already Used Or Not Checking
	
	
	
	if($noc)
	{
		
		if(!$_FILES['p_img']['error'])
		{
			//create folder if not exist
			if (!file_exists($Upload_path)) {
				mkdir($Upload_path, 0777, true);
			}
			
			$imageFileType = strtolower(pathinfo($_FILES["p_img"]["name"],PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$reply['status']="false";
				$field[]=201;
				$reply['field']=$field;
				echo json_encode($reply); 
				return false;
			}else{
				if ($_FILES["p_img"]["size"] > 10000000) {
					$reply['status']="false";
					$field[]=202;
					$reply['field']=$field;
					echo json_encode($reply); 
					return false;
				}else{
					$filnm=$uroll.'img';
					$p_img = $Upload_path . $filnm.'.'.$imageFileType;
					//Upload File Upload
					move_uploaded_file($_FILES["p_img"]["tmp_name"], $p_img);
				}
			}
			
		}
		else
		{
			$reply['status']="false";
			$field[]=20;
			
		}
		
		
		
		
		
		
		if(!$_FILES['last_grade']['error'])
		{
			$imageFileType = strtolower(pathinfo($_FILES["last_grade"]["name"],PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$reply['status']="false";
				$field[]=211;
				$reply['field']=$field;
				echo json_encode($reply); 
				return false;
			}else{
				if ($_FILES["last_grade"]["size"] > 10000000) {
					$reply['status']="false";
					$field[]=212;
					$reply['field']=$field;
					echo json_encode($reply); 
					return false;
				}else{
					$filnm=$uroll.'greadCard';
					$greadCard_file = $Upload_path . $filnm.'.'.$imageFileType;
					//Upload File Upload
					move_uploaded_file($_FILES["last_grade"]["tmp_name"], $greadCard_file);
				}
			}
		
		}
		else
		{
			$reply['status']="false";
			$field[]=21;
			
		}
		
    
		
		
		
		
		if(isset($_FILES['degriCertificate']) && $_FILES['degriCertificate']["name"]!=""){
			$imageFileType = strtolower(pathinfo($_FILES["degriCertificate"]["name"],PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$reply['status']="false";
				$field[]=221;
				$reply['field']=$field;
				echo json_encode($reply); 
				return false;
			}else{
				if ($_FILES["degriCertificate"]["size"] > 10000000) {
					$reply['status']="false";
					$field[]=222;
					$reply['field']=$field;
					echo json_encode($reply); 
					return false;
				}else{
					$filnm=$uroll.'degriCertificate';
					$degriCertificate_file = $Upload_path . $filnm.'.'.$imageFileType;
					//Upload File Upload
					move_uploaded_file($_FILES["degriCertificate"]["tmp_name"], $degriCertificate_file);
				}
			}
		}
		
		
		
		if(!$_FILES['fpage']['error'])
		{
			
			$imageFileType = strtolower(pathinfo($_FILES["fpage"]["name"],PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$reply['status']="false";
				$field[]=231;
				$reply['field']=$field;
				echo json_encode($reply); 
				return false; 
			}else{
				if ($_FILES["fpage"]["size"] > 10000000) {
					$reply['status']="false";
					$field[]=232;
					$reply['field']=$field;
					echo json_encode($reply); 
					return false;
				}else{
					$filnm=$uroll.'passbook';
					$fpage_file = $Upload_path . $filnm.'.'.$imageFileType;
					//Upload File Upload
					move_uploaded_file($_FILES["fpage"]["tmp_name"], $fpage_file);
				}
			}
			
		}
		else
		{
			$reply['status']="false";
			$field[]=23;
			
		}
		
		
		if($reply['status']=='false')
		{
			
			$reply['field']=$field;
			echo json_encode($reply);
			return false;
		}
		
		
			
		$p_img=substr($p_img,3);
		
		$fpage_file=substr($fpage_file,3);
		$greadCard_file=substr($greadCard_file,3);
		$degriCertificate_file=substr($degriCertificate_file,3);
		
		// $files=SELECT("select passbook,grade_card,degree_certificate from academic_details where uroll='$uroll'")[0];
		// if($files['passbook']!='')
		// unlink("../".$files['passbook']);
		// if($files['grade_card']!='')
		// unlink("../".$files['grade_card']);
		// if($files['degree_certificate']!='')
		// unlink("../".$files['degree_certificate']);
		// $dp=SELECT("select photo from students_information where uroll='$uroll'")[0]['photo'];
		// if($dp!='')
		// unlink("../".$dp);
		
		SQL("update students_information set status='clearance done' photo='$p_img' where uroll='$uroll'");
		
		SQL("update academic_details set bank_name='$bank_name',account_holder='$acholdername',account_no='$ac_no',
		ifsc_code='$ifsc',branch_name='$branch_name',micr_code='$micr_code',passbook='$fpage_file',grade_card='$greadCard_file',
		degree_certificate='$degriCertificate_file' where uroll='$uroll'");
		
 
		unset($_SESSION['registration']);
		unset($_SESSION['editable']);
	}
	
	else
	{
		$reply['status']='false';
		$field=0;
		$reply['field']=$field;
	}
	
	
	
	
	//echo $reply['status'];
	echo json_encode($reply);
	
	die;
		
}







if(isset($_SESSION['noneditable']))
{
	$reply['status']='true';
	unset($_SESSION['registration']);
	echo json_encode($reply);
	die;
}







if($_SERVER["REQUEST_METHOD"] == "POST") 
{
	//form1
	$reply['status']='true';
	$field=array();
	
	if (empty($_POST['fname'])) {
		$reply['status']="false";
		$field[]=1;
		//return false;
	} else {
	$fname =  input_check($_POST['fname']);
	// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
		  //echo "false";
		  $reply['status']="false";
		  $field[]=1;
		  //return false;
		}
	}
   if(isset($_POST["mname"]) && $_POST["mname"]!=""){
	  $mname =  input_check($_POST['mname']);
	  // check if name only contains letters and whitespace
	  if (!preg_match("/^[a-zA-Z-' ]*$/",$mname)) {
		//echo "false"; 
		$reply['status']="false";
		$field[]=2;
		//return false;
	  }
	}
	if (empty($_POST['lname'])){
		$reply['status']="false";
		$field[]=3;
		//return false;
	} else {
		$lname =  input_check($_POST['lname']);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
		  //echo "false"; 
		  $reply['status']="false";
		  $field[]=3;
		  //return false;
		}
	}
	
	
	if (empty($_POST['ph-no'])) {
		 
		$reply['status']="false";
		$field[]=4;
		//return false;
	} else {
		$ph_no =  input_check($_POST['ph-no']);
		// check if the pone_no only contain numbers
		if(!preg_match('/^[0-9]{10}+$/', $ph_no)) {
			
			$reply['status']="false";
		    $field[]=4;
			//return false;
		}
	} 
	
	
	if (empty($_POST["email"])) {
		//echo "false"; 
		$reply['status']="false";
		$field[]=5;
		//return false;
	} else {
		$email = input_check($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  //echo "false"; 
		  $reply['status']="false";
		  $field[]=5;
		  //return false;
		}
	}
	
	if(empty($_POST['dob'])) { 
		$reply['status']="false";
		$field[]=6;
		//return false;
	} else {
		$dob =  input_check($_POST['dob']);
	} 
	
	if (empty($_POST["add"])) {
		//echo "false"; 
		$reply['status']="false";
		$field[]=7;
		//return false;
	} else {
		$add = input_check($_POST["add"]);
	}
	
	if (empty($_POST['pincode'])) {
		//echo "false"; 
		$reply['status']="false";
		$field[]=8;
		//return false;
	} else {
		$pincode =  input_check($_POST['pincode']);
		// check if the pone_no only contain numbers
		if(!preg_match('/^[0-9]+$/', $pincode)) {
			//echo "false"; 
			$reply['status']="false";
		    $field[]=8;
			//return false;
		}
	}
	/////////////////////////////////////////////  SECOND PAGE /////////////////////////////
	
	 
	
	//form2
	
	if (empty($_POST["dept"])) {
		$reply['status']="false";
		$field[]=9;
		//return false;
	} else {
		$dept = input_check($_POST["dept"]);
	}
	
	
	if(empty($_POST['startYear'])){
		
		$reply['status']="false";
		$field[]=10;
		//return false;
	}else{
		$startYear= input_check($_POST['startYear']);
		$startYearLen=strlen($startYear);
		if($startYearLen != 4){
			
			$reply['status']="false";
		    $field[]=10;
			//return false;
		}
	}
	if(empty($_POST['endYear'])){
		
		$reply['status']="false";
		$field[]=11;
		//return false;
	}else{
		$endYear= input_check($_POST['endYear']);
		$endYearlen=strlen($endYear);
		if($endYearlen != 4){
			$reply['status']="false";
		    $field[]=11;
			//return false;
		}
	}
	
	
	
	
	if(empty($_POST['uroll'])) {
		
		$reply['status']="false";
		$field[]=12;
		//return false;
	} else {
		$uroll =  input_check  ($_POST['uroll']);
		if(!preg_match('/^[0-9]+$/', $uroll)) {
			$reply['status']="false";
		    $field[]=12;
			//return false;
		}
	}
	
	
	
	if (empty($_POST['classRoll'])) {
		$reply['status']="false";
		$field[]=13;
	} else {
    $classRoll =  input_check($_POST['classRoll']);
	if(!preg_match('/^[0-9]+$/', $classRoll)) {
		$reply['status']="false";
		$field[]=13;
		}
	}
	
	/////////////////////////////////////////// THIRD FORM /////////////////////////////
	
	//form3
	if (empty($_POST['bank_name'])) {
		$reply['status']="false";
		$field[]=14;
	} else {
		$bank_name =  input_check($_POST['bank_name']);
	// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z-' ]*$/",$bank_name)) {
		  $reply['status']="false";
		  $field[]=14;
		}
	}
	if (empty($_POST['acholdername'])) {
			$reply['status']="false";
		    $field[]=15;
	} else {
	$acholdername =  input_check($_POST['acholdername']);
	// check if name only contains letters and whitespace
	if (!preg_match("/^[a-zA-Z-' ]*$/",$acholdername)) {
			$reply['status']="false";
		    $field[]=15;
	}
	}
	
	
	if(empty($_POST['ac_no'])) {
		$reply['status']="false";
		$field[]=16;
	} else {
	$ac_no =  input_check($_POST['ac_no']);
    // check if the pone_no only contain numbers
	if(!preg_match('/^[0-9]+$/', $ac_no)) {
		$reply['status']="false";
		$field[]=16; 
		}
	}
	
	
	if (empty($_POST['ifsc'])) {
		$reply['status']="false";
		$field[]=17;
	} else {
		$ifsc = input_check($_POST['ifsc']);
	}  
	
	
	
	
	if(isset($_POST['micr_code']) && $_POST['micr_code'] != ""){
	$micr_code =  input_check($_POST['micr_code']);
    // check if the pone_no only contain numbers
	if(!preg_match('/^[0-9]+$/', $micr_code)) {
		$reply['status']="false";
		$field[]=18; 
		}
	}
	
	
    if (empty($_POST['branch_name'])) {
		$reply['status']="false";
		$field[]=19;
	} else {
	$branch_name =  input_check($_POST['branch_name']);
	// check if name only contains letters and whitespace
	if (!preg_match("/^[a-zA-Z-' ]*$/",$branch_name)) {
		$reply['status']="false";
		$field[]=19;
	}
	}
	
	/*
	if($reply['status']=='false')
	{
		
		$reply['field']=$field;
		echo json_encode($reply);
		return false;
	}*/
	
	
	
	$Upload_path="../assets/photos/";
	
	
	$fullname = $fname .' '.$mname. ' '. $lname;
	$sesion = $startYear.'-'.$endYear;
	$dttm=date('Y-m-d H:i:s');		
	$sqll="SELECT id FROM new_entry where uroll='$uroll'";
	$qr1=mysqli_query($conn,$sqll) or die(mysqli_error($conn));
	$noc=mysqli_num_rows($qr1);
	//University Roll Already Used Or Not Checking
	
	
	if($noc)
	{
		
		if(!$_FILES['p_img']['error'])
		{
			//create folder if not exist
			if (!file_exists($Upload_path)) {
				mkdir($Upload_path, 0777, true);
			}
			
			$imageFileType = strtolower(pathinfo($_FILES["p_img"]["name"],PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$reply['status']="false";
				$field[]=201;
				$reply['field']=$field;
				echo json_encode($reply); 
				return false;
			}else{
				if ($_FILES["p_img"]["size"] > 10000000) {
					$reply['status']="false";
					$field[]=202;
					$reply['field']=$field;
					echo json_encode($reply); 
					return false;
				}else{
					$filnm=$uroll.'img';
					$p_img = $Upload_path . $filnm.'.'.$imageFileType;
					//Upload File Upload
					move_uploaded_file($_FILES["p_img"]["tmp_name"], $p_img);
				}
			}
			
		}
		else
		{
			$reply['status']="false";
			$field[]=20;
			
		}
		
		
		
		
		
		
		if(!$_FILES['last_grade']['error'])
		{
			$imageFileType = strtolower(pathinfo($_FILES["last_grade"]["name"],PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$reply['status']="false";
				$field[]=211;
				$reply['field']=$field;
				echo json_encode($reply); 
				return false;
			}else{
				if ($_FILES["last_grade"]["size"] > 10000000) {
					$reply['status']="false";
					$field[]=212;
					$reply['field']=$field;
					echo json_encode($reply); 
					return false;
				}else{
					$filnm=$uroll.'greadCard';
					$greadCard_file = $Upload_path . $filnm.'.'.$imageFileType;
					//Upload File Upload
					move_uploaded_file($_FILES["last_grade"]["tmp_name"], $greadCard_file);
				}
			}
		
		}
		else
		{
			$reply['status']="false";
			$field[]=21;
			
		}
		
    
		
		
		
		
		if(isset($_FILES['degriCertificate']) && $_FILES['degriCertificate']["name"]!=""){
			$imageFileType = strtolower(pathinfo($_FILES["degriCertificate"]["name"],PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$reply['status']="false";
				$field[]=221;
				$reply['field']=$field;
				echo json_encode($reply); 
				return false;
			}else{
				if ($_FILES["degriCertificate"]["size"] > 10000000) {
					$reply['status']="false";
					$field[]=222;
					$reply['field']=$field;
					echo json_encode($reply); 
					return false;
				}else{
					$filnm=$uroll.'degriCertificate';
					$degriCertificate_file = $Upload_path . $filnm.'.'.$imageFileType;
					//Upload File Upload
					move_uploaded_file($_FILES["degriCertificate"]["tmp_name"], $degriCertificate_file);
				}
			}
		}
		
		
		
		if(!$_FILES['fpage']['error'])
		{
			
			$imageFileType = strtolower(pathinfo($_FILES["fpage"]["name"],PATHINFO_EXTENSION));
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
				$reply['status']="false";
				$field[]=231;
				$reply['field']=$field;
				echo json_encode($reply); 
				return false; 
			}else{
				if ($_FILES["fpage"]["size"] > 10000000) {
					$reply['status']="false";
					$field[]=232;
					$reply['field']=$field;
					echo json_encode($reply); 
					return false;
				}else{
					$filnm=$uroll.'passbook';
					$fpage_file = $Upload_path . $filnm.'.'.$imageFileType;
					//Upload File Upload
					move_uploaded_file($_FILES["fpage"]["tmp_name"], $fpage_file);
				}
			}
			
		}
		else
		{
			$reply['status']="false";
			$field[]=23;
			
		}
		
		
		if($reply['status']=='false')
		{
			
			$reply['field']=$field;
			echo json_encode($reply);
			return false;
		}
		
		
			
		$sql3="select * from new_entry where uroll='$uroll'";
		$qrr3=mysqli_query($conn, $sql3) or die(mysqli_error($conn));
		//$noc=mysqli_num_rows($
		$row=mysqli_fetch_array($qrr3);
		$password=$row['password'];
		$salt=$row['salt'];
		$logintoken=$row['login_token'];
		$remember_token=$row['remember_token'];
		$expr=$row['exp_remember'];
		
		$p_img=substr($p_img,3);
		$sql= "INSERT INTO students_information(name,stream,uroll,email,batch,phone,dob, address, pin,photo,status,application_date,password, salt, login_token,remember_token,exp_remember)
		VALUES ('$fullname', '$dept', '$uroll', '$email','$sesion','$ph_no','$dob','$add','$pincode','$p_img','clearance missing','$dttm','$password','$salt','$logintoken','$remember_token','$expr')";
		
		$qrr=mysqli_query($conn,$sql) or die(mysqli_error($conn));	
		
		$fpage_file=substr($fpage_file,3);
		$greadCard_file=substr($greadCard_file,3);
		$degriCertificate_file=substr($degriCertificate_file,3);
		
		$sql1="insert into academic_details(uroll,classRoll,batch,bank_name,account_holder,account_no,
		ifsc_code,branch_name,micr_code,passbook,grade_card,degree_certificate)values('$uroll','$classRoll','$sesion','$bank_name','$acholdername',
		'$ac_no','$ifsc','$branch_name','$micr_code','$fpage_file','$greadCard_file','$degriCertificate_file')";
		
		$qrr=mysqli_query($conn,$sql1) or die(mysqli_error($conn));
		
		$sql4= "INSERT INTO status(uroll, apply)VALUES ('$uroll', '".$row['date']."')";
		$qrr=mysqli_query($conn,$sql4) or die(mysqli_error($conn));	
		
		$sql2="delete from new_entry where uroll='$uroll'";
		$qrr2=mysqli_query($conn, $sql2) or die(mysqli_error($conn)); 
		unset($_SESSION['registration']);
	}
	
	else
	{
		$reply['status']='false';
		$field=0;
		$reply['field']=$field;
	}

	echo json_encode($reply);
}
?>