F<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
  
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
?>

 
 <script language="javascript">
 	function MsgOkCancel()	{

		var message = "Please confirm to DELETE this entry...";
		var return_value = confirm(message);
		return return_value;
	}
	
	function getGrade(mark1,mark2,row)
	{
		var grade;
		var gradePoint;
		
if(mark1=='AB'){
	
	
	document.getElementById('txtMarks'+row).value='AB';
	grade = '';
		gradePoint='';
		document.getElementById('txtGrade'+row).value = grade;
	document.getElementById('txtGradePoint'+row).value = gradePoint;
		}
if(mark1=='MD'){
	
	
	document.getElementById('txtMarks'+row).value='MD';
	grade = '';
	gradePoint='';
	document.getElementById('txtGrade'+row).value = grade;
	document.getElementById('txtGradePoint'+row).value = gradePoint;
		
		}
else{
		
	var average;
	mark1=eval(mark1);
	mark2=eval(mark2);
		

	average=((mark1+mark2)/2);
	

	document.getElementById('txtMarks'+row).value=average;
	marks=average;
	if (0<=marks && marks<=24) {grade = 'E'; gradePoint='0.0';}
	else if (25<=marks && marks<=29) {grade = 'D'; gradePoint='1.0';}
	else if (30<=marks && marks<=34) {grade = 'D+'; gradePoint='1.3';}
	else if (35<=marks && marks<=39) {grade = 'C-'; gradePoint='1.7';}
	else if (40<=marks && marks<=44) {grade = 'C'; gradePoint='2.0';}
	else if (45<=marks && marks<=49) {grade = 'C+'; gradePoint='2.3';}
	else if (50<=marks && marks<=54) {grade = 'B-'; gradePoint='2.7';}
	else if (55<=marks && marks<=59) {grade = 'B'; gradePoint='3.0';}
	else if (60<=marks && marks<=64) {grade = 'B+'; gradePoint='3.3';}
	else if (65<=marks && marks<=69) {grade = 'A-'; gradePoint='3.7';}
	else if (70<=marks && marks<=84) {grade = 'A'; gradePoint='4.0';}
	else if (85<=marks && marks<=100) {grade = 'A+'; gradePoint='4.0';}
	else grade = '';
	
	document.getElementById('txtGrade'+row).value = grade;
	document.getElementById('txtGradePoint'+row).value = gradePoint;
		}
	}
 </script>
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
	if (isset($_POST['acyear']))
	{
		$acyear=$_POST['acyear'];
	}
	if (isset($_POST['SubjectID']))
	{
		$SubjectID=$_POST['SubjectID'];
	}
	
  //print $acyear;
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$effortID = $db->cleanInput($_GET['effortID']);
	$delQuery = "DELETE FROM exameffortR WHERE effortID='$effortID'";
	$result = $db->executeQuery($delQuery);
  }
  
  session_start();
  
  if (isset($_POST['btnSubmit']))
	{
		$indexNo = $_SESSION['indexNo']; 
		///print $indexNo[1];
		$queryall = "Select * from  crs_enrollR as c, paymentEnrollR as p where yearEntry='$acyear' and p.payment1='1' and p.payment2='1' and c.Enroll_id=p.enroll_id ";
//print $queryall;
  $resultall = $db->executeQuery($queryall);
		for ($i=0;$i<$db->Row_Count($resultall);$i++)
		{
		$indexNovalue = $indexNo[$i];
		$querymark1 = "Select * from exameffortR where indexNo=$indexNovalue and acYear='$acyear'";
		 $resultmark = $db->executeQuery($querymark1);
		 $rowmark=  $db->Next_Record($resultmark);
		 $effortvalue = $rowmark['effortID'];
			
		
			$mark2 = $db->cleanInput($_POST['txtMarks2'. $effortvalue]);
			$marks = $db->cleanInput($_POST['txtMarks'. $effortvalue]);
					
			//$grade = $db->cleanInput($_POST['txtGrade'.$effortID]);
			$result = $db->executeQuery("UPDATE exameffortR set mark2='$mark2',marks='$marks',effort='1' where effortID='$effortvalue' ");
			//print "INSERT INTO exameffort (indexNo,subjectID,mark1)VALUES($indexNovalue,$SubjectID,$marks,$acyear)";
		}
		header("location:examAdmin.php");
	}
  
  //$query = $_SESSION['query'];
 
