<?php
session_start();//Session start. It is a array.


// if ($_SERVER["REQUEST_METHOD"] != "POST") {
	// header("Location: index.php");
// }

//Setup the connection with the server and database
try
{
	$conn = new mysqli("localhost","root","","caution_money_refund_sys");// For ofline Xammp
}
catch(Exception $e)
{
	die("Please double check connections. There are some error");
}
//--------------------server--username-password--database-------



//Insert, Delete, and Update, drop, truncate, query can perform by this function.
function SQL($sql)// SQL(The Query inside the brackets)
{
	global $conn;
	mysqli_query($conn,$sql);
}

//Select query can perform by this function, and return the whole array, if any problem returns 0.
function SELECT($sql) //SELECT(The Query inside the brackets)
{
	global $conn;
	$ifhas=mysqli_query($conn,$sql);
	$table_data=array();
	$blank=array();
	if(mysqli_num_rows($ifhas))
	{
		while($row=mysqli_fetch_array($ifhas)) //Returs the row of the output
		{
			
			foreach ($row as $key => $value)
			{
				if(is_int($key))
				{
					unset($row[$key]);
				}
			}
			
			$table_data[]=$row;
		}
		return $table_data;
	}
	else
	{
		return $blank;
	}
}

//Set the default time zone on asia/kolkata
date_default_timezone_set("Asia/Kolkata");

//Store today's date on yyyy-mm-dd format
$DATE=date('Y-m-d');

//The name of developers
$GROUP=['Ardhendu Dutta','Arindam Das','Bibhas Das','Soumyadip Das','Utsha Rudra','Sharmi Karmakar','Bineeta Saha','Keya Das',];
sort($GROUP);


function compress_image($source_url,$destination_url,$quality)
{
    $info = getimagesize($source_url);
    if ($info['mime'] == "image/jpeg") 
        $image = imagecreatefromjpeg($source_url);
    elseif ($info['mime'] == "image/gif") 
        $image = imagecreatefromgif($source_url);
    elseif ($info['mime'] == "image/png") 
        $image = imagecreatefrompng($source_url);
    elseif ($info['mime'] == "image/jpg") 
        $image = imagecreatefromjpeg($source_url);
    
    imagejpeg($image, $destination_url, $quality);
    return $destination_url;
}


/*Validation Code for checking /$_POST's variables*/
function input_check($data) 
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
/*************************************************/

//Function for send mail using web mail server (000webhostapp.com) It has limit 20 mail per day.
function mail_send($password,$sender,$receiver,$subject,$message)
{
	$url = "https://bibhasmail.000webhostapp.com/api/index.php?password=".base64_encode($password)."&sender=".base64_encode($sender)."&receiver=".base64_encode($receiver)."&subject=".base64_encode($subject)."&message=".base64_encode($message); 
	$response  = file_get_contents($url);
	$jsonobj  = json_decode($response);
	return $jsonobj->response;
}
?>