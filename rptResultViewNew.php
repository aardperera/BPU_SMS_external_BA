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
        font-size: 10pt;
        transform: rotate(270deg);
        max-width: 50px;
    }

    .vTableHeader2 {
        text-align: center;
        font-size: 10pt;
        transform: rotate(270deg);
        height: 150px;
        word-wrap: break-word;
        word-break: keep-all;
        max-width: 50px;
    }

    .vTableHeader {
        text-align: center;
        font-size: 10pt;
        transform: rotate(270deg);
        height: 75px;
        max-width: 50px;
    }
</style>
<center>
    <?php
    include('dbAccess.php');

    $db = new DBOperations();
    $courseID = $_GET['courseID'];
    $subcrsID = $_GET['subcrsID'];
    $emonth = $_GET['emonth'];
    $acyear = $_GET['acyear'];

    echo '<img src="logo.png" width="75" height="75" />';

    if (isset($_POST['btn-save'])) {

        $dist = $_POST['year'];


        header("location:ResultViewNewExcel.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&emonth=$emonth");
    }

    ?>
    <h3>BUDDHIST AND PALI UNIVERSITY OF SRI LANKA</h3>
    <h4>Bachlor of Arts (General) External Degree - Examination I </h4>
    <h4>Repeat Subject of  Incompleted Students</h4>


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



                <!-- Subjects -->
                <?php
                $queryallS = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.suborder;";
                $resultallS = $db->executeQuery($queryallS);
                $k = 0;
                $subjects;

                while ($rowS = $db->Next_Record($resultallS)) {


                    $nameEnglish = $rowS['nameEnglish'];
                    $subjectID = $rowS['codeEnglish'];
                    $subjects[$k] = $rowS['subjectID'];

                    $k++;
                    $str2 = $nameEnglish . "       " . $subjectID; ?>
                    <th colspan="2" class="vTableHeader2">
                        <?php echo wordwrap($str2, 15, "<br>\n") ?>
                    </th>


                    <?php
                }
                $noofsubjects = $k;

                ?>
                <!-- Fixed -->

                <th rowspan="2" class="vTableHeader1">
                    Final Results
                </th>
            </tr>
            <!-- Sub-Heading Row -->
            <tr>
                <!-- Single Subject -->
                <?php
                $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.suborder";

                $resultallSE = $db->executeQuery($queryallSE);

                for ($i = 0; $i < $db->Row_Count($resultallSE); $i++) { ?>

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

                }
            }

            ?>

        </table>
        <div align="left" class="box-header with-border">
            <button type="submit" name="btn-save" class="btn btn-primary" id="btn-save" align="left">Print Excel</button>
        </div>
    </form>
</div>