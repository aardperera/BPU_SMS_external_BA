<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
?>

<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtCodeEnglish) || !validate_required(txtNameEnglish))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
</script>

<h1>Subject Mapping</h1>
<?php
	include('dbAccess.php');
	$db = new DBOperations();

 // 	include('authcheck.inc.php');
 if (isset($_POST['delMapBut']))
	{
	 
	 $deleteID=$_POST['deletemap'];
 	 $query = "DELETE FROM map_sub_to_years WHERE id = $deleteID";
		$result = $db->executeQuery($query);
			echo "<script>alert('Subject Combination Successfully Deleted!')</script>";
 
 	}
 
 if (isset($_POST['courseID']))
	{$courseID=$_POST['courseID'];}
 
	
	if (isset($_POST['btnSubmit']))
	{
	   
		$subject1 = $_POST['subject1'];
		$subject2 = $_POST['subject2'];
		$subject3 = $_POST['subject3'];
		$frmdate = $_POST['frmdate'];
		$todate = $_POST['todate'];
		
		
		
		 $query2 = "SELECT * FROM `map_sub_to_years` WHERE first_subid = '$subject1' AND (from_date<='$frmdate' AND to_date>='$frmdate') ";
		 //$numRows2 = mysql_num_rows(executeQuery($query2));
		 $numRows2 = $db->Row_Count($db->executeQuery($query2));

		 
		 if ($numRows2>0){
			 echo "<script>alert('This is not allowed, Please input correct data!')</script>";
			 
		 }
		else
		{
		
		$query = "INSERT INTO map_sub_to_years (from_date,to_date,first_subid,second_subid,third_subid) VALUES('$frmdate','$todate','$subject1','$subject2','$subject3')";
		$result = $db->executeQuery($query);
			echo "<script>alert('Subject Combination Successfully Added!')</script>";
		//header("location:subjectAdmin.php");
		//header("location:message.php?message=Successfully inserted!");
			//print $_SESSION['courseID'] ;
	
	}
	}
?>
<form id="form1" name="form1" method="post" action="" class="plain">
<table class="searchResults">
    <tr>
      <td>CourseID</td>
      <td>
	  <select id="course" name="course" onchange="document.form1.submit()" >
      <option value="">---</option>
          <?php
			$query = "SELECT courseID,courseCode FROM course WHERE `courseID` ='".$_SESSION['courseId']."'";
			//SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
			$result = $db->executeQuery($query);
			//while ($data=mysql_fetch_array($result)) 
			while ($data=$db->Next_Record($result))

			{
			echo '<option value="'.$data[0].'">'.$data[1].'</option>';
        	} 
			?>
        </select>
               
        </td>
    </tr>
	<tr>
    	<td>From Date : </td><td><input id="frmdate" name="frmdate" type="date" value="2018-01-01" /></td>
    </tr>
    <tr>
    	<td>To Date : </td><td><input name="todate" id="todate" type="date" value="2100-12-31" /></td>
    </tr>
	
	<?php
	if (isset($_POST['course']))
	{
		$courseids = $_POST['course'];
		$frmdate = $_POST['frmdate'];
		$todate = $_POST['todate'];
		?>
	<script>document.getElementById('course').value = '<?php echo($courseids); ?>'</script>
	<?php
	if ($frmdate!='')
	{
	?><script>document.getElementById('frmdate').value = '<?php echo($frmdate); ?>'</script><?php
	}
	?>
	
	<?php
	if ($todate!='')
	{
	?><script>document.getElementById('todate').value = '<?php echo($todate); ?>'</script><?php
	}
	?>
	
	<?php
		
			$query123 = "SELECT * FROM `crs_sub` WHERE `courseID` = '$courseids' ORDER BY `subcrsID` ASC;";
			//SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
			$result123 = $db->executeQuery($query123);
			//while ($data=mysql_fetch_array($result))
		$axj = 0;
			while ($data123=$db->Next_Record($result123))

			{
				$axj++;
				?>
	<tr>
    	<td><?php echo $data123['description'];?>: </td>
		<td>
		<select id="subject<?php echo($axj);?>" name="subject<?php echo($axj);?>" onchange="document.form1.submit()" >
      <option value="">---</option>
          <?php
				
				$query2 = "SELECT s.subjectID,s.nameEnglish,s.codeEnglish FROM subject AS s, crs_subject AS cs  Where s.subjectID = cs.subjectID AND cs.subcrsid ='".$data123['id']."' order by s.codeEnglish;";
		
			$result2 = $db->executeQuery($query2);
			//while ($data2=mysql_fetch_array($result2)) 
			while ($data2=$db->Next_Record($result2))
			{
			echo '<option value="'.$data2['subjectID'].'">'.$data2['codeEnglish'].'--'.$data2['nameEnglish'].'</option>';
        	}  
			?>
        </select>
		
		</td>
    </tr>
	
	<?php
				if (isset($_POST['subject'.$axj]))
				{
					${'SUBJ' . $axj} = $_POST['subject'.$axj];
					//$SUBJ.$axj = $_POST['subject'.$axj];
					?>
	<script>document.getElementById('subject<?php echo($axj);?>').value = '<?php echo(${'SUBJ' . $axj}); ?>'</script>
	<?php
				}
        	} 
	}
			?>
	
	
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'subjectAdmin.php';"  class="button"style="width:60px;"//>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;"//></p>
</form>

<?php
if (isset($_POST['subject1']) && $_POST['subject1'] != "")
{
	$query32 = "SELECT a.*, b.codeEnglish AS firstsub, c.codeEnglish AS secsub, d.codeEnglish AS thisub FROM `map_sub_to_years` AS a, subject AS b,subject AS c,subject AS d WHERE a.first_subid = b.subjectID AND a.second_subid = c.subjectID AND a.third_subid = d.subjectID AND  first_subid = '".$_POST['subject1']."'";
		 //$numRows2 = mysql_num_rows(executeQuery($query2));
		 $numRows32data = $db->executeQuery($query32);
		 $numRows32 = $db->Row_Count($numRows32data);
	if ($numRows32>0)
	{
		
	
	?>
<table class="searchResults">
<caption>Already Mapped Combinations</caption>
	<tr><th>#</th><th>From Date</th><th>To Date</th><th>Examination1</th><th>Examination2</th><th>Examination3</th><th>Action</th></tr>
	<?php
		$axdf = 1;
	while ($mydatarwo = $db->Next_Record($numRows32data))
	{
		?>
	<tr>
	<th><?php echo($axdf);?></th>
	<th><?php echo($mydatarwo['from_date']);?></th>
	<th><?php echo($mydatarwo['to_date']);?></th>
	<th><?php echo($mydatarwo['firstsub']);?></th>
	<th><?php echo($mydatarwo['secsub']);?></th>
	<th><?php echo($mydatarwo['thisub']);?></th>
	<th><form action="" method="post"><input type="hidden" name="deletemap" value="<?php echo($mydatarwo['id']);?>" ><input type="submit" name="delMapBut" value="Delete" ></form></th>
	</tr>
	<?php
		$axdf++;
	}
	
	
	?>
</table>

<?php
	}
}
?>


<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "Subjects - Subject Mapping - Student Management System - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='subjectMap.php'>Subjects </a></li><li>Subject Mapping</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>