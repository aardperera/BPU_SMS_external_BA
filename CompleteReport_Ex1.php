<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if ( !isset( $_SESSION['authenticatedUser'] ) ) {
    echo $_SESSION['authenticatedUser'];
    header( 'Location: index.php' );
}
?>
<script language = 'javascript'>
function MsgOkCancel() {
    var message = 'Please confirm to DELETE this entry...';
    var return_value = confirm( message );
    return return_value;
}
</script>
<?php
#___________________________________________________________
$filename ="excelreport.xls";
$contents = "testdata1 \t testdata2 \t testdata3 \t \n";
  header('Content-type: application/ms-excel');
  header('Content-Disposition: attachment; filename='.$filename);
   $courseID=$_GET['courseID'];
	 $subcrsID=$_GET['subcrsID'];
	 //$emonth=$_GET['emonth'];
	 $acyear=$_GET['acyear'];

#___________________________________________________________

include( 'dbAccess.php' );
if ( isset( $_POST['CourseID'] ) )
 {
    $courseID = $_POST['CourseID'];
}
if ( isset( $_POST['subcrsID'] ) )
 {
    $subcrsID = $_POST['subcrsID'];
}
if ( isset( $_POST['acyear'] ) )
 {
    $acyear = $_POST['acyear'];
}
if ( isset( $_POST['SubjectID'] ) )
 {
    $SubjectID = $_POST['SubjectID'];
}
if ( isset( $_POST['pfa'] ) )
 {
    $pfa = $_POST['pfa'];
}
//print $acyear;
if ( isset( $_GET['cmd'] ) && $_GET['cmd'] == 'delete' )
 {
    $effortID = $db->cleanInput( $_GET['effortID'] );
    $delQuery = "DELETE FROM exameffort WHERE effortID='$effortID'";
    $result = $db->executeQuery( $delQuery );
}
session_start();
//$enrollid = array();
//$query = $_SESSION['query'];
?>
<h1>Exam Result</h1>
<br />
<?php
//if ( $db->Row_Count( $result )>0 ) {
?>
<form method = 'post' action = '' name = 'form1' id = 'form1' class = 'plain'>
<br />
<table width = '230' class = 'searchResults'>
<tr>

</tr>
<tr>

</tr>
<tr>

</tr>
</table>
<table class = 'searchResults'>
<tr>
<th>Subject</th>
<th>Enrolled students</th>
<th>Absent</th>
<th>Present</th>
<th>Pass</th>
<th>Fail</th>
<th>%</th>
</tr>
<?php
//$queryall = "Select * from crs_enroll c,student s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and e.mark2='AB'";
//$resultall = $db->executeQuery( $queryall );
if ( $acyear == '' ) {
} else {
    $queryall = "Select * from crs_subject c,subject s where c.courseID='".$_SESSION['courseId']."' and c.subcrsID='$subcrsID' and c.subjectID=s.subjectID order by s.suborder";
    $resultall = $db->executeQuery( $queryall );
    //print 'll';
    //			print $query12;
    //$result12 = $db->executeQuery( $query12 );
    $row12 =  $db->Next_Record( $result12 );
    while ( $row =  $db->Next_Record( $resultall ) )
 {
        $subjectId = $row['subjectID'];
        $query1 = "select * from exameffort where acYear='$acyear' and subjectID='$subjectId'";
        $result1 = $db->executeQuery( $query1 );
        $rowcount1 = $db->Row_Count( $result1 );
        $query2 = "select * from exameffort where acYear='$acyear' and subjectID='$subjectId' and marks='AB'";
        $result2 = $db->executeQuery( $query2 );
        $rowcount2 = $db->Row_Count( $result2 );
        $query3 = "select * from exameffort where acYear='$acyear' and subjectID='$subjectId' and marks!='AB'";
        $result3 = $db->executeQuery( $query3 );
        $rowcount3 = $db->Row_Count( $result3 );
        $query4 = "select * from exameffort where acYear='$acyear' and subjectID='$subjectId' and marks!='AB' and marks>=40 and marks<=100";
        $result4 = $db->executeQuery( $query4 );
        $rowcount4 = $db->Row_Count( $result4 );
        $query5 = "select * from exameffort where acYear='$acyear' and subjectID='$subjectId' and marks!='AB' and marks<40 and marks>=0";
        $result5 = $db->executeQuery( $query5 );
        $rowcount5 = $db->Row_Count( $result5 );
        ?>
        <?php
        $prentage = round( ( $rowcount4/$rowcount1 )*100 );
        ?>
        <tr>
        <td><?php echo $row['codeEnglish'] ?><?php echo( '  ' ) ?><?php echo $row['nameEnglish'] ?></td>
        <td><?php echo $rowcount1 ?></td>
        <td><?php echo $rowcount2 ?></td>
        <td><?php echo $rowcount3 ?></td>
        <td><?php echo $rowcount4 ?></td>
        <td><?php echo $rowcount5 ?></td>
        <td><?php echo $prentage ?></td>
        </tr>
        <?php
    }
}
?>
</table>
<?php
$indexNo = array();
for ( $i = 0; $i<$db->Row_Count( $resultall );
$i++ )
 {
    $indexNo[$i] = mysql_result( $resultall, $i, 'indexNo' );
    //print $indexNo[$i] ;
}
$_SESSION['indexNo'] = $indexNo;
?>
<br /><br />
</form>
<?php
//} else echo '<p>No exam details available.</p>';
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = 'Enrollment Related - Payment Details - Student Management System (External) - Buddhist & Pali University of Sri Lanka';
$navpath = "<ul><li><a href='index.php'>Home </a></li><li><a href='examAdmin.php'>Exam Related </a></li><li>Absent List</li></ul>";
//Apply the template
//include( 'master_sms_external.php' );
?>