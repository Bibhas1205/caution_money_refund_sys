<?php
	include("php/config.php");
	//$_SESSION['uroll']='15401220001';
	if(!isset($_SESSION['login_status']) || $_SESSION['login_status']!=true || !isset($_SESSION['uroll']))
	{
		header("Location: index.php");
	}
	
	$uroll=$_SESSION['uroll'];
	
	$row=SELECT("select name,phone,email,photo,status from students_information where uroll='$uroll'")[0];
	$status=SELECT("select apply as signup,hod_clearance as hod,lib_clearance as lib, lab_clearance as lab,admin_confirmation as cashier,bank_confirmation as bank,registration_date as apply from status where uroll='$uroll'")[0];
	
	$notice=0;
?>
<!DOCTYPE html>
<html lang="En-IN">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style043.css">
	<script src="script/ajax.js"></script>
    <title>User Pannel | Caution Money Refund sys</title>
	<script src="script/ajax.js"></script>
	<link rel="icon" href="assets/images/daitm.ico" type="image/x-icon">
</head>

	<body>
		<div class="sidebar">

			<img class="application_logo" id="application_logo" src="assets/images/application_logo.png" alt="menu" />
			
			<ul class="menu-list">
			
				<li>
					<div class="menu-container">
						<button class="icon" id="menu"><img src="assets/images/menu.svg" alt="menu" /></button>
					</div>
				</li>

				<li>
					<button class="icon" id="clients">
						<img src="./assets/images/user.svg" alt="clients" />
					</button>
				</li>
				
				<li>
					<button class="icon" id="search">
						<img src="assets/images/edit.png" width="25" height="25" alt="search" />
					</button>
				</li>
				

				<li>
					<button class="icon" id="settings">
						<img src="assets/images/settings.svg" alt="settings" />
					</button>
				</li>
			</ul>

			<div class="left-bottom">
				<div id="profile" class="profile"><img class="profile_img_min" title="title"></div>
				<div class="logout-container">
					<button class="icon-logout">
						<img src="assets/images/log-out.svg" alt="logout" />
					</button>
				</div>
			</div>
		</div>
		
		
		


		<!----------------------------->
		
		<div class="main-container">
			<div class="container-head">
				<p>Applicant details</p>
			</div>
			
			<div class="profile-container">
				
			</div>
			
			
			<div class="profile-details">
				<span id="name"><?php echo $row['name'];?></span>
				<span id="phone-number"><?php echo $row['phone'];?></span>
				<span id="email"><?php echo $row['email'];?></span>
			</div>
	
			<div class="table-container">
				<table style="width: 100%;" >
					<tr>
						<th id="col1">#</th>
						<th id="col2">Activity</th>
						<th id="col3">Status</th>
						<th id="col4">Cause</th>
						<th>Date</th>
					</tr>
					<tr>
						<td id="col1">1</td>
						<td id="col2">Sign up</td>
						<?php
						$fill_up=$status['signup'];
						if($fill_up!='')
							{
								echo '<td id="col3"><input type="text"  class="status done" value="Done"></td>
								<td>--------</td>
								<td>'.$fill_up.'</td>';
							}
						else
						{
							echo '<td id="col3">Pending</td>
								<td>--------</td> <td>--------</td>';
						}
						?>
					</tr>
					
					<tr>
						<td id="col1">2</td>
						<td id="col2">Registration form Submission</td>
						<?php
						$fill_up=$status['apply'];
						if($fill_up!='')
							{
								echo '<td id="col3"><input type="text"  class="status done" value="Done"></td>
								<td>--------</td>
								<td>'.$fill_up.'</td>';
							}
						else
						{
							echo '<td id="col3"><input type="text"  class="status" value="Pending"></td>
								<td>--------</td><td>--------</td>';
						}
						?>
					</tr>
					
					<tr>
						<td id="col1">3</td>
						<td id="col2">Library Clearance</td>
						<?php
						$fill_up=$status['lib'];
						
						if($fill_up!='')
							{
								$data=explode("/",$fill_up);
								
								if($data[1]=='demote')
								{
									echo '<td id="col3"><input type="text"  class="status demote" value="Demoted"></td>
									<td>'.$data[2].'</td>   <td>'.$data[0].'</td>';
								}
								else
								{
									echo '<td id="col3"><input type="text"  class="status done" value="Done"></td>
									<td>'.$data[1].'</td> <td>'.$data[0].'</td>';
								}
							}
						else
						{
							echo '<td id="col3"><input type="text"  class="status" value="Pending"></td>
								<td>--------</td><td>--------</td>';
						}
						?>
					</tr>
					
					
					<tr>
						<td id="col1">4</td>
						<td id="col2">LAB Clearance</td>
						<?php
						$fill_up=$status['lab'];
						
						if($fill_up!='')
							{
								$data=explode("/",$fill_up);
								
								if($data[1]=='demote')
								{
									echo '<td id="col3"><input type="text"  class="status demote" value="Demoted"></td>
									<td>'.$data[2].'</td>   <td>'.$data[0].'</td>';
								}
								else
								{
									echo '<td id="col3"><input type="text"  class="status done" value="Done"></td>
									<td>'.$data[1].'</td> <td>'.$data[0].'</td>';
								}
							}
						else
						{
							echo '<td id="col3"><input type="text"  class="status" value="Pending"></td>
								<td>--------</td><td>--------</td>';
						}
						?>
					</tr>
					
					
					<tr>
						<td id="col1">5</td>
						<td id="col2">HOD Clearance</td>
						<?php
						$fill_up=$status['hod'];
						
						if($fill_up!='')
							{
								$data=explode("/",$fill_up);
								
								if($data[1]=='demote')
								{
									echo '<td id="col3"><input type="text"  class="status demote" value="Demoted"></td>
									<td>'.$data[2].'</td>   <td>'.$data[0].'</td>';
								}
								else
								{
									echo '<td id="col3"><input type="text"  class="status done" value="Done"></td>
									<td>'.$data[1].'</td> <td>'.$data[0].'</td>';
								}
							}
						else
						{
							echo '<td id="col3"><input type="text"  class="status" value="Pending"></td>
								<td>--------</td><td>--------</td>';
						}
						?>
					</tr>
					
					
					<tr>
						<td id="col1">6</td>
						<td id="col2">Cashier confirmation</td>
						<?php
						$fill_up=$status['cashier'];
						
						if($fill_up!='')
							{
								$data=explode("/",$fill_up);
								if($data[1]!='ok')
								{
									echo '<td id="col3"><input type="text"  class="status demote" value="Demoted"></td>
									<td>'.$data[1].'</td>   <td>'.$data[0].'</td>';
									$notice=1;
								}
								else
								{
									echo '<td id="col3"><input type="text"  class="status done" value="Done"></td>
									<td>'.$data[1].'</td> <td>'.$data[0].'</td>';
								}
							}
						else
						{
							echo '<td id="col3"><input type="text"  class="status" value="Pending"></td>
								<td>--------</td><td>--------</td>';
						}
						?>
					</tr>
					
					
					<tr>
						<td id="col1">7</td>
						<td id="col2">Bank confirmation</td>
						<?php
						$fill_up=$status['bank'];
						
						if($fill_up!='')
							{
								$data=explode("/",$fill_up);
								if($data[1]=='demote')
								{
									echo '<td id="col3"><input type="text"  class="status demote" value="Demoted"></td>
									<td>'.$data[1].'</td>   <td>'.$data[0].'</td>';
									$notice=1;
								}
								else
								{
									echo '<td id="col3"><input type="text"  class="status done" value="Done"></td>
									<td>'.$data[1].'</td> <td>'.$data[0].'</td>';
								}
							}
						else
						{
							echo '<td id="col3"><input type="text"  class="status" value="Pending"></td>
								<td>--------</td><td>--------</td>';
						}
						?>
					</tr>
					
					<?php
					$fill_up=$status['bank'];
					if($fill_up!='')
					{
						echo "<tr> <td colspan='5' >Transaction completed</td> </tr>";
					}
					
					?>
					
				</table>
				
				
				

			</div>
	
		</div>
	
		
		<!----------------------------->
		
		<?php
			if($notice==1)
			{
				echo "
				<div style='width:45%;margin:30px 300px;color:red'>
				Please click on Edit button and update your details
				</div>";
			}
		?>


		<div style="margin:40px 300px;padding:10px;border-radius:5px; width:45%;background-color:pink;">
				<p>For registration or tecnical issue contact: +91 9876543210 or email: friday@stak.com</p>
				<p>For clearance issue contact: +91 9976543210 or email: hod@gmail.com</p>
				<p>For other issue contact: 100 and dont't waste your time</p>
		</div>






		<div class="pop_up" id="pop_up">
			<span id="close" class="close" onclick="$('#pop_up').hide()">&times;</span>
			
			<center><h2 id='pop_pup_heading'>POP_UP BOX</h2></center><br><br>
			
			<!--Profile-->
			<div class="profile_pop_up">
				<table >
					<tr><td ><center><img id="admin_img" src='<?php echo $row['photo'];?>'></center></td> 
					<td>
					<p id="admin_name"> <?php echo $row['name'];?></p> 
					<p id="admin_email"><?php echo $row['email'];?></p> 
					<p id="Phone"><?php echo $row['phone'];?></p> 
					</td></tr>
					
					<tr>
						<td colspan="2">
						<hr/>
						<small>
							Welcome to our project! As a student, this platform is designed to enhance your learning experience and make your academic journey more engaging and efficient. To get started, create an account using your student credentials. This will grant you access to a wide range of features and resources tailored specifically for students like you. Once logged in, take some time to explore the various sections of the project. You'll find tools for organizing your schedule, managing tasks and assignments, and accessing educational materials. In the scheduling section, you can create a personalized timetable by adding your classes, study sessions, and extracurricular activities. This will help you stay organized and ensure you never miss an important event. Use the task management feature to keep track of your assignments, projects, and deadlines. You can also find educational materials such as articles, videos, and interactive quizzes to support your learning. We hope our project becomes your go-to companion in your educational journey, empowering you to succeed and excel in your studies. Happy learning!
						</small>
						</td>
					</tr>
				</table>
				<center><img src=""></center>
			</div>
			
			<!--Search box -->
			<form id="search_pop_up">		
				<div id="iframeContainer">
					<iframe id="registrationFrame" src="registration.php"></iframe>
				</div>
			</form>
			
			<!--Settings -->
			<table  class="setting_pop_up" >
				<tr>
				<td>Dark Mode</td>
				<td><center>
				<label class="switch switch-flat" ><input class="switch-input" type="checkbox" title="title" id='dark_mode'><span class="switch-label" data-on="On" data-off="Off"></span><span class="switch-handle"></span> </label></center>
				</td>
				</tr>
				
				
				
				
				<!--tr><td>Change Details</td> <td><input type="submit" id='ch_details' value="Edit Details"></td></tr>
					<tr class="details_hide"><td></td> <td><input type="text" id='ch_name' placeholder="New name"></td></tr>
					<tr class="details_hide"><td></td> <td><input type="email" id='ch_email' placeholder="New Email" ></td></tr>
					<tr class="details_hide"><td></td> <td><input type="number" id='ch_college' placeholder="New Phone Number" ></td></tr>
					<tr class="details_hide"><td> </td> <td><input type="submit" id='change_details' value="Edit Details"></td></tr-->
					
					
					
					
				<tr><td>Change password</td> <td><input type="submit" id='ch_pass' value="Change Password"></td></tr>
					<tr class="profile_hide"><td></td> <td><input type="password" id='ad_passw1' placeholder="Previous password"></td></tr>
					<tr class="profile_hide"><td></td> <td><input type="password" id='ad_passw2' placeholder="Enter new password" ></td></tr>
					<tr class="profile_hide"><td></td> <td><input type="password" id='ad_passw3' placeholder="Confirm password" ></td></tr>
					<tr class="profile_hide"><td> </td> <td><input type="submit" id='change_password' value="Change Password"></td></tr>
					
				<tr><td>Change profile picture</td> <td><input type="submit" id='ch_photo' value="Change Photo"></td></tr>
					<form id="subfrom">
					<tr class="profile_hide_pic"><td></td> <td><input type="file" id='ad_photo' name="ch_dp" accept="image/png, image/jpeg, image/jpg" onchange="fileValidation()"></td></tr>
					<tr class="profile_hide_pic"><td></td> <td><input type="submit" value="Upload Photo"></td></tr>
					</form>		
			</table>
		</div>
			
		<script type="text/javascript" src="script/script043.js"></script>
		<script>
			$(".profile-container").css({"background" : "url(<?php echo $row['photo'];?>)", "background-size": "cover", "background-position": "center"});
			$(".profile_img_min").attr("src","<?php echo $row['photo'];?>");
			ADMIN_IMG="<?php echo $row['photo'];?>";
		</script>
	</body>
</html>