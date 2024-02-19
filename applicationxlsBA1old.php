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
$yearEntry = 2022;
$courseID = 5;
$subcrsID = 7;





// Build the SQL query to fetch data from crs_enroll and ba_applicant tables
$query = "SELECT  ce.regNo,ce.studentID, ce.IndexNo, ba.nic, ba.title, ba.nameEnglish, ba.nameSinhala, CONCAT(ba.addressE1, ' ', ba.addressE2, ' ', ba.addressE3) AS englishAddress, CONCAT(ba.addressS1, ' ', ba.addressS2, ' ', ba.addressS3) AS sinhalaAddress, ba.contactNo0, ba.email, ba.medium
          FROM crs_enroll ce
          INNER JOIN ba_applicant ba ON ce.studentID = ba.applicantID
          WHERE ce.yearEntry = $yearEntry AND ce.courseID = $courseID AND ce.subcrsID = $subcrsID LIMIT 700";

$result = $db->executeQuery($query);

// Fetch the data into an array
$values = [];
$subjectQuery = "SELECT codeEnglish, nameEnglish, subjectID FROM subject WHERE courseID = $courseID AND subcrsID = $subcrsID";

$subjectResult = $db->executeQuery($subjectQuery);

while ($row = $db->Next_Record($result)) {

    // Manually define the array of subjects
$subjectNames = [
    'BUPH E-13014 Early Buddhism-Fundamental Teaching', 'BUPH E - 13024 Pre-Buddhist Religious and Philosophical Background in India', 'BUCU E 13014 Pre- Buddhist Indian Culture', 'BUCU E 13024 Origin of Buddhism and the Basic Concepts of Buddhist Culture ', 'PALI E 13015 Introduction to Pali Grammar', 'PALI E 13025 Pali Prescribed Texts - I', 'SANS E 13014 Introduction to Classical Sanskrit Literature', 'SANS E 13024 Introduction to Sanskrit Grammar', 'SINH E 13014 Introduction to Sinhala Language and Grammar', 'SINH E 13024 Classical and Modern Sinhala Poetic Sinhala
    ', 'ENGL E 13014 Advanced Reading and Writing Skills', 'ENGL E 13024 Introduction to English Literature', 'ARCH E 13014 History of Archaeology','ARCH E 13024 Archaeological Techniques and Methods','REST E 13014 Introduction to Religious Studies','REST E 13024 Theorotical Approches in Religious Studies','PALI E (C) 13013 Pali Prescribed Text and Study of Pali Literature','PALI E (C) 13023 Study of Pali Grammar','ITECE (C) 13024 Information Technology','SINH E (E)13034 Introduction to Sinhala Grammar','BUCL E (E)13044 Buddhist Psychology and Counselling','TAMI E (E)13054 Introduction to Tamil Language '
];

// Create an array of subjects with codeEnglish and nameEnglish
$subjectValues = [];
foreach ($subjectNames as $index => $subjectName) {
    $subjectValues[] = [
        'nameEnglish' => $subjectName,
    ];
}


    $regNo =    $row["regNo"];
    
    
   $new_array = [];


    $i = 1;
    // Fetch subject_enroll count data outside the loop
$subjectEnrollCounts = [];
foreach ($subjectValues as $subjectRow) {
    $subjectID = $subjectRow['subjectID'];
    $enrollCountQuery = "SELECT COUNT(ID) AS count1 FROM `subject_enroll`
                         WHERE `subjectID` = '$subjectID'
                         AND `Enroll_id` IN (SELECT `Enroll_id` FROM `crs_enroll`
                                            WHERE `regNo`='$regNo'
                                            AND `yearEntry` ='$yearEntry'
                                            AND `courseID` = '$courseID'
                                            AND `subcrsID` = '$subcrsID')";
    $enrollCountResult = $db->executeQuery($enrollCountQuery);
    $enrollCountRow = $db->Next_Record($enrollCountResult);
    $subjectEnrollCounts[$subjectID] = $enrollCountRow['count1'];
}

// Loop through subjects and update $new_array
$i = 1;
foreach ($subjectValues as $subjectRow) {
    $subjTitle = $subjectRow['nameEnglish'];
    $subjectID = $subjectRow['subjectID']; // Retrieve subjectID from $subjectRow

    if ($subjectEnrollCounts[$subjectID] == 0) {
        $pi = 10 + $i;
        $pii = $subjTitle;
        $new_array[$pi] = "";
        $new_array[$pii] = "";
    } else {
        $pi = 10 + $i;
        $pii = $subjTitle;
        $new_array[$pi] = "Yes";
        $new_array[$pii] = "Yes";
    }
    $i++;

}


$newrow = array_merge($row,$new_array);

usort($values, function ($a, $b) {
    return strcmp($a['regNo'], $b['regNo']);
});
    $values[] = $newrow;
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
$titles = [ 'Registration No','Student ID', 'Index No','NIC', 'Title', 'Name (English)', 'Name (Sinhala)', 'Address (English)', 'Address (Sinhala)', 'Contact No', 'Email', 'Medium'];

$title = [
   
    ['name' => 'Registration No', 'width' => 15, 'type' => '', 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ['name' => 'Student ID', 'width' => 15, 'type' => '', 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ['name' => 'Index No', 'width' => 15, 'type' => '', 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    ['name' => 'NIC', 'width' => 15, 'type' => '', 'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
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
        'name' => $subjectRow['nameEnglish'],
        'width' => 20,
        'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
        'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
    ];
}

$properties['titles'] = $title;
$properties['sheetnames'] = ['Enrollment Data'];
$properties['filename'] = 'Enrollment_Data';

$columns = [ 'regNo', 'studentID','IndexNo',"nic", 'title', 'nameEnglish', 'nameSinhala', 'englishAddress', 'sinhalaAddress', 'contactNo0', 'email', 'medium'];

foreach ($subjectValues as $subjectRow) {
    $columns[] = $subjectRow['codeEnglish'] . '_' . $subjectRow['nameEnglish'];
}

$exportExcel->exportExcel($values, $columns, $properties);


?>
