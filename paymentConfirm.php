<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();

if (!isset($_SESSION['authenticatedUser'])) {
//	echo $_SESSION['authenticatedUser'];
	header("Location: index.php");
}
?>

<?php
    error_reporting(E_ALL & ~E_WARNING);
?>
<script language="javascript">
 	function MsgOkCancel()	{
		var message = "Please confirm to DELETE this entry...";
		var return_value = confirm(message);
		return return_value;
	}
</script>
<script language="javascript" src="lib/scw/scw.js"></script>
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
//$enrollid=array();

//print_r($_POST);

//if (isset($_POST)) {
//    print_r($_POST);
////    echo("button may have been pressed");
//}
if (isset($_POST['btnSubmit'])) {
//echo("button pressed");
//    exit();
	$queryall = "Select * from crs_enroll where  yearEntry='$acyear' and courseID='".$_SESSION['courseId']."'  and subcrsID='$subcrsID' order by regNo";
//    echo $queryall . '<br/>';
//    exit;
	$resultall = $db->executeQuery($queryall);

	while ($row =  $db->Next_Record($resultall))
	{
		$Enrollid = $row['Enroll_id'];

		$queryexist = "Select * from paymentEnroll where enroll_id='$Enrollid'";
		//echo $queryexist . '<br/>';
		$resultexist = $db->executeQuery($queryexist);

		$value = $db->Row_Count($resultexist);
		$date1 = date('Y-m-d', strtotime($_POST['date1'.$Enrollid]));
		$date2 = date('Y-m-d', strtotime($_POST['date2'.$Enrollid]));
        $date3 = date('Y-m-d', strtotime($_POST['date3'.$Enrollid]));

		if($value==0){
			$sqlinsert = "INSERT INTO paymentEnroll (enroll_id, payment1, payment2, payment3, amount1, amount2, amount3, date1, date2,  date3 ) VALUES ($Enrollid, ";
            if ( isset( $_POST[ 'checkBox1' . $Enrollid] ) )    { $sqlinsert = $sqlinsert . "1, "; }
            else                                                { $sqlinsert = $sqlinsert . "0, "; }
            if ( isset( $_POST[ 'checkBox2' . $Enrollid] ) )    { $sqlinsert = $sqlinsert . "1, "; }
            else                                                { $sqlinsert = $sqlinsert . "0, "; }
            if ( isset( $_POST[ 'checkBox3' . $Enrollid] ) )    { $sqlinsert = $sqlinsert . "1, "; }
            else                                                { $sqlinsert = $sqlinsert . "0, "; }

            $sqlinsert = $sqlinsert . "'" . $_POST[ 'amount1' . $Enrollid] . "', ";
            $sqlinsert = $sqlinsert . "'" . $_POST[ 'amount2' . $Enrollid] . "', ";
            $sqlinsert = $sqlinsert . "'" . $_POST[ 'amount3' . $Enrollid] . "', ";

            $sqlinsert = $sqlinsert . "'" . $_POST[ 'date1' . $Enrollid] . "', ";
            $sqlinsert = $sqlinsert . "'" . $_POST[ 'date2' . $Enrollid] . "', ";
            $sqlinsert = $sqlinsert . "'" . $_POST[ 'date3' . $Enrollid] . "');";

            //echo $sqlinsert . "<br/>" ;
            $resultinsert = $db->executeQuery($sqlinsert);
		}
		else{
			$sqlupdate = "UPDATE paymentEnroll SET ";
			//	$resultinsert = $db->executeQuery("UPDATE paymentEnroll SET payment1='1', pay1date = '$date1', payment2='1', pay2date = '$date2' where enroll_id='$Enrollid'");
			if ( isset( $_POST[ 'checkBox1' . $Enrollid] ) )    { $sqlupdate = $sqlupdate . "payment1=1, "; }
            else                                                { $sqlupdate = $sqlupdate . "payment1=0, "; }
            if ( isset( $_POST[ 'checkBox2' . $Enrollid] ) )    { $sqlupdate = $sqlupdate . "payment2=1, "; }
            else                                                { $sqlupdate = $sqlupdate . "payment2=0, "; }
            if ( isset( $_POST[ 'checkBox3' . $Enrollid] ) )    { $sqlupdate = $sqlupdate . "payment3=1, "; }
            else                                                { $sqlupdate = $sqlupdate . "payment3=0, "; }

            $sqlupdate = $sqlupdate . "amount1 = '" . $_POST[ 'amount1' . $Enrollid] . "', ";
            $sqlupdate = $sqlupdate . "amount2 = '" . $_POST[ 'amount2' . $Enrollid] . "', ";
            $sqlupdate = $sqlupdate . "amount3 = '" . $_POST[ 'amount3' . $Enrollid] . "', ";


            $sqlupdate = $sqlupdate . "date1 = '" . $_POST[ 'date1' . $Enrollid] . "', ";
            $sqlupdate = $sqlupdate . "date2 = '" . $_POST[ 'date2' . $Enrollid] . "', ";
            $sqlupdate = $sqlupdate . "date3 = '" . $_POST[ 'date3' . $Enrollid] . "' ";


            $sqlupdate = $sqlupdate . "where enroll_id='$Enrollid'";
		    //echo $sqlupdate . "<br/>" ;
            $resultinsert = $db->executeQuery($sqlupdate);
        }
	}
}



