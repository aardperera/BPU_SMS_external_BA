<?php
 //Buffer larger content areas like the main page content
 ob_start();
 session_start();

 if (!isset($_SESSION['authenticatedUser'])) {
	 echo $_SESSION['authenticatedUser'];
	 header("Location: index.php");
 }
?>


<script language="javascript">
 	function MsgOkCancel()	{

		var message = "Please confirm to DELETE this entry...";
		var return_value = confirm(message);
		return return_value;
	}

    function getGrade(mark2,id,row)	{
		var grade;
		var gradePoint;

		var mark1 = document.getElementById(id).value;
		
		if(mark1.includes('AB') || mark1.includes('MD')){
			//document.getElementById('txtMarks2' + row).value = mark1;
			grade = '';
			marks='';
			gradePoint = '0.0';
			document.getElementById('txtMarks' + row).value = marks;
			document.getElementById('txtGrade'+row).value = grade;
			document.getElementById('txtGradePoint'+row).value = gradePoint;
		}
		else{

			var average;
			grade = '';
			marks='';
			gradePoint='0.0';
			mark1=eval(mark1);
			mark2=eval(mark2);


			average=Math.round((mark1+mark2)/2);
			//average=((mark1+mark2)/2);


			document.getElementById('txtMarks'+row).value=average;
			marks=average;
			if (0<=marks && marks<=24) {grade = 'E'; gradePoint='0.0';}
			else if (25<=marks && marks<=29) {grade = 'D'; gradePoint='1.0';}
			else if (30<=marks && marks<=34) {grade = 'D+'; gradePoint='1.3';}
			else if (35<=marks && marks<=39) {grade = 'C-'; gradePoint='1.7';}
			else if (40<=marks && marks<=44) {grade = 'C'; gradePoint='2.0';}
			else if (45<=marks && marks<=49) {grade = 'C+'; gradePoint='2.3';}
			else if (50<=marks && marks<=54) {grade = 'B-'; gradePoint='2.7';}
			else if (55<=marks && marks<=59) {grade = 'B'; gradePoint='3.0';}
			else if (60<=marks && marks<=64) {grade = 'B+'; gradePoint='3.3';}
			else if (65<=marks && marks<=69) {grade = 'A-'; gradePoint='3.7';}
			else if (70<=marks && marks<=84) {grade = 'A'; gradePoint='4.0';}
			else if (85<=marks && marks<=100) {grade = 'A+'; gradePoint='4.0';}
			else grade = '';

			document.getElementById('txtGrade'+row).value = grade;
			document.getElementById('txtGradePoint'+row).value = gradePoint;
		}
	}
</script>
<?php
include('dbAccess.php');

$db = new DBOperations();


if (isset($_POST['courseID']))
{
	$courseID=$_POST['courseID'];
}

if (isset($_POST['subcrsID']))
{
	$subcrsID=$_POST['subcrsID'];
}
if (isset($_POST['acyear']))
{
	$acyear=$_POST['acyear'];
}
if (isset($_POST['SubjectID']))
{
	$SubjectID=$_POST['SubjectID'];
}

//print $acyear;
if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
{
	$effortID = $db->cleanInput($_GET['effortID']);
	$delQuery = "DELETE FROM exameffort WHERE effortID='$effortID'";
	$result = $db->executeQuery($delQuery);
}

//session_start();

