<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if ( !isset( $_SESSION['authenticatedUser'] ) ) {
    echo $_SESSION['authenticatedUser'];
    header( 'Location: index.php' );
}
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
$courseID = $_GET['courseID'];
$subcrsID = $_GET['subcrsID'];
$acyear = $_GET['acyear'];
$medium = $_GET['medium'];
session_start();
//$enrollid = array();
//$query = $_SESSION['query'];
?>
<h1>Medium - Wise</h1>
<br />
<?php
//if ( $db->Row_Count( $result )>0 ) {
?>
<form method='post' action='' name='form1' id='form1' class='plain'>
    <br />
    <table class='searchResults'>
        <tr>
            <th>Registration No.</th>
            <th>Name</th>
            <th>Address</th>
            <th>NIC</th>
            <th>Contact No</th>
        </tr>
        <?php
        
$abc = $_GET['medium'];
if ( $abc == '1' ) {
    $queryall = "SELECT DISTINCT c.regNo, c.indexNo, s.nameEnglish, s.addressE1, s.nic, s.contactNo from crs_enroll c,student s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and SUBSTRING(s.studentID, 12, 1)='S'";
    $resultall = $db->executeQuery( $queryall );
} elseif ( $abc == '2' ) {
    $queryall = "SELECT DISTINCT c.regNo, c.indexNo, s.nameEnglish, s.addressE1, s.nic, s.contactNo from crs_enroll c,student s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and SUBSTRING(s.studentID, 12, 1)='E'";
    //print "SELECT DISTINCT c.regNo, c.indexNo, s.nameEnglish, s.addressE1, s.nic, s.contactNo from crs_enroll c,student s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and SUBSTRING(s.studentID, 12, 1)='E'";
    $resultall = $db->executeQuery( $queryall );
}
//print 'll';
//			print $query12;
//$result12 = $db->executeQuery( $query12 );
$row12 =  $db->Next_Record( $result12 );

while ( $row =  $db->Next_Record( $resultall ) )
 {
    $indexNo = $row['indexNo'];
    ?>
        <tr>            
            <td><?php echo $row['regNo'] ?></td>
            <?php
    $nameStudent = 'SELECT * from student';
    $resultStudent = $db->executeQuery( $nameStudent );
    ?>
            <td><?php echo $row['nameEnglish'] ?></td>
            <td><?php echo $row['addressE1'] ?></td>            
            <td><?php echo $row['nic'] ?></td>
            <td><?php echo $row['contactNo'] ?></td>
        </tr>
        <?php
}
?>
    </table>
    <br /><br />
</form>
<?php
//} else echo '<p>No exam details available.</p>';
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = 'Enrollment Related - Payment Details - Student Management System (External) - Buddhist & Pali University of Sri Lanka';
$navpath = "<ul><li><a href='index.php'>Home </a></li><li><a href='examAdmin.php'>Enrollment Related </a></li><li>Medium - Wise</li></ul>";
//Apply the template
include( 'master_sms_external.php' );
?>