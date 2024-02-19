<?php

require_once("dbAccess.php");
//session_start();
// $userName;
//echo 'sss';
//echo $password;
function authenticateUser($userName,$password)
{
	$db = new DBOperations();
	//Test the username and password
	if (!isset($userName) || !isset($password)) return false;
	
	//Get 2 characters salt from username
	$salt = substr($userName,0,2);
	
	//Encrypt password
	$crypted_password = crypt($password,$salt);
	
	//clean
	$userName = $db->cleanInput($userName);
	$password = $db->cleanInput($password);
	$crypted_password = $db->cleanInput($crypted_password);
	
	//Formulate the query
	$query = "SELECT courseId
			FROM user_tbl
			WHERE userID = '$userName'
				AND password = md5('$password')";
				//echo $query;
				
	//Execute the query
	$result = $db->executeQuery($query);
	
	
	
	//Should be exactly one row
	if ($db->Row_Count($result) != 1) return false;
	else 
	 {
	$row=$db->Next_Record($result);
	//$row = mysql_fetch_array($result);
	$Cid = $row[0];
	$_SESSION['courseId'] = $Cid; 
	return true;
	}
}

//Main------

session_start();
$authenticated = false;

//Get data collected from the user
$appUserName = $_POST["txtUserName"];
$appPassword = $_POST["txtPassword"];

$authenticated = authenticateUser($appUserName,$appPassword);
if ($authenticated == true)
{
	//Register the customer ID
	$_SESSION['authenticatedUser'] = $appUserName;
	
	
	//Register the remote IP address
	$_SESSION['loginIpAddress'] = $_SERVER['REMOTE_ADDR'];
}
else
{
	//The authentication failed
	$_SESSION['loginMessage'] = "Could not connect to the system as \"$appUserName\"";
}

//Relocate back to the login page
header("Location: index.php");
?>