<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>

<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtAcYear))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
function getAverage(row)
{

	
	var average;
	var grade;
	var gradePoint
	var diff
mark1=document.getElementById('txtMarks1'+row).value;
mark2=document.getElementById('txtMarks2'+row).value;

diff=Math.abs(mark1-mark2);



if(mark1=='AB' && mark2=='AB' ){
	
	document.getElementById('txtMarks'+row).value="AB"
	document.getElementById('txtGrade'+row).value = '';
	document.getElementById('txtGradePoint'+row).value = '';
		}
else if(mark1=='MD' && mark2=='MD'){
	
	document.getElementById('txtMarks'+row).value="AB"
	document.getElementById('txtGrade'+row).value = '';
	document.getElementById('txtGradePoint'+row).value = '';
		}
else {
mark1=eval(mark1);
mark2=eval(mark2);
	average=((mark1+mark2)/2);
	document.getElementById('txtMarks'+row).value=average;
	marks=average;

	
	
if (0<=marks && marks<24) {grade = 'E'; gradePoint='0.0';}
	else if (25<=marks && marks<30) {grade = 'D'; gradePoint='1.0';}
	else if (30<=marks && marks<35) {grade = 'D+'; gradePoint='1.3';}
	else if (35<=marks && marks<40) {grade = 'C-'; gradePoint='1.7';}
	else if (40<=marks && marks<45){ grade = 'C'; gradePoint='2.0';}
	else if (45<=marks && marks<50){ grade = 'C+'; gradePoint='2.3';}
	else if (50<=marks && marks<55){ grade = 'B-'; gradePoint='2.7';}
	else if (55<=marks && marks<60){ grade = 'B'; gradePoint='3.0';}
	else if (60<=marks && marks<65){ grade = 'B+'; gradePoint='3.3';}
	else if (65<=marks && marks<70){ grade = 'A-'; gradePoint='3.7';}
	else if (70<=marks && marks<85){ grade = 'A'; gradePoint='4.0';}
	else if (85<=marks && marks<=100){ grade = 'A+'; gradePoint='4.0';}
	else {grade = ''; gradePoint='';}
	

	document.getElementById('txtGrade'+row).value = grade;
	document.getElementById('txtGradePoint'+row).value = gradePoint;
 
	if(diff>10.0){
	document.getElementById('txtMarks'+row).style.backgroundColor= 'rgb(' + 233 + ',' + 185+ ',' + 193 + ')';
	document.getElementById('txtGrade'+row).style.backgroundColor= 'rgb(' + 233 + ',' + 185+ ',' + 193 + ')';
	document.getElementById('txtGradePoint'+row).style.backgroundColor= 'rgb(' + 233 + ',' + 185+ ',' + 193 + ')';
}
}
}


</script>



