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
echo $examCourse; echo ' - '; echo '2019'; echo ' ('; echo 'October'; echo ')';
?> </u></h3>
    </center>
    <br>
    <p>This is to inform you that you have obtained following results at the <?php echo $examCourse;?> held in 2019 October<?php //echo date('Y F');?></p>
    <br>
    <table class="no-border">
        <tr>
		<?php
		  $nameStudent = "SELECT * from student_a s, crs_enroll c where c.indexNo='$indexNo' and s.studentID=c.studentID ";
		 // print $nameStudent;
    $resultStudent = $db->executeQuery( $nameStudent );
	$row12 =  $db->Next_Record( $resultStudent );
	$studentName=$row12['nameEnglish'];
	$studentid=$row12['studentID'];
	
	//$value1=substr($studentid,12,1);
	//print $studentid;
	//print $value1;
	if(substr($studentid, 12, 1)=='E'){
	$medium="English";
	}
	else{
	$medium="Sinhala";
	}
	
	
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
 $queryall = "Select * from crs_enroll c,subject_enroll s,subject j where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.Enroll_id=s.Enroll_id and c.indexNo='$indexNo' and j.subjectID=s.subjectID order by j.suborder";
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
                    <th align="left">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $rowsub['grade']?></th>
                </tr>
					
<?php
  }
?>
            </table>
        </form>
        <table class="no-border" style="width: 100%;">
            <tr>
                <td width="36%" class="no-border" style="text-align: left;">Prepared by:</td>
                <td width="24%" class="no-border" style="text-align: left;">Checked by:</td>
                <th width="40%" rowspan="2" class="no-border">
                    <table style="width: 90%; font-size:8pt">
                        <tr>
                            <th colspan="3">Grading Scheme</th>
                        </tr>
                        <tr>
                            <th width="35%">Marks</th>
                            <th width="34%">Grade</th>
                            <th width="31%">Credit Value</th>
                        </tr>
                        <tr>
                            <th>85-100</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">A</th><th align="left" width="50%" style="border:#FFFFFF">+</th></tr></table></th>
                            <th>4.00</th>
                        </tr>
                        <tr>
                            <th>70-84</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">A</th><th align="left" width="50%" style="border:#FFFFFF"></th></tr></table></th>
                            <th>4.00</th>
                        </tr>
                        <tr>
                            <th>65-69</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">A</th><th align="left" width="50%" style="border:#FFFFFF">-</th></tr></table></th>
                            <th>3.70</th>
                        </tr>
                        <tr>
                            <th>60-64</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">B</th><th align="left" width="50%" style="border:#FFFFFF">+</th></tr></table></th>
                            <th>3.30</th>
                        </tr>
                        <tr>
                            <th>55-59</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">B</th><th align="left" width="50%" style="border:#FFFFFF"></th></tr></table></th>
                            <th>3.00</th>
                        </tr>
                        <tr>
                            <th>50-54</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">B</th><th align="left" width="50%" style="border:#FFFFFF">-</th></tr></table></th>
                            <th>2.70</th>
                        </tr>
                        <tr>
                            <th>45-49</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">C</th><th align="left" width="50%" style="border:#FFFFFF">+</th></tr></table></th>
                            <th>2.30</th>
                        </tr>
                        <tr>
                            <th>40-44</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">C</th><th align="left" width="50%" style="border:#FFFFFF"></th></tr></table></th>
                            <th>2.00</th>
                        </tr>
                        <tr>
                            <th>35-39</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">C</th><th align="left" width="50%" style="border:#FFFFFF">-</th></tr></table></th>
                            <th>1.70</th>
                        </tr>
                        <tr>
                            <th>30-34</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">D</th><th align="left" width="50%" style="border:#FFFFFF">+</th></tr></table></th>
                            <th>1.30</th>
                        </tr>
                        <tr>
                            <th>25-29</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">D</th><th align="left" width="50%" style="border:#FFFFFF"></th></tr></table></th>
                            <th>1.00</th>
                        </tr>
                        <tr>
                            <th>00-24</th>
                            <th><table width="100%" style="border:#FFFFFF; font-size:8pt;"><tr><th align="right" width="50%" style="border:#FFFFFF">E</th><th align="left" width="50%" style="border:#FFFFFF"></th></tr></table></th>
                            <th>0.00</th>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr>
                <td style="vertical-align: bottom;" class="no-border" colspan="2"><p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <p>&nbsp;</p>
                  <p>E. A. Gunasena<br>Deputy
                    Registrar<br>(Faculty of Graduate Studies and
                    <br>Center for External Examination Studies)<br>For Registrar
                    <br>
                  </p>
                  
                  <p><br>
<br>
                    <br><br>
                    <b style="font-size: 12px;">**The candidates should obtain at least 40% marks to pass a subject.</b></p>
                </td>
            </tr>
        </table>
    </div>
</div>