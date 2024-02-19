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

<h1>New Course Payment</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
 // 	include('authcheck.inc.php');
 
 
 if (isset($_POST['courseID']))
	{$courseID=$_POST['courseID'];}
 
	
	if (isset($_POST['btnSubmit']))
	{
	    $courseID   = $_POST['course'];
		$subcrsID  = $_POST['subcrsID'];
		$CoursePaymenttxt = $_POST['CoursePaymenttxt'];
		$Description = $_POST['txtDescription'];
		$Amount = $_POST['txtAmount'];
		$StartDate = $_POST['date'];
		
		//$Amount = $db->cleanInput($_POST['Amount']);
		//$chours = $db->cleanInput($_POST['txtChours']);
		//$description = $db->cleanInput($_POST['txtDescription']);
		
		$query = "INSERT INTO course_payment SET courseID='$courseID ',subcrsID='$subcrsID', PaymentType='$CoursePaymenttxt',Description='$Description',Amount='$Amount',StartDate='$StartDate'";
		$result = $db->executeQuery($query);
		header("location:coursepayment.php");
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
   
   <tr>
      <td>Sub Course ID: </td>
      <td>
     	  <?php
	 
								echo '<select name="subcrsID" id="subcrsID"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
								$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								
								while ($row =  $db->Next_Record($result)){
									echo '<option value="'.$row['id'].'">'.$row['description'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
							
							 <script>
								document.getElementById('subcrsID').value = "<?php echo $subcrsID;?>";
							</script>
		</td>
        
    </tr>
	
	 <tr>
    	
      <td height="28">Payment Type : </td>
      <td><select name="CoursePaymenttxt">
        <option value="CourseFree">Course Free</option>
        <option value="Other">Other</option>
      </select></td>
    </tr>
	
    <tr>
    	<td> Description : </td>
		<td><textarea rows="4" cols="50" name="txtDescription" type="text" value="">
			</textarea>
			</td>
    </tr>
  
   <tr>
    	<td> Amount : </td><td><input name="txtAmount" type="text" value="" style="width:300px"/></td>
    </tr>
	
	<tr>
    	
      <td>Start Date: </td>
      <td> <input type="date" id="date" name="date" value="<?php echo date("Y-m-d"); ?>"/></td>
    </tr>
	
   
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'coursepayment.php';"  class="button"style="width:60px;"//>&nbsp;&nbsp;&nbsp;
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