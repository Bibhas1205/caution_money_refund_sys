<?php

	session_start();
	$_SESSION['login_status']=true;
	$_SESSION['user']="lab technician";
	
	print_r($_SESSION);

?>