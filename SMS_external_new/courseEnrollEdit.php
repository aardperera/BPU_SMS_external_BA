<?php
  //Buffer larger content areas like the main page content
  ob_start();
    session_start();
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

<h1>Edit Course Enrollment</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	if (isset($_POST['btnSubmit']))
	{
	/*
	$subcrsquery = "SELECT subcrsID FROM crs_sub where description='".$_SESSION['subcourseType']."'";
	 $subcrsresult = $db->executeQuery($subcrsquery);
	$subcrsrow =  $db->Next_Record($subcrsresult);
	$valuesubcrsID	 = $subcrsrow['subcrsID'];
	*/
		$regNo = $db->cleanInput($_POST['txtRegNo']);
		$indexNo = $db->cleanInput($_POST['txtIndexNo']);
		$studentID = $_POST['txtStudentID'];
		$course = $_POST['lstCourse'];
		$courseCombID = $_POST['lstCourseComb'];
		$subcrsID = $_POST['lstCoursesub'];
		$yearEntry = $_POST['lstYearEntry'];
		
		$query = "UPDATE crs_enroll SET indexNo='$indexNo', studentID='$studentID', courseID='$course', yearEntry='$yearEntry' WHERE regNo='$regNo'";
		$result = $db->executeQuery($query);
		header("location:courseEnroll.php?studentID=$studentID");
	}
	
	$regNo = $db->cleanInput($_GET['regNo']);
	$query = "SELECT * FROM crs_enroll WHERE regNo='$regNo'";
	$result = $db->executeQuery($query);
	
	$row =  $db->Next_Record($result);
	if ($db->Row_Count($result)>0)
	{
?>
<form method="post" action="">
<table class="searchResults">
    <tr>
    	<td>Registration No. : </td><td width = 300><input name="txtRegNo" type="text" value="<?php echo $regNo; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
    	<td>Index No. : </td><td><input name="txtIndexNo" type="text" value="<?php echo $row['indexNo']; ?>" /></td>
    </tr>
    <tr>
    	<td>Student ID : </td><td><input name="txtStudentID" type="text" value="<?php echo $row['studentID']; ?>" readonly="readonly" /></td>
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
				if ($rCourseID==$row['courseID'])
					echo "<option value=\"".$rCourseID."\" selected='selected' >".$rCourseID." - ".$rName."</option>";
				else echo "<option value=\"".$rCourseID."\">".$rCourseID." - ".$rName."</option>";
        	} 
			?>
        	</select>
        </td>
    </tr>
	<tr>
    	<td>Sub Course : </td><td>
        	<select name="lstCoursesub" id="lstCoursesub" size="auto" onChange="this.form.submit()">
        	<?php
			if (isset($_SESSION['courseId']))
			{
				$query = "SELECT description, subcrsID FROM crs_sub WHERE  courseID='".$_SESSION['courseId']."' order by Description";
				$result = $db->executeQuery($query);
				for ($i=0;$i<mysql_numrows($result);$i++)
				{
					$subCourseID = mysql_result($result,$i,"subcrsID");
					$subName = mysql_result($result,$i,"description");
						if ($subcrsID ==$subCourseID){
					echo "<option selected value=\"".$subCourseID."\">".$subName."</option>";
					}
					else {
					echo "<option value=\"".$subCourseID."\">".$subName."</option>";}
				}
			} 
			
			?>
        	</select>
        </td>
    </tr>
	
	<!--<tr>
    	<td>Course Combination : </td><td>
        	<select name="lstCourseComb" id="lstCourseComb" size="auto" onChange="this.form.submit()">
        	<?php
			if (isset($_POST['lstCoursesub']))
			//print 'hhhhhhhhh';
			{
				$querynew = "SELECT Description, combinationID FROM course_combination WHERE   courseID='".$_SESSION['courseId']."' and subcrsID=".$_POST['lstCoursesub']." order by Description";
				//$querynew = "SELECT Description, combinationID FROM course_combination WHERE  CourseID = '9' and subcrsID='1' order by Description";
				$result = $db->executeQuery($querynew);
				for ($i=0;$i<mysql_numrows($result);$i++)
				{
					$rCourseID = mysql_result($result,$i,"combinationID");
					$rName = mysql_result($result,$i,"Description");
					echo "<option value=\"".$rCourseID."\">".$rName."</option>";
				}
			} 
			?>
        	</select> 
        </td>
    </tr> -->
	
    <tr>
    	<td>Entry Year : </td><td><select name="lstYearEntry">
        	<?php
				for ($i=2010;$i<=2100;$i++)
				{
					if ($i==$row['yearEntry'])
						echo "<option selected='selected' value='$i'>$i</option>";
					else echo "<option value='$i'>$i</option>";
				}
			?>
        </select></td>
    </tr>
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'courseEnroll.php?studentID=<?php echo $row['studentID']; ?>';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;"/></p>
</form>

<?php
  }	
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "Edit Course Enrollment - Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li><a href='courseEnroll.php?studentID=".$row['studentID']."'>Course Enrollments </a></li><li>Edit Course Enrollment</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>