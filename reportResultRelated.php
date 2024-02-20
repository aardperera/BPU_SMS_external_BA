<?php
    error_reporting(E_ALL & ~E_WARNING);
?>

<?php
  ob_start();
  
  include('dbAccess.php');

$db = new DBOperations();
  include('authcheck.inc.php');
?>

<h1> Examination Results Related Reports</h1>
<form method="post" onsubmit="return false;">
  <table class="searchResults">
  
    <tr><td><h2><a href="resultsSheetViewMain.php">Detailed Result Sheet without withheld Results</a></h2></td></tr>
    <tr><td><h2><a href="resultsSheetViewMain2.php">Detailed Result Sheet with withheld Results</a></h2></td></tr>
    <tr><td><h2><a href="repeatResultView.php">Repeat Result Sheet</a></h2></td></tr>
    <tr><td><h2><a href="rsWithRepeat.php">Detailed Result Sheet with Repeat Results</a></h2></td></tr>
    <tr><td><h2><a href="statusReport.php">Student Degree Status Report</a></h2></td></tr> 
    <tr><td><h2><a href="ResultViewNew.php">Repeat Subject of  Incompleted Students </a></h2></td></tr> 
    <tr><td><h2><a href="allAbsent.php">All Absent Student Report</a></h2></td></tr> 
    <tr><td><h2><a href="subPassFailAb.php">Pass/Fail/Absent/Withheld Student Details Subjectwise</a></h2></td></tr> 
    <tr><td><h2><a href="completeRe.php">Examination Subject Results Summary</a></h2></td></tr>
    <tr><td><h2><a href="transcript3Main.php">Examination Student Transcript </a></h2></td></tr>
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