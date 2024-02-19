<?php
  //Buffer larger content areas like the main page content
  ob_start();
   session_start();
?>

<script language="javascript" src="lib/scw/scw.js"></script>
<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtStudentID) || !validate_required(txtNameEnglish))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
</script>

<h1>New Student</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	if (isset($_POST['btnSubmit']))
	{
		$studentID = $db->cleanInput($_POST['txtStudentID']);
		$nic = $db->cleanInput($_POST['txtNic']);
		$title = $_POST['lstTitle'];
		$nameEnglish = $db->cleanInput($_POST['txtNameEnglish']);
		$nameSinhala = $db->cleanInput($_POST['txtNameSinhala']);
		$addressE1 = $db->cleanInput($_POST['txtAddressE1']);
		$addressE2 = $db->cleanInput($_POST['txtAddressE2']);
		$addressE3 = $db->cleanInput($_POST['txtAddressE3']);
		$addressS1 = $db->cleanInput($_POST['txtAddressS1']);
		$addressS2 = $db->cleanInput($_POST['txtAddressS2']);
		$addressS3 = $db->cleanInput($_POST['txtAddressS3']);
		$contactNo = $db->cleanInput($_POST['txtContactNo']);
		$email = $db->cleanInput($_POST['txtEmail']);
		$birthday = $db->cleanInput($_POST['txtBirthday']);
		$citizenship = $db->cleanInput($_POST['txtCitizenship']);
		$civilStatus=$_POST['txtCivilStatus'];
		$employment = $db->cleanInput($_POST['txtEmployment']);
		$employer = $db->cleanInput($_POST['txtEmployer']);
		
		//Details of Qualification
		$ol=$_POST['txtol'];
		$al=$_POST['txtal'];
		$diploma=$_POST['txtdiploma'];
		$higher_Diploma=$_POST['txthigher_Diploma'];
		$First_Degree=$_POST['txtFirst_Degree'];
		$Post_One_Year=$_POST['txtPost_One_Year'];
		$Post_Two_Year=$_POST['txtPost_Two_Year'];
		$others=$_POST['txtothers'];
		$courseID=$_POST['courseID'];
			
		print $_SESSION['courseID'] ;
	
		
		
		$query = "INSERT INTO student SET studentID='$studentID', nic='$nic', title='$title', nameEnglish='$nameEnglish', nameSinhala='$nameSinhala', addressE1='$addressE1', addressE2='$addressE2', addressE3='$addressE3', addressS1='$addressS1', addressS2='$addressS2', addressS3='$addressS3', contactNo='$contactNo', email='$email', birthday='$birthday', citizenship='$citizenship',civilStatus='$civilStatus', employment='$employment', employer='$employer',courseID='".$_SESSION['courseId']."'";
		//$query = "INSERT INTO student SET studentID='$studentID', nic='$nic', title='$title', nameEnglish='$nameEnglish', nameSinhala='$nameSinhala', addressE1='$addressE1', addressE2='$addressE2', addressE3='$addressE3', addressS1='$addressS1', addressS2='$addressS2', addressS3='$addressS3', contactNo='$contactNo', email='$email', birthday='$birthday', citizenship='$citizenship',civilStatus='$civilStatus', employment='$employment', employer='$employer'";
		$result = $db->executeQuery($query);
		header("location:studentAdmin.php");
		
		
		$query1 = "INSERT INTO stu_qualification SET studentID='$studentID',OL='$ol',AL='$al',Diploma='$diploma',HigherDiploma='$higher_Diploma',FirsDegree='$First_Degree',Post_OneYear='$Post_One_Year',Post_TwoYears='$Post_Two_Year',Others='$others'";
		$result = $db->executeQuery($query1);
		
	}
