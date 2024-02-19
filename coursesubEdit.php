<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>


<h1> Sub Course Edit</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();

	if (isset($_POST['btnSubmit']))
	{
		$id = $db->cleanInput($_POST['txtid']);

		$courseID = $db->cleanInput($_POST['txtCourseCode']);
		$subcrsID = $db->cleanInput($_POST['txtsubcrsID']);
		$description = $db->cleanInput($_POST['txtdescription']);
		
		
		$query = "UPDATE crs_sub SET  description='$description' WHERE id='$id'";
		$result = $db->executeQuery($query);
		header("location:coursesubAdmin.php");
	}
	
	$id = $db->cleanInput($_GET['id']);
	$query = "SELECT * FROM crs_sub  WHERE id='$id'";
	$result = $db->executeQuery($query);
	
	$row =  $db->Next_Record($result);
	
	$query2 = "SELECT courseCode FROM course  WHERE courseID='$row[1]'";
	$result2 = $db->executeQuery($query2);
	$row2 =  $db->Next_Record($result2);
	
	if ($db->Row_Count($result)>0)
	{
?>
<form method="post" action="coursesubEdit.php?id=<?php echo $id ?>" class="plain">
<table class="searchResults">
	<tr>
    	<td>ID : </td><td><input name="txtid" type="text" value="<?php echo $row['id'] ?>" readonly="readonly" /></td>
    </tr>
	<tr>
    	<td>Course Code : </td><td><input name="txtCourseCode" type="text" value="<?php echo $row2[0] ?>"  readonly="readonly" /></td>
    </tr>
	
    <tr>
    	<td>subcrsID : </td><td><input name="txtsubcrsID" type="text" value="<?php echo $row[2] ?>" readonly="readonly" style="width:300px"/></td>
    </tr>
    <tr>
    	<td>description : </td><td><input name="txtdescription" type="text" value="<?php echo $row['description'] ?>" style="width:300px"/></td>
    </tr>
    
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'coursesubAdmin.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" /></p>
</form>

<?php
   }
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
 $pagetitle = "Edit Course - Courses - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='courseAdmin.php'>Courses </a></li><li>Edit Course</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>