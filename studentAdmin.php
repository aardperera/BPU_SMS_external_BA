<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if (!isset($_SESSION['authenticatedUser'])) {
	echo $_SESSION['authenticatedUser'];
	header("Location: index.php");
}
?>
<?php
    error_reporting(E_ALL & ~E_WARNING);
?>

<script type="text/javascript" language="javascript">
	function MsgOkCancel() {
		var message = "Please confirm to DELETE this student...";
		var return_value = confirm(message);
		return return_value;
	}

	function quickSearch() {
		var regNo = document.getElementById('txtSearch').value;
		if (regNo == "")
			alert("Enter a Registration No");
		else
			document.location.href = 'studentDetails.php?studentID=' + regNo;
	}

	function quickSearch2() {
		var nic = document.getElementById('txtSearchN').value;
		if (nic == "")
			alert("Enter NIC No");
		else
			document.location.href = 'studentAdmin.php?cmd=find&nic=' + nic;
	}


	function onChangeId() {
		var selectedId = $("#studentID").val();
		$("#myName").val(selectedId);
	}
	function myFunction() {
		var selectedName = $("#myName").val();
		$("#studentID").val(selectedName);
	}
</script>
<?php
 //print $_SESSION['courseID'] ;
 
 include('dbAccess.php');
 $db = new DBOperations();

 $stud = "";

 if (isset($_GET['cmd']) && $_GET['cmd'] == "delete") {
	 $regNo = $db->cleanInput($_GET['studentID']);
	 $delQuery = "DELETE FROM student_a WHERE studentID ='$regNo'";
	 $result = $db->executeQuery($delQuery);
 }

 if (isset($_GET['cmd']) && $_GET['cmd'] == "find") {
	 //print 'hhh';
 	$stud = "Not Found";
	 $nic = $db->cleanInput($_GET['nic']);
	 $srcQuery = "Select studentID FROM student_a WHERE nic ='$nic'";
	 //print $srcQuery;
 	$result = $db->executeQuery($srcQuery);
	 $row = $db->Next_Record($result);
	 $stud = $row['studentID'];
	 //print $stud;
 }

 $date = "";
 if (isset($_GET['date'])) {
	 $date = $_GET['date'];
 }

 //session_start();
 
 $rowsPerPage = 10;
 $pageNum = 1;
 if (isset($_GET['page']))
	 $pageNum = $_GET['page'];
 //$nic='';
 //if ($nic == "") {
	 $query = "SELECT * FROM student_a WHERE courseID='" . $_SESSION['courseId'] . "'";
 //} else {
//	 $query = "SELECT * FROM student WHERE courseID='" . $_SESSION['courseId'] . "' and nic=$nic";
 //}

 // counting the offset
 $offset = ($pageNum - 1) * $rowsPerPage;
 $numRows = $db->Row_Count($db->executeQuery($query));
 $numPages = ceil($numRows / $rowsPerPage);

 $pageQuery = $query . " LIMIT $offset, $rowsPerPage";
 $pageResult = $db->executeQuery($pageQuery);

 $studentID = "";
 if (isset($_POST["studentID"])) {
	 $studentID = strip_tags($_POST["studentID"]);
	 //$studentID=echo $studentID;
 
	 //echo $studentID;
 }
 //$nic = "";
 //if (isset($_POST["txtSearchN"])) {
//	 $nic = strip_tags($_POST["txtSearchN"]);
//	 $sqlnic = "SELECT *  FROM student WHERE `nic`= '" . $nic . "'";
//	 $Resultnic = $db->executeQuery($sqlnic);
//	 $rownic = $db->Next_Record($Resultnic);
//	 //$studentID=$rownic['studentID'];
 //
//	 //echo $studentID;
 //	echo 'kkkk';
//	 //echo $studentID;
 //}
 $description = "";
 if (isset($_POST["description"])) {
	 $description = strip_tags($_POST["description"]);
	 //echo $description;
 }

 $subcrsID = "";
 if (isset($_POST["subcrsID"])) {
	 $subcrsID = strip_tags($_POST["subcrsID"]);

 }


 ?>


