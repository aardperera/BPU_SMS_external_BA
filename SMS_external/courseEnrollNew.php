<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtRegNo))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
</script>

<h1>New Course Enrollment</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	$studentID = $db->cleanInput($_GET['studentID']);
?>
<form method="post" action="" class="plain">
<?php 
	if (isset($_POST['btnSubmit']))
	{
		$regNo = $db->cleanInput($_POST['txtRegNo']);
		$indexNo = $db->cleanInput($_POST['txtIndexNo']);
		$studentID = $_POST['txtStudentID'];
		$course = $_POST['lstCourse'];
		$yearEntry = $_POST['lstYearEntry'];
		
		$query = "INSERT INTO crs_enroll SET regNo='$regNo', indexNo='$indexNo', studentID='$studentID', courseID='$course', yearEntry='$yearEntry'";
		$result = $db->executeQuery($query);
		header("location:courseEnroll.php?studentID=$studentID");
	}

?>
<table class="searchResults">
    <tr>
    	<td>Registration No. : </td><td width = 300><input name="txtRegNo" type="text" value="" /></td>
    </tr>
    <tr>
    	<td>Index No. : </td><td><input name="txtIndexNo" type="text" value="" /></td>
    </tr>
    <tr>
    	<td>Student ID : </td><td><input name="txtStudentID" type="text" value="<?php echo $studentID; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
    	<td>Course : </td><td>
        	<select name="lstCourse" id="lstCourse" size="auto">
        	<?php
			$query = "SELECT courseID,nameEnglish FROM course order by nameEnglish";
			$result = $db->executeQuery($query);
			for ($i=0;$i<mysql_numrows($result);$i++)
			{
				$rCourseID = mysql_result($result,$i,"courseID");
				$rName = mysql_result($result,$i,"nameEnglish");
              	echo "<option value=\"".$rCourseID."\">".$rCourseID." - ".$rName."</option>";
        	} 
			?>
        	</select>
        </td>
    </tr>
    <tr>
    	<td>Entry Year : </td><td><select name="lstYearEntry">
        	<?php
				for ($i=2010;$i<=2100;$i++)
				{
					echo "<option value='$i'>$i</option>";
				}
			?>
        </select></td>
    </tr>
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'courseEnroll.php?studentID=<?php echo $studentID; ?>';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
    <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;"/>
  </p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "New Course Enrollment - Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li><a href='courseEnroll.php?studentID=$studentID'>Course Enrollments </a></li><li>New Course Enrollment</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>