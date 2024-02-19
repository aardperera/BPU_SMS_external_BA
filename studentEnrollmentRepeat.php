<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if (!isset($_SESSION['authenticatedUser'])) {
	echo $_SESSION['authenticatedUser'];
	header("Location: index.php");
}
//print $_SESSION['courseID'] ;

include('dbAccess.php');
$db = new DBOperations;

$stud = "";

$acyear = "";

if (isset($_POST["acyear"])) {
	$acyear = strip_tags($_POST["acyear"]);
	//echo $acyear;
}

$subjectID = "";
if (isset($_POST["subjectID"])) {
	$subjectID = strip_tags($_POST["subjectID"]);
	//echo $courseID;
}

if (isset($_POST['enroll'])) {

	$subjects = "";
	$students = "";
	if ($acyear != '') {
		if ($subjectID != '') {
			$students = "SELECT * FROM exameffort INNER JOIN crs_enroll ON exameffort.indexNo = crs_enroll.indexNo where subjectID = $subjectID and (grade = 'E' or grade = 'AB') and yearEntry = $acyear; ";
		}

		$studentlist = $db->executeQuery($students);

		//find the course and subcourse related to the subject
		$sql = "SELECT * FROM `crs_subject` WHERE subjectID = $subjectID;";
		$result = $db->executeQuery($sql);
		$subject = $db->fetchArrray($result);
		//echo $subject['courseID'] . $subject['subcrsID'];

		while ($student = $db->fetchArrray($studentlist)) {	


			//check the record
			
			$year = $student['acYear'] + 1;
			$sql = "SELECT * from crs_enroll WHERE studentID = '" . $student['studentID'] . "' AND courseID = '" . $subject['CourseID'] . "' AND yearEntry = '" . $year . "' AND subcrsID = '" . $subject['subcrsid'] . "';";
			//echo $sql;
			$result = $db->executeQuery($sql);
			if ($db->numRows($result) > 0) {
				//alert course record exist
				 //echo nl2br('course record exist' . '\r\n');
			} else {
				//create a new course record
				//echo nl2br('writing new record...' . '\r\n');
				$sql = "INSERT INTO crs_enroll (regNo, indexNo, studentID, courseID, yearEntry, subcrsID) VALUES ('" . $student['studentID'] . "', '" . $student['studentID'] . "', '" . $student['studentID'] . "','" . $subject['CourseID'] . "', '" . $year . "', '" . $subject['subcrsid'] . "')";
				//echo nl2br($sql . '\r\n');
				$result = $db->executeQuery($sql);
			}



			//get Enroll_id
			$sql = "SELECT * from crs_enroll WHERE studentID = '" . $student['studentID'] . "' AND courseID = '" . $subject['CourseID'] . "' AND yearEntry = '" . $year . "' AND subcrsID = '" . $subject['subcrsid'] . "' ";
			//echo $sql;
			$crsenroll = $db->executeQuery($sql);
			$enroll = $db->fetchArrray($crsenroll);

			//subject enroll
			$sql = "SELECT Enroll_id, subjectID from subject_enroll WHERE Enroll_id = '" . $enroll['Enroll_id'] . "' AND subjectID = '" . $subject['subjectID'] . "';";
			//echo $sql;
			$result = $db->executeQuery($sql);
			if ($db->numRows($result) > 0) {
				//alert
				//echo nl2br('record available...' . '\r\n');
			} else {
				//echo nl2br('writing new record...' . '\r\n');
				$sql = "INSERT INTO subject_enroll (Enroll_id, subjectID, enroll_date) VALUES ('" . $enroll['Enroll_id'] . "', '" . $subject['subjectID'] . "', '" . date("Y-m-d") . "' )";
				//echo $sql . '\r\n';
				$result = $db->executeQuery($sql);
			}
		}
		
		echo '<script type ="text/JavaScript">';  
		echo 'alert("Successfully enrolled repeat students")';
		echo '</script>';  
	}
}

?>


