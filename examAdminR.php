<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();

   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
?>
 <?php
    error_reporting(E_ALL & ~E_NOTICE);
?>
 <script language="javascript">
 	function MsgOkCancel()
	{
		var message = "Please confirm to DELETE this subject...";
		var return_value = confirm(message);
		return return_value;
	}
 </script>
 <?php
  include('dbAccess.php');

$db = new DBOperations();

  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$effortID = $db->cleanInput($_GET['effortID']);
	$delQuery = "DELETE FROM exameffortR WHERE effortID='$effortID'";
	$result = $db->executeQuery($delQuery);
  }

  session_start();

  $rowsPerPage = 25;
  $pageNum = 1;
  if(isset($_GET['page'])) $pageNum = $_GET['page'];

  $query = "SELECT effortID,exameffortR.indexNo,student_a.nameEnglish AS student_a,subject.nameEnglish AS subject,exameffortR.acYear,mark1,mark2,marks,grade,effort FROM exameffortR JOIN crs_enrollR ON exameffortR.indexNo=crs_enrollR.indexNo JOIN student_a ON crs_enrollR.studentID=student_a.studentID JOIN subject ON exameffortR.subjectID=subject.subjectID";
  //print $query;
  //Set filter according  to list box values
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
  	$pageNum = 1;
	$acYear = $_POST['lstAcYear'];
	$subject = $_POST['lstSubject'];
	$student = $_POST['lstStudent'];

	$_SESSION['acYear'] = $acYear;
	$_SESSION['subject'] = $subject;
	$_SESSION['student'] = $student;

	$subQuery = filterQuery($acYear,$subject,$student);
	$query = $query.$subQuery;
    //print($query);
  }

  else if (isset($_SESSION['acYear']) && isset($_SESSION['subject']) && isset($_SESSION['student']))
  {
	$acYear = $_SESSION['acYear'];
	$subject = $_SESSION['subject'];
	$student = $_SESSION['student'];
  	$subQuery = filterQuery($acYear,$subject,$student);
	$query = $query.$subQuery;
	//print($query);
  }

  function filterQuery($acYear,$subject,$student)
  {
	$subQuery = "";
	if ($acYear<>0)
	{
		$subQuery = " WHERE exameffortR.acYear='".$acYear."' AND crs_enrollR.yearEntry = '".$acYear."' "; // (1,_,_)
		if ($subject<>0)
		{
			$subQuery = $subQuery." AND exameffortR.subjectID='".$subject."'"; // (1,1,_)
			if ($student<>0)
				$subQuery = $subQuery." AND exameffortR.indexNo='".$student."'"; // (1,1,1)
		}
		else if ($student<>0)
			$subQuery = $subQuery." AND exameffortR.indexNo='".$student."'"; // (1,0,1)
	}
	else
	{
		if ($subject<>0)
		{
			$subQuery = " WHERE exameffortR.subjectID='".$subject."'"; // (0,1,_)
			if ($student<>0)
				$subQuery = $subQuery." AND exameffortR.indexNo='".$student."'"; // (0,1,1)
		}
		else if ($student<>0)
			$subQuery = " WHERE exameffortR.indexNo='".$student."'"; // (0,0,1)
	}
	$subQuery = $subQuery." ORDER BY exameffortR.indexNo";
	return $subQuery;
  }

   $_SESSION['query'] = $query;

   //print  $query;

  // counting the offset
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = $db->Row_Count($db->executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);

  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	//echo $pageQuery;
	$pageResult = $db->executeQuery($pageQuery);
