<script language="javascript"></script>
<style>
table {
    border-collapse: collapse;
}

table,
td,
th {
    border: 1px solid black;
}

.no-border {
    border: none !important;
}
</style>
<div style="margin-left: 40px; margin-right: 40px;">
    <center>
	<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
  
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
?>

        <?php
	  include('dbAccess.php');

$db = new DBOperations();
	 $courseID=$_GET['courseID'];
	 $subcrsID=$_GET['subcrsID'];
	 $acyear=$_GET['acyear'];
	$indexNo=$_GET['indexNo'];

	
echo '<img src="logo.png" width="75" height="75" />';
?>
        <h3><u>BUDDHIST AND PALI UNIVERSITY OF SRI LANKA<br>
                <?php
$examCourse = 'Bachlor of Arts (General) External Degree I Examination';
echo $examCourse; echo ' - '; echo date("Y"); echo ' ('; echo date('F'); echo ')';
?> </u></h3>
    </center>
    <br>
    <p>This is to inform you that you have obtained following results at the <?php echo $examCourse;?> held in <?php echo date('Y F');?></p>
    <br>
    <table class="no-border">
        <tr>
		<?php
		  $nameStudent = "SELECT * from student s, crs_enroll c where c.indexNo='$indexNo' and s.studentID=c.studentID ";
		 // print $nameStudent;
    $resultStudent = $db->executeQuery( $nameStudent );
	$row12 =  $db->Next_Record( $resultStudent );
	$studentName=$row12['nameEnglish'];
	$studentid=$row12['studentID'];
	
	/*$value1=SUBSTRING($studentid, 12, 1);
	print $studentid;
	print $value1;
	/*if(SUBSTRING($studentid, 12, 1)=='E'){
	$medium="English";
	}
	else{
	$medium="Sinhala";
	}
	*/
	
	?>
            <td class="no-border">Name</td>
            <td class="no-border">:</td>
            <td class="no-border"><?php echo $studentName ?></td>
        </tr>
        <tr>
            <td class="no-border">Index No.</td>
            <td class="no-border">:</td>
            <td class="no-border"><?php echo $indexNo ?></td>
        </tr>
        <tr>
            <td class="no-border">Medium</td>
            <td class="no-border">:</td>
            <td class="no-border"><?php echo $medium ?></td>
        </tr>
    </table>
    <br><br>
    <div style="overflow: auto;  white-space: nowrap; margin-left: 0px; margin-right: 0px;">
        <form method="post">
            <table>
                <!-- Main Heading Row -->
                <tr style="text-align: center;">
                    <!-- Fixed -->
                    <th>
                        Course Unit
                    </th>
                    <th>
                        Course Unit Title
                    </th>
                    <th>
                        Grade
                    </th>
                </tr><?php
 $queryall = "Select * from crs_enroll c,subject_enroll s,subject j where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.Enroll_id=s.Enroll_id and c.indexNo='$indexNo' and j.subjectID=s.subjectID ";
//print $queryall;
  $resultall = $db->executeQuery($queryall);
	 
		  		
	 $row12=  $db->Next_Record($result12);
  while ($row=  $db->Next_Record($resultall))
  {
  $subjectId=$row['subjectID'];
  $queryallsub = "Select * from exameffort where  acYear='$acyear' and indexNo='$indexNo'  and subjectID='$subjectId' ";
//print $queryall;
 $resultallsub = $db->executeQuery($queryallsub);
 $rowsub=  $db->Next_Record($resultallsub);
	
?>
				
				
                <tr>
                   <td><?php echo $row['codeEnglish'] ?></td>
		   <td><?php echo $row['nameEnglish']?></td>
                    <td><?php echo $rowsub['grade']?></td>
                </tr>
					
<?php
  }
?>
            </table>
        </form>
        <table class="no-border" style="width: 100%;">
            <tr>
                <td class="no-border" style="text-align: left;">Prepared by:</td>
                <td class="no-border" style="text-align: left;">Checked by:</td>
                <th class="no-border" rowspan="2">
                    <table style="width: 90%;">
                        <tr>
                            <td colspan="3">Grading Scheme</td>
                        </tr>
                        <tr>
                            <td>Marks</td>
                            <td>Grade</td>
                            <td>Credit<br>Value</td>
                        </tr>
                        <tr>
                            <td>85-100</td>
                            <td>A+</td>
                            <td>4.00</td>
                        </tr>
                        <tr>
                            <td>70-84</td>
                            <td>A</td>
                            <td>4.00</td>
                        </tr>
                        <tr>
                            <td>65-69</td>
                            <td>A-</td>
                            <td>3.70</td>
                        </tr>
                        <tr>
                            <td>60-64</td>
                            <td>B+</td>
                            <td>3.30</td>
                        </tr>
                        <tr>
                            <td>55-59</td>
                            <td>B</td>
                            <td>3.00</td>
                        </tr>
                        <tr>
                            <td>50-54</td>
                            <td>B-</td>
                            <td>2.70</td>
                        </tr>
                        <tr>
                            <td>45-49</td>
                            <td>C+</td>
                            <td>2.30</td>
                        </tr>
                        <tr>
                            <td>40-44</td>
                            <td>C</td>
                            <td>2.00</td>
                        </tr>
                        <tr>
                            <td>35-39</td>
                            <td>C-</td>
                            <td>1.70</td>
                        </tr>
                        <tr>
                            <td>30-34</td>
                            <td>D+</td>
                            <td>1.30</td>
                        </tr>
                        <tr>
                            <td>25-29</td>
                            <td>D</td>
                            <td>1.00</td>
                        </tr>
                        <tr>
                            <td>00-24</td>
                            <td>E</td>
                            <td>0.00</td>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr>
                <td style="vertical-align: bottom;" class="no-border" colspan="2">E. A. Gunasena<br>Deputy
                    Registrar<br>(Postgraduate Degrees and
                    External
                    Examination)<br>For Registrar
                    <br><br><br><br>
                    <b style="font-size: 12px;">**The candidates should obtain at least 40% marks to pass a subject.</b>
                </td>
            </tr>
        </table>
    </div>
</div>