<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<h1>Student Details</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	$studentID = $db->cleanInput($_GET['studentID']);
	$query = "SELECT * FROM student WHERE studentID='$studentID'";
	$result = $db->executeQuery($query);
	$row =  $db->Next_Record($result);
	
	if ($db->Row_Count($result)>0)
	{
?>

<table class="searchResults">
  <tr> 
    <th colspan="2"><?php echo $row['nameEnglish']; ?></th>
  </tr>
  <tr> 
    <td>StudentID : </td>
    <td> <?php echo $row['studentID']; ?></td>
  </tr>
  <tr>
    <td>NIC No. :</td>
    <td><?php echo $row['nic']; ?></td>
  </tr>
  <tr> 
    <td>Title : </td>
    <td width = 300> <?php echo $row['title']; ?></td>
  </tr>
  <tr> 
    <td>Name (English) : </td>
    <td> <?php echo $row['nameEnglish']; ?></td>
  </tr>
  <tr> 
    <td>Name (Sinhala) : </td>
    <td> <?php echo $row['nameSinhala']; ?></td>
  </tr>
  <tr> 
    <td valign="top">Address (English): </td>
    <td> <?php echo $row['addressE1']."<br/>".$row['addressE2']."<br/>".$row['addressE3']; ?></td>
  </tr>
  <tr> 
    <td valign="top">Address (Sinhala): </td>
    <td> <?php echo $row['addressS1']."<br/>".$row['addressS2']."<br/>".$row['addressS3']; ?></td>
  </tr>
  <tr> 
    <td>Contact No. : </td>
    <td> <?php echo $row['contactNo']; ?></td>
  </tr>
  <tr> 
    <td>Email : </td>
    <td> <?php echo $row['email']; ?></td>
  </tr>
  <tr> 
    <td>Birthday : </td>
    <td> <?php echo $row['birthday']; ?></td>
  </tr>
  <tr> 
    <td>Citizenship : </td>
    <td> <?php echo $row['citizenship']; ?></td>
  </tr>
  <tr> 
    <td>Nationality : </td>
    <td> <?php echo $row['nationality']; ?></td>
  </tr>
  <tr> 
    <td>Religion : </td>
    <td> <?php echo $row['religion']; ?></td>
  </tr>
  <tr> 
    <td>Civil Status : </td>
    <td> <?php echo $row['civilStatus']; ?></td>
  </tr>
  <tr> 
    <td>Employment : </td>
    <td> <?php echo $row['employment']; ?></td>
  </tr>
  <tr> 
    <td>Employer : </td>
    <td> <?php echo $row['employer']; ?></td>
  </tr>
  <tr> 
    <td>Guardian Name : </td>
    <td> <?php echo $row['guardName']; ?></td>
  </tr>
  <tr> 
    <td>Guardian Address : </td>
    <td> <?php echo $row['guardAddress']; ?></td>
  </tr>
  <tr> 
    <td>Guardian Contact No. : </td>
    <td> <?php echo $row['guardContactNo']; ?></td>
  </tr>
</table>
	<br/><p><input name="btnEdit" type="button" value="Edit"  class="button" onclick="document.location.href ='studentEdit.php?studentID=<?php echo $row['studentID'] ?>'" style="width:60px;"/></p>
      
<?php
   }
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Student Details - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>Student Details</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>