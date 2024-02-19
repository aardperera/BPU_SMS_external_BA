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
	
	function quickSearch()
	{
		var regNo = document.getElementById('txtSearch').value;
		if (regNo == "")
			alert("Enter a Registration No");
		else
			document.location.href ='studentDetails.php?studentID='+regNo;
	}
	
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
	$regNo = $db->cleanInput($_GET['studentID']);
	$delQuery = "DELETE FROM student WHERE studentID ='$regNo'";
	$result = $db->executeQuery($delQuery);
  }
  
  if (isset($_GET['cmd']) && $_GET['cmd']=="find")
  {
	$stud = "Not Found";
	$nic = $db->cleanInput($_GET['nic']);
	$srcQuery = "Select studentID FROM student WHERE nic ='$nic'";
	$result = $db->executeQuery($srcQuery);
	$row =  $db->Next_Record($result);
	$stud = $row['studentID'];
  }
  
  //session_start();
  
  $rowsPerPage = 10;
  $pageNum = 1;
  if(isset($_GET['page'])) $pageNum = $_GET['page'];

  $query = "SELECT * FROM student";
  
  // counting the offset
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = $db->Row_Count($db->executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);
  
  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	$pageResult = $db->executeQuery($pageQuery);
?>
  
  <h1>Student Administration</h1>
  <form method="post" action="" class="plain">
  <table style="margin-left:8px" class="panel">
    <tr>
      <td><input name="btnNew" type="button" value="New" onclick="document.location.href = 'studentNew.php';" class="button" style="width:60px;"/>&#160;&#160;&#160;
	  <input name="btnstudId" type="button" value="Student ID" onclick="document.location.href = 'mastudentIdentify.php';" class="button" style="width:90px;"/></td>
      <td>&nbsp;</td>
      <td><input name="btnSearch" type="button" value="Search" onclick="quickSearch();" class="button" style="width:60px;"/></td>
      <td><input name="txtSearch" id="txtSearch" type="text" />
        (Student ID)</td>
    </tr>
    <tr> 
      <td>Enter NIC : 
        <input name="txtSearchN" type="text" id="txtSearchN" maxlength="10" /></td>
      <td>&nbsp;</td>
      <td><input name="btnSearch2" type="button" value="Search" onclick="quickSearch2();" class="button" style="width:60px;"/></td>
      <td><input name="txtID" type="text" id="txtID" value="<?php echo $stud; ?>" size="10" readonly = "readonly"/> </td>
    </tr>
  </table>
  
<?php if ($db->Row_Count($pageResult)>0){ ?>
<br/>
  <table class="searchResults">
	<tr>
    	<th>Student ID</th><th>Title</th><th>Name</th><th>Address</th><th colspan="4"></th>
    </tr>
    
<?php
  while ($row =  $db->Next_Record($pageResult))
  {
?>
	<tr>
        <td><?php echo $row['studentID'] ?></td>
        <td><?php echo $row['title'] ?></td>
		<td><?php echo $row['nameEnglish'] ?></td>
        <td><?php echo $row['addressE1'].$row['addressE2'].$row['addressE3'] ?></td>
        <td><input name="btnDetails" type="button" value="Details" onclick="document.location.href ='studentDetails.php?studentID=<?php echo $row['studentID'] ?>'"  class="button" style="width:60px;"/></td>
        <td><input name="btnEdit" type="button" value="Edit" onclick="document.location.href ='studentEdit.php?studentID=<?php echo $row['studentID'] ?>'" class="button" style="width:60px;"/></td>
        <td><input name="btnDelete" type="button" value="Delete" class="button" onclick="if (MsgOkCancel()) document.location.href ='studentAdmin.php?cmd=delete&studentID=<?php echo $row['studentID'] ?>'" style="width:60px;" /></td>
        <td><input name="btnEnroll" type="button" value="Enrollments" onclick="document.location.href ='courseEnroll.php?studentID=<?php echo $row['studentID'] ?>'" class="button" style="width:80px;"/></td>
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
}else echo "<p>No students.</p>";

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