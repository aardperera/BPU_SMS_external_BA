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
			document.location.href ='studentAdminold.php?cmd=find&nic='+nic;
	}
 </script>
 <?php
  include('dbAccess.php');

$db = new DBOperations();
  $stud = "";
  
  

  
  
  
  session_start();
$_SESSION['CourseID'] = $_POST['CourseID'];
$_SESSION[' CombinationID'] =$_POST['CombinationID'];

   
if (isset($_POST['lstYearEntry']))
{

//$_SESSION['courseval'] = $_POST['lstCourseType'];
$_SESSION['yre'] = $_POST['lstYearEntry'];
$value=$_GET['CourseID'];
print $value;



//echo '<script>alert ('.$_SESSION['courseval'].');<//script>';

	if ($_POST['lstYearEntry'] != "0")
	{
	$_SESSION['sfcourseCode'] = "%/".$_POST['lstYearEntry']."%";
	} 
	else
	{
	unset($_SESSION['sfcourseCode']);
	}
	
 }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$regNo = $db->cleanInput($_GET['studentID']);
	$delQuery = "DELETE FROM student WHERE studentID ='$regNo'";
	$result = $db->executeQuery($delQuery);
  }
  
  //if (isset($_GET['cmd']) && $_GET['cmd']=="find")
  //{
	//$stud = "Not Found";
	//$nic = $db->cleanInput($_GET['nic']);
$courseIDnew = $_GET['newcourseID'];
//print $courseIDnew;
	 $srcQuery = "SELECT * FROM crs_enroll WHERE courseID ='$courseIDnew'";

	//$srcQuery = "Select studentID FROM student WHERE nic ='$nic'";
	
	//===============================================================
		$resultnew = $db->executeQuery($srcQuery);
	
	while ($datastudent= $db->Next_Record($resultnew)) 
			{
			$stud = $datastudent['studentID'];
echo $stud;
        	
		
	
	//========================================================
	
 // }
  
  //session_start();
  
  $rowsPerPage = 10;
  $pageNum = 1;
  
  
  //if(isset($_GET['page'])) $pageNum = $_GET['page'];
 
$query ="SELECT * FROM student WHERE studentID  ='$stud'";
echo $query;
  //$query = "SELECT * FROM student WHERE nic ='$nic'";
  
  
  
   if (isset($_SESSION['sfcourseCode']))
{
//$query.= " WHERE studentID LIKE '".$_SESSION['sfcourseCode']."' ";
}
  
  
  
  // counting the offset
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = $db->Row_Count($db->executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);
  
  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	$pageResult = $db->executeQuery($pageQuery);
	}
?>
<?php

	if (isset($_POST['CourseID']))
	{$courseID=$_POST['CourseID'];}
	
	
	if (isset($_POST['btnSubmit']))
	{
	
	
	    $courseID = $_POST['CourseID'];
		
		$combinationID = $db->cleanInput($_POST['CombinationID']);
		 
		header("location:studentAdminold.php?newcourseID=$courseID&combinationID=$combinationID");
	}



$courseID=$_SESSION['courseID'];
$combinationID=$_SESSION['combinationID'];

?>
  
  
  <h1>Student Administration</h1>
  <form method="post" action="" class="plain">
  <table style="margin-left:8px" class="panel">
    <tr>
      <td><input name="btnNew" type="button" value="New" onclick="document.location.href = 'studentNew.php';" class="button" style="width:60px;"/>
        &#160;&#160;&#160; <input name="btnstudId" type="button" value="Student ID" onClick="document.location.href = 'mastudentIdentify.php';" class="button" style="width:90px;"/></td>
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
      <td>
	  
			
			
			Year <select id="lstYearEntry" name="lstYearEntry" onchange="this.form.submit();">
        	<?php
			echo "<option value=".'"0"'.">All</option>";
				for ($i=2010;$i<=2100;$i++)
				{
					echo "<option value='$i'>$i</option>";
				}
			?>
        </select>
		<script> document.getElementById('lstYearEntry').value = '<?php echo $_SESSION['yre'];?>';</script>
	  
	  
	  
	   </td>
    </tr>
	  <table class="searchResults">
    <tr> 
      <td>Course ID : </td>
      <td><select id="CourseID" name="CourseID" onchange="document.form1.submit()" >
          <option value="">---</option>
          <?php
			$query = "SELECT courseID,courseCode FROM course;";
			$result = $db->executeQuery($query);
			while ($data= $db->Next_Record($result)) 
			{
			echo '<option value="'.$data[0].'">'.$data[1].'</option>';
        	} 
			?>
        </select> <script type="text/javascript" language="javascript">
		document.getElementById('CourseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
		</script> </td>
    </tr>
    <tr> 
      <td>Combination ID</td>
      <td><select name="CombinationID">
         
          <?php
	  if (isset($_POST["CourseID"]))
	  {
	  $qry = $db->executeQuery("SELECT DISTINCT(combinationID) FROM course_combination WHERE CourseID='".$_POST["CourseID"]."';");
	  while ($myval =  $db->Next_Record($qry))
		  {
		  ?>
          <option value="<?php echo $myval[0];?>"><?php echo $myval[0];?></option>
          <?php	
		  }
	  }
	  ?>
        </select></td>
    </tr>
	
  </table>
  
  
  
  
  
  

<p><input name="btnCancel" type="button" value="Cancel" onClick="document.location.href = 'coursecombination2.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" /></p>
	<tr> 
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
        <td><input name="btnDelete" type="button" value="Delete" class="button" onclick="if (MsgOkCancel()) document.location.href ='studentAdminold.php?cmd=delete&studentID=<?php echo $row['studentID'] ?>'" style="width:60px;" /></td>
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