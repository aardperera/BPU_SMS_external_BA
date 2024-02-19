﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exam Schedule - Student Management System (External) - Buddhist & Pali University of Sri Lanka</title>
<link href="css/print.css" rel="stylesheet" type="text/css" media="screen,print,projection"  />
<style type='text/css' media='print'>
	@page {size:A4; size:portrait}
	#btnPrint {display : none}
</style>
<?php
 include('dbAccess.php');

$db = new DBOperations();
?>
<div align="right"><input type="button" id="btnPrint" value="Print" onClick="window.print();return false"/></div>
<h2 align="center">ශ්‍රී ලංකා බෞ‍ද්ධ හා පාලි විශ්වවි‍ද්‍යාලය - විභාග කාලසටහන</h2>
<h2 align="center">Buddhist & Pali University of Sri Lanka - Exam Timetable</h2>
<h3 align="center"><?php echo $_POST['txtReportHeading']; ?></h3>
</head>

<body>
	<table width="100%">
    	<thead>
        	<tr><th>Date<br/>දිනය</th><th>Time<br/>වේලාව</th><th>Code<br/>අංකය</th><th>Subject<br/>විෂය</th><th>Venue<br/>ස්ථානය</th></th>
        </thead>
        <tbody>
<?php
		session_start();
		$query = $_SESSION['query'];
		$result = $db->executeQuery($query);
		while ($row= $db->Next_Record($result))
		{
			echo "<tr><td>".$row['date']."</td><td>".$row['time']."</td>";
			if ($row['medium']=='English') echo "<td>".$row['codeEnglish']."</td><td width='30%'>".$row['nameEnglish']."</td>";
			elseif ($row['medium']=='Sinhala') echo "<td>".$row['codeSinhala']."</td><td width='30%'>".$row['nameSinhala']."</td>";
			echo "<td>".$row['venue']."</td></tr>";
		}
?>
        </tbody>
    </table>
</body>
</html>
