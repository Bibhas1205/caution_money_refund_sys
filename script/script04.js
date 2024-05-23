let NUMBER_OF_ROW=0;
let NUMBER_OF_PENDING=0;
let NUMBER_OF_DEMOTED=0;
let NUMBER_OF_WAITING=0;
let ADMIN_IMG="";
const sidebar = document.querySelector(".sidebar");
const menu = document.querySelector("#menu");
const menu_container = document.querySelector(".menu-container");
const logout_container = document.querySelector(".logout-container");

const icon_logout = document.querySelector(".icon-logout");

const clients = document.querySelector("#clients");
const serach = document.querySelector("#search");
const chat = document.querySelector("#chat");
const settings = document.querySelector("#settings");

let previousToggled = null;
let currentToggled = null;

const toggleMenu = (button) => {
  if (previousToggled && button !== menu) {
    untoggleMenu(previousToggled);
  }

  button.classList.add("toggled");
  button.style.backgroundColor = "#bea1f4";

  if (button !== menu) {
    previousToggled = button;
  }
};

const untoggleMenu = (button) => {
  button.classList.remove("toggled");
 // button.style.backgroundColor = "#6d18c2";
};

const openMenu = () => {
  $("#menu").hide();
  $("#profile").hide();
  $("#application_logo").css("display","block");
  $(".menu-list").css("margin-top","50px");
  sidebar.classList.add("active");
  sidebar.style.width = "250px";
  toggleMenu(menu);
  let p_clients = document.createElement("p");
  p_clients.id = "p-clients";
  p_clients.innerHTML = "Profile";
  clients.style.width = "220px";
  clients.style.justifyContent = "left";
  clients.appendChild(p_clients);
  let p_search = document.createElement("p");
  p_search.id = "p-search";
  p_search.innerHTML = "Search";
  search.style.width = "220px";
  search.style.justifyContent = "left";
  search.appendChild(p_search);
  let p_chat = document.createElement("p");
  p_chat.id = "p-chat";
  p_chat.innerHTML = "Print";
  chat.style.width = "220px";
  chat.style.justifyContent = "left";
  chat.appendChild(p_chat);
  let p_settings = document.createElement("p");
  p_settings.id = "p-settings";
  p_settings.innerHTML = "Settings";
  settings.style.width = "220px";
  settings.style.justifyContent = "left";
  settings.appendChild(p_settings);
  icon_logout.style.width = "25%";
  let user_container = document.createElement("div");
  user_container.id = "user-container";
  let user_name = document.createElement("p");
  user_name.id = "user-name";
  user_name.innerHTML = "User 1";
  let user_role = document.createElement("p");
  user_role.id = "user-role";
  user_role.innerHTML = "Student";
  user_container.appendChild(user_name);
  user_container.appendChild(user_role);
  logout_container.insertBefore(user_container, logout_container.childNodes[0]);
  let logout_photo = document.createElement("img");
  logout_photo.id = "logout-photo";
  logout_photo.src = ADMIN_IMG;
  logout_container.style.paddingLeft = "15px";
  logout_container.insertBefore(logout_photo, logout_container.childNodes[0]);
};

const closeMenu = () => {
  menu_container.style.paddingLeft = "0px";
  untoggleMenu(menu);
  clients.removeChild(document.getElementById("p-clients"));
  clients.style.width = "50px";
  clients.style.justifyContent = "center";
  settings.removeChild(document.getElementById("p-settings"));
  settings.style.width = "50px";
  settings.style.justifyContent = "center";
  search.removeChild(document.getElementById("p-search"));
  search.style.width = "50px";
  search.style.justifyContent = "center";
  chat.removeChild(document.getElementById("p-chat"));
  chat.style.width = "50px";
  chat.style.justifyContent = "center";
  logout_container.removeChild(document.getElementById("logout-photo"));
  logout_container.removeChild(document.getElementById("user-container"));
  logout_container.style.paddingLeft = "0px";
  icon_logout.style.width = "100%";
  sidebar.classList.remove("active");
  sidebar.style.width = "78px";
};

