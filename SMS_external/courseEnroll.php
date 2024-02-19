<?php
  //Buffer larger content areas like the main page content
  ob_start();
 ?>
 
 <script type="text/javascript" language="javascript">
 	function MsgOkCancel()
	{
		var message = "Please confirm to DELETE this student...";
		var return_value = confirm(message);
		return return_value;
	}
 </script>
 
 <?php
  include('dbAccess.php');

$db = new DBOperations();
  
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$regNo = $db->cleanInput($_GET['regNo']);
	$delQuery = "DELETE FROM crs_enroll WHERE regNo='$regNo'";
	$result = $db->executeQuery($delQuery);
  }
  
  session_start();
  $studentID = $db->cleanInput($_GET['studentID']);
  $rowsPerPage = 10;
  $pageNum = 1;
  if(isset($_GET['page'])) $pageNum = $_GET['page'];

  $query = "SELECT regNo,indexNo,crs_enroll.courseID,nameEnglish,yearEntry FROM crs_enroll JOIN course ON crs_enroll.courseID = course.courseID WHERE studentID='$studentID'";
  
  // counting the offset
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = $db->Row_Count($db->executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);
  
  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	$pageResult = $db->executeQuery($pageQuery);
?>
  
  <h1>Course Enrollments - <?php echo $studentID; ?></h1>
  <form method="post" action="courseEnroll.php?studentID=<?php echo $studentID; ?>" class="plain">
  <table style="margin-left:8px" class="panel">
  	<tr>
    	<td><input name="btnNew" type="button" value="New" onclick="document.location.href = 'courseEnrollNew.php?studentID=<?php echo $studentID; ?>';" class="button" style="width:60px;"/></td>
    </tr>
  </table>
  
<?php if ($db->Row_Count($pageResult)>0){ ?>
<br/>
  <table class="searchResults">
	<tr>
    	<th>Reg. No.</th><th>Course</th><th>Entry Year</th><th colspan="3"></th>
    </tr>
    
<?php
  while ($row =  $db->Next_Record($pageResult))
  {
?>
	<tr>
        <td width = 120><?php echo $row['regNo'] ?></td>
		<td width = 250><?php echo $row['nameEnglish'] ?></td>
        <td><?php echo $row['yearEntry'] ?></td>
        <td><input name="btnEdit" type="button" value="Edit" onclick="document.location.href ='courseEnrollEdit.php?regNo=<?php echo $row['regNo'] ?>'" class="button" style="width:60px;"/></td>
        <td><input name="btnDelete" type="button" value="Delete" class="button" onclick="if (MsgOkCancel()) document.location.href ='courseEnroll.php?cmd=delete&regNo=<?php echo $row['regNo'] ?>&studentID=<?php echo $studentID ?>'" style="width:60px;"/></td>
        <td><input name="btnSubjects" type="button" value="Subjects" onclick="document.location.href ='subjectEnroll.php?indexNo=<?php echo $row['indexNo'] ?>&studentID=<?php echo $studentID; ?>'" class="button" style="width:60px;"/></td>
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
  $pagetitle = "Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>Course Enrollments</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>