?>

 <h1>Repeat Student Exam Administration</h1>
 <form method="post" action="" class="plain">
  <table style="margin-left:8px" class="panel">
  	<tr>
    	<td><input name="btnNew" type="button" value="New" onclick="document.location.href = 'effortNew.php';" class="button" /></td>
        <td>&nbsp;</td>
        <td><input name="btnEnterResults" type="button" value="Enter First Mark Results" class="button" onclick="document.location.href ='examEnterResultsR.php'" /></td>
   <td>&nbsp;</td>
        <td><input name="btnEnterResults" type="button" value="Enter Second Marks Results" class="button" onclick="document.location.href ='examEnterResults2R.php'" /></td>
		<td>&nbsp;</td>
        <td><input name="btnEnterResults" type="button" value="Withholding Results" class="button" onclick="document.location.href ='examWHR.php'" /></td>
	</tr>
   </table>
   <table style="margin-left:8px" class="panel">
    <tr>
        <td>Academic Year</td>
        <td>
            <select name="lstAcYear" id="lstAcYear" onchange="this.form.submit();">
            <?php
				$result = $db->executeQuery("SELECT DISTINCT acYear FROM exameffortR");
				if ($db->Row_Count($result)>0)
				{
					echo "<option value='0'>All</option>";
					while ($row= $db->Next_Record($result))
					{
						if (isset($_POST['lstAcYear']) && $_POST['lstAcYear']==$row['acYear'])
							echo "<option selected='selected' value='".$row['acYear']."'>".$row['acYear']."</option>";
						else if (isset($_SESSION['acYear']) && $_SESSION['acYear']==$row['acYear'])
							echo "<option selected='selected' value='".$row['acYear']."'>".$row['acYear']."</option>";
						else echo "<option value='".$row['acYear']."'>".$row['acYear']."</option>";
					}
				}
			?>
            </select>
        </td>
        <td>&nbsp;</td>
        <td>Subject</td>
        <td>
            <select name="lstSubject" id="lstSubject" onchange="this.form.submit();">
            <?php
				$result = $db->executeQuery("SELECT subjectID,codeEnglish FROM subject");
				if ($db->Row_Count($result)>0)
				{
					echo "<option value='0'>All</option>";
					while ($row= $db->Next_Record($result))
					{
						if (isset($_POST['lstSubject']) && $_POST['lstSubject']==$row['subjectID'])
							echo "<option selected='selected' value='".$row['subjectID']."'>".$row['codeEnglish']."</option>";
						else if (isset($_SESSION['subject']) && $_SESSION['subject']==$row['subjectID'])
							echo "<option selected='selected' value='".$row['subjectID']."'>".$row['codeEnglish']."</option>";
						else echo "<option value='".$row['subjectID']."'>".$row['codeEnglish']."</option>";
					}
				}
			?>
            </select>
        </td>
        <td>&nbsp;</td>
        <td>Student</td>
        <td>
            <select name="lstStudent" id="lstStudent" onchange="this.form.submit();">
                <?php
				$result = $db->executeQuery("SELECT DISTINCT indexNo FROM crs_enrollR where courseID = '".$_SESSION['courseId']."'");
				if ($db->Row_Count($result)>0)
				{
					echo "<option value='0'>All</option>";
					while ($row= $db->Next_Record($result))
					{
						if (isset($_POST['lstStudent']) && $_POST['lstStudent']==$row['indexNo'])
							echo "<option selected='selected' value='".$row['indexNo']."'>".$row['indexNo']."</option>";
						else if (isset($_SESSION['student']) && $_SESSION['student']==$row['indexNo'])
							echo "<option selected='selected' value='".$row['indexNo']."'>".$row['indexNo']."</option>";
						else echo "<option value='".$row['indexNo']."'>".$row['indexNo']."</option>";
					}
				}
                ?>
            </select>
        </td>
   	</tr>
  </table>
<?php
if ($db->Row_Count($pageResult)>0){
?>
<br/>
  <table class="searchResults">
	<tr>
    	<th>Index No.</th><th>Student</th><th>Subject</th><th>Ac. Year</th><th>Mark 1</th><th>Mark 2</th><th>Marks</th><th>Grade</th><th>Effort</th><th colspan="2"></th>
    </tr>
    
<?php
  while ($row =  $db->Next_Record($pageResult))
  {
?>
	<tr>
        <td><?php echo $row['indexNo'] ?></td>
		<td><?php echo $row['student'] ?></td>
        <td><?php echo $row['subject'] ?></td>
        <td><?php echo $row['acYear'] ?></td>
		<td><?php echo $row['mark1'] ?></td>
		<td><?php echo $row['mark2'] ?></td>
		<td><?php echo $row['marks'] ?></td>
        <td><?php echo $row['grade'] ?></td>
        <td><?php echo $row['effort'] ?></td>
        <td><input name="btnEdit" type="button" value="Edit" onclick="document.location.href ='effortEdit.php?effortID=<?php echo $row['effortID'] ?>'" class="button" /></td>
        <td><input name="btnDelete" type="button" value="Delete" class="button" onclick="if (MsgOkCancel()) document.location.href ='examAdmin.php?cmd=delete&effortID=<?php echo $row['effortID'] ?>'" /></td>
	</tr>
<?php
  }
?>
  </table>
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
}else echo "<p>No exam details available.</p>";

?>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Exams - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li>Exams</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>