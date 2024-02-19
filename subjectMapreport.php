<?php
session_start();

include('export.php');
$exportExcel = new Export();

include('dbAccess.php');
$db = new DBOperations();

ob_start();
// Removed the second session_start() call
if (!isset($_SESSION['authenticatedUser'])) {
    header("Location: index.php");
}
?>

<h1>Subject Mapping</h1>

<div>
    <button onclick="loadReportTable()">Load Report</button>
    <button onclick="exportAsExcel()">Export as Excel</button>
</div>
<br>
<div id="reportTableContainer"></div>

<?php 

$sql = "SELECT m.from_date, m.to_date, m.first_subid, m.second_subid, m.third_subid,
               CONCAT(s1.codeEnglish, ' ', s1.nameEnglish) AS first_subject,
               CONCAT(s2.codeEnglish, ' ', s2.nameEnglish) AS second_subject,
               CONCAT(s3.codeEnglish, ' ', s3.nameEnglish) AS third_subject
        FROM map_sub_to_years m
        LEFT JOIN subject s1 ON m.first_subid = s1.subjectID
        LEFT JOIN subject s2 ON m.second_subid = s2.subjectID
        LEFT JOIN subject s3 ON m.third_subid = s3.subjectID";

$result = $db->executeQuery($sql);
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>

<script>
    function loadReportTable() {
        // Create a table with specified fields
        var tableHtml = '<table border="1">';
        tableHtml += '<tr><th>From Date</th><th>To Date</th><th>First Subject ID</th><th>First Subject Name</th><th>Second Subject ID</th><th>Second Subject Name</th><th>Third Subject ID</th><th>Third Subject Name</th></tr>';

        <?php
        // Check if there are rows in the result
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Output a new row for each record in the result
                echo "tableHtml += '<tr><td>" . $row["from_date"] . "</td><td>" . $row["to_date"] . "</td>";
                
                // First Subject
                echo "<td>" . $row["first_subid"] . "</td><td>" . $row["first_subject"] . "</td>";
                
                // Second Subject
                echo "<td>" . $row["second_subid"] . "</td><td>" . $row["second_subject"] . "</td>";
                
                // Third Subject
                echo "<td>" . $row["third_subid"] . "</td><td>" . $row["third_subject"] . "</td></tr>';\n";
            }
        }
        ?>

        tableHtml += '</table>';

        // Display the table in the reportTableContainer div
        document.getElementById('reportTableContainer').innerHTML = tableHtml;
    }

	function exportAsExcel() {
    // Extract data from the HTML table
    var table = document.querySelector('table');
    var tableData = Array.from(table.rows).map(row => Array.from(row.cells).map(cell => cell.textContent));

    // Create a worksheet
    var ws = XLSX.utils.aoa_to_sheet(tableData);

    // Create a workbook
    var wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Sheet1");

    // Customize the style of the Excel sheet
    var wscols = [];
    for (var i = 0; i < table.rows[0].cells.length; i++) {
        wscols.push({ wch: table.rows[0].cells[i].textContent.length + 5 });
    }
    ws['!cols'] = wscols;

    // Add borders to the table
    var range = XLSX.utils.decode_range(ws['!ref']);
    for (var R = range.s.r; R <= range.e.r; ++R) {
        for (var C = range.s.c; C <= range.e.c; ++C) {
            var cell_address = { c: C, r: R };
            var cell = ws[XLSX.utils.encode_cell(cell_address)];
            if (!cell) continue;

            // Add borders to each cell
			cell.s = { border: { top: { style: "thin", color: { rgb: "000000" } }, bottom: { style: "thin", color: { rgb: "000000" } }, left: { style: "thin", color: { rgb: "000000" } }, right: { style: "thin", color: { rgb: "000000" } } } };

        }
    }

    // Save the workbook as an Excel file
    XLSX.writeFile(wb, 'exported_data.xlsx');
}




</script>
<?php
// Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Subjects - Subject Mapping - Student Management System - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='subjectMap.php'>Subjects </a></li><li>Subject Mapping</li></ul>";

// Apply the template
include("master_sms_external.php");
?>