if (isset($_POST['btnSubmit']))
{
	//$indexNo = $_SESSION['indexNo'];
	///print $indexNo[1];
	$queryall = "Select * from subject_enroll as s, crs_enroll as c, paymentEnroll as p where s.subjectID='$SubjectID' and s.Enroll_id=c.Enroll_id and c.yearEntry='$acyear' and p.payment1='1' and p.payment2='1' and c.Enroll_id=p.enroll_id ";
	//print $queryall;
	$resultall = $db->executeQuery($queryall);
	while ($row=  $db->Next_Record($resultall))
	{
		$indexNo=$row['indexNo'];

		//print $marks ;
		//print 'g';
		$queryexist = "Select * from exameffort where subjectID='$SubjectID' and indexNo='$indexNo' and acYear='$acyear'";

		$resultexist = $db->executeQuery($queryexist);
		$roweffort=  $db->Next_Record($resultexist);
		$effortvalue=$roweffort['effortID'];
		// print  $effortvalue;

		$mark2 = $db->cleanInput($_POST['txtMarks2'.$effortvalue]);
        $marks = $db->cleanInput($_POST['txtMarks'.$effortvalue]);
        $grade = $db->cleanInput($_POST['txtGrade'.$effortvalue]);
        $gradepoint = $db->cleanInput($_POST['txtGradePoint'.$effortvalue]);
		if($mark2=='AB'){
            $result = $db->executeQuery("UPDATE exameffort set mark2='$mark2',marks='AB',grade='AB',gradePoint='$gradepoint',effort='1' where effortID='$effortvalue' ");
		}
		else if($mark2=='MD'){
            $result = $db->executeQuery("UPDATE exameffort set mark2='$mark2',marks='MD',grade='MD',gradePoint='$gradepoint',effort='1' where effortID='$effortvalue' ");
		}
		else{
			//$grade = $db->cleanInput($_POST['txtGrade'.$effortID]);
			$updatequery = "UPDATE exameffort set mark2='$mark2',marks='$marks',grade='$grade',gradePoint='$gradepoint',effort='1' where effortID='$effortvalue' ";
			$result = $db->executeQuery($updatequery);
        }//print "UPDATE exameffort set mark2='$mark2',marks='$marks',grade='$grade',gradePoint='$gradepoint',effort='1' where effortID='$effortvalue' ";

	}
	header("location:examAdmin.php");
}

//$query = $_SESSION['query'];

?>

<h1>Enter Results</h1>
<br />

