<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--<link href="css/print.css" rel="stylesheet" type="text/css" media="screen,projection,print" />-->
<style type='text/css' media='print'>
	@page {size:A4; size:portrait}
	#btnPrint {display : none}
</style>
<title>Academic Transcript - Student Management System (External) - Buddhist & Pali University of Sri Lanka</title>
</head>

<body>
    <?php
	include('dbAccess.php');

$db = new DBOperations();

	$indexNo = $db->cleanInput($_GET['indexNo']);
	$registrar = $db->cleanInput($_GET['registrar']);

	$withMarks = $_GET['withMarks'];
	$result = $db->executeQuery("SELECT nameEnglish FROM course WHERE courseID IN (SELECT courseID FROM crs_enroll WHERE indexNo='$indexNo')");
	$row = $db->Next_Record($result);
	$courseName = $row['nameEnglish'];
	$result = $db->executeQuery("SELECT nameEnglish FROM student WHERE studentID IN (SELECT studentID FROM crs_enroll WHERE indexNo='$indexNo')");
	$row = $db->Next_Record($result);
	$studentName = $row['nameEnglish'];
	$query = "SELECT codeEnglish,nameEnglish,level,grade,MAX(marks) as marks,effort FROM exameffort JOIN subject ON exameffort.subjectID=subject.subjectID WHERE indexNo='$indexNo' GROUP BY exameffort.subjectID ORDER BY level";
	print($query);
	$result = $db->executeQuery($query);
	if ($db->Row_Count($result)==0) die("This student has not registered for any examination units.");
    ?>
	<div align="right"><input type="button" id="btnPrint" value="Print" onClick="window.print();return false"/></div>
    <h2 align="center">Buddhist & Pali University of Sri Lanka</h2>
    <h3 align="center">Academic Transcript</h3>
    <p align="right">Date of Issue : <?php echo date('d-m-Y'); ?></p>
	<h4 align='center'><u><?php echo $courseName; ?></u></h4>
    
    <table border='0' width='100%'>
			<tr>
				<th colspan="2"><u>Study Unit</u></th>
				<th><u>Grade</u></th>
				<?php if ($withMarks=='on') echo "<th><u>Marks</u></th>"; ?>
				<th><u>Effort</u></th>
			</tr>
        <?php
        //    $arrLevel = queryOfQuery($result,"level",true);
		$query = "SELECT codeEnglish,nameEnglish,level,grade,marks,effort FROM exameffort JOIN subject ON exameffort.subjectID=subject.subjectID WHERE indexNo='001' AND level= true AND effortID IN (SELECT effortID FROM exameffort JOIN (SELECT subjectID,MAX(marks) as marks FROM exameffort GROUP BY subjectID) AS temp_ee ON exameffort.subjectID=temp_ee.subjectID AND exameffort.marks=temp_ee.marks) ORDER BY level";
	    $arrLevel = $db->executeQuery($query);
		$numExams = $db->numRows($arrLevel);
	if ($numExams>1)
	{
		for ($i=1;$i<=$numExams;$i++)
		{
			$curLevel = $arrLevel[($i-1)]['level'];
			echo "<tr><td align='left' colspan='4'><u>Examination $i</u></td></tr>";
			$subjects = queryOfQuery($result,"*",false,"level",$curLevel);
			for ($j=0;$j<count($subjects);$j++)
			{
				echo "<tr align='center'><td>".$subjects[$j]['codeEnglish']."</td><td align='left'>".$subjects[$j]['nameEnglish']."</td><td>".$subjects[$j]['grade']."</td>";
				if ($GLOBALS['withMarks']=='on') echo "<td>".$subjects[$j]['marks']."</td>";
				echo "<td>".$subjects[$j]['effort']."</td></tr>";
			}
		}
	}
	else
	{
		while ($row =  $db->Next_Record($result))
		{
			echo "<tr align='center'><td align='left'>".$row['codeEnglish']."</td><td align='left'>".$row['nameEnglish']."</td><td>".$row['grade']."</td>";
			if ($GLOBALS['withMarks']=='on') echo "<td>".$row['marks']."</td>";
			echo "<td>".$row['effort']."</td></tr>";
		}
	}
        ?>
	</table>
	<br/><br /><br />
	<table border="0" width="100%">
    	<tr valign="top">
        	<td width="30%">Prepared by:</td>
            <td width="30%">Checked by:</td>
            <td></td>
        </tr>
        <tr>
        	<td></td>
            <td></td>
            <td><?php echo $registrar;?><br/>Asst. Registar (Examinations) <br/>for Registar</td>
        </tr>
    </table>
    <br/>
    <table border="0">
    	<tr><th colspan="3" align="left">Key to Grading</th></tr>
        <tr><td>A - (70-100)</td><td>B - (55-69)</td><td>C - (40-54)</td></tr>
        <tr><td>D - (30-39)</td><td>E - (0-29)</td><td>ab - Absent</td></tr>
    </table>
</body>
</html>
