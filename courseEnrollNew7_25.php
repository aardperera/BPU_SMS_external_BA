<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();

if (!isset($_SESSION['authenticatedUser'])) {
    $authenticatedUser = $_SESSION['authenticatedUser'];
    echo $authenticatedUser;
    header("Location: index.php");
}

$rowsPerPage = 100;
$pageNum = 1;
if (isset($_GET['page']))
    $pageNum = $_GET['page'];

//  $query = "SELECT * FROM subject WHERE courseID='".$_SESSION['courseId']."'";
?>


<h1>New Course Enrollment</h1>
<?php
include('dbAccess.php');
$db = new DBOperations();

$studentID = $db->cleanInput($_GET['studentID']);
?>
<form method="post" name = "form" action="" class="plain">
    <?php
    $subid = array();
    if (isset($_POST['lstCourse'])) {
        //$course = $_SESSION['courseId'];
    } else {
        $course = "";
    }
    if (isset($_POST['lstCoursesub'])) {
        $course = $_SESSION['courseId'];
        //$indexNo = $_POST['txtIndexNo'];
        //$courseCombID = $_POST['lstCourseComb'];
        //$subcrsID = $_POST['lstCoursesub'];
    }
    $subcrsID = $_POST['subcrsID'];
    $query = "SELECT * FROM `crs_sub` WHERE `courseID` ='" . $_SESSION['courseId'] . "' ";
// $query = "SELECT * FROM crs_subject  WHERE CourseID='".$_SESSION['courseId']."' AND`subcrsid`='$subcrsID' order by  Compulsary  ";
//print $query;




    $offset = ($pageNum - 1) * $rowsPerPage;
    $numRows = $db->Row_Count($db->executeQuery($query));
//$numRows = mysql_num_rows(executeQuery($query));
    $numPages = ceil($numRows / $rowsPerPage);
    $pageQuery = $query . " LIMIT $offset, $rowsPerPage";
    $pageResult = $db->executeQuery($pageQuery);
    ?>
    <table class="searchResults">
        <tr>
            <td>Registration No. : </td><td width = 300><input name="txtRegNo" type="text" value="<?php echo $studentID; ?>" /></td>
        </tr>

        <tr>
            <td>Sub Course ID: </td>
            <td>
                <?php
                echo '<select name="subcrsID" id="subcrsID"  onChange="document.form.submit()" class="form-control">'; // Open your drop down box
                $sql = "SELECT * FROM `crs_sub` WHERE `courseID` ='" . $_SESSION['courseId'] . "' ";

                $result = $db->executeQuery($sql);
