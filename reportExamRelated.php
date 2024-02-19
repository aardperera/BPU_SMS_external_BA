<?php
    error_reporting(E_ALL & ~E_WARNING);
?>

<?php
  ob_start();
  
  include('dbAccess.php');

$db = new DBOperations();
  include('authcheck.inc.php');
?>

<h1> Examination Related Reports</h1>
<form method="post" onsubmit="return false;">
  <table class="searchResults">
  <tr><td><h2><a href="admissionList.php">Admission List</a></h2></td></tr>
  <tr><td><h2><a href="attend_admission.php">Attendance Sheet for Admission List</a></h2></td></tr> 
  <tr><td><h2><a href="markingSheetMain.php">Marking Sheet</a></h2></td></tr> 
  <tr><td><h2><a href="signingSheetMain.php">Signing Sheet</a></h2></td></tr> 
    
  </table>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Exam Related Reports - Applicants - Student Management System - Buddhisht & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='index.php'>Home </a></li><li>Exam Related Reports</ul>";
  //Apply the template
  include("master_sms_external.php");
?>