<?php
  //Buffer larger content areas like the main page content
  ob_start();
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
		$indexNo = $_POST['lstIndexNo'];
		$medium = $_POST['lstMedium'];
		$withMarks = $_POST['chkMarks'];
		if ($medium=='English')
			header("location:rptTranscriptE.php?indexNo=$indexNo&withMarks=$withMarks");
		else if ($medium=='Sinhala')
			header("location:rptTranscriptS.php?indexNo=$indexNo&withMarks=$withMarks");
	}
?>
<form method="post" action="" onsubmit="return validate_form(this);" class="plain">
<table class="searchResults">
	<tr>
    	<td>Index Number : </td>
        <td><select name="lstIndexNo" id="lstIndexNo" style="width:auto" >
        	<?php
			$query = "SELECT indexNo,nameEnglish FROM crs_enroll JOIN student ON crs_enroll.studentID=student.studentID";
			$result = $db->executeQuery($query);
			for ($i=0;$i<$db->Row_Count($result);$i++)
			{
				$rIndexNo = mysql_result($result,$i,"indexNo");
				$rNameEnglish = mysql_result($result,$i,"nameEnglish");
				if (isset($_POST['lstIndexNo']) && $rIndexNo==$_POST['lstIndexNo'])
					echo "<option selected='selected' onmousedown=\"document.getElementById('txtName').value='(".$rNameEnglish.")'\" value=\"".$rIndexNo."\">".$rIndexNo."</option>";
				else
              		echo "<option onmousedown=\"document.getElementById('txtName').value='(".$rNameEnglish.")'\" value=\"".$rIndexNo."\">".$rIndexNo."</option>";
        	} 
			?>
        	</select>
            <input name="txtName" id="txtName" type="text" value="<?php if (isset($_POST['txtName'])) echo $_POST['txtName']; ?>" readonly="readonly" style="border:none;width:300px" />
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
    	<td colspan="2"><input name="chkMarks" type="checkbox" /> With marks</td>
    </tr>
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'home.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Create" class="button" /></p>
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