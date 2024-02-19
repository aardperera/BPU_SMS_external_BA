<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
  
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
 ?>

 <script type="text/javascript" language="javascript">
 	function MsgOkCancel()
	{
		var message = "Please confirm to DELETE this student...";
		var return_value = confirm(message);
		return return_value;
	}
	
	function quickSearch()
	{
		var regNo = document.getElementById('txtSearch').value;
		if (regNo == "")
			alert("Enter a Registration No");
		else
			document.location.href ='coursecombdetails.php?combinationID='+regNo;
	}
	s
	function quickSearch2()
	{
		var nic = document.getElementById('txtSearchN').value;
		if (nic == "")
			alert("Enter NIC No");
		else
			document.location.href ='studentAdmin.php?cmd=find&nic='+nic;
	}
 </script>
 <?php
  include('dbAccess.php');

$db = new DBOperations();
  $stud = "";
  
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$regNo = $db->cleanInput($_GET['combinationID']);
	$delQuery = "DELETE FROM course_combination WHERE combinationID ='$regNo'";
	$result = $db->executeQuery($delQuery);
  }
  
  if (isset($_GET['cmd']) && $_GET['cmd']=="find")
  {
	$stud = "Not Found";
	$combinationID = $db->cleanInput($_GET['combinationID']);
	$srcQuery = "Select combinationID FROM course_combination WHERE combinationID ='$combinationID'";
	$result = $db->executeQuery($srcQuery);
	$row =  $db->Next_Record($result);
	$stud = $row['combinationID'];
  }
  
  //session_start();
  
  $rowsPerPage = 10;
  $pageNum = 1;
  if(isset($_GET['page'])) $pageNum = $_GET['page'];

  $query = "SELECT * FROM crs_sub";
  
  if ($_SESSION['courseId']!=0)
		  {
		  $query = $query. " where courseID='".$_SESSION['courseId']."' ";
		  }
  
  
  
  // counting the offset
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = @$db->Row_Count($db->executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);
  
  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	$pageResult = $db->executeQuery($pageQuery);
?>
  
  
<h1>Sub Course </h1>
  <form method="post" action="" class="plain">
  <table style="margin-left:8px" class="panel">
    <tr>
      <td><input name="btnNew" type="button" value="New" onClick="document.location.href = 'subcourse.php';" class="button" style="width:60px;"/> </td>
      <td>&nbsp;</td>
      <td><input name="btnSearch" type="button" value="Search" onclick="quickSearch();" class="button" style="width:60px;"/></td>
      <td><input name="txtSearch" id="txtSearch" type="text" />      
      (CombinationID)</td>
    </tr>
  </table>
  
<?php if ($db->Row_Count($pageResult)>0){ ?>
<br/>
  <table class="searchResults">
    <tr> 
      <th>Course Code</th>
      <th>Description</th>
      <th colspan="4"></th>
    </tr>
    <?php
  while ($row =  $db->Next_Record($pageResult))
  {
  $valuecode=$row['courseID'];
  $subcrsQuery = "Select courseCode FROM course WHERE courseID ='$valuecode'";
  //print $subcrsQuery;
  $subcrsresult = $db->executeQuery($subcrsQuery);
  $subrow =  $db->Next_Record($subcrsresult);
	$crscode= $subrow['courseCode'];
?>
    <tr> 
      <td><?php echo $crscode ?></td>
      <td><?php echo $row['description'] ?></td>
      <!--<td><input name="btnDetails" type="button" value="Details" onclick="document.location.href ='coursecombdetails.php?combinationID=<?php echo $row['combinationID']?>'"  class="button" style="width:60px;"/></td>
     -->
	 <td><input name="btnEdit" type="button" value="Edit" onClick="document.location.href ='coursecombedit.php?combinationID=<?php echo $row['id'] ?>'" class="button" style="width:60px;"/></td>
      <td><input name="btnDelete" type="button" value="Delete" class="button" onClick="if (MsgOkCancel()) document.location.href ='coursecombination2.php?cmd=delete&combinationID=<?php echo $row['combinationID'] ?>'" style="width:60px;" /></td>
      <td>&nbsp;</td>
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
}else echo "<p>No sub course.</p>";

?>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li>Students</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>