var marks = document.querySelectorAll(".progressbar-container>ul>li");
// console.log(marks);
var forms = document.querySelectorAll(".form-wrapper>form");
// console.log(forms);
var btns_wrapper = document.querySelectorAll(".btn-wrapper");
// console.log(btns_wrapper);
var btns = document.querySelectorAll(".btn-wrapper>button");
// console.log(btns);

// form1-next-btn
btns[0].addEventListener('click', () => {
  forms[0].style.display = 'none';
  forms[1].style.display = 'block';

  btns_wrapper[0].style.display = 'none';
  btns_wrapper[1].style.display = 'flex';

  marks[1].classList.add("active");
});

// fomr2-next-btn
btns[2].addEventListener('click', () => {
  forms[1].style.display = 'none';
  forms[2].style.display = 'block';

  btns_wrapper[1].style.display = 'none';
  btns_wrapper[2].style.display = 'flex';

  marks[2].classList.add("active");
});

// form2-back-btn
btns[1].addEventListener('click', () => {
  forms[1].style.display = 'none';
  forms[0].style.display = 'block';

  btns_wrapper[1].style.display = 'none';
  btns_wrapper[0].style.display = 'flex';

  marks[1].classList.remove("active");
});

// fomr3-next-btn
btns[4].addEventListener('click', () => {
  forms[2].style.display = 'none';
  forms[3].style.display = 'block';

  btns_wrapper[2].style.display = 'none';
  btns_wrapper[3].style.display = 'flex';

  marks[3].classList.add("active");
});

// form3-back-btn
btns[3].addEventListener('click', () => {
  forms[2].style.display = 'none';
  forms[1].style.display = 'block';

  btns_wrapper[2].style.display = 'none';
  btns_wrapper[1].style.display = 'flex';

  marks[2].classList.remove("active");
});

// form4-back-btn
btns[5].addEventListener('click', () => {
  forms[3].style.display = 'none';
  forms[2].style.display = 'block';

  btns_wrapper[3].style.display = 'none';
  btns_wrapper[2].style.display = 'flex';

  marks[3].classList.remove("active");
});
// ------------------------------------------------------------------------------
const sidebar = document.querySelector(".sidebar");
const menu = document.querySelector("#menu");
const menu_container = document.querySelector(".menu-container");
const logout_container = document.querySelector(".logout-container");

const icon_logout = document.querySelector(".icon-logout");

const clients = document.querySelector("#clients");
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
  button.style.backgroundColor = "#6d18c2";
};

// menu.addEventListener("click", (e) => {
  // sidebar.classList.contains("active") ? closeMenu() : openMenu();
// });
/*
const openMenu = () => {
  sidebar.classList.add("active");
  sidebar.style.width = "250px";
  toggleMenu(menu);

  let p_clients = document.createElement("p");
  p_clients.id = "p-clients";
  p_clients.innerHTML = "Profile";
  clients.style.width = "220px";
  clients.style.justifyContent = "left";
  clients.appendChild(p_clients);

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
  logout_photo.src = "./assets/images/user.png";
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

  logout_container.removeChild(document.getElementById("logout-photo"));
  logout_container.removeChild(document.getElementById("user-container"));
  logout_container.style.paddingLeft = "0px";

  icon_logout.style.width = "100%";

  sidebar.classList.remove("active");
  sidebar.style.width = "78px";
};
*/

$("#submitBtn").click(function(){
	const formdata = new FormData();
	
	function append(n)
	{
		let fd = new FormData(document.getElementById(n));
		for (var p of fd) 
		{
			formdata.append(p[0],p[1]);
		}
	}
	append("form1");
	append("form2");
	append("form3");
	append("form4");
	
	$.ajax({
		type: "POST",
		url: "php/get_userdata.php",
		data: formdata,
		dataType: "json",
		enctype:"multipart/form-data",
		processData: false,
		contentType: false,
		cache: false,
	
	}).success(function(data){
		$("input,select").css("border","1px solid rgba(128, 128, 128, 0.332)");
		if(data.status=="false")
		{
			if(data.field==0)
			{
				alert("Something is wrong.");
				window.location.href='profile.php';
			}
			
			var array=data.field;
			for (var i = 0; i < array.length; i++) 
			{
				var f=array[i];
				if(f==9)
					$("select").css("border","1px solid red");
				else if(f<9)
					$("input:eq("+(parseInt(f)-1)+")").css("border","1px solid red");
				else if(f==201 || f==202)
					$("input:eq(18)").css("border","1px solid red");
				else if(f==211 || f==212)
					$("input:eq(19)").css("border","1px solid red");
				else if(f==221 || f==222)
					$("input:eq(20)").css("border","1px solid red");
				else if(f==231 || f==232)
					$("input:eq(21)").css("border","1px solid red");
				else
					$("input:eq("+(parseInt(f)-2)+")").css("border","1px solid red");
				//else
					//$("input:eq("+(parseInt(f)-1)+")").css("border","2px solid green");
			}
			
			alert("Please move back and fillup all fields");
		}
		else if(data.status=="true")
		{
			alert("Successfull");
			window.location.href='profile.php';
		}
	});
});



function fileValidation(id) {
		
            var fileInput =document.getElementById(id);
            var filePath = fileInput.value;
            var allowedExtensions =/(\.jpg|\.png|\.jpeg)$/i;
            if (!allowedExtensions.exec(filePath)) {
                alert('You should select an image like jpg,jpeg or png file');
                fileInput.value = '';
                return false;
            }
        }





