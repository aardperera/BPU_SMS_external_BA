<?php
    error_reporting(E_ALL & ~E_WARNING);
?>
<script language="javascript"></script>
<style>
table {
    border-collapse: collapse;
}

table,
th,
td {
    border: 1px solid black;
}

.vTableHeader1 {
    text-align: center;
	font-size:10pt;
    /* transform: rotate(270deg); */
	
	max-width:50px;
}

.vTableHeader2 {
    text-align: center;
	font-size:10pt;
    /* transform: rotate(270deg); */
    height: 150px;
	word-wrap: break-word;
	word-break: keep-all;
	max-width:50px;
}

.vTableHeader {
    text-align: center;
	font-size:10pt;
    /* transform: rotate(270deg); */
    height: 75px;
	max-width:50px;
}
</style>
<center>
    <?php
	    include('dbAccess.php');

        $db = new DBOperations();
        $courseID=$_GET['courseID'];
        $subcrsID=$_GET['subcrsID'];
        $acyear=$_GET['acyear'];
        $effortNo=$_GET['effortNo'];
        $subQuery = "SELECT `description` FROM `crs_sub` WHERE `id` = $subcrsID";
        $resultsubQ = $db->executeQuery($subQuery);  
        
        if ($resultsubQ) {
            $row = $resultsubQ->fetch_assoc();
            if ($row) {
                $description = $row['description'];
            } 
        }

        echo '<img src="logo.png" width="75" height="75" />';

        if (isset($_POST['btn-save'])) {
            $dist = $_POST['year'];
  			header("location:rsWithRepeatExcel.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&effortNo=$effortNo");
        }
    ?>
    
    <h3>BUDDHIST AND PALI UNIVERSITY OF SRI LANKA</h3>
    <h4>Bachelor of Arts (General) External Degree - <?php echo $description;?> - <?php echo $acyear; ?></h4>
    <h4>Detailed Result Sheet with Repeat Results</h4>
