<?php
echo 'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh';
	$cnn=@mysql_connect('localhost','root','');
     if (!$cnn) 
	 {
     die('<p>Unable to connect to the database server at this time!</p>');
     } 
	 
	 else {
	 echo 'dddddddddddddddddddddddd';
	 
	 }
//Select the database
if (!@mysql_select_db("sms_external", $cnn)){
die('<p>Unable to locate Database at this time.</p>');
}
else{
echo 'hI';
} 
?>