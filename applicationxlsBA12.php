<?php
session_start();

include('export.php');
$exportExcel = new Export();

include('dbAccess.php');
$db = new DBOperations();


if (!isset($_SESSION['authenticatedUser'])) {
    header("Location: index.php");
}

// Specify the query parameters
$yearEntry = 2019;
$courseID = 5;
$subcrsID = 8;

// Build the SQL query to fetch data from crs_enroll and ba_applicant tables
$query = "SELECT ce.studentID, ce.regNo, ce.IndexNo, ba.title, ba.nameEnglish, ba.nameSinhala, CONCAT(ba.addressE1, ' ', ba.addressE2, ' ', ba.addressE3) AS englishAddress, CONCAT(ba.addressS1, ' ', ba.addressS2, ' ', ba.addressS3) AS sinhalaAddress, ba.contactNo0, ba.email, ba.medium
          FROM crs_enroll ce
          INNER JOIN ba_applicant ba ON ce.studentID = ba.applicantID
          WHERE ce.yearEntry = $yearEntry AND ce.courseID = $courseID AND ce.subcrsID = $subcrsID";

$result = $db->executeQuery($query);

// Fetch the data into an array
$values = [];
while ($row = $db->Next_Record($result)) {



    //student_id
   $new_array = [][];
// select subject list

//subject list loop
// {
    //check each subject is enrolled for student_id
    // if yes    add a "Y" to $new_array
    // else add "" to $new_array
// }

//    merge $row with $new_array 
// $new_array [0][11]= "Y";
$new_array[0]["sub1"]= "Y";

// $new_array [0][12]= "";
$new_array[0]["sub2"]= "";

// $new_array [0][13]= "Y";
$new_array[0]["sub3"]= "Y";

// $new_array [0][14]= "Y";
$new_array[0]["sub4"]= "Y";

// $new_array [0][15]= "";
$new_array[0]["sub5"]= "";
print_r($row);
exit();
print_r($new_array);


$newrow = array_merge($row,$new_array);
    $values[] = $newrow;
}
// $values1 = ['Y','Y','Y','Y','Y','Y','Y','Y','Y'];

// $value=array_merge($values,$values1);


// Build the SQL query to fetch data from the subject table
$subjectQuery = "SELECT codeEnglish, nameEnglish, subjectID FROM subject WHERE courseID = $courseID AND subcrsID = $subcrsID";

$subjectResult = $db->executeQuery($subjectQuery);

// Fetch subject data into an array
$subjectValues = [];
while ($subjectRow = $db->Next_Record($subjectResult)) {
    $subjectValues[] = $subjectRow;
}

// Build the SQL query to fetch data from the subject_enroll table
$subjectEnrollQuery = "SELECT Enroll_id, subjectID FROM subject_enroll";

$subjectEnrollResult = $db->executeQuery($subjectEnrollQuery);

// Fetch subject_enroll data into an array
$subjectEnrollValues = [];
while ($subjectEnrollRow = $db->Next_Record($subjectEnrollResult)) {
    $subjectEnrollValues[$subjectEnrollRow['Enroll_id']][] = $subjectEnrollRow['subjectID'];
}

// Define Excel export properties
$titles = ['Student ID', 'Registration No', 'Index No', 'Title', 'Name (English)', 'Name (Sinhala)', 'Address (English)', 'Address (Sinhala)', 'Contact No', 'Email', 'Medium'];

$title = [
    ['name' => 'Student ID', 'width' => 15, 'type' => '', 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ['name' => 'Registration No', 'width' => 15, 'type' => '', 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ['name' => 'Index No', 'width' => 15, 'type' => '', 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ['name' => 'Title', 'width' => 10, 'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2, 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ['name' => 'Name (English)', 'width' => 30, 'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2, 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    ['name' => 'Name (Sinhala)', 'width' => 30, 'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2, 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    ['name' => 'Address (English)', 'width' => 50, 'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2, 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    ['name' => 'Address (Sinhala)', 'width' => 50, 'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2, 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    ['name' => 'Contact No', 'width' => 15, 'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2, 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ['name' => 'Email', 'width' => 25, 'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2, 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
    ['name' => 'Medium', 'width' => 10, 'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2, 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
];

// Add new titles for subject data
foreach ($subjectValues as $subjectRow) {
    $title[] = [
        'name' => $subjectRow['codeEnglish'] . ' ' . $subjectRow['nameEnglish'],
        'width' => 20,
        'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
        'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
    ];
}

$properties['titles'] = $title;
$properties['sheetnames'] = ['Enrollment Data'];
$properties['filename'] = 'Enrollment_Data';

$columns = ['studentID', 'regNo', 'IndexNo', 'title', 'nameEnglish', 'nameSinhala', 'englishAddress', 'sinhalaAddress', 'contactNo0', 'email', 'medium'];

// Add new columns for subject data
foreach ($subjectValues as $subjectRow) {
    $columns[] = $subjectRow['codeEnglish'] . '_' . $subjectRow['nameEnglish'];
}

// Export data to Excel
print_r($values);
exit();
$exportExcel->exportExcel($values, $columns, $properties);

// Iterate through the subject_enroll data and update the Excel file
foreach ($subjectEnrollValues as $enrollID => $enrolledSubjects) {
    $updateQuery = "UPDATE Enrollment_Data SET ";

    foreach ($enrolledSubjects as $subjectID) {

        $columnName = $subjectValues[$subjectID]['codeEnglish'] . '_' . $subjectValues[$subjectID]['nameEnglish'];
        $updateQuery .= "$columnName = 'Y', ";
    }

    // Remove the trailing comma and space
    $updateQuery = rtrim($updateQuery, ', ');

    // Add the WHERE clause based on the Enroll_id
    $updateQuery .= " WHERE Enroll_id = (SELECT Enroll_id FROM crs_enroll WHERE Enroll_id = $enrollID)";
    
    // Execute the update query
    $db->executeQuery($updateQuery);
}
?>
