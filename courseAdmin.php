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
    error_reporting(E_ALL & ~E_WARNING);
?>

 <script language="javascript">
 	function MsgOkCancel()
	{
		var message = "Please confirm to DELETE this course...";
		var return_value = confirm(message);
		return return_value;
	}
 </script>
 <?php

// include('authcheck.inc.php');
 require_once("dbAccess.php");
 $db = new DBOperations();
  
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$courseID = $db->cleanInput($_GET['courseID']);
	$delQuery = "DELETE FROM course WHERE courseID='$courseID'";
	$result = $db->executeQuery($delQuery);
  }
  

  
  $rowsPerPage = 10;
  $pageNum = 1;
  if(isset($_GET['page'])) $pageNum = $_GET['page'];

  $query = "SELECT * FROM course";
  
  
  //Set filter according  to list box values
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
  	$pageNum = 1;
	$courseType = $_POST['lstCourseType'];
	
	$_SESSION['courseType'] = $courseType;
	
	$subQuery = filterQuery($courseType);
	$query = $query.$subQuery;
  }
  
  else if (isset($_SESSION['courseType']))
  {
	$courseType = $_SESSION['courseType'];
  	$subQuery = filterQuery($courseType);
	$query = $query.$subQuery;
  }
  else
  {
  if ($_SESSION['courseId']!=0)
		  {
		  $subQuery = $subQuery. " where courseID='".$_SESSION['courseId']."' ";
		  }
  }
 
  
  function filterQuery($courseType)
  {
	$subQuery = "";
	if ($courseType<>'0')
	{
		$subQuery = " WHERE courseType='".$courseType."' ";
		if ($_SESSION['courseId']!=0)
		  {
		  $subQuery = $subQuery. " and courseID='".$_SESSION['courseId']."' ";
		  }
	}
	else
	{
		if ($_SESSION['courseId']!=0)
		  {
		  $subQuery = $subQuery. " where courseID='".$_SESSION['courseId']."' ";
		  }
	}
	
	
	
	$subQuery = $subQuery." ORDER BY courseID";
	return $subQuery;
  }
  
  // counting the offset
  
  //echo $query;
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = $db->Row_Count($db->executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);
  
  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	$pageResult = $db->executeQuery($pageQuery);


?>
  
  
<h1>Course Administration</h1>
  <form method="post" action="" class="plain">
  <table style="margin-left:8px" class="panel">
  	<tr>
    	<td><input name="btnNew" type="button" value="New" onclick="document.location.href = 'courseNew.php';" class="button" style="width:60px;" /></td>
        <td width="80px">Course Type</td>
        <td>
            <select name="lstCourseType" id="lstCourseType" onchange="this.form.submit();">
            <?php
				$result = $db->executeQuery("SELECT DISTINCT courseType FROM course");
				if ($db->Row_Count($result)>0)
				{
					echo "<option value='0'>All</option>";
					while ($row=$db->Next_Record($result))
					{
						if (isset($_POST['lstCourseType']) && $_POST['lstCourseType']==$row['courseType'])
							echo "<option selected='selected' value='".$row['courseType']."'>".$row['courseType']."</option>";
						else if (isset($_SESSION['courseType']) && $_SESSION['courseType']==$row['courseType'])
							echo "<option selected='selected' value='".$row['courseType']."'>".$row['courseType']."</option>";
						else echo "<option value='".$row['courseType']."'>".$row['courseType']."</option>";
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
    	<th>ID</th><th>Code</th><th>Name</th><th>Type</th><th colspan="3"></th>
    </tr>
    
<?php
  while ($row = $db->Next_Record($pageResult))
  {
?>
	<tr>
        <td><?php echo $row['courseID'] ?></td>
	<td><?php echo $row['courseCode'] ?></td>
		<td><?php echo $row['nameEnglish'] ?></td>
        <td><?php echo $row['courseType'] ?></td>
        <td><input name="btnDetails" type="button" value="Details" onclick="document.location.href ='courseDetails.php?courseID=<?php echo $row['courseID'] ?>'"  class="button" style="width:60px;"/></td>
        <td><input name="btnEdit" type="button" value="Edit" onclick="document.location.href ='courseEdit.php?courseID=<?php echo $row['courseID'] ?>'" class="button" style="width:60px;" /></td>
        <td><input name="btnDelete" type="button" value="Delete" class="button" onclick="if (MsgOkCancel()) document.location.href ='courseAdmin.php?cmd=delete&courseID=<?php echo $row['courseID'] ?>'" style="width:60px;" /></td>
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
  $pagetitle = "Courses - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li>Courses</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>