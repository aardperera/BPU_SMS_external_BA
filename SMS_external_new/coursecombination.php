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

<h1>New Course Combination</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	if (isset($_POST['CourseID']))
	{$courseID=$_POST['CourseID'];
	$_SESSION['courseId']=$courseID;
	}
	
	
	if (isset($_POST['btnSubmit']))
	{
	
	
	    $courseID = $_POST['CourseID'];
		
		$combinationID = $db->cleanInput($_POST['CombinationID']);
			$subcrsID= $db->cleanInput($_POST['lstCoursesub']);
		 /*if ($combinationID=="New")
		 {
		 $combinationID =1;
		 }
		 else{
		 	$qry =  $db->Next_Record($db->executeQuery("SELECT COUNT(DISTINCT(combinationID)) FROM course_combination WHERE CourseID='".$_POST["CourseID"]."' and subcrsID=$subcrsID;"));
			print  $qry[0];
			$combinationID = $qry[0]+1;
			print "SELECT COUNT(DISTINCT(combinationID)) FROM course_combination WHERE CourseID='".$_POST["CourseID"]."' and subcrsID=$subcrsID;";
		 }
		
		*/
		
		//$subjectID = $db->cleanInput($_POST['SubjectID']);
		$description = $db->cleanInput($_POST['Description']);
	
		$compulsary = $_POST['compulsary'];
		
		
		
		$query = "INSERT INTO course_combination SET  CourseID='$courseID', combinationID='$combinationID', Description='$description',compulsary='$compulsary',subcrsID='$subcrsID' ";
		
		print $query;
		$result = $db->executeQuery($query);
		header("location:coursecombination2.php");
	}
?>
<form method="post" name="form1" id="form1" action="" onSubmit="return validate_form(this);" class="plain">
  <table class="searchResults">
    <tr> 
      <td>Course ID  : </td>
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
    	<td>Sub Course : </td><td>
        	<select name="lstCoursesub" id="lstCoursesub" size="auto" onChange="this.form1.submit()">
        	<?php
			if (isset($_SESSION['courseId']))
			{
				$query = "SELECT description, subcrsID FROM crs_sub WHERE  courseID='".$_SESSION['courseId']."' order by Description";
				$result = $db->executeQuery($query);
				for ($i=0;$i<mysql_numrows($result);$i++)
				{
					$subCourseID = mysql_result($result,$i,"subcrsID");
					$subName = mysql_result($result,$i,"description");
						if ($subcrsID ==$subCourseID){
					echo "<option selected value=\"".$subCourseID."\">".$subName."</option>";
					}
					else {
					echo "<option value=\"".$subCourseID."\">".$subName."</option>";}
				}
			} 
			
			?>
        	</select>
        </td>
    </tr>
    <tr>
      <td>Combination ID</td>
      <td><select name="CombinationID">
	  <option value="New">New</option>
	  <?php
	  if (isset($_POST["CourseID"]))
	  {
	  $qry = $db->executeQuery("SELECT DISTINCT(combinationID) FROM course_combination WHERE CourseID='".$_SESSION['courseId']."';");
	  while ($myval =  $db->Next_Record($qry))
		  {
		  ?>
		  <option value="<?php echo $myval[0];?>"><?php echo $myval[0];?></option>
		  <?php	
		  }
	  }
	  ?>
	  </select></td>
    </tr>
    <tr> 
      <td>Description:</td>
      <td><input type="text" name="Description" id="textfield" />      </td>
    </tr>
	<!--
    <tr>
      <td>Subject ID : </td>
      <td><label>
      <select name="SubjectID">
        <?php
		if(isset($courseID))
		{
		
			$query2 = "SELECT subjectID,nameEnglish FROM subject WHERE courseID='".$_SESSION['courseId']."';";
			$result2 = $db->executeQuery($query2);
			while ($data2= $db->Next_Record($result2)) 
			{
			echo '<option value="'.$data2[0].'">'.$data2[1].'</option>';
        	} 

		}

			?>
      </select>
        
      </label></td>
    </tr> --->
    <tr> 
      <td>Compulsary : </td>
      <td><select name="compulsary">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
       
      </select></td>
    </tr>
  </table>
  
  
  
  
  
  
  
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onClick="document.location.href = 'coursecombination2.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
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