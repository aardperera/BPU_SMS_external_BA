<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if (!isset($_SESSION['authenticatedUser'])) {
	echo $_SESSION['authenticatedUser'];
	header("Location: index.php");
}
?>

<script type="text/javascript" language="javascript">
	function MsgOkCancel() {
		var message = "Please confirm to DELETE this student...";
		var return_value = confirm(message);
		return return_value;
	}


	function onChangeId() {
		var selectedId = $("#acyear").val();
		$("#myName").val(selectedId);
	}

	function myFunction() {
		var selectedName = $("#myName").val();
		$("#acyear").val(selectedName);
	}
</script>
<?php
//print $_SESSION['courseID'] ;

include('dbAccess.php');
$db = new DBOperations;

$stud = "";

$acyear = "";

if (isset($_POST["acyear"])) {
	$acyear = strip_tags($_POST["acyear"]);
	//echo $acyear;
}

$courseID = "";
if (isset($_POST["courseID"])) {
	$courseID = strip_tags($_POST["courseID"]);
	//echo $courseID;
}


if (isset($_POST['enroll'])) {

	$subjects = "";
	$students = "";
	if ($acyear != '') {
		if ($courseID != '') {
			//$subcourses = "SELECT CourseID, subcrsid FROM `crs_subject` WHERE CourseID = '" . $courseID . "' AND crs_subject.Compulsary = 'Yes' Group By subcrsid;";
			$subjects = "SELECT crs_subject.CourseID, combinationID, crs_subject.subjectID, crs_subject.subcrsid FROM `crs_subject` INNER JOIN subject ON crs_subject.subjectID = subject.subjectID WHERE crs_subject.CourseID = '" . $courseID . "' AND crs_subject.Compulsary = 'Yes'";
			$students = "SELECT acyear, studentID FROM student INNER JOIN course ON student.courseID = course.courseID WHERE acyear = '" . $acyear . "' AND student.courseID = '" . $courseID . "';";
		}

		//echo $subjects;
		//echo $students;
		//$subcourselist = $db->executeQuery($subcourses);
		$subjectlist = $db->executeQuery($subjects);
		$studentlist = $db->executeQuery($students);

		//echo $db->numRows($subcourselist);
		//echo $db->numRows($subjectlist);
		//echo $db->numRows($studentlist);



		while ($student = $db->fetchArrray($studentlist)) {
			
			$subjectlist = $db->executeQuery($subjects);

			//crs enroll
			while ($subject = $db->fetchArrray($subjectlist)) {

				$sql = "SELECT * from crs_enroll WHERE studentID = '" . $student['studentID'] . "' AND courseID = '" . $courseID . "' AND yearEntry = '" . $student['acyear'] . "' AND subcrsID = '" . $subject['subcrsid'] . "' ";
				//echo $sql;
				$result = $db->executeQuery($sql);
				if ($db->numRows($result) > 0) {
					//alert
					//echo nl2br('record available...' . '\r\n');
				} else {
					//echo nl2br('writing new record...' . '\r\n');
					$sql = "INSERT INTO crs_enroll (regNo, indexNo, studentID, courseID, yearEntry, subcrsID) VALUES ('" . $student['studentID'] . "', '" . $student['studentID'] . "', '" . $student['studentID'] . "', '" . $subject['CourseID'] . "', '" . $student['acyear'] . "', '" . $subject['subcrsid'] . "')";
					//echo nl2br($sql . '\r\n');
					$result = $db->executeQuery($sql);
				}

				$sql = "SELECT * from crs_enroll WHERE studentID = '" . $student['studentID'] . "' AND courseID = '" . $courseID . "' AND yearEntry = '" . $student['acyear'] . "' AND subcrsID = '" . $subject['subcrsid'] . "' ";
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
		}
		echo '<script type ="text/JavaScript">';  
		echo 'alert("Successfully enrolled student for masters")';
		echo '</script>';
	}
}

?>


<h1>Student Enrollment for Masters</h1>
<form method="post" action="" class="plain" id="form1" name="form1">
	<table style="margin-left:8px" class="panel">

		<tr>

			<td>
				<?php
				if (isset($_POST['btn'])) {
					$acyear = $_POST['acyear'];
					$courseID = $_POST['courseID'];

					echo "s  : <br> session : " . $_SESSION['courseId'] . "<br> sid : " . $acyear . "<br>";
				}
				?>

				<?php

				echo "Academic Year :";
				echo '<select name="acyear" id="acyear" width="100px" onChange="document.form1.submit()" class="form-control">'; // Open your drop down box


				//$sql = "SELECT acyear FROM student WHERE courseID='" . $_SESSION['courseId'] . "'";
				$sql = "SELECT acyear FROM `student` INNER JOIN course ON student.courseID = course.courseID WHERE acyear != 0 AND course.courseType = 'Master' GROUP BY acyear;";
				$result = $db->executeQuery($sql);
				//echo '<option value="all">Select All</option>';

				echo '<option value="" selected="selected" disabled >Select an academic year</option>';
				while ($row = mysqli_fetch_array($result)) {
					echo '<option value="' . $row['acyear'] . '">' . $row['acyear'] . '</option>';
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
				echo '<select name="courseID" id="courseID" onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
				//$sql = "SELECT * FROM `crs_sub` WHERE `courseID` ='" . $_SESSION['courseId'] . "' ";
				//$sql = "SELECT * FROM `crs_sub` WHERE 1";

				$sql = "SELECT * FROM `course` WHERE courseType = 'Master';";

				$result = $db->executeQuery($sql);
				echo '<option value="" selected="selected" disabled >Select All</option>';

				while ($row = mysqli_fetch_array($result)) {
					echo '<option value="' . $row['courseID'] . '">' . $row['courseCode'] . '-' . $row['nameEnglish'] . '</option>';
				}
				echo '</select>'; // Close drop down box
				?>

				<script>
					document.getElementById('courseID').value = "<?php echo $courseID; ?>";
				</script>

			</td>

		</tr>


	</table>
	<br />
	<input type="submit" name="enroll" value="enroll" />



	<?php
	$sql = "";

	if ($courseID != "") {


		$sql = "SELECT * FROM `crs_subject` INNER JOIN subject ON crs_subject.subjectID = subject.subjectID WHERE crs_subject.CourseID = '" . $courseID . "' AND crs_subject.Compulsary = 'Yes'";

		$pageResult1 = $db->executeQuery($sql);
		//print $sql;
		if (mysqli_num_rows($pageResult1) > 0) { ?>
			<br />
			<h2> Subjects for the selected course </h2>

			<table class="searchResults">
				<tr>
					<th>Code</th>
					<th>Name</th>
					<th>Faculty</th>
					<th>Semester</th>
					<th>Compulsary</th>
				</tr>
				<?php
				while ($row = mysqli_fetch_array($pageResult1)) {
				?>
					<tr>
						<td><?php echo $row['codeEnglish'] ?></td>
						<td><?php echo $row['nameEnglish'] ?></td>
						<td><?php echo $row['faculty'] ?></td>
						<td><?php echo $row['semester'] ?></td>
						<td><?php echo $row['Compulsary'] ?></td>
					</tr>

				<?php

				}
				?>
			</table>
			<br />
			<?php

		} else echo "<p>No any subject for this course.	</p>";
	}


	if ($acyear != '') {

		if ($courseID != "") {
			//$sql = "SELECT *  FROM student WHERE `acyear`= '" . $acyear . "' AND `courseID`= '" . $courseID . "'";		
			$sql = "SELECT acyear, studentID, title, student.nameEnglish, contactNo, courseCode  FROM student INNER JOIN course ON student.courseID = course.courseID WHERE acyear = '" . $acyear . "' AND student.courseID = '" . $courseID . "'";


			$pageResult1 = $db->executeQuery($sql);
			//print $sql;
			if (mysqli_num_rows($pageResult1) > 0) { ?>
				<br />
				<h2>Student for the selected course </h2>
				<table class="searchResults">
					<tr>
						<th>Academic Year</th>
						<th>Student ID</th>
						<th>Title</th>
						<th>Name</th>
						<th>Telephone</th>
						<th>Course</th>
					</tr>
					<?php
					while ($row = mysqli_fetch_array($pageResult1)) {
					?>
						<tr>
							<td><?php echo $row['acyear'] ?></td>
							<td><?php echo $row['studentID'] ?></td>
							<td><?php echo $row['title'] ?></td>
							<td><?php echo $row['nameEnglish'] ?></td>
							<td><?php echo $row['contactNo'] ?></td>
							<td><?php echo $row['courseCode'] ?></td>
						</tr>

			<?php

					}
				} else echo "<p>No students.</p>";
			} else echo "<p>Please select a year and a course.</p>";
			?>
				</table>
</form>
<?php
	}
?>

<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='index.php'>Home </a></li><li>Student Enrollment</li></ul>";
//Apply the template
include("master_sms_external.php");
?>