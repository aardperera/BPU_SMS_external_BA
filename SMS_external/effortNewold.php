<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtAcYear))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}

function getGrade(marks)
{
	var grade;
	if (0<=marks && marks<=29) grade = 'E';
	else if (30<=marks && marks<=39) grade = 'D';
	else if (40<=marks && marks<=54) grade = 'C';
	else if (55<=marks && marks<=69) grade = 'B';
	else if (70<=marks && marks<=100) grade = 'A';
	else grade = '';
	document.getElementById('txtGrade').value = grade;
}
</script>

<h1>Exam Effort</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	if (isset($_POST['btnSubmit']))
	{
		$indexNo = $_POST['lstIndexNo'];
		$subjectID = $_POST['lstSubject'];
		$acYear = $db->cleanInput($_POST['txtAcYear']);
		$marks = $db->cleanInput($_POST['txtMarks']);
		$grade = $db->cleanInput($_POST['txtGrade']);
		$effort = $_POST['lstEffort'];
		
		$query = "INSERT INTO exameffort SET indexNo='$indexNo', subjectID='$subjectID', acYear='$acYear', marks='$marks', grade='$grade', effort='$effort'";
		$result = $db->executeQuery($query);
		
		header("location:examAdmin.php");
	}
?>
<form method="post" action="" onsubmit="return validate_form(this);" class="plain">
<table class="searchResults">
    <tr>
    	<td>Index Number : </td>
        <td><select name="lstIndexNo" id="lstIndexNo" style="width:auto" onchange="this.form.submit();" >
        	<?php
			$query = "SELECT indexNo,nameEnglish FROM student JOIN crs_enroll ON student.studentID=crs_enroll.studentID";
			$result = $db->executeQuery($query);
			for ($i=0;$i<$db->Row_Count($result);$i++)
			{
				$rIndexNo = mysql_result($result,$i,"indexNo");
				$rNameEnglish = mysql_result($result,$i,"nameEnglish");
				if (isset($_POST['lstIndexNo']) && $rIndexNo==$_POST['lstIndexNo'])
					echo "<option selected='selected' onmousedown=\"document.getElementById('txtName').value='(".$rNameEnglish.")'\" value=\"".$rIndexNo."\">".$rIndexNo."</option>";
				else
              		echo "<option onmousedown=\"document.getElementById('txtName').value='(".$rNameEnglish.")'\" value=\"".$rIndexNo."\">".$rIndexNo."</option>";
        	} 
			?>
        	</select>
            <input name="txtName" id="txtName" type="text" value="<?php if (isset($_POST['txtName'])) echo $_POST['txtName']; ?>" readonly="readonly" style="border:none;width:300px" />
        </td>
    </tr>
    <tr>
    	<td>Subject : </td>
        <td><select name="lstSubject" id="lstSubject" style="width:auto">
        	<?php
			if (isset($_POST['lstIndexNo'])) $indexNo = $_POST['lstIndexNo'];
			else $indexNo = mysql_result($result,0,"indexNo");
			$query = "SELECT * FROM subject WHERE subjectID IN (SELECT subjectID FROM sub_enroll WHERE indexNo='".$indexNo."')";
			$result = $db->executeQuery($query);
			for ($i=0;$i<$db->Row_Count($result);$i++)
			{
				$rID = mysql_result($result,$i,"subjectID");
				$rCode = mysql_result($result,$i,"codeEnglish");
				$rSubject = mysql_result($result,$i,"nameEnglish");
              	echo "<option value=\"".$rID."\">".$rCode." - ".$rSubject."</option>";
        	} 
			?>
        	</select>
        </td>
    </tr>
    <tr>
    	<td>Academic Year : </td><td><input name="txtAcYear" type="text" value="" /></td>
    </tr>
    <tr>
    	<td>Marks : </td><td><input name="txtMarks" type="text" value="" onkeyup="getGrade(this.value)" /></td>
    </tr>
    <tr>
    	<td>Grade : </td><td><input name="txtGrade" id="txtGrade" type="text" value="" /></td>
    </tr>
    <tr>
    	<td>Effort : </td><td><select name="lstEffort">
        	<option value="1">1</option>
        	<option value="2">2</option>
            <option value="3">3</option>
        </select></td>
    </tr>
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'examAdmin.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" /></p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "New Effort - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='examAdmin.php'>Exam Efforts </a></li><li>New Effort</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>