<?php
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
</script>

<?php
  include('dbAccess.php');

$db = new DBOperations();
 
	 
	 $courseID=$_GET['courseID'];
	 $subcrsID=$_GET['subcrsID'];
	 $edate=$_GET['edate'];
	 $acyear=$_GET['acyear'];
$subjectID=$_GET['SubjectID'];
print $subjectID;
$medium=$_GET['medium'];
$examc=$_GET['examc'];
 
  //print $acyear;
  
  session_start();
  //$enrollid=array();
 
  //$query = $_SESSION['query'];
?><?php
echo '<img src="logo.png" width="75" height="75" />';
?><center>
    <h3>BUDDHIST AND PALI UNIVERSITY OF SRI LANKA</h3>
    <h4>Bachlor of Arts (General) External Degree - Examination III - 2018 (December)</h4>
    <h4>Detailed Result Sheet</h4>
    </center>

<br />
<?php
//if ($db->Row_Count($result)>0){
?>

<form method="post" action="" name="form1" id="form1" class="plain">
    <br />
    
    <table class="searchResults">
        <tr>
            <th rowspan="2">Serial No.</th>
            <th rowspan="2">Index No.</th>
            <th rowspan="2">Total<br>100</th>
            <th colspan="10">Question</th>
        </tr>
        <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
            <th>5</th>
            <th>6</th>
            <th>7</th>
            <th>8</th>
            <th>9</th>
            <th>10</th>
        </tr>
        <?php
  $queryexist2 = "Select distinct c.indexNo from admission_list a,crs_enroll c,subject_enroll s where c.Enroll_id=s.Enroll_id and c.courseID='5' and c.indexNo=a.indexNo and  c.subcrsID= '7' and c.yearEntry='2019' and s.subjectID='152'";
			print $queryexist2;
//print $queryall;
  $resultall = $db->executeQuery($queryexist2);
		  				//print 'll';
		  //			print $query12;
							//$result12 = $db->executeQuery($query12);
     $row12=  $db->Next_Record($result12);
     $a=0;
  while ($row=  $db->Next_Record($resultall))
  {
   
		//	print $queryexist2;
			$resultexist2 = $db->executeQuery($queryexist2);
			 $value2= $db->Row_Count($resultexist2);
			 if($value2==0){
	 $resultinsert = $db->executeQuery("INSERT INTO admission_list (indexNo,courseID,subcrsID,yearEntry) VALUES ($indexNo,$courseID,$subcrsID,$acyear)");
			 }
	   $queryall5 = "Select * from subject_enroll c,subject s where  c.subjectID=s.subjectID and c.Enroll_id='$enrollID'";
  $resultall5 = $db->executeQuery($queryall5);
	  $a=$a+1;
      $subjectIDAll=0;
 
?>
        <tr>
            <?php?>
            <td><?php echo $a ?></td>
            <td><?php echo $row['indexNo'] ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>student
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
        <?php
	 
  }
?>
    </table>
   
    <br /><br />
</form>
<?php 
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Enter Results - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='examAdmin.php'>Exam Efforts </a></li><li>Enter Results</li></ul>";
  include("master_sms_external.php");
?>