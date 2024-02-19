<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<script language="javascript" src="lib/scw/scw.js"></script>
<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtStudentID) || !validate_required(txtNameEnglish))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
</script>

<h1>Course Combination Details Edit</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();

	if (isset($_POST['btnSubmit']))
	{
	
	    $courseID = $_POST['coursID'];
		$combinationID = $db->cleanInput($_POST['combinationID']);
		
		
		//$subjectID= $db->cleanInput($_POST['subjectID']);
		
		$description= $db->cleanInput($_POST['Description']);
		
		$compulsary = $_POST['compulsary'];
		
		
		$query = "UPDATE course_combination SET CourseID='$courseID' , Description='$description',compulsary='$compulsary' WHERE combinationID='$combinationID'";
		$result = $db->executeQuery($query);
		header("location:coursecombination2.php");
	}
	
	$combinationID = $db->cleanInput($_GET['combinationID']);
	$query = "SELECT * FROM course_combination WHERE combinationID='$combinationID'";
	$result = $db->executeQuery($query);
	
	$row =  $db->Next_Record($result);
	if ($db->Row_Count($result)>0)
	{
?>
<form method="post" action="coursecombedit.php?combinationID=<?php echo $combinationID; ?>" onsubmit="return validate_form(this);" class="plain">
  <table class="searchResults">
    <tr> 
      <td>CourseID : </td>
      <td><input name="coursID" type="text" id="txtCoursID" value="<?php echo $row['CourseID']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>combinationID :</td>
      <td><input name="combinationID" type="text" id="txtcombinationID" value="<?php echo $row['combinationID']; ?>" /></td>
    </tr>
    
    
    <tr> 
      <td>Description : </td>
      <td><input name="Description" type="text" value="<?php echo $row['Description'] ?>" style="width:300px"/></td>
    </tr>
    
    <tr> 
      <td valign="top">compulsary : </td>
      <td><select name="compulsary">
        <option <?php if ($row['compulsary']=='Yes') echo "selected='selected'"; ?> value="Yes">Yes</option>
        <option <?php if ($row['compulsary']=='No') echo "selected='selected'"; ?> value="No">No</option>
      </select>
        <br/>
        <br/></td>
    </tr>
  </table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'coursecombination2.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;"/></p>
</form>

<?php
   }
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
 $pagetitle = "Edit Student - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>Edit Student</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>
