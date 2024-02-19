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
<?php
 include('dbAccess.php');

$db = new DBOperations();
?>
<div align="right"><input type="button" id="btnPrint" value="Print" onClick="window.print();return false"/></div>
<center><img src="http://www.bpu.ac.lk/images/theme/logo-top.png" alt="university icon" width="75" height="75"></center>
<h2 align="center">BUDDHIST AND PALI UNIVERSITY OF SRI LANKA</h2>
<h2 align="center">Course End Examination of Diploma in English - <?php if($_POST['txtTimePeriod'] == '') echo 'Enter Time period'; else echo $_POST['txtTimePeriod']; ?></h2>
<h2 align="center"><?php  if ($_POST['txtReportHeading'] == '') echo 'Enter Report Heading'; else echo $_POST['txtReportHeading']; ?></h2>
<h3 align="center">TIME TABLE</h3>

</head>

<body>
	<!--<table align="center" width="100%">-->
    	
        <tbody>
			<TABLE align="center" BORDER="4"    WIDTH="100%"   CELLPADDING="6" CELLSPACING="3">
   
			<TR>
				<TH Rowspan="2"<H3><i>Date<br/>දිනය</i></H3>
				</TH>
				<TH COLSPAN="3"><BR><H3><i>Time<br/>වේලාව</i></H3>
				</TH>
			</TR>
			<TR >
				<TH>9.00 a.m - 12.00 noon<br/>පෙ.ව  9.00 - ප.ව  12.00 </TH>
				<TH>1.00 p.m - 4.00 p.m<br/>ප.ව  1.00 - ප.ව  4.00 </TH>
				<TH>Venue<br/>ස්ථානය</TH>
			</TR>
	
			<?php
						
				session_start();
				$query = $_SESSION['query'];
				$result = $db->executeQuery($query);
								
				while ($row= $db->Next_Record($result))
				
								
			{
				echo "<tr><td>".$row['date']."</td>";
				
				echo '<td>'; if ($row['medium']== 'English' and $row['time'] <= '12:30:00') echo ''.$row['nameEnglish'].''; 
				elseif ($row['medium']== 'Sinhala' and $row['time'] <= '12:30:00') echo ''.$row['nameSinhala'].''; 
				else echo " "; '</td>';
				
				echo '<td>'; if ($row['medium']== 'English' and $row['time'] > '12:30:00') echo ''.$row['nameEnglish'].''; 
				elseif ($row['medium']== 'Sinhala' and $row['time'] > '12:30:00') echo ''.$row['nameSinhala'].''; 
				else echo " "; '</td>';
				
				echo "<td>".$row['venue']."</td></tr>"; 
				
												 
				
			} 
			
			
			?>
			
			</TABLE>
        </tbody>
    <!--</table>-->
</body>
<body><br>
On every occasion the candidate sits a paper the identify certificate issued by the university should be produced as proof of identity.

<p><br>.................................... <br>
A.L.M.S.D.Ambegoda<br>
Deputy Registrar<br>
For Registrar<br>

<?php
echo date ('Y-m-d');
?>
</p>
</html>