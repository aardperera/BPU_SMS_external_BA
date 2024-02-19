<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
  
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
   
  $rowsPerPage = 100;
  $pageNum = 1;
  if(isset($_GET['page'])) $pageNum = $_GET['page'];

//  $query = "SELECT * FROM subject WHERE courseID='".$_SESSION['courseId']."'";
  
	
?>


<h1>Course Enrollment Auto Transfer</h1>
<?php
	include('dbAccess.php');
	$db = new DBOperations();
	
	//$studentID = $db->cleanInput($_GET['studentID']);
	
?>
<form method="post" name = "form" id = "form" action="" class="plain">
<?php 
$subid=array();
	//$course="";
	$course = $_SESSION['courseId'];
	
	if (isset($_POST['lstYearEntry']))
	{
		$lstYearEntry= $_POST['lstYearEntry'];
		//$course = $_SESSION['courseId'];
	}
	else
	{
	
	}
		if (isset($_POST['subcrsID']))
	{
		$subcrsID =$_POST['subcrsID'];
		//$indexNo = $_POST['txtIndexNo'];
		//$courseCombID = $_POST['lstCourseComb'];
		//$subcrsID = $_POST['lstCoursesub'];
	}
	 
if (isset($_POST['btnSubmit']))
	{
	if($subcrsID==7 || $subcrsID==8)
	{
		$errorsubid = '';
		$errorstuid = '';
	$testDate = date('Y-m-d');
	$query1234 = "SELECT a.Enroll_id, a.regNo, b.title, b.nameEnglish FROM `crs_enroll` AS a, student AS b WHERE a.subcrsID = $subcrsID AND a.yearEntry = $lstYearEntry AND a.regNo = b.studentID order by a.regNo ;";
	
	$result1234 = $db->executeQuery($query1234);
	while ($row1234 = $db->Next_Record($result1234))
		  {
		if(isset($_POST['stu'.$row1234['Enroll_id']]))
		{
			$enrlid = $_POST['stu'.$row1234['Enroll_id']];
			
			$query11234 = "SELECT regNo FROM `crs_enroll` WHERE subcrsID = '".($subcrsID+1)."' AND yearEntry = '".($lstYearEntry+1)."' AND regNo = (SELECT regNo FROM crs_enroll WHERE Enroll_id = '$enrlid');";
			$res11234 = $db->executeQuery($query11234);
			if($db->Row_Count($res11234)>0)
			{
				$errdata = $db->Next_Record($res11234);
				$errorstuid = $errdata['regNo'];
				break;
			}
			
			
			$query12345 = "SELECT a.subjectID, b.codeEnglish FROM `subject_enroll` AS a, subject AS b WHERE a.Enroll_id = '$enrlid' AND a.subjectID = b.subjectID AND b.notMap ='n' ;";
			//print $query12345;
			$result12345 = $db->executeQuery($query12345);
			
			while ($row12345 = $db->Next_Record($result12345))
		  	{
				$currentSubject = $row12345['subjectID'];
				$currentSubjectcode = $row12345['codeEnglish'];
				if($subcrsID==7)
				{
					$query123456 = "SELECT second_subid FROM `map_sub_to_years` WHERE from_date <= '$testDate' AND to_date >= '$testDate' AND first_subid = '$currentSubject';";
				}
				elseif($subcrsID==8)
				{
					$query123456 = "SELECT third_subid FROM `map_sub_to_years` WHERE from_date <= '$testDate' AND to_date >= '$testDate' AND second_subid = '$currentSubject';";
				}
				$result123456 = $db->executeQuery($query123456);
				if ($db->Row_Count($result123456)==0)
				{
					$errorsubid=$currentSubjectcode;
					break;
				}
			}
		}
		if ($errorsubid != '')
		{
			break;
		}
	}
		
		if ($errorsubid != '')
		{
			echo"<script>alert('The Subject $errorsubid is not Mapped to a Next Level Subject');</script>";
		}
		if ($errorstuid != '')
		{
			echo"<script>alert('The Student $errorstuid is Already Enrolled for Next Level');</script>";
		}
		
		if ($errorsubid == '' && $errorstuid == '')
		{
			$query1234 = "SELECT a.Enroll_id, a.regNo, b.title, b.nameEnglish, a.indexNo, a.studentID FROM `crs_enroll` AS a, student AS b WHERE a.subcrsID = $subcrsID AND a.yearEntry = $lstYearEntry AND a.regNo = b.studentID;";
	$result1234 = $db->executeQuery($query1234);
	while ($row1234 = $db->Next_Record($result1234))
		  {
		if(isset($_POST['stu'.$row1234['Enroll_id']]))
		{
			$enrlid = $_POST['stu'.$row1234['Enroll_id']];
			
			// insert crs_enroll table
			$regNo = $row1234['regNo'];
			$indexNo = $row1234['indexNo'];
			$studentID = $row1234['studentID'];
			$newyearEntry = ($lstYearEntry+1);
			$newsubcrsID = ($subcrsID+1);
			
			$query12345678 = "INSERT INTO `crs_enroll`(`regNo`, `indexNo`, `studentID`, `courseID`, `yearEntry`, `subcrsID`) VALUES ('$regNo', '$indexNo', '$studentID', '$course', '$newyearEntry', '$newsubcrsID');";
			$db->executeQuery($query12345678);
			$newEnrollID = $db->lastID();
			
			$query12345 = "SELECT a.subjectID, b.codeEnglish FROM `subject_enroll` AS a, subject AS b WHERE a.Enroll_id = '$enrlid' AND a.subjectID = b.subjectID AND b.notMap ='n';";
			$result12345 = $db->executeQuery($query12345);
			
			while ($row12345 = $db->Next_Record($result12345))
		  	{
				$currentSubject = $row12345['subjectID'];
				$currentSubjectcode = $row12345['codeEnglish'];
				if($subcrsID==7)
				{
					$query123456 = "SELECT second_subid FROM `map_sub_to_years` WHERE from_date <= '$testDate' AND to_date >= '$testDate' AND first_subid = '$currentSubject';";
					print $query123456;
				}
				elseif($subcrsID==8)
				{
					$query123456 = "SELECT third_subid FROM `map_sub_to_years` WHERE from_date <= '$testDate' AND to_date >= '$testDate' AND second_subid = '$currentSubject';";
				}
				$result123456 = $db->executeQuery($query123456);
				// insert subj_enroll table
				$row123456 = $db->Next_Record($result123456);
				$insertsubjectID = $row123456[0];
				print $insertsubjectID;
					$query1234567 = "INSERT INTO `subject_enroll`(`Enroll_id`, `subjectID`, `enroll_date`) VALUES ('$newEnrollID','$insertsubjectID','$testDate');";
				print $query1234567;
					$db->executeQuery($query1234567);
				
			}
		}
	}
			echo'<script>alert("All Selected Students were Sucessfully Enrolled to Next Year Examination!");</script>';
	}	
	}
	else
	{
		echo'<script>alert("Not Allowed, Please check the operation again!");</script>';
	}
}
?>
<table class="searchResults">
	
	<tr>
      <td>Current Sub Course ID: </td>
      <td width="300">
     	  <?php
	
								echo '<select name="subcrsID" id="subcrsID"  onChange="document.form.submit()" class="form-control"><option value="">---</option>'; // Open your drop down box
								$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
								
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								

								while ($row = $db->Next_Record($result)){
								//while ($row = mysql_fetch_array($result)){
									echo '<option value="'.$row['id'].'">'.$row['description'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
							<?php
		if (isset($_POST['subcrsID']))
		{
			?>
							 <script>
								document.getElementById('subcrsID').value = "<?php echo $subcrsID;?>";
							</script>
		  <?php
		}
		?>
		</td>
        
    </tr>

	
	
    <tr>
    	<td>Entry Year : </td><td><select name="lstYearEntry" id="lstYearEntry"   onChange="document.form.submit()">
        	<?php
				for ($i=2018;$i<=2050;$i++)
				{
					echo "<option value='$i'>$i</option>";
				}
			?>
        </select>&nbsp;&nbsp;&nbsp;&nbsp;
		
		<?php
		if (isset($_POST['lstYearEntry']))
		{
			?>
		<script>
								document.getElementById('lstYearEntry').value = '<?php echo $lstYearEntry;?>';
							</script>
		<?php
		}
		?>
		
		</td>
    </tr>


	


</table> 

<br/>






<?php 

if ($subcrsID!='' && $lstYearEntry!=''){
//if (mysql_num_rows($pageResult)>0){ 
	
	$query1234 = "SELECT a.Enroll_id, a.regNo, b.title, b.nameEnglish FROM `crs_enroll`AS a, student AS b WHERE a.subcrsID = $subcrsID AND a.yearEntry = $lstYearEntry AND a.regNo = b.studentID order by a.regNo;";
	$result1234 = $db->executeQuery($query1234);
	if ($db->Row_Count($result1234)>0)
	{
		
	
?>
	
<table class="searchResults">

<h5>Enrolled Student List </h5>
	<tr>
    	<th>#</th><th>Student ID</th><th>Title</th><th>Student Name</th><th></th>
    </tr>

<?php
	$cnt = 1;
		  while ($row1234 = $db->Next_Record($result1234))
		  {
			  ?>
	<tr>
    	<td><?php echo $cnt;?></td><td><?php echo $row1234['regNo'];?></td><td><?php echo $row1234['title'];?></td><td><?php echo $row1234['nameEnglish'];?></td>
    	<td><input type="checkbox" id="stu<?php echo $row1234['Enroll_id'];?>" value="<?php echo $row1234['Enroll_id'];?>" name="stu<?php echo $row1234['Enroll_id'];?>" checked /></td>
    </tr>
	<?php
			  $cnt++;
		  }
				  ?>

	</table>
	


<br/><br/>
<p>
<input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'studentAdmin.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
    <!--<input name="btnSubmit" type="Submit" value="Submit"  class="button" style="width:60px;"/>-->
	<input name="btnSubmit" type="Submit" value="Auto Enroll to Next Year"  class="button" style="width:150px; "/>
  
  </p>
</form>
<?php 
}
	else {echo "<p>No enrollments.</p>";}
}
	

?>
<?php
	
//for($i=0;$i<count($subid);$i++){
//	
//	//echo $subid[$i]."<br>";
//}

  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "New Course Enrollment - Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>Course Enrollments - Auto Transfer</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>