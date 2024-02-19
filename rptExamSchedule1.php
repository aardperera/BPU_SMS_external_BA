<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Exam Schedule - Student Management System (External) - Buddhist & Pali University of Sri Lanka</title>
<link href="css/print.css" rel="stylesheet" type="text/css" media="screen,print,projection"  />
<style type='text/css' media='print'>
	@page {size:A4; size:portrait}
	#btnPrint {display : none}
</style>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
</head>
<body>
<center><img src="http://www.bpu.ac.lk/images/theme/logo-top.png" alt="" width="60" height="60"></center>
<?php 
include('dbAccess.php');

$db = new DBOperations();

//connect to the database

$examType= $_POST["course"];
$medium= $_POST["Medium"];
//S$level = $_POST["Level"];
$exam;
 
if ($medium == "English"){
 ?>
	<h1 align="center">BUDDHIST AND PALI UNIVERSITY OF SRI LANKA</h1>
	<h2 align="center">Course End Examination of <? php echo $examType; ?> in English-November 2013/2014</h2>
	<h3 align="center"> <?php echo $examType; ?> - Time Table</h3>
	<?php
//////////////////////////////////////   changed only this section 

if ( $examType=="Diploma Level"){
//query
$query = $db->executeQuery("SELECT t.date, 
       MAX(CASE WHEN t.time = '9to12' THEN s.nameEnglish ELSE '' END) AS `9to12`,  
       MAX(CASE WHEN t.time = '1to4' THEN s.nameEnglish ELSE '' END) AS `1to4`,  
       t.venue  
FROM examschedule t
INNER JOIN subject s ON t.subjectID = s.subjectID and level='Diploma Level'
GROUP BY t.date ");
}
if ( $examType=="Certificate Level"){
//query
$query = $db->executeQuery("SELECT t.date, 
       MAX(CASE WHEN t.time = '9to12' THEN s.nameEnglish ELSE '' END) AS `9to12`,  
       MAX(CASE WHEN t.time = '1to4' THEN s.nameEnglish ELSE '' END) AS `1to4`,  
       t.venue  
FROM examschedule t  
INNER JOIN subject s ON t.subjectID = s.subjectID and level='Certificate Level' 
GROUP BY t.date ");
}
//////////////////////////////////////////////////////////////////////////////////////

$i=1;
$j=2;

?>
<table width="1000" align="center">
<tr>
	<th width="150" rowspan="2">Date</th>
	<th colspan="2">Time</th>
	<th width="150" rowspan="2">Venue</th>
</tr>
<tr>
	<th align="center" width="350">9.00 a.m - 12.00 noon</th>
	<th align="center" width="350">1.00 p.m - 4.00 p.m</th>

	
</tr>
<?php
//write the results
while ($row =  $db->Next_Record($query))
{
?>
<tr>
	<td><?php echo  $row['date'] ;?> </td>
	<td> <?php echo $i.". ".$row['9to12'];?></td>
	<td><?php echo $j.". ".$row['1to4'];?></td>
	<td><?php echo $row['venue'] ;?></td>	
</tr>
<?php
$i=$i+2;
$j=$j+2;
// close the loop
}
?>
</table>
    
 <?php
	} else if ($medium == "Sinhala")
	 {
		if ($examType== "Diploma Level")
		{
			$exam="ඩිප්ලෝමා මට්ටම" ;
		}
		else if ($examType== "Certificate Level")
		{
			$exam="ප්‍රවේශ මට්ටම" ;
		}
		
	 ?>
    <h1 align="center">ශ්‍රී ලංකා බෞ‍ද්ධ හා පාලි විශ්වවි‍ද්‍යාලය </h1>
	<h2 align="center">විභාග කාලසටහන - <?php echo $exam; ?>  - නොවෙම්බර් 2013/2014</h2>

   <?php 
    //////////////////////////////////////   changed only this section 
	 
if ( $examType=="Diploma Level"){
//query
$query = $db->executeQuery("SELECT t.date, 
       MAX(CASE WHEN t.time = '9to12' THEN s.nameSinhala ELSE '' END) AS `9to12`,  
       MAX(CASE WHEN t.time = '1to4' THEN s.nameSinhala ELSE '' END) AS `1to4`,  
       t.venue FROM examschedule t
INNER JOIN subject s ON t.subjectID = s.subjectID and level='Diploma Level'
GROUP BY t.date ");

}
if ( $examType=="Certificate Level"){
//query
$query = $db->executeQuery("SELECT t.date, 
       MAX(CASE WHEN t.time = '9to12' THEN s.nameSinhala ELSE '' END) AS `9to12`,  
       MAX(CASE WHEN t.time = '1to4' THEN s.nameSinhala ELSE '' END) AS `1to4`,  
       t.venue FROM examschedule t  
INNER JOIN subject s ON t.subjectID = s.subjectID and level='Certificate Level' 
GROUP BY t.date ");
}
//////////////////////////////////////////////////////////////////////////////////////

$i=1;
$j=2;

?>
<table width="1000" align="center">
<tr>
	<th width="150" rowspan="2">දිනය</th>
	<th colspan="2">වේලාව</th>
	<th width="150" rowspan="2">ස්ථානය</th>
</tr>
<tr>
	<th align="center" width="350">පෙ.ව. 9.00 - ප.ව. 12.00</th>
	<th align="center" width="350">ප.ව. 1.00 - ප.ව. 4.00</th>

	
</tr>
<?php
//write the results
while ($row =  $db->Next_Record($query))
{
?>
<tr>
	<td><?php echo  $row['date'] ;?> </td>
	<td> <?php echo $i.". ".$row['9to12'];?></td>
	<td><?php echo $j.". ".$row['1to4'];?></td>
	
</tr>
<?php
$i=$i+2;
$j=$j+2;
// close the loop
}
?>
</table>
    
    
    
     <?php
	  	 } else if ($medium == "All")
		 {
	
			 ?>
             
    <h1 align="center">BUDDHIST AND PALI UNIVERSITY OF SRI LANKA</h1>
    <h1 align="center">ශ්‍රී ලංකා බෞ‍ද්ධ හා පාලි විශ්වවි‍ද්‍යාලය </h1>
	<h2 align="center">Course End Examination of <?php echo $examType; ?> in English-November 2013/2014</h2>
	<h3 align="center"> <?php echo $examType; ?> - Time Table</h3>
	<?php

//////////////////////////////////////   changed only this section 
if ( $examType=="Diploma Level"){
//query
$query = $db->executeQuery("SELECT t.date, 
       MAX(CASE WHEN t.time = '9to12' THEN s.nameEnglish ELSE '' END) AS `9to12`,  
       MAX(CASE WHEN t.time = '1to4' THEN s.nameEnglish ELSE '' END) AS `1to4`,  
       t.venue  
FROM examschedule t
INNER JOIN subject s ON t.subjectID = s.subjectID and level='Diploma Level'
GROUP BY t.date ");
}
if ( $examType=="Certificate Level"){
//query
$query = $db->executeQuery("SELECT t.date, 
       MAX(CASE WHEN t.time = '9to12' THEN s.nameEnglish ELSE '' END) AS `9to12`,  
       MAX(CASE WHEN t.time = '1to4' THEN s.nameEnglish ELSE '' END) AS `1to4`,  
       t.venue  
FROM examschedule t  
INNER JOIN subject s ON t.subjectID = s.subjectID and level='Certificate Level' 
GROUP BY t.date ");
}
//////////////////////////////////////////////////////////////////////////////////////

$i=1;
$j=2;

?>
<table width="1000" align="center">
<tr>
	<th width="150" rowspan="2">Date</th>
	<th colspan="2">Time</th>
	<th width="150" rowspan="2">Venue</th>
</tr>
<tr>
	<th align="center" width="350">9.00 a.m - 12.00 noon</th>
	<th align="center" width="350">1.00 p.m - 4.00 p.m</th>

	
</tr>
<?php
//write the results
while ($row =  $db->Next_Record($query))
{
?>
<tr>
	<td><?php echo  $row['date'] ;?> </td>
	<td> <?php echo $i.". ".$row['9to12'];?></td>
	<td><?php echo $j.". ".$row['1to4'];?></td>
	<td><?php echo $row['venue'] ;?></td>	
</tr>
<?php
$i=$i+2;
$j=$j+2;
// close the loop
}
?>
</table>
    
 <?php
		if ($examType== "Diploma Level")
		{
			$exam="ඩිප්ලෝමා මට්ටම" ;
		}
		else if ($examType== "Certificate Level")
		{
			$exam="ප්‍රවේශ මට්ටම" ;
		}
		
	 ?>
    
	<h2 align="center">විභාග කාලසටහන - <?php echo $exam; ?>  - නොවෙම්බර් 2013/2014</h2>

   <?php 
    //////////////////////////////////////   changed only this section 
	 
if ( $examType=="Diploma Level"){
//query
$query = $db->executeQuery("SELECT t.date,
       MAX(CASE WHEN t.time = '9to12' THEN s.nameSinhala ELSE '' END) AS `9to12`,  
       MAX(CASE WHEN t.time = '1to4' THEN s.nameSinhala ELSE '' END) AS `1to4`,  
       t.venue FROM examschedule t
INNER JOIN subject s ON t.subjectID = s.subjectID and level='Diploma Level'
GROUP BY t.date ");

}
if ( $examType=="Certificate Level"){
//query
$query = $db->executeQuery("SELECT t.date, 
       MAX(CASE WHEN t.time = '9to12' THEN s.nameSinhala ELSE '' END) AS `9to12`,  
       MAX(CASE WHEN t.time = '1to4' THEN s.nameSinhala ELSE '' END) AS `1to4`,  
       t.venue FROM examschedule t  
INNER JOIN subject s ON t.subjectID = s.subjectID and level='Certificate Level' 
GROUP BY t.date ");
}
//////////////////////////////////////////////////////////////////////////////////////

$i=1;
$j=2;

?>
<table width="1000" align="center">
<tr>
	<th width="150" rowspan="2">දිනය</th>
	<th colspan="2">වේලාව</th>
	<th width="150" rowspan="2">ස්ථානය</th>
</tr>
<tr>
	<th align="center" width="350">පෙ.ව. 9.00 - ප.ව. 12.00</th>
	<th align="center" width="350">ප.ව. 1.00 - ප.ව 4.00</th>

	
</tr>
<?php
//write the results
while ($row =  $db->Next_Record($query))
{
?>
<tr>
	<td><?php echo  $row['date'] ;?> </td>
	<td> <?php echo $i.". ".$row['9to12'];?></td>
	<td><?php echo $j.". ".$row['1to4'];?></td>
	
</tr>
<?php
$i=$i+2;
$j=$j+2;
// close the loop
}
?>
</table>

<?php
}      

?>
</body>
</html>
