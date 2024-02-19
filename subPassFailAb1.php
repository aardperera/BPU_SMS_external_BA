<?php
//Buffer larger content areas like the main page content
ob_start();

?>
<script language='javascript'>
function MsgOkCancel() {
    var message = 'Please confirm to DELETE this entry...';
    var return_value = confirm(message);
    return return_value;
}
</script>
<?php
include( 'dbAccess.php' );
$db = new DBOperations();



#___________________________________________________________
$filename ="excelreport.xls";
$contents = "testdata1 \t testdata2 \t testdata3 \t \n";
  header('Content-type: application/ms-excel');
  header('Content-Disposition: attachment; filename='.$filename);

#___________________________________________________________
//require_once "dbAccess.php";

$db = new DBOperations();
	 /* $courseID=$_GET['courseID'];
	 $subcrsID=$_GET['subcrsID'];
     */
    //$pfa='1';
     $pfa=$_GET['pfa'];
	  $SubjectID=$_GET['SubjectID'];
      $acyear=$_GET['acyear'];
      //$SubjectID='137';
     $courseID='5';
	 $subcrsID='7';
	 
	 //$acyear='2019';


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
   <?php
$abc = $pfa;
if ( $abc == '1' ) {
    ?>
<h1>Pass List</h1>
<?php
}elseif ( $abc == '2' ) {
    ?>
<h1>Fail List</h1>
<?php
}elseif ( $abc == '3' ) {
    ?>
<h1>Absent List</h1>
<?php
}elseif ( $abc == '4' ) {
    ?>
    <h1>withheld List</h1>
    <?php
}
?>
<br />
<?php
//if ( $db->Row_Count( $result )>0 ) {
?>
<form method='post' action='' name='form1' id='form1' class='plain'>
    <br />
    
    <table class='searchResults'>
        <tr>
        <th> No.</th>
            <th>Registration No.</th>
            <th>Index No.</th>
            <th>Name</th>
            <th>Address</th>
        </tr>
        <?php
$abc = $pfa;
if ( $abc == '1' ) {
    $queryall = "Select * from crs_enroll c,student_a s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and e.SubjectID='$SubjectID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and e.mark2>=40 and e.mark2<=100";
    $resultall = $db->executeQuery( $queryall );
} elseif ( $abc == '2' ) {
    $queryall = "Select * from crs_enroll c,student_a s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and e.SubjectID='$SubjectID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and e.mark2<40 and e.mark2>=0 ";
    $resultall = $db->executeQuery( $queryall );
} elseif ( $abc == '3' ) {
    $queryall = "Select * from crs_enroll c,student_a s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and e.SubjectID='$SubjectID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and e.mark2='AB'";
    $resultall = $db->executeQuery( $queryall );
}
elseif ( $abc == '4' ) {
    $queryall = "Select * from crs_enroll c,student_a s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and e.SubjectID='$SubjectID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and e.withhold='WH'";
    $resultall = $db->executeQuery( $queryall );
}
//rint $queryall;
//			print $query12;
//$resultall = $db->executeQuery( $queryall);
//$row =  $db->Next_Record( $resultall );
$number=1;
while ( $row =  $db->Next_Record( $resultall ) )
 {
    $indexNo = $row['indexNo'];
    ?>
        <tr>
           <td ><?php echo $number ?></td>
            <td><?php echo $row['regNo'] ?></td>
            <td><?php echo $row['indexNo'] ?></td>
            <?php
    //$nameStudent = 'SELECT * from student_a';
    //$resultStudent = $db->executeQuery( $nameStudent );
    ?>
            <td><?php echo $row['nameEnglish'] ?></td>
            <td><?php echo $row['addressE1'] ?></td>
        </tr>
        <?php
         $number=$number+1;
}
?>
    </table>
   
    <br /><br />
</form>
