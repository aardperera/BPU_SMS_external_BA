<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
  
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
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
<script language="javascript">
 	function MsgOkCancel()
	{
		var message = "Please confirm to DELETE this subject...";
		var return_value = confirm(message);
		return return_value;
	}
 </script>

<h1>Course Subject</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	if (isset($_POST['CourseID']))
	{
		$courseID=$_POST['CourseID'];
	}
	
	if (isset($_POST['subcrsID']))
	{
		$subcrsID=$_POST['subcrsID'];
	}
	
	if (isset($_POST['SubjectID']))
	{
		$SubjectID=$_POST['SubjectID'];
	}
	
	if (isset($_POST['compulsary']))
	{
		$compulsary=$_POST['compulsary'];
	}
	
	
	if (isset($_POST['btnSubmit']))
	{
	
	$subjectID = $db->cleanInput($_POST['SubjectID']);
	
	    $courseID = $_POST['CourseID'];
		$subcrsID= $_POST['subcrsID'];
		$compulsary = $_POST['compulsary'];
		
		
		
		$query = "INSERT INTO crs_subject SET  CourseID='$courseID', subcrsID='$subcrsID',SubjectID='$SubjectID',compulsary='$compulsary'";
		$result = $db->executeQuery($query);
		
		header("location:coursecomsubject.php");
	}
?>
<form method="post" name="form1" id="form1" action="" onSubmit="return validate_form(this);" class="plain">
  <table class="searchResults">
    <tr> 
      <td>Course ID  :</td>
	 
      <td><select id="CourseID" name="CourseID" onchange="document.form1.submit()" >
      <option value="">---</option>
          <?php
			$query = "SELECT courseID,courseCode FROM course;";
			$result = $db->executeQuery($query);
			while ($data= $db->Next_Record($result)) 
			{
			if ($_SESSION['courseId']==0)
			  {
			  echo '<option value="'.$data[0].'">'.$data[1].'</option>'; 
			  }
			  else
			  {
				if ($_SESSION['courseId']==$data[0])
				  {
				  echo '<option value="'.$data[0].'">'.$data[1].'</option>'; 
				  }	
			  }
        	} 
			?>
        </select>
        <script type="text/javascript" language="javascript">
		document.getElementById('CourseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
		</script>
      </td>
    </tr>
   
	
	
	<tr>
      <td>Sub Course ID: </td>
      <td><label>
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
 </label>
		</td>
        
    </tr>
	 
   
    <tr>
      <td>Subject ID : </td>
      <td><label>
      <select name="SubjectID">
        <?php
		if(isset($courseID))
		{
		
			$query2 = "SELECT subjectID,nameEnglish FROM subject Where `courseID` ='".$_SESSION['courseId']."' ;";
			$result2 = $db->executeQuery($query2);
			while ($data2= $db->Next_Record($result2)) 
			{
			echo '<option value="'.$data2[0].'">'.$data2[0].'--'.$data2[1].'</option>';
        	} 

		}

			?>
      </select>
        
      </label></td>
    </tr>
	
	
	
    <tr> 
      <td>Compulsary : </td>
      <td><select name="compulsary">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
       
      </select></td>
    </tr>
  </table>
  
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onClick="document.location.href = 'coursecomsubject.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" /></p>





<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "New Student - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='coursecombination2.php'>Students </a></li><li>New Student</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>