</center>
<div style="overflow: auto;  white-space: nowrap; margin-left: 50px; margin-right: 50px;">

        <form action="" method="post">
            <table>
                <tr>
                    <!-- Fixed -->
                    <th rowspan="2" class="vTableHeader1">Serial Number</th>
                    <th rowspan="2" class="vTableHeader1">Reg Number</th>
                    <th rowspan="2">Index Number</th>
                    <th rowspan="2">Full Name</th>
                    <th rowspan="2">Address</th>
                    <th rowspan="2" class="vTableHeader1">Withheld</th>
                    
                    <!-- Subjects -->
                    <?php
                        $queryallS = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.suborder;";
                        $resultallS = $db->executeQuery($queryallS);
                        $k=0;
                        $subjects;
                    
                        while ($rowS=  $db->Next_Record($resultallS)){
                        
                            $nameEnglish = $rowS['nameEnglish'];
                            $subjectID=$rowS['codeEnglish'];
                            $subjects[$k]=$rowS['subjectID'];
                            $k++;
                            $str2=$nameEnglish."       ".$subjectID;
                    ?>
                            <!-- need 7column  -->
                            <th colspan="7" class="vTableHeader2"><?php echo wordwrap($str2,15,"<br>\n")?></th>
                            <?php
                        }
                    $noofsubjects=$k;
                    ?>
                    
                    <!-- Fixed -->
                    <th rowspan="2" class="vTableHeader1">Sub Total</th>
                    <th rowspan="2" class="vTableHeader1">%</th>
                    <th rowspan="2" class="vTableHeader1">Final Results</th> 
                </tr>
                <tr>
                    <?php
                    $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.suborder";
                    $resultallSE = $db->executeQuery($queryallSE);
                    while ($db->Next_Record($resultallSE)){?>
                        <td class="vTableHeader">1st Marking</td>
                        <td class="vTableHeader">2nd Marking</td>
                        <td class="vTableHeader">Total</td>
                        <td class="vTableHeader">Grade</td>
                        <td class="vTableHeader">Points</td>
                        <td class="vTableHeader">Actual Grade</td> 
                        <td class="vTableHeader">Actual Grade Ponits</td> 
                    <?php
                    }
                    ?>
                </tr>
                <?php
                $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ";
				$resultallSE = $db->executeQuery($queryallSE);
				$rowSE=  $db->Next_Record($resultallSE);
				
				$queryallSER = "Select distinct indexNo from crs_subject c,subject s,exameffort e where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID  and e.subjectID=s.subjectID and e.acYear='$acyear'  order by e.indexNo";
			    $resultallSER = $db->executeQuery($queryallSER);
				
				$j=0;
			
                while ($rowSER = $db->Next_Record($resultallSER)) {

                    $indexNo = $rowSER['indexNo'];                            
                    // filter not completed and Absent student
                    $queryallcom = "SELECT r.status 
                    FROM final_result r 
                    INNER JOIN crs_enroll c ON r.enroll_id = c.Enroll_id 
                    WHERE c.yearEntry = '$acyear' 
                    AND c.indexNo = '$indexNo' 
                    AND (r.status = 'Not Complete' OR r.status = 'Absent')";
    
                    $resultallcom = $db->executeQuery($queryallcom);
                    $rowcom = $db->Next_Record($resultallcom);
                    // Display not completed and Absent student
                    if ($rowcom && ($rowcom['status'] === 'Not Complete' || $rowcom['status'] === 'Absent')) {
    
                        $j++;
  
                        $status1 = isset($rowcom['status']) ? $rowcom['status'] : '';
    
                        $queryalldetl = "Select c.regNo,r.nameEnglish,r.addressE1,r.addressE2,r.addressE3 from student_a r,crs_enroll c  where  c.yearEntry='$acyear' and c.indexNo='$indexNo' and r.studentID=c.studentID";
                        $resultalldetl = $db->executeQuery($queryalldetl);
                        $rowdetl = $db->Next_Record($resultalldetl);
                        $regNo = $rowdetl['regNo']; 
                        $nameEnglish = $rowdetl['nameEnglish']; 
                        $addressE1 = $rowdetl['addressE1']; 
                        $addressE2 = $rowdetl['addressE2']; 
                        $addressE3 = $rowdetl['addressE3']; 
                
                        ?>    
                        <tr>
                            <td style="size: 3;" align="center"><?php echo $j; ?></td>
                            <td style="size: 15;"><?php echo $regNo; ?></td>
                            <td style="size: 12;"><?php echo $indexNo; ?></td>
                            <td style="size: 80;"><?php echo $nameEnglish; ?></td>
                            <td style="size: 70;"><?php echo $addressE1; echo $addressE2; echo $addressE3;?></td>
                            <td style="size: 4;"></td>
                        
                        <?php

                        $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.suborder";
                        $resultallSE = $db->executeQuery($queryallSE);
                        while ($subjects = $db->Next_Record($resultallSE)){
                            $queryR = "SELECT *
                            FROM exameffortr 
                            WHERE effort = ".$effortNo."
                            AND subjectID = ".$subjects['subjectID']."
                            AND indexNo = ".$indexNo;
                        
                            $repeatSubjects = $db->executeQuery($queryR);
                            $repeatSubject = $db->Next_Record($repeatSubjects);
                        
                            if($subjects['subjectID'] == $repeatSubject['subjectID']){
                            ?>
                                    <td><?php echo $repeatSubject[7]; ?></td>
                                    <td><?php echo $repeatSubject[8]; ?></td>
                                    <td><?php echo $repeatSubject[4]; ?></td>
                                    <td><?php echo $repeatSubject[5]; ?></td>
                                    <td><?php echo $repeatSubject[9]; ?></td>
                                    <td><?php echo $repeatSubject[11];?></td>
                                    <td><?php echo $repeatSubject[12];?></td>
                        
                                    <?php
                        
                            } else {
                            ?>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td> 
                            <?php
                        
                            }
                                                
                            
                            $marks2=0;$a=0;
                            $marks2=$marks2+(int)$rowR[12];
                            $a=$a+1;
                            // $rowR= $db->Next_Record($resultR);
                                                
                        }
                        ?>
                            <!-- Sub Total -->
                            <td></td> 
                            <!-- % -->
                            <td></td> 
                            <!-- Final Results -->
                            <td></td>
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
</div>