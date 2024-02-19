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
    transform: rotate(270deg);
}

.vTableHeader2 {
    text-align: center;
    transform: rotate(270deg);
    height: 150px;
	word-wrap: break-word;
	word-break: keep-all;
}

.vTableHeader {
    text-align: center;
    transform: rotate(270deg);
    height: 75px;
}
</style>
<center>
    <?php
	
	

#___________________________________________________________
   $filename ="excelreport.xls";
$contents = "testdata1 \t testdata2 \t testdata3 \t \n";
  header('Content-type: application/ms-excel');
  header('Content-Disposition: attachment; filename='.$filename);

#___________________________________________________________
//require_once "dbAccess.php";
//require_once "phpfncs/Funcs.php";
//$db = new DBOperations();
//$fncs = new FRMOperations();
	  include('dbAccess.php');

$db = new DBOperations();
	 /* $courseID=$_GET['courseID'];
	 $subcrsID=$_GET['subcrsID'];
	 $emonth=$_GET['emonth'];
	 $acyear=$_GET['acyear'];*/
	 $courseID='5';
	 $subcrsID='7';
	 $emonth='1';
	 $acyear='2019';
	



?>

    <?php echo "<h3>BUDDHIST AND PALI UNIVERSITY OF SRI LANKA</h3>";?>
    <?php echo"<h4>Bachlor of Arts (General) External Degree - Examination III - 2019 (December)</h4>";?>
    <?php echo"<h4>Detailed Result Sheet</h4>";?>
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
                <!-- Single Subject -->
                <?php
				 $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.suborder ";
			//	print $queryallSE;
				$resultallSE = $db->executeQuery($queryallSE);
				// $rowS=  $db->Next_Record($resultmark);
                for ($i=0;$i<$db->Row_Count($resultallSE);$i++)
		         {              ?>
                <td class="vTableHeader">
                    1st Marking
                </td>
                <td class="vTableHeader">
                    2nd Marking
                </td>
                <td class="vTableHeader">
                    Total
                </td>
                <td class="vTableHeader">
                    Grade
                </td>
                <td class="vTableHeader">
                    Points
                </td>
                <?php
                 }
                ?>
            </tr>
            <!-- One Entry -->
            
            
               <?php
                $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.suborder";
				//print $queryallSE;
				$resultallSE = $db->executeQuery($queryallSE);
				 $rowSE=  $db->Next_Record($resultallSE);
				//getting exam results
				$queryallSER = "Select distinct indexNo from crs_subject c,subject s,exameffort e where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID  and e.subjectID=s.subjectID and e.acYear='$acyear' order by e.indexNo";
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
                     $noWH=0;
					// print $indexNo;
					  $j++;
				//  print $indexNo;
					  $queryallSERM = "Select e.mark1,e.mark2,e.marks,e.grade,e.gradePoint,e.subjectID,e.withhold from exameffort e,subject s  where  e.acYear='$acyear' and e.indexNo='$indexNo' and s.subjectID=e.subjectID ORDER BY s.suborder";
					// print $queryallSERM;
					 $resultallSERM = $db->executeQuery($queryallSERM);
					// $rowSERM= $db->Next_Record($resultallSERM);
					// print $queryallSERM;
					// print $rowSERM[0];print 'll'; print $rowSERM[1];
					// print 'll';
					  $queryallcom = "Select status from final_result r,crs_enroll c  where  c.yearEntry='$acyear' and c.indexNo='$indexNo' and r.enroll_id=c.Enroll_id";
					 $resultallcom = $db->executeQuery($queryallcom);
					 $rowcom= $db->Next_Record($resultallcom);
					 $status1=$rowcom[status];

 //================Amendment========================================
 $queryalldetl = "Select c.regNo,r.nameEnglish,r.addressE1,r.addressE2,r.addressE3 from student_a r,crs_enroll c  where  c.yearEntry='$acyear' and c.indexNo='$indexNo' and r.studentID=c.studentID";
 $resultalldetl = $db->executeQuery($queryalldetl);
 $rowdetl= $db->Next_Record($resultalldetl);
 $regNo=$rowdetl[regNo];
 $nameEnglish=$rowdetl[nameEnglish];
 $addressE1=$rowdetl[addressE1];
 $addressE2=$rowdetl[addressE2];
 $addressE3=$rowdetl[addressE3];


 //============================================================


					 
				?>
                <!-- Serial Number -->
               <tr>
               
                
                   <?php  echo "<td align='left'>$j </td>";?>
                
               
                <!-- Index Number -->
                <?php  echo "<td align='left'>$regNo </td>";?>
              
                     <?php  echo "<td align='left'>$indexNo </td>";?>
					 <?php  echo "<td align='left'>$nameEnglish </td>";?>
					 <?php  echo "<td align='left'>$addressE1 $addressE2 $addressE3 </td>";?>
					  <?php  echo "<td align='left'> </td>";?>
               
                <!-- Withheld -->
                
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

                    if($rowSERM[6]=='WH'){
                        $noWH=$noWH+1;
					   //if (true){
                    ?>
                    <!-- One Subject -->
                    
                   
                        <?php  echo "<td align='left' bgcolor='green'>$rowSERM[0] </td>";?>
                  
                 
                       
                        <?php  echo "<td align='left'bgcolor='green'>$rowSERM[1] </td>";?>
                        
                   
                  
                       
						 <?php  echo "<td align='left' bgcolor='green'>$rowSERM[2] </td>";?>
                                    
                      
						 <?php  echo "<td align='left' bgcolor='green'>$rowSERM[3] </td>";?>
                    
                     
						 <?php  echo "<td align='left' bgcolor='green'>$rowSERM[4] </td>";?>

                         
                    
                    <?php
                    }
                    else{

                        ?>

                    <?php  echo "<td align='left'>$rowSERM[0] </td>";?>
                  
                 
                       
                  <?php  echo "<td align='left'>$rowSERM[1] </td>";?>
                  
             
            
                 
                   <?php  echo "<td align='left'>$rowSERM[2] </td>";?>
                              
                
                   <?php  echo "<td align='left'>$rowSERM[3] </td>";?>
              
               
                   <?php  echo "<td align='left'>$rowSERM[4] </td>";?>

                        <?php
                    }
					  $marks2=$marks2+$rowSERM[2];
					 $a=$a+1;
					  $average=number_format(($marks2)/$a,2);
					//  print 'yyyyyyyyyyyyy';
					//  print $rowSERM[2];
					//  print 'yyyyyyyyyyyyy';
					  $rowSERM= $db->Next_Record($resultallSERM);
				  }
					  else{ ?>
					<?php  echo "<td align='left'> </td>";?>
				   <?php  echo "<td align='left'> </td>";?>
				   <?php  echo "<td align='left'> </td>";?>
				   <?php  echo "<td align='left'></td>";?>
				   <?php  echo "<td align='left'> </td>";?>
					<?php 
						  }
						  
               // }
			  }
			  }
				 ?>
                <!-- Sub Total -->
        
                
					<?php  echo "<td align='left'>$marks2 </td>";?>
					
              
                <!-- % -->
           
                    
					<?php  echo "<td align='left'> $average </td>";?>
              
                <!-- Final Results -->
                <?php 
                   if($noWH=='0'){

                    ?>
					<?php  echo "<td align='left'> $status1 </td>";?>
                    <?php
                   }
                   else{
                    ?>
                    <?php  echo "<td align='left'> </td>";?>
                </tr>
                 <?php
					
                }
				
				 ?>
            
        </table>
		<div align="left" class="box-header with-border">
			
			</div>
    </form>
</div>