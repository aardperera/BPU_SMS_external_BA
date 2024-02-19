<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();

?>
<?php
#___________________________________________________________
$filename ="sumaryreport.xls";
$contents = "testdata1 \t testdata2 \t testdata3 \t \n";
  header('Content-type: application/ms-excel');
  header('Content-Disposition: attachment; filename='.$filename);
  

#___________________________________________________________

$db = new DBOperations();

$courseID='5';
$subcrsID='7';

$acyear='2019';
//print $acyear;

?>
<h1>Summary Report</h1>
<br />
<?php
//if ( $db->Row_Count( $result )>0 ) {
?>
<form method = 'post' action = '' name = 'form1' id = 'form1' class = 'plain'>
<br />

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
    $queryall = "Select * from crs_subject c,subject s where c.courseID='$courseID' and c.subcrsID='$subcrsID' and c.subjectID=s.subjectID order by s.suborder";
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

</form>

