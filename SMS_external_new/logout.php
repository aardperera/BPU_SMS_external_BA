<?php
session_start();
$appUserName = $_SESSION['authenticatedUser'];
$_SESSION['loginMessage'] = "User \"$appUserName\" has logged out";
unset($_SESSION['authenticatedUser']);
unset($_SESSION['courseId']);

//Relocate back to the login page
header("Location: index.php");
?>