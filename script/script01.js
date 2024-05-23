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
	formdata("myForm");
}


$(document).ready(function() {
  $('#myForm').submit(function(e) {
    e.preventDefault(); // prevent form submission

    // create form data object
    var formData = new FormData(this);

    // submit form data via AJAX
    $.ajax({
      url: "php/student_logcheck.php",
      type: "POST",
      data: formData,
	  dataType: "json",
      contentType: false,
      processData: false,
      success: function(response) {
		if(response.msg=='login Success'){
			window.location.href=response.file;
			alert(response.msg);
		}else{
			alert(response.msg);
		}
      }
    });
  });
});

 