<h1>Student Administration</h1>
<form method="post" action="" class="plain" id="form1" name="form1">
	<table style="margin-left:8px" class="panel">
		<tr>
			<td><input name="btnNew" type="button" value="New" onclick="document.location.href = 'studentNew.php';"
					class="button" style="width:60px;" />&#160;&#160;&#160;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><input name="btnAuto" type="button" value="Bulk Enrollment"
					onclick="document.location.href = 'courseEnrollBulk.php';" class="button" style="width:100px;" />
			</td>
			<td><input name="btnAuto" type="button" value="LS/BS"
					onclick="document.location.href = 'appStream.php';" class="button" style="width:80px;" />
			</td>
			<td><input name="btnAuto" type="button" value="Reg/ Index No"
					onclick="document.location.href = 'generateNo.php';" class="button" style="width:120px;" />
			</td>
			<td>
                <a href="studentxlsBA.php" class="button">Export Data</a> </br>
				<a href="applicationxlsBA1.php" class="button">Full Report</a>
            </td>
		</tr>
		<tr>
			<input hidden type="text" id="date" name="date" value=" <?php echo $date; ?> " />
		</tr>

		<tr>

			<td>
				<?php
       if (isset($_POST['btn'])) {
	       $studentID = $_POST['studentID'];
	       print $studentID;
	       $subCID = $_POST['description'];
	       if ($subCID != '') {
		       $studentID = '';
	       }

	       $nic = $_POST['txtSearchN'];

	       if ($studentID == 'all') {
		       $subCID = '';
	       }
	       $subCID = "1";
	       $description = $_POST['description'];
	       echo "s  : " . $subCID . "<br> session : " . $_SESSION['courseId'] . "<br> sid : " . $studentID . "<br>";

       }
       ?>

				<?php

      echo "Student ID:&nbsp;";
      echo '<select name="studentID" id="studentID" width="100px" onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
      

      $sql = "SELECT studentID FROM student_a WHERE courseID='" . $_SESSION['courseId'] . "'";
      $result = $db->executeQuery($sql);
      echo '<option value="all">Select All</option>';

      while ($row = $db->Next_Record($result)) {
	      echo '<option value="' . $row['studentID'] . '">' . $row['studentID'] . '</option>';
      }
      echo '</select>'; // Close drop down box
      ?>

				<script>
					document.getElementById('studentID').value = "<?php echo $studentID; ?>";
				</script>


<!-- -------------------------------------------------------------------------------------------------------- -->


<?php

echo "Academic year :&nbsp;";
echo '<select name="acyear" id="acyear" width="100px" onChange="document.form1.submit()" class="form-control">'; // Open your drop down box


$sql = "SELECT DISTINCT acyear  FROM student_a WHERE courseID='" . $_SESSION['courseId'] . "'";
$result = $db->executeQuery($sql);
echo '<option value="all">Select All</option>';

while ($row = $db->Next_Record($result)) {
	echo '<option value="' . $row['acyear'] . '">' . $row['acyear'] . '</option>';
}
echo '</select>'; // Close drop down box
?>

		  <script>
			  document.getElementById('acyear').value = "<?php echo $acyear; ?>";
		  </script>








