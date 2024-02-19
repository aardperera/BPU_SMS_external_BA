<?php
  //Buffer larger content areas like the main page content
  ob_start();
 ?>
 
 <script type="text/javascript" language="javascript">
 	function MsgOkCancel()
	{
		var message = "Please confirm to DELETE this entry...";
		var return_value = confirm(message);
		return return_value;
	}
 </script>
 
 <?php
  include('dbAccess.php');

$db = new DBOperations();
  
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$indexNo = $db->cleanInput($_GET['indexNo']);
	$subjectID = $db->cleanInput($_GET['subjectID']);
	$delQuery = "DELETE FROM sub_enroll WHERE indexNo='$indexNo' AND subjectID='$subjectID'";
	$result = $db->executeQuery($delQuery);
  }
  
  //session_start();
  $studentID = $_GET['studentID'];
  $indexNo = $db->cleanInput($_GET['indexNo']);
  $rowsPerPage = 10;
  $pageNum = 1;
  if(isset($_GET['page'])) $pageNum = $_GET['page'];

  $query = "SELECT sub_enroll.subjectID,codeEnglish,nameEnglish,medium,acYear FROM sub_enroll JOIN subject ON sub_enroll.subjectID = subject.subjectID WHERE indexNo='$indexNo'";
  
  // counting the offset
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = $db->Row_Count($db->executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);
  
  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	$pageResult = $db->executeQuery($pageQuery);
?>
  
  <h1>Subject Enrollments - <?php echo $indexNo; ?></h1>
  <form method="post" action="subjectEnroll.php?indexNo=<?php echo $indexNo; ?>&studentID=<?php echo $studentID; ?>" class="plain">
  <table style="margin-left:8px" class="panel">
  	<tr>
    	<td><input name="btnNew" type="button" value="New" onclick="document.location.href = 'subjectEnrollNew.php?indexNo=<?php echo $indexNo; ?>&studentID=<?php echo $studentID; ?>';" class="button" style="width:60px;"/></td>
    </tr>
  </table>
  
<?php if ($db->Row_Count($pageResult)>0){ ?>
<br/>
  <table class="searchResults">
	<tr>
    	<th>Code</th><th>Subject Code</th><th>Subject</th><th>Medium</th><th>Acd. Year</th><th></th>
    </tr>
    
<?php
  while ($row =  $db->Next_Record($pageResult))
  {
?>
	<tr>
        <td width=30><?php echo $row['subjectID'] ?></td>
		<td width=70><?php echo $row['codeEnglish'] ?></td>
        <td width = 250><?php echo $row['nameEnglish'] ?></td>
        <td width=50><?php echo $row['medium'] ?></td>
		<td><?php echo $row['acYear'] ?></td>
        <td><input name="btnDelete" type="button" value="Delete" class="button" onclick="if (MsgOkCancel()) document.location.href ='subjectEnroll.php?cmd=delete&indexNo=<?php echo $indexNo ?>&subjectID=<?php echo $row['subjectID'] ?>&studentID=<?php echo $studentID ?>'" style="width:60px;"/></td>
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
}else echo "<p>No enrollments.</p>";

?>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Subject Enrollments - Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li><a href='courseEnroll.php?studentID=$studentID'>Course Enrollments </a></li><li>Subject Enrollments</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>