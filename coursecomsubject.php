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
  function MsgOkCancel() {
    var message = "Please confirm to DELETE this student...";
    var return_value = confirm(message);
    return return_value;
  }

  function quickSearch() {
    var regNo = document.getElementById('txtSearch').value;
    if (regNo == "")
      alert("Enter a Registration No");
    else
      document.location.href = 'coursecombdetails.php?combinationID=' + regNo;
  }

  function quickSearch2() {
    var nic = document.getElementById('txtSearchN').value;
    if (nic == "")
      alert("Enter NIC No");
    else
      document.location.href = 'studentAdmin.php?cmd=find&nic=' + nic;
  }
</script>
<?php
include('dbAccess.php');
$db = new DBOperations();

$stud = "";

if (isset($_GET['cmd']) && $_GET['cmd'] == "delete") {
  $regNo = $db->cleanInput($_GET['ID']);
  $delQuery = "DELETE FROM crs_subject WHERE ID ='$regNo'";
  $result = $db->executeQuery($delQuery);
}

if (isset($_GET['cmd']) && $_GET['cmd'] == "find") {
  $stud = "Not Found";
  $combinationID = $db->cleanInput($_GET['combinationID']);
  $srcQuery = "Select combinationID FROM course_combination WHERE combinationID ='$combinationID'";
  $result = $db->executeQuery($srcQuery);
  //$row = mysql_fetch_array($result);
  $row = $db->Next_Record($result);
  $stud = $row['combinationID'];
}

//session_start();

$rowsPerPage = 10;
$pageNum = 1;
if (isset($_GET['page'])) $pageNum = $_GET['page'];

// $query = "SELECT distinct a.ID,b.courseCode,a.subcrsid, b.courseID,c.description,s.nameEnglish,s.subjectID  FROM crs_subject as a,course as b,subject s, crs_sub c WHERE a.CourseID=b.courseID and a.CourseID=c. CourseID and a.subcrsID= c.subcrsID ";
$query = "SELECT * FROM  crs_subject as c, subject as s";

if ($_SESSION['courseId'] != 0) {
  $query = $query . " where c.courseID='" . $_SESSION['courseId'] . "' ";
}
$query = $query." and s.subjectID=c.subjectID order by c.subcrsid, s.suborder";


// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
//$numRows = @mysql_num_rows(executeQuery($query));
$numRows = $db->Row_Count($db->executeQuery($query));
$numPages = ceil($numRows / $rowsPerPage);

$pageQuery = $query . " LIMIT $offset, $rowsPerPage";
$pageResult = $db->executeQuery($pageQuery);

?>

<h1>Course Subject</h1>
<form method="post" action="" class="plain">
  <table style="margin-left:8px" class="panel">
    <tr>
      <td><input name="btnNew" type="button" value="New" onClick="document.location.href = 'crs_subject.php';" class="button" style="width:60px;" /> </td>
      <td>&nbsp;</td>
      <!-- <td><input name="btnSearch" type="button" value="Search" onclick="quickSearch();" class="button" style="width:60px;"/></td>
      <td><input name="txtSearch" id="txtSearch" type="text" />      
      (CombinationID)</td> -->
    </tr>
  </table>

  <?php
  //if (mysql_num_rows($pageResult)>0)
  if ($db->Row_Count($pageResult) > 0) { ?>
    <br />
    <table class="searchResults">
      <tr>
        <th>Course Code</th>
        <th>Sub Course </th>

        <!--<th>Combination</th> -->


        <th>Subject</th>
        <th colspan="4"></th>
      </tr>

      <?php
      // while ($row = mysql_fetch_array($pageResult))
      while ($row = $db->Next_Record($pageResult)) {
        $recordId = $row['ID'] !== null ? $row['ID'] : '';
      ?>
        <tr>
          <td><?php echo $row['CourseID']; ?></td>



          <td><?php
              //============================================
              $newvalue1 = $row['subcrsid'];
              
              $srcQuerycrssub = "Select description FROM crs_sub WHERE id ='$newvalue1'";              
              $resultsub = $db->executeQuery($srcQuerycrssub);
              //$rowsub = mysql_fetch_array($resultsub);
              $subdesc = '--';
              while ($rowsub = $db->Next_Record($resultsub))
                $subdesc = $rowsub == null || $rowsub['description'] == null ? '--' : $rowsub['description'];
              //================================================

              echo $subdesc; ?></td>
          <td>
            <?php
            $ttt = $row['subjectID'];
            $srcQuerycrssub = "Select codeEnglish  FROM subject WHERE subjectID ='$ttt'";
            $resultsub = $db->executeQuery($srcQuerycrssub);
            $subdesc = '--';
            $rowsub = $db->Next_Record($resultsub);
            $subdesc = $rowsub == null || $rowsub['codeEnglish']  == null ? '--' : $rowsub['codeEnglish'];
            echo $subdesc; ?></td>
          <td><input name="btnDetails" type="button" value="Details" onclick="document.location.href ='coursecombdetails.php?combID=<?php echo $recordId ?>'" class="button" style="width:60px;" /></td>
          <td><input name="btnEdit" type="button" value="Edit" onClick="document.location.href ='coursecombedit.php?combID=<?php echo $recordId ?>'" class="button" style="width:60px;" /></td>
          <td><input name="btnDelete" type="button" value="Delete" class="button" onClick="if (MsgOkCancel()) document.location.href ='coursecomsubject.php?cmd=delete&ID=<?php echo $row['ID'] ?>'" style="width:60px;" /></td>
          <td>&nbsp;</td>
        </tr>
      <?php
      }
      ?>
    </table>
</form>
<?php
    $self = $_SERVER['PHP_SELF'];
    if ($pageNum > 1) {
      $page  = $pageNum - 1;
      $prev  = " <a class=\"link\" href=\"$self?page=$page\">[Prev]</a> ";
      $first = " <a class=\"link\" href=\"$self?page=1\">[First Page]</a> ";
    } else {
      $prev  = '&nbsp;'; // we're on page one, don't print previous link
      $first = '&nbsp;'; // nor the first page link
    }

    if ($pageNum < $numPages) {
      $page = $pageNum + 1;
      $next = " <a class=\"link\" href=\"$self?page=$page\">[Next]</a> ";
      $last = " <a class=\"link\" href=\"$self?page=$numPages\">[Last Page]</a> ";
    } else {
      $next = '&nbsp;'; // we're on the last page, don't print next link
      $last = '&nbsp;'; // nor the last page link
    }

    echo "<table border=\"0\" align=\"center\" width=\"50%\"><tr><td width=\"20%\">" . $first . "</td><td width=\"10%\">" . $prev . "</td><td width=\"10%\">" . "$pageNum of $numPages" . "</td><td width=\"10%\">" . $next . "</td><td width=\"30%\">" . $last . "</td></tr></table>";
  } else echo "<p>No Combinations.</p>";

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