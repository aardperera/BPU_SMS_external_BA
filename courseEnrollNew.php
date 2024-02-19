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

<script language="javascript" src="lib/scw/scw.js"></script>
<h1>New Course Enrollment</h1>
<?php
include('dbAccess.php');
$db = new DBOperations();

$studentID = $db->cleanInput($_GET['studentID']);
$date="";
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
    }
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

    if (isset($_POST['date'])) {
        $date = $_POST['date'];
    }

    $subcrsID = $_POST['subcrsID'];
    $queryindexNo = "SELECT * FROM `generate_temp_order` WHERE `applicantID` ='$studentID'";
    $resultindexN = $db->executeQuery($queryindexNo);
    while ($rowindexN = $db->Next_Record($resultindexN)) {
        //while ($row = mysql_fetch_array($result)){
        $indexNo= $rowindexN['indexNo'] ;
        $regNo=$rowindexN['RegNo'] ;
    }

    $query = "SELECT * FROM `crs_sub` WHERE `courseID` ='" . $_SESSION['courseId'] . "' ";
	// $query = "SELECT * FROM crs_subject  WHERE CourseID='".$_SESSION['courseId']."' AND`subcrsid`='$subcrsID' order by  Compulsary  ";
	//print $query;

	if (isset($_POST['enroll'])) {

		$subjects = "";
		if ($subcrsID != '') {


			$sql = "SELECT * from crs_enroll WHERE studentID = '" . $studentID . "' AND courseID = '" . $_SESSION['courseId'] . "' AND yearEntry = '" . $_POST['lstYearEntry'] . "' AND subcrsID = '" . $subcrsID . "' ";
			//echo $sql;
			$result = $db->executeQuery($sql);
			if ($db->numRows($result) > 0) {
				//alert
				//echo nl2br('record available...' . '\r\n');
			} else {
				//echo nl2br('writing new record...' . '\r\n');
				$sql = "INSERT INTO crs_enroll (regNo, indexNo, studentID, courseID, yearEntry, subcrsID) VALUES ('" . $regNo . "', '" . $IndexNo . "', '" . $studentID . "', '" . $_SESSION['courseId'] . "', '" . $_POST['lstYearEntry'] . "', '" . $subcrsID . "')";
				//echo nl2br($sql . '\r\n');
				$result = $db->executeQuery($sql);
			}


			$subjectlist="";
			$sql = "SELECT * FROM `crs_sub` WHERE `courseID` ='" . $_SESSION['courseId'] . "' ";
			$result = $db->executeQuery($sql);
			if ($db->Row_Count($result) > 0 && isset($subcrsID)) {
				if($db->Row_Count($result) == 1){
					$sql = "SELECT * FROM `subject` WHERE `courseID` ='" . $_SESSION['courseId'] . "' order by CAST(suborder AS UNSIGNED)";
					$subjectlist = $db->executeQuery($sql);
				}
				else{
					$subcrsID = $_POST['subcrsID'];
					$sql = "SELECT * FROM `subject` WHERE `subcrsID` ='" . $subcrsID . "' order by CAST(suborder AS UNSIGNED)";
					$subjectlist = $db->executeQuery($sql);
				}           
			}

			
			//echo $db->numRows($subcourselist);
			//echo $db->numRows($subjectlist);
			//echo $db->numRows($studentlist);

			$sql = "SELECT * from crs_enroll WHERE studentID = '" . $studentID . "' AND courseID = '" . $_SESSION['courseId'] . "' AND yearEntry = '" . $_POST['lstYearEntry'] . "' AND subcrsID = '" . $subcrsID . "' ";
			//echo $sql;
			$crsenroll = $db->executeQuery($sql);
			$enroll = $db->fetchArrray($crsenroll);


			//crs enroll
			while ($subject = $db->fetchArrray($subjectlist)) {
				
                if(isset($_POST[$subject['subjectID']])){
				    //subject enroll
				    $sql = "SELECT Enroll_id, subjectID from subject_enroll WHERE Enroll_id = '" . $enroll['Enroll_id'] . "' AND subjectID = '" . $subject['subjectID'] . "';";
				    echo $sql;
				    $result = $db->executeQuery($sql);
				    if ($db->numRows($result) > 0) {
					    //alert
					    //echo nl2br('record available...' . '\r\n');
				    } else {
                        $regDate = $_POST['date']; 
					    //echo nl2br('writing new record...' . '\r\n');
					    $sql = "INSERT INTO subject_enroll (Enroll_id, subjectID, enroll_date) VALUES ('" . $enroll['Enroll_id'] . "', '" . $subject['subjectID'] . "', '" . $regDate . "' )";
					   //echo $sql . '\r\n';
					    $result = $db->executeQuery($sql);
				    }
                }
			}
			
			echo '<script type ="text/JavaScript">';  
			echo 'alert("Successfully enrolled")';
			echo '</script>';

			header("location:courseEnroll.php?studentID=$studentID&date=$date");
		}
	}



    $offset = ($pageNum - 1) * $rowsPerPage;
    $numRows = $db->Row_Count($db->executeQuery($query));
	//$numRows = mysql_num_rows(executeQuery($query));
    $numPages = ceil($numRows / $rowsPerPage);
    $pageQuery = $query . " LIMIT $offset, $rowsPerPage";
    $pageResult = $db->executeQuery($pageQuery);
    ?>
    <table class="searchResults">
        <tr>
            <td>Registration No. : </td><td width = 300><input name="txtRegNo" type="text" value="<?php echo $regNo; ?>" /></td>
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
            <td>Index No. : </td><td><input name="txtIndexNo" type="text" value="<?php  echo $indexNo; ?>" /></td>
        </tr>
        <tr>
            <td>Student ID : </td><td><input name="txtStudentID" type="text" value="<?php echo $studentID; ?>" readonly="readonly" /></td>
        </tr>



        <tr>
            <td>Entry Year : 
            
                <select name="lstYearEntry" id="lstearEntry" >
                    <?php
                    for ($i = 2010; $i <= 2100; $i++) {
                        ?>
                        <option value="<?php echo $i?>" <?php if(date("Y")==$i) echo 'selected'; ?>><?php echo $i?></option>;
                        <?php
                    }
                        ?>
                </select>&nbsp;&nbsp;&nbsp;&nbsp;
            </td>
            <td>Enroll Date : 
            
                <input name="date" id="date" type="text" value="<?php echo $date; ?>" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" required/>
                
    
                <!--
                <input type="date" id="date" name="date" value="<?php echo date("Y-m-d"); ?> " >
                
                    -->
            </td>
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

			if($db->Row_Count($result) == 1){
				$sql = "SELECT * FROM `subject` WHERE `courseID` ='" . $_SESSION['courseId'] . "' order by CAST(suborder AS UNSIGNED)";
                //print $sql;
				$result = $db->executeQuery($sql);

				while ($rowg = $db->Next_Record($result)) {
					//while ($rowg = mysql_fetch_array($resultg))
            ?>
                        <tr>
                            <td><?php echo $rowg['subjectID'] ?></td>
                            <td><?php echo $rowg['codeEnglish'] ?></td>
                            <td><?php echo $rowg['nameEnglish'] ?></td>
                            <td><input type="checkbox" name=<?php echo $rowg['subjectID'] ?> id=<?php echo $rowg['subjectID'] ?>  <?php if ($rowg['Compulsary']=='Yes') echo 'checked'?>></td>
                        </tr>
                        <?php
				}
			}
			else{
				$subcrsID = $_POST['subcrsID'];
				//echo $subcrsID;
				
				
				$sql = "SELECT * FROM `subject` WHERE `subcrsID` ='" . $subcrsID . "' order by CAST(suborder AS UNSIGNED)";
                //print $sql;
				$result = $db->executeQuery($sql);

				while ($rowg = $db->Next_Record($result)) {
					//while ($rowg = mysql_fetch_array($resultg))
                        ?>
                        <tr>
                            <td><?php echo $rowg['subjectID'] ?></td>
                            <td><?php echo $rowg['codeEnglish'] ?></td>
                            <td><?php echo $rowg['nameEnglish'] ?></td>
                            <td><input type="checkbox" name=<?php echo $rowg['subjectID'] ?> id=<?php echo $rowg['subjectID'] ?> <?php if ($rowg['Compulsary']=='Yes') echo 'checked'?>></td>
                        </tr>
                        <?php
				}
			}           
		}
                        ?>


        </table>
        </br>
        <input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'courseEnroll.php?studentID=<?php echo $studentID?>&date= <?php echo $date?>';"  class="button"/>&nbsp;&nbsp;&nbsp;
        <input type="submit"  class="button" name="enroll" value="enroll" />




        <?php
        $self = $_SERVER['PHP_SELF'];
    } else {
        echo "<p>No new enrollments</p>";
    }
        ?>

    <?php
    


	//Assign all Page Specific variables
    $pagemaincontent = ob_get_contents();
    ob_end_clean();
    $pagetitle = "New Course Enrollment - Course Enrollments - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
    $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='courseEnroll.php'>Students </a></li><li><a href='courseEnroll.php?studentID=$studentID'>Course Enrollments </a></li><li>New Course Enrollment</li></ul>";
	//Apply the template
    include("master_sms_external.php");
    ?>