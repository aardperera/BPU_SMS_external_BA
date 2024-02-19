<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type='text/css' media='print'>
	@page {size:A4; size:portrait}
	#btnPrint {display : none}
</style>
<?php
ob_start();
 include('dbAccess.php');

$db = new DBOperations();
?>
<?php
$regNo = $_POST['IndexNoId'];
$query="SELECT e.regNo, s.nameEnglish, s.addressE1, s.addressE2, s.addressE3, c.courseCode
FROM student s, crs_enroll e, course c
WHERE e.studentID = s.studentID
AND e.courseID = c.courseID
AND e.regNO = '$regNo'";



//$query = "SELECT * FROM student WHERE studentID='$studentID'";
$result = $db->executeQuery($query);
	$row =  $db->Next_Record($result);
	if ($db->Row_Count($result)>0)
	{

?>
<div align="right"><input type="button" id="btnPrint" value="Print" onClick="window.print();return false"/></div>
</head>

<body>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" > 
		<tr>
			<td width="60%">
				<p><b>Registration:</b><u>
				<?php echo $row['regNo']; ?></u>
				</p>
			</td>			
			<td width="40%">
				<p><b>Name in Full:</b>
				<u><?php echo $row['nameEnglish']; ?></u>
				</p>
			</td>
		</tr>
		<tr>
			<td rowspan="3" >
				<table cellpadding="60" cellspacing="" border="1" align="center" width="20%" > 
					<tr>
						<td >
							<p align="center">Photograph</p>
						</td>
					</tr>
				</table>
				<p align="center"><b> .......................................................</b></p>
				<p align="center"><b> Candidate’s Signature</b></p>
			</td>
			<td>
				<p><b>Permanent Address:</b><u>
				<?php echo $row['addressE1']; ?></br>
				<?php echo $row['addressE2']; ?></br>
				<?php echo $row['addressE3']; ?></u>
				</p>
			</td>
		
			<tr>
			<td  rowspan="3" >
				<table border="1" cellspacing="0" cellpadding="10" align="left" width="100%">
					<p><b>Postgraduate degree examination</b></p>
							<tr>
								<td width="35%">Course</td>
								<td width="35%">Date of Registration</td>
								<td width="30%">Register's initials</td>
							</tr>
							<tr>
								<td><?php echo $row['courseCode']; ?></td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							</tr>
							<tr>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							</tr>						
				</table>
			</td>
		</tr>
	</tr>
	</table>
</body>
</html>

<?php } ?>