// ( 4/4/2023 12:05 am )///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$("#menu").click(function(){
	openMenu();
});

$(".sidebar").mouseleave(function(){
	closeMenu();
	$("#application_logo").css("display","none");
	$(".menu-list").css("margin-top","0px");
	$("#menu").show();
	$("#profile").show();
	});
	
$("#clients").click(function(){
	$(".setting_pop_up").css("display","none");
	$("#search_pop_up").css("display","none");
	$(".profile_pop_up").css("display","block");
	$("#pop_up").css("display","block");
	$("#pop_pup_heading").html("PROFILE");
});

$("#search").click(function(){
	$(".setting_pop_up").css("display","none");
	$(".profile_pop_up").css("display","none");
	$("#search_pop_up").css("display","block");
	$("#pop_up").css("display","block");
	$("#pop_pup_heading").html("SEARCH BOX");
});

$("#chat").click(function(){
	if(confirm("We are going to make a exel sheet which contains the students details with caution money related informations.\n\nTo continue press 'Ok' otherwise press 'Cancel'\nThank you"))
	{
		let fdata="print_name="+$("#search_name").val()+"&print_uroll="+$("#search_roll").val()+"&print_session="+$("#search_batch").val()+"&print_stream="+$("#search_stream").val();
		
		$.ajax({
			type: "POST",
			url: "php/admin_process.php",
			data: fdata,
			dataType: "json",
			processData: false,
			//contentType: false,
			cache: false,
			}).success(function (data){
				const d=data.data;
				if(d=='0')
				{
					alert("There are no more data for forwarding to bank");
					return false;
				}
				let txt="<title>Print | Caution Money Refund Sys</title><body><style>table{border-collapse: collapse;margin-left:auto;margin-right:auto;margin-top:20px;}th, td {border: 1px solid #ccc;padding: 5px;font-family: Arial, sans-serif;font-size: 12px;}th {background-color: #eee;font-weight: bold;}td {background-color: #fff;}";
				txt=txt+" div{position: fixed;bottom: 15px;left: 50%;transform: translateX(-50%);}button {margin: 0 10px;padding: 10px 20px;background-color: #4CAF50;color: white;border: none;border-radius: 4px;cursor: pointer;}button:hover {background-color: #3e8e41;}</style>";
				txt=txt+"<table ><tr><th colspan='11'>CAUTION MONEY REFUND, "+d[0].batch+" "+d[0].stream+" (MAKAUT)</th></tr>";
				txt=txt+"<tr><th>SI No.</th><th>Student name</th><th>Stream</th><th>University roll</th><th>Session</th><th>Account holder</th><th>Bank name</th><th>Branch name</th><th>Account number</th><th>IFSC code</th><th>Amount</th></tr>";
				for(let i=0;i<d.length;i++)
				{
					txt=txt+"<tr><td>"+(parseInt(i)+1)+"</td><td>"+d[i].name+"</td><td>"+d[i].stream+"</td><td>"+d[i].uroll+"</td><td>"+d[i].batch+"</td><td>"+d[i].account_holder+"</td><td>"+d[i].bank_name+"</td><td>"+d[i].branch_name+"</td><td>"+d[i].account_no+"</td><td>"+d[i].ifsc_code+"</td><td>"+d[i].money+"</td></tr>";
				}
				txt=txt+"</table><div><button class='Print' onclick='Print()'>Click to Print</button><button class='Reload' onclick='location.reload();'>Click to Back</button></div>";
				txt=txt+"<script>function Print(){document.querySelector('.Print','.Reload').style.visibility = 'hidden';document.querySelector('.Reload').style.visibility = 'hidden';window.print();document.querySelector('.Print').style.visibility = 'visible';document.querySelector('.Reload').style.visibility = 'visible';}</script><body>";
				$("html").html(txt);
				
			});
		
	}
});

$("#settings").click(function(){
	$("#search_pop_up").css("display","none");
	$(".profile_pop_up").css("display","none");
	$(".setting_pop_up").css("display","block");
	$("#pop_up").css("display","block");
	$("#pop_pup_heading").html("SETTINGS");
});

