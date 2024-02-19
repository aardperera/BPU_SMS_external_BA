$queryRepeatStudents = "
    SELECT ce.indexNo, ce.regNo, r.nameEnglish, r.addressE1, r.addressE2, r.addressE3,
           se.subjectID, ee.mark1, ee.mark2, ee.marks, ee.grade, ee.gradePoint
    FROM courseEnrollRepeat ce
    JOIN subjectEnrollRepeat se ON ce.enroll_id = se.enroll_id
    JOIN examEffortRepeat ee ON se.subjectEnrollRepeat_id = ee.subjectEnrollRepeat_id
    JOIN student_a r ON r.studentID = ce.studentID
    WHERE ce.yearEntry = '$acyear'
      AND ce.subcrsID = '$subcrsID'
    ORDER BY ce.indexNo, se.subjectID
";
$resultRepeatStudents = $db->executeQuery($queryRepeatStudents);


$queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ";
            $resultallSE = $db->executeQuery($queryallSE);
            $rowSE = $db->Next_Record($resultallSE);
            $queryallSER = "Select distinct indexNo from crs_subject c,subject s,exameffort e where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID  and e.subjectID=s.subjectID and e.acYear='$acyear'  order by e.indexNo";
            $resultallSER = $db->executeQuery($queryallSER);

            $j = 0;


            while ($rowSER = $db->Next_Record($resultallSER)) {

                $indexNo = $rowSER['indexNo'];

                // filter the students who has got AB and Fail
                $queryallSERM = "SELECT e.mark1, e.mark2, e.marks, e.grade, e.gradePoint, e.subjectID 
                FROM exameffort e, subject s 
                WHERE e.acYear='$acyear' 
                AND e.indexNo='$indexNo' 
                AND s.subjectID=e.subjectID 
                AND e.grade IN ('AB', 'C-', 'E') 
                ORDER BY s.suborder";

                $resultallSERM = $db->executeQuery($queryallSERM);

                // filter not completed and Absent student
                $queryallcom = "SELECT r.status 
                FROM final_result r 
                INNER JOIN crs_enroll c ON r.enroll_id = c.Enroll_id 
                WHERE c.yearEntry = '$acyear' 
                  AND c.indexNo = '$indexNo' 
                  AND (r.status = 'Not Complete' OR r.status = 'Absent')
                  ";


                $resultallcom = $db->executeQuery($queryallcom);
                $rowcom = $db->Next_Record($resultallcom);

                // Display not completed and Absent student
                if ($rowcom && ($rowcom['status'] === 'Not Complete' || $rowcom['status'] === 'Absent')) {

                    $j++;

                    // Safely retrieve 'status' from $rowcom array
                    $status1 = isset($rowcom['status']) ? $rowcom['status'] : '';

                    //================Amendment========================================
                    $queryalldetl = "Select c.regNo,r.nameEnglish,r.addressE1,r.addressE2,r.addressE3 from student_a r,crs_enroll c  where  c.yearEntry='$acyear' and c.indexNo='$indexNo' and r.studentID=c.studentID";
                    $resultalldetl = $db->executeQuery($queryalldetl);
                    $rowdetl = $db->Next_Record($resultalldetl);
                    $regNo = $rowdetl['regNo']; // Fix: Add quotes around 'regNo'
                    $nameEnglish = $rowdetl['nameEnglish']; // Fix: Add quotes around 'nameEnglish'
                    $addressE1 = $rowdetl['addressE1']; // Fix: Add quotes around 'addressE1'
                    $addressE2 = $rowdetl['addressE2']; // Fix: Add quotes around 'addressE2'
                    $addressE3 = $rowdetl['addressE3']; // Fix: Add quotes around 'addressE3'
            


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
                            <input type="text" value="<?php echo $addressE1;
                            echo $addressE2;
                            echo $addressE3; ?>" size="70" />
                        </td>

                        <?php {
                            $rowSERM = $db->Next_Record($resultallSERM);
                            $marks2 = 0;
                            $a = 0;
                            for ($m = 0; $m < $noofsubjects; $m++) {


                                if ($rowSERM !== null && isset($rowSERM['subjectID']) && isset($subjects[$m]) && $rowSERM['subjectID'] == $subjects[$m]) {
                                    //if (true){
                                    ?>
                                    <!-- One Subject -->

                                    <td>
                                        <input type="text" value="<?php echo $rowSERM[3]; ?>" size="3" />
                                    </td>
                                    <td>
                                        <input type="text" value="<?php echo $rowSERM[4]; ?>" size="3" />
                                    </td>
                                    <?php
                                    $marks2 = $marks2 + intval($rowSERM[2]); // Explicitly cast to integer
                                    $a = $a + 1;
                                    $rowSERM = $db->Next_Record($resultallSERM);
                                } else { ?>

                                    <td>
                                        <input type="text" size="3" />
                                    </td>
                                    <td>
                                        <input type="text" size="3" />
                                    </td>
                                    <?php
                                }

                                // }
                            }
                        }
                        ?>

                        <!-- Final Results -->
                        <td>
                            <input type="text" value="<?php echo $status1; ?>" size="15" />
                        </td>
                    </tr>
                    <?php

                       