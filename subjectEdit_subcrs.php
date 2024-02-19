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
		if (!validate_required(txtCodeEnglish) || !validate_required(txtNameEnglish))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
</script>

<h1>Subject Edit</h1>
<?php

 print $_SESSION['courseID'] ;
	include('dbAccess.php');

$db = new DBOperations();
 // 	include('authcheck.inc.php');

	if (isset($_POST['btnSubmit']))
	{
	
	    
		$subjectID = $db->cleanInput($_GET['subjectID']);
		$courseID = $db->cleanInput($_POST['courseID']);
		// $compulsary = $_POST['compulsary'];
		$codeEnglish = $db->cleanInput($_POST['txtCodeEnglish']);
		$nameEngslih = $db->cleanInput($_POST['txtNameEnglish']);
		$codeSinhala = $db->cleanInput($_POST['txtCodeSinhala']);
		$nameSinhala = $db->cleanInput($_POST['txtNameSinhala']);
		$faculty = $_POST['lstFaculty'];
		$semester = $_POST['txtSemester'];
		$level = $db->cleanInput($_POST['txtLevel']);
		//$semester = $db->cleanInput($_POST['txtSemester']);
		$chours = $db->cleanInput($_POST['txtchours']);
		$subcrsID = $_POST['subcrsID'];
		
		$query = "UPDATE subject SET courseID='$courseID',subcrsID='$subcrsID',codeEnglish='$codeEnglish', nameEnglish='$nameEngslih', codeSinhala='$codeSinhala', nameSinhala='$nameSinhala', faculty='$faculty', level='$level', semester='$semester', creditHours='$chours' WHERE subjectID='$subjectID'";
		$result = $db->executeQuery($query);
		header("location:subjectAdmin.php");
	}
	
	$subjectID = $db->cleanInput($_GET['subjectID']);
	$query = "SELECT * FROM subject WHERE subjectID='$subjectID'";
	$result = $db->executeQuery($query);
	
	$row =  $db->Next_Record($result);
	if ($db->Row_Count($result)>0)
	{
?>
<form method="post" action="subjectEdit.php?subjectID=<?php echo $subjectID ?>" onsubmit="return validate_form(this);" class="plain">
<table class="searchResults">
	<tr>
	  <td>CourseID:</td>
	  <td><label>
	  <input name="courseID" type="text" value="<?php echo $row['courseID'] ?>" />
	  </label></td>
    </tr>
	<!--<tr>
	  <td>Compulsary:</td>
	  <td><select name="compulsary">
        <option <?php if ($row['Compulsary']=='Yes') echo "selected='selected'"; ?> value="Yes">Yes</option>
        <option <?php if ($row['Compulsary']=='No') echo "selected='selected'"; ?> value="No">No</option>
      </select></td>
    </tr>-->
	<tr>
    	<td>Code (English) : </td><td><input name="txtCodeEnglish" type="text" value="<?php echo $row['codeEnglish'] ?>" /></td>
    </tr>
    <tr>
    	<td>Name (English) : </td><td><input name="txtNameEnglish" type="text" value="<?php echo $row['nameEnglish'] ?>" style="width:300px"/></td>
    </tr>
    <tr>
    	<td>Code (Sinhala) : </td><td><input name="txtCodeSinhala" type="text" value="<?php echo $row['codeSinhala'] ?>" /></td>
    </tr>
    <tr>
    	<td>Name (Sinhala) : </td><td><input name="txtNameSinhala" type="text" value="<?php echo $row['nameSinhala'] ?>" style="width:300px"/></td>
    </tr>
    <tr>
    	<td>Faculty : </td><td><select name="lstFaculty">
        	<option <?php if ($row['faculty']=='Buddhist') echo "selected='selected'"; ?> value="Buddhist">Buddhist Studies</option>
        	<option <?php if ($row['faculty']=='Language') echo "selected='selected'"; ?> value="Language">Language Studies</option>
			<option <?php if ($row['faculty']=='Other') echo "selected='selected'"; ?> value="Other">Other Studies</option>	
        </select></td>
    </tr>
	
    <!--<tr>
    	<td>Level : </td><td><input name="txtLevel" type="text" value="<?php echo $row['level'] ?>" /></td>
    </tr>-->
	
	
		
		 <tr>
    	<td>Semester : </td><td><select name="txtSemester">
        	<option <?php if ($row['Semester']=='Frist Semester') echo "selected='selected'"; ?> value="Frist Semester">First Semester</option>
        	<option <?php if ($row['Semester']=='Second Semester') echo "selected='selected'"; ?> value="Second Semester">Second Semester</option>
			<option <?php if ($row['Semester']=='Other') echo "selected='selected'"; ?> value="Other">Other Studies</option>	
        </select></td>
    </tr>
	
	
	<!--<tr>
    	<td>Semester : </td><td><input name="txtSemester" type="text" value="<?php echo $row['semester'] ?>" /></td>
    </tr>-->
	<tr>
    	<td>Credit Hours : </td><td><input name="txtchours" type="text" value="<?php echo $row['creditHours'] ?>" /></td>
    </tr>
  <tr>
      <td>Sub Course ID: </td>
      <td>
     	  <?php
	
		  
//	$val=$subID;
								echo '<select name="subcrsID" id="subcrsID"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
								$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
								
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								
								while ($row1 =  $db->Next_Record($result)){
								if($row1['id']==$row['id']){
									echo '<option value="'.$row['id'].'" selected="selected" >'.$row1['description'].'</option>'; }
									else {
									echo '<option value="'.$row['id'].'">'.$row1['description'].'</option>';
									//echo '<option value="'.$row['id'].'" selected="selected" >'.tttt.'</option>';
									}
								}
								echo '</select>';// Close drop down box
							?>
							
							 <script>
								document.getElementById('subcrsID').value = "<?php echo $subcrsID;?>";
							</script>
		</td>
        
    </tr>
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'subjectAdmin.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;"/></p>
</form>

<?php
   }
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
 $pagetitle = "Edit Subject - Subjects - Student Management System - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='subjectAdmin.php'>Subjects </a></li><li>Edit Subject</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>