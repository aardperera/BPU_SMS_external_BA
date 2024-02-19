<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
  
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
   
   $rowsPerPage = 10;
  $pageNum = 1;
  if(isset($_GET['page'])) $pageNum = $_GET['page'];
  
  
	
?>

<h1>New Course Enrollment</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	$studentID = $db->cleanInput($_GET['studentID']);
	
?>
<form method="post" name = "form" action="" class="plain">

<?php 
$subid=array();
	if (isset($_POST['lstCourse']))
	{
		//$course = $_SESSION['courseId'];
	}
	else
	{
	$course="";
	}
		if (isset($_POST['lstCoursesub']))
	{
		$course = $_SESSION['courseId'];
		//$indexNo = $_POST['txtIndexNo'];
		$courseCombID = $_POST['lstCourseComb'];
		
	}
$subcrsID = $_POST['lstCoursesub1'];
	 $query = "SELECT * FROM subject WHERE courseID='".$_SESSION['courseId']."' AND `subcrsID`='$subcrsID' ";
	
	
	
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = $db->Row_Count($db->executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);
  
  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	$pageResult = $db->executeQuery($pageQuery);
?>
<table class="searchResults">
    <tr>
    	<td>Registration No. : </td><td width = 300><input name="txtRegNo" type="text" value="<?php echo $studentID; ?>" /></td>
    </tr>
	<tr>
      <td>Sub Course: </td>
      <td>
     	  <?php
	 
								echo '<select name="lstCoursesub1" id="lstCoursesub1"  onChange="document.form.submit()" class="form-control">'; // Open your drop down box
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
    	<td>Index No. : </td><td><input name="txtIndexNo" type="text" value="<?php echo $indexNo; ?>" /></td>
    </tr>
    <tr>
    	<td>Student ID : </td><td><input name="txtStudentID" type="text" value="<?php echo $studentID; ?>" readonly="readonly" /></td>
    </tr>
	
	
	
	
	
	<!--<tr>
    	<td>Sub Course : </td><td>
        	<select name="lstCoursesub" id="lstCoursesub" size="auto" onChange="this.form.submit()">
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
	-->
	
	
	<!-- <tr>
    	<td>Course Combination : </td><td>
        	<select name="lstCourseComb" id="lstCourseComb" size="auto" onChange="this.form.submit()">
        	<?php
			if (isset($_POST['lstCoursesub']))
			//print 'hhhhhhhhh';
			{
				$querynew = "SELECT Description, combinationID FROM course_combination WHERE   courseID='".$_SESSION['courseId']."' and subcrsID=".$_POST['lstCoursesub']." order by Description";
				//$querynew = "SELECT Description, combinationID FROM course_combination WHERE  CourseID = '9' and subcrsID='1' order by Description";
				$result = $db->executeQuery($querynew);
				for ($i=0;$i<mysql_numrows($result);$i++)
				{
					$rCourseID = mysql_result($result,$i,"combinationID");
					$rName = mysql_result($result,$i,"Description");
					echo "<option value=\"".$rCourseID."\">".$rName."</option>";
				}
			} 
			?>
        	</select> 
        </td>
    </tr> -->
	

	
    <tr>
    	<td>Entry Year : </td><td><select name="lstYearEntry">
        	<?php
				for ($i=2010;$i<=2100;$i++)
				{
					echo "<option value='$i'>$i</option>";
				}
			?>
        </select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="date" name="date" value="<?php echo date("Y-m-d"); ?>"/ readonly></td>
    </tr>
</table>

<br/>




<?php if ($db->Row_Count($pageResult)>0){ ?>

  <table class="searchResults">
	<tr>
    	<th>Subject ID</th><th>Subject Code</th><th>Subject Name</th><th colspan="4"></th>
    </tr>
    
<?php
  while ($row =  $db->Next_Record($pageResult))
  {
	  array_push($subid, $row['subjectID']);
?>
	<tr>
        <td><?php echo $row['subjectID'] ?></td>
		<td><?php echo $row['codeEnglish'] ?></td>
		<td><?php echo $row['nameEnglish'] ?></td>
        <td><input name="check<?php echo $row['subjectID'] ?>" type="checkbox"   <?php if ($row['courseID'] == '5' || $row['courseID'] == '3'){ ?> Enabled <?php   }else { ?> Disabled  <?php }  ?>  value="check<?php echo $row['subjectID'] ?>" /> </td>
		
    </tr>
<?php
  }
?>
  </table>
<br/><br/>
<p>
	<input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'courseEnroll.php?studentID=<?php echo $studentID; ?>';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <td><input name="btnSubmit" type="button" value="Submit" onclick="document.location.href = 'courseEnroll.php?studentID=<?php echo $studentID; ?>';" class="button" style="width:80px;"/></td>
	
</p>
</form>
<?php 
  $self = $_SERVER['PHP_SELF'];
  if ($pageNum > 1)
{
   $page  = $pageNum - 1;
   $prev  = " <a class=\"link\" href=\"$self?page=$page\">[Prev]</a> ";
   $first = " <a class=\"link\" href=\"$self?page=1\">[First Page]</a> ";
}
else
{
   $prev  = '&nbsp;'; // we're on page one, don't print previous link
   $first = '&nbsp;'; // nor the first page link
}

if ($pageNum < $numPages)
{
   $page = $pageNum + 1;
   $next = " <a class=\"link\" href=\"$self?page=$page\">[Next]</a> ";
   $last = " <a class=\"link\" href=\"$self?page=$numPages\">[Last Page]</a> ";
}
else
{
   $next = '&nbsp;'; // we're on the last page, don't print next link
   $last = '&nbsp;'; // nor the last page link
}

echo "<table border=\"0\" align=\"center\" width=\"50%\"><tr><td width=\"20%\">".$first."</td><td width=\"10%\">".$prev."</td><td width=\"10%\">"."$pageNum of $numPages"."</td><td width=\"10%\">".$next."</td><td width=\"30%\">".$last."</td></tr></table>";
}else echo "<p>No enrollments.</p>";