$(".logout-container").click(function(){
	if(confirm("Your all activities are recorded. Are you sure to exit?\nTo Exit click 'Ok' or click on 'Cancel'")){
		window.location.href="php/logout.php";
	}});
//Upto the code is okey.....(4/4/2023 2:22pm) ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


$("#ch_details").click(function(){
	if($("#ch_details").val()=="Edit Details")
	{
		$("#ch_details").val("Click to Close");
		$("#ch_details").css("background-color","grey");
	}
	else
	{
		$("#ch_details").val("Edit Details");
		$("#ch_details").css("background-color","green");
	}
	$(".details_hide").toggle();
});


$("#ch_pass").click(function(){
	if($("#ch_pass").val()=="Change Password")
	{
		$("#ch_pass").val("Click to Close");
		$("#ch_pass").css("background-color","grey");
	}
	else
	{
		$("#ch_pass").val("Change Password");
		$("#ch_pass").css("background-color","green");
	}
	$(".profile_hide").toggle();
});

$("#ch_photo").click(function(){
	if($("#ch_photo").val()=="Change Photo")
	{
		$("#ch_photo").val("Click to close");
		$("#ch_photo").css("background-color","grey");
	}
	else
	{
		$("#ch_photo").val("Change Photo")
		$("#ch_photo").css("background-color","green");
	}
	$(".profile_hide_pic").toggle();
});



$("#change_password").click(function(){
	var password_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
	
	if(!password_regex.test($("#ad_passw1").val()))
	{
		alert("Please enter a password that is at least 8 characters long and contains at least one uppercase letter, one lowercase letter, and one number.");
		$("#ad_passw1").css("border","2px solid red");
		return false;
	}
	else if(!password_regex.test($("#ad_passw2").val()))
	{
		alert("Please enter a password that is at least 8 characters long and contains at least one uppercase letter, one lowercase letter, and one number.");
		$("#ad_passw2").css("border","2px solid red");
		return false;
	}
	else if(!password_regex.test($("#ad_passw3").val()))
	{
		alert("Please enter a password that is at least 8 characters long and contains at least one uppercase letter, one lowercase letter, and one number.");
		$("#ad_passw3").css("border","2px solid red");
		return false;
	}
	
	if($("#ad_passw2").val()==$("#ad_passw3").val())
	{
		let fdata="ch_pass1="+$("#ad_passw1").val()+"&ch_pass2="+$("#ad_passw2").val()+"&ch_pass3="+$("#ad_passw3").val();
		$.ajax({
				type: "POST",
				url: "php/admin_process.php",
				data: fdata,
				}).success(function (data){
					if(data==1)
					{
						alert("The password is updated successfully");
					}
					else if(data==-1)
					{
						alert("The password is not updated");
					}
					else if(data==0)
					{
						alert("Warning client side script is infected");
						
					}
				});
						
		$("#ad_passw1").val('');
		$("#ad_passw1").css("border","none");
		$("#ad_passw2").val('');
		$("#ad_passw2").css("border","none");
		$("#ad_passw3").val('');
		$("#ad_passw3").css("border","none");
		$(".profile_hide").hide();
		$("#ch_pass").val("Change Password")
		$("#ch_pass").css("background-color","green");
	}
	else
	{
		$("#ad_passw2").val('');
		$("#ad_passw3").val('');
		alert("Please confirm password correctly");
	}
});

