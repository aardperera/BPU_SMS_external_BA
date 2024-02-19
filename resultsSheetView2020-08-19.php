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
	  include('dbAccess.php');

$db = new DBOperations();
	 $courseID=$_GET['courseID'];
	 $subcrsID=$_GET['subcrsID'];
	 $emonth=$_GET['emonth'];
	 $acyear=$_GET['acyear'];
	
echo '<img src="logo.png" width="75" height="75" />';
?>
    <h3>BUDDHIST AND PALI UNIVERSITY OF SRI LANKA</h3>
    <h4>Bachlor of Arts (General) External Degree - Examination III - 2018 (December)</h4>
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
                <th rowspan="2">
                    Index Number
                </th>
                <th rowspan="2" class="vTableHeader1">
                    Withheld
                </th>
                <!-- Subjects -->
                <?php
                
                $queryallS = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.subjectID;";
				//print $queryallS;
				$resultallS = $db->executeQuery($queryallS);
	 $k=0;
				$subjects;
				
		  			  while ($rowS=  $db->Next_Record($resultallS))
					  {
						 
						 // print 'kkk'; 
  						$nameEnglish = $rowS['nameEnglish'];
						   $subjects[$k]=$rowS['subjectID'];
						 // print $sujects[k];
						  $k++;
						  $str2=$nameEnglish;
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
				 $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ";
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
                $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ";
				//print $queryallSE;
				$resultallSE = $db->executeQuery($queryallSE);
				 $rowSE=  $db->Next_Record($resultallSE);
				//getting exam results
				$queryallSER = "Select distinct indexNo from crs_subject c,subject s,exameffort e where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID  and e.subjectID=s.subjectID and e.acYear='$acyear'";
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
					 $queryallSERM = "Select mark1,mark2,marks,grade,gradePoint,subjectID from exameffort  where  acYear='$acyear' and indexNo='$indexNo' ORDER BY subjectID";
					 $resultallSERM = $db->executeQuery($queryallSERM);
					// $rowSERM= $db->Next_Record($resultallSERM);
					// print $queryallSERM;
					// print $rowSERM[0];print 'll'; print $rowSERM[1];
					// print 'll';
				?>
                <!-- Serial Number -->
               <tr>
                <td>
                    <input type="text" value="<?php echo $j; ?>" size="4" />
                </td>
               
                <!-- Index Number -->
                <td>
                    <input type="text" value="<?php echo $indexNo; ?>" size="12" />
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
				   for ($m=0;$m<$noofsubjects;$m++){
				  //print 'forr';
				 //print $m;
					   //print 'forr';
					   //print $rowSERM[$subjectID];print 'y';
					   //print $subjects[$m];
					   //print 'ndd';
					   
				  if ($rowSERM['subjectID']==$subjects[$m]){
					   //if (true){
                    ?>
                    <!-- One Subject -->
                    <td>
                        <input type="text" value="<?php echo $rowSERM[0]; ?>" size="5" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[1]; ?>" size="5" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[2]; ?>" size="5" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[3]; ?>" size="5" />
                    </td>
                    <td>
                        <input type="text"value="<?php echo$rowSERM[4]; ?>"  size="5" />
                    </td>
                    <?php
					  $rowSERM= $db->Next_Record($resultallSERM);
				  }
					  else{?>
					<td>
                        <input type="text"  size="5" />
                    </td>
                    <td>
                        <input type="text"  size="5" />
                    </td>
                    <td>
                        <input type="text"  size="5" />
                    </td>
                    <td>
                        <input type="text"  size="5" />
                    </td>
                    <td>
                        <input type="text"  size="5" />
                    </td>  
					<?php 
						  }
						  
               // }
			  }
			  }
				 ?>
                <!-- Sub Total -->
                <td>
                    <input type="text" size="7" />
                </td>
                <!-- % -->
                <td>
                    <input type="text" size="6" />
                </td>
                <!-- Final Results -->
                <td>
                    <input type="text" size="15" />
                </td>
                </tr>
                 <?php
					
                }
				
				 ?>
            
        </table>
    </form>
</div>