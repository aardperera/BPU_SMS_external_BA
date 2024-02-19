<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
include('dbAccess.php');

$db = new DBOperations();

$result = $db->executeQuery("SELECT * FROM course");

$subjects = queryOfQuery($result,"*");
for ($j=0;$j<count($subjects);$j++)
{
	echo $subjects[$j]['nameEnglish']."<br/>";
}

print_r($subjects);
?>
</body>
</html>
