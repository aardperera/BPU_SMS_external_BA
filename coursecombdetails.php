<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<h1>Course Combination Details</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	$combinationID = $db->cleanInput($_GET['combinationID']);
	
	
	
	
	$query = "SELECT * FROM course_combination WHERE combinationID='$combinationID'";
	$result = $db->executeQuery($query);
	$row =  $db->Next_Record($result);

	if ($db->Row_Count($result)>0)
	{
	
?>
<table class="searchResults">
  <tr> 
    <td>CourseID : </td>
    <td width="300"> <?php echo $row['CourseID']; ?></td>
  </tr>
  <tr>
    <td>combinationID :</td>
    <td><?php echo $row['combinationID']; ?></td>
  </tr>
  <tr> 
    <td>subjectID : </td>
    <td> <?php echo $row['subjectID']; ?></td>
  </tr>
  
  <tr> 
    <td>Description : </td>
    <td> <?php echo $row['Description']; ?></td>
  </tr>
  
  <tr> 
    <td>compulsary: </td>
    <td> <?php echo $row['compulsary']; ?></td>
  </tr>
</table>
<br/>
<p>
  <input name="btnEdit" type="button" value="Edit"  class="button" onclick="document.location.href ='coursecombedit.php?combinationID=<?php echo $row['combinationID'] ?>'" style="width:60px;"/>
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