<?php
  //Buffer larger content areas like the main page content
  ob_start();
 ?>
 
 <script language="javascript">
 	function MsgOkCancel()
	{
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
  
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$effortID = $db->cleanInput($_GET['effortID']);
	$delQuery = "DELETE FROM exameffort WHERE effortID='$effortID'";
	$result = $db->executeQuery($delQuery);
  }
  
  session_start();
  
  if (isset($_POST['btnSubmit']))
	{
		$efforts = $_SESSION['efforts'];
		for ($i=0;$i<count($efforts);$i++)
		{
			$effortID = $efforts[$i];
			$marks = $db->cleanInput($_POST['txtMarks'.$effortID]);
			$grade = $db->cleanInput($_POST['txtGrade'.$effortID]);
			$result = $db->executeQuery("UPDATE exameffort SET marks='$marks', grade='$grade' WHERE effortID='$effortID'");
		}
		header("location:examAdmin.php");
	}
  
  $query = $_SESSION['query'];
  $result = $db->executeQuery($query);
?>

 <h1>Enter Results</h1>
 <br />
  
<?php
if ($db->Row_Count($result)>0){
?>
<form method="post" action="examEnterResults.php" class="plain">
<br/>
  <table class="searchResults">
	<tr>
    	<th>Index No.</th><th>Student</th><th>Subject</th><th>Semester</th><th>Marks</th><th>Grade</th>
    </tr>
    
<?php
  while ($row =  $db->Next_Record($result))
  {
?>
	<tr>
        <td><?php echo $row['indexNo'] ?></td>
		<td><?php echo $row['student'] ?></td>
        <td><?php echo $row['subject'] ?></td>
        <td><?php echo $row['acYear'] ?></td>
        <td><input name="txtMarks<?php echo $row['effortID'] ?>" value="<?php echo $row['marks'] ?>" onkeyup="getGrade(this.value,<?php echo $row['effortID'] ?>)" type="text" /></td>
        <td><input name="txtGrade<?php echo $row['effortID'] ?>" id="txtGrade<?php echo $row['effortID'] ?>" value="<?php echo $row['grade'] ?>" type="text" /></td>
	</tr>
<?php
  }
?>
  </table>
  <?php
  	$efforts = array();
  	for ($i=0;$i<$db->Row_Count($result);$i++)
	{
		$efforts[$i] = mysql_result($result,$i,"effortID");
	}
	$_SESSION['efforts'] = $efforts;
  ?>
  <br/><br/>
  <p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'examAdmin.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" /></p>
  </form>

<?php 
}else echo "<p>No exam details available.</p>";

  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Enter Results - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='examAdmin.php'>Exam Efforts </a></li><li>Enter Results</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>