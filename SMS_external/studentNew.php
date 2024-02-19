<?php
  //Buffer larger content areas like the main page content
  ob_start();
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
		$nationality = $db->cleanInput($_POST['txtNationality']);
		$religion = $db->cleanInput($_POST['txtReligion']);
		$civilStatus = $db->cleanInput($_POST['txtCivilStatus']);
		$employment = $db->cleanInput($_POST['txtEmployment']);
		$employer = $db->cleanInput($_POST['txtEmployer']);
		$guardName = $db->cleanInput($_POST['txtGuardName']);
		$guardAddress = $db->cleanInput($_POST['txtGuardAddress']);
		$guardContactNo = $db->cleanInput($_POST['txtGuardContactNo']);
		
		$query = "INSERT INTO student SET studentID='$studentID', nic='$nic', title='$title', nameEnglish='$nameEnglish', nameSinhala='$nameSinhala', addressE1='$addressE1', addressE2='$addressE2', addressE3='$addressE3', addressS1='$addressS1', addressS2='$addressS2', addressS3='$addressS3', contactNo='$contactNo', email='$email', birthday='$birthday', citizenship='$citizenship', nationality='$nationality', religion='$religion', civilStatus='$civilStatus', employment='$employment', employer='$employer', guardName='$guardName', guardAddress='$guardAddress', guardContactNo='$guardContactNo'";
		$result = $db->executeQuery($query);
		header("location:studentAdmin.php");
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
      <td>Nationality : </td>
      <td><input name="txtNationality" type="text" value="" /></td>
    </tr>
    <tr> 
      <td>Religion : </td>
      <td><input name="txtReligion" type="text" value="" /></td>
    </tr>
    <tr> 
      <td>Civil Status : </td>
      <td><input name="txtCivilStatus" type="text" value="" /></td>
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
      <td>Gurdian Name : </td>
      <td><input name="txtGuardName" type="text" value="" /></td>
    </tr>
    <tr> 
      <td>Gurdian Address : </td>
      <td><input name="txtGuardAddress" type="text" value="" /></td>
    </tr>
    <tr> 
      <td>Gurdian Contact No. : </td>
      <td><input name="txtGuardContactNo" type="text" value="" /></td>
    </tr>
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