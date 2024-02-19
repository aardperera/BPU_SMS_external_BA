<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<h1>Payment Details</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	$PaymentID = $db->cleanInput($_GET['PaymentID']);
	$query = "SELECT * FROM `course_payment` WHERE PaymentID='$PaymentID' ";
	$result = $db->executeQuery($query);
	$row =  $db->Next_Record($result);
	
	if ($db->Row_Count($result)>0)
	{


?>
<table class="searchResults">
  <tr> 
    <td>Payment ID : </td>
    <td> <?php echo $row['PaymentID']; ?></td>
  </tr>
  <tr>
    <td>Course :</td>
    <td><?php echo $row['courseID']; ?></td>
  </tr>
  <tr> 
    <td>Sub Course : </td>
    <td width = 300> <?php echo $row['subcrsID']; ?></td>
  </tr>
  <tr> 
    <td>Payment Type : </td>
    <td> <?php echo $row['PaymentType']; ?></td>
  </tr>
  <tr> 
    <td>Description : </td>
    <td> <?php echo $row['Description']; ?></td>
  </tr>
  <tr> 
    <td valign="top">Amount: </td>
    <td> <?php echo $row['Amount']; ?></td>
  </tr>
  <tr> 
    <td valign="top">Start Date: </td>
    <td> <?php echo $row['StartDate']; ?></td>
  </tr>
   <tr> 
    <td valign="top">End Date: </td>
    <td> <?php echo $row['EndDate']; ?></td>
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