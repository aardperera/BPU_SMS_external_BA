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
  //include('authcheck.inc.php');
  
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$subjectID = $db->cleanInput($_GET['subjectID']);
	$delQuery = "DELETE FROM subject WHERE subjectID='$subjectID'";
	$result = $db->executeQuery($delQuery);
  }
  
  //session_start();
  
  $rowsPerPage = 10;
  $pageNum = 1;
  if(isset($_GET['page'])) $pageNum = $_GET['page'];

  $query = "SELECT a.subjectID,a.codeEnglish,b.courseCode,a.Compulsary,a.nameEnglish,a.level,a.creditHours FROM subject as a, course as b WHERE a.courseID=b.courseID ";
   if ($_SESSION['courseId']!=0)
		  {
		  $query = $query. " and a.courseID='".$_SESSION['courseId']."' ";
		  }
		  //print  $query;
  //Set filter according  to list box values
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
  	$pageNum = 1;
	$faculty = $_POST['lstFaculty'];
	$level = $_POST['lstLevel'];
	
	$_SESSION['faculty'] = $faculty;
	$_SESSION['level'] = $level;
	
	$subQuery = filterQuery($faculty,$level);
	$query = $query.$subQuery;
  }
  
  else if (isset($_SESSION['faculty']) && isset($_SESSION['level']))
  {
	$faculty = $_SESSION['faculty'];
	$level = $_SESSION['level'];
  	$subQuery = filterQuery($faculty,$level);
	$query = $query.$subQuery;
  }
  
  function filterQuery($faculty,$level)
  {
	$subQuery = "";
	if ($faculty<>'0')
	{
		$subQuery = " AND faculty='".$faculty."'"; // (1,_)
		if ($level<>'0')
			$subQuery = $subQuery." AND level='".$level."'"; // (1,1)
	}
	else
	{
		if ($level<>'0')
			$subQuery = " AND level='".$level."'"; // (0,1)
	}
	$subQuery = $subQuery." ORDER BY codeEnglish";
	return $subQuery;
  }
  
  // counting the offset
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = $db->Row_Count($db->executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);
  
  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	$pageResult = $db->executeQuery($pageQuery);
?>
  
  <h1>Subject Administration</h1>
  <form method="post" action="" class="plain">
  <table style="margin-left:8px" class="panel">
  	<tr>
    	<td><input name="btnNew" type="button" value="New" onclick="document.location.href = 'subjectNew.php';" class="button" style="width:60px;" /></td>
        <td>&nbsp;</td>
        <td>Faculty</td>
        <td>
            <select name="lstFaculty" id="lstFaculty" onchange="this.form.submit();">
            <?php
				$result = $db->executeQuery("SELECT DISTINCT faculty FROM subject");
				if ($db->Row_Count($result)>0)
				{
					echo "<option value='0'>All</option>";
					while ($row= $db->Next_Record($result))
					{
						if (isset($_POST['lstFaculty']) && $_POST['lstFaculty']==$row['faculty'])
							echo "<option selected='selected' value='".$row['faculty']."'>".$row['faculty']." Studies</option>";
						else if (isset($_SESSION['faculty']) && $_SESSION['faculty']==$row['faculty'])
							echo "<option selected='selected' value='".$row['faculty']."'>".$row['faculty']." Studies</option>";
						else echo "<option value='".$row['faculty']."'>".$row['faculty']." Studies</option>";
					}
				}
			?>
            </select>
        </td>
        <td>&nbsp;</td>
        <td>Level</td>
        <td>
            <select name="lstLevel" id="lstLevel" onchange="this.form.submit();">
            <?php
				$result = $db->executeQuery("SELECT DISTINCT level FROM subject");
				if ($db->Row_Count($result)>0)
				{
					echo "<option value='0'>All</option>";
					while ($row= $db->Next_Record($result))
					{
						if (isset($_POST['lstLevel']) && $_POST['lstLevel']==$row['level'])
							echo "<option selected='selected' value='".$row['level']."'>".$row['level']."</option>";
						else if (isset($_SESSION['level']) && $_SESSION['level']==$row['level'])
							echo "<option selected='selected' value='".$row['level']."'>".$row['level']."</option>";
						else echo "<option value='".$row['level']."'>".$row['level']."</option>";
					}
				}
			?>
            </select>
        </td>
  	</tr>
  </table>
<?php if ($db->Row_Count($pageResult)>0){ ?>
<br/>
  <table class="searchResults">
	<tr>
    	<th height="23">Subject Code</th>
    	<th>Course Code</th>
    	<th>Compulsary</th>
    	<th>Name</th><th>Level</th><th>Credit Hours</th><th colspan="3"></th>
    </tr>
    
<?php
  while ($row =  $db->Next_Record($pageResult))
  {
?>
	<tr>
        <td width=80><?php echo $row['codeEnglish'] ?></td>
		<td width=200><?php echo $row['courseCode'] ?></td>
		<td width=200><?php echo $row['Compulsary'] ?></td>
		<td width=200><?php echo $row['nameEnglish'] ?></td>
        <td><?php echo $row['level'] ?></td>
		<td><?php echo $row['creditHours'] ?></td>
        <td><input name="btnDetails" type="button" value="Details" onclick="document.location.href ='subjectDetails.php?subjectID=<?php echo $row['subjectID'] ?>'"  class="button" style="width:60px;"/></td>
      <td><input name="btnEdit" type="button" value="Edit" onclick="document.location.href ='subjectEdit.php?subjectID=<?php echo $row['subjectID'] ?>'" class="button" style="width:60px;"/></td>
        <td><input name="btnDelete" type="button" value="Delete" class="button" onclick="if (MsgOkCancel()) document.location.href ='subjectAdmin.php?cmd=delete&subjectID=<?php echo $row['subjectID'] ?>'" style="width:60px;"/></td>
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
}else echo "<p>No subjects.</p>";

?>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Subjects - Student Management System - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li>Subjects</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>s