<h1>Repeat Student Enrollment</h1>
<form method="post" action="" class="plain" id="form1" name="form1">
	<table style="margin-left:8px" class="panel">

		<tr>

			<td>
				<?php

				echo "Academic Year :";
				echo '<select name="acyear" id="acyear" width="100px" onChange="document.form1.submit()" class="form-control">'; // Open your drop down box


				//$sql = "SELECT acyear FROM student WHERE courseID='" . $_SESSION['courseId'] . "'";
				$sql = "SELECT acYear FROM sms_external.exameffort inner join subject on exameffort.subjectID = subject.subjectID where grade = 'AB' group by acYear; ;";
				$result = $db->executeQuery($sql);
				//echo '<option value="all">Select All</option>';

				echo '<option value="" selected="selected" disabled >Select an academic year</option>';
				while ($row = mysqli_fetch_array($result)) {
					echo '<option value="' . $row['acYear'] . '">' . $row['acYear'] . '</option>';
				}
				echo '</select>'; // Close drop down box
				?>

				<script>
					document.getElementById('acyear').value = "<?php echo $acyear; ?>";
				</script>

			</td>

			<td>
				<?php
				echo "Course :";
				echo '<select name="subjectID" id="subjectID" onChange="document.form1.submit()" class="form-control">'; // Open your drop down box

				$sql = "";
				if ($acyear != "") {
					$sql = "SELECT exameffort.subjectID, codeEnglish, nameEnglish FROM sms_external.exameffort inner join subject on exameffort.subjectID = subject.subjectID where grade = 'AB' and acYear = $acyear group by exameffort.subjectID order by codeEnglish; ";
				} else {
					$sql = "SELECT exameffort.subjectID, codeEnglish, nameEnglish FROM sms_external.exameffort inner join subject on exameffort.subjectID = subject.subjectID where grade = 'AB' group by exameffort.subjectID order by codeEnglish; ";
				}

				$result = $db->executeQuery($sql);
				echo '<option value="" selected="selected" disabled >Select All</option>';

				while ($row = mysqli_fetch_array($result)) {
					echo '<option value="' . $row['subjectID'] . '">' . $row['codeEnglish'] . '-' . $row['nameEnglish'] . '</option>';
				}
				echo '</select>'; // Close drop down box
				?>

				<script>
					document.getElementById('subjectID').value = "<?php echo $subjectID; ?>";
				</script>

			</td>

		</tr>


	</table>
	<br />


	<?php
	$sql = "";

	if ($subjectID != "") {


		if ($acyear != "") {
			$sql = "SELECT * FROM exameffort  where subjectID = $subjectID and (grade = 'E' or grade = 'AB') and acYear = $acyear; ";
		} else {
			$sql = "SELECT * FROM exameffort  where subjectID = $subjectID and (grade = 'E' or grade = 'AB'); ";
		}
		$pageResult1 = $db->executeQuery($sql);
		//print $sql;
		if (mysqli_num_rows($pageResult1) > 0) { ?>
			<br />
			<h2> Students for the selected subject </h2>

			<table class="searchResults">
				<tr>
					<th>Index No.</th>
					<th>Name</th>
					<th>Academic Year</th>
					<th>Marks</th>
					<th>Grade</th>
					<th>Selection</th>
				</tr>
				<?php
				while ($row = mysqli_fetch_array($pageResult1)) {
				?>
					<tr>
						<td><?php echo $row['indexNo'] ?></td>
						<td><?php echo $row['indexNo'] ?></td>
						<td><?php echo $row['acYear'] ?></td>
						<td><?php if ($row['marks'] == 'AB' || $row['marks'] == 'E') echo '';
							else echo $row['marks'] ?></td>
						<td><?php if ($row['grade'] == 'AB') echo 'Ab';
							else echo $row['grade'] ?></td>
					</tr>

				<?php

				}
				?>
			</table>
			<br />
			<input type="submit" name="enroll" value="enroll" />
	<?php

		} else echo "<p>No any student for this course.	</p>";
	}


	//Assign all Page Specific variables
	$pagemaincontent = ob_get_contents();
	ob_end_clean();
	$pagetitle = "Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
	$navpath = "<ul><li><a href='index.php'>Home </a></li><li>Student Enrollment</li></ul>";
	//Apply the template
	include("master_sms_external.php");
	?>