<?php
//if ($db->Row_Count($result)>0){
?>
<form method="post" action="" name="form1" id="form1" class="plain">
    <br />
    <table width="230" class="searchResults">
        <tr>
            <td width="127">Course  :</td>

            <td width="91">
                <select id="courseID" name="courseID" onchange="document.form1.submit()">
                    <?php
					$query = "SELECT courseID,courseCode FROM course WHERE `courseID` ='" . $_SESSION['courseId'] . "' ";
					$result = $db->executeQuery($query);
					while ($data= $db->Next_Record($result))
					{
						echo '<option value="'.$data['courseID'].'">'.$data['courseCode'].'</option>';
					}
                    ?>
                </select>
                <script type="text/javascript" language="javascript">
		document.getElementById('courseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
                </script>
            </td>
        </tr>



        <tr>
            <td>SubCourse: </td>
            <td>
                <label>
                    <?php

					echo '<select name="subcrsID" id="subcrsID"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
					if(isset($courseID)){
						$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_POST['courseID']."' ";
						$result = $db->executeQuery($sql);
						//echo '<option value="all">Select All</option>';
						echo sql;
						while ($row =  $db->Next_Record($result)){
							echo '<option value="'.$row['id'].'">' . $row['description'] . '</option>';
						}
					}
					echo '</select>';// Close drop down box
                    ?>

                    <script>
								document.getElementById('subcrsID').value = "<?php if(isset($subcrsID)) echo $subcrsID;?>";
                    </script>
                </label>
            </td>

        </tr>


        <tr>
            <td>Subject: </td>
            <td>
                <label>
                    <select id="SubjectID" name="SubjectID" onchange="document.form1.submit()">
                        <?php
						if(isset($subcrsID))
						{
							$sql = "SELECT * FROM `crs_sub` WHERE `courseID` ='" . $_POST['courseID'] . "' ";
							$result = $db->executeQuery($sql);
							if ($db->Row_Count($result) > 0 && isset($subcrsID)) {

								if($db->Row_Count($result) == 1){
									//$sql = "SELECT * FROM `subject` WHERE `courseID` ='" . $_POST['courseID'] . "' order by CAST(suborder AS UNSIGNED)";
									$sql = "SELECT  a.subjectID,a.codeEnglish,a.Compulsary,a.nameEnglish,a.nameSinhala,a.level,a.creditHours,a.suborder FROM subject as a, course as b, crs_subject as c WHERE b.courseID=c.courseID and a.subjectID=c.subjectID and c.courseID='5' and c.subcrsID='$subcrsID'";
									$result = $db->executeQuery($sql);

									while ($rowg = $db->Next_Record($result)) {
										//while ($rowg = mysql_fetch_array($resultg))
										echo '<option value="' . $rowg['subjectID'] .'">'. $rowg['codeEnglish'] .'--'. $rowg['nameEnglish'] .'</option>';
									}
								}
								else{
									$subcrsID = $_POST['subcrsID'];
									//echo $subcrsID;

									//$sql = "SELECT * FROM `subject` WHERE `subcrsID` ='" . $subcrsID . "' order by CAST(suborder AS UNSIGNED)";
									$sql = "SELECT  a.subjectID,a.codeEnglish,a.Compulsary,a.nameEnglish,a.nameSinhala,a.level,a.creditHours,a.suborder FROM subject as a, course as b, crs_subject as c WHERE b.courseID=c.courseID and a.subjectID=c.subjectID and c.courseID='5' and c.subcrsID='$subcrsID'";
									$result = $db->executeQuery($sql);

									while ($rowg = $db->Next_Record($result)) {
										echo '<option value="' . $rowg['subjectID'] .'">'. $rowg['codeEnglish'] .'--'. $rowg['nameEnglish'] .'</option>';
									}
								}
							}
						}

                        ?>
                    </select>
                    <script type="text/javascript" language="javascript">
		document.getElementById('SubjectID').value="<?php if(isset($SubjectID)){echo $SubjectID;}?>";
                    </script>
                </label>
            </td>
        </tr>
        <tr>
            <td>Academic Year: </td>
            <td>
                <label>
                    <?php

					echo '<select name="acyear" id="acyear"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box

					$sql="SELECT distinct yearEntry FROM crs_enroll order by yearEntry";
					$result = $db->executeQuery($sql);
					//echo '<option value="all">Select All</option>';

					while ($row =  $db->Next_Record($result)){
						echo '<option value="'.$row['yearEntry'].'">'.$row['yearEntry'].'</option>';
					}
					echo '</select>';// Close drop down box
                    ?>

                    <script>
								document.getElementById('acyear').value = "<?php if(isset($acyear)) echo $acyear;?>";
                    </script>
                </label>
            </td>

        </tr>
    </table>





    <table class="searchResults">
        <tr>
            <th>Index No.</th><th>Mark 1</th><th>Mark 2</th><th>Marks</th><th>Grade</th><th>Grade Point</th>
        </tr>

        <?php


		if (isset($_POST['SubjectID']) && isset($_POST['acyear']))
		{



			$queryall = "Select * from subject_enroll as s, crs_enroll as c, paymentEnroll as p where s.subjectID='$SubjectID' and s.Enroll_id=c.Enroll_id and c.yearEntry='$acyear' and p.payment1='1' and p.payment2='1' and c.Enroll_id=p.enroll_id order by c.indexNo ";
			//print $queryall;
			$resultall = $db->executeQuery($queryall);

			//print 'll';
			//		print $query12;
			//$result12 = $db->executeQuery($query12);
			//$row12=  $db->Next_Record($result12);
			while ($row=  $db->Next_Record($resultall))
			{
				$indexNo=$row['indexNo'];
				$query12 = "Select * from exameffort where subjectID='$SubjectID' and indexNo='$indexNo' and acYear='$acyear'";
				//print $query12;
				$result12 = $db->executeQuery($query12);
				$row=  $db->Next_Record($result12);
        ?>

        <tr>

            <?php

                $indexNo=$row['indexNo'] ;
                $querymark1 = "Select * from exameffort where subjectID='$SubjectID' and indexNo='$indexNo' and acYear='$acyear'";
                $resultmark = $db->executeQuery($querymark1);
                $rowmark=  $db->Next_Record($resultmark);

                
            ?>
            <td align="center">
                <?php echo $row['indexNo'] ?>
            </td>
            <td align="center">
                <input style="border:hidden; text-align:center" size="4" name="txtMarks1<?php echo $rowmark['effortID'] ?>" id="txtMarks1<?php echo $rowmark['effortID'] ?>" value="<?php echo $rowmark['mark1'] ?>" type="text" readonly />
            </td>
            <td align="center">
                <input type="text" id="txtMarks2<?php echo $rowmark['effortID'] ?>" name="txtMarks2<?php echo $rowmark['effortID'] ?>" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); verifymark('txtMarks2<?php echo $rowmark['effortID'];?>', 'txtMarks1<?php echo $rowmark['effortID'];?>'); verifydiff('txtMarks2<?php echo $rowmark['effortID'];?>', 'txtMarks1<?php echo $rowmark['effortID'];?>', this.value);" onkeyup="getGrade(this.value,'txtMarks1<?php echo $rowmark['effortID'];?>',<?php echo $rowmark['effortID'];?>);" required onchange="verifymark('txtMarks2<?php echo $rowmark['effortID'] ?>', 'txtMarks1<?php echo $rowmark['effortID'];?>'); verifydiff('txtMarks2<?php echo $rowmark['effortID'];?>', 'txtMarks1<?php echo $rowmark['effortID'];?>', this.value);" value="<?php if($rowmark['mark2'] != null) echo $rowmark['mark2'];?>" <?php if($rowmark['mark1'] != "AB" && $rowmark['mark1'] != "MD" && ($rowmark['mark1']-$rowmark['mark2'] > 10 || $rowmark['mark2']-$rowmark['mark1'] > 10)) echo 'style="color:red;"'; ?> />

                <!--
					<input size="3" name="txtMarks2<?php echo $rowmark['effortID'] ?>" id="txtMarks2<?php echo $rowmark['effortID'] ?>" value="<?php if($rowmark) echo $rowmark['mark2'];?>" onkeyup="getGrade(this.value,<?php echo $rowmark['mark1']; ?>,<?php echo $rowmark['effortID']; ?>)" type="text" maxlength="3" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); verifymark('txtMarks2<?php echo $rowmark['effortID'];?>', <?php echo $rowmark['mark1'];?>,this.value);" <?php if($rowmark['mark1']-$rowmark['mark2'] > 10 || $rowmark['mark2']-$rowmark['mark1'] > 10) echo 'style="color:red;"'; ?> required />
                                -->
					<span class="validity"></span> 
            </td>
            <td>
                <input style="border:hidden; text-align:center" size="4" name="txtMarks<?php echo $rowmark['effortID'] ?>" id="txtMarks<?php echo $rowmark['effortID'] ?>" value="<?php echo $rowmark['marks'] ?>" type="text" readonly />
            </td>
            <td>
                <input style="border:hidden; text-align:center" size="4" name="txtGrade<?php echo $rowmark['effortID'] ?>" id="txtGrade<?php echo $rowmark['effortID'] ?>" value="<?php echo $rowmark['grade'] ?>" type="text" readonly />
            </td>

            <td>
                <input style="border:hidden; text-align:center" size="4" name="txtGradePoint<?php echo $rowmark['effortID'] ?>" id="txtGradePoint<?php echo $rowmark['effortID'] ?>" value="<?php echo $rowmark['gradePoint'] ?>" type="text" readonly/ />
            </td>
        </tr>

        <?php
            }
		}
        ?>
    </table>




    <br /><br />
    <p>
        <input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'examAdmin.php';" class="button" />&nbsp;&nbsp;&nbsp;
        <input name="btnSubmit" type="submit" value="Submit" class="button" />
    </p>
