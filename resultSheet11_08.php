<?php
//Result Page
ob_start();
include('dbAccess.php');

$db = new DBOperations();

	
$index_No = $_POST['lstIndexNo'];
$ename = $_POST['txtEName'];
$sname = $_POST['txtSName'];
$med = $_POST['lstMedium'];
$date = "2014.01.01";
?>

<?php 

if($med == "English")
{
echo'
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link rel="stylesheet" href="../SMS_external/css/resultsheet.css" type="text/css">








<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PBU-Examinations</title>
</head>

<body>


    <div class="page">
        <div class="subpage">Page 1    
    

            


<h3 align="center">Master of Arts Degree Examination - Buddhist Studies</h3>

<p align="center">
	This is to certify that '.$ename.' sat the Master of Arts Degree Examination in English Medium held in December 2013 <br>
    under the '.$index_No.' reached the standard required for a pass offering the following subjects. 
</p>
<br>
<br>

<table align="center" width="80%" cellspacing="15" cellpadding="5" border="0" height="10%">
  <tr>
    <th>Subject Number</th>
    <th>Subject</th>		
    <th>Grade</th>
  </tr>';
  
  $exmeft = $db->executeQuery("select * from exameffort where indexNo = '$index_No'");
  if($exmeft === FALSE)
  {
	echo '<hr><table border="1" style="width:100%">
				<tr><td><h4 style=" color: red; text-align: center">
				No Data in Exams </h4><tr><td></table>';
  }
  else{
  while ($roww1 =  $db->Next_Record($exmeft))
  {
	$subjctid = $roww1["subjectID"];
	$grade = $roww1["grade"];
	
	$subjct = $db->executeQuery("select * from subject where subjectID = '$subjctid'");
	while ($roww2 =  $db->Next_Record($subjct))
	{
		$sub_code = $roww2["codeEnglish"];
		$sub_name = $roww2["nameEnglish"];
		echo '<tr>
		<td align="center">'.$sub_code.'</td>
		<td align="left">'.$sub_name.'</td>		
		<td align="center">'.$grade.'</td>
		</tr>';
	}
  }
  echo '
</table>';
}
echo '
<br>
<br>

<table align="center" width="80%" cellspacing="15" cellpadding="5" border="0" height="10%">
<tr>
    <td align="left">Result Valid From : 1st January 2014 </td>
    </tr>
    <tr style="font-size:12px">
    <td align="left">Prepared by : </td>
    <td align="left">Checked by : </td>	
    </tr>
</table>
<br>
<br>

<table align="center" width="80%" cellspacing="15" cellpadding="5" border="0" height="10%" style="font-size:12px">
<tr>
    <td align="left">A.L.M.S.D. Ambegoda <br> 
    				 Deputy Registrar(Postgraduate Degrees & External Exams) <br> 
                     For Registrar </td>
    </tr>
   
</table>

<table align="center" width="80%" cellspacing="15" cellpadding="5" border="0" height="10%" style="font-size:12px">
<tr>
    <td align="center">Key to Gradings :</td>
    <td align="left">A - 75-100 <br> 		
    				 B - 65-74 <br>
                     C - 50-64 <br>
                     D - 40-49 <br>
                     E - 00-39 <br></td>			 
  </tr>
</table>
</div>
</div>
</body>

</html>
';
}
else{
echo'
<html>
	<head>
		<title>Result</title>
		<link rel="stylesheet" href="../SMS_external/css/resultsheet.css" type="text/css">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
	<div class="page">
        <div class="subpage">Page 1    
		<form id = "form1" method = "POST" action = "">
		
			<h2 align = "center">ශාස්ත්‍රපති උපාධි පරීක්ෂණය - බෞද්ධ අධ්‍යයන පාඨමාලාව</h2>
			
			<p align = "center">2013 දෙසැම්බර් මස පැවැති උක්ත පරීක්ෂණයට විභාග අංක '.$index_No.' යටතේ පෙනී සිටි '.$sname.' එම <br/> පරීක්ෂණයෙන් සාමාර්ථය ලබා ගෙන 
			ඇති බව සතුටින් දන්වා සිටිමි. ලබා ඇති ශ්‍රේණි පහත දැක්වේ.</p>
			
			<table align ="center" width = "65%" cellspacing = "15" cellpadding = "5" border ="0" height ="">
				<tr><th>විෂය අංකය</th><th>විෂය</th><th>ශ්‍රේණිය</th></tr>';
				
				$exmeft1 = $db->executeQuery("select * from exameffort where indexNo = '$index_No'");
				if($exmeft1 === FALSE)
				{
					echo '<hr><table border="1" style="width:100%">
					<tr><td><h4 style=" color: red; text-align: center">
					No Data in Exams </h4><tr><td></table>';
				}
				else{
				while ($roww1 =  $db->Next_Record($exmeft1))
				{
					$subjctid = $roww1["subjectID"];
					$grade = $roww1["grade"];
	
					$subjct1 = $db->executeQuery("select * from subject where subjectID = '$subjctid'");
					while ($roww2 =  $db->Next_Record($subjct1))
					{
						$sub_code = $roww2["codeSinhala"];
						$sub_name = $roww2["nameSinhala"];
						echo '<tr>
						<td align="center">'.$sub_code.'</td>
						<td align="left">'.$sub_name.'</td>		
						<td align="center">'.$grade.'</td>
						</tr>';
					}
				}
			echo '
			</table>';
			}
			echo '
			
			<br/><br/>
			
			<table align="center" width="80%" cellspacing="15" cellpadding="5" border="0" height="10%">
			<tr>
			<td align="left">ප්‍රතිඵල වලංගු දිනය : '.$date.'</td>
			</tr>
			<tr style="font-size:12px">
			<td align="left">සකස් කළේ  : </td>
			<td align="left">පරීක්ෂා කළේ : </td>	
			</tr>
			</table>
			
			<br/><br/>
			
			<table align="center" width="80%" cellspacing="15" cellpadding="5" border="0" height="10%" style="font-size:12px">
			<tr>
			<td align="left">ඒ.එල්.එම්.එස්.ඩී. අඹේගොඩ <br> 
    				 නියෝජ්‍ය ලේඛාධිකාර (පශ්චාද් උපාධි හා බාහිර විභාග) <br> 
					ලේඛකාධිකාරී වෙනුවට </td>
			</tr>
   
			</table>
			
			<table align="center" width="80%" cellspacing="15" cellpadding="5" border="0" height="10%" style="font-size:12px">
			<tr>
			<td align="center">ශ්‍රේණි</td>
			<td align="left">ඒ	-	75-100 <br> 		
    				 බී	-	65-74 <br>
					සී	-	50-64 <br>
					ඩී	-	40-49 <br>
					ඊ	-	00-39 <br></td>			 
			</tr>
			</table>
		</form>
		</div>
		</div>
	</body>
</html>';
}
?>