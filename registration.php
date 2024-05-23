<?php
include("php/config.php");

if(!isset($_SESSION['login_token']) || $_SESSION['login_status']!=1 || !isset($_SESSION['uroll']) || !isset($_SESSION['registration']))
{
	header("Location: index.php");
}


$uroll=$_SESSION['uroll'];


$fname=$mname=$lname=$email=$ph_no=$dob=$add=$pincode=$dep=$startYear=$greadCard_file=$fpage_file="";
$endYear=$classRoll=$bank_name=$ifsc=$ac_no=$branch_name=$micr_code=$acholdername=$degriCertificate_file="";
if(isset($_SESSION['editable']) || isset($_SESSION['noneditable']))
{
	$data=SELECT("SELECT * FROM students_information AS st JOIN academic_details AS ac ON st.uroll = ac.uroll WHERE st.uroll = '$uroll';")[0];
	$name=$data['name'];
	$name=explode(" ",$name);
	$fname="value='".$name[0]."' readonly";
	if(count($name)==3)
	{
		$mname="value='".$name[1]."' readonly";
		$lname="value='".$name[2]."' readonly";
	}
	else if(count($name)==2)
	{
		$lname="value='".$name[1]."' readonly";
	}
	$email=$data['email'];
	$ph_no="value='".$data['phone']."' readonly";
	$dob="value='".$data['dob']."' readonly";
	$add="value='".$data['address']."' readonly";
	$pincode="value='".$data['pin']."' readonly";
	$dep=$data['stream'];
	
	$session=$data['batch'];
	$session=explode("-",$session);
	
	$startYear="value='".$session[0]."' readonly";
	$endYear="value='".$session[1]."' readonly";
	
	$classRoll="value='".$data['classRoll']."' readonly";
	
	$bank_name="value='".$data['bank_name']."'";
	$ifsc="value='".$data['ifsc_code']."'";
	$ac_no="value='".$data['account_no']."'";
	$branch_name="value='".$data['branch_name']."'";
	$micr_code="value='".$data['micr_code']."'";
	$acholdername="value='".$data['account_holder']."'";
}
else
	$email=SELECT("select email from new_entry where uroll='$uroll'")[0]['email'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
	<link rel="icon" href="assets/images/daitm.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/style03.css">
	<script src="script/ajax.js"></script>
	<script async type="text/javascript" src="script/script03.js" defer></script>
</head>

<body>
    <div class="container">
        <!-- -------SIDDEBAR--------------------- -->
        <!--div class="sidebar">
            <ul class="menu-list">
                <li>
                    <div class="menu-container">
                        <button class="icon" id="menu">
                            <img src="./assets/images/menu.svg" alt="menu" />
                        </button>
                    </div>
                </li>

                <li>
                    <button class="icon" id="clients">
                        <img src="./assets/images/user.svg" alt="clients" />
                    </button>
                </li>

                <li>
                    <button class="icon" id="settings">
                        <img src="./assets/images/settings.svg" alt="settings" />
                    </button>
                </li>
            </ul>

            <div class="logout-container">
                <button class="icon-logout">
                    <img src="./assets/images/log-out.svg" alt="logout" />
                </button>
            </div>
        </div-->

        <!-- -------SIDEBAR_ENDS_HERE------------ -->
        <!--                                      -->
        <!-- -------PROGRESS_BAR----------------- -->
        <div class="progressbar-container">
            <ul>
                <li id="mark1" class="active">
                    <div></div>Personal details
                </li>
                <li id="mark2">
                    <div></div>Academic details
                </li>
                <li id="mark3">
                    <div></div>Account details
                </li>
                <li id="mark4">
                    <div></div>Document upload
                </li>
            </ul>

        </div>
        <!-- -------PROGRESS_BAR_ends_here------- -->

        <!--                                      -->

        <!-- -------FORM_CONTAINER--------------  -->
        <div class="form-container">

            <div class="form-wrapper">
                <!-- Form1 -->
                <form id="form1">
                    <!--  -->
                    <h5>Personal details</h4>
                        <!-- ------------------------------------------ -->
                        <div class="input-wrap form1-line1">
                            <!--  -->
                            <div>
                                <label for="fname">First name<span>*</span></label><br>
                                <input type="text" id="fname" name="fname" <?php echo $fname; ?> required><br>
								 <label id="fnameErr"></label>
                            </div>
                            <!--  -->
                            <div>
                                <label for="mname">Middle name</label><br>
                                <input type="text" id="mname" name="mname" <?php echo $mname; ?>>
                            </div>
                            <!--  -->
                            <div>
                                <label for="lname">Last name<span>*</span></label><br>
                                <input type="text" id="lname" name="lname"  <?php echo $lname; ?> required>
                            </div>
                        </div>
                        <!-- -------------------------------------------- -->
                        <div class="input-wrap form1-line2">
                            <!--  -->
                            <div>
                                <label for="ph-no">Phone number<span>*</span></label><br>
                                <input type="tel" id="ph-no" name="ph-no"  <?php echo $ph_no; ?>required>
                            </div>
                            <!--  -->
                            <div>
                                <label for="email">Email<span>*</span></label><br>
                                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required readonly>
                            </div>
                        </div>
                        <!-- ------------------------------------------ -->
                        <div class="input-wrap form1-line3">
                            <!--  -->
                            <div>
                                <label for="dob">Date of birth<span>*</span></label><br>
                                <input type="date" id="dob" name="dob" <?php echo $dob; ?> required>
                            </div>
                        </div>
                        <!-- ------------------------------------------ -->
                        <h5>Address details</h5>
                        <div class="input-wrap form1-line4">
                            <div>
                                <label for="add">Address<span>*</span></label><br>
                                <input type="text" id="add" name="add" <?php echo $add; ?>>
                            </div>
                        </div>
                        <!-- ------------------------------------------ -->
                        <div class="input-wrap form1-line5">
                            <!--  -->
                            <div>
                                <label for="pincode">Pincode.<span>*</span></label><br>
                                <input type="tel" id="pincode" name="pincode" <?php echo $pincode; ?> required>
                            </div>
                        </div>
                        <!-- ------------------------------------------ -->
                </form>
                <!--  -->
                <!-- Form2 -->
                <form id="form2" style="display: none;">
                    <!--  -->
                    <h5>Academic details</h4>
                        <!-- ------------------------------------------ -->
                        <div class="input-wrap form2-line1">
                            <!--  -->
                            <div>
                                <label for="dept">Department<span>*</span></label><br>
                                <select type="text" id="dept" name="dept" required>
									<?php 
										if($dep=="BCA")
											echo "<option value='BCA' selected>BCA</option>";
										else if($dep=="BBA")
											echo "<option value='BBA' selected>BBA</option>";
										else if($dep=="BHM")
											echo "<option value='BHM' selected>BHM</option>";
										else if($dep=="BMLT")
											echo "<option value='BMLT' selected>BMLT</option>";
										else if($dep=="Msc")
											echo "<option value='Msc' selected>M.sc</option>";
										else
										{
											echo ' <option value="">--Select Department</option>
                                    <option value="BCA">BCA</option>
                                    <option value="BBA">BBA</option>
                                    <option value="BHM">BHM</option>
                                    <option value="BMLT">BMLT</option>
                                    <option value="Msc">M.sc</option>';
										}
									?>
									
                                </select>
                            </div>
                            <!--  -->
                            <div>
                                <label for="year">Academic year<span>*</span></label><br>
                                 <input type="number" placeholder="Starting Year" min="1999" id="startYear" name="startYear" <?php echo $startYear; ?> >
                                 <input type="number" placeholder="Ending Year" min="1999" id="endYear" name="endYear" <?php echo $endYear; ?> >
                            </div>
                        </div>
                        <!-- -------------------------------------------- -->
                        <div class="input-wrap form2-line2">
                            <!--  -->
                            <div>
                                <label for="uroll">University roll<span>*</span></label><br>
                                <input type="tel" id="uroll" name="uroll" value="<?php echo $uroll; ?>" required readonly>
                            </div>
                            <div>
                                <label for="year">Class Roll<span>*</span></label><br>
								<input type= "number" id="classRoll" name="classRoll" <?php echo $classRoll; ?> >
                            </div>
                        </div>
                </form>
                <!--  -->
				
				
				<!-- This is for editing------>
				
                <!-- Form3 -->
                <form id="form3" style="display: none;">
                    <!--  -->
                    <h5>Account details</h4>
                        <!-- ------------------------------------------ -->
                        <div class="input-wrap form3-line1">
                            <!--  -->
                            <div>
                                <label for="bank_name">Name of bank<span>*</span></label><br>
                                <input type="text" id="bank_name" name="bank_name" <?php echo $bank_name; ?> required>
                            </div>
                            <!--  -->
							<div>
                                <label for="acholdername">Account Holder Name<span>*</span></label><br>
                                <input type="text" id="acholdername" name="acholdername" <?php echo $acholdername; ?> required>
                            </div>
                            
                        </div>
                        <!-- -------------------------------------------- -->
                        <div class="input-wrap form3-line2">
                            <!--  -->
                            <div>
                                <label for="ac_no">Account number<span>*</span></label><br>
                                <input type="text" id="ac_no" name="ac_no" <?php echo $ac_no; ?> required>
                            </div>
                            <!--  -->
							<div>
                                <label for="ifsc">IFSC Code<span>*</span></label><br>
                                <input type="text" id="ifsc" name="ifsc" <?php echo $ifsc; ?> required>
                            </div>
                        </div>
                        <!-- -------------------------------------------- -->
                        <div class="input-wrap form3-line3">
                            <div>
                                <label for="micr_code">MICR code<span></span></label><br>
                                <input type="text" id="micr_code" name="micr_code" <?php echo $micr_code; ?> required>
                            </div>
							 <div>
                                <label for="branch_name">Branch name<span>*</span></label><br>
                                <input type="text" id="branch_name" name="branch_name" <?php echo $branch_name; ?> required>
                            </div>
                        </div>
                        <!-- -------------------------------------------- -->

                </form>
                <!--  -->
                <!-- Form4 -->
                <form id="form4" style="display: none;">
                    <!--  -->
                    <h5>Document uploads</h4>
                        <!-- ------------------------------------------ -->
                        <div class="input-wrap form4-line1">
                            <!--  -->
                            <!--  -->
							<div>
                                <label for="last_grade">Upload Your Photo (jpg, png or jpeg format)<span>*</span></label><br>
                                <input type="file" name="p_img" id="p_img" onchange="fileValidation('p_img')">
                            </div>
							<div>
                                <label for="last_grade">6th semester grade card (jpg, png, or jpeg format)<span>*</span></label><br>
                                <input type="file" name="last_grade" id="last_grade" onchange="fileValidation('last_grade')">
                            </div>
                        </div>
                        <!-- ------------------------------------ -->
                        <div class="input-wrap form4-line2">
                            <!--  -->
							 <div>
                                <label for="degriCertificate">Degree Certificate (jpg, png, or jpeg format)<span></span></label><br>
                                <input type="file" name="degriCertificate" id="degriCertificate" value="null" onchange="fileValidation('degriCertificate')">
                            </div>
							<div>
                                <label for="fpage">1st page of bank passbok (jpg, png, or jpeg format)<span>*</span></label><br>
                                <input type="file" name="fpage" id="fpage" onchange="fileValidation('fpage')">
                            </div>      
                        </div>
						<!-- ------------------------------------- -->
                </form>
                <!-- end -->
            </div>
            <!-- ------FORM_CONTAINER_ENDS_HERE----------  -->
            <!--                                           -->
            <!-- ------BTN_CONTAINER---------------------- -->
            <div class="btn-container">
                <div class="btn-wrapper form1">
                    <button class="form1-next">next</button>
                </div>
                <div class="btn-wrapper form2" style="display: none;">
                    <button class="form2-pre">back</button>
                    <button class="form2-next">next</button>
                </div>
                <div class="btn-wrapper form3" style="display: none;">
                    <button class="form3-pre">back</button>
                    <button class="form3-next">next</button>
                </div>
                <div class="btn-wrapper form4" style="display: none;">
                    <button class="form4-pre">back</button>
                    <button type="submit"class="form4-submit"id="submitBtn" name="submitBtn">Submit</button>
                </div>
            </div>
        </div>

        <!-- ------BTN_CONTAINER_ENDS_HERE----------- -->
    </div>
</body>
</html>