function validateForm() {
    var email = document.forms["myForm"]["email"].value;
    var password = document.forms["myForm"]["password"].value;
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    var passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
    if (!emailPattern.test(email)) {
        alert("Invalid email address");
        return false;
    }
    if (!passwordPattern.test(password)) {
        alert("Password must contain at least 8 characters, one uppercase, one lowercase and one number");
        return false;
    }
}

$(document).ready(function() {
  $('#a_log').submit(function(e) {
    e.preventDefault(); // prevent form submission

    // create form data object
    var formData = new FormData(this);

    // submit form data via AJAX
    $.ajax({
      url: "php/a_logcheck.php",
      type: "POST",
      data: formData,
	  dataType: "json",
      contentType: false,
      processData: false,
      success: function(response) {
		if(response.msg=='login Success.'){
			alert(response.msg);
			if(response.admin_type=='cashier'){
				window.location.href="cashier.php";
			}else{
				window.location.href="faculty.php";
			}
		}else{
			alert(response.msg);
		}
      }
    });
  });
});
