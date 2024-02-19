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

</script>

<h1>Sub Course Details</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	if (isset($_POST['CourseID']))
	{$courseID=$_POST['CourseID'];}
	
	
	if (isset($_POST['btnSubmit']))
	{
	
	
	    $courseID = $_POST['CourseID'];
		
		
		
		
		$description = $db->cleanInput($_POST['Description']);
		
		
		$queryselect = "SELECT subcrsID from crs_sub WHERE CourseID='$courseID'";
		$resultselect = $db->executeQuery($queryselect);
		$rowvalu= $db->Row_Count($resultselect);
		$newvalu=$rowvalu+1;
		$query = "INSERT INTO crs_sub SET  CourseID='$courseID', subcrsID='$newvalu', Description='$description'";
		$result = $db->executeQuery($query);
		header("location:coursesubAdmin.php");
	}
?>
<form method="post" name="form1" id="form1" action="" onSubmit="return validate_form(this);" class="plain">
  <table class="searchResults">
    <tr> 
      <td>Course ID  : </td>
      <td><select id="CourseID" name="CourseID" onchange="document.form1.submit()" >
      <option value="">---</option>
          <?php
			$query = "SELECT courseID,nameEnglish FROM course;";
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
      <td>Description:</td>
      <td><input type="text" name="Description" id="textfield" />      </td>
    </tr>
    
  </table>
  
  
  
  
  
  
  
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onClick="document.location.href = 'subcourse.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" /></p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "New Student - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='coursecombination2.php'>Students </a></li><li>New Student</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>