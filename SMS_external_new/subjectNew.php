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

<h1>New Subject</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
 // 	include('authcheck.inc.php');
 
 
 if (isset($_POST['courseID']))
	{$courseID=$_POST['courseID'];}
 
	
	if (isset($_POST['btnSubmit']))
	{
	    $courseID   = $_POST['course'];
		$compulsary  = $_POST['compulsarysub'];
		$subcrsID  = $_POST['subcrsID'];
		
		$codeEnglish = $db->cleanInput($_POST['txtCodeEnglish']);
		$nameEngslih = $db->cleanInput($_POST['txtNameEnglish']);
		$codeSinhala = $db->cleanInput($_POST['txtCodeSinhala']);
		$nameSinhala = $db->cleanInput($_POST['txtNameSinhala']);
		$faculty = $_POST['lstFaculty'];
		$semester = $_POST['subSemester'];
		$level = $db->cleanInput($_POST['txtLevel']);
		$chours = $db->cleanInput($_POST['txtChours']);
		$description = $db->cleanInput($_POST['txtDescription']);
		
		$query = "INSERT INTO subject SET courseID='$courseID ',subcrsID='$subcrsID', Compulsary='$compulsary', codeEnglish='$codeEnglish', nameEnglish='$nameEngslih', codeSinhala='$codeSinhala', nameSinhala='$nameSinhala', faculty='$faculty', level='$level',semester='$semester',creditHours='$chours'";
		$result = $db->executeQuery($query);
		header("location:subjectAdmin.php");
		//header("location:message.php?message=Successfully inserted!");
			print $_SESSION['courseID'] ;
	
	}
?>
<form method="post" action="" onsubmit="return validate_form(this);" class="plain">
<table class="searchResults">
    <tr>
      <td>CourseID</td>
      <td>
        	    <select id="course" name="course" onchange="document.form1.submit()" >
      <option value="">---</option>
          <?php
			$query = "SELECT courseID,courseCode FROM course WHERE `courseID` ='".$_SESSION['courseId']."'";
			//SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
			$result = $db->executeQuery($query);
			while ($data= $db->Next_Record($result)) 
			{
			echo '<option value="'.$data[0].'">'.$data[1].'</option>';
        	} 
			?>
        </select>
               
        </td>
    </tr>
   <!-- <tr>
      <td>Compulsary</td>
      <td><select name="compulsarysub">
        	<option value="Yes">Yes</option>
        	<option value="No">No</option>
			
        </select></td>
    </tr> -->
    <tr>
    	<td>Code (English) : </td><td><input name="txtCodeEnglish" type="text" value="" /></td>
    </tr>
    <tr>
    	<td>Name (English) : </td><td><input name="txtNameEnglish" type="text" value="" style="width:300px"/></td>
    </tr>
    <tr>
    	<td>Code (Sinhala) : </td><td><input name="txtCodeSinhala" type="text" value="" /></td>
    </tr>
    <tr>
    	<td>Name (Sinhala) : </td><td><input name="txtNameSinhala" type="text" value="" style="width:300px"/></td>
    </tr>
    <tr>
    	
      <td height="28">Faculty : </td>
      <td><select name="lstFaculty">
        <option value="Buddhist">Buddhist Studies</option>
        <option value="Language">Language Studies</option>
        <option value="Other">Other</option>
      </select></td>
    </tr>
   
	<tr>
      <td>Sub Course ID: </td>
      <td>
     	  <?php
	 
								echo '<select name="subcrsID" id="subcrsID"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
								$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								
								while ($row =  $db->Next_Record($result)){
									echo '<option value="'.$row['subcrsID'].'">'.$row['description'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
							
							 <script>
								document.getElementById('subcrsID').value = "<?php echo $subcrsID;?>";
							</script>
		</td>
        
    </tr>
	<tr>
    	
      <td>Semester : </td>
      <td><select name="subSemester">
        	<option value="Frist Semester">First Semester</option>
        	<option value="Second Semester">Second Semester</option>
				<option value="Other">Other</option>
        </select></td>
    </tr>
	<tr>
    	
      <td>Credit Hours: </td>
      <td><input name="txtChours" type="text" value="" /></td>
    </tr>
    <tr>
    	
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'subjectAdmin.php';"  class="button"style="width:60px;"//>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;"//></p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "New Subject - Subjects - Student Management System - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='subjectAdmin.php'>Subjects </a></li><li>New Subject</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>