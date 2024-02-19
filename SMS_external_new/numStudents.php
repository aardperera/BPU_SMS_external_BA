<?php include("dbAccess.php");

$subjectID = $db->cleanInput($_GET['subjectID']);
$acYear = $db->cleanInput($_GET['acYear']);
$medium = $db->cleanInput($_GET['medium']);
$result = $db->executeQuery("SELECT COUNT(exameffort.indexNo) AS numStudents FROM exameffort JOIN sub_enroll ON exameffort.indexNo=sub_enroll.indexNo AND exameffort.subjectID=sub_enroll.subjectID WHERE exameffort.subjectID='$subjectID' AND exameffort.acYear='$acYear' AND medium='$medium'");
$numStudents =  $db->Next_Record($result);
echo $numStudents['numStudents'];

?>

        	