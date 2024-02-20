<?php
                $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ";
				
				$resultallSE = $db->executeQuery($queryallSE);
				$rowSE=  $db->Next_Record($resultallSE);
				//getting exam results
				$queryallSER = "Select distinct indexNo from crs_subject c,subject s,exameffort e where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID  and e.subjectID=s.subjectID and e.acYear='$acyear'  order by e.indexNo";
				
				$resultallSER = $db->executeQuery($queryallSER);
				$j=0;
			
			
			while ($rowSER= $db->Next_Record($resultallSER))
				
		         { 
					
					 $indexNo=$rowSER['indexNo'];
					  $j++;
				
					 $queryallSERM = "Select e.mark1,e.mark2,e.marks,e.grade,e.gradePoint,e.subjectID from exameffort e,subject s  where  e.acYear='$acyear' and e.indexNo='$indexNo' and s.subjectID=e.subjectID ORDER BY s.suborder";
					 $resultallSERM = $db->executeQuery($queryallSERM);
					
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