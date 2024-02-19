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

function getAverage()
{
	
	var average;
	
mark1 = document.examEffort.txtMarks1.value;
mark2 = document.examEffort.txtMarks2.value;
mark1=eval(mark1);
mark2=eval(mark2);
	average=((mark1+mark2)/2);
	document.getElementById('txtMarks').value=average;
	marks=average;
	if (0<=marks && marks<=24) {grade = 'E'; gradePoint='0.0';}
	else if (25<=marks && marks<=29) {grade = 'D'; gradePoint='1.0';}
	else if (30<=marks && marks<=34) {grade = 'D+'; gradePoint='1.3';}
	else if (35<=marks && marks<=39) {grade = 'C-'; gradePoint='1.7';}
	else if (40<=marks && marks<=44) {grade = 'C'; gradePoint='2.0';}
	else if (45<=marks && marks<=49) {grade = 'C+'; gradePoint='2.3';}
	else if (50<=marks && marks<=54) {grade = 'B-'; gradePoint='2.7';}
	else if (55<=marks && marks<=59) {grade = 'B'; gradePoint='3.0';}
	else if (60<=marks && marks<=64) {grade = 'B+'; gradePoint='3.3';}
	else if (65<=marks && marks<=69) {grade = 'A-'; gradePoint='3.7';}
	else if (70<=marks && marks<=84) {grade = 'A'; gradePoint='4.0';}
	else if (85<=marks && marks<=100) {grade = 'A+'; gradePoint='4.0';}
	else grade = '';
	document.getElementById('txtGrade').value = grade;
	document.getElementById('txtGradePoint').value = gradePoint;
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
		$marks1 = $db->cleanInput($_POST['txtMarks1']);
		$marks2 = $db->cleanInput($_POST['txtMarks2']);
		$marks = $db->cleanInput($_POST['txtMarks']);
		$grade = $db->cleanInput($_POST['txtGrade']);
		$gradePoint = $db->cleanInput($_POST['txtGradePoint']);
		$effort = $_POST['lstEffort'];
		
		$query = "INSERT INTO exameffort SET indexNo='$indexNo', subjectID='$subjectID', acYear='$acYear', mark1='$marks1',mark2='$marks2',marks='$marks',grade='$grade',gradePoint='$gradePoint', effort='$effort'";
		$result = $db->executeQuery($query);
		
		header("location:examAdmin.php");
	}
?>
<form method="post" name="examEffort" action="" onsubmit="return validate_form(this);" class="plain">
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
			
			$query2 = "select * from crs_enroll where indexNo='$indexNo'";
			
			$result2 = $db->executeQuery($query2);
			$Enroll_id = mysql_result($result2,0,"Enroll_id");
			
			$query = "SELECT * FROM subject WHERE subjectID IN (SELECT subjectID FROM  subject_enroll WHERE Enroll_id='".$Enroll_id."')";
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
    	<td>Academic Year :  </td><td><input name="txtAcYear" type="text" value="" /></td>
    </tr>
    <tr>
    	<td>First Mark : </td><td><input name="txtMarks1" id="txtMarks1"  type="text"  /></td>
    </tr>
	<tr>
    	<td>Second Mark : </td><td><input name="txtMarks2" id="txtMarks2" type="text" value=""    onKeyUp="getAverage()" /></td>
    </tr>
    <tr>
    	<td>Marks : </td><td><input name="txtMarks" id="txtMarks" type="text" value=""  readonly="readonly" /></td>
    </tr>
    <tr>
    	<td>Grade : </td><td><input name="txtGrade" id="txtGrade" type="text" value="" /></td>
    </tr>
    <tr>
    <tr>
    	<td>Grade Point : </td><td><input name="txtGradePoint" id="txtGradePoint" type="text" value="" /></td>
    </tr>
    	<td>Effort : </td><td><select name="lstEffort">
        	<option value="1">1</option>
        	<option value="2">2</option>
            <option value="3">3</option>
			<option value="4">4</option>
        	<option value="5">5</option>
            <option value="6">6</option>
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