<?php
//Result Page
//Buffer larger content areas like the main page content
ob_start();
$rNameSinhala = "";
?>

<script type="text/javascript">
function medium_check()
{
	//alert(test);
	var select = document.getElementById('lstMedium');
	if(select.value == "English")
	{
		document.getElementById('medName').value  = "English";
	}
	else if(select.value == "Sinhala")
	{
		document.getElementById('medName').value  = "Sinhala";
	}
	else
	{
		document.getElementById('medName').value  = "Select Medium";
	}
	
}

function int_check()
{
	var intselect = document.getElementById('lstIndexNo');
	if(intselect.value == "sel")
	{
		document.getElementById('txtEName').value  = "Select Intdex No";
	}
}

function validate(){
	//alert("Please select Student Name");
	var selname = document.getElementById('lstIndexNo').value;
	var selmed = document.getElementById('lstMedium').value;
	
	if(selname == "sel")
	{
		alert("Please select Student Name");
			return false;
	}
	else{
		if(selmed == "")
		{
			alert("Please select Medium");
			return false;
		}
		else{
			document.form119.submit();
		}
	}
}
</script>


<?php
include('dbAccess.php');

$db = new DBOperations();
?>

<html>
	<head>
		<title>Result</title>
	</head>
	<body>
		<h1>Exam Results</h1>

		<form name = "form119" id = "form119" method = "POST" action = "resultSheet.php">
		
			<table class="searchResults">
			<tr>
				<td>Index Number : </td>
				<td>
					                                                                                            <select name="lstIndexNo" id="lstIndexNo" style="width:auto" onchange = "int_check(this)">
				<option value="sel"> Select</option>
        		<?php
				$query = "SELECT indexNo,nameEnglish,nameSinhala FROM crs_enroll JOIN student ON crs_enroll.studentID=student.studentID";
				$result = $db->executeQuery($query);
				while ($row = $db->Next_Record($result))
				{
					$rIndexNo = $row['indexNo'];
					$rNameEnglish = $row['nameEnglish'];
					$rNameSinhala = $row['nameSinhala'];
					if (isset($_POST['lstIndexNo']) && $rIndexNo==$_POST['lstIndexNo'])
						echo "<option selected='selected' onmousedown=\"document.getElementById('txtEName').value='".$rNameEnglish."'\" value=\"".$rIndexNo."\">".$rIndexNo."</option>";
					else
				        echo "<option onmousedown=\"document.getElementById('txtEName').value='".$rNameEnglish."'\" value=\"".$rIndexNo."\">".$rIndexNo."</option>";
        		} 
				?>
        		</select>
				<input name="txtEName" id="txtEName" type="text" value="" readonly="readonly" style="border:none;width:300px" />
				<input name="txtSName" id="txtSName" type="hidden" value="<?php echo $rNameSinhala; ?>" readonly="readonly" style="border:none;width:300px" />
				</td>
			</tr>
			<tr>
				<td>Medium : </td>
				<td>
					<select name="lstMedium" id = "lstMedium" onchange = "medium_check(this)">
						<option value=""> Select</option>
        				<option value="English">English</option>
						<option value="Sinhala">Sinhala</option>
					</select>
					<input name="medName" id="medName" type="text" value="" readonly="readonly" style="border:none;width:300px" />
				</td>
			</tr>
			</table>
			<br/><br/>
			<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'index.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" id = "btnSubmit" type="button" value="Create" onClick="validate(this)"/></p>

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