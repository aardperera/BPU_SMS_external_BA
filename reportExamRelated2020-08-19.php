<?php
  ob_start();
  
  include('dbAccess.php');

$db = new DBOperations();
  include('authcheck.inc.php');
?>

<h1> Enrollment Related Reports</h1>
<form method="post" onsubmit="return false;">
  <table class="searchResults">
  <tr><td><a href="admissionList.php">Admission List</a></td></tr>
  <tr><td><a href="attend_admission.php">Attendance for Admission List</a></td></tr> 
  <tr><td><a href="resultsView.php"> Results View Report</a></td></tr> 
  <tr><td><a href="resultsSheetViewMain.php">Detailed Result Sheet</a></td></tr> 
  <tr><td><a href="markingSheetMain.php">Marking Sheet</a></td></tr> 
  <tr><td><a href="signingSheetMain.php">Signing Sheet</a></td></tr> 
  </table>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Enrollment Related Reports - Applicants - Student Management System - Buddhisht & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='index.php'>Home </a></li><li>Exam Related Reports</ul>";
  //Apply the template
  include("master_sms_external.php");
?>