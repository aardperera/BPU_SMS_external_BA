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
//$student = $_GET['student'];
session_start();
//$enrollid = array();
//$query = $_SESSION['query'];
?>
<h1>Student details</h1>
<br />
<?php
//if ( $db->Row_Count( $result )>0 ) {
?>
<form method='post' action='' name='form1' id='form1' class='plain'>
    <br />
    <table class='searchResults'>
        <tr>
            <th>
                Studnt ID
            </th>
            <th>Title</th>
            <th>Name</th>
            <th>Address</th>
            <th>NIC</th>
            <th>Telephone No.</th>
            <?php 
			if ( ($subcrsID == 'a') || ($subcrsID == 'c') ) {
			}
			else{?>
				 <th>Sub Course</th>
			<?php }
			
			
			?>
            
        </tr>
        <?php
        
$subcrsID = $_GET['subcrsID'];
if ( $subcrsID == 'a' ) {
    $queryall = "SELECT studentID, title, nameEnglish, addressE2,nic,contactNo from student where acyear='$acyear' and courseID='$courseID' order by studentID ";
    //print "SELECT DISTINCT c.regNo, c.indexNo, s.nameEnglish, s.addressE1 from crs_enroll c,student s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and e.mark2>=40 and e.mark2<=100 and e.mark2!='AB' order by c.indexNo";
    $resultall = $db->executeQuery( $queryall );
	//print 'aa';
} elseif ( $subcrsID == 'b' ) {
    $queryall = "SELECT  s.studentID, s.title, s.nameEnglish, s.addressE2,s.nic,s.contactNo,c.subcrsID,c.courseID from crs_enroll c,student s where  c.yearEntry='$acyear' and c.courseID='$courseID'  and  c.studentID=s.studentID    order by s.studentID";
//	print "SELECT  s.studentID, s.title, s.nameEnglish, s.addressE2,s.nic,s.contactNo,c.subcrsID from crs_enroll c,student s where  c.yearEntry='$acyear' and c.courseID='$courseID'  and  c.studentID=s.studentID    order by s.studentID";
	//course sub ek
   // print "SELECT DISTINCT c.regNo, c.indexNo, s.nameEnglish, s.addressE1 from crs_enroll c,student s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and e.mark2<40 and e.mark2>=0 and e.mark2!='AB' order by c.indexNo";
	//print 'bb';
    $resultall = $db->executeQuery( $queryall );
} elseif ( $subcrsID == 'c' ) {
    $queryall = "SELECT studentID,title, nameEnglish, addressE2,nic,contactNo from student where studentID not in(select studentID from crs_enroll)"; ;
    //print "SELECT DISTINCT c.regNo, c.indexNo, s.nameEnglish, s.addressE1 from crs_enroll c,student s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.studentID=s.studentID and e.IndexNo=c.IndexNo and e.mark2='AB' order by c.indexNo";
    $resultall = $db->executeQuery( $queryall );
	//print 'cc';
}
		else{
			$queryall = "SELECT  s.studentID, s.title, s.nameEnglish, s.addressE2,s.nic,s.contactNo,c.subcrsID,c.courseID from crs_enroll c,student s where  c.yearEntry='$acyear' and c.courseID='$courseID'  and c.subcrsID='$subcrsID' and c.studentID=s.studentID order by s.studentID";
			 $resultall = $db->executeQuery( $queryall );
		}
//print 'll';
//			print $query12;
//$result12 = $db->executeQuery( $query12 );
$row12 =  $db->Next_Record( $result12 );
$j=0;
while ( $row =  $db->Next_Record( $resultall ) )
 {
    $indexNo = $row['indexNo'];
    ?>
        <tr>
           
            <td><?php echo $row['studentID'] ?></td>
            <td><?php echo $row['title'] ?></td>
           
            <td><?php echo $row['nameEnglish'] ?></td>
            <td><?php echo $row['addressE2'] ?></td>
            <td><?php echo $row['nic'] ?></td>
            <td><?php echo $row['contactNo'] ?></td>
            <?php if ( ($subcrsID == 'a')  || ($subcrsID == 'c') ) {
		
			}
			else {
			//	print 'lll';
				$cid=$row['courseID'];
				$sid=$row['subcrsID'];
			// print $cid;
			//	print $scid;
    $subcrsdes = "SELECT description from crs_sub where courseID='$cid' and id='$sid'";
	//print "SELECT description from crs_sub where courseID='$cid' and id='$sid'";
     $resultsub= $db->executeQuery( $subcrsdes );
    
		$rows=  $db->Next_Record($resultsub);
			?>
				<td><?php echo $rows['description'] ?></td>
			<?php }?>
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
$navpath = "<ul><li><a href='index.php'>Home </a></li><li><a href='examAdmin.php'>Enrollment Related </a></li><li>Student details</li></ul>";
//Apply the template
include( 'master_sms_external.php' );
?>