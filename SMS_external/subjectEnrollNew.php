<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtIndexNo))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
</script>

<h1>New Subject Enrollment</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	if (isset($_POST['btnSubmit']))
	{
		$indexNo = $_POST['txtIndexNo'];
		$subject = $_POST['lstSubject'];
		$medium = $_POST['lstMedium'];
		$acYear = $_POST['lstAcYear'];
		$studentID = $_GET['studentID'];
		
		$query = "INSERT INTO sub_enroll SET indexNo='$indexNo', subjectID='$subject', medium='$medium', acYear='$acYear'";
		$result = $db->executeQuery($query);
		header("location:subjectEnroll.php?indexNo=$indexNo&studentID=$studentID");
	}
	
	$indexNo = $db->cleanInput($_GET['indexNo']);
	$studentID = $_GET['studentID'];
?>
<form method="post" action="subjectEnrollNew.php?indexNo=<?php echo $indexNo; ?>&studentID=<?php echo $studentID; ?>" onsubmit="return validate_form(this);" class="plain">
<table class="searchResults">
    <tr>
    	<td>Index No. : </td><td width=200><input name="txtIndexNo" type="text" value="<?php echo $indexNo; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
    	<td>Subject : </td><td>
        	<select name="lstSubject" id="lstSubject" size="auto">
        	<?php
			$query = "SELECT subjectID,codeEnglish,nameEnglish FROM subject";
			$result = $db->executeQuery($query);
			for ($i=0;$i<mysql_numrows($result);$i++)
			{
				$rSubjectID = mysql_result($result,$i,"subjectID");
				$rCode = mysql_result($result,$i,"codeEnglish");
				$rName = mysql_result($result,$i,"nameEnglish");
              	echo "<option value=\"".$rSubjectID."\">".$rCode." - ".$rName."</option>";
        	} 
			?>
        	</select>
        </td>
    </tr>
    <tr>
    	<td>Medium : </td><td><select name="lstMedium">
        	<option value="English">English</option>
            <option value="Sinhala">Sinhala</option>
        </select></td>
    </tr>
    <tr>
    	<td>Academic Year : </td><td><select name="lstAcYear">
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
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'subjectEnroll.php?indexNo=<?php echo $indexNo; ?>&studentID=<?php echo $studentID; ?>';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" /></p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "New Subject Enrollment - Subject Enrollments - Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li><a href='courseEnroll.php?studentID=$studentID'>Course Enrollments </a></li><li><a href='subjectEnroll.php?indexNo=".$indexNo."&studentID=".$studentID."'>Subject Enrollments </a></li><li>New Subject Enrollment</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>