</form>

<script>
	function verifymark(id, idmark1) {
		var val = document.getElementById(id).value;
    	var mark1 = document.getElementById(idmark1).value;
    	
		if (mark1.includes('AB')) {
			if (val.includes('AB')) {
				document.getElementById(id).setCustomValidity("");
			}
			else {
				document.getElementById(id).setCustomValidity("mark1 is mentioned as AB");
    			document.getElementById(id).value = 'AB';
   				document.getElementById(id).setCustomValidity("");
			}
    		document.getElementById(id).style.color = 'blue';
        	return;
		}
    	else if (mark1.includes('MD')) {
            if (val.includes('MD')) {
				document.getElementById(id).setCustomValidity("");
			}
			else {
				document.getElementById(id).setCustomValidity("mark1 is mentioned as MD");
				document.getElementById(id).value = 'MD';
   				document.getElementById(id).setCustomValidity("");
			}
    		document.getElementById(id).style.color = 'blue';
			return;
		}
		if (val <= 100 && val >= 0) {
			document.getElementById(id).style.color = 'black';
    		document.getElementById(id).setCustomValidity("");
		} else {
			console.log("wrong mark");
			document.getElementById(id).value = "";
    		document.getElementById(id).setCustomValidity("Mark should be from 0 to 100");
		}		
	}
</script>

<script>
	function verifydiff(id, idmark1, value) {
		var mark1 = document.getElementById(idmark1).value;
		
		if (mark1 - value > 10 || value - mark1 > 10) {
    		document.getElementById(id).setCustomValidity("higher mark differance");
			//console.log("higher mark differance");
			document.getElementById(id).style.color = 'red';
		}
		else {
    		document.getElementById(id).style.color = 'black';
		}
	}
</script>


<?php
//}else echo "<p>No exam details available.</p>";

//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Enter Results - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='examAdmin.php'>Exam Efforts </a></li><li>Enter Results</li></ul>";
//Apply the template
include("master_sms_external.php");
?>