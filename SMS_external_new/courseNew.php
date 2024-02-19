<?php
  //Buffer larger content areas
  ob_start();
?>

<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtCourseCode) || !validate_required(txtNameEnglish) || !validate_required(txtNameSinhala))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
</script>

<h1>New Course</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	if (isset($_POST['btnSubmit']))
	{
		$courseID = $db->cleanInput($_POST['txtCourseID']);
		$courseCode = $db->cleanInput($_POST['txtCourseCode']);
		$nameEngslih = $db->cleanInput($_POST['txtNameEnglish']);
		$nameSinhala = $db->cleanInput($_POST['txtNameSinhala']);
		$courseType = $_POST['lstCourseType'];
		
		$query = "INSERT INTO course SET courseID='$courseID',courseCode='$courseCode', nameEnglish='$nameEngslih', nameSinhala='$nameSinhala', courseType='$courseType'";
		$result = $db->executeQuery($query);
		header("location:courseAdmin.php");
	}
?>
<form method="post" action="" onsubmit="return validate_form(this);" class="plain">
<table class="searchResults">
    
<tr>
    	<td>Course Code : </td><td><input name="txtCourseCode" type="text" value="" /></td>
    </tr>
    <tr>
    	<td>Name (English) : </td><td><input name="txtNameEnglish" type="text" value="" style="width:300px"/></td>
    </tr>
    <tr>
    	<td>Name (Sinhala) : </td><td><input name="txtNameSinhala" type="text" value="" style="width:300px"/></td>
    </tr>
    <tr>
    	<td>Course Type : </td><td><select name="lstCourseType">
        	<option value="Diploma">Diploma</option>
        	<option value="Bachelor">Bachelor Degree</option>
            <option value="PG Diploma">Postgraduate Diploma</option>
            <option value="Master">Master Degree</option>
            <option value="MPhil">M.Phil Degree</option>
            <option value="PhD">Ph.D. Degree</option>
        </select></td>
    </tr>
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'courseAdmin.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" /></p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "New Course - Courses - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='courseAdmin.php'>Courses </a></li><li>New Course</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>