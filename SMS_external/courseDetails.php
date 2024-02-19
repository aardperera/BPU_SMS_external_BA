<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<h1>Course Details</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	$courseID = $db->cleanInput($_GET['courseID']);
	$query = "SELECT * FROM course WHERE courseID='$courseID'";
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
    	<td>Course ID : </td><td> <?php echo $row['courseID']; ?></td>
    </tr>
<tr>
    	<td>Course Code : </td><td> <?php echo $row['courseCode']; ?></td>
    </tr>
    <tr>
    	<td width = 150>Name (English) : </td><td width = 500> <?php echo $row['nameEnglish']; ?></td>
    </tr>
    <tr>
    	<td>Name (Sinhala) : </td><td> <?php echo $row['nameSinhala']; ?></td>
    </tr>
    <tr>
    	<td>Course Type : </td><td> <?php echo $row['courseType']; ?> Studies</td>
    </tr>
</table>
	<br/><p><input name="btnEdit" type="button" value="Edit"  class="button" onclick="document.location.href ='courseEdit.php?courseID=<?php echo $row['courseID'] ?>'" style="width:60px;"/></p>
      
<?php
   }
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Course Details - Courses - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='courseAdmin.php'>Courses </a></li><li>Course Details</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>