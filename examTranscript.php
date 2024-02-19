<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();

if (!isset($_SESSION['authenticatedUser'])) {
	echo $_SESSION['authenticatedUser'];
	header("Location: index.php");
}
?>

<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtAcYear))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
</script>

<h1>Academic Transcript</h1>
<?php
include('dbAccess.php');

$db = new DBOperations();

if (isset($_POST['btnSubmit']))
{
    $indexNo = $_POST['indexNo'];
    $medium = $_POST['lstMedium'];
    $registrar = $_POST['registrar'];
    $withMarks = $_POST['chkMarks'];
    if ($medium=='English')
        header("location:rptTranscriptE.php?indexNo=$indexNo&withMarks=$withMarks&registrar=$registrar");
    else if ($medium=='Sinhala')
        header("location:rptTranscriptS.php?indexNo=$indexNo&withMarks=$withMarks&registrar=$registrar");
}

if (isset($_POST['lstIndexNo']))
{
    $indexNo = $_POST['lstIndexNo'];
	if($indexNo!=""){
        $query = "SELECT indexNo,nameEnglish,nameSinhala FROM crs_enroll JOIN student ON crs_enroll.studentID=student.studentID where indexNo = '".$indexNo."'";
        $result = $db->executeQuery($query);
        if($row = $db->Next_Record($result)){
            $nameEnglish = $row[1];
            $nameSinhala = $row[2];
        }
    }
}

if (isset($_POST['acyear']))
{
	$acyear=$_POST['acyear'];
}

?>

<form name="form2" id="form2" method="post" action="examTranscript.php">
			<table class="searchResults">
				<tr>
					<td>Academic Year: </td>
            <td>
                <label>
                    <?php

					echo '<select name="acyear" id="acyear"  onChange="document.form2.submit()" class="form-control">'; // Open your drop down box

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
					<td>Index Number : </td>
					<td width="400px">
						<select name="lstIndexNo" id="lstIndexNo" style="width:auto"  onChange="document.form2.submit()" required>
							<option value=""> Select</option>
        					<?php
							if(isset($acyear)){
								//$courseID = $_SESSION['courseId']; 
                                $query = "SELECT indexNo,nameEnglish,nameSinhala FROM crs_enroll JOIN student ON crs_enroll.studentID=student.studentID WHERE crs_enroll.courseID = '".$_SESSION['courseId']."' AND yearEntry = $acyear";
                                $result = $db->executeQuery($query);
                                while ($row = $db->Next_Record($result))
                                {
                                    $rIndexNo = $row['indexNo'];
                                    $rNameEnglish = $row['nameEnglish'];
                                    $rNameSinhala = $row['nameSinhala'];
                                    if (isset($_POST['lstIndexNo']) && $rIndexNo==$_POST['lstIndexNo'])
                                        echo "<option selected='selected' onmouseup=\"document.getElementById('txtEName').value='".$rNameEnglish."'\" value=\"".$rIndexNo."\">".$rIndexNo."</option>";
                                    else
                                        echo "<option onmouseup=\"document.getElementById('txtEName').value='".$rNameEnglish."';\" value=\"".$rIndexNo."\">".$rIndexNo."</option>";
                                }
                            } 
                            ?>
        				</select>
						<script>
							document.getElementById('lstIndexNo').value = "<?php if(isset($indexNo)) echo $indexNo;?>";
						</script>
					</td>
				</tr>
			</table>
		</form>

<form method="post" action="" onsubmit="return validate_form(this);" class="plain">
<table class="searchResults">
	<tr>
					<td>
						<label>Name in English :</label>
						<input id="indexNo" name="indexNo" type="text" value="" hidden/>
						<script>
							document.getElementById('indexNo').value = "<?php echo $indexNo;?>";
						</script>
					</td>
					<td>
						<input id="txtEName" name="txtEName" type="text" value="" style="width:425px; border:none;" required/>
						<script>
							document.getElementById('txtEName').value = "<?php echo $nameEnglish;?>";
						</script>
		   		    </td>
				</tr>
	<tr>
					<td>
						<label>Name in Sinhala :</label>
					</td>
					<td>
						<input id="txtSName" name="txtSName" type="text" value="" style="width:425px; border:none;"/>
						<script>
							document.getElementById('txtSName').value = "<?php echo $nameSinhala;?>";
						</script>
					</td>
				</tr>
    <tr>
    	<td>Medium : </td><td><select name="lstMedium">
        		<option value="English">English</option>
            	<option value="Sinhala">Sinhala</option>
            </select>
       	</td>
    </tr>
    <tr>
		<td >
			Deputy Registrar (Name) :
		</td>
		<td>
			<input type="text" style ="width:375px; height:50px; text-align:center;" id="registrar" name="registrar" maxlength="150" required/>
		</td>
	</tr>
    <tr>
    	<td colspan="2"><input name="chkMarks" type="checkbox" /> With marks</td>
    </tr>
</table>
<br/><br/>
<p>
	<input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'home.php';"  class="button"/>
	&nbsp;&nbsp;&nbsp;
	<input name="btnSubmit" type="submit" value="Create" class="button" /></p>
</form>

<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Academic Transcript - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li>Academic Transcript</li></ul>";
//Apply the template
include("master_sms_external.php");
?>