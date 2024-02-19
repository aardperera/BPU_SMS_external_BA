<?php
  ob_start();
  
  include('dbAccess.php');

$db = new DBOperations();
  include('authcheck.inc.php');
?>

<h1> Enrollment Related Reports</h1>
<form method="post" onsubmit="return false;">
  <table class="searchResults">
  <tr><td><a href="paymentDetails.php">Payment Details Report</a></td></tr>
  <tr><td><a href="reportStudentInf.php"> Report</a></td></tr> 
  <tr><td><a href="reportSubjec.php"> Report</a></td></tr> 
  <tr><td><a href="reportCountr.php"> Report</a></td></tr> 
  </table>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Enrollment Related Reports - Applicants - Student Management System - Buddhisht & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='index.php'>Home </a></li><li>Enrollment Related Reports</ul>";
  //Apply the template
  include("master_registration.php");
?>