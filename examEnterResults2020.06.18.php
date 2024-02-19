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
	
	function getGrade(marks,row)
	{
		var grade;
		if (0<=marks && marks<=29) grade = 'E';
		else if (30<=marks && marks<=39) grade = 'D';
		else if (40<=marks && marks<=54) grade = 'C';
		else if (55<=marks && marks<=69) grade = 'B';
		else if (70<=marks && marks<=100) grade = 'A';
		else grade = '';
		document.getElementById('txtGrade'+row).value = grade;
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
	$delQuery = "DELETE FROM exameffort WHERE effortID='$effortID'";
	$result = $db->executeQuery($delQuery);
  }
  
  session_start();
  
  if (isset($_POST['btnSubmit']))
	{
		$indexNo = $_SESSION['indexNo']; 
		///print $indexNo[1];
		$queryall = "Select * from subject_enroll as s, crs_enroll as c where s.subjectID='$SubjectID' and s.Enroll_id=c.Enroll_id and yearEntry='$acyear'";
  //print $queryall;
  $resultall = $db->executeQuery($queryall);
		for ($i=0;$i<$db->Row_Count($resultall);$i++)
		{
		
			$indexNovalue = $indexNo[$i];
		
			$marks = $db->cleanInput($_POST['txtMarks'.$indexNovalue]);
			//print $marks ;
			//print 'g';
		$queryexist = "Select * from exameffort where subjectID='$SubjectID' and indexNo=$indexNovalue and acYear='$acyear'";
			
			$resultexist = $db->executeQuery($queryexist);
			 $roweffort=  $db->Next_Record($resultexist);
			 $effortvalue=$roweffort['effortID'];
			
			 $value= $db->Row_Count($resultexist);

			
			//if ($marks!=0){

			if ($db->Row_Count($resultexist)==0)
{
				print "INSERT INTO exameffort (indexNo,subjectID,mark1,acYear)VALUES($indexNovalue,$SubjectID,$marks,$acyear)";
			$resultinsert = $db->executeQuery("INSERT INTO exameffort (indexNo,subjectID,mark1,acYear)VALUES($indexNovalue,$SubjectID,$marks,$acyear)");
			
			//}
		
			}
			else{
			
			print "UPDATE exameffort set mark1=$marks where effortID='$effortvalue'";
			$resultupdate = $db->executeQuery("UPDATE exameffort set mark1=$marks where effortID='$effortvalue'") ;
			}
			//}
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
      <td width="127">Course  :</td>
	 
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
        </select>
        <script type="text/javascript" language="javascript">
		document.getElementById('CourseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
		</script>
      </td>
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
 </label>
		</td>
        
    </tr>
	 
   
    <tr>
      <td>Subject: </td>
      <td><label>
	  <select id="SubjectID" name="SubjectID" onchange="document.form1.submit()" >
              <?php
		if(isset($courseID))
		{
		
			//$query2 = "SELECT subjectID,nameEnglish,codeEnglish FROM subject Where `courseID` ='".$_SESSION['courseId']."' ;";
		$query2 = "SELECT * FROM crs_subject WHERE CourseID='".$_SESSION['courseId']."' AND `subcrsid`='$subcrsID' order by compulsary  ";
			$result2 = $db->executeQuery($query2);
			while ($data2= $db->Next_Record($result2)) 
			{
			$subjectid=$data2[3];
				$query22="SELECT subjectID,nameEnglish,codeEnglish FROM subject Where `subjectID` ='$subjectid'";
				$result22= $db->executeQuery($query22);
				$data22= $db->Next_Record($result22);
				
			echo '<option value="'.$data22[0].'">'.$data22[2].'--'.$data22[1].'</option>';
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
		  			
								$sql="SELECT distinct yearEntry FROM crs_enroll";
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
 </label>
		</td>
        
    </tr>
	</table>
 
 
 
 
 
  <table class="searchResults">
	<tr>
    	<th>Index No.</th><th>Marks</th>
    </tr>
    
<?php
 $queryall = "Select * from subject_enroll as s, crs_enroll as c where s.subjectID='$SubjectID' and s.Enroll_id=c.Enroll_id and yearEntry='$acyear'";
//print $queryall;
  $resultall = $db->executeQuery($queryall);
	 
		  				//print 'll';
		  			//print $query12;
							//$result12 = $db->executeQuery($query12);
	 $row12=  $db->Next_Record($result12);
  while ($row=  $db->Next_Record($resultall))
  {
	  $indexNo=$row['indexNo'];
	 $query12 = "Select * from exameffort where subjectID='$SubjectID' and indexNo=$indexNo 	and acYear='$acyear'";  
	 // print $query12;
							$result12 = $db->executeQuery($query12);
	  $row12=  $db->Next_Record($result12);
?>
	<tr>
        <td><?php echo $row['indexNo'] ?></td>
		
   
        <td><input name="txtMarks<?php echo $row['indexNo'] ?>" value="<?php echo $row12['mark1'] ?>" )" type="text" /> </td>

        
        
	</tr>
<?php
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