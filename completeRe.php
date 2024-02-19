F<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
?>
<script language="javascript">
function MsgOkCancel() {
    var message = "Please confirm to DELETE this entry...";
    var return_value = confirm(message);
    return return_value;
}

function getGrade(marks, row) {
    var grade;
    if (0 <= marks && marks <= 29) grade = 'E';
    else if (30 <= marks && marks <= 39) grade = 'D';
    else if (40 <= marks && marks <= 54) grade = 'C';
    else if (55 <= marks && marks <= 69) grade = 'B';
    else if (70 <= marks && marks <= 100) grade = 'A';
    else grade = '';
    document.getElementById('txtGrade' + row).value = grade;
}
</script>
<?php
  include('dbAccess.php');

$db = new DBOperations();
  if (isset($_POST['CourseID']))
	{
		$courseID=$_POST['CourseID'];
	}
	if (isset($_POST['subcrsID']))
	{
		$subcrsID=$_POST['subcrsID'];
	}
	if (isset($_POST['acyear']))
	{
		$acyear=$_POST['acyear'];
	}
	if (isset($_POST['SubjectID']))
	{
		$SubjectID=$_POST['SubjectID'];
	}
    if ( isset( $_POST['pfa'] ) )
 {
    $pfa = $_POST['pfa'];
}

//=========================================================================================

if (isset($_POST['btn-save'])) {

    $dist = $_POST['year'];
  
				
			header("location:completeReEX.php?acyear=$acyear&subcrsID=$subcrsID");
	

}


//===========================================================================================
  //print $acyear;
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$effortID = $db->cleanInput($_GET['effortID']);
	$delQuery = "DELETE FROM exameffort WHERE effortID='$effortID'";
	$result = $db->executeQuery($delQuery);
  }
  session_start();
  if (isset($_POST['btnSubmit']))
	{
		$indexNo = $_SESSION['indexNo']; 
		///print $indexNo[1];
		$queryall = "Select * from subject_enroll as s, crs_enroll as c, paymentEnroll as p where s.subjectID='$SubjectID' and s.Enroll_id=c.Enroll_id and yearEntry='$acyear' and p.payment1='1' and p.payment2='1' and c.Enroll_id=p.enroll_id ";
//print $queryall;
  $resultall = $db->executeQuery($queryall);
		for ($i=0;$i<$db->Row_Count($resultall);$i++)
		{
			$indexNovalue = $indexNo[$i];
			$marks = $db->cleanInput($_POST['txtMarks'.$indexNovalue]);
			//print $marks ;
			//print 'g';
		$queryexist = "Select * from exameffort where subjectID='$SubjectID' and indexNo=$indexNovalue and acYear='$acyear'";
			$resultexist = $db->executeQuery($queryexist);
			 $roweffort=  $db->Next_Record($resultexist);
			 $effortvalue=$roweffort['effortID'];
			// print  $effortvalue;
			 $value= $db->Row_Count($resultexist);
			// print $value;
			if ($marks!=""){
			if ($db->Row_Count($resultexist)==0){
			//$grade = $db->cleanInput($_POST['txtGrade'.$effortID]); */
			//print 'uuu';
			//print $mark;
			//print "INSERT INTO exameffort (indexNo,subjectID,mark1,acYear)VALUES($indexNovalue,$SubjectID,$marks,$acyear)";
			$resultinsert = $db->executeQuery("INSERT INTO exameffort (indexNo,subjectID,mark1,acYear)VALUES($indexNovalue,$SubjectID,'$marks',$acyear)");
			//}
			}
			else{
			//print 'ttt';
			//print "UPDATE exameffort set mark1=$mark where effortID='$effortvalue'";
			$resultupdate = $db->executeQuery("UPDATE exameffort set mark1='$marks' where effortID='$effortvalue'") ;
			}
			}
		}
		header("location:examAdmin.php");
	}
  //$query = $_SESSION['query'];
?>
<h1>Summary Report</h1>
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
        $prentage = round( ( $rowcount4/$rowcount3 )*100 );
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
<div align="left" class="box-header with-border">
			<button type="submit" name="btn-save" class="btn btn-primary" id="btn-save" align="left">Print</button>
</div>

</form>
<?php 
//}else echo "<p>No exam details available.</p>";
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Enter Results - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='examAdmin.php'>Exam Efforts </a></li><li>Complete Status</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>