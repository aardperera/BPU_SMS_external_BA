<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
  
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
?>

<script language="javascript" src="lib/scw/scw.js"></script>
<script>

</script>

<h1>Sub Course Details</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	if (isset($_POST['CourseID']))
	{$courseID=$_POST['CourseID'];}
	
	
	if (isset($_POST['btnSubmit']))
	{
	$id = $db->cleanInput($_GET['combinationID']);
	
	    
		$courseby = $_POST['Courseby'];
		
		
		
		
		$description = $db->cleanInput($_POST['Description']);
		
		
		
		$query = "UPDATE crs_sub SET  description='$description',course_by='$courseby' where id='$id'";
		$result = $db->executeQuery($query);
		header("location:coursesubAdmin.php");
	}
	
	
	
	$id = $db->cleanInput($_GET['combinationID']);
	$query = "SELECT * FROM crs_sub WHERE id='$id'";
	$result = $db->executeQuery($query);
	
	$row =  $db->Next_Record($result);
	if ($db->Row_Count($result)>0)
	{
	}
?>
<form method="post" name="form1" id="form1" action="" onSubmit="return validate_form(this);" class="plain">
  <table class="searchResults">
    
    	<tr>
    	<td>Course Code : </td><td><input name="txtCourseID" type="text" value="<?php echo $row['courseID'] ?>" readonly="readonly" /></td>
    </tr>
	<tr>
    	<td>Description : </td><td><input name="Description" type="text" value="<?php echo $row['description'] ?>" /></td>
   
     <tr>
    	<td>Course By  : </td><td><select name="Courseby">
        	<option <?php if ($row['course_by']=='E') echo "selected='selected'"; ?> value="E">Exam</option>
        	<option <?php if ($row['course_by']=='R') echo "selected='selected'"; ?> value="R">Reserch</option>
            
        </select></td>
    </tr>
  </table>
  
  
  
  
  
  
  
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onClick="document.location.href = 'subcourse.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" /></p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "New Student - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='coursecombination2.php'>Students </a></li><li>New Student</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>