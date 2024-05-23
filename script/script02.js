let code=`<style>body {font-family: Arial, sans-serif;display: flex;justify-content: center;align-items: center;height: 80vh;}
#otp-form {display: flex;flex-direction: column;justify-content: center;align-items: center;height: 80px;background-color: #f0f0f0;padding:20px;border-radius:10px;}
.otp-input {width: 30px;height: 30px;text-align: center;font-size: 16px;border:none;border-bottom: 1px solid black;outline: none;background-color: #f0f0f0;margin-right: 10px;color:green;}
.otp-input:last-child {margin-right: 0;}
</style></head><body><div id='otp-form'>
<center><b>Enter OTP for verify </b><br><span id='email'>example@gmail.com</span></center><br><form><div class='otp-input-group'>
<input class='otp-input' type='text' name='digit-1' pattern='\d' maxlength='1' onkeyup='moveToNext(this)' autofocus>
<input class='otp-input' type='text' name='digit-2' pattern='\d' maxlength='1' onkeyup='moveToNext(this)'>
<input class='otp-input' type='text' name='digit-3' pattern='\d' maxlength='1' onkeyup='moveToNext(this)'>
<input class='otp-input' type='text' name='digit-4' pattern='\d' maxlength='1' onkeyup='moveToNext(this)'>
<input class='otp-input' type='text' name='digit-5' pattern='\d' maxlength='1' onkeyup='moveToNext(this)'>
<input class='otp-input' type='text' name='digit-6' pattern='\d' maxlength='1' onkeyup='showOTP()'></div></form></div>`;

  function validateForm() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var confirm_password = document.getElementById("confirm_password").value;
    var email_regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var password_regex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    if (!email_regex.test(email)) {
      alert("Please enter a valid email address.");
      return false;
    }
    if (!password_regex.test(password)) {
      alert("Please enter a password that is at least 8 characters long and contains at least one uppercase letter, one lowercase letter, and one number.");
      return false;
    }
    if (password != confirm_password) {
      alert("Passwords do not match.");
      return false;
    }
    return true;
  }
  
  function validatePassword() {
    var password = document.getElementById("password").value;
    var lengthCondition = password.length >= 8;
    var lowercaseCondition = /[a-z]/.test(password);
    var uppercaseCondition = /[A-Z]/.test(password);
    var numberCondition = /\d/.test(password);
    var lengthIcon = document.getElementById("length-icon");
    var lowercaseIcon = document.getElementById("lowercase-icon");
    var uppercaseIcon = document.getElementById("uppercase-icon");
    var numberIcon = document.getElementById("number-icon");
    var submitButton = document.getElementById("button");

    if (lengthCondition) {
      lengthIcon.style.color = "green";
    } else {
      lengthIcon.style.color = "red";
    }

    if (lowercaseCondition) {
      lowercaseIcon.style.color = "green";
    } else {
      lowercaseIcon.style.color = "red";
    }

    if (uppercaseCondition) {
      uppercaseIcon.style.color = "green";
    } else {
      uppercaseIcon.style.color = "red";
    }

    if (numberCondition) {
      numberIcon.style.color = "green";
    } else {
      numberIcon.style.color = "red";
    }

    if (lengthCondition && lowercaseCondition && uppercaseCondition && numberCondition) {
      submitButton.disabled = false;
    } else {
      submitButton.disabled = true;
    }
  }
  

  $("#form").submit(function(e){
	  if(validateForm())
	  {
		  e.preventDefault();
		  $(".loader img").show();
		  const formD = new FormData(document.getElementById('form'));
		$.ajax({
		  type: "POST",
		  url: "php/insert.php",
		  data: formD,
		  dataType: "json",
		  processData: false,
		  contentType: false,
		  cache: false,
		}).success(function (data){
			if(data.response=='unsuccess')
			{
				alert(data.message);
				location.reload();
			}
			if(data.response=='success')
			{
				alert(data.message);
				$("body").html(code);
				$("#email").html(data.email);
			}
		});
	  }
  });
  
  
  
  
  
////////////////////////////////////////////////////////////  
   function moveToNext(current) {
      if (current.value.length === current.maxLength) {
        var next = current.nextElementSibling;
        if (next) {
          next.focus();
        }
      }
    }

    function showOTP() {
	  let i;
	  let otp = "";
	  for(i=1;i<=6;i++)
	  {
		var digits = document.getElementsByName("digit-"+i);
		otp=otp+digits[0].value;
	  }
	  let formD="otp="+otp;//+"&email="+$("#email").html();//+"&uroll="+$("#uroll").html();
	  $.ajax({
		  type: "POST",
		  url: "php/insert.php",
		  data: formD,
		  dataType: "json",
		  processData: false,
		  //contentType: false,
		  cache: false,
		}).success(function (data){
			if(data.response=="unsuccess")
			{
				alert("OTP is wrong please sign-up yourself onece again");
				location.reload();
			}
			if(data.response=="success")
			{
				alert("Sing-up completed. Now you can log-in and fill up your form");
				window.location.href="student_login.php";
			}
		});
	  
    }