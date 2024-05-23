<?php
include('php/config.php');
if(!isset($_SESSION['login_status']) || $_SESSION['login_status']!=true || !isset($_SESSION['user']))
{
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="En-IN">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/style04.css">
	<script src="script/ajax.js"></script>
    <title>Cashier Pannel | Caution Money Refund sys</title>
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
						<img src="assets/images/search.png" width="25" height="25" alt="search" />
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
		
		
		<div class="dashboard">
			<ul class="info-list">
				<li id="info-1">
					<img src="assets/images/total_students.png" class="icons">
					<div class="pannel-info">Total-students</div>
					<div id="count">Calculating..</div>
				</li>
				
				<li id="info-2">
					<img src="assets/images/pending.png" class="icons">
					<div class="pannel-info">Total-pending</div>
					<div id="count">Calculating..</div>
				</li>
				
				<li id="info-3">
					<img src="assets/images/approve.png" class="icons">
					<div class="pannel-info">Total-demoted</div>
					<div id="count">Calculating..</div>
				</li>
				
				<!--li id="info-4">
					<img src="assets/images/complete.png" class="icons">
					<div class="pannel-info">Wait for Bank</div>
					<div id="count">Calculating..</div>
				</li-->
			 
			</ul>
		</div>
		
		<table  class="user_table" >
		<tr class='head'><td>Sl no.</td> <td>Student Name</td> <td>U.Roll</td> <td>Stream</td> <td>Session</td> <td>Status</td> <td></td> <td>Fine &#8377;</td> <td>Action</td></tr>
		<tbody id="user_table">
			<!-- Add data -->
		</tbody>
		</table>

		<div class="pop_up" id="pop_up">
			<span id="close" class="close" onclick="$('#pop_up').hide()">&times;</span>
			
			<center><h2 id='pop_pup_heading'>POP_UP BOX</h2></center><br><br>
			
			<!--Profile-->
			<div class="profile_pop_up">
				<table >
					<tr><td ><center><img id="admin_img" ></center></td> 
					<td> 
					<p id="admin_name"></p> 
					<p id="admin_email"></p> 
					<p id="admin_college"></p> 
					</td></tr>
					
					<tr>
						<td colspan="2">
						<hr/>
						<small>
						You are the Admin of this system. You can handel who will get his caution money or not. It tottaly depends on you.
						As an admin, it's important to keep the system up-to-date, implement strong security measures, monitor the system, backup data regularly, provide user support, stay informed about new technologies, security threats, and best practices, and document everything to ensure that the system runs smoothly and securely for all users. By following these guidelines, admins can effectively manage their systems and provide the best possible support to users
						</small>
						</td>
					</tr>
				</table>
				<center><img src=""></center>
			</div>
			
			<!--Search box -->
			<form id="search_pop_up">		
				<table>
				<tr> 
					<td> <input type="text" name="search_name" id="search_name" placeholder="Name"></td> 
					<td><input type="text" name="search_roll" id="search_roll" placeholder="University Roll Number"></td>
				</tr>
				
				<tr> 
					<td><select name="search_batch" id="search_batch"> <option value="" selected>Session</option> </select></td> 
					<td><select name="search_stream" id="search_stream"> <option value="" selected>Stream</option> </select></td> 
				</tr>
				
				<tr>
					<td><select name="search_status">  <option value="promoted">Promoted</option> <option value="demoted">Demoted</option> <option value="pending" selected>Pending</option> </select></td>
					<td><select name="search_order"> <option value="" selected>Sort by order</option> <option value="ascending">Ascending</option> <option value="descending">Descending</option> </select></td> 
				</tr>
				
				<tr></tr>
				<tr></tr>
				<tr> <td colspan='2'> <center> <input class="search_but" value="Search / Sort" type="submit"></center></td></tr>
				</table>
			</form>
			
			<!--Settings -->
			<table  class="setting_pop_up" >
				<tr>
				<td>Dark Mode</td>
				<td><center>
				<label class="switch switch-flat" ><input class="switch-input" type="checkbox" title="title" id='dark_mode'><span class="switch-label" data-on="On" data-off="Off"></span><span class="switch-handle"></span> </label></center>
				</td>
				</tr>
				
				<tr><td>Change admin Details</td> <td><input type="submit" id='ch_details' value="Edit Details"></td></tr>
					<tr class="details_hide"><td></td> <td><input type="text" id='ch_name' placeholder="New name"></td></tr>
					<tr class="details_hide"><td></td> <td><input type="email" id='ch_email' placeholder="New Email" ></td></tr>
					<tr class="details_hide"><td></td> <td><input type="text" id='ch_college' placeholder="New college name" ></td></tr>
					<tr class="details_hide"><td> </td> <td><input type="submit" id='change_details' value="Edit Details"></td></tr>
					
				<tr><td>Change admin password</td> <td><input type="submit" id='ch_pass' value="Change Password"></td></tr>
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
			
		<script type="text/javascript" src="script/script042.js"></script>
		<script>
		$("#search_pop_up").submit(function(){
			//e.preventDefault();
			let formData = new FormData(document.getElementById('search_pop_up'));
			//$("#user_table").html();
			fetch_data(formData);
			return false;
		});
		</script>
	
	</body>
</html>