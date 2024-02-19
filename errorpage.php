<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if (!isset($_SESSION['authenticatedUser'])) {
    echo $_SESSION['authenticatedUser'];
    header("Location: index.php");
}
?>

<div align="center">
    <img width="200px" height="auto" style="float:none; border:none;" src="img/error2.gif" />
    <h2>Something went wrong....</h2>
    <h5>Please contact your administrator</h5>
</div>

<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Error - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li></ul>";
//Apply the template
include("master_sms_external.php");
?>