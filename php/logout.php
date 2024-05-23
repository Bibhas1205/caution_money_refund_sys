<?php
session_start();
session_destroy();
setcookie('remember_token', '', time() - 86400,"/");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Logout Page</title>
    <link rel="icon" href="../assets/images/daitm.ico" type="image/x-icon">
	<style>

	* {
  box-sizing: border-box;
}

body {
  background-color: #f5f5f5;
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

.container {
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  margin: 50px auto;
  padding: 20px;
  text-align: center;
  width: 400px;
}

h1 {
  font-size: 24px;
  margin-bottom: 20px;
}

a {
  color: #4CAF50;
  text-decoration: none;
  transition: color 0.3s ease;
}

a:hover {
  color: #3e8e41;
}
	
	</style>
  </head>
  <body>
    <div class="container">
      <h1>You have successfully logged out!</h1>
      <p>Thank you for using our application.</p>
      <a href="/">Click here to log in again</a>
    </div>
  </body>
</html>