///////////Edit Details from submit
$("#change_details").click(function(){
	var email_regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
	if($("#ch_name").val()=="")
	{
		$("#ch_name").css("border","2px solid red");
		return false;
	}
	else if($("#ch_email").val()=="" && email_regex.test($("#ch_email").val()))
	{
		$("#ch_email").css("border","2px solid red");
		return false;
	}
	else if($("#ch_college").val()=="")
	{
		$("#ch_college").css("border","2px solid red");
		return false;
	}
	
	let fdata="details_name="+$("#ch_name").val()+"&details_email="+$("#ch_email").val()+"&details_college="+$("#ch_college").val();
	$.ajax({
			type: "POST",
			url: "php/admin_process.php",
			data: fdata,
			}).success(function (data){
				if(data==1)
				{
					alert("Your details are successfully updated");
					$("#admin_name").html($("#ch_name").val());
					$("#admin_email").html($("#ch_email").val());
					$("#admin_college").html($("#ch_college").val());
				}
				else if(data==-1)
				{
					alert("The details are not updated");
				}
				else if(data==0)
				{
					alert("Warning client side script is infected");
				}
				else if(data==2)
				{
					alert("Email is not valid");
				}
			});
		
		$("#ch_name").css("border","none");
		$("#ch_email").css("border","none");
		$("#ch_college").css("border","none");
		$(".details_hide").hide();
		$("#ch_details").val("Edit Details");
		$("#ch_details").css("background-color","green");
});




//This block of code is for change the dp of admin profile
	$("#subfrom").submit(function (e) {	  
	e.preventDefault();
	if($("#ad_photo").val()=="")
	{
		alert("please select an image to upload");
	}
	const formD = new FormData(document.getElementById('subfrom'));
    $.ajax({
      type: "POST",
      url: "php/admin_process.php",
      data: formD,
      dataType: "json",
	  processData: false,
	  contentType: false,
	  cache: false,
    }).success(function (data){
		if(data.status==1)
		{
			alert("Profile picture is updated successfully");
			//alert(data.photo);
			$("#ch_photo").val("Change Photo");
			$(".profile_hide_pic").toggle();
			
			$(".profile_pop_up table tr td center img").attr("src",data.photo);
			$(".left-bottom #profile .profile_img_min").attr("src",data.photo);
			//$("#logout-photo").attr("src",data.image);
			$("#ch_photo").css("background-color","green");
		}
		else if(data.status==-1)
		{
			alert("Profile picture is not updated");
		}
		else if(data.status==0)
		{
			alert("Warning client side script is infected");
		}
    });
  });


