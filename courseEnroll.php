<?php
//Buffer larger content areas like the main page content
ob_start();
?>

<script type="text/javascript" language="javascript">
 	function MsgOkCancel()
	{
		var message = "Please confirm to DELETE this subject enrollment...";
		var return_value = confirm(message);
		return return_value;
	}
</script>

<?php

require_once("dbAccess.php");
$db = new DBOperations();

if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
{
	$studentID = $db->cleanInput($_GET['studentID']);
	$yearEntry = $db->cleanInput($_GET['yearEntry']);
	$subjectID = $db->cleanInput($_GET['subjectID']);
	$seldelQuery="select Enroll_id from crs_enroll where studentID='$studentID' and yearEntry='$yearEntry'";
	//print $seldelQuery;
	$subenrollidresult = $db->executeQuery($seldelQuery);

	$subenrollrow = $db->Next_Record($subenrollidresult);
	$Enroll_id	 = $subenrollrow['Enroll_id'];

	//print $Enroll_id;
	$delQuery= "DELETE FROM subject_enroll WHERE subjectID ='$subjectID' and Enroll_id='$Enroll_id'";
	//print $delQuery;
	$result = $db->executeQuery($delQuery);
}

if (isset($_GET['cmd']) && $_GET['cmd']=="deletec")
{
	$studentID = $db->cleanInput($_GET['studentID']);
    $indexNo = $db->cleanInput($_GET['indexNo']);
	$yearEntry = $db->cleanInput($_GET['yearEntry']);

    $query="select Enroll_id from crs_enroll where studentID='$studentID' and yearEntry='$yearEntry' and indexNo='$indexNo'";
	//print $seldelQuery;
	if($result = $db->executeQuery($query)){
        $row = $db->Next_Record($result);
        $Enroll_id	 = $row['Enroll_id'];

        $query = "DELETE FROM subject_enroll WHERE Enroll_id='$Enroll_id'";
        $result = $db->executeQuery($query);

        $query = "DELETE FROM crs_enroll WHERE Enroll_id='$Enroll_id'";
        $result = $db->executeQuery($query);
    }
}


session_start();

//print $_SESSION['studentID'] ;
$indexNo="";
if(isset($_GET['indexNo'])){
	$indexNo = $_GET['indexNo'];
}

$studentID = "";
if(isset($_GET['studentID'])){
	$studentID = $_GET['studentID'];
}
//$regNo = $db->cleanInput($_GET['regNo']);
$rowsPerPage = 100;
$pageNum = 1;
if(isset($_GET['page'])) $pageNum = $_GET['page'];

$query = "SELECT `crs_enroll`.`regNo`,`crs_enroll`.indexNo,`crs_enroll`.`courseID` , `course`.courseCode ,`subject_enroll` .subjectID,`subject`.codeEnglish,`subject`.nameEnglish ,`crs_enroll`.yearEntry FROM `crs_enroll`,`subject_enroll`, `course` ,`subject` WHERE studentID ='$studentID' AND `crs_enroll`.Enroll_id = `subject_enroll`.Enroll_id AND `subject`.subjectID= `subject_enroll`.subjectID AND `course`.courseID = `crs_enroll`.courseID";
//print($query);
$query2 = "SELECT `crs_enroll`.`regNo`, `crs_enroll`.`studentID`, `crs_enroll`.indexNo,`crs_enroll`.`courseID` , `course`.courseCode,`crs_enroll`.yearEntry FROM `crs_enroll`, `course` WHERE studentID = '$studentID' AND `course`.courseID = `crs_enroll`.courseID";
//print $query2; 

$offset = ($pageNum - 1) * $rowsPerPage;
$numRows = $db->Row_Count($db->executeQuery($query));
$numPages = ceil($numRows/$rowsPerPage);

$pageQuery = $query." LIMIT $offset, $rowsPerPage";
$pageResult = $db->executeQuery($pageQuery);



$courseID="";
if(isset($_POST["courseID"]))
{
	$courseID=strip_tags($_POST["courseID"]);
	//echo $courseID="5 ";
}

$date="";
if (isset($_GET['date'])) {
    $date = $_GET['date'];
}



?>

<h1>
    Course Enrollments - <?php echo $studentID; ?>
