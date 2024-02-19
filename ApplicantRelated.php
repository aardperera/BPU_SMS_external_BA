<?php
    error_reporting(E_ALL & ~E_WARNING);
?>

<?php
  ob_start();
  
  include('dbAccess.php');

$db = new DBOperations();
  include('authcheck.inc.php');
?>


<h1> Applicant Related Details</h1>
<form method="post" onsubmit="return false;">
  <table class="searchResults">
  <tr><td><h2><a href="applicationxlsBA.php">Excel Report - Applicant Details</a> </h2></td></tr>
  <tr><td> <h2><a href="applicationxlsselectedBA.php">Excel Report - Selected Applicant Details </a></h2></td></tr> 

  
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