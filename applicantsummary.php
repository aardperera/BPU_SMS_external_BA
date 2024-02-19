<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if (!isset($_SESSION['authenticatedUser'])) {
    echo $_SESSION['authenticatedUser'];
    header("Location: index.php");
}

//print $_SESSION['courseID'] ;

include('dbAccess.php');
$db = new DBOperations();

$select = '';

if(isset($_GET['select'])) $select = $_GET['select'];
if(isset($_GET['acyear']))  $acyear  = $_GET['acyear'];

$query = "SELECT field, medium, COUNT(1) FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."'";
if ($acyear != ''){
    $query = $query . " AND acyear = '".$acyear."'";
}
$query = $query . " GROUP BY field, medium HAVING (field is not null or medium is null)";
//$fquery = "SELECT distinct field FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."'";
$mquery = "SELECT distinct medium FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."'";
if ($acyear != ''){
    $mquery = $mquery . " AND acyear = '".$acyear."'";
}


//if($select != ''){
//    $query = $query . " AND selection = '".$select."'";
//    $fquery = $fquery . " AND selection = '".$select."'";
//    $mquery = $mquery . " AND selection = '".$select."'";
//}


$subcrsID="";
if(isset($_POST["subcrsID"]))
{
    $subcrsID=strip_tags($_POST["subcrsID"]);
}

$result = $db->executeQuery($query);

$fdata = ["Buddhist Studies", "Pali", "Sinhala", "Sanskrit",  "English"];
for($i=0; $i < count($fdata); $i++){
    $mresult = $db->executeQuery($mquery);
    while($medium = $db->Next_Record($mresult)){
        $query = "SELECT field, medium FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND field='".$fdata[$i]."' AND medium='$medium[0]';";
        $data[$fdata[$i]][$medium[0]] = $db->numRows($db->executeQuery($query));
    }
}

    //inteneded dgreee program
$query = "SELECT degree, medium, COUNT(1) FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."'";
if ($acyear != ''){
    $query = $query . " AND acyear = '".$acyear."'";
}
$query = $query . " GROUP BY degree, medium HAVING (degree is not null or medium is null)";
//$fquery = "SELECT distinct field FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."'";
$mquery = "SELECT distinct medium FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."'";
if ($acyear != ''){
    $mquery = $mquery . " AND acyear = '".$acyear."'";
}

$result = $db->executeQuery($query);

$ddata = ["P.G.D. - Buddhist Studies", "M.A. (One Year)", "M.A. (Two Year)"];
$ddata1 = ["P.G.D. - Buddhist Studies", "Master of Arts (One Year)", "Master of Arts (Two Year)"];
for($i=0; $i < count($ddata); $i++){
    $mresult = $db->executeQuery($mquery);
    while($medium = $db->Next_Record($mresult)){
        $query = "SELECT degree, medium FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree='".$ddata[$i]."' AND medium='$medium[0]';";
        $data1[$ddata[$i]][$medium[0]] = $db->numRows($db->executeQuery($query));
    }
}

?>



<h1>Summary of Applicants<?php if($acyear != '') echo ' - ' . $acyear; ?></h1>
<form method="post" action="" class="plain" id="form1" name="form1">
    <table class="applicant" style="width:50%;">
        <tr>
            <th rowspan="2">Field of Study ( Master of Arts Degree )</th>
            <th colspan="<?php echo $db->numRows($db->executeQuery($mquery)); ?>">Medium of Study</th>
        </tr>
        <tr>
            <?php
            $mresult = $db->executeQuery($mquery);
            while($rowm = $db->Next_Record($mresult)) {
            ?>
            <th width="20%">
                <?php echo $rowm[0]=='' ? 'Not specified' : $rowm[0]; ?>
            </th>
            <?php
            } 
            ?>
        </tr>

        <?php
        for($i=0; $i < count($fdata); $i++){
        ?>
        <tr>
            <td>
                <?php echo $fdata[$i]; ?>
            </td>
            <?php
                $mresult = $db->executeQuery($mquery);
                while($rowm = $db->Next_Record($mresult)) {
            ?>
                <td align="center">
                    <?php echo $data[$fdata[$i]][$rowm[0]] ?>
                </td> 
                <?php
                }
                ?>
        </tr>
        <?php
                }
        ?>
    </table>

    </br></br></br></br>

    <table class="applicant" style="width:50%;">
        <tr>
            <th rowspan="2">Intended Degree Programme</th>
            <th colspan="<?php echo $db->numRows($db->executeQuery($mquery)); ?>">Medium of Study</th>
        </tr>
        <tr>
            <?php
            $mresult = $db->executeQuery($mquery);
            while($rowm = $db->Next_Record($mresult)) {
            ?>
            <th width="20%">
                <?php echo $rowm[0]=='' ? 'Not specified' : $rowm[0]; ?>
            </th>
            <?php
            }
            ?>
        </tr>

        <?php
        for($i=0; $i < count($ddata); $i++){
        ?>
        <tr>
            <td>
                <?php echo $ddata1[$i]; ?>
            </td>
            <?php
            $mresult = $db->executeQuery($mquery);
            while($rowm = $db->Next_Record($mresult)) {
            ?>
            <td align="center">
                <?php echo $data1[$ddata[$i]][$rowm[0]] ?>
            </td>
            <?php
            }
            ?>
        </tr>
        <?php
        }
        ?>
    </table>
</form>

<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Summary of Applicant - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='applicantAdmin.php'>Applicants </a></li><li>Summary of Applicant</li></ul>";
//Apply the template
include("master_sms_external.php");
?>