</h1>
<form method="post" action="courseEnroll.php?studentID=<?php echo $studentID; ?>" class="plain">
    <table style="margin-left:8px" class="panel">
        <tr>
            <td>
                <input name="btnNew" type="button" value="New" onclick="document.location.href = 'courseEnrollNew.php?studentID=<?php echo $studentID; ?>&date=<?php echo $date; ?>';" class="button" style="width:60px;" />
            </td>
        </tr>
        <tr>
            <input hidden type="text" id="date" name="date" value=" <?php echo $date; ?> " />
        </tr>
    </table>

    <?php
	$result = $db->executeQuery($query2);
	if($db->Row_Count($result)>0){
    ?>
    <table class="searchResults">	
        <tr>
            <th>Reg. No.</th><th>Index No</th><th>Course</th><th>Entry Year</th><th>&nbsp;</th>
        </tr>
        <?php
		while($row = $db->Next_Record($result)){
        ?>
        <tr>
            <td width=120>
                <?php echo $row['regNo'] ?>
            </td>
            <td width=250>
                <?php echo $row['indexNo'] ?>
            </td>
            <td width=250>
                <?php echo $row['courseCode'] ?>
            </td>
            <td>
                <?php echo $row['yearEntry'] ?>
            </td>
            <!-- <td> <td><input name="btnEdit" type="button" value="Edit" onclick="document.location.href ='courseEnrollEdit.php?regNo=<?php echo $row['regNo'] ?>'" class="button" style="width:60px;"/></td>-->
            <td>
                <input name="btnDeleteC" type="button" value="Delete" class="button" onclick="if (MsgOkCancel()) document.location.href ='courseEnroll.php?cmd=deletec&studentID=<?php echo $row['studentID'] ?>&indexNo=<?php echo $row['indexNo'] ?>&yearEntry=<?php echo $row['yearEntry'] ?>'" style="width:60px;" />
            </td>
            <!-- <td><input type="btnSubjects" type="button" value="Subjects" <?php if ($row['courseID'] == '5' || $row['courseID'] == '3'){ ?> Enabled <?php   }else { ?> Disabled  <?php }  ?>  onclick="document.location.href ='subjectEnroll.php?indexNo=<?php echo $row['indexNo'] ?>&studentID=<?php echo $studentID; ?>'"  class="button" style="width:60px;"/></td>
	--><!--  <td><input name="btnSubjects" type="button" value="Subjects" onclick="document.location.href ='subjectEnroll.php?indexNo=<?php echo $row['indexNo'] ?>&studentID=<?php echo $studentID; ?>'" class="button" style="width:60px;"/></td>
	-->
        </tr>
        <?php
        }

    }
        ?>
    </table>

    <?php if ($db->Row_Count($pageResult)>0){ ?>
    <br />

    <h1>
        Subject Enrollments - <?php echo $studentID; ?>
    </h1>
    <table class="searchResults">
        <tr>
            <th>Reg. No.</th><th>Index No</th><th>Course</th><th>Subject Code</th><th>Subject Name</th><th>Entry Year</th><th colspan="3"></th>
        </tr>

        <?php
			  while ($row = $db->Next_Record($pageResult))
			  {
        ?>
        <tr>
            <td width=120>
                <?php echo $row['regNo'] ?>
            </td>
            <td width=250>
                <?php echo $row['indexNo'] ?>
            </td>
            <td width=250>
                <?php echo $row['courseCode'] ?>
            </td>
            <td width=250>
                <?php echo $row['codeEnglish'] ?>
            </td>
            <td width=250>
                <?php echo $row['nameEnglish'] ?>
            </td>
            <td>
                <?php echo $row['yearEntry'] ?>
            </td>
            <!-- <td> <td><input name="btnEdit" type="button" value="Edit" onclick="document.location.href ='courseEnrollEdit.php?regNo=<?php echo $row['regNo'] ?>'" class="button" style="width:60px;"/></td>-->
            <td>
                <input name="btnDelete" type="button" value="Delete" class="button" onclick="if (MsgOkCancel()) document.location.href ='courseEnroll.php?cmd=delete&regNo=<?php echo $row['regNo'] ?>&studentID=<?php echo $studentID ?>&subjectID=<?php echo $row['subjectID'] ?>&yearEntry=<?php echo $row['yearEntry'] ?>&date=<?php echo $date; ?>'" style="width:60px;" />
            </td>
            <!-- <td><input type="btnSubjects" type="button" value="Subjects" <?php if ($row['courseID'] == '5' || $row['courseID'] == '3'){ ?> Enabled <?php   }else { ?> Disabled  <?php }  ?>  onclick="document.location.href ='subjectEnroll.php?indexNo=<?php echo $row['indexNo'] ?>&studentID=<?php echo $studentID; ?>'"  class="button" style="width:60px;"/></td>
	--><!--  <td><input name="btnSubjects" type="button" value="Subjects" onclick="document.location.href ='subjectEnroll.php?indexNo=<?php echo $row['indexNo'] ?>&studentID=<?php echo $studentID; ?>'" class="button" style="width:60px;"/></td>
	-->
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
<input name="btnBack" type="button" value="Back" onclick="document.location.href = 'studentAdmin.php?date=<?php echo $date?>';" class="button" />&nbsp;&nbsp;&nbsp;
<?php

//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>Course Enrollments</li></ul>";
//Apply the template
include("master_sms_external.php");
?>