<!-- ------------------------------------------------------------------------------------------------------ -->

			</td>

			<td>NIC :
				<input name="txtSearchN" type="text" id="txtSearchN" maxlength="10"
					onChange="document.form1.submit()" />
			</td>

			<script>
				document.getElementById('txtSearchN').value = "<?php echo $nic; ?>";
			</script>
			<td>


				<?php
      echo "SubCourse:&nbsp;";
      echo '<select name="description" id="description" onchange="myFunction()" onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
      $sql = "SELECT * FROM `crs_sub` WHERE `courseID` ='" . $_SESSION['courseId'] . "' ";
      $result = $db->executeQuery($sql);
      echo '<option value="all">Select All</option>';

      while ($row = $db->Next_Record($result)) {
	      echo '<option value="' . $row['subcrsID'] . '">' . $row['description'] . '</option>';
      }
      echo '</select>'; // Close drop down box
      ?>

				<script>
					document.getElementById('description').value = "<?php echo $subcrsID; ?>";
				</script>

			</td>




			<td>
				<input type="submit" name="btn" value="&nbsp;View&nbsp;" onclick="quickSearch2();">
			</td>
		</tr>


	</table>

	<?php if ($db->Row_Count($pageResult) > 0) { ?>
	<br />
	<table class="searchResults">
		<tr>
			<th>Student ID</th>
			<th>Title</th>
			<th>Name</th>
			<th>Address</th>
			<th colspan="4"></th>
		</tr>

		<?php
	if (($studentID == 'all' || $studentID == "") && ($subCID == "" || $subCID == 'all')) {
		$sql = "SELECT * FROM student_a WHERE courseID='" . $_SESSION['courseId'] . "'";

	} else {
		$sql = "SELECT *  FROM student_a WHERE `studentID`= '" . $studentID . "'";

	}

	if ($nic == "") {
		$sql3 = "SELECT * FROM student_a WHERE courseID='" . $_SESSION['courseId'] . "'";

	} else {
		$sqlnic = "SELECT *  FROM student_a WHERE `nic`= '" . $nic . "'";
		$Resultnic = $db->executeQuery($sqlnic);
		$rownic = $db->Next_Record($Resultnic);
		$studentID = $rownic['studentID'];


	}

	if ($subCID != "" && $studentID == '') {


		/*if($nic==''){
		
		$sql1="SELECT * FROM `crs_enroll` WHERE `courseID` ='".$_SESSION['courseId']."' and `subcrsID` ='".$subCID."' ORDER BY `crs_enroll`.`subcrsID` ASC ";
		$Result = executeQuery($sql1);
		
		}
		else {
		$sql1="SELECT *  FROM student WHERE `nic`= '".$nic."'";
		$Result = executeQuery($sql1);
		}
		*/



		while ($row = $db->Next_Record($Result)) {

			$sql2 = "SELECT *  FROM student_a WHERE `studentID`= '" . $row['studentID'] . "'";



			$pageResult1 = $db->executeQuery($sql2);
			print $sql2;

			while ($row = $db->Next_Record($pageResult1)) {
?>
		<tr>
			<td><?php echo $row['studentID'] ?></td>
			<td><?php echo $row['title'] ?></td>
			<td><?php echo $row['nameEnglish'] ?></td>
			<td><?php echo $row['addressE1'] . $row['addressE2'] . $row['addressE3'] ?></td>
			<td><input name="btnDetails" type="button" value="Details"
					onclick="document.location.href ='studentDetails.php?studentID=<?php echo $row['studentID']?>'"
					class="button" style="width:60px;" /></td>


					<td>

					<input name="btnDetails" type="button" style="width:30px; font-size:smaller; padding-bottom:2px; padding-top:2px;" value="Details" onclick="document.location.href ='applicantDetailsBA.php?studentID=<?php echo $row['applicantID'] ?>&page=<?php echo $pageNum?>&select=<?php echo $select?>&acyear=<?php echo $acyear?>'" class="button" style="width:60px;" />
					</td>
			<td><input name="btnEdit" type="button" value="Edit"
					onclick="document.location.href ='studentEdit.php?studentID=<?php echo $row['studentID']?>'"
					class="button" style="width:60px;" /></td>
					
			<td><input name="btnDelete" type="button" value="Delete" class="button"
					onclick="if (MsgOkCancel()) document.location.href ='studentAdmin.php?cmd=delete&studentID=<?php echo $row['studentID'] ?>'"
					style="width:60px;" /></td>
			<td><input name="btnEnroll" type="button" value="Enrollments"
					onclick="document.location.href ='courseEnroll.php?studentID=<?php echo $row['studentID'] ?>&date= <?php $date ?>'"
					class="button" style="width:80px;" /></td>
		</tr>
		<?php

			}
		}

	} else {

	}

	$pageResult = $db->executeQuery($sql);
	while ($row = $db->Next_Record($pageResult)) {


                ?>
		<tr>
			<td><?php echo $row['studentID'] ?></td>
			<td><?php echo $row['title'] ?></td>
			<td><?php echo $row['nameEnglish'] ?></td>
			<td><?php echo $row['addressE1'] . $row['addressE2'] . $row['addressE3'] ?></td>
			<td><input name="btnDetails" type="button" value="Details"
							onclick="document.location.href ='studentDetails.php?studentID=<?php echo $row['studentID'] ?>'"
							class="button" style="width:60px;" /></td>
					<td><input name="btnEdit" type="button" value="Edit"
							onclick="document.location.href ='studentEdit.php?studentID=<?php echo $row['studentID'] ?>'"
							class="button" style="width:60px;" /></td>
					<td><input name="btnDelete" type="button" value="Delete" class="button"
							onclick="if (MsgOkCancel()) document.location.href ='studentAdmin.php?cmd=delete&studentID=<?php echo $row['studentID'] ?>'"
							style="width:60px;" /></td>
					<td><input name="btnEnroll" type="button" value="Enrollments"
							onclick="document.location.href ='courseEnroll.php?studentID=<?php echo $row['studentID'] ?>&date=<?php echo $date ?>'"
							class="button" style="width:80px;" /></td>
		</tr>
		<?php
	}

?>
	</table>
</form>
<?php
	$self = $_SERVER['PHP_SELF'];
	if ($pageNum > 1) {
		$page = $pageNum - 1;
		$prev = " <a class=\"link\" href=\"$self?page=$page\">[Prev]</a> ";
		$first = " <a class=\"link\" href=\"$self?page=1\">[First Page]</a> ";
	} else {
		$prev = '&nbsp;'; // we're on page one, don't print previous link
		$first = '&nbsp;'; // nor the first page link
	}

	if ($pageNum < $numPages) {
		$page = $pageNum + 1;
		$next = " <a class=\"link\" href=\"$self?page=$page\">[Next]</a> ";
		$last = " <a class=\"link\" href=\"$self?page=$numPages\">[Last Page]</a> ";
	} else {
		$next = '&nbsp;'; // we're on the last page, don't print next link
		$last = '&nbsp;'; // nor the last page link
	}

	echo "<table border=\"0\" align=\"center\" width=\"50%\"><tr><td width=\"20%\">" . $first . "</td><td width=\"10%\">" . $prev . "</td><td width=\"10%\">" . "$pageNum of $numPages" . "</td><td width=\"10%\">" . $next . "</td><td width=\"30%\">" . $last . "</td></tr></table>";
} else
	echo "<p>No students.</p>";

?>

<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li>Students</li></ul>";
//Apply the template
include("master_sms_external.php");
?>