//$query = $_SESSION['query'];

?>
<h1>Enter Payment Details</h1>
<br />

<form method="post" action="" name="form1" id="form1" class="plain">
    <br />
    <table width="230" class="searchResults">
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
						echo '<option value="'.$row['yearEntry'].'"> ' . $row['yearEntry'] . ' </option>';
					}
					echo '</select>';// Close drop down box
                    ?>

                    <script>
								document.getElementById('acyear').value = "<?php if(isset($acyear)) echo $acyear;?>";
                    </script>
                </label>
            </td>

        </tr>
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
						$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
						$result = $db->executeQuery($sql);
						//echo '<option value="all">Select All</option>';

						while ($row =  $db->Next_Record($result)){
							echo '<option value="'.$row['id'].'">'.$row['description'].'</option>';
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


    </table>





    <table class="searchResults">
        <tr>
            <th rowspan="2">Registration No.</th>
            <th colspan="3">First</th>
            <th colspan="3">Second</th>
            <th colspan="3">Third</th>
            <th rowspan="2">Total Payment</th>
        </tr>
        <tr>
            <th>Payment</th>
            <th>Amount</th>
            <th>Date</th>
			<th>Payment </th>
            <th>Amount</th>
			<th>Date</th>
			<th>Payment</th>
            <th>Amount</th>
			<th>Date</th>
        </tr>

        <?php
		$queryall = "Select * from crs_enroll where  yearEntry='$acyear' and courseID='".$_SESSION['courseId']."'  and subcrsID='$subcrsID' order by regNo";

		$resultall = $db->executeQuery($queryall);

        $tamount1 = 0;
        $tamount2 = 0;
        $tamount3 = 0;

		//print 'll';
		//			print $query12;
		//$result12 = $db->executeQuery($query12);
		//$row12=  $db->Next_Record($result12);
		while ($row=  $db->Next_Record($resultall))
		{
			$indexNo=$row['indexNo'];
			//$query12 = "Select regNo from exameffort where subjectID='$SubjectID' and indexNo=$indexNo 	and acYear='$acyear'";
			//print $query12;
			//$result12 = $db->executeQuery($query12);
			// $row12=  $db->Next_Record($result12);
        ?>
        <tr>
            <td align="center">
                <?php echo $row['regNo'] ?>
            </td>

         <?php
			$Enrollid = $row[ 'Enroll_id' ];
			$queryexist = "Select * from paymentEnroll where enroll_id='$Enrollid'";

			$resultexist = $db->executeQuery($queryexist);

			$value= $db->Row_Count($resultexist);
			$row = $db->Next_Record($resultexist);

		?>
            <td>
                <center>
                    <input type='checkBox' name="checkBox1<?php echo $Enrollid ?>" id="checkBox1<?php echo $Enrollid ?>" value="checkBox1<?php echo $Enrollid ?>" <?php if($row[1]==1) echo 'checked'?> />
                </center>
            </td>
            <td>
                <center>
                    <input type="text" style="width:50px; text-align:center;" name="amount1<?php echo $Enrollid ?>" id="amount1<?php echo $Enrollid ?>" value="<?php $tamount1 += $row[4]; echo $row[4]; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); payment('amount1<?php echo $Enrollid ?>', 'amount2<?php echo $Enrollid ?>', 'amount3<?php echo $Enrollid ?>' , 'amount<?php echo $Enrollid ?>' );" maxlength="6" />
                </center>
            </td>
			<td>
                <input type="text" style="width:75px; text-align:center;" id="date1<?php echo $Enrollid ?>" name="date1<?php echo $Enrollid ?>" value="<?php if($row[7] != "1970-01-01" && $row[7] && $row[7] != "0000-00-00") echo $row[7]; ?>" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" />

			</td>
            <td>
                <center>
                    <input type='checkBox' name="checkBox2<?php echo $Enrollid ?>" id="checkBox2<?php echo $Enrollid ?>" value="checkBox1<?php echo $row[0] ?>" <?php if($row[2]==1) echo 'checked'?> />
                </center>
            </td>
            <td>
                <center>
                    <input type="text" style="width:50px; text-align:center;" name="amount2<?php echo $Enrollid ?>" id="amount2<?php echo $Enrollid ?>" value="<?php $tamount2 += $row[5]; echo $row[5]; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); payment('amount1<?php echo $Enrollid ?>', 'amount2<?php echo $Enrollid ?>', 'amount3<?php echo $Enrollid ?>' , 'amount<?php echo $Enrollid ?>' );" maxlength="6" />
                </center>
            </td>
            <td>
                <input type="text" style="width:75px; text-align:center;" id="date2<?php echo $Enrollid ?>" name="date2<?php echo $Enrollid ?>" value="<?php if($row[8] != "1970-01-01" && $row[8] && $row[8] != "0000-00-00") echo $row[8]; ?>" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" />

            </td>
            <td>
                <center>
                    <input type='checkBox' name="checkBox3<?php echo $Enrollid ?>" id="checkBox3<?php echo $Enrollid ?>" value="checkBox1<?php echo $row[0] ?>" <?php if($row[3]==1) echo 'checked'?> />
                </center>
            </td>
            <td>
                <center>
                    <input type="text" name="amount3<?php echo $Enrollid ?>" id="amount3<?php echo $Enrollid ?>" style="width:50px; text-align:center;" value="<?php $tamount3 += $row[6]; echo $row[6]; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); payment('amount1<?php echo $Enrollid ?>', 'amount2<?php echo $Enrollid ?>', 'amount3<?php echo $Enrollid ?>' , 'amount<?php echo $Enrollid ?>' );" maxlength="6" />
                </center>
            </td>
            <td>
                <input type="text" style="width:75px; text-align:center;" id="date3<?php echo $Enrollid ?>" name="date3<?php echo $Enrollid ?>" value="<?php if($row[9] != "1970-01-01" && $row[9] && $row[9] != "0000-00-00") echo $row[9]; ?>" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*)\./g, '$1');" maxlength="10" />
            </td>
            <td>
                <center>
                    <input type="text" name="amount<?php echo $Enrollid ?>" id="amount<?php echo $Enrollid ?>" style="width:60px; text-align:center; border:hidden;" value="<?php echo $row[4] + $row[5] + $row[6]; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="7" readonly />
                </center>
            </td>

        </tr>

        <?php
		}
        ?>
        <tr>
            <th>
                Total
            </th>
            <td colspan="3">
                <center>
                    <?php echo $tamount1; ?>
                </center>
            </td>
            <td colspan="3">
                <center>
                    <?php echo $tamount2; ?>
                </center>
            </td>
            <td colspan="3">
                <center>
                    <?php echo $tamount3; ?>
                </center>
            </td>
            <td>
                <center>
                    <?php echo $tamount1 + $tamount2 + $tamount3; ?>
                </center>
            </td>
        </tr>
    </table>
    
    <br /><br />
    <p>
        <input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'index.php';" class="button" />&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" />
    </p>
</form>

<script>
			function Function(item,value){
				var string = ""; string = value;
				document.getElementById(item).value = string;
				document.getElementById(item).innerHTML = value;
				//alert("item : " + item + ", value : " + value);
            }
</script>

<script>
    function payment(id1, id2, id3, id) {
        amount1 = parseInt(document.getElementById(id1).value);
        amount2 = parseInt(document.getElementById(id2).value);
        amount3 = parseInt(document.getElementById(id3).value);

        total = 0;
        if (!isNaN(amount1)) total += amount1;
        if (!isNaN(amount2)) total += amount2;
        if (!isNaN(amount3)) total += amount3;

        document.getElementById(id).value = total;
	}
</script>

<?php
//}else echo "<p>No exam details available.</p>";

//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Enter Results - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='index.php'>Enrollment Related </a></li><li>Course Payments</li></ul>";
//Apply the template
include("master_sms_external.php");
?>