<?php
ob_start();

include('dbAccess.php');

// Assuming DBOperations has a method to execute a query
$db = new DBOperations();
$queryyr = "SELECT acyear FROM student_a";
$result = $db->executeQuery($queryyr);

$academicYears = array();

while ($row = $db->fetchAssoc($result)) {
    $academicYears[] = $row['acyear'];
}

// Remove duplicate academic years
$academicYears = array_unique($academicYears);

include('authcheck.inc.php');
?>

<h1> Applicant Related Details</h1>
<form method="post" onsubmit="return false;">
  <label for="academicYear">Select Academic Year:</label>
  <select name="academicYear" id="academicYear">
    <?php
    foreach ($academicYears as $year) {
        echo "<option value=\"$year\">$year</option>";
    }
    ?>
  </select>
  <br><br>

  <table class="searchResults">
    <tr>
      <td><h2><a href="RepeatEnrollexls.php">Excel Report - Applicant Details</a> </h2></td>
    </tr>
  </table>
</form>

<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Enrollment Related Reports - Applicants - Student Management System - Buddhisht & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='index.php'>Home </a></li><li>Enrollment Related Reports</ul>";
//Apply the template
include("master_sms_external.php");
?>
