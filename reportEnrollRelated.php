<?php
    error_reporting(E_ALL & ~E_WARNING);
?>

<?php
  ob_start();
  
  include('dbAccess.php');

$db = new DBOperations();
  include('authcheck.inc.php');
?>

<h1> Enrollment Related Reports</h1>
<form method="post" onsubmit="return false;">
  <table class="searchResults">
  <tr><td><h2><a href="applicationxlsBA1.php">Student Details Excel Report</a></h2></td></tr>
  <tr><td><h2><a href="studentxlsBA.php">Student Subject Enrollment Excel Report</a></h2></td></tr>
  <tr><td><h2><a href="RepeatEnroll_subject.php">Repeat Student Subject Enrollment Examination I</a></h2></td></tr>  
  <tr><td><h2><a href="medium.php">Students List- Medium</a></h2></td></tr> 
  <tr><td><h2><a href="appStream2019.php">Subject Students List- Examination 2</a></h2></td></tr>

  
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