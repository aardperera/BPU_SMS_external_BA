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
	$queryall = "Select * from crs_enroll where  yearEntry='$acyear' and courseID='".$_SESSION['courseId']."'  and subcrsID='$subcrsID'";

  $resultall = $db->executeQuery($queryall);
	 
	

	while ($row =  $db->Next_Record($resultall))
	{
		$Enrollid = $row['Enroll_id'];

		$queryexist = "Select * from paymentEnrollBA where enroll_id='$Enrollid'";
		//echo $queryexist . '<br/>';
		$resultexist = $db->executeQuery($queryexist);

		$value = $db->Row_Count($resultexist);
 if($value==0){
if ( isset( $_POST[ 'checkBox1' . $Enrollid] ) ) {
$resultinsert = $db->executeQuery("INSERT INTO paymentEnrollBA (enroll_id,payment1)VALUES($Enrollid,'1')");
print "INSERT INTO paymentEnrollBA (enroll_id,payment1)VALUES($Enrollid,'1')";
}
else{
$resultinsert = $db->executeQuery("INSERT INTO paymentEnrollBA (enroll_id,payment1)VALUES($Enrollid,'0')");
}
if ( isset( $_POST[ 'checkBox2' . $Enrollid] ) ) {
$resultinsert = $db->executeQuery("UPDATE paymentEnrollBA SET payment2='1' where enroll_id='$Enrollid' ");

}
else{
$resultinsert = $db->executeQuery("UPDATE paymentEnrollBA SET payment2='0' where enroll_id='$Enrollid' ");
}
}
else{
if ( isset( $_POST[ 'checkBox1' . $Enrollid] ) ) {
$resultinsert = $db->executeQuery("UPDATE paymentEnrollBA SET payment1='1' where enroll_id='$Enrollid'");

}
else{
$resultinsert = $db->executeQuery("UPDATE paymentEnrollBA SET payment1='0' where enroll_id='$Enrollid'");
}
if ( isset( $_POST[ 'checkBox2' . $Enrollid] ) ) {
$resultinsert = $db->executeQuery("UPDATE paymentEnrollBA SET payment2='1' where enroll_id='$Enrollid' ");

}
else{
$resultinsert = $db->executeQuery("UPDATE paymentEnrollBA SET payment2='0' where enroll_id='$Enrollid' ");
}
}
}
  }
	
	print "UPDATE paymentEnrollBA SET payment2='1' where enroll_id='$Enrollid' ";
  
  //$query = $_SESSION['query'];
 
?>

 <h1>Enter Payment Details</h1>
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
	
	
	</table>
 
 
 <p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'examAdmin.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" /></p>
 
 
  <table class="searchResults">
	  
	  
	<tr>
    	<th>Registration No.</th><th>Frist Payment </th> <th>Second Payment </th>
    </tr>
    
<?php
 $queryall = "Select * from crs_enroll where  yearEntry='$acyear' and courseID='".$_SESSION['courseId']."'  and subcrsID='$subcrsID'";
	  print $queryall;

  $resultall = $db->executeQuery($queryall);
	 
		  				//print 'll';
		  //			print $query12;
							//$result12 = $db->executeQuery($query12);
	 $row12=  $db->Next_Record($result12);
  while ($row=  $db->Next_Record($resultall))
  {
	  $indexNo=$row['indexNo'];
	  $Enrollid = $row[ 'Enroll_id' ];
	 //$query12 = "Select regNo from exameffort where subjectID='$SubjectID' and indexNo=$indexNo 	and acYear='$acyear'";  
	  //print $query12;
							//$result12 = $db->executeQuery($query12);
	 // $row12=  $db->Next_Record($result12);
?>
	<tr>
        <td><?php echo $row['regNo'] ?></td>
		<?php
			$Enrollid = $row[ 'Enroll_id' ];
			$queryexist = "Select * from paymentEnrollBA where enroll_id='$Enrollid'";

			$resultexist = $db->executeQuery($queryexist);

			$value= $db->Row_Count($resultexist);
			$row = $db->Next_Record($resultexist);

		?>
		
		 <td>
                <center>
                    <input type='checkBox' name="checkBox1<?php echo $Enrollid ?>" id="checkBox1<?php echo $Enrollid ?>" value="checkBox1<?php echo $Enrollid ?>" <?php if($row[1]==1) echo 'checked'?> />
                </center>
            </td>

   
        <td>
                <center>
                    <input type='checkBox' name="checkBox2<?php echo $Enrollid ?>" id="checkBox2<?php echo $Enrollid ?>" value="checkBox1<?php echo $row[0] ?>" <?php if($row[2]==1) echo 'checked'?> />
                </center>
            </td>

        
        
	</tr>
<?php
  }
?>
  </table>
  <?php
	/*
  	$indexNo = array();
  	for ($i=0;$i<$db->Row_Count($resultall);$i++)
	{
			$indexNo[$i] = mysql_result($resultall,$i,"indexNo");
			//print $indexNo[$i] ;
	}
	$_SESSION['indexNo'] = $indexNo; */
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