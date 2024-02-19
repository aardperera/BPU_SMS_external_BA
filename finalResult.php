<?php
//Result Page
//Buffer larger content areas like the main page content
ob_start();
session_start();

if (!isset($_SESSION['authenticatedUser'])) {
    echo $_SESSION['authenticatedUser'];
    header("Location: index.php");
}
								
include('dbAccess.php');
$db = new DBOperations();

$indexNo = "";
$nameEnglish = "";
$nameSinhala = "";

if (isset($_POST['lstIndexNo']))
{
    $indexNo = $_POST['lstIndexNo'];
	if($indexNo!=""){
        $query = "SELECT indexNo,nameEnglish,nameSinhala FROM crs_enroll JOIN student ON crs_enroll.studentID=student.studentID where indexNo = $indexNo";
        $result = $db->executeQuery($query);
        if($row = $db->Next_Record($result)){
            $nameEnglish = $row[1];
            $nameSinhala = $row[2];
        }
    }
}


if (isset($_POST['lstMedium']))
{
    $medium = $_POST['lstMedium'];
}

?>

	


<script type="text/javascript">

function validate(){
	//alert("Please select Student Name");
	var selname = document.getElementById('lstIndexNo').value;
	var selmed = document.getElementById('lstMedium').value;
	
	if(selname == "")
	{
		alert("Please select Student Name");
		return;
	}
	else if (selmed == "")
	{
		alert("Please select Medium");
		return;
	}
}
</script>
<script language="javascript" src="lib/scw/scw.js"></script>



<html>
	<head>
		<title>Result</title>
	</head>
	<body>
		<h1>Exam Results</h1>

		<form name="form2" id="form2" method="post" action="finalResult.php">
			<table class="searchResults">
				<tr>
					<td>Index Number : </td>
					<td width="400px">
						<select name="lstIndexNo" id="lstIndexNo" style="width:auto"  onChange="document.form2.submit()" required>
							<option value=""> Select</option>
        					<?php
							$query = "SELECT indexNo,nameEnglish,nameSinhala FROM crs_enroll JOIN student ON crs_enroll.studentID=student.studentID";
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
                            ?>
        				</select>
						<script>
							document.getElementById('lstIndexNo').value = "<?php if(isset($indexNo)) echo $indexNo;?>";
						</script>
					</td>
				</tr>
			</table>
		</form>

		<form name = "form1" id = "form1" method = "POST" action="resultSheet.php">
		
			<table class="searchResults" style="">
				
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
					<td>Medium : </td>
					<td>
						<select name="lstMedium" id = "lstMedium" required>
							<option value="">Select</option>
        					<option value="English">English</option>
							<option value="Sinhala">Sinhala</option>
						</select>
						<script>
							document.getElementById('lstMedium').value = "<?php if(isset($medium)) echo $medium;?>";
						</script>
					</td>
				</tr>
				<tr>
					<td>
						Result Valid From (Date) :
					</td>
					<td>
						<input type="text" style="width:75px; text-align:center;" id="date" name="date" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*)\./g, '$1');" value=""{{ old('date') }} maxlength="10" required />
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
					<td >
						Exam (Month) :
					</td>
					<td>
						<input type="month" style="width:125px; text-align:center;" id="month" name="month" oninput="this.value = this.value.replace(/[^0-9-]/g, '').replace(/(\..*)\./g, '$1');" maxlength="20" required/>
					</td>
				</tr>
			</table>
			<br/><br/>
			<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'index.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" id = "btnSubmit" type="submit" value="Create" onClick="validate(this)"/></p>

		</form>
	</body>
</html>

<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Academic Transcript - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li>Academic Transcript</li></ul>";
//Apply the template
include("master_sms_external.php");
?>