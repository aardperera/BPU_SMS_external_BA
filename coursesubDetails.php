<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<h1>Course Sub Details</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	$id = $db->cleanInput($_GET['id']);
	$query = "SELECT * FROM crs_sub WHERE id='$id'";
	$result = $db->executeQuery($query);
	$row =  $db->Next_Record($result);

	
	$query2 = "SELECT courseCode FROM course  WHERE courseID='$row[1]'";
	$result2 = $db->executeQuery($query2);
	$row2 =  $db->Next_Record($result2);
	
	if ($db->Row_Count($result)>0)
	{
	
?>
<table class="searchResults">
  <tr> 
    <td>ID : </td>
    <td width="300"> <?php echo $row['id']; ?></td>
  </tr>
  <tr>
    <td>Course Code :</td>
    <td><?php echo $row2['courseCode']; ?></td>
  </tr>
  <tr> 
    <td>Sub Course ID : </td>
    <td> <?php echo $row['subcrsID']; ?></td>
  </tr>
  
  <tr> 
    <td>Description : </td>
    <td> <?php echo $row['description']; ?></td>
  </tr>
  
  
</table>
<br/>
<p>
  <input name="btnEdit" type="button" value="Edit"  class="button" onclick="document.location.href ='coursesubEdit.php?id=<?php echo $row['id'] ?>'" style="width:60px;"/>&nbsp;&nbsp;&nbsp;<input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'coursesubAdmin.php';" style="width:60px;" class="button"/>
</p>
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