<h1>Exam Effort</h1>
<?php
	//2021-03-25 start  include('dbAccess.php');
	require_once("dbAccess.php");
	$db = new DBOperations();
    //2021-03-25 end
  //	include('authcheck.inc.php');
	
	//====================================
	if (isset($_POST['lstFaculty']))
	{
		//$faculty=$_POST['lstFaculty'];
		$faculty = $db->cleanInput($_POST['lstFaculty']);
	}
	
	if (isset($_POST['subSemester']))
	{
	$semester= $db->cleanInput($_POST['subSemester']);
		//$semester=$_POST['subSemester'];
	}
	if (isset($_POST['level']))
	{
	$level = $db->cleanInput($_POST['level']);
		//$level=$_POST['level'];
	}
	if (isset($_POST['lstSubject']))
	
	{
	$SubjectID = $db->cleanInput($_POST['lstSubject']);
		//$SubjectID=$_POST['lstSubject'];
	}
	if (isset($_POST['acyear']))
	{
	$acyear = $db->cleanInput($_POST['acyear']);
		//$acyear=$_POST['acyear'];
	}
	if (isset($_POST['lstMedium']))
	{
	$medium = $db->cleanInput($_POST['lstMedium']);
		//$medium=$_POST['lstMedium'];
	}
	if (isset($_POST['lstEffort']))
	{
	$effort = $db->cleanInput($_POST['lstEffort']);
		//$effort=$_POST['lstEffort'];
	}
	//====================================
	
	if (isset($_POST['btnSubmit']))
	{
		 //$queryall = "Select * from studentenrolment e, student s where e.subjectID='$SubjectID' and e.acYear='$acyear'and s.regNo=e.regNo and confirm_exam='y' order by e.indexNo";
  
		 $queryall = "Select * from studentenrolment e, student s where e.subjectID='$SubjectID' and e.acYear='$acyear'and s.regNo=e.regNo order by e.indexNo";
		 //print  $queryall;
  //2021.03.25 start  $resultall = executeQuery($queryall);
  $resultall = $db->executeQuery($queryall);
  //2021.03.25 end
  //2021.03.25 start  while ($row= mysql_fetch_array($resultall))
  while ($row= $db->Next_Record($resultall))
  //2021.03.25 end
  {
		//$indexNovalue = mysql_result($resultall,$i,'$indexNo');
		//$indexNovalue = $resultall['$indexNo'];
		$indexNovalue=$row['indexNo'] ;
			//$indexNovalue = '20133000';
	//print $indexNovalue;
	  $a=substr($indexNovalue,0,2);
		  $b=substr($indexNovalue,3,4);
		  $c=substr($indexNovalue,8,10);
		  $d=$b.$c;
		  
		  if($a=='BS')
		  $effortid='6683'.$d;
		  if($a=='LS')
		  $effortid='7683'.$d;
			
			//2021-03-25 start  $mark1 = cleanInput($_POST['txtMarks1'.$effortid]);
			$mark1 = $db->cleanInput($_POST['txtMarks1'.$effortid]);
			//2021-03-25 end
			//2021-03-25 start  $mark2 = cleanInput($_POST['txtMarks2'.$effortid]);
			$mark2 = $db->cleanInput($_POST['txtMarks2'.$effortid]);
			//2021-03-25 end
			//2021-03-25 start  $marks = cleanInput($_POST['txtMarks'.$effortid]);
			$marks = $db->cleanInput($_POST['txtMarks'.$effortid]);
			//2021-03-25 end
			//2021-03-25 start  $grade = cleanInput($_POST['txtGrade'.$effortid]);
			$grade = $db->cleanInput($_POST['txtGrade'.$effortid]);
			//2021-03-25 end
			//2021-03-25 start  $gradepoint = cleanInput($_POST['txtGradePoint'.$effortid]);
			$gradepoint = $db->cleanInput($_POST['txtGradePoint'.$effortid]);
			//2021-03-25 end

		//print "Insert into exameffort (indexNo,subjectID,mark1,mark2,marks,grade,gradePoint,acYear,effort,medium) VALUES ('$indexNovalue','$SubjectID','$mark1','$mark2','$marks','$grade','$gradepoint','$acyear','$effort','$medium')";
			//$grade = cleanInput($_POST['txtGrade'.$effortID]);

			//2021-03-25 start  $result = executeQuery("Insert into exameffort (indexNo,subjectID,mark1,mark2,marks,grade,gradePoint,acYear,effort,medium)VALUES ('$indexNovalue','$SubjectID','$mark1','$mark2','$marks','$grade','$gradepoint','$acyear','$effort','$medium')");
			//print $marks1;
			//================================================================================
			
			$query5 = "Select * from exameffort where subjectID='$SubjectID' and indexNo='$indexNovalue' and acYear='$acyear'";
			$result5 = $db->executeQuery( $query5 );
			$rowcount5 = $db->Row_Count( $result5 );
			//print $rowcount5;
			//print $query5;
			if ($rowcount5>0)
			{
				$result = $db->executeQuery("update exameffort set mark1='$mark1',mark2='$mark2',marks='$marks',grade='$grade',gradePoint='$gradepoint' where indexNo='$indexNovalue' and subjectID='$SubjectID' and acYear='$acyear' and effort='$effort'");
			//print ("update exameffort set mark1='$mark1',mark2='$mark2',marks='$marks',grade='$grade',gradePoint='$gradepoint' where indexNo='$indexNovalue' and subjectID='$SubjectID' and acYear='$acyear' and effort='$effort'");
			}
			else{
			//===============================================================================
			if ($mark1==''){
			}
			else{
			$result = $db->executeQuery("Insert into exameffort (indexNo,subjectID,mark1,mark2,marks,grade,gradePoint,acYear,effort)VALUES ('$indexNovalue','$SubjectID','$mark1','$mark2','$marks','$grade','$gradepoint','$acyear','$effort')");
			}
		}
			//2021-03-25 end
            
			//print "Insert into exameffort (indexNo,subjectID,mark1,mark2,marks,grade,gradePoint,acYear,effort)VALUES ($indexNovalue,$SubjectID,'$mark1','$mark2','$marks',$grade,$gradepoint,$acyear,$effort)";
		}
		//header("location:examAdmin.php");
	}
