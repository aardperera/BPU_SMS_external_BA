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

$query = "SELECT * FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."'";

$select = '';
if(isset($_GET['select'])) $select = $_GET['select'];

if($select != '')
    if($select != ''){
        $query = $query . " AND selection = '".$select."'";
    }

$query = $query . " order by studentID";

$result = $db->executeQuery($query);

while($row = $db->Next_Record($result)){
    $studentID = $row['studentID'];
    $queryqua = "SELECT * FROM  ma_applicant_qualification WHERE studentID='$studentID'";
    $resultqua = $db->executeQuery($queryqua);

    $row['address'] = preg_match('/^[a-zA-Z .\-]+$/i', $row['nameEnglish']) ? $row['addressE1']. ' ' . $row['addressE2']. ' ' . $row['addressE3'] : $row['addressS1']. ' ' . $row['addressS2']. ' ' . $row['addressS3'];
    $row['mobile'] = $row['countrycode2'] .'-' . $row['contactNo2'] . ', ' . $row['countrycode3'] .'-' . $row['contactNo3'];
    $row['certificate'] = $row['certificate'] == 'Yes' ? $row['certificate'] : 'No';
    $row['photos'] = $row['photos'] == 'Yes' ? $row['photos'] : 'No';
    $row['selection'] = $row['selection'] == 'Cancel' ? '' : $row['selection'];

    $rowqua = $db->Next_Record($resultqua);
    $row['q_degree']    = $rowqua['degree'];
    $row['q_institute'] = $rowqua['institute'];
    $row['q_class']     = $rowqua['class'];

    if( $rowqua['class'] == 'Pending'){
        $row['colour'] = 'FFFF9966';
    }

    while($rowqua = $db->Next_Record($resultqua)){
        $row['q_degree'] = $row['q_degree'] . ', ' . $rowqua['degree'];
        $row['q_institute'] = $row['q_institute'] . ', ' . $rowqua['institute'];
        $row['q_class'] = $row['q_class'] . ', ' . $rowqua['class'];

        if($rowqua['class'] == 'Pending'){
            $row['colour'] = 'FFFF9966';
        }
    }

    if($row['payment'] < '1000'){
        $row['colour'] = 'FFFF9966';
    }

    $values[] = $row;
}

$titles=['ID', 'Title', 'Name', 'Address', 'NIC No.', 'Mobile No.', 'Intended Degree Programme', 'Medium of Study', 'Field of Study', 'Degree', 'University', 'Class', 'Payment' ];

$title = [
        [
            'name' => 'ID',
            'width'=> 5,
            'type' => '',
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Title',
            'width'=> 5,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Name with Initials',
            'width'=> 40,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Names Denoted by Initials',
            'width'=> 40,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Full Name in English',
            'width'=> 40,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Address',
            'width'=> 50,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'City',
            'width'=> 20,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Postal Code',
            'width'=> 10,
            'type' => '',
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'District/State',
            'width'=> 20,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Country',
            'width'=> 20,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'NIC No.',
            'width'=> 15,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Mobile No.',
            'width'=> 20,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Email',
            'width'=> 25,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Passport',
            'width'=> 25,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Birthday',
            'width'=> 12,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Age',
            'width'=> 6,
            'type' => '',
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Gender',
            'width'=> 8,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Civil Status',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Citizenship',
            'width'=> 15,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Religion',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Occupation',
            'width'=> 20,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Place of the Work',
            'width'=> 25,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Intended Degree Programme',
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
            'name' => 'Field of Study',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Degree',
            'width'=> 35,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'University',
            'width'=> 35,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Class',
            'width'=> 20,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Certificate',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Photo',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Application Payment',
            'width'=> 12,
            'type' => '',
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
        ],
        [
            'name' => 'Selection',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Selection Date',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ],
        [
            'name' => 'Course Payment',
            'width'=> 12,
            'type' => '',
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT
        ],
        [
            'name' => 'Payment Date',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
        ]
    ];

$properties['titles'] = $title;
$properties['sheetnames'] = ['Applications'];
$properties['filename'] = 'Applications';

$columns=['studentID', 'title', 'nameEnglish', 'initials', 'nameFullEnglish', 'address', 'city', 'postalcode', 'districtstate', 'country', 'nic', 'mobile', 'email', 'passport', 'birthday', 'age', 'gender', 'civilStatus', 'citizenship', 'religion', 'employment', 'employer', 'degree', 'medium', 'field', 'q_degree', 'q_institute', 'q_class', 'certificate', 'photos', 'payment', 'selection', 'selection_date', 'c_payment', 'c_payment_date'];

$exportExcel->exportExcel($values, $columns, $properties);
