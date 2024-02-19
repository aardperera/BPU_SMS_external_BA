<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<h1>Student Details</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	$studentID = $db->cleanInput($_GET['studentID']);
	//$query = "SELECT * FROM student a,stu_qualification b WHERE a.studentID='$studentID'";
	$query = "SELECT * FROM `student` a,`stu_qualification`b WHERE a.studentID='$studentID' AND a.`studentID`= b.`studentID` ";
	//$query = "SELECT a.studentID,a.`nic`, a.`title`, a.`nameEnglish`, a.`nameSinhala`,a. `addressE1`, a.`addressE2`,a. `addressE3`, a.`addressS1`, a.`addressS2`, a.`addressS3`, a.`contactNo`,a. `email`, a.`birthday`, a.`citizenship`,a.`civilStatus`, a.`employment`, a.`employer`, a.`courseID`, b.`OL`, b.`AL`, b.Diploma, b.`HigherDiploma`, b.`FirsDegree`, b.`Post_OneYear`, b.`Post_TwoYears`, b.`Others` FROM student a ,stu_qualification b WHERE a.studentID='$studentID'";
	$result = $db->executeQuery($query);
	$row =  $db->Next_Record($result);
	
	if ($db->Row_Count($result)>0)
	{
//print_r($row);

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
 
      <td>Qualification : </td>
      <td>
	  <table border="0">

		<tr>
		<td>1.</td><td>O/L</td>  <td>  <?php echo $row['OL']; ?></td>
		</tr>
		<tr>
		<td>2.</td><td>A/L</td> <td>  <?php echo $row['OL']; ?> </td>
		</tr>
		<tr>
		<td>3.</td><td>Diploma</td> <td><?php echo $row['Diploma']; ?> </td>
		</tr>
		<tr>
		<td>4.</td><td>Higher Diploma</td> <td><?php echo $row['HigherDiploma']; ?> </td>
		</tr>
		<tr>
		<td>5.</td><td>First Degree</td> <td><?php echo $row['FirsDegree']; ?> </td>
		</tr>
		<tr>
		<td>6.</td><td>Postgraduate</td> <td></td>
		</tr>
		<tr>
		<td> </td><td>One Year </td> <td><?php echo $row['Post_OneYear']; ?></td>
		</tr>
		<tr>
		<td> </td><td>Two Years</td> <td><?php echo $row['Post_TwoYears']; ?></td>
		</tr>
		<tr>
		<td>7.</td>
		<td>Others : </td><td><?php echo $row['Others']; ?></td>
		</tr>
		</td>
 </table>
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