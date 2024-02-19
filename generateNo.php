<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();

if (!isset($_SESSION['authenticatedUser'])) {
//	echo $_SESSION['authenticatedUser'];
	header("Location: index.php");
}
?>


<script language="javascript">
 	function MsgOkCancel()	{
		var message = "Please confirm to DELETE this entry...";
		var return_value = confirm(message);
		return return_value;
	}
</script>
<script language="javascript" src="lib/scw/scw.js"></script>
    <?php
include('dbAccess.php');

$db = new DBOperations();


if (isset($_POST['submit'])) {
    $year = $_POST['year'];

    // Clear the existing data in the generate_temp_order table for the selected year
    $db->executeQuery("DELETE FROM generate_temp_order WHERE entryyear = '$year'");

    // Reset the AUTO_INCREMENT value for the 'id' field to 1
    $db->executeQuery("ALTER TABLE generate_temp_order AUTO_INCREMENT = 1");

    // Define an array to order for titles
    $customTitleOrder = array("Ven.", "Mr.", "Mrs.", "Miss.");
    $customGenderOrder = array("Male", "Female");
    
    $titleOrder = implode("','", $customTitleOrder);
    $GenderOrder = implode("','", $customGenderOrder);
    

    $streamMediumCombinations = array(
        array("stream" => "BS", "medium" => "Sinhala"),
        array("stream" => "LS", "medium" => "Sinhala"),
        array("stream" => "BS", "medium" => "English"),
        array("stream" => "LS", "medium" => "English")
    );

    foreach ($streamMediumCombinations as $combination) {
        $stream = $combination['stream'];
        $medium = $combination['medium'];

        // Fetch data from ba_applicant for the selected academic year, stream, medium, and order by title
        $result = $db->executeQuery("SELECT  applicantID, acyear, stream, title, medium, gender FROM ba_applicant WHERE acYear = '$year' AND stream = '$stream' AND medium = '$medium' ORDER BY FIELD(title, '$titleOrder'),FIELD(gender, '$GenderOrder')");
        //$result = $db->executeQuery("SELECT  applicantID, acyear, stream, title, medium, gender FROM ba_applicant WHERE acYear = '$year' AND stream = '$stream' AND medium = '$medium' ORDER BY FIELD(title, 'Ven.') DESC ,FIELD(gender,'Male','Female'), FIELD(title, FIELD(title, '" . implode("','", $customTitleOrder) . "'))");
        //print "SELECT  applicantID, acyear, stream, title, medium FROM ba_applicant WHERE acYear = '$year' AND stream = '$stream' AND medium = '$medium' ORDER BY FIELD(title, '$titleOrder')";

        // Insert the data into generate_temp_order table

        while ($row = $db->Next_Record($result)) {
            
            $applicantID = $row['applicantID']; 
            $title = $row['title'];
            $acyear = $row['acyear'];
            $medium = $row['medium'];
            $gender = $row['gender'];

            //$acyear = $acyear - 1;

            $insertQuery = "INSERT INTO generate_temp_order (applicantID, entryyear, stream, title, acyear, medium, Gender) VALUES ('$applicantID', '$year', '$stream', '$title', '$acyear', '$medium','$gender')";
           // print "hello===========================";
//print  $insertQuery;
            $db->executeQuery($insertQuery);

           $result1 = $db->executeQuery("SELECT id FROM generate_temp_order WHERE applicantID = '$applicantID' ");
           
         
           while ($row1 = $db->Next_Record($result1)) {
            $id = $row1['id'];
            
            // Generate a four-digit padded ID
            $paddedId = str_pad($id, 4, '0', STR_PAD_LEFT);
            $paddedId1 = str_pad($id, 3, '0', STR_PAD_LEFT);
        
            // Build the indexno value with the required format
            $mediumFirstLetter = substr($medium, 0, 1);
            $RegNo = "EC/$stream/$mediumFirstLetter/$acyear/$paddedId";
            $indexNo="20226$paddedId1";
            //print $RegNo;
            // Update the row 
            $updateQuery = "UPDATE generate_temp_order SET RegNo = '$RegNo',indexNo = '$indexNo' WHERE id = $id";
           
            $db->executeQuery($updateQuery);


           
            
            
        }
        
        }
    }
    //echo "Task Completed";
}
if (isset($_POST['update'])) {
   
    // Retrieve data from generate_temp_order based on applicantID
    $result2 = $db->executeQuery("SELECT RegNo,indexNo,acyear,applicantID FROM generate_temp_order ");
    //print "SELECT RegNo,indexNo,acyear,applicantID FROM generate_temp_order ";
    while ($row2 = $db->Next_Record($result2)) {
        $RegNo = $row2['RegNo'];
        $indexNo = $row2['indexNo'];
        $acyear = $row2['acyear'];
        $applicantID = $row2['applicantID'];
       
        
        // Update the regNo and RegNo in the crs_enroll table
        $updateCrsEnrollQuery = "
        UPDATE crs_enroll
        SET regNo = '$RegNo',
            indexNo = '$indexNo'
        WHERE yearEntry = '$acyear' AND studentID = '$applicantID'";
        
        
        $db->executeQuery($updateCrsEnrollQuery);

        // Update the regNo and indexNo in the student_a table

        $updateStudentAQuery = "
        UPDATE student_a
        SET regNo = '$RegNo'
        WHERE acyear = '$acyear' AND studentID = '$applicantID'";
        
        $db->executeQuery($updateStudentAQuery);

    }
echo "Task Completed";
    
}
?>
<h1>Generate Registration No /IndexNo</h1>
<br />
<form action="" method="post">
    <table>
        <tr>
            <td>Entry Year : </td>
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


<script>
			function Function(item,value){
				var string = ""; string = value;
				document.getElementById(item).value = string;
				document.getElementById(item).innerHTML = value;
				//alert("item : " + item + ", value : " + value);
            }
</script>

<script>
    function payment(id1, id2, id3, id) {
        amount1 = parseInt(document.getElementById(id1).value);
        amount2 = parseInt(document.getElementById(id2).value);
        amount3 = parseInt(document.getElementById(id3).value);

        total = 0;
        if (!isNaN(amount1)) total += amount1;
        if (!isNaN(amount2)) total += amount2;
        if (!isNaN(amount3)) total += amount3;

        document.getElementById(id).value = total;
	}
</script>

<?php
//}else echo "<p>No exam details available.</p>";

//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Enter Results - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='index.php'>Enrollment Related </a></li><li>Course Payments</li></ul>";
//Apply the template
include("master_sms_external.php");
?>