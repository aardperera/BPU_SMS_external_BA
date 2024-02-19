<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Attendance - Student Management System (External) - Buddhist & Pali University of Sri Lanka</title>
<link href="css/print.css" rel="stylesheet" type="text/css" />
<style type='text/css' media='print'>
	@page {size:A4; size:portrait}
	#btnPrint {display : none}
</style>
<?php
include('dbAccess.php');

$db = new DBOperations();

$acYear = $db->cleanInput($_GET['lstAcYear']);
$subjectID = $db->cleanInput($_GET['lstSubject']);
$result = $db->executeQuery("SELECT codeEnglish, nameEnglish FROM subject WHERE subjectID=$subjectID");
$subject =  $db->Next_Record($result);
?>
<div align="right"><input type="button" id="btnPrint" value="Print" onClick="window.print();return false"/></div>
<h2 align="center">Buddhist & Pali University of Sri Lanka</h2>
<h3 align="center">Exam Attendance Sheet - <?php echo $acYear; ?></h3>
<h4 align="center"><?php echo $subject['codeEnglish']." - ".$subject['nameEnglish']; ?></h4>
</head>

<body>
	<table width="100%">
    	<thead>
        	<tr>
            	<th></th><th>Reg. No.</th><th>Index No.</th><th>Name</th><th>Medium</th><th>Signature</th>
            </tr>
   		</thead>
        <tbody>
<?php
			$result = $db->executeQuery("SELECT regNo,crs_enroll.indexNo,nameEnglish,medium FROM crs_enroll JOIN student ON crs_enroll.studentID=student.studentID JOIN sub_enroll ON crs_enroll.indexNo=sub_enroll.indexNo WHERE crs_enroll.indexNo IN (SELECT DISTINCT indexNo FROM exameffort WHERE acYear=$acYear AND subjectID=$subjectID)");
			for ($i=1;$i<= $db->Row_Count($result);$i++)
			{
				$row =  $db->Next_Record($result);
				echo "<tr><td>$i</td><td>".$row['regNo']."</td><td>".$row['indexNo']."</td><td>".$row['nameEnglish']."</td><td>".$row['medium']."</td><td></td></tr>";
			}
?>
        </tbody>
    </table>
</body>
</html>
