<?php

//Buffer larger content areas like the main page content
ob_start();
session_start();
if (!isset($_SESSION['authenticatedUser'])) {
    echo $_SESSION['authenticatedUser'];
    header("Location: index.php");
}

include('export.php');
$exportExcel = new Export();

include('dbAccess.php');
$db = new DBOperations();
$acyear='2019';

$query = "SELECT * FROM crs_enroll WHERE courseID='5' and yearEntry='$acyear' and subcrsID='8' ";
//print $query;

/*
$select = '';
if(isset($_GET['select'])) $select = $_GET['select'];

if($select != '')
    if($select != ''){
        $query = $query . " AND selection = '".$select."'";
    }
*/
$query = $query . " order by indexNo";

$result = $db->executeQuery($query);

while($row = $db->Next_Record($result)){
    $regNo = $row['regNo'];
    $indexNo = $row['indexNo'];
    $studentID = $row['studentID'];

    


//========================= Getting student details //==========================================


    $querystudent = "SELECT * FROM  ba_applicant WHERE applicantID='$studentID'";
    //print $querystudent;
    $resultstudent = $db->executeQuery($querystudent);
    $rowstudent = $db->Next_Record($resultstudent);
    $row['address'] = $rowstudent['addressE1']. "\r\n" . $rowstudent['addressE2']. "\r\n" . $rowstudent['addressE3'];
    //$row['address'] = preg_match('/^[a-zA-Z .\-]+$/i', $row['nameEnglish']) ? $row['addressE1']. ' ' . $row['addressE2']. ' ' . $row['addressE3'] : $row['addressS1']. ' ' . $row['addressS2']. ' ' . $row['addressS3'];
    $row['mobile'] = $rowstudent['countrycode2'] .'-' . $rowstudent['contactNo2'] . ', ' . $rowstudent['countrycode3'] .'-' . $rowstudent['contactNo3'];
    $row['medium'] = $rowstudent['medium'];
    $row['name'] = $rowstudent['nameEnglish'];
    $row['nic'] = $rowstudent['nic'];
    $row['title'] = $rowstudent['title'];
 

    




//====================================================== Getting Subjects ========================
$queryenroll = "Select Enroll_id from crs_enroll where  studentID='$studentID'  and yearEntry='$acyear' and courseID='5' and subcrsID='8' ";
//print $queryenroll;

$resultenroll = $db->executeQuery($queryenroll);
while ($rowenroll=  $db->Next_Record($resultenroll))
		{
			
            $enrollid=$rowenroll['Enroll_id'];
        }

$querysubject = "Select e.subjectID,s.codeEnglish,s.nameEnglish from subject_enroll as e,subject as s where  e.Enroll_id ='$enrollid'  and e.subjectID=s.subjectID ";
//print $querysubject;
                $resultsubject = $db->executeQuery($querysubject);
                while ($rowsubject=  $db->Next_Record($resultsubject))
                        {
                            $row['subjectcode'] = $row['subjectcode'] .  "\r\n " . $rowsubject['codeEnglish'];
                            $row['subjectName'] = $row['subjectName'] .  "\r\n " . $rowsubject['nameEnglish'];
                           
                        }
//========================================================
$values[] = $row;
}
 

$titles=['Registration No', 'Index No', 'Title', 'Name', 'Address', 'Contact No','NIC', 'Medium of Study', 'Subjects Code', 'Subjects Name'];

$title = [
        [
            'name' => 'Registration No',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Index No',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Title',
            'width'=> 5,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Name',
            'width'=> 40,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Address',
            'width'=> 40,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Contact No',
            'width'=> 50,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'NIC',
            'width'=> 20,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Medium of Study',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Subjects Code',
            'width'=> 20,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Subjects Name',
            'width'=> 80,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ]
       
        
    ];

$properties['titles'] = $title;
$properties['sheetnames'] = ['Student'];
$properties['filename'] = 'Student';

$columns=['regNo', 'indexNo', 'title', 'name', 'address', 'mobile', 'nic','medium', 'subjectcode', 'subjectName'];
//print_r($values) ;
$exportExcel->exportExcel($values, $columns, $properties);
