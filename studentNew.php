<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if (!isset($_SESSION['authenticatedUser'])) {
	echo $_SESSION['authenticatedUser'];
	header("Location: index.php");
}
?>

<script language="javascript" src="lib/scw/scw.js"></script>

<style>
table, th, td {
         border: 1px solid #fff;
         padding:5px;
      }
</style>

<h1>New Students Registration </h1>
<?php
include('dbAccess.php');
$db = new DBOperations();

$acyear = '';

if(isset($_GET['acyear']))   $acyear  = $_GET['acyear'];
if(isset($_POST['acyear']))  $acyear  = $_POST['acyear'];

//$query = "SELECT * FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND selection='Selected'";

$queryyr = "SELECT acyear FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND selection='Selected'";

$queryyr = $queryyr . " GROUP BY acyear";
$resulty = $db->executeQuery($queryyr);

//if($acyear != ''){
//    $query = $query . " AND acyear = '".$acyear."'";
//}

//$query = $query . " ORDER BY field(title, 'Ven.') desc, field(gender, 'Male', 'Female'), studentID";

//$result = $db->executeQuery($query);

if (isset($_POST['register'])) {
    //print_r($_POST);
    foreach($_POST['id'] as $id => $studentID){
         //echo $id . " => " . $studentID . '<br/>';
         $query = "SELECT studentID, title, nameEnglish, nameSinhala, email, courseID, acyear, medium, contactNo2 FROM `ma_applicant` WHERE id = '".$id."'";
         $result = $db->executeQuery($query);
         $row = $db->Next_Record($result);

         //echo  $id . $studentID . $row['nameEnglish'] . '<br/>';


         //check for record
         $query = "SELECT applicantID FROM `student` WHERE applicantID = '".$id."'";
         $result = $db->executeQuery($query);

         if($db->Row_Count($result) == 0){
             //insert
             $query = "INSERT INTO `student` (studentID, applicantID, title, nameEnglish, email, courseID, acyear, medium, contactNo1) VALUES('".$studentID."', '".$id."', '".$row['title']."', '".$row['nameEnglish']."', '".$row['email']."', '".$row['courseID']."', '".$row['acyear']."', '".$row['medium']."', '".$row['contactNo2']."' )";
             $db->executeQuery($query);
         }
         else{
             //update
             $query = "UPDATE `student` set studentID = '".$studentID."' WHERE applicantID = '".$id."'";
             $db->executeQuery($query);
         }
    }

    header("location:studentAdmin.php");
}
?>