?>
<?php
for($i=0;$i<count($subid);$i++){
	
	//echo $subid[$i]."<br>";
}
if (isset($_POST['btnSubmit']))
	{
	//====
	$subcrsquery = "SELECT subcrsID FROM crs_sub where description='".$_SESSION['subcourseType']."'";
	 $subcrsresult = $db->executeQuery($subcrsquery);
	$subcrsrow =  $db->Next_Record($subcrsresult);
	$valuesubcrsID	 = $subcrsrow['subcrsID'];
	//====
		$regNo = $db->cleanInput($_POST['txtRegNo']);
		$indexNo = $_POST['txtIndexNo'];
		$studentID = $_POST['txtStudentID'];
		$course = $_SESSION['courseId'];
		$yearEntry = $_POST['lstYearEntry'];
		$courseCombID = $_POST['lstCourseComb'];
		$subcrsID = $_POST['lstCoursesub1'];
		//print $indexNo ;
		//echo 'aaaa';
		
			$date=$_POST['date'];
			$subjectID = $_POST['subjectID'];
		
		
		$resultrow = $db->executeQuery("SELECT * FROM crs_enroll where courseID='".$_SESSION['courseId']."' and  studentID='$studentID'");
	//			if ($db->Row_Count($resultrow)>0){
	//	$query = "UPDATE crs_enroll SET regNo='$regNo', indexNo='$indexNo', studentID='$studentID', courseID='".$_SESSION['courseId']."', yearEntry='$yearEntry', combinationID='$courseCombID',subcrsID='$subcrsID' WHERE  studentID='$studentID'";
	//	}
	//	else{
	//	echo "val" ;
		

	$query = "INSERT INTO crs_enroll SET regNo='$regNo', indexNo='$indexNo', studentID='$studentID', courseID='".$_SESSION['courseId']."', yearEntry='$yearEntry', combinationID='$courseCombID',subcrsID='$subcrsID'";
		$result = $db->executeQuery($query);
			
	//	header("location:courseEnroll.php");
		
		$query1="SELECT max(`Enroll_id`) FROM `crs_enroll` ";
		$result1 = $db->executeQuery($query1);
		$subcrsrow1 =  $db->Next_Record($result1);
	//	}
	//	print $query;
		//print $query;
		
		
		for($i=0;$i<count($subid);$i++){
	
	if (isset($_POST["check".$subid[$i]]))
	{
		//echo $subid[$i]."  check <br>";
	
		$query1 = "INSERT INTO `subject_enroll`(`Enroll_id`, `subjectID`, `enroll_date`) VALUES ($subcrsrow1[0],$subid[$i],'$date')";
		$result1 = $db->executeQuery($query1);
	
		
		}

	}
		
		//=======================================
		$querystudent = "SELECT * FROM crs_select WHERE  studentID='$studentID'";
				$resultstudent = $db->executeQuery($querystudent);
				for ($i=0;$i<mysql_numrows($resultstudent);$i++)
				{
					$CourseIDtable = mysql_result($resultstudent,$i,"courseID");
					print $CourseIDtable;
						echo 'aaammm';
					print $course;
					if ($CourseIDtable!=$course){
					//$queryupdate = "UPDATE crs_select SET status='N' where courseID='$CourseIDtable' and studentID='$studentID' ";
					//print $queryupdate;
			//	$result = $db->executeQuery($queryupdate);
					}
				}
		//========================================
		//header("location:courseEnroll.php?studentID=$studentID");
	}
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "New Course Enrollment - Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li><a href='courseEnroll.php?studentID=$studentID'>Course Enrollments </a></li><li>New Course Enrollment</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>