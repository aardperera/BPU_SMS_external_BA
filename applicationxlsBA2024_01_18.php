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

$query = "SELECT * FROM ba_applicant WHERE courseID='".$_SESSION['courseId']."' and acyear='2023'";

$select = '';
if(isset($_GET['select'])) $select = $_GET['select'];

if($select != '')
    if($select != ''){
        $query = $query . " AND selection = '".$select."'";
    }

$query = $query . " order by applicantID";

$result = $db->executeQuery($query);

while($row = $db->Next_Record($result)){
    $studentID = $row['applicantID'];
    $queryqua = "SELECT * FROM  ba_qualifications WHERE applicantID='$studentID'";
    $resultqua = $db->executeQuery($queryqua);
    $row['address'] = $row['addressE1']. ' ' . $row['addressE2']. ' ' . $row['addressE3'];
    //$row['address'] = preg_match('/^[a-zA-Z .\-]+$/i', $row['nameEnglish']) ? $row['addressE1']. ' ' . $row['addressE2']. ' ' . $row['addressE3'] : $row['addressS1']. ' ' . $row['addressS2']. ' ' . $row['addressS3'];
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

//======================================================

$quli='';
$quli1=$quli2=$quli3=$quli4=$quli6=$quli7=$quli8=$quli9=$quli10=$quli11='';
if($rowqua['OL']=='1') $quli1= 'O/L, ';
elseif ($rowqua['AL']=='1') $quli2= 'A/L, ';
elseif ($rowqua['HDEnglish']=='1') $quli3= 'Higher Diploma English,';
elseif ($rowqua['HDPali']=='1') $quli4= 'Higher Diploma Pali,';
elseif ($rowqua['HDSans']=='1') $quli5= 'Higher Diploma Sanskrit,';
elseif ($rowqua['HDBud']=='1') $quli6= 'Higher Diploma Buddhisum,';
elseif ($rowqua['HDDaham']=='1') $quli7= 'Higher Diploma DahamSarasawiya,';
elseif ($rowqua['Darmacharya']=='1') $quli8= 'Dharmacharya,';
elseif ($rowqua['PrachinaM']=='1') $quli9= 'Prachina Maddhyam,';
elseif ($rowqua['PrachinaP']=='1') $quli10= 'Prachina Praramba,';
elseif ($rowqua['Degree']=='1') $quli11= 'Degree,';
elseif ($rowqua['Ctest']=='1') $quli12= 'Common Test';

//$quli=$quli1."-". $quli2."-". $quli3."-". $quli4."-". $quli5."-". $quli6."-". $quli7."-". $quli8."-". $quli9."-". $quli10."-". $quli11;
$quli=$quli1."". $quli2."". $quli3."". $quli4."". $quli5."". $quli6."". $quli7."". $quli8."". $quli9."". $quli10."". $quli11;
$row['quli']=$quli;

//========================================================
$applicantID = $row['applicantID'];
            $querysub = "SELECT * FROM  ba_subjects WHERE applicantID='$applicantID'";
           
            $resultsub= $db->executeQuery($querysub);
            
            $row['pending'] = false;

            $rowsub= $db->Next_Record($resultsub);

          
            
            $sub1=$sub2=$sub3=$sub4=$sub5=$sub6=$sub7=$sub8=$sub9=$sub10=$sub11='';
           
            if ($rowsub['bp']=='1') $sub1= 'Buddist Philosophy,';
            if ($rowsub['bc']=='1') $sub2= 'Buddist Culture,';
            if ($rowsub['pali']=='1') $sub3= 'Pali,';
            if ($rowsub['san']=='1') $sub4= 'Sanskrit,';
            if ($rowsub['eng']=='1') $sub5= 'English,';
            if ($rowsub['arch']=='1') $sub6= 'Archaeology,';
            if ($rowsub['rs']=='1') $sub7= 'Religious Study,';
            if ($rowsub['sin']=='1') $sub8= 'Sinhala';
            if ($rowsub['esin']=='1')  $sub9= 'Sinhala,';
            if ($rowsub['bcon']=='1') $sub10= 'Buddist Councelling,';
            if ($rowsub['tamil']=='1') $sub11= 'Tamil';

            $row['comsub']=$sub1." ". $sub2." ". $sub3." ". $sub4." ". $sub5." ". $sub6." ". $sub7." ". $sub8;
            $row['elesub']=$sub9." ". $sub10." ". $sub11;



//========================================================

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

$titles=['ID', 'Title', 'Name', 'Address', 'NIC No.', 'Mobile No.','Email','Birthday', 'Medium of Study', 'Qualification', 'Main Subjects', 'Elective Subjects', 'Payment' ];

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
            'name' => 'Qualification',
            'width'=> 35,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Main Subjects',
            'width'=> 45,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Elective Subjects',
            'width'=> 35,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
        ],
        [
            'name' => 'Certificate',
            'width'=> 10,
            'type' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2,
            'algn' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
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

$columns=['applicantID', 'title', 'nameEnglish', 'initials', 'nameFullEnglish', 'address', 'city', 'postalcode', 'districtstate', 'country', 'nic', 'mobile', 'email', 'passport', 'birthday', 'age', 'gender', 'civilStatus', 'citizenship', 'religion', 'employment', 'employer', 'medium', 'field', 'quli','comsub','elesub','certificate', 'photos', 'payment', 'selection', 'selection_date', 'c_payment', 'c_payment_date'];

$exportExcel->exportExcel($values, $columns, $properties);
