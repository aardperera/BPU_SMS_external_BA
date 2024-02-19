<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
?>

<h1>Subject Details</h1>
<?php
	include('dbAccess.php');
  $db = new DBOperations();
 // 	include('authcheck.inc.php');
	
	$subjectID = $db->cleanInput($_GET['subjectID']);
	$query = "SELECT *,a.nameEnglish as EName FROM crs_sub c,`subject` a,course b WHERE a.subjectID='$subjectID' AND  b.courseID = a.courseID  ";
	//print $query;
	//SELECT * FROM `subject` a,course b WHERE a.`subjectID`='307' AND b.courseID = a.courseID ORDER BY `subjectID` DESC 
	$result = $db->executeQuery($query);
	//$row = mysql_fetch_array($result);
  $row = $db->Next_Record($result);
	
	//if (mysql_num_rows($result)>0)
  if ($db->Row_Count($result)>0)
	{
?>

<table class="searchResults">
	<tr>
    	<th colspan="2"><?php echo $row['nameEnglish']; ?></th>
    </tr>
    <tr>
      <td>CourseID:</td>
      <td><?php echo $row['courseID'] ."-". $row['courseCode'] ; ?></td>
	  
    </tr>
  <!--  <tr>
      <td>Compulsary:</td>
      <td><?php echo $row['Compulsary']; ?></td>
    </tr>-->
    <tr>
    	<td>Code (English) : </td><td width = 300> <?php echo $row['codeEnglish']; ?></td>
    </tr>
    <tr>
    	<td>Name (English) : </td><td> <?php echo $row['EName']; ?></td>
    </tr>
    <tr>
    	<td>Code (Sinhala) : </td><td> <?php echo $row['codeSinhala']; ?></td>
    </tr>
    <tr>
    	<td>Name (Sinhala) : </td><td> <?php echo $row['nameSinhala']; ?></td>
    </tr>
    <tr>
    	<td>Faculty : </td><td> <?php echo $row['faculty']; ?> Studies</td>
    </tr>
    <tr>
    	<td>Sub Course ID: </td><td> <?php echo $row['subcrsID'].'-'.$row['description']; ?></td>
    </tr>
	<tr>
    	<td>Semester : </td><td> <?php echo $row['semester']; ?></td>
    </tr>
	<tr>
    	<td>Credit Hours : </td><td> <?php echo $row['creditHours']; ?></td>
    </tr>
    
</table>
<br/><p><input name="btnEdit" type="button" value="Edit"  class="button" onclick="document.location.href ='subjectEdit.php?subjectID=<?php echo $row['subjectID'] ?>'" style="width:60px;"/></p>

  
      
<?php
   }
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Subject Details - Subjects - Student Management System - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='subjectAdmin.php'>Subjects </a></li><li>Subject Details</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>