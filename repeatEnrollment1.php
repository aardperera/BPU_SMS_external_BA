<?php
session_start();

// Check if the user is authenticated
if (!isset($_SESSION['authenticatedUser'])) {
    echo $_SESSION['authenticatedUser'];
    header("Location: index.php");
    exit(); // It's important to exit after a header redirect
}

// Include necessary files
require_once("dbAccess.php");
$db = new DBOperations();


// Initialize selected values
$selectedYear = $_POST['acyear'] ?? ''; // Assuming you're using POST method
$selectedCourse = $_POST['course'] ?? '';

?>

<h1>Repeat Student Enrollment</h1><br>







<!-- HTML Form -->
<form method="post" action="" class="plain">
    <table class="searchResults">
        <tr>
            <td>Academic Year:</td>
            <td>
                <select name="acyear" id="acyear" size="auto">
                    <?php
                    $result = $db->executeQuery("SELECT DISTINCT acyear FROM student_a");
                    while ($resultSet = $db->Next_Record($result)) {
                        $acyear = $resultSet["acyear"];
                        $selected = ($acyear == $selectedYear) ? 'selected' : '';
                        echo "<option value=\"$acyear\" $selected>$acyear</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Level:</td>
            <td>
                <select name="level" id="level" size="auto">
                    <?php
                    $result = $db->executeQuery("SELECT description FROM crs_sub WHERE courseID = 5");
                    while ($resultSet = $db->Next_Record($result)) {
                        $level = $resultSet["description"];
                        $selected = ($level == $selectedLevel) ? 'selected' : '';
                        echo "<option value=\"$level\" $selected>$level</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td>Course:</td>
            <td>
                <select name="course" id="course" size="auto">
                    <?php
                    $result = $db->executeQuery("SELECT codeEnglish,  nameEnglish , subjectID  FROM subject WHERE courseID = 5 AND subcrsID = 7");
                    while ($resultSet = $db->Next_Record($result)) {
                      $codeEnglish = $resultSet["codeEnglish"];
                      $nameEnglish = $resultSet["nameEnglish"];
                      $subjectID = $resultSet["subjectID"];
                      $course = $codeEnglish . " " . $nameEnglish;
                      $selected = ($subjectID == $selectedCourse) ? 'selected' : '';
                      echo "<option value=\"$subjectID\" $selected>$course</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2"><input type="submit" name="submit" value="Submit"></td>
        </tr>
    </table>
</form>

<?php

if (isset($_POST['submit'])) {
    
   

    // Check if the subject_enrollr table already has the selected subjectID
    $checkSubjectEnrollQuery = "SELECT COUNT(*) as count FROM subject_enrollr WHERE subjectID = '$selectedCourse'";
    $checkSubjectEnrollResult = $db->executeQuery($checkSubjectEnrollQuery);
    $subjectEnrollCount = $db->Next_Record($checkSubjectEnrollResult)['count'];

    if ($subjectEnrollCount > 0) {
        // SubjectID already exists in subject_enrollr, load the already enrolled data
        $enrolledDataQuery = "SELECT * FROM subject_enrollr WHERE subjectID = '$selectedCourse'";
        $enrolledDataResult = $db->executeQuery($enrolledDataQuery);

        // Display the already enrolled data
        echo "<h2>Already Enrolled Data</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Enroll_id</th><th>subjectID</th><th>enroll_date</th></tr>";

        while ($enrolledData = $db->Next_Record($enrolledDataResult)) {
            $enroll_id = $enrolledData['Enroll_id'];
            $subjectID = $enrolledData['subjectID'];
            $enroll_date = $enrolledData['enroll_date'];

            echo "<tr><td>$enroll_id</td><td>$subjectID</td><td>$enroll_date</td></tr>";
        }

        echo "</table>";
    }
    else {
        $subjectQuery = "SELECT indexNo, grade FROM exameffort WHERE effort = 1 AND subjectID = '$selectedCourse' AND acYear = ($selectedYear - 1) AND (marks < 40 OR marks = 'AB' OR withhold = 'WH')";
        $subjectResult = $db->executeQuery($subjectQuery);
    
        // Create and display the table
        echo "<table border='1'>";
        echo "<tr><th>Index No</th><th>Grade</th></tr>";
    
        while ($resultSet = $db->Next_Record($subjectResult)) {
            $indexNo = $resultSet['indexNo'];
            $grade = $resultSet['grade'];
    
            echo "<tr><td>$indexNo</td><td>$grade</td></tr>";
        }
    
        echo "</table>";
    } 
}
?>

<?php 
 
    echo '<form method="post" action="">';
    echo '<input type="hidden" name="selectedYear" value="' . htmlspecialchars($selectedYear) . '">';
    echo '<input type="hidden" name="selectedCourse" value="' . htmlspecialchars($selectedCourse) . '">';
    echo '<br><input type="submit" name="repeatEnroll" value="Repeat Enroll">';
    echo '</form>';



if (isset($_POST['repeatEnroll'])) {
  // Retrieve selected values from hidden fields
  $selectedYear = $_POST['selectedYear'] ?? '';
  $selectedCourse = $_POST['selectedCourse'] ?? '';

  // Fetch index numbers from the displayed table
  $indexNumbers = array();
  $subjectQuery = "SELECT indexNo FROM exameffort WHERE effort = 1 AND subjectID = '$selectedCourse' AND acYear = ($selectedYear - 1) AND (marks < 40 OR marks = 'AB' OR withhold = 'WH')";
  $subjectResult = $db->executeQuery($subjectQuery);

  while ($resultSet = $db->Next_Record($subjectResult)) {
      $indexNumbers[] = $resultSet['indexNo'];
  }

  // Insert data into crs_enrollr table for each index number
  foreach ($indexNumbers as $indexNo) {
      // Check if the index number already exists in crs_enrollr
      $checkQuery = "SELECT COUNT(*) as count FROM crs_enrollr WHERE indexNo = '$indexNo' AND yearEntry = '$selectedYear'";
      $checkResult = $db->executeQuery($checkQuery);
      $count = $db->Next_Record($checkResult)['count'];

      if ($count == 0) {
          // Index number doesn't exist, proceed with the insertion

          // Check if 'regNo' is not null for the given indexNo and yearEntry
          $regNoQuery = "SELECT regNo FROM crs_enrollr WHERE indexNo = '$indexNo' AND yearEntry = '$selectedYear'";
          $regNoResult = $db->executeQuery($regNoQuery);
          $regNo = $db->Next_Record($regNoResult)['regNo'];

          if ($regNo !== null) {
              // The subquery returned a non-null value, proceed with the insertion
              $insertQuery = "INSERT INTO crs_enrollr (regNo, indexNo, studentID, courseID, yearEntry, subcrsID) 
                              SELECT regNo, indexNo, studentID, '5' AS courseID, '$selectedYear' AS yearEntry, '7' AS subcrsID
                              FROM crs_enroll WHERE indexNo = '$indexNo' AND yearEntry = '$selectedYear'";
              $db->executeQuery($insertQuery);






              
      }
      
  }
}
$insertSubjectEnrollrQuery = "INSERT INTO subject_enrollr (Enroll_id, subjectID, enroll_date) 
                              SELECT crs_enrollr.Enroll_id, '$selectedCourse', NOW()
                              FROM crs_enrollr
                             ";
$insertSubjectEnrollrResult = $db->executeQuery($insertSubjectEnrollrQuery);






}
?>




