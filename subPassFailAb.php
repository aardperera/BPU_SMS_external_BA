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
//session_start();
//$enrollid = array();
//$query = $_SESSION['query'];


if (isset($_POST['btnSubmit']))
	{
				
			header("location:subPassFailAb1.php?SubjectID=$SubjectID&pfa=$pfa&acyear=$acyear");
	}
?>
<h1>Pass / Fail / Absent Student Subject wise</h1>
<br />
<?php
//if ( $db->Row_Count( $result )>0 ) {
?>
<form method='post' action='subPassFailAb.php' name='form1' id='form1' class='plain'>
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
        <tr>
            <td>Subject: </td>
            <td><label>
                    <select id="SubjectID" name="SubjectID" onchange="document.form1.submit()">
                        <?php
		if(isset($courseID))
		{
			//$query2 = "SELECT subjectID,nameEnglish,codeEnglish FROM subject Where `courseID` ='".$_SESSION['courseId']."' ;";
		$query2 = "SELECT * FROM crs_subject WHERE CourseID='".$_SESSION['courseId']."' AND `subcrsid`='$subcrsID' order by compulsary  ";
			$result2 = $db->executeQuery($query2);
			while ($data2= $db->Next_Record($result2)) 
			{
			$subjectid=$data2[3];
				$query22="SELECT subjectID,nameEnglish,codeEnglish FROM subject Where `subjectID` ='$subjectid'";
				$result22= $db->executeQuery($query22);
				$data22= $db->Next_Record($result22);
			echo '<option value="'.$data22[0].'">'.$data22[2].'--'.$data22[1].'</option>';
        	} 
		}
			?>
                    </select>
                    <script type="text/javascript" language="javascript">
                    document.getElementById('SubjectID').value = "<?php if(isset($SubjectID)){echo $SubjectID;}?>";
                    </script>
                </label> </td>
        </tr>
        <tr>
            <td>Pass/Fail/Ab/Whithheld</td>
            <td><label>
                    <?php
echo '<select name="pfa" id="pfa" onChange="document.form1.submit()" class="form-control">';
// Open your drop down box
echo '<option value="1">Pass</option>';
echo '<option value="2">Fail</option>';
echo '<option value="3">Absent</option>';
echo '<option value="4">withheld</option>';
echo '</select>';
// Close drop down box
?>
                    <script>
                    document.getElementById('pfa').value = "<?php echo $pfa;?>";
                    </script>
                </label>
            </td>
        </tr>
        <tr><td><p><input name="btnSubmit" type="submit" value="Print Report" class="button" /></p></td></tr>
    </table>
    <table  border: 1px solid; collapse; class='searchResults' >
        <tr bgcolor:#0bb31e>
           <th> No.</th>
      
            <th>Registration No.</th>
         
            <th>Index No.</th>
            
            <th>Name</th>
            
            <th>Address</th>
        </tr>
        <?php
$abc = $_POST['pfa'];
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
//print $queryall;
//			print $query12;
//$result12 = $db->executeQuery( $query12 );
//$row12 =  $db->Next_Record( $result12 );
$number=1;
while ( $row =  $db->Next_Record( $resultall ) )
 {
 
    $indexNo = $row['indexNo'];
    ?>
        <tr> <td><?php echo $number ?></td>
       
            <td><?php echo $row['regNo'] ?></td>
            
            <td><?php echo $row['indexNo'] ?></td>
            
            <?php
    $nameStudent = 'SELECT * from student_a';
    $resultStudent = $db->executeQuery( $nameStudent );
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
<?php
//} else echo '<p>No exam details available.</p>';
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = 'Enrollment Related - Payment Details - Student Management System (External) - Buddhist & Pali University of Sri Lanka';
$navpath = "<ul><li><a href='index.php'>Home </a></li><li><a href='examAdmin.php'>Exam Related </a></li><li>Pass/Fail/Absent</li></ul>";
//Apply the template
include( 'master_sms_external.php' );
?>