?>
<form method="post" action="" onsubmit="return validate_form(this);" class="plain">
  <table class="searchResults">
    <tr> 
      <td>Student ID : </td>
      <td><input name="txtStudentID" type="text" value="" /></td>
    </tr>
    <tr>
      <td>NIC No. : </td>
      <td><input name="txtNic" type="text" value="" maxlength="10" /></td>
    </tr>
    <tr> 
      <td>Title : </td>
      <td><select name="lstTitle">
          <option value="Ven.">Ven.</option>
          <option value="Prof.">Prof.</option>
          <option value="Dr.">Dr.</option>
          <option value="Mr.">Mr.</option>
          <option value="Mrs.">Mrs.</option>
          <option value="Miss.">Miss.</option>
        </select></td>
    </tr>
    <tr> 
      <td>Name (English) : </td>
      <td><input name="txtNameEnglish" type="text" value="" style="width:300px"/></td>
    </tr>
    <tr> 
      <td>Name (Sinhala) : </td>
      <td><input name="txtNameSinhala" type="text" value="" style="width:300px"/></td>
    </tr>
    <tr> 
      <td valign="top">Address (English) : </td>
      <td><input name="txtAddressE1" type="text" value="" />
        <br/>
        <input name="txtAddressE2" type="text" value="" style="width:300px"/>
        <br/>
        <input name="txtAddressE3" type="text" value="" style="width:300px"/></td>
    </tr>
    <tr> 
      <td valign="top">Address (Sinhala) : </td>
      <td><input name="txtAddressS1" type="text" value="" />
        <br/>
        <input name="txtAddressS2" type="text" value="" style="width:300px"/>
        <br/>
        <input name="txtAddressS3" type="text" value="" style="width:300px"/></td>
    </tr>
    <tr> 
      <td>Contact No. : </td>
      <td><input name="txtContactNo" type="text" value="" /></td>
    </tr>
    <tr> 
      <td>Email : </td>
      <td><input name="txtEmail" type="text" value="" /></td>
    </tr>
    <tr> 
      <td>Birthday : </td>
      <td><input name="txtBirthday" type="text" value="" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" /></td>
    </tr>
    <tr> 
      <td>Citizenship : </td>
      <td><input name="txtCitizenship" type="text" value="" /></td>
    </tr>
    <tr> 
      <td>Civil Status : </td>
      <td>
	<ol>
		<li>Married&ensp;&ensp;&ensp;&ensp;&ensp;<input name="txtCivilStatus" type="radio" value="Married"></li>
		<li>Unmarried&ensp;&ensp;<input name="txtCivilStatus" type="radio" value="Unmarried"></li>
	</ol>  

	  </td>
	</tr>
    <tr> 
      <td>Employment : </td>
      <td><input name="txtEmployment" type="text" value="" /></td>
    </tr>
    <tr> 
      <td>Employer : </td>
      <td><input name="txtEmployer" type="text" value="" /></td>
    </tr>
	
    <tr> 
      <td>Qualification : </td>
      <td>
	  <table border="0">
		<tr>
		<td>1.</td><td>O/L</td> <td><input name="txtol" type="checkbox" value="YES" /> </td>
		</tr>
		<tr>
		<td>2.</td><td>A/L</td> <td><input name="txtal" type="checkbox" value="YES" /> </td>
		</tr>
		<tr>
		<td>3.</td><td>Diploma</td> <td><input name="txtdiploma" type="checkbox" value="YES" /> </td>
		</tr>
		<tr>
		<td>4.</td><td>Higher Diploma</td> <td><input name="txthigher_Diploma" type="checkbox" value="YES" /> </td>
		</tr>
		<tr>
		<td>5.</td><td>First Degree</td> <td><input name="txtFirst_Degree" type="checkbox" value="YES" /> </td>
		</tr>
		<tr>
		<td>6.</td><td>Postgraduate</td> <td> </td>
		</tr>
		<tr>
		<td> </td><td>One Year </td> <td><input name="txtPost_One_Year" type="checkbox" value="YES" /></td>
		</tr>
		<tr>
		<td> </td><td>Two Years</td> <td><input name="txtPost_Two_Year" type="checkbox" value="YES" /></td>
		</tr>
		<tr>
		<td>7.</td>
		<td>Others : </td><td><input type="checkbox" id="myCheck"  onclick="myFunction()"></td>
		</tr>
		</td>
		</tr>
	  </table>
	  
			<p id="text" style="display:none" >
			<textarea rows="4" cols="50" name="txtothers" type="text" value="">

			</textarea>

			</p>

			<script>
			function myFunction() {
				var checkBox = document.getElementById("myCheck");
				var text = document.getElementById("text");
				if (checkBox.checked == true){
					text.style.display = "block";
				} else {
				   text.style.display = "none";
				}
			}
			</script>
		
	
  </table>
 
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'studentAdmin.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" /></p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "New Student - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>New Student</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>