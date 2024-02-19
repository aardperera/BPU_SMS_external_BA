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
		//$courseCombID = $_POST['lstCourseComb'];
		//$subcrsID = $_POST['lstCoursesub'];
	}
	 $subcrsID =$_POST['subcrsID'];
     $query = "SELECT  c.subjectID  FROM crs_subject as c,subject as s WHERE c.CourseID='".$_SESSION['courseId']."' AND c.subcrsid ='$subcrsID'  AND c. CourseID=s.courseID and s.subjectID=c.subjectID order by s.suborder  ";
	// $query = "SELECT * FROM crs_subject  WHERE CourseID='".$_SESSION['courseId']."' AND`subcrsid`='$subcrsID' order by  Compulsary  ";
//print $query;
	
	
	
	
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = $db->Row_Count( $db->executeQuery($query));
	//$numRows = mysql_num_rows(executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);
  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	$pageResult = $db->executeQuery($pageQuery);
?>
<table class="searchResults">
    <tr>
    	<td>Registration No. : </td><td width = 300><input name="txtRegNo" type="text" value="<?php echo $studentID; ?>" /></td>
    </tr>
	
	<tr>
      <td>Sub Course ID: </td>
      <td>
     	  <?php
	
								echo '<select name="subcrsID" id="subcrsID"  onChange="document.form.submit()" class="form-control">'; // Open your drop down box
								$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
								
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								

								while ($row = $db->Next_Record($result)){
								//while ($row = mysql_fetch_array($result)){
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
    	<td>Index No. : </td><td><input name="txtIndexNo" type="text" value="<?php echo $indexNo; ?>" /></td>
    </tr>
    <tr>
    	<td>Student ID : </td><td><input name="txtStudentID" type="text" value="<?php echo $studentID; ?>" readonly="readonly" /></td>
    </tr>

	
	
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


<?php

function myFunction($cId) {
    if ($cId == 3){}
	elseif($cId == 5){}
	else
	{}
}
?>



<?php 

if ($db->Row_Count($pageResult)>0){
//if (mysql_num_rows($pageResult)>0){ 
	
?>

<h5>Elective Combined Modules </h5>

<table class="searchResults">
	<tr>
    	<th>Subject ID</th><th>Subject Code</th><th>Subject Name</th><th colspan="4"></th>
    </tr>
    
<?php	  
	  $querye = "SELECT * FROM `combined_subjects` ";
      $resulte = $db->executeQuery($querye);
      //$rowe = mysql_fetch_array($resulte);

	  //while ($rowe = mysql_fetch_array($resulte))
	  while ($rowe = $db->Next_Record($resulte))
	  {

		array_push($subid, $rowe['sub_id_y1']);
		if($subcrsID == 7)
		{

      $ae = $rowe['sub_id_y1'];

	  $queryg = "SELECT * FROM subject where subjectID='$ae'  ";
	  $resultg =  $db->executeQuery($queryg);
	 while ($rowg = $db->Next_Record($resultg))
	 //while ($rowg = mysql_fetch_array($resultg))
	 
	 {
?>
	<tr>
        <td><?php echo $rowg['subjectID'] ?></td>
		<td><?php echo $rowg['codeEnglish'] ?></td>
		<td><?php echo $rowg['nameEnglish'] ?></td>
        <td><input name="check<?php echo $rowg['subjectID'] ?>" id="myCheck" <?php myFunction($row['courseID']); ?>  type="checkbox" value="check<?php echo $rowg['subjectID'] ?>" /> </td>
        </tr>
<?php
	  } }	}

	  

	  $querya= "SELECT * FROM `crs_enroll` WHERE `regNo` = '$studentID'";
      $resulta = $db->executeQuery($querya);
      $rowa = $db->Next_Record($resulta);	
      //$rowa= mysql_fetch_array($resulta);
	  $a = $rowa['Enroll_id'];
	  
	  $query0 = "SELECT * FROM `subject_enroll` WHERE `Enroll_id` ='$a' ";
	  $result0 = $db->executeQuery($query0);
     // $row2 = mysql_fetch_array($result2);
	  
 	//while ($row0 = mysql_fetch_array($result0))
	 while ($row0 = $db->Next_Record($result0))
{

	

	  $a1 = $row0['subjectID'];
	
	  $query2 = "SELECT * FROM `combined_subjects` WHERE  `sub_id_y1` = '$a1'";
      $result2 = $db->executeQuery($query2);
      $row2 = $db->Next_Record($result2);	
      //$row2 = mysql_fetch_array($result2);
      $a2 = $row2['id'];
	 
	  $query3 = "SELECT * FROM `combined_subjects` WHERE  `id` = '$a2'";
      $result3 = $db->executeQuery($query3);
	  $row3 = $db->Next_Record($result3);	
      //$row3 = mysql_fetch_array($result3);
      $a3 = $row3['sub_id_y2'];
	  $a4 = $row3['sub_id_y3'];
	  if ($subcrsID == 8)
	{ 
	
	  $queryrr = "SELECT * FROM subject where subjectID='$a3' AND subcrsID = '8' ";
	  $resultrr = $db->executeQuery($queryrr);
			//$rowrr = mysql_fetch_array($resultrr);
	  while ($rowr = $db->Next_Record($resultr))
	  //while ($rowrr = mysql_fetch_array($resultrr))
	    {
  
		array_push($subid, $rowrr['subjectID']);
?>
	<tr>
        <td><?php echo $rowrr['subjectID'] ?></td>
		<td><?php echo $rowrr['codeEnglish'] ?></td>
		<td><?php echo $rowrr['nameEnglish'] ?></td>
		<td><input name="check<?php echo $rowrr['subjectID'] ?>" id="myCheck" <?php myFunction($row['courseID']); ?>  type="checkbox" value="check<?php echo $rowrr['subjectID'] ?>" /> </td>
        </tr>



<?php
	  
	}
?>

<?php
	  
	}
	if ($subcrsID == 9)
	{ 
	
	  $queryv = "SELECT * FROM subject where subjectID='$a4' AND subcrsID = '9' ";
	  $resultv = $db->executeQuery($queryv);
			//$rowrr = mysql_fetch_array($resultrr);
	  while ($rowv = $db->Next_Record($resultv))	
	  //while ($rowv = mysql_fetch_array($resultv))
	    {
  
		array_push($subid, $rowv['subjectID']);
	
?>
<tr>
        <td><?php echo $rowv['subjectID'] ?></td>
		<td><?php echo $rowv['codeEnglish'] ?></td>
		<td><?php echo $rowv['nameEnglish'] ?></td>
		<td><input name="check<?php echo $rowv['subjectID'] ?>" id="myCheck" <?php myFunction($row['courseID']); ?>  type="checkbox" value="check<?php echo $rowv['subjectID'] ?>" /> </td>
        </tr>
<?php
	  
	}}}



?>
</table>
<table class="searchResults">

<h5>Elective Modules </h5>
	<tr>
    	<th>Subject ID</th><th>Subject Code</th><th>Subject Name</th><th colspan="4"></th>
    </tr>

<?php
		   $query4 = "SELECT * FROM `combined_subjects` ";
		   $result4 = $db->executeQuery($query4);
		   $row4 = $db->Next_Record($result4);
		   //$row4 = mysql_fetch_array($result4);
		 
		   $a4 = $row4['sub_id_y2'];
		   $a5 = $row4['sub_id_y1'];
		   $a6 = $row4['sub_id_y3'];

		   if($subcrsID == 8)
		   {
		   $query6 = "SELECT * FROM subject where subjectID <> '$a4' AND subcrsID = '8' ";
		   $result6 = $db->executeQuery($query6);
	//$rowrr = mysql_fetch_array($resultrr);
	
	       while ($row6 = $db->Next_Record($result6))
			//while ($row6 = mysql_fetch_array($result6))
		   { 
			array_push($subid, $row6['subjectID']);

	?>
<tr>
        <td><?php echo $row6['subjectID'] ?></td>
		<td><?php echo $row6['codeEnglish'] ?></td>
		<td><?php echo $row6['nameEnglish'] ?></td>
		<td><input name="check<?php echo $row6['subjectID'] ?>" id="myCheck" <?php myFunction($row['courseID']); ?>  type="checkbox" value="check<?php echo $row6['subjectID'] ?>" /> </td> 
        </tr>


<?php
	}	}

	elseif($subcrsID == 7)
	{

	       $query7 = "SELECT * FROM subject where subjectID <> '$a5' AND subcrsID = '7' ";
		   $result7 =  $db->executeQuery($query7);
	//$rowrr = mysql_fetch_array($resultrr);
	
	       while ($row7 = $db->Next_Record($result7))
			//while ($row7 = mysql_fetch_array($result7))
		   { 
			array_push($subid, $row7['subjectID']);
?>
<tr>
        <td><?php echo $row7['subjectID'] ?></td>
		<td><?php echo $row7['codeEnglish'] ?></td>
		<td><?php echo $row7['nameEnglish'] ?></td>
		<td><input name="check<?php echo $row7['subjectID'] ?>" id="myCheck" <?php myFunction($row['courseID']); ?>  type="checkbox" value="check<?php echo $row7['subjectID'] ?>" /> </td> 
        </tr>

		<?php
		   }}
		   elseif($subcrsID == 9)
		   {
	   
		   $query8 = "SELECT * FROM subject where subjectID <> '$a6' AND subcrsID = '9' ";
				  $result8 = $db->executeQuery($query8);
		   //$rowrr = mysql_fetch_array($resultrr);
		   
		 	while ($row8 = $db->Next_Record($result8))
				   //while ($row8 = mysql_fetch_array($result8))
				  { 
					array_push($subid, $row8['subjectID']);
		   ?>
<tr>
        <td><?php echo $row8['subjectID'] ?></td>
		<td><?php echo $row8['codeEnglish'] ?></td>
		<td><?php echo $row8['nameEnglish'] ?></td>
		<td><input name="check<?php echo $row8['subjectID'] ?>" id="myCheck" <?php myFunction($row['courseID']); ?>  type="checkbox" value="check<?php echo $row8['subjectID'] ?>" /> </td> 
        </tr>

		<?php
				  }}
				  ?>

	</table>
	


<br/><br/>
<p>
<input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'courseEnroll.php?studentID=<?php echo $studentID; ?>';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
    <!--<input name="btnSubmit" type="Submit" value="Submit"  class="button" style="width:60px;"/>-->
	<input name="btnSubmit" type="Submit" value="Submit"  class="button" style="width:60px; "/>
  
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
	$subcrsrow = $db->Next_Record($subcrsresult);		
	//$subcrsrow = mysql_fetch_array($subcrsresult);
	$valuesubcrsID	 = $subcrsrow['subcrsID'];
	//====
		$regNo = $db->cleanInput($_POST['txtRegNo']);
		$indexNo = $_POST['txtIndexNo'];
		$studentID = $_POST['txtStudentID'];
		$course = $_SESSION['courseId'];
		$yearEntry = $_POST['lstYearEntry'];
		$courseCombID = $_POST['lstCourseComb'];
		$subcrsID = $_POST['subcrsID'];
		
		//print $indexNo ;
		//echo 'aaaa';
		
			$date=$_POST['date'];
			$subjectID = $_POST['subjectID'];
			
if ($indexNo==''){
echo "<script>alert('Index No should not empty')</script>";
}
else {
		
		$resultrow = $db->executeQuery("SELECT * FROM crs_enroll where courseID='".$_SESSION['courseId']."' and  studentID='$studentID'");
	
	$sql="SELECT * FROM `crs_enroll` WHERE `indexNo`= $indexNo";	
	//$sql="SELECT * FROM `crs_enroll`,`subject_enroll` WHERE crs_enroll.`indexNo`= '$indexNo'  AND crs_enroll.Enroll_id = subject_enroll.Enroll_id";	
	
	$result = $db->executeQuery($sql);
	
	if($db->Row_Count($result)>0){
	//if(mysql_num_rows($result)>0){
		
		echo "<script>alert('The indexNo already submited more...')</script>";
		$sql2="SELECT `Enroll_id` FROM `crs_enroll` WHERE `indexNo`= $indexNo";
		$result3 = $db->executeQuery($sql2);
	}
	if($db->Row_Count($result3)>0){
	//if(mysql_num_rows($result3)>0){	
		$rowvalue = $db->Next_Record($result3);
		//$rowvalue = mysql_fetch_array($result3);
		$TestEnroll=$rowvalue['Enroll_id'];
		
		//print($TestEnroll);
		//start a loop
			for($i=0;$i<count($subid);$i++){
	
			if (isset($_POST["check".$subid[$i]]))
			{
			//echo $subid[$i]."  check <br      
			
			$sql3="SELECT * FROM `subject_enroll` WHERE Enroll_id= $TestEnroll AND subjectID = $subid[$i] "  ;
			//print($sql3);
			$result4 = $db->executeQuery($sql3);
		
			     if($db->Row_Count($result4)>0){
				//if(mysql_num_rows($result4)>0){
						
				}
				else{
				$query1 = "INSERT INTO `subject_enroll`(`Enroll_id`, `subjectID`, `enroll_date`) VALUES ($TestEnroll,$subid[$i],'$date')";
				//print $query1; 
				$result1 = $db->executeQuery($query1);
				echo "<script>alert('Course Enrollment was submited')</script>";
				
				header("Location: courseEnroll.php?studentID=$studentID");
				
			}
			}
			}
			
		//end loop
		
		
		
		
	}else{
		
		
		
		
		
	$query = "INSERT INTO crs_enroll SET regNo='$regNo', indexNo='$indexNo', studentID='$studentID', courseID='".$_SESSION['courseId']."', yearEntry='$yearEntry', subcrsID='$subcrsID'";
		$result = $db->executeQuery($query);
		
		$query1="SELECT max(`Enroll_id`) FROM `crs_enroll` ";
		$result1 = $db->executeQuery($query1);
		$subcrsrow1 = $db->Next_Record($result1);
		//$subcrsrow1 = mysql_fetch_array($result1);
		
		
		for($i=0;$i<count($subid);$i++){
	
	if (isset($_POST["check".$subid[$i]]))
	{
		//echo $subid[$i]."  check <br>     
	
		$query1 = "INSERT INTO `subject_enroll`(`Enroll_id`, `subjectID`, `enroll_date`) VALUES ($subcrsrow1[0],$subid[$i],'$date')";
		$result1 = $db->executeQuery($query1);
		echo "<script>alert('New Course Enrollment was submited')</script>";
		
		 header("Location: courseEnroll.php?studentID=$studentID");
		}

	}
	}
		
		//=======================================
		$querystudent = "SELECT * FROM crs_select WHERE  studentID='$studentID'";
				$resultstudent = $db->executeQuery($querystudent);
				for ($i=0;$i<$db->Row_Count($resultstudent);$i++)
				//for ($i=0;$i<mysql_numrows($resultstudent);$i++)
				{
					$CourseIDtable = mysql_result($resultstudent,$i,"courseID");
					//$CourseIDtable = mysql_result($resultstudent,$i,"courseID");
					print $CourseIDtable;
						echo 'aaammm';
					print $course;
					if ($CourseIDtable!=$course){
					//$queryupdate = "UPDATE crs_select SET status='N' where courseID='$CourseIDtable' and studentID='$studentID' ";
					//print $queryupdate;
			//	$result = executeQuery($queryupdate);
					}
				}
		//========================================
		//header("location:courseEnroll.php?studentID=$studentID");
	}
	}
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "New Course Enrollment - Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li><a href='courseEnroll.php?studentID=$studentID'>Course Enrollments </a></li><li>New Course Enrollment</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>