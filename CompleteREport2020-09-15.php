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
<td>Academic Year: </td>
<td><label>
<?php
echo '<select name="acyear" id="acyear"  onChange="document.form1.submit()" class="form-control">';
// Open your drop down box
$sql = 'SELECT distinct yearEntry FROM crs_enroll';
$result = $db->executeQuery( $sql );
//echo '<option value="all">All</option>';
while ( $row =  $db->Next_Record( $result ) ) {
    echo '<option value="'.$row['yearEntry'].'">'.$row['yearEntry'].'</option>';
}
echo '</select>';
// Close drop down box
?>
<script>
document.getElementById( 'acyear' ).value = "<?php echo $acyear;?>";
</script>
</label>
</td>
</tr>
<tr>
<td width = '127'>Course :</td>
<td width = '91'><select id = 'CourseID' name = 'CourseID' onchange = 'document.form1.submit()'>
<option value = ''>---</option>
<?php
$query = 'SELECT courseID,courseCode FROM course;';
$result = $db->executeQuery( $query );
while ( $data =  $db->Next_Record( $result ) )
 {
    if ( $_SESSION['courseId'] == 0 )
 {
        echo '<option value="'.$data[0].'">'.$data[1].'</option>';
    } else {
        if ( $_SESSION['courseId'] == $data[0] )
 {
            echo '<option value="'.$data[0].'">'.$data[1].'</option>';
        }
    }
}
?>
</select>
<script type = 'text/javascript' language = 'javascript'>
document.getElementById( 'CourseID' ).value = "<?php if(isset($courseID)){echo $courseID;}?>";
</script>
</td>
</tr>
<tr>
<td>SubCourse: </td>
<td><label>
<?php
echo '<select name="subcrsID" id="subcrsID"  onChange="document.form1.submit()" class="form-control">';
// Open your drop down box
$sql = "SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
$result = $db->executeQuery( $sql );
//echo '<option value="all">Select All</option>';
while ( $row =  $db->Next_Record( $result ) ) {
    echo '<option value="'.$row['id'].'">'.$row['description'].'</option>';
}
echo '</select>';
// Close drop down box
?>
<script>
document.getElementById( 'subcrsID' ).value = "<?php echo $subcrsID;?>";
</script>
</label>
</td>
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
    $queryall = "Select * from subject where courseID='".$_SESSION['courseId']."' and subcrsID='$subcrsID' order by suborder";
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
include( 'master_sms_external.php' );
?>