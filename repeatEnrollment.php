<?php
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
	
	function getGrade(marks,row)
	{
		var grade;
		if		(0<=marks && marks<=24)		grade = 'E';
		else if (25<=marks && marks<=29)	grade = 'D';
		else if (30<=marks && marks<=34)	grade = 'D+';
		else if (35<=marks && marks<=39)	grade = 'C-';
		else if (40<=marks && marks<=44)	grade = 'C';
		else if (45<=marks && marks<=49)	grade = 'C+';
		else if (50<=marks && marks<=54)	grade = 'B-';
		else if (55<=marks && marks<=59)	grade = 'B';
		else if (60<=marks && marks<=64)	grade = 'B+';
		else if (65<=marks && marks<=69)	grade = 'A-';
		else if (70<=marks && marks<=84)	grade = 'A';
		else if (85<=marks && marks<=100)	grade = 'A+';
		else grade = '';
		document.getElementById('txtGrade'+row).value = grade;
	}
 </script>
 <?php
  include('dbAccess.php');

$db = new DBOperations();
  
  
  if (isset($_POST['courseID']))
	{
		$courseID=$_POST['courseID'];
	}
	
	if (isset($_POST['subcrsID']))
	{
		$subcrsID=$_POST['subcrsID'];
	}
	if (isset($_POST['acyear']))
	{
		$acyear=$_POST['acyear'];
	}
	if (isset($_POST['exyear']))
	{
		$exyear=$_POST['exyear'];
	}
	
	if (isset($_POST['SubjectID']))
	{
		$SubjectID=$_POST['SubjectID'];
	}
	
  //print $acyear;
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$effortID = $db->cleanInput($_GET['effortID']);
	$delQuery = "DELETE FROM exameffort WHERE effortID='$effortID'";
	$result = $db->executeQuery($delQuery);
  }
  
  //session_start();
  
  if (isset($_POST['btnSubmit']))
	{
		//$indexNo = $_SESSION['indexNo']; 
		///print $indexNo[1];
		//$queryall = "Select * from subject_enroll as s, crs_enroll as c, paymentEnroll as p where s.subjectID='$SubjectID' and s.Enroll_id=c.Enroll_id and c.yearEntry='$acyear' and p.payment1='1' and p.payment2='1' and c.Enroll_id=p.enroll_id ";
		//print $queryall;
        $queryall = "SELECT indexNo, grade FROM exameffort WHERE effort = 1 AND subjectID = '$SubjectID' AND acYear = $acyear AND (marks < 40 OR marks = 'AB' OR withhold = 'WH')";
		//print $queryall;
		//$queryall = "SELECT indexNo, grade FROM exameffort WHERE effort = 1 AND subjectID = '$SubjectID' AND acYear = $acyear AND (marks < 40 OR marks = 'AB') order by indexNo"; 
		$resultall = $db->executeQuery($queryall);
		while ($row=  $db->Next_Record($resultall))
		{
			$indexNo=$row['indexNo'];
		
            $checkQuery = "SELECT COUNT(*) as count FROM crs_enrollR WHERE indexNo = '$indexNo' AND yearEntry = '$acyear' and subcrsID='$subcrsID' and courseID='$courseID'";
            //print $checkQuery;
            $checkResult = $db->executeQuery($checkQuery);
            $count = $db->Next_Record($checkResult)['count'];
      
            if ($count == 0) {

                $regNoQuery = "SELECT regNo,studentID FROM crs_enroll WHERE indexNo = '$indexNo' AND yearEntry = '$acyear'";
                $regNoResult = $db->executeQuery($regNoQuery);
                $regNo = $db->Next_Record($regNoResult)['regNo'];
				$studentID = $db->Next_Record($regNoResult)['studentID'];
    
                    // The subquery returned a non-null value, proceed with the insertion
                    $insertQuery = "INSERT INTO crs_enrollR (regNo, indexNo, studentID, courseID, yearEntry, subcrsID) VALUES ( '$regNo','$indexNo','$studentID','5','$acyear','$subcrsID')";
                    
                   //print $insertQuery;

      $db->executeQuery($insertQuery);
      
                    
            
                

            }

            else{
    
            }
           

            $enrolNoQuery = "SELECT Enroll_id FROM crs_enrollR WHERE indexNo = '$indexNo' AND yearEntry = '$acyear' and subcrsID='$subcrsID' and courseID='$courseID'";
            $enrolNoResult = $db->executeQuery($enrolNoQuery);
            $Enroll_id = $db->Next_Record( $enrolNoResult)['Enroll_id'];


            $checkQuery1 = "SELECT COUNT(*) as count1 FROM subject_enrollR WHERE Enroll_id = '$Enroll_id' AND yearEntry = '$acyear' and subjectID='$SubjectID' ";
            
            $checkResult1 = $db->executeQuery($checkQuery1);
            $count1 = $db->Next_Record($checkResult1)['count1'];
      
            if ($count1 == 0) {
            

            $insertSubjectEnrollrQuery = "INSERT INTO subject_enrollR (Enroll_id, subjectID, enroll_date) VALUES ('$Enroll_id', '$SubjectID', NOW())";

   //print $insertSubjectEnrollrQuery;
    $insertSubjectEnrollrResult = $db->executeQuery($insertSubjectEnrollrQuery);
	//print $i;
            }
			
		}
		//header("location:examAdmin.php");
	}
  
  //$query = $_SESSION['query'];
 
