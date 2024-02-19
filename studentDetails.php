<?php
  //Buffer larger content areas like the main page content
  ob_start();
session_start();
if (!isset($_SESSION['authenticatedUser'])) {
	echo $_SESSION['authenticatedUser'];
	header("Location: index.php");
}
?>
<?php
    error_reporting(E_ALL & ~E_WARNING);
?>
<h1>Student Details</h1>
<?php

	//2021-03-25 start include('dbAccess.php');
	require_once("dbAccess.php");
	$db = new DBOperations();
  //2021-03-25 end

//	include('authcheck.inc.php');
	
	//2021-03-25 start  $studentID = cleanInput($_GET['studentID']);
  $studentID = $db->cleanInput($_GET['studentID']);
  //2021.03.25 end

	$query = "SELECT *,b.nameSinhala,b.districtstate,b.medium,b.contactNo0 FROM student_a as a, ba_applicant as b  WHERE a.studentID='$studentID' and b.applicantID='$studentID'";
  //print $query;

	//2021-03-25 start  $result = executeQuery($query);
  $result = $db->executeQuery($query);
  //2021.03.25 end
	//2021-03-25 start  $row = mysql_fetch_array($result);
  $row = $db->Next_Record($result);
	//2021.03.25 end

	//2021-03-25 start  if (mysql_num_rows($result)>0)
  if ($db->Row_Count($result)>0)


  //2021.03.25 end
	{


    $query1 = "SELECT * FROM crs_enroll  WHERE studentID='$studentID'";
    $result1 = $db->executeQuery($query1);
  //2021.03.25 end
	//2021-03-25 start  $row = mysql_fetch_array($result);
  $row1 = $db->Next_Record($result1);
	//2021.03.25 end

	//2021-03-25 start  if (mysql_num_rows($result)>0)
  if ($db->Row_Count($result1)>0)


  //2021.03.25 end
	{
$indexNo=$row['indexNo'];
$regNo=$row['regNo'];

  }
?>

<table class="searchResults">
	<tr>
    	<th colspan="2"><?php echo $row['nameEnglish']; ?></th>
    </tr>
    <tr>
    	<td>Applicant No. : </td><td> <?php echo $row['studentID']; ?></td>
    </tr>
    <tr>
    	<td>Registration No. : </td><td> <?php echo $row1['regNo']; ?></td>
    </tr>
    <tr>
    	<td>Index No. : </td><td> <?php echo $row1['indexNo']; ?></td>
    </tr>
    <tr>
    	<td>Title : </td><td> <?php echo $row['title'];  ?></td>
    </tr>
    <tr>
    	<td>Name (English) : </td><td> <?php echo $row['nameEnglish']; ?></td>
    </tr>
    <tr>
    	<td>Name (Sinhala) : </td><td> <?php echo $row['nameSinhala']; ?></td>
    </tr>
    <tr>
    	<td valign="top">Address (English): </td><td> <?php echo $row['addressE1']."<br/>".$row['addressE2']."<br/>".$row['addressE3']; ?></td>
    </tr>
    <tr>
    	<td valign="top">Address (Sinhala): </td><td> <?php echo $row['addressS1']."<br/>".$row['addressS2']."<br/>".$row['addressS3']; ?></td>
    </tr>
    <tr>
    	<td>District : </td><td> <?php echo $row['districtstate']; ?></td>
    </tr>
    <tr>
    	<td>Entry Type : </td><td> <?php echo $row['degree']; ?></td>
    </tr>
    <tr>
    	<td>Year of Entrance : </td><td> <?php echo $row['acyear']; ?></td>
    </tr>
    
    <tr>
    	<td>Degree Type : </td><td> <?php echo $row['degreeType']; ?></td>
    </tr>
	<tr>
    	<td>Meduim : </td><td> <?php echo $row['medium']; ?></td>
    </tr>
    <tr>
    	<td>NIC/Passport No. : </td><td> <?php echo $row['nic']; ?></td>
    </tr>
    <tr>
    	<td>Contact No. : </td><td> <?php echo $row['contactNo0']; ?></td>
    </tr>
    <tr>
    	<td>Email : </td><td> <?php echo $row['email']; ?></td>
    </tr>
    <tr>
    	<td>Birthday : </td><td> <?php echo $row['birthday']; ?></td>
    </tr>
    <tr>
    	<td>Citizenship : </td><td> <?php echo $row['citizenship']; ?></td>
    </tr>
    <tr>
    	<td>Nationality : </td><td> <?php echo $row['nationality']; ?></td>
    </tr>
    <tr>
    	<td>Religion : </td><td> <?php echo $row['religion'];  ?></td>
    </tr>
    <tr>
    	<td>Civil Status : </td><td> <?php echo $row['civilStatus']; ?></td>
    </tr>
    <tr>
    	<td>Guardian Name : </td><td> <?php echo $row['guardName']; ?></td>
    </tr>
    <tr>
    	<td>Guardian Address : </td><td> <?php echo $row['guardAddress']; ?></td>
    </tr>
    <tr>
    	<td>Guardian Contact No. : </td><td> <?php echo $row['guardContactNo']; ?></td>
    </tr>
    <tr>
    	<td>Scholarship : </td><td> <?php echo $row['Scholarship']; ?></td>
    </tr>
</table>
	<br/><p><input name="btnEdit" type="button" value="Edit"  class="button" onclick="document.location.href ='studentEdit.php?studentID=<?php echo $row['studentID'] ?>'"/></p>
      
<?php
          
   }

  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();

  ob_end_clean();
//exit();
  $pagetitle = "Student Details - Students - Student Management System - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>Student Details</li></ul>";
  //Apply the template
include("master_sms_external.php");
//  include("master_registration.php");
?>