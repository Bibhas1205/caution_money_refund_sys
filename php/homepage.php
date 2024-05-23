<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
	header("Location: index.php");
}
$info=$_SERVER;
$device=$_SERVER["HTTP_USER_AGENT"];
preg_match('/\((.*?)\)/', $device, $matches);
$subString = $matches[1];
$subString = str_replace(";", " ", $subString);
echo $subString;

?>