?>

 <h1>Enter Results</h1>
 <br />
  
<?php
//if ($db->Row_Count($result)>0){
?>
<form method="post" action="" name="form1" id="form1" class="plain">
<br/>
  <table width="230" class="searchResults">
    <tr> 
      <td width="127">Course :</td>
      <td width="91"><select id="CourseID" name="CourseID" onchange="document.form1.submit()" >
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
        </select> <script type="text/javascript" language="javascript">
		document.getElementById('CourseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
		</script> </td>
    </tr>
    <tr> 
      <td>SubCourse: </td>
      <td><label> 
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
        </label> </td>
    </tr>
    <tr> 
      <td>Academic Year: </td>
      <td><label> 
        <?php
	 
								echo '<select name="acyear" id="acyear"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
								$sql="SELECT distinct yearEntry FROM crs_enrollR";
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								
								while ($row =  $db->Next_Record($result)){
									echo '<option value="'.$row['yearEntry'].'">'.$row['yearEntry'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
        <script>
								document.getElementById('acyear').value = "<?php echo $acyear;?>";
							</script>
        </label> </td>
    </tr>
  </table>
 
 
 
 
 
  <table class="searchResults">
	<tr>
    	<th>Index No.</th><th>Topic</th><th>Progress 1</th><th>Progress 2</th><th>Progress </th>
    </tr>
    
<?php
 $queryall = "Select * from  crs_enrollR as c, paymentEnrollR as p where yearEntry='$acyear' and p.payment1='1' and p.payment2='1' and c.Enroll_id=p.enroll_id ";
//print $queryall;
  $resultall = $db->executeQuery($queryall);
  while ($row=  $db->Next_Record($resultall))
  {
?>
	<tr>
        
		<?php
		
		$u=$row['indexNo'] ;
		  //=======================================
	  $querytopic = "Select * from subject_R where indexNo=$indexNo and acYear='$acyear'";  
	  //print $query12;
							$resulttopic = $db->executeQuery($querytopic);
	  $rowtopic=  $db->Next_Record($resulttopic);
	  
	  //=======================================
		$querymark1 = "Select * from exameffortR where indexNo=$u and acYear='$acyear'";
		 $resultmark = $db->executeQuery($querymark1);
		 $rowmark=  $db->Next_Record($resultmark);
		
		if ($rowmark['mark1']==''){
		
		}
		else {
		 ?>
		 <td><?php echo $row['indexNo'] ?></td>
		<td><?php echo $rowtopic['topic'] ?></td>
     	<td><?php echo $rowmark['mark1'] ?></td>
        <td><input  size="4" name="txtMarks2<?php echo $rowmark['effortID'] ?>" value="<?php echo $rowmark['mark2'] ?>" onkeyup="getGrade(this.value,<?php echo $rowmark['mark1'] ?>,<?php echo $rowmark['effortID'] ?>)" type="text" /></td>
        <td><input size="4" name="txtMarks<?php echo $rowmark['effortID'] ?>" id="txtMarks<?php echo $rowmark['effortID'] ?>" value="<?php echo $rowmark['marks'] ?>" type="text" /></td>
		
  			
        
        
	</tr>
<?php
}
  }
?>
  </table>
  <?php
  	$indexNo = array();
  	for ($i=0;$i<$db->Row_Count($resultall);$i++)
	{
			$indexNo[$i] = mysql_result($resultall,$i,"indexNo");
			//print $indexNo[$i] ;
	}
	$_SESSION['indexNo'] = $indexNo;
  ?>
  <br/><br/>
  <p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'examAdmin.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" /></p>
  </form>

<?php 
//}else echo "<p>No exam details available.</p>";

  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Enter Results - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='examAdmin.php'>Exam Efforts </a></li><li>Enter Results</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>