?>
<form method="post" name="form1" id="form1" action="" onsubmit="return validate_form(this);" class="plain">
<table class="searchResults">
   <tr>
    	
      <td height="28">Faculty : </td>
      <!-- <td><select name="lstFaculty" id="lstFaculty" onchange="document.form1.submit()"> -->
	  <td><select name="lstFaculty" id="lstFaculty" onchange="form1.submit()">

        	<option value="Buddhist">Buddhist Studies</option>
        	<option value="Language">Language Studies</option>
        </select>
		<script>
								document.getElementById('lstFaculty').value = "<?php echo $faculty;?>";
							</script>
		
		</td>
    </tr>
    <tr>
    	<td>Level : </td>
		<!-- <td><select name="level" id="level" onchange="document.form1.submit()">  -->
		 <td><select name="level" id="level" onchange="form1.submit()"> 

        	<option value="I">Level One</option>
        	<option value="II">Level Two</option>
			<option value="III">Level Three</option>
        	<option value="IV">Level Four</option>
        </select>
		<script>
								document.getElementById('level').value = "<?php echo $level;?>";
							</script> 
		</td>
    </tr>
	<tr>
    	
      <td>Semester : </td>
      <!-- <td><select name="subSemester" id="subSemester" onchange="document.form1.submit()"> -->
	  <td><select name="subSemester" id="subSemester" onchange="form1.submit()">

        	<option value="First Semester">First Semester</option>
        	<option value="Second Semester">Second Semester</option>
        </select>
			<script>
		
								document.getElementById('subSemester').value = "<?php echo $semester;?>";
							</script> 
		</td>
    </tr>
	<tr>
    <tr>
    	<td>Subject : </td>
        <!-- <td><select name="lstSubject" id="lstSubject" style="width:auto" onchange="document.form1.submit()"> -->
		<td><select name="lstSubject" id="lstSubject" style="width:auto" onchange="form1.submit()">>

        	<?php
			
			$query = "SELECT * FROM subject WHERE faculty='$faculty' and level='$level' and semester='$semester'";
			// print $query;
			//2021-03-25 start  $result = executeQuery($query);
			$result = $db->executeQuery($query);
			//2021.03.25 end
			//2021-03-25 start  for ($i=0;$i<mysql_num_rows($result);$i++)
			
			// for ($i=0;$i<$db->Row_Count($result);$i++)
			while($data=$db->Next_Record($result))
				
			//2021.03.25 end
			{
				$rID = $data["subjectID"];
				$rCode = $data["codeEnglish"];
				$rSubject =$data["nameEnglish"];
              	echo "<option value=\"".$rID."\">".$rCode." - ".$rSubject."</option>";
        	} 
			?>
        	</select>
			<script>
								document.getElementById('lstSubject').value = '<?php echo $SubjectID;?>';
							</script> 
        </td>
    </tr>
   <tr>
      <td>Academic Year:</td>
      <td><label>
     	  <?php
	 							// echo '<select name="acyear" id="acyear"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
								echo '<select name="acyear" id="acyear" onChange="form1.submit()"  class="form-control">'; // Open your drop down box
								$sql="SELECT distinct acYear FROM studentenrolment";
								//2021-03-25 start  $result = executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								while ($row=$db->Next_Record($result))
								{
								//2021-03-25 start  while ($row = mysql_fetch_array($result)){
									echo '<option value="'.$row['acYear'].'">'.$row['acYear'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
							
							  <script>
								document.getElementById('acyear').value = "<?php echo $acyear;?>";
							</script> 
 </label>
		</td>
        
    </tr>
    <tr>
    	<td>Medium : </td><td>
        	<!-- <select name="lstMedium" id="lstMedium" size="auto" onChange="document.form1.submit()"> -->
			<select name="lstMedium" id="lstMedium" size="auto" >

            	<option value="English">English</option>
                <option value="Sinhala">Sinhala</option>
            </select>
			<!-- <script>
								document.getElementById('lstMedium').value = "<?php echo $medium;?>";
							</script> -->
       	</td>
    </tr>
	
    <tr>
    	<td>Effort : </td><td><select name="lstEffort" id="lstEffort">
        	<option value="1">1</option>
        	<option value="2">2</option>
            <option value="3">3</option>
        </select></td>
    </tr>
</table>
 <table class="searchResults">
	<tr>
    	<th>Index No.</th><th>Mark 1</th><th>Mark 2</th><th>Marks</th><th>Grade</th><th>Grade Point</th>
    </tr>
    
<?php
 //$queryall = "Select * from subject_enroll as s, crs_enroll as c where s.subjectID='$SubjectID' and s.Enroll_id=c.Enroll_id and yearEntry='$acyear' order by c.indexNo";
//print $queryall;
  //$queryall = "Select * from studentenrolment e, student s where e.subjectID='$SubjectID' and e.acYear='$acyear' and s.regNo=e.regNo and confirm_exam='y' order by e.indexNo";
  $queryall = "Select * from studentenrolment e, student s where e.subjectID='$SubjectID' and e.acYear='$acyear' and s.regNo=e.regNo order by e.indexNo"; 
 
  //print  $queryall;
  //2021.03.25 start  $resultall = executeQuery($queryall);
  $resultall = $db->executeQuery($queryall);
  //2021.03.25 end
  //2021.03.25 start  while ($row= mysql_fetch_array($resultall))
  while ($row= $db->Next_Record($resultall))
  //2021.03.25 end
  {
?>
	<tr>
        
		<?php
		
		$u=$row['indexNo'] ;
		$querymark1 = "Select * from exameffort where subjectID='$SubjectID' and indexNo='$u' and acYear='$acyear'";
		//print $querymark1;
		 //2021.03.25 start  $resultmark = executeQuery($querymark1);
		 $resultmark = $db->executeQuery($querymark1);
		 //2021.03.25 end
		 //2021.03.25 start  $rowmark= mysql_fetch_array($resultmark);
		 $rowmark= $db->Next_Record($resultmark);
		 //2021.03.25 end
		  $a=substr($u,0,2);
		  $b=substr($u,3,4);
		  $c=substr($u,8,10);
		  $d=$b.$c;
		  
		  if($a=='BS')
		  $effortid='6683'.$d;
		  if($a=='LS')
		  $effortid='7683'.$d;
		  
		  //print  $effortid;
		
	
		 ?>
		 <td><?php echo $row['indexNo'] ?></td>
     
		<td><input  size="4" name="txtMarks1<?php echo $effortid; ?>" id="txtMarks1<?php echo $effortid;  ?>" value="<?php echo $rowmark['mark1'] ?>" type="text" /></td>
        <td><input  size="4" name="txtMarks2<?php echo $effortid ?>" id="txtMarks2<?php echo  $effortid ?>" value="<?php echo $rowmark['mark2'] ?>" onChange="getAverage(<?php echo  $effortid ?>)" type="text" /></td>
        <td><input size="4" name="txtMarks<?php echo  $effortid ?>" id="txtMarks<?php echo  $effortid ?>" value="<?php echo $rowmark['marks'] ?>" type="text" /></td> 		
		<td><input size="4" name="txtGrade<?php echo  $effortid ?>" id="txtGrade<?php echo  $effortid ?>" value="<?php echo $rowmark['grade'] ?>" type="text" /></td>
		
		<td><input size="4" name="txtGradePoint<?php echo $effortid ?>" id="txtGradePoint<?php echo  $effortid ?>" value="<?php echo $rowmark['gradePoint'] ?>" type="text" /></td>
  
  			
        
        
	</tr>
<?php

  }
?>
  </table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'examAdmin.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" /></p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "New Effort - Exam Efforts - Student Management System - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='examAdmin.php'>Exam Efforts </a></li><li>New Effort</li></ul>";
  //Apply the template
  include("master_registration.php");
?>