<form method="post" action="" class="plain" id="form1" name="form1">
    <table style="margin-left:8px" class="panel">
        <tr>
            <td>
                <select id="acyear" name="acyear" onChange="document.form1.submit()">
                    <option value="" >Select an Year</option>
                    <?php 
                    $entry = false;
                    while($rowy = $db->Next_Record($resulty)) {
                    ?>
                        <option value="<?php echo $rowy[0]; ?>"  <?php if ($acyear == $rowy[0]) echo 'selected'; ?> ><?php echo $rowy[0]; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
            <td>
                <input type="submit" id="register" name="register" value="Register" />
            </td>
            <td>
                <input hidden type="text" id="date" name="date" value=" <?php echo $date; ?> " />
            </td>
        </tr>
    </table>


    
    <?php
    //bs sin
    $query = "SELECT * FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND selection='Selected'";
    if($acyear != ''){
        $query = $query . " AND acyear = '".$acyear."'";
    }
    $query = $query . " AND field = 'Buddhist Studies' AND medium = 'Sinhala' ORDER BY field(title, 'Ven.') desc, field(gender, 'Male', 'Female'), studentID";
    $result = $db->executeQuery($query);

    $i = 1;
    if ($db->Row_Count($result)>0 && $acyear != ''){ ?>
    <br />
    <table class="applicant" width="100%">
        <tr>
            <th style="width:1%;">ID</th>
            <th style="width:2%;">Title</th>
            <th style="width:15%;">Name</th>
            <th style="width:5%;">Gender</th>
            <th style="width:8%;">Mobile No.</th>
            <th style="width:5%;">Intended Degree Programme</th>
            <th style="width:5%;">Medium of Study</th>
            <th style="width:5%;">Field of Study</th>
            <th style="width:5%;">Certi- ficate</th>
            <th style="width:3%;">Appli- cation Pay.</th>
            <th style="width:5%;">Selection</th>
            <th style="width:5%;">Course Payment</th>
            <th style="width:5%;">Student ID</th>
        </tr>

        <?php
              while($row = $db->Next_Record($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['studentID'] ?>
            </td>
            <td>
                <?php echo $row['title'] ?>
            </td>
            <td style="font-size:110%;">
                <?php echo $row['nameEnglish'] ?>
            </td>
            <td align="center">
                <?php echo $row['gender'] ?>
            </td>
            <td>
                <?php echo $row['countrycode2']; ?>-<?php echo $row['contactNo2']; ?>
                <br/>
                <?php echo $row['countrycode3']; ?>-<?php echo $row['contactNo3']; ?>
            </td>
            <td>
                <?php echo $row['degree'] ?>
            </td>
            <td>
                <?php echo $row['medium'] ?>
            </td>
            <td>
                <?php echo $row['field'] ?>
            </td>
            
            <!--
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?> >
                <?php echo $row['q_degree'] ?>
            </td>
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_institute'] ?>
            </td>
            <td align="center" <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_class'] ?>
            </td>
                -->
            <td align="center">
                <?php echo $row['certificate'] == 'Yes' ? $row['certificate'] : 'No' ?>
            </td>
            <td align="right" <?php if($row['payment'] < 1000) echo 'bgcolor=#f4a261' ?> >
                <?php echo $row['payment'] ?>
            </td>
            <td align="center">
                <?php if ($row['selection'] == 'Cancel') echo '';  else echo $row['selection']; ?>
            </td>
            <td align="right">
                <?php echo $row['c_payment'] ?>
            </td>
            <td>
                <input style="width:110px; font-size:12px;" type="text" readonly id="id[<?php echo $row['id'] ; ?>]" name="id[<?php echo $row['id'] ; ?>]" value="<?php echo 'MA/BS(S)/' . $acyear . '/' . $i; $i++; ?>" />
            </td>
        </tr>
        <?php
              }

        ?>
    </table>
    <?php         
    }
    ?>

    <?php
    //bs en
    $query = "SELECT * FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND selection='Selected'";
    if($acyear != ''){
        $query = $query . " AND acyear = '".$acyear."'";
    }
    $query = $query . " AND field = 'Buddhist Studies' AND medium = 'English' ORDER BY field(title, 'Ven.') desc, field(gender, 'Male', 'Female'), studentID";
    $result = $db->executeQuery($query);
    $i = 1; 
    if ($db->Row_Count($result)>0 && $acyear != ''){ ?>
    <br />
    <table class="applicant" width="100%">
        <tr>
            <th style="width:1%;">ID</th>
            <th style="width:2%;">Title</th>
            <th style="width:15%;">Name</th>
            <th style="width:5%;">Gender</th>
            <th style="width:8%;">Mobile No.</th>
            <th style="width:5%;">Intended Degree Programme</th>
            <th style="width:5%;">Medium of Study</th>
            <th style="width:5%;">Field of Study</th>
            <th style="width:5%;">Certi- ficate</th>
            <th style="width:3%;">Appli- cation Pay.</th>
            <th style="width:5%;">Selection</th>
            <th style="width:5%;">Course Payment</th>
            <th style="width:5%;">Student ID</th>
        </tr>

        <?php
        while($row = $db->Next_Record($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['studentID'] ?>
            </td>
            <td>
                <?php echo $row['title'] ?>
            </td>
            <td style="font-size:110%;">
                <?php echo $row['nameEnglish'] ?>
            </td>
            <td align="center">
                <?php echo $row['gender'] ?>
            </td>
            <td>
                <?php echo $row['countrycode2']; ?>-<?php echo $row['contactNo2']; ?>
                <br/>
                <?php echo $row['countrycode3']; ?>-<?php echo $row['contactNo3']; ?>
            </td>
            <td>
                <?php echo $row['degree'] ?>
            </td>
            <td>
                <?php echo $row['medium'] ?>
            </td>
            <td>
                <?php echo $row['field'] ?>
            </td>
            
            <!--
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?> >
                <?php echo $row['q_degree'] ?>
            </td>
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_institute'] ?>
            </td>
            <td align="center" <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_class'] ?>
            </td>
                -->
            <td align="center">
                <?php echo $row['certificate'] == 'Yes' ? $row['certificate'] : 'No' ?>
            </td>
            <td align="right" <?php if($row['payment'] < 1000) echo 'bgcolor=#f4a261' ?> >
                <?php echo $row['payment'] ?>
            </td>
            <td align="center">
                <?php if ($row['selection'] == 'Cancel') echo '';  else echo $row['selection']; ?>
            </td>
            <td align="right">
                <?php echo $row['c_payment'] ?>
            </td>
            <td>
                <input style="width:110px; font-size:12px;" type="text" readonly id="id[<?php echo $row['id'] ; ?>]" name="id[<?php echo $row['id'] ; ?>]" value="<?php echo 'MA/BS(E)/' . $acyear . '/' . $i; $i++; ?>" />
            </td>
        </tr>
        <?php
        }

        ?>
    </table>
    <?php         
    }
    ?>

    <?php
    //sans sin
    $query = "SELECT * FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND selection='Selected'";
    if($acyear != ''){
        $query = $query . " AND acyear = '".$acyear."'";
    }
    $query = $query . " AND field = 'Sanskrit' AND medium = 'Sinhala' ORDER BY field(title, 'Ven.') desc, field(gender, 'Male', 'Female'), studentID";
    $result = $db->executeQuery($query);
    $i = 1;
    if ($db->Row_Count($result)>0 && $acyear != ''){ ?>
    <br />
    <table class="applicant" width="100%">
        <tr>
            <th style="width:1%;">ID</th>
            <th style="width:2%;">Title</th>
            <th style="width:15%;">Name</th>
            <th style="width:5%;">Gender</th>
            <th style="width:8%;">Mobile No.</th>
            <th style="width:5%;">Intended Degree Programme</th>
            <th style="width:5%;">Medium of Study</th>
            <th style="width:5%;">Field of Study</th>
            <th style="width:5%;">Certi- ficate</th>
            <th style="width:3%;">Appli- cation Pay.</th>
            <th style="width:5%;">Selection</th>
            <th style="width:5%;">Course Payment</th>
            <th style="width:5%;">Student ID</th>
        </tr>

        <?php
        while($row = $db->Next_Record($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['studentID'] ?>
            </td>
            <td>
                <?php echo $row['title'] ?>
            </td>
            <td style="font-size:110%;">
                <?php echo $row['nameEnglish'] ?>
            </td>
            <td align="center">
                <?php echo $row['gender'] ?>
            </td>
            <td>
                <?php echo $row['countrycode2']; ?>-<?php echo $row['contactNo2']; ?>
                <br/>
                <?php echo $row['countrycode3']; ?>-<?php echo $row['contactNo3']; ?>
            </td>
            <td>
                <?php echo $row['degree'] ?>
            </td>
            <td>
                <?php echo $row['medium'] ?>
            </td>
            <td>
                <?php echo $row['field'] ?>
            </td>
            
            <!--
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?> >
                <?php echo $row['q_degree'] ?>
            </td>
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_institute'] ?>
            </td>
            <td align="center" <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_class'] ?>
            </td>
                -->
            <td align="center">
                <?php echo $row['certificate'] == 'Yes' ? $row['certificate'] : 'No' ?>
            </td>
            <td align="right" <?php if($row['payment'] < 1000) echo 'bgcolor=#f4a261' ?> >
                <?php echo $row['payment'] ?>
            </td>
            <td align="center">
                <?php if ($row['selection'] == 'Cancel') echo '';  else echo $row['selection']; ?>
            </td>
            <td align="right">
                <?php echo $row['c_payment'] ?>
            </td>
            <td>
                <input style="width:110px; font-size:12px;" type="text" readonly id="id[<?php echo $row['id'] ; ?>]" name="id[<?php echo $row['id'] ; ?>]" value="<?php echo 'MA/SA(S)/' . $acyear . '/' . $i; $i++; ?>" />
            </td>
        </tr>
        <?php
        }

        ?>
    </table>
    <?php         
    }
    ?>

    <?php
    //sans en
    $query = "SELECT * FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND selection='Selected'";
    if($acyear != ''){
        $query = $query . " AND acyear = '".$acyear."'";
    }
    $query = $query . " AND field = 'Sanskrit' AND medium = 'English' ORDER BY field(title, 'Ven.') desc, field(gender, 'Male', 'Female'), studentID";
    $result = $db->executeQuery($query);
    $i = 1;
    if ($db->Row_Count($result)>0 && $acyear != ''){ ?>
    <br />
    <table class="applicant" width="100%">
        <tr>
            <th style="width:1%;">ID</th>
            <th style="width:2%;">Title</th>
            <th style="width:15%;">Name</th>
            <th style="width:5%;">Gender</th>
            <th style="width:8%;">Mobile No.</th>
            <th style="width:5%;">Intended Degree Programme</th>
            <th style="width:5%;">Medium of Study</th>
            <th style="width:5%;">Field of Study</th>
            <th style="width:5%;">Certi- ficate</th>
            <th style="width:3%;">Appli- cation Pay.</th>
            <th style="width:5%;">Selection</th>
            <th style="width:5%;">Course Payment</th>
            <th style="width:5%;">Student ID</th>
        </tr>

        <?php
        while($row = $db->Next_Record($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['studentID'] ?>
            </td>
            <td>
                <?php echo $row['title'] ?>
            </td>
            <td style="font-size:110%;">
                <?php echo $row['nameEnglish'] ?>
            </td>
            <td align="center">
                <?php echo $row['gender'] ?>
            </td>
            <td>
                <?php echo $row['countrycode2']; ?>-<?php echo $row['contactNo2']; ?>
                <br/>
                <?php echo $row['countrycode3']; ?>-<?php echo $row['contactNo3']; ?>
            </td>
            <td>
                <?php echo $row['degree'] ?>
            </td>
            <td>
                <?php echo $row['medium'] ?>
            </td>
            <td>
                <?php echo $row['field'] ?>
            </td>
            
            <!--
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?> >
                <?php echo $row['q_degree'] ?>
            </td>
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_institute'] ?>
            </td>
            <td align="center" <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_class'] ?>
            </td>
                -->
            <td align="center">
                <?php echo $row['certificate'] == 'Yes' ? $row['certificate'] : 'No' ?>
            </td>
            <td align="right" <?php if($row['payment'] < 1000) echo 'bgcolor=#f4a261' ?> >
                <?php echo $row['payment'] ?>
            </td>
            <td align="center">
                <?php if ($row['selection'] == 'Cancel') echo '';  else echo $row['selection']; ?>
            </td>
            <td align="right">
                <?php echo $row['c_payment'] ?>
            </td>
            <td>
                <input style="width:110px; font-size:12px;" type="text" readonly id="id[<?php echo $row['id'] ; ?>]" name="id[<?php echo $row['id'] ; ?>]" value="<?php echo 'MA/SA(E)/' . $acyear . '/' . $i; $i++; ?>" />
            </td>
        </tr>
        <?php
        }

        ?>
    </table>
    <?php         
    }
    ?>

    <?php
    //pali sn
    $query = "SELECT * FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND selection='Selected'";
    if($acyear != ''){
        $query = $query . " AND acyear = '".$acyear."'";
    }
    $query = $query . " AND field = 'Pali' AND medium = 'Sinhala' ORDER BY field(title, 'Ven.') desc, field(gender, 'Male', 'Female'), studentID";
    $result = $db->executeQuery($query);
    if ($db->Row_Count($result)>0 && $acyear != ''){ ?>
    <br />
    <table class="applicant" width="100%">
        <tr>
            <th style="width:1%;">ID</th>
            <th style="width:2%;">Title</th>
            <th style="width:15%;">Name</th>
            <th style="width:5%;">Gender</th>
            <th style="width:8%;">Mobile No.</th>
            <th style="width:5%;">Intended Degree Programme</th>
            <th style="width:5%;">Medium of Study</th>
            <th style="width:5%;">Field of Study</th>
            <th style="width:5%;">Certi- ficate</th>
            <th style="width:3%;">Appli- cation Pay.</th>
            <th style="width:5%;">Selection</th>
            <th style="width:5%;">Course Payment</th>
            <th style="width:5%;">Student ID</th>
        </tr>

        <?php
        while($row = $db->Next_Record($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['studentID'] ?>
            </td>
            <td>
                <?php echo $row['title'] ?>
            </td>
            <td style="font-size:110%;">
                <?php echo $row['nameEnglish'] ?>
            </td>
            <td align="center">
                <?php echo $row['gender'] ?>
            </td>
            <td>
                <?php echo $row['countrycode2']; ?>-<?php echo $row['contactNo2']; ?>
                <br/>
                <?php echo $row['countrycode3']; ?>-<?php echo $row['contactNo3']; ?>
            </td>
            <td>
                <?php echo $row['degree'] ?>
            </td>
            <td>
                <?php echo $row['medium'] ?>
            </td>
            <td>
                <?php echo $row['field'] ?>
            </td>
            
            <!--
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?> >
                <?php echo $row['q_degree'] ?>
            </td>
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_institute'] ?>
            </td>
            <td align="center" <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_class'] ?>
            </td>
                -->
            <td align="center">
                <?php echo $row['certificate'] == 'Yes' ? $row['certificate'] : 'No' ?>
            </td>
            <td align="right" <?php if($row['payment'] < 1000) echo 'bgcolor=#f4a261' ?> >
                <?php echo $row['payment'] ?>
            </td>
            <td align="center">
                <?php if ($row['selection'] == 'Cancel') echo '';  else echo $row['selection']; ?>
            </td>
            <td align="right">
                <?php echo $row['c_payment'] ?>
            </td>
            <td>
                <input style="width:110px; font-size:12px;" type="text" readonly id="id[<?php echo $row['id'] ; ?>]" name="id[<?php echo $row['id'] ; ?>]" value="<?php echo 'MA/PL(S)/' . $acyear . '/' . $i; $i++; ?>" />
            </td>
        </tr>
        <?php
        }

        ?>
    </table>
    <?php         
    }
    ?>

    <?php
    //pali en
    $query = "SELECT * FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND selection='Selected'";
    if($acyear != ''){
        $query = $query . " AND acyear = '".$acyear."'";
    }
    $query = $query . " AND field = 'Pali' AND medium = 'English' ORDER BY field(title, 'Ven.') desc, field(gender, 'Male', 'Female'), studentID";
    $result = $db->executeQuery($query);
    $i = 1;
    if ($db->Row_Count($result)>0 && $acyear != ''){ ?>
    <br />
    <table class="applicant" width="100%">
        <tr>
            <th style="width:1%;">ID</th>
            <th style="width:2%;">Title</th>
            <th style="width:15%;">Name</th>
            <th style="width:5%;">Gender</th>
            <th style="width:8%;">Mobile No.</th>
            <th style="width:5%;">Intended Degree Programme</th>
            <th style="width:5%;">Medium of Study</th>
            <th style="width:5%;">Field of Study</th>
            <th style="width:5%;">Certi- ficate</th>
            <th style="width:3%;">Appli- cation Pay.</th>
            <th style="width:5%;">Selection</th>
            <th style="width:5%;">Course Payment</th>
            <th style="width:5%;">Student ID</th>
        </tr>

        <?php
        while($row = $db->Next_Record($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['studentID'] ?>
            </td>
            <td>
                <?php echo $row['title'] ?>
            </td>
            <td style="font-size:110%;">
                <?php echo $row['nameEnglish'] ?>
            </td>
            <td align="center">
                <?php echo $row['gender'] ?>
            </td>
            <td>
                <?php echo $row['countrycode2']; ?>-<?php echo $row['contactNo2']; ?>
                <br/>
                <?php echo $row['countrycode3']; ?>-<?php echo $row['contactNo3']; ?>
            </td>
            <td>
                <?php echo $row['degree'] ?>
            </td>
            <td>
                <?php echo $row['medium'] ?>
            </td>
            <td>
                <?php echo $row['field'] ?>
            </td>
            
            <!--
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?> >
                <?php echo $row['q_degree'] ?>
            </td>
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_institute'] ?>
            </td>
            <td align="center" <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_class'] ?>
            </td>
                -->
            <td align="center">
                <?php echo $row['certificate'] == 'Yes' ? $row['certificate'] : 'No' ?>
            </td>
            <td align="right" <?php if($row['payment'] < 1000) echo 'bgcolor=#f4a261' ?> >
                <?php echo $row['payment'] ?>
            </td>
            <td align="center">
                <?php if ($row['selection'] == 'Cancel') echo '';  else echo $row['selection']; ?>
            </td>
            <td align="right">
                <?php echo $row['c_payment'] ?>
            </td>
            <td>
                <input style="width:110px; font-size:12px;" type="text" readonly id="id[<?php echo $row['id'] ; ?>]" name="id[<?php echo $row['id'] ; ?>]" value="<?php echo 'MA/PL(E)/' . $acyear . '/' . $i; $i++; ?>" />
            </td>
        </tr>
        <?php
        }

        ?>
    </table>
    <?php         
    }
    ?>

    <?php
    //sn
    $query = "SELECT * FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND selection='Selected'";
    if($acyear != ''){
        $query = $query . " AND acyear = '".$acyear."'";
    }
    $query = $query . " AND field = 'Sinhala' ORDER BY field(title, 'Ven.') desc, field(gender, 'Male', 'Female'), studentID";
    $result = $db->executeQuery($query);
    $i = 1;
    if ($db->Row_Count($result)>0 && $acyear != ''){ ?>
    <br />
    <table class="applicant" width="100%">
        <tr>
            <th style="width:1%;">ID</th>
            <th style="width:2%;">Title</th>
            <th style="width:15%;">Name</th>
            <th style="width:5%;">Gender</th>
            <th style="width:8%;">Mobile No.</th>
            <th style="width:5%;">Intended Degree Programme</th>
            <th style="width:5%;">Medium of Study</th>
            <th style="width:5%;">Field of Study</th>
            <th style="width:5%;">Certi- ficate</th>
            <th style="width:3%;">Appli- cation Pay.</th>
            <th style="width:5%;">Selection</th>
            <th style="width:5%;">Course Payment</th>
            <th style="width:5%;">Student ID</th>
        </tr>

        <?php
        while($row = $db->Next_Record($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['studentID'] ?>
            </td>
            <td>
                <?php echo $row['title'] ?>
            </td>
            <td style="font-size:110%;">
                <?php echo $row['nameEnglish'] ?>
            </td>
            <td align="center">
                <?php echo $row['gender'] ?>
            </td>
            <td>
                <?php echo $row['countrycode2']; ?>-<?php echo $row['contactNo2']; ?>
                <br/>
                <?php echo $row['countrycode3']; ?>-<?php echo $row['contactNo3']; ?>
            </td>
            <td>
                <?php echo $row['degree'] ?>
            </td>
            <td>
                <?php echo $row['medium'] ?>
            </td>
            <td>
                <?php echo $row['field'] ?>
            </td>
            
            <!--
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?> >
                <?php echo $row['q_degree'] ?>
            </td>
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_institute'] ?>
            </td>
            <td align="center" <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_class'] ?>
            </td>
                -->
            <td align="center">
                <?php echo $row['certificate'] == 'Yes' ? $row['certificate'] : 'No' ?>
            </td>
            <td align="right" <?php if($row['payment'] < 1000) echo 'bgcolor=#f4a261' ?> >
                <?php echo $row['payment'] ?>
            </td>
            <td align="center">
                <?php if ($row['selection'] == 'Cancel') echo '';  else echo $row['selection']; ?>
            </td>
            <td align="right">
                <?php echo $row['c_payment'] ?>
            </td>
            <td>
                <input style="width:110px; font-size:12px;" type="text" readonly id="id[<?php echo $row['id'] ; ?>]" name="id[<?php echo $row['id'] ; ?>]" value="<?php echo 'MA/SIN/' . $acyear . '/' . $i; $i++; ?>" />
            </td>
        </tr>
        <?php
        }

        ?>
    </table>
    <?php         
    }
    ?>

    <?php
    //en
    $query = "SELECT * FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND selection='Selected'";
    if($acyear != ''){
        $query = $query . " AND acyear = '".$acyear."'";
    }
    $query = $query . " AND field = 'English' ORDER BY field(title, 'Ven.') desc, field(gender, 'Male', 'Female'), studentID";
    $result = $db->executeQuery($query);
    $i = 1;
    if ($db->Row_Count($result)>0 && $acyear != ''){ ?>
    <br />
    <table class="applicant" width="100%">
        <tr>
            <th style="width:1%;">ID</th>
            <th style="width:2%;">Title</th>
            <th style="width:15%;">Name</th>
            <th style="width:5%;">Gender</th>
            <th style="width:8%;">Mobile No.</th>
            <th style="width:5%;">Intended Degree Programme</th>
            <th style="width:5%;">Medium of Study</th>
            <th style="width:5%;">Field of Study</th>
            <th style="width:5%;">Certi- ficate</th>
            <th style="width:3%;">Appli- cation Pay.</th>
            <th style="width:5%;">Selection</th>
            <th style="width:5%;">Course Payment</th>
            <th style="width:5%;">Student ID</th>
        </tr>

        <?php
        while($row = $db->Next_Record($result)) {
        ?>
        <tr>
            <td>
                <?php echo $row['studentID'] ?>
            </td>
            <td>
                <?php echo $row['title'] ?>
            </td>
            <td style="font-size:110%;">
                <?php echo $row['nameEnglish'] ?>
            </td>
            <td align="center">
                <?php echo $row['gender'] ?>
            </td>
            <td>
                <?php echo $row['countrycode2']; ?>-<?php echo $row['contactNo2']; ?>
                <br/>
                <?php echo $row['countrycode3']; ?>-<?php echo $row['contactNo3']; ?>
            </td>
            <td>
                <?php echo $row['degree'] ?>
            </td>
            <td>
                <?php echo $row['medium'] ?>
            </td>
            <td>
                <?php echo $row['field'] ?>
            </td>
            
            <!--
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?> >
                <?php echo $row['q_degree'] ?>
            </td>
            <td <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_institute'] ?>
            </td>
            <td align="center" <?php if($row['pending']) echo 'bgcolor=#a8dadc' ?>>
                <?php echo $row['q_class'] ?>
            </td>
                -->
            <td align="center">
                <?php echo $row['certificate'] == 'Yes' ? $row['certificate'] : 'No' ?>
            </td>
            <td align="right" <?php if($row['payment'] < 1000) echo 'bgcolor=#f4a261' ?> >
                <?php echo $row['payment'] ?>
            </td>
            <td align="center">
                <?php if ($row['selection'] == 'Cancel') echo '';  else echo $row['selection']; ?>
            </td>
            <td align="right">
                <?php echo $row['c_payment'] ?>
            </td>
            <td>
                <input style="width:110px; font-size:12px;" type="text" readonly id="id[<?php echo $row['id'] ; ?>]" name="id[<?php echo $row['id'] ; ?>]" value="<?php echo 'MA/EN/' . $acyear . '/' . $i; $i++; ?>" />
            </td>
        </tr>
        <?php
        }

        ?>
    </table>
    <?php         
    }
    ?>

</form>



<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "New Student - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>New Student</li></ul>";
//Apply the template
include("master_sms_external.php");
?>