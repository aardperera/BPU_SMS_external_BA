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
    transform: rotate(270deg);
	
	max-width:50px;
}

.vTableHeader2 {
    text-align: center;
	font-size:10pt;
    transform: rotate(270deg);
    height: 150px;
	word-wrap: break-word;
	word-break: keep-all;
	max-width:50px;
}

.vTableHeader {
    text-align: center;
	font-size:10pt;
    transform: rotate(270deg);
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
	 $emonth=$_GET['emonth'];
	 $acyear=$_GET['acyear'];
     $subQuery = "SELECT `description` FROM `crs_sub` WHERE `id` = $subcrsID";
$resultsubQ = $db->executeQuery($subQuery);  // Assuming $db is your MySQLi connection

if ($resultsubQ) {
    // Fetch the result as an associative array
    $row = $resultsubQ->fetch_assoc();

    if ($row) {
        // Access the 'description' column from the result array
        $description = $row['description'];

        // Now $description contains the value as a string
       // echo $description;
    } }
echo '<img src="logo.png" width="75" height="75" />';

if (isset($_POST['btn-save'])) {

    $dist = $_POST['year'];
  
				
			header("location:newresultsheet.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&emonth=$emonth");
	

}
?>
    <h3>BUDDHIST AND PALI UNIVERSITY OF SRI LANKA</h3>
    <h4>Bachelor of Arts (General) External Degree - <?php echo $description;?> - <?php echo $acyear; ?></h4>
    <h4>Detailed Result Sheet</h4>
</center>
<div style="overflow: auto;  white-space: nowrap; margin-left: 50px; margin-right: 50px;">
    <form method="post">
        <table>
            <!-- Main Heading Row -->
            <tr>
                <!-- Fixed -->
                <th rowspan="2" class="vTableHeader1">
                    Serial Number
                </th>
                <th rowspan="2" class="vTableHeader1">
                    Reg Number
                </th>
                <th rowspan="2">
                    Index Number
                </th>
                <th rowspan="2">
                    Full Name
                </th>
                <th rowspan="2">
                    Address
                </th>
                <th rowspan="2" class="vTableHeader1">
                    Withheld
                </th>
                <!-- Subjects -->
                <?php
                
                $queryallS = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.suborder;";
				//print $queryallS;
				$resultallS = $db->executeQuery($queryallS);
	 $k=0;
				$subjects;
				
		  			  while ($rowS=  $db->Next_Record($resultallS))
					  {
						 
						 // print 'kkk'; 
  						$nameEnglish = $rowS['nameEnglish'];
						  $subjectID=$rowS['codeEnglish'];
						   $subjects[$k]=$rowS['subjectID'];
						 // print $sujects[k];
						  $k++;
						  $str2=$nameEnglish."       ".$subjectID;
			//	print $subjectID;?>
						  <th colspan="5" class="vTableHeader2"><?php echo wordwrap($str2,15,"<br>\n")?></th>
                    
                   
                    <?php
                }
				$noofsubjects=$k;
				//print 'hh';
				//print $sujects[0];
				//print 'hh';
                ?>
                
                
             
                
                <!-- Fixed -->
                <th rowspan="2" class="vTableHeader1">
                    Sub Total
                </th>
                <th rowspan="2" class="vTableHeader1">
                    %
                </th>
                <th rowspan="2" class="vTableHeader1">
                    Final Results
                </th>
            </tr>
            <!-- Sub-Heading Row -->
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
            <!-- One Entry -->
            
            
               <?php
                $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ";
				//print $queryallSE;
				$resultallSE = $db->executeQuery($queryallSE);
				 $rowSE=  $db->Next_Record($resultallSE);
				//getting exam results
                
				$queryallSER = "Select distinct indexNo from crs_subject c,subject s,exameffort e where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID  and e.subjectID=s.subjectID and e.acYear='$acyear'  order by e.indexNo";
				//print $queryallSER;
				$resultallSER = $db->executeQuery($queryallSER);
				 //$rowSER= $db->Row_Count($resultallSER);
				$j=0;
			
			//print $db->Row_Count($resultallSER);
			//print 'hhh';
			while ($rowSER= $db->Next_Record($resultallSER))
				// for ($j=0;$j<$db->Row_Count($resultallSER);$j++)
		         { 
					// $rowSER=  $db->Next_Record($resultallSER);
					 $indexNo=$rowSER['indexNo'];
					  $j++;
				//  print $indexNo;
					 $queryallSERM = "Select e.mark1,e.mark2,e.marks,e.grade,e.gradePoint,e.subjectID from exameffort e,subject s  where  e.acYear='$acyear' and e.indexNo='$indexNo' and s.subjectID=e.subjectID ORDER BY s.suborder";
					 $resultallSERM = $db->executeQuery($queryallSERM);
					// $rowSERM= $db->Next_Record($resultallSERM);
					// print $queryallSERM;
					// print $rowSERM[0];print 'll'; print $rowSERM[1];
					// print 'll';
					  $queryallcom = "Select status from final_result r,crs_enroll c  where  c.yearEntry='$acyear' and c.indexNo='$indexNo' and r.enroll_id=c.Enroll_id";
					 $resultallcom = $db->executeQuery($queryallcom);
					 $rowcom= $db->Next_Record($resultallcom);
					 $status1=$rowcom['status'];

                     //================Amendment========================================
                     $queryalldetl = "Select c.regNo,r.nameEnglish,r.addressE1,r.addressE2,r.addressE3 from student_a r,crs_enroll c  where  c.yearEntry='$acyear' and c.indexNo='$indexNo' and r.studentID=c.studentID";
                     $resultalldetl = $db->executeQuery($queryalldetl);
					 $rowdetl= $db->Next_Record($resultalldetl);
					 $regNo=$rowdetl['regNo'];
                     $nameEnglish=$rowdetl['nameEnglish'];
                     $addressE1=$rowdetl['addressE1'];
                     $addressE2=$rowdetl['addressE2'];
                     $addressE3=$rowdetl['addressE3'];


                     //============================================================
					 
				?>
                <!-- Serial Number -->
               <tr>
                <td>
                    <input type="text" value="<?php echo $j; ?>" size="4" />
                </td>
                <!-- regNo Number -->
                <td>
                    <input type="text" value="<?php echo $regNo; ?>" size="15" />
                </td>
               
                <!-- Index Number -->
                <td>
                    <input type="text" value="<?php echo $indexNo; ?>" size="12" />
                </td>
                <!-- Name -->
                <td>
                    <input type="text" value="<?php echo $nameEnglish; ?>" size="60" />
                </td>
                <!-- Address -->
                <td>
                    <input type="text" value="<?php echo $addressE1; echo $addressE2; echo $addressE3;?>" size="70" />
                </td>
                <!-- Withheld -->
                <td>
                    <input type="text" size="4" />
                </td>
                <?php
				//	 print 'ttt';
				//print $queryallSERM	;
					// print 'ttt';
                //print $db->Row_Count($resultallSERM);
					 //$m=0;
					
				 
					 //print 'inside';
					 
              //while ($rowSERM= $db->Next_Record($resultallSERM))
			  
			  {
				  $rowSERM= $db->Next_Record($resultallSERM);
				  //print 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
					//  print $marks2;
					// print 'll';
					 $marks2=0;$a=0;
				   for ($m=0;$m<$noofsubjects;$m++){
				  //print 'forr';
				 //print $m;
					   //print 'forr';
					   //print $rowSERM[$subjectID];print 'y';
					   //print $subjects[$m];
					   //print 'ndd';
					   
					 //  
					//  print $rowSERM['subjectID'];
					 //  print 'kk'; 
					  
				  if ($rowSERM['subjectID']==$subjects[$m]){
					   //if (true){
                    ?>
                    <!-- One Subject -->
                    <td>
                        <input type="text" value="<?php echo $rowSERM[0]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[1]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[2]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[3]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[4]; ?>"  size="3" />
                    </td>
                    <?php
					  $marks2=$marks2+(int)$rowSERM[2];
					 $a=$a+1;
					//  print 'yyyyyyyyyyyyy';
					//  print $rowSERM[2];
					//  print 'yyyyyyyyyyyyy';
					  $rowSERM= $db->Next_Record($resultallSERM);
				  }
					  else{?>
					<td>
                        <input type="text"  size="3" />
                    </td>
                    <td>
                        <input type="text"  size="3" />
                    </td>
                    <td>
                        <input type="text"  size="3" />
                    </td>
                    <td>
                        <input type="text"  size="3" />
                    </td>
                    <td>
                        <input type="text"  size="3" />
                    </td>  
					<?php 
						  }
						  
               // }
			  }
			  }
				 ?>
                <!-- Sub Total -->
                <td> 
                    <input type="text"  value="<?php echo $marks2; ?>" size="7" />
                </td>
                <!-- % -->
                <td>
                    <input type="text" value="<?php echo number_format(($marks2)/$a,2); ?>" size="6" />
                </td>
                <!-- Final Results -->
                <td>
                    <input type="text"  value="<?php echo $status1;?>" size="15" />
                </td>
                </tr>
                 <?php
					
                }
				
				 ?>
            
        </table>
		<div align="left" class="box-header with-border">
			<button type="submit" name="btn-save" class="btn btn-primary" id="btn-save" align="left">Print</button>
			</div>
    </form>
</div>