//echo '<option value="all">Select All</option>';


                while ($row = $db->Next_Record($result)) {
                    //while ($row = mysql_fetch_array($result)){
                    echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                }
                echo '</select>'; // Close drop down box
                ?>

                <script>
                    document.getElementById('subcrsID').value = "<?php echo $subcrsID; ?>";
                </script>
            </td>

        </tr>

        <tr>
            <td>Index No. : </td><td><input name="txtIndexNo" type="text" value="<?php echo $indexNo; ?>" /></td>
        </tr>
        <tr>
            <td>Student ID : </td><td><input name="txtStudentID" type="text" value="<?php echo $studentID; ?>" readonly="readonly" /></td>
        </tr>



        <tr>
            <td>Entry Year : </td><td><select name="lstYearEntry">
                    <?php
                    for ($i = 2010;
                            $i <= 2100;
                            $i++) {
                        echo "<option value='$i'>$i</option>";
                    }
                    ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;<input type="date" id="date" name="date" value="<?php echo date("Y-m-d"); ?>"/ readonly></td>
        </tr>





    </table> 

    <br/>



    <?php
    if ($db->Row_Count($pageResult) > 0) {
//if (mysql_num_rows($pageResult)>0){ 
        ?>    
        <h5>Available Modules </h5>



        <table class="searchResults">
            <tr>
                <th>Subject ID</th><th>Subject Code</th><th>Subject Name</th><th>Selection</th>
            </tr>


            <?php
            $sql = "SELECT * FROM `crs_sub` WHERE `courseID` ='" . $_SESSION['courseId'] . "' ";
            $result = $db->executeQuery($sql);
            if ($db->Row_Count($result) > 0 && isset($subcrsID)) {
                
                while ($rowg = $db->Next_Record($result)) {
                                    
                }
                
                
                $sql = "SELECT * FROM `subject` WHERE `courseID` ='" . $_SESSION['courseId'] . "'  AND `Compulsary` = 'Yes' ";
                $result = $db->executeQuery($sql);

                while ($rowg = $db->Next_Record($result)) {
                    //while ($rowg = mysql_fetch_array($resultg))
                    ?>
                    <tr>
                        <td><?php echo $rowg['subjectID'] ?></td>
                        <td><?php echo $rowg['codeEnglish'] ?></td>
                        <td><?php echo $rowg['nameEnglish'] ?></td>
                    </tr>
                    <?php
                }
                ?>
                    <tr><td colspan = 3><b>Elective Modules</b></td></tr>
                <?php
                $sql = "SELECT * FROM `subject` WHERE `courseID` ='" . $_SESSION['courseId'] . "'  AND `Compulsary` = 'No' ";
                $result = $db->executeQuery($sql);

                while ($rowg = $db->Next_Record($result)) {
                    //while ($rowg = mysql_fetch_array($resultg))
                    ?>
                    <tr>
                        <td><?php echo $rowg['subjectID'] ?></td>
                        <td><?php echo $rowg['codeEnglish'] ?></td>
                        <td><?php echo $rowg['nameEnglish'] ?></td>
                        <td><input type="radio" name="elective" id="elective" value=<?php echo $rowg['subjectID'] ?>/></td>
                    </tr>
                    <?php
                }
            }
            ?>


        </table>
        
        




        <?php
        $self = $_SERVER['PHP_SELF'];
    } else {
        echo "<p>No new enrollments</p>";
    }
    ?>

    <?php
    for ($i = 0; $i < count($subid); $i++) {

        //echo $subid[$i]."<br>";
    }

    //submit
    if (isset($_POST['btnSubmit'])) {
        //====
        $subcrsquery = "SELECT subcrsID FROM crs_sub where description='" . $_SESSION['subcourseType'] . "'";
        $subcrsresult = $db->executeQuery($subcrsquery);
        $subcrsrow = $db->Next_Record($subcrsresult);
        //$subcrsrow = mysql_fetch_array($subcrsresult);
        $valuesubcrsID = $subcrsrow['subcrsID'];
        //====
        $regNo = $db->cleanInput($_POST['txtRegNo']);
        $indexNo = $_POST['txtIndexNo'];
        $studentID = $_POST['txtStudentID'];
        $course = $_SESSION['courseId'];
        $yearEntry = $_POST['lstYearEntry'];
        $courseCombID = $_POST['lstCourseComb'];
        $subcrsID = $_POST['subcrsID'];

        //print $indexNo ;
        //echo 'aaaa';

        $date = $_POST['date'];
        $subjectID = $_POST['subjectID'];

        if ($indexNo == '') {
            echo "<script>alert('Index No should not empty')</script>";
        } else {

            $resultrow = $db->executeQuery("SELECT * FROM crs_enroll where courseID='" . $_SESSION['courseId'] . "' and  studentID='$studentID'");

            $sql = "SELECT * FROM `crs_enroll` WHERE `indexNo`= $indexNo";
            //$sql="SELECT * FROM `crs_enroll`,`subject_enroll` WHERE crs_enroll.`indexNo`= '$indexNo'  AND crs_enroll.Enroll_id = subject_enroll.Enroll_id";	

            $result = $db->executeQuery($sql);

            if ($db->Row_Count($result) > 0) {
                //if(mysql_num_rows($result)>0){

                echo "<script>alert('The indexNo already submited more...')</script>";
                $sql2 = "SELECT `Enroll_id` FROM `crs_enroll` WHERE `indexNo`= $indexNo";
                $result3 = $db->executeQuery($sql2);
            }
            if ($db->Row_Count($result3) > 0) {
                //if(mysql_num_rows($result3)>0){	
                $rowvalue = $db->Next_Record($result3);
                //$rowvalue = mysql_fetch_array($result3);
                $TestEnroll = $rowvalue['Enroll_id'];

                //print($TestEnroll);
                //start a loop
                for ($i = 0; $i < count($subid); $i++) {

                    if (isset($_POST["check" . $subid[$i]])) {
                        //echo $subid[$i]."  check <br      

                        $sql3 = "SELECT * FROM `subject_enroll` WHERE Enroll_id= $TestEnroll AND subjectID = $subid[$i] ";
                        //print($sql3);
                        $result4 = $db->executeQuery($sql3);

                        if ($db->Row_Count($result4) > 0) {
                            //if(mysql_num_rows($result4)>0){
                        } else {
                            $query1 = "INSERT INTO `subject_enroll`(`Enroll_id`, `subjectID`, `enroll_date`) VALUES ($TestEnroll,$subid[$i],'$date')";
                            //print $query1; 
                            $result1 = $db->executeQuery($query1);
                            echo "<script>alert('Course Enrollment was submited')</script>";

                            header("Location: courseEnroll.php?studentID=$studentID");
                        }
                    }
                }

                //end loop
            } else {





                $query = "INSERT INTO crs_enroll SET regNo='$regNo', indexNo='$indexNo', studentID='$studentID', courseID='" . $_SESSION['courseId'] . "', yearEntry='$yearEntry', subcrsID='$subcrsID'";
                $result = $db->executeQuery($query);

                $query1 = "SELECT max(`Enroll_id`) FROM `crs_enroll` ";
                $result1 = $db->executeQuery($query1);
                $subcrsrow1 = $db->Next_Record($result1);
                //$subcrsrow1 = mysql_fetch_array($result1);


                for ($i = 0; $i < count($subid); $i++) {

                    if (isset($_POST["check" . $subid[$i]])) {
                        //echo $subid[$i]."  check <br>     

                        $query1 = "INSERT INTO `subject_enroll`(`Enroll_id`, `subjectID`, `enroll_date`) VALUES ($subcrsrow1[0],$subid[$i],'$date')";
                        $result1 = $db->executeQuery($query1);
                        echo "<script>alert('New Course Enrollment was submited')</script>";

                        header("Location: courseEnroll.php?studentID=$studentID");
                    }
                }
            }

            //=======================================
            $querystudent = "SELECT * FROM crs_select WHERE  studentID='$studentID'";
            $resultstudent = $db->executeQuery($querystudent);
            for ($i = 0; $i < $db->Row_Count($resultstudent); $i++) {
                //for ($i=0;$i<mysql_numrows($resultstudent);$i++)
                $CourseIDtable = mysql_result($resultstudent, $i, "courseID");
                //$CourseIDtable = mysql_result($resultstudent,$i,"courseID");
                print $CourseIDtable;
                echo 'aaammm';
                print $course;
                if ($CourseIDtable != $course) {
                    //$queryupdate = "UPDATE crs_select SET status='N' where courseID='$CourseIDtable' and studentID='$studentID' ";
                    //print $queryupdate;
                    //	$result = executeQuery($queryupdate);
                }
            }
            //========================================
            //header("location:courseEnroll.php?studentID=$studentID");
        }
    }


//Assign all Page Specific variables
    $pagemaincontent = ob_get_contents();
    ob_end_clean();
    $pagetitle = "New Course Enrollment - Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
    $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li><a href='courseEnroll.php?studentID=$studentID'>Course Enrollments </a></li><li>New Course Enrollment</li></ul>";
//Apply the template
    include("master_sms_external.php");
    ?>