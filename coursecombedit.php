<?php
  //Buffer larger content areas like the main page content
  ob_start();
    session_start();
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

<h1>Course Subject Edit</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	$combID = $db->cleanInput($_GET['combID']);
	
	if (isset($_POST['btnSubmit']))
	{
	
	 $querynew = "SELECT * FROM crs_subject WHERE ID='$combID'";
	//print $query;
	$resultnew = $db->executeQuery($querynew);
	
	$rownew =  $db->Next_Record($resultnew);
	$val1new=$rownew['CourseID'];
	$val2new=$rownew['subcrsid'];
	
		
		
		$subjectID= $db->cleanInput($_POST['SubjectID']);
		//print $subjectID;
		
		
		
		$queryupdate = "UPDATE crs_subject SET CourseID='$val1new' , subcrsid ='$val2new', subjectID='$subjectID' WHERE ID='$combID '";
		
		//print $queryupdate;
		
		$result = $db->executeQuery($queryupdate);
		header("location:coursecomsubject.php");
	}
	

	//print $combID;
	$query = "SELECT * FROM crs_subject WHERE ID='$combID'";
	//print $query;
	$result = $db->executeQuery($query);
	
	$row =  $db->Next_Record($result);
	$val1=$row['CourseID'];
	$val2=$row['subcrsid'];
	
	if ($db->Row_Count($result)>0)
	{
		$querycrs = "SELECT courseCode FROM course where courseID='$val1';";
			$resultcrs = $db->executeQuery($querycrs);
			$rowcrs =  $db->Next_Record($resultcrs);
			
			$querycrs1 = "SELECT  description FROM crs_sub where courseID='$val1' and subcrsID='$val2';";
			
			$resultcrs1 = $db->executeQuery($querycrs1);
			$rowcrs1 =  $db->Next_Record($resultcrs1);
	
	  }
?>
  
<form method="post"  onsubmit="return validate_form(this);" class="plain">
  <table class="searchResults">
    <tr> 
      <td>Course: </td>
      <td><input name="coursID" type="text" id="txtCoursID" value="<?php echo $rowcrs['courseCode']; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
      <td>Sub Course:</td>
      <td><input name="combinationID" type="text" id="txtcombinationID" value="<?php echo $rowcrs1['description']; ?>" /></td>
    </tr>
    
    
    <tr> 
      <td>Subject : </td>
      <td> 
      <select name="SubjectID" id="SubjectID">
        <?php
		

		
			$query2 = "SELECT subjectID,nameEnglish FROM subject Where `courseID` ='$val1' ;";
		
			$result2 = $db->executeQuery($query2);
			while ($data2= $db->Next_Record($result2)) 
			{
			echo '<option value="'.$data2[0].'">'.$data2[0].'--'.$data2[1].'</option>';
        	} 



			?>
      </select> </td>

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
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'coursecomsubject.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;"/></p>
</form>

<?php
 
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
 $pagetitle = "Edit Student - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>Edit Student</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>
