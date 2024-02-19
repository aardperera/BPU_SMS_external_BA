<?php
    error_reporting(E_ALL & ~E_WARNING);
?>


<?php
// Buffer larger content areas like the main page content
ob_start();
session_start();

if (!isset($_SESSION['authenticatedUser'])) {
    header("Location: index.php");
    exit(); // Ensure that the script stops execution after redirection
}

?>

<script language="javascript">
    // Your JavaScript code here
</script>
<script language="javascript" src="lib/scw/scw.js"></script>

<?php
include('dbAccess.php');

$db = new DBOperations();

// Fetch unique academic years
$queryAcademicYear = "SELECT DISTINCT acYear FROM exameffort";
$resultAcademicYear = $db->executeQuery($queryAcademicYear);

$academicYears = array();

while ($rowAcademicYear = $db->fetchAssoc($resultAcademicYear)) {
    $academicYears[] = $rowAcademicYear['acYear'];
}

// Fetch unique efforts
$queryEffort = "SELECT DISTINCT effort FROM exameffort";
$resultEffort = $db->executeQuery($queryEffort);

$efforts = array();

while ($rowEffort = $db->fetchAssoc($resultEffort)) {
    $efforts[] = $rowEffort['effort'];
}

include('authcheck.inc.php');
?>

<form method="post" onsubmit="return false;">
    <br>
    <label for="academicYear">Select Academic Year:</label>
    <select name="academicYear" id="academicYear">
        <?php foreach ($academicYears as $year) : ?>
            <option value="<?= $year ?>"><?= $year ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <label for="effort">Select Effort:</label>
    <select name="effort" id="effort">
        <?php foreach ($efforts as $effort) : ?>
            <option value="<?= $effort ?>"><?= $effort ?></option>
        <?php endforeach; ?>
    </select>
    <br><br>

    <!-- Print Excel button -->
    <button type="button" onclick="printEmptyExcel()">Print Excel</button>
</form>

<script>
    function printEmptyExcel() {
        var academicYear = document.getElementById("academicYear").value;
        var effort = document.getElementById("effort").value;
        // Construct the URL to the PHP script that generates the Excel file
        var excelUrl = "RepeatEnrollexls.php?academicYear=" + encodeURIComponent(academicYear) + "&effort=" + encodeURIComponent(effort);

        // Open the URL in a new tab
        window.open(excelUrl, '_blank');
    }
</script>

<?php
// Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Enter Results - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='index.php'>Enrollment Related </a></li><li>Course Payments</li></ul>";

// Apply the template
include("master_sms_external.php");
?>
