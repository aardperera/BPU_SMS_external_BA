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
	if (isset($_POST['indexNo']))
	{
		$indexNo=$_POST['indexNo'];
	
	}
	
  //print $acyear;
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$effortID = $db->cleanInput($_GET['effortID']);
	$delQuery = "DELETE FROM exameffort WHERE effortID='$effortID'";
	$result = $db->executeQuery($delQuery);
  }
  
  session_start();
  //$enrollid=array();
 
 
  if (isset($_POST['btnSubmit']))
  {
			  
		  header("location:transcript3.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&indexNo=$indexNo");
  }
	
  
  //$query = $_SESSION['query'];
 
?>

 
<h1>Generate Transcript</h1>
 <br />
  
<?php
//if ($db->Row_Count($result)>0){
?>
<form method="post" action="" name="form1" id="form1" class="plain">
<br/>
 <table width="230" class="searchResults">
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
      <td>Index No.: </td>  
      <td><label>
     	  <?php
	 
								echo '<select name="indexNo" id="indexNo"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
								$sql="SELECT * FROM `crs_enroll` WHERE `courseID` ='".$_SESSION['courseId']."' and subcrsID='$subcrsID' and yearEntry='$acyear' ";
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								
								while ($row =  $db->Next_Record($result)){
									echo '<option value="'.$row['indexNo'].'">'.$row['indexNo'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
							
							 <script>
								document.getElementById('indexNo').value = "<?php echo $indexNo;?>";
							</script>
 </label>
		</td>
        
    </tr>
	<tr><td><p><input name="btnSubmit" type="submit" value="View Report" class="button" /></p></td></tr>
    
	</table>
 
 
 
 
 
  <!-- <table class="searchResults">
	<tr>
    <th>Subjects Code</th><th>Subject Name</th> 
    </tr> -->
    
<?php
 $queryall = "Select * from crs_enroll c,subject_enroll s,subject j where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.Enroll_id=s.Enroll_id and c.indexNo='$indexNo' and j.subjectID=s.subjectID ";
//print $queryall;
  $resultall = $db->executeQuery($queryall);
	 
		  				//print 'll';
		  //			print $query12;
							//$result12 = $db->executeQuery($query12);
	 $row12=  $db->Next_Record($result12);
  while ($row=  $db->Next_Record($resultall))
  {
	/* 
	  $courseID=$row['courseID'];
	  $indexNo=$row['indexNo'];
	   
	   $enrollID=$row['Enroll_id'];
	  
	  $queryexist2 = "Select * from admission_list where indexNo='$indexNo' and courseID='$courseID' and subcrsID= '$subcrsID' and yearEntry='$acyear'";
			//*print $queryexist;
			$resultexist2 = $db->executeQuery($queryexist2);
			
			 $value2= $db->Row_Count($resultexist2);
			 if($value2==0){
	  
	 
	 $resultinsert = $db->executeQuery("INSERT INTO admission_list (indexNo,courseID,subcrsID,yearEntry) VALUES ($indexNo,$courseID,$subcrsID,$acyear)");
			 }
	   $queryall5 = "Select * from subject_enroll c,subject s where  c.subjectID=s.subjectID and c.Enroll_id='$enrollID'";
	 // print  $queryall5;
  $resultall5 = $db->executeQuery($queryall5);
	  // $row5=  $db->Next_Record($result5);
	  $a=0;
	  $subjectIDAll=0;
  while ($row5=  $db->Next_Record($resultall5)){
	  $subjectID=$row5['subjectID'];
	  $a=$a+1;
	  //print 'kkk';
	 // print $subjectID;
	  //print 'lll';
	  if ($a==1){
		  $subjectIDAll=$subjectIDAll.$row5[codeEnglish]; 
	  }
	  else{
		  $subjectIDAll=$subjectIDAll.','.$row5[codeEnglish];
		  }
	  
	  //print  $subjectIDAll;
  }

							//$result12 = $db->executeQuery($query12);
	 // $row12=  $db->Next_Record($result12); */
?>
	<!-- <tr>
      
		 <td><?php //echo $row['codeEnglish'] ?></td>
		   <td><?php //echo $row['nameEnglish']?></td>
		
		

       
	</tr> -->
<?php
  }
?>
  <!-- </table> -->
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
  
  </form>

<?php 
//}else echo "<p>No exam details available.</p>";

  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Transcript - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='index.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>Transcript</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>