?>

 <h1>Subject Enrollment of Repeat Students</h1>
 <br />
  
<?php
//if ($db->Row_Count($result)>0){
?>
<form method="post" action="" name="form1" id="form1" class="plain">
<br/>
 <table width="230" class="searchResults">
    <tr> 
      <td width="127">Course  :</td>
	 
      <td width="91"><select id="courseID" name="courseID" onchange="document.form1.submit()" >
          <?php
			$query = "SELECT courseID,courseCode FROM course WHERE `courseID` ='" . $_SESSION['courseId'] . "' ";
			$result = $db->executeQuery($query);
			while ($data= $db->Next_Record($result)) 
			{
			  echo '<option value="'.$data['courseID'].'">'.$data['courseCode'].'</option>'; 
			} 
			?>
        </select>
        <script type="text/javascript" language="javascript">
		document.getElementById('courseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
		</script>
      </td>
    </tr>
   
	
	
	<tr>
      <td>SubCourse: </td>
      <td><label>
     	  <?php
	 
								echo '<select name="subcrsID" id="subcrsID"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
								if(isset($courseID)){
									$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_POST['courseID']."' ";
									$result = $db->executeQuery($sql);
									//echo '<option value="all">Select All</option>';
									echo sql;
									while ($row =  $db->Next_Record($result)){
										echo '<option value="'.$row['id'].'">' . $row['description'] . '</option>';
									}
								}
								echo '</select>';// Close drop down box
							?>
							
							 <script>
								document.getElementById('subcrsID').value = "<?php if(isset($subcrsID)) echo $subcrsID;?>";
							</script>
 </label>
		</td>
        
    </tr>
	 
   
    <tr>
      <td>Subject: </td>
      <td><label>
	  <select id="SubjectID" name="SubjectID" onchange="document.form1.submit()" >
              <?php
		if(isset($subcrsID))
		{								
			$sql = "SELECT * FROM `crs_sub` WHERE `courseID` ='" . $_POST['courseID'] . "' ";
            $result = $db->executeQuery($sql);
            if ($db->Row_Count($result) > 0 && isset($subcrsID)) {
                
                if($db->Row_Count($result) == 1){
                    //$sql = "SELECT * FROM `subject` WHERE `courseID` ='" . $_POST['courseID'] . "' order by CAST(suborder AS UNSIGNED)";
					$sql = "SELECT  a.subjectID,a.codeEnglish,a.Compulsary,a.nameEnglish,a.nameSinhala,a.level,a.creditHours,a.suborder FROM subject as a, course as b, crs_subject as c WHERE b.courseID=c.courseID and a.subjectID=c.subjectID and c.courseID='5' and c.subcrsID='$subcrsID'";
                    $result = $db->executeQuery($sql);

                    while ($rowg = $db->Next_Record($result)) {
                        //while ($rowg = mysql_fetch_array($resultg))
                        echo '<option value="' . $rowg['subjectID'] .'">'. $rowg['codeEnglish'] .'--'. $rowg['nameEnglish'] .'</option>';
                    }
                }
                else{
                    $subcrsID = $_POST['subcrsID'];
                    //echo $subcrsID;
                    
                    //$sql = "SELECT * FROM `subject` WHERE `subcrsID` ='" . $subcrsID . "' order by CAST(suborder AS UNSIGNED)";
					$sql = "SELECT  a.subjectID,a.codeEnglish,a.Compulsary,a.nameEnglish,a.nameSinhala,a.level,a.creditHours,a.suborder FROM subject as a, course as b, crs_subject as c WHERE b.courseID=c.courseID and a.subjectID=c.subjectID and c.courseID='5' and c.subcrsID='$subcrsID' ";
                    $result = $db->executeQuery($sql);

                    while ($rowg = $db->Next_Record($result)) {
                        echo '<option value="' . $rowg['subjectID'] .'">'. $rowg['codeEnglish'] .'--'. $rowg['nameEnglish'] .'</option>';
                    }
                }           
            }
		}

			?>
      </select>
        <script type="text/javascript" language="javascript">
		document.getElementById('SubjectID').value="<?php if(isset($SubjectID)){echo $SubjectID;}?>"; 
			</script>
      </label> </td>
    </tr>
	<tr>
      <td>Academic Year: </td>
      <td><label>
     	  <?php
	 
								echo '<select name="acyear" id="acyear"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
		  			
								$sql="SELECT distinct yearEntry FROM crs_enroll order by yearEntry";
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
									
								while ($row =  $db->Next_Record($result)){
									echo '<option value="'.$row['yearEntry'].'">'.$row['yearEntry'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
							
							 <script>
								document.getElementById('acyear').value = "<?php if(isset($acyear)) echo $acyear;?>";
							</script>
 </label>
		</td>
        
    </tr>
	
	</table>
 
 
 
 
 
  <table class="searchResults">
	<tr>
    	<th>Index No.</th><th>Marks/AB/WH</th>
    </tr>
    
<?php


if (isset($_POST['SubjectID']) && isset($_POST['acyear']))
{
	
	

 //$queryall = "Select * from subject_enroll as s, crs_enroll as c, paymentEnroll as p where s.subjectID='$SubjectID' and s.Enroll_id=c.Enroll_id and c.yearEntry='$acyear' and p.payment1='1' and p.payment2='1' and c.Enroll_id=p.enroll_id order by c.indexNo ";
 $queryall = "SELECT indexNo, grade FROM exameffort WHERE effort = 1 AND subjectID = '$SubjectID' AND acYear = $acyear AND (marks < 40 OR marks = 'AB' OR withhold = 'WH') order by indexNo";
 //$queryall = "SELECT indexNo, grade FROM exameffort WHERE effort = 1 AND subjectID = '$SubjectID' AND acYear = $acyear AND (marks < 40 OR marks = 'AB') order by indexNo"; 
//print $queryall;
  $resultall = $db->executeQuery($queryall);
	 
		  				//print 'll';
		  	//		print $query12;
							//$result12 = $db->executeQuery($query12);
	 //$row12=  $db->Next_Record($result12);
  while ($row=$db->Next_Record($resultall))
  {
	  $indexNo=$row['indexNo'];
	 $query12 = "Select * from exameffort where subjectID='$SubjectID' and indexNo='$indexNo' and acYear='$acyear'";  
	 //print $query12;
							$result12 = $db->executeQuery($query12);
	  $row12=$db->Next_Record($result12);
?>
	<tr>
        <td><?php echo $row['indexNo'] ?></td>
        <td><?php echo $row12['marks'] ?></td>
		
	</tr>
<?php
  }
  }
?>
  </table>



  
  <br/><br/>
  <p>
  <input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'examAdmin.php';"  class="button"/>&nbsp;&nbsp;&nbsp;
  <input name="btnSubmit" type="submit" value="Submit" class="button" />
  </p>
  </form>

<script>
	function verifymark(id,value) {
		var val = document.getElementById(id).value
		if (val.match(/[A]/g) == "A" && val.length == 1) {
    		//document.getElementById(id).validity.rangeUnderflow;
    		document.getElementById(id).setCustomValidity("Accept only AB, MD or value from 0 to 100");
			return;
		}
		else if (val.match(/[A]/g) == "A" && val.charAt(1) == "B" && val.length == 2) {
			document.getElementById(id).setCustomValidity("");
			return;
		}
    	if (val.match(/[M]/g) == "M" && val.length == 1) {
        	document.getElementById(id).setCustomValidity("Accept only AB, MD or value from 0 to 100");
			return;
		}
		else if (val.match(/[M]/g) == "M" && val.charAt(1) == "D" && val.length == 2) {
			document.getElementById(id).setCustomValidity("");
			return;
		}
		if (val <= 100 && val >= 0) {
    		document.getElementById(id).setCustomValidity("");
		} else {
			console.log("wrong mark");
			document.getElementById(id).value = "";
			document.getElementById(id).validity.rangeUnderflow;
		}
	}
</script>

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