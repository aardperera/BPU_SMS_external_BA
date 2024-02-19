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
$db = new DBOperations();
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
<h1>Whole Exam Absent</h1>
<br />
<?php
//if ( $db->Row_Count( $result )>0 ) {
?>
<form method='post' action='' name='form1' id='form1' class='plain'>
    <br />
    <table width='230' class='searchResults'>
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
                    document.getElementById('acyear').value = "<?php echo $acyear;?>";
                    </script>
                </label>
            </td>
        </tr>
        <tr>
            <td width='127'>Course :</td>
            <td width='91'><select id='CourseID' name='CourseID' onchange='document.form1.submit()'>
                    <option value=''>---</option>
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
                <script type='text/javascript' language='javascript'>
                document.getElementById('CourseID').value = "<?php if(isset($courseID)){echo $courseID;}?>";
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
                    document.getElementById('subcrsID').value = "<?php echo $subcrsID;?>";
                    </script>
                </label>
            </td>
        </tr>
        
    </table>
    <table class='searchResults'>
        <tr>
            <th>Registration No.</th>
            <th>Index No.</th>
            <th>Name</th>
            <th>Address</th>
        </tr>
        <?php
        $queryall = "Select DISTINCT e.indexNo, c.regNo, s.nameEnglish,s.addressE1 from crs_enroll c,student_a s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.studentID=s.studentID and e.indexNo=c.indexNo";
        
        
        $resultall = $db->executeQuery( $queryall );

//print 'll';
//			print $query12;
//$result12 = $db->executeQuery( $query12 );
$row12 =  $db->Next_Record( $result12 );
while ( $row =  $db->Next_Record( $resultall ) )
 {
    $indexNo = $row['indexNo'];

    $queryallsub = "Select  e.marks, c.regNo, s.nameEnglish,s.addressE1 from crs_enroll c,student_a s,exameffort e where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.studentID=s.studentID and e.indexNo=c.indexNo ";
    $s=0;
    while ( $rowsub =  $db->Next_Record( $resultallsub ) )
    {
       $marks = $row['marks'];
       if($marks!='AB'){
        $s=1;
       }

    }
    print $s;
    print 't';
if($s=='1'){
/*

    ?>
        <tr>
            <td><?php //echo $row['regNo'] ?></td>
            <td><?php //echo $row['indexNo'] ?></td>
            <?php/*
    $nameStudent = 'SELECT * from student';
    $resultStudent = $db->executeQuery( $nameStudent );
    ?>
            <td><?php //echo $row['nameEnglish'] ?></td>
            <td><?php //echo $row['addressE1'] ?></td>
        </tr>
        <?php */
}
else{
?>
<tr>
            <td><?php echo $row['regNo'] ?></td>
            <td><?php echo $row['indexNo'] ?></td>
            <?php
    $nameStudent = 'SELECT * from student';
    $resultStudent = $db->executeQuery( $nameStudent );
    ?>
            <td><?php echo $row['nameEnglish'] ?></td>
            <td><?php echo $row['addressE1'] ?></td>
        </tr>
<?php
}       
}
?>
    </table>
    <?php
    /*
$indexNo = array();
for ( $i = 0; $i<$db->Row_Count( $resultall );
$i++ )
 {
    $indexNo[$i] = mysql_result( $resultall, $i, 'indexNo' );
    //print $indexNo[$i] ;
}
$_SESSION['indexNo'] = $indexNo; */
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