function man_data(id,n)
{
	if(n==2){//Delete
		if(confirm("Are you sure to delete this row ?"))
		{
			let formD="delete_student="+id;
			
			$.ajax({
				    type: "POST",
					url: "php/admin_process.php",
					data: formD,
					}).success(function (data){
						if(data==true)
						{
							$("#"+id).remove();
							$("."+id).remove();
							
							var stat = $("#"+id+" td:nth-child(6)").html();
							NUMBER_OF_ROW-=1;
							$(".dashboard .info-list #info-1 #count").html(NUMBER_OF_ROW);//Total User
							if(stat=="forwarding to bank")//Waiting for bank
							{
								NUMBER_OF_WAITING-=1;
								$(".dashboard .info-list #info-4 #count").html(NUMBER_OF_WAITING);
							}
							else if(stat=='demote by admin')//total Demoted
							{
								NUMBER_OF_DEMOTED-=1;
								$(".dashboard .info-list #info-3 #count").html(NUMBER_OF_DEMOTED);
							}
							else if(stat!='forwarding to bank' && stat!='transaction complete')//Total Pending
							{
								NUMBER_OF_PENDING-=1;
								$(".dashboard .info-list #info-2 #count").html(NUMBER_OF_PENDING);
							}
							if(NUMBER_OF_ROW<1)
							{
								var msg="<tr class='rows'> <td colspan='8' style='text-align:center'>Sorry no data found in the database</td> </tr>";
								$("#user_table").html($("#user_table").html()+msg);
							}
						}
						else
						{
							alert("This row is not deleted");
						}
					});
							
		}
	}
	else if(n==0)//Show
	{
		let new_row="<tr class='"+id+"'><td colspan='8'><div class='new_row'>";
		
		let formD="show_student="+id;
		$.ajax({
				type: "POST",
				url: "php/admin_process.php",
				dataType: "json",
				data: formD,
				processData: false,
				cache: false,
				}).success(function (data){
					
					let Data=data.student_details[0];
					let Data2=data.academic_details[0];
					let Data3=data.status[0];
					new_row=new_row+"Phone : "+Data.phone;
					new_row=new_row+" , Date of birth : "+Data.dob;
					new_row=new_row+" , Address : "+Data.address;
					new_row=new_row+"<br><br> Account Holder : "+Data2.account_holder;
					new_row=new_row+" , Account no : "+Data2.account_no;
					new_row=new_row+" , IFSC code : "+Data2.ifsc_code;
					new_row=new_row+" , Bank name : "+Data2.bank_name;
					new_row=new_row+"<br><br> Documents : <a href='"+Data2.passbook+"' target='_blank'>Bank Passbook</a>";
					new_row=new_row+" - <a href='"+Data2.grade_card+"' target='_blank'>Grade Card of 6th sem</a>";
					new_row=new_row+" - <a href='"+Data2.degree_certificate+"' target='_blank'>Degree Certificate</a>";
					
					
					let lib=Data3.lib_clearance.split("/");
					let lab=Data3.lab_clearance.split("/");
					let hod=Data3.hod_clearance.split("/");
					let admin=Data3.admin_confirmation.split("/");
					let bank=Data3.bank_confirmation.split("/");
					
					new_row=new_row+"<br><br><div style='text-align:center'>";
					if(Data3.lib_clearance!='')
					{
						if(lib[1]!='demoted')
						new_row=new_row+"Library clearance : <strong style='color:green'> Ok ( "+lib[0]+" )</strong> --- ";
						else
						new_row=new_row+"Library clearance : <strong style='color:red'>"+lib[1]+" ( "+lib[0]+" )</strong> --- ";
					}
					if(Data3.lab_clearance!='')
					{
						if(lab[1]!='demoted')
						new_row=new_row+"Lab clearance : <strong style='color:green'> Ok ( "+lab[0]+" )</strong> --- ";
						else
						new_row=new_row+"Lab clearance : <strong style='color:red'>"+lab[1]+" ( "+lab[0]+" )</strong> --- ";
					}
					if(Data3.hod_clearance!='')
					{
						if(hod[1]!='demoted')
						new_row=new_row+"HOD clearance : <strong style='color:green'> Ok ( "+hod[0]+" )</strong> --- ";
						else
						new_row=new_row+"HOD clearance : <strong style='color:red'>"+hod[1]+" ( "+hod[0]+" )</strong> --- ";
					}
					if(Data3.admin_confirmation!='')
					{
						if(admin[1]=='ok')
						new_row=new_row+"Cashier confirmation : <strong style='color:green'> Ok ( "+admin[0]+" )</strong> --- ";
						else
						new_row=new_row+"Cashier confirmation : <strong style='color:red'>"+admin[1]+" ( "+admin[0]+" )</strong><br>";
					}
					if(Data3.bank_confirmation!='')
					{
						new_row=new_row+"Bank confirmation : <strong style='color:green'> Ok ( "+bank[0]+" )</strong>";
					}
					let fine=0;
					new_row=new_row+"</div><br><br>Fines : <strong style='color:brown'>";
					if(typeof lib[1]!='undefined')
					{new_row=new_row+"Fine from library: "+lib[2]+" ( "+lib[1]+" ) --- ";fine+=parseInt(lib[2]);}
					if(typeof lab[1]!='undefined')
					{new_row=new_row+"Fine from Lab : "+lab[2]+" ( "+lab[1]+" ) --- ";fine+=parseInt(lab[2]);}
					if(typeof hod[1]!='undefined')
					{new_row=new_row+"Fine from HOD : "+hod[2]+" ( "+hod[1]+" )"; fine+=parseInt(hod[2]);}
					
					new_row=new_row+"</strong><br><br><strong style='color:red;'>Total money : "+(parseInt(Data.money)-fine)+" Rupees only</strong>";
					
					new_row=new_row+"</div></td></tr>";
					$('#'+id).after(new_row);
					$("#"+id+" .toogle button:nth-child(1) img:nth-child(1)").attr("src","assets/images/hidden.png");	
					$("#"+id+" .toogle button:nth-child(1)").attr("onclick","man_data('"+id+"',5)");	
					
				});
				
				
	}
	else if(n==5)
	{
		$('#'+id).closest("tr").next().remove();
		$("#"+id+" .toogle button:nth-child(1) img:nth-child(1)").attr("src","assets/images/Eye-Bold-32px.svg");	
		$("#"+id+" .toogle button:nth-child(1)").attr("onclick","man_data('"+id+"',0)");
		
	}
	else if(n==1)//Demote
	{
			let cause="<select class='demote_cause'> <option value=''>Cause</option> <option value='details_invalid'>Details invalid</option> <option value='incorrect_bank_details'>Incorrect Bank details</option>  </select>";
			$("#"+id+" td:nth-child(8) button:nth-child(1)").hide();
			$("#"+id+" td:nth-child(8)").html(cause+$("#"+id+" td:nth-child(8)").html());
			
			
			$(".demote_cause").on('change',function() {
				if(confirm("Are you sure?"))
				{
					let cause=$(".demote_cause").val();
					
					let formD="demote_student="+id+"&cause="+cause;
					$.ajax({
						type: "POST",
						url: "php/admin_process.php",
						data: formD,
						}).success(function (data){
							if(data==0)
							{
								alert("There are some error");
								return false;
							}	
							else if(data==-1)
							{
								alert("Warning the XSS attack is dectected");
							}
							else if(data==1)
							{
								NUMBER_OF_DEMOTED=parseInt(NUMBER_OF_DEMOTED)+1;
								$(".dashboard .info-list #info-3 #count").html(NUMBER_OF_DEMOTED);
								
								var stat = $("#"+id+" td:nth-child(6)").html();
								if(stat=="forwarding to bank")
								{
									NUMBER_OF_WAITING-=1;
									$(".dashboard .info-list #info-4 #count").html(NUMBER_OF_WAITING);
								}
								if(stat=="forwarding to bank" || stat=='transaction complete')
								{
									NUMBER_OF_PENDING=parseInt(NUMBER_OF_PENDING)+1;
									$(".dashboard .info-list #info-2 #count").html(NUMBER_OF_PENDING);
								}
								
								$("#"+id+" td:nth-child(6)").html('demoted by admin');
								let promote_but="<button class='act-btn' onclick=\"man_data('"+id+"',3)\">Promote</button>";
								$("#"+id+" td:nth-child(8)").html(promote_but);
								
							}
						});	
						
						$("#"+id).css({"background-color":"rgb(255,102,102)","box-shadow":"0 0 10px rgba(0, 0, 0, 0.3)"});
				}
			});		
	}
	
	else if(n==3)//promote
	{
		if($("#"+id+" td:nth-child(6)").html()!='forwarding to bank')
		{	if(confirm("Are you sure?"))
			{
				let formD="promote_student="+id;
				$.ajax({
				    type: "POST",
					url: "php/admin_process.php",
					data: formD,
					}).success(function (data){
						if(data==0)
						{
							alert("There are some error");
							return false;
						}	
						else if(data==-1)
						{
							alert("Warning the XSS attack is dectected");
						}
						else if(data==1)
						{
							NUMBER_OF_PENDING-=1;
							$(".dashboard .info-list #info-2 #count").html(NUMBER_OF_PENDING);
							
							NUMBER_OF_WAITING=parseInt(NUMBER_OF_WAITING)+1;
							$(".dashboard .info-list #info-4 #count").html(NUMBER_OF_WAITING);
									
							var stat = $("#"+id+" td:nth-child(6)").html();
							if(stat=="demote by admin")
							{
								NUMBER_OF_DEMOTED-=1;
								$(".dashboard .info-list #info-3 #count").html(NUMBER_OF_DEMOTED);
							}
							
							$("#"+id+" td:nth-child(6)").html('forwarding to bank');
							let count_button=$("#"+id+" td:nth-child(8)").find("button").length;
							let promote_but="<button class='act-btn' onclick=\"man_data('"+id+"',1)\">Demote</button> <button class='act-btn' onclick=\"man_data('"+id+"',4)\">Approve</button>";
							if(count_button==2)
							{
								//promote will change with Approve
								$("#"+id+" td:nth-child(8)").html(promote_but);
							}
							else if(count_button==1)
							{
								//approve will chnage with Approve and A Demote button will add before it
								$("#"+id+" td:nth-child(8)").html(promote_but);
							}
							
							$("#"+id).css({"background-color":"lightgreen","box-shadow":"0 0 10px rgba(0, 0, 0, 0.3)"});
						}
					});
					
			}
		}
	}
	else if(n==4)//Approve after bank confirmation
	{
		if(confirm("Are you sure?"))
			{
				let formD="approve_student="+id;
				$.ajax({
				    type: "POST",
					url: "php/admin_process.php",
					data: formD,
					}).success(function (data){
						if(data==0)
						{
							alert("There are some error");
							return false;
						}	
						else if(data==-1)
						{
							alert("Warning the XSS attack is dectected");
						}
						else if(data==1)
						{
							
							NUMBER_OF_WAITING-=1;
							$(".dashboard .info-list #info-4 #count").html(NUMBER_OF_WAITING);	
								
							$("#"+id+" td:nth-child(6)").html('transaction complete');
							$("#"+id+" td:nth-child(8)").hide();
							$("#"+id).css({"background-color":"lightblue","box-shadow":"0 0 10px rgba(0, 0, 0, 0.3)"});
							
						}
					});
			}
	}
	
	
	
	
}




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//(6/4/2023  2:20 am) This function for fetch all the data and some calculation for first time or  when the page is reloaded.		
function fetch_data(fd)
{
	$.ajax({
		  type: "POST",
		  url: "php/admin_process.php",
		  dataType: "json",
		  data: fd,
		  processData: false,
		  contentType: false,
		  cache: false,
		}).success(function (data) 
			{
				if(fd==0)
				{
					$(".dashboard .info-list #info-1 #count").html(data.student_number);
					$(".dashboard .info-list #info-2 #count").html(data.pending_approval);
					$(".dashboard .info-list #info-3 #count").html(data.demoted);
					$(".dashboard .info-list #info-4 #count").html(data.wait_for_bank);
					
					NUMBER_OF_ROW=data.student_number;//GLOBAL variable store the rows number
					NUMBER_OF_PENDING=data.pending_approval;//GLOBAL variable store the pending number
					NUMBER_OF_DEMOTED=data.demoted;//GLOBAL variable store the approved number
					NUMBER_OF_WAITING=data.wait_for_bank;//GLOBAL variable store the approved number
					
					if(data.stream.length)// It is for select tag for Stream selection
					{
						let stream_data="";
						for(let i=0;i<data.stream.length;i++)
						{
							let info=data.stream[i];
							stream_data=stream_data+"<option value='"+info.stream+"'>"+info.stream+"</option>";
						}
						$("#search_stream").html($("#search_stream").html()+stream_data);
					}					
					if(data.year.length)// It is for select tag for passing year selection
					{
						let batch_data="";
						for(let i=0;i<data.year.length;i++)
						{
							let info=data.year[i];
							batch_data=batch_data+"<option value='"+info.batch+"'>"+info.batch+"</option>";
						}
						$("#search_batch").html($("#search_batch").html()+batch_data);
					}
					
					
					$(".profile_pop_up #admin_img").attr("src",data.admin_data.photo);
					$(".left-bottom #profile .profile_img_min").attr("src",data.admin_data.photo);
					ADMIN_IMG=data.admin_data.photo;
					$(".profile_pop_up #admin_name").html(data.admin_data.name+" ("+data.admin_data.admin_type+")");
					$(".profile_pop_up #admin_email").html(data.admin_data.email);
					$(".profile_pop_up #admin_college").html(data.admin_data.college);
					
					$(".setting_pop_up #ch_name").attr("value",data.admin_data.name);
					$(".setting_pop_up #ch_email").attr("value",data.admin_data.email);
					$(".setting_pop_up #ch_college").attr("value",data.admin_data.college);
					
					
				}
				let student_data='';// Now it is editting...
				if(data.data.length)
				{
					for(let i=0;i<data.data.length;i++)
					{
						let info=data.data[i];
						if(info.status=="transaction complete")
						student_data=student_data+"<tr class='rows rows_complete'";
						else if(info.status=="forwarding to bank")
						student_data=student_data+"<tr class='rows rows_forwarding'";
						else if(info.status=="demote by admin")
						student_data=student_data+"<tr class='rows rows_demote'";
						else
						student_data=student_data+"<tr class='rows'";	
						
						student_data=student_data+"id='"+info.uroll+"' ><td>"+(parseInt(i)+1)+"</td><td>"+info.name+"</td><td>"+info.uroll+"</td><td>"+info.stream+"</td><td>"+info.batch+"</td><td>"+info.status+"</td>";
						student_data=student_data+"<td class='toogle'><button class='optn-btn' onclick=\"man_data('"+info.uroll+"',0)\"><img src='assets/images/Eye-Bold-32px.svg' ></button>";
						student_data=student_data+"<button class='optn-btn' onclick=\"man_data('"+info.uroll+"',2)\"><img src='assets/images/Bag-Linear-32px.svg' ></button></td><td class='last_col'>";
						if(info.status!="transaction complete")
						{
							if(info.status!="demote by admin")
								student_data=student_data+" <button class='act-btn' onclick=\"man_data('"+info.uroll+"',1)\">Demote</button>";
							if(info.status!="forwarding to bank")
								student_data=student_data+"<button class='act-btn' onclick=\"man_data('"+info.uroll+"',3)\">Promote</button>";
							if(info.status=="forwarding to bank")
								student_data=student_data+"<button class='act-btn' onclick=\"man_data('"+info.uroll+"',4)\">Approve</button>";  
							student_data=student_data+"</td></tr>";
						}
					}
				}
				else
				{
					student_data="<tr class='rows'> <td colspan='8' style='text-align:center'>Sorry there are no current application for this year. But you can use search option.</td> </tr>";
				}
				$("#user_table").html(student_data);
				
			});
}
fetch_data(0);//Function call. Here 0 means when shearching is called only table body will reload not the whole details containg total students, pending..etc
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////
//(06/04/2023  1:50 am) This the block for use Dark Mode
$(document).ready(function(){
	$("#dark_mode").on('change',function() {
		if (this.checked == true)
		{
			$('.sidebar').css('background-color','black');
			$('.pop_up').css('background-color','black');
			$('.pop_up').css('border','1px solid white');
			$('.pop_up').css('color','white');
			$("body").css("background-color","black");
			$("body").css("color","white");
		}
		else
		{
			$('.sidebar').css('background-color','rgb(190, 204, 249)');
			$('.pop_up').css('background-color','rgb(228, 228, 228)');
			$('.pop_up').css('color','black');
			$("body").css("background-color","white");
			$("body").css("color","black");
		}
	});
});
/////////////////////////////////////////////////////////////////////

$(".student_info button:nth-child(1)").click(function()// approve in pop up box
{
	
	if(confirm("Are you sure?"))
		{
			id=$("#_st_uroll").html()+$("#_st_year").html();
			//id="154012200012023";
			let formD="approve_student="+id;
			$.ajax({
				type: "POST",
				url: "php/admin_process.php",
				data: formD,
				}).success(function (data){
					if(data==0)
					{
						alert("There are some error");
						return false;
					}	
					else if(data==-1)
					{
						alert("Warning the XSS attack is dectected");
					}
					else if(data==1)
					{
						$("#_st_status").html("approved");
						$("#"+id+" td:nth-child(6)").html('approved');
						$(".student_info button:nth-child(1)").hide();
					}
				});
			
		}
});


function fileValidation() {
		
            var fileInput =document.getElementById('ad_photo');
            var filePath = fileInput.value;
            var allowedExtensions =/(\.jpg|\.png|\.jpeg)$/i;
            if (!allowedExtensions.exec(filePath)) {
                alert('You should select an image like jpg,jpeg or png file');
                fileInput.value = '';
                return false;
            }
        }
