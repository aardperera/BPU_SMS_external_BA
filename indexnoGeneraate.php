<?php
ob_start();
?>
<head>
    <script language="javascript">
    </script>
    <script>
        function MsgOkCancel() {
            var message = "Please confirm to DELETE this item...";
            var return_value = confirm(message);
            return return_value;
        }
    </script>
</head>
<?php

require_once("dbAccess.php");
$db = new DBOperations();

include("authcheck.inc.php");



if (isset($_POST['submit'])) {
    $year = $_POST['year'];

    // Clear the existing data in the generate_temp_order table for the selected year
    $db->executeQuery("DELETE FROM generate_temp_order WHERE entryyear = '$year'");

    // Reset the AUTO_INCREMENT value for the 'id' field to 1
    $db->executeQuery("ALTER TABLE generate_temp_order AUTO_INCREMENT = 1");

    // Define an array to order for titles
    $customTitleOrder = array("Ven.", "Mr.", "Mrs.", "Miss.");

    
    $titleOrder = implode("','", $customTitleOrder);

    $streamMediumCombinations = array(
        array("stream" => "LS", "medium" => "Sinhala"),
        array("stream" => "LS", "medium" => "English"),
        array("stream" => "BS", "medium" => "Sinhala"),
        array("stream" => "BS", "medium" => "English")
    );

    foreach ($streamMediumCombinations as $combination) {
        $stream = $combination['stream'];
        $medium = $combination['medium'];

        // Fetch data from ba_applicant for the selected academic year, stream, medium, and order by title
        $result = $db->executeQuery("SELECT  applicantID, acyear, stream, title, medium FROM ba_applicant WHERE acYear = '$year' AND stream = '$stream' AND medium = '$medium' ORDER BY FIELD(title, '$titleOrder')");

        

        // Insert the data into generate_temp_order table

        while ($row = $db->Next_Record($result)) {
            
            $applicantID = $row['applicantID']; 
            $title = $row['title'];
            $acyear = $row['acyear'];
            $medium = $row['medium'];

            $acyear = $acyear - 1;

            $insertQuery = "INSERT INTO generate_temp_order (applicantID, entryyear, stream, title, acyear, medium) VALUES ('$applicantID', '$year', '$stream', '$title', '$acyear', '$medium')";
            $db->executeQuery($insertQuery);

           $result1 = $db->executeQuery("SELECT id FROM generate_temp_order WHERE applicantID = '$applicantID' ");
           
        
           while ($row1 = $db->Next_Record($result1)) {
            $id = $row1['id'];
            
            // Generate a four-digit padded ID
            $paddedId = str_pad($id, 4, '0', STR_PAD_LEFT);
        
            // Build the indexno value with the required format
            $mediumFirstLetter = substr($medium, 0, 1);
            $indexNo = "EC/$stream/$mediumFirstLetter/$acyear/$paddedId";
        
            // Update the row 
            $updateQuery = "UPDATE generate_temp_order SET indexno = '$indexNo' WHERE id = $id";
            $db->executeQuery($updateQuery);


           
            
            
        }
        
        }
    }
}
if (isset($_POST['update'])) {
   
    // Retrieve data from generate_temp_order based on applicantID
    $result2 = $db->executeQuery("SELECT indexno, acyear, applicantID FROM generate_temp_order ");
    
    while ($row2 = $db->Next_Record($result2)) {
        $indexno = $row2['indexno'];
        $acyear = $row2['acyear'];
        $applicantID = $row2['applicantID'];
       
        
        // Update the regNo and indexNo in the crs_enroll table
        $updateCrsEnrollQuery = "
        UPDATE crs_enroll
        SET regNo = '$indexno',
            indexNo = '$indexno'
        WHERE yearEntry = '$acyear' AND studentID = '$applicantID'";
        
        $db->executeQuery($updateCrsEnrollQuery);

        // Update the regNo and indexNo in the student_a table

        $updateStudentAQuery = "
        UPDATE student_a
        SET regNo = '$indexno'
        WHERE acyear = '$acyear' AND studentID = '$applicantID'";
        
        $db->executeQuery($updateStudentAQuery);
    }

    
}
?>

<form action="" method="post">
    <table>
        <tr>
            <td>Academic Year : </td>
            <td>
                <select name="year" id="year" required="true">
                    <?php
                    $result = $db->executeQuery("SELECT DISTINCT acYear FROM ba_applicant");
                    echo "<option value='0'>All</option>";
                    while ($row = $db->Next_Record($result)) {
                        $selected = ($row['acYear'] == $year) ? "selected" : "";
                        echo "<option value='" . $row['acYear'] . "' $selected>" . $row['acYear'] . "</option>";
                    }
                    ?>
                </select><br>
            </td>
        </tr>
    </table>
    <br><input type="submit" name="submit" value="Generate Index No"><br><br>
    <input type="submit" name="update" value="Update">
    <br><br>
</form>

<?php
// Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Applicants - Student Management System - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home</a></li><li>Calculate GPA</li></ul>";

// Apply the template
include("master_registration.php");
?>