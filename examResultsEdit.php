<?php
  //Buffer larger content areas like the main page content
  ob_start();
    session_start();
  
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
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

<h1>Student Edit</h1>
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
		
			//Details of Qualification
		$ol=$_POST['txtol'];
		$al=$_POST['txtal'];
		$diploma=$_POST['txtdiploma'];
		$higher_Diploma=$_POST['txthigher_Diploma'];
		$First_Degree=$_POST['txtFirst_Degree'];
		$Post_One_Year=$_POST['txtPost_One_Year'];
		$Post_Two_Year=$_POST['txtPost_Two_Year'];
		$others=$_POST['txtothers'];
		
		$query = "UPDATE student SET nic='$nic', title='$title',civilStatus='$civilStatus' ,nameEnglish='$nameEnglish', nameSinhala='$nameSinhala', addressE1='$addressE1', addressE2='$addressE2', addressE3='$addressE3', addressS1='$addressS1', addressS2='$addressS2', addressS3='$addressS3', contactNo='$contactNo', email='$email', birthday='$birthday', citizenship='$citizenship', nationality='$nationality', religion='$religion', civilStatus='$civilStatus', employment='$employment', employer='$employer', guardName='$guardName', guardAddress='$guardAddress', guardContactNo='$guardContactNo' WHERE studentID='$studentID'";
		$result = $db->executeQuery($query);
		
		$query1 = "UPDATE stu_qualification SET OL='$ol',AL='$al',Diploma='$diploma',HigherDiploma='$higher_Diploma',FirsDegree='$First_Degree',Post_OneYear='$Post_One_Year',Post_TwoYears='$Post_Two_Year',Others='$others' where studentID='$studentID'";
		$result1 = $db->executeQuery($query1);
		
		header("location:studentAdmin.php");
	}
	
	$studentID = $db->cleanInput($_GET['studentID']);
	$query = "SELECT * FROM student WHERE studentID='$studentID'";
	//=======

	  
	  //=====================================
	  $queryqua = "SELECT * FROM  stu_qualification WHERE studentID='$studentID'";
	$resultqua = $db->executeQuery($queryqua);
	
	$rowqua=  $db->Next_Record($resultqua);
	  
	  
	  
	  
	  
	  
	 
	
	//=====
	
	$result = $db->executeQuery($query);
	
	$row =  $db->Next_Record($result);
	if ($db->Row_Count($result)>0)
	{
?>
<form method="post" action="studentEdit.php?studentID=<?php echo $studentID; ?>" onsubmit="return validate_form(this);" class="plain">
  <table class="searchResults">
    <tr> 
      <td>StudentID : </td>
      <td><input name="txtStudentID" type="text" id="txtStudentID" value="<?php echo $row['studentID']; ?>" readonly /></td>
    </tr>
    <tr>
      <td>NIC No. :</td>
      <td><input name="txtNic" type="text" id="txtNic" value="<?php echo $row['nic']; ?>" /></td>
    </tr>
    <tr> 
      <td>Title : </td>
      <td><select name="lstTitle">
          <option <?php if ($row['title']=='Ven.') echo "selected='selected'"; ?> value="Ven.">Ven.</option>
          <option <?php if ($row['title']=='Prof.') echo "selected='selected'"; ?> value="Prof.">Prof.</option>
          <option <?php if ($row['title']=='Dr.') echo "selected='selected'"; ?> value="Dr.">Dr.</option>
          <option <?php if ($row['title']=='Mr.') echo "selected='selected'"; ?> value="Mr.">Mr.</option>
          <option <?php if ($row['title']=='Mrs.') echo "selected='selected'"; ?> value="Mrs.">Mrs.</option>
          <option <?php if ($row['title']=='Miss.') echo "selected='selected'"; ?> value="Miss.">Miss.</option>
        </select>
	</td>
    </tr>
    <tr> 
      <td>Name (English) : </td>
      <td><input name="txtNameEnglish" type="text" value="<?php echo $row['nameEnglish'] ?>" style="width:300px"/></td>
    </tr>
    <tr> 
      <td>Name (Sinhala) : </td>
      <td><input name="txtNameSinhala" type="text" value="<?php echo $row['nameSinhala'] ?>" style="width:300px"/></td>
    </tr>
    <tr> 
      <td valign="top">Address (English) : </td>
      <td><input name="txtAddressE1" type="text" value="<?php echo $row['addressE1'] ?>" />
        <br/>
        <input name="txtAddressE2" type="text" value="<?php echo $row['addressE2'] ?>" style="width:300px"/>
        <br/>
        <input name="txtAddressE3" type="text" value="<?php echo $row['addressE3'] ?>" style="width:300px"/></td>
    </tr>
    <tr> 
      <td valign="top">Address (Sinhala) : </td>
      <td><input name="txtAddressS1" type="text" value="<?php echo $row['addressS1'] ?>" />
        <br/>
        <input name="txtAddressS2" type="text" value="<?php echo $row['addressS2'] ?>" style="width:300px"/>
        <br/>
        <input name="txtAddressS3" type="text" value="<?php echo $row['addressS3'] ?>" style="width:300px"/></td>
    </tr>
    <tr> 
      <td>Contact No. : </td>
      <td><input name="txtContactNo" type="text" value="<?php echo $row['contactNo'] ?>" /></td>
    </tr>
    <tr> 
      <td>Email : </td>
      <td><input name="txtEmail" type="text" value="<?php echo $row['email'] ?>" /></td>
    </tr>
    <tr> 
      <td>Birthday : </td>
      <td><input name="txtBirthday" type="text" value="<?php echo $row['birthday'] ?>" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" /></td>
    </tr>
    <tr> 
      <td>Citizenship : </td>
      <td><input name="txtCitizenship" type="text" value="<?php echo $row['citizenship'] ?>" /></td>
    </tr>
    
    <tr> 
      <td>Civil Status : </td>
      <td>
	<ol>
		<li>Married&ensp;&ensp;&ensp;&ensp;&ensp;
		<input name="txtCivilStatus" type="radio" value="Married" <?php if($row['civilStatus']=="Married"){ echo "checked";}?>/></li>
		<li>Unmarried&ensp;&ensp;
		<input name="txtCivilStatus" type="radio" value="Unmarried" <?php if($row['civilStatus']=="Unmarried"){ echo "checked";}?>/></li>
	</ol>  

	<!--
	
<td><input type="radio" name="txtCivilStatus" value="Married" id="Married" <? if($txtCivilStatus=='Married') {?> checked="" <? }?>/>Married
<input type="radio" name="txtCivilStatus" value="Unmarried" id="Unmarried" <? if($txtCivilStatus=='Unmarried') {?> checked="" <?}?>/>Unmarried<br/> </td>
-->
	  </td>
	</tr>
	
    <tr> 
      <td>Employment : </td>
      <td><input name="txtEmployment" type="text" value="<?php echo $row['employment'] ?>" /></td>
    </tr>
    <tr> 
      <td>Employer : </td>
      <td><input name="txtEmployer" type="text" value="<?php echo $row['employer'] ?>" /></td>
    </tr>
    
	
     <tr> 
      <td>Qualification : </td>
      <td>
	  <table border="0">
		<tr>
		<td>1.</td><td>O/L</td> <td><input name="txtol" type="checkbox" value="YES"  <?php if($rowqua['OL']=="YES"){ echo "checked";}?>/> </td>
		</tr>
		<tr>
		<td>2.</td><td>A/L</td> <td><input name="txtal" type="checkbox" value="YES"  <?php if($rowqua['AL']=="YES"){ echo "checked";}?>/> </td>
		</tr>
		<tr>
		<td>3.</td><td>Diploma</td> <td><input name="txtdiploma" type="checkbox" value="YES"  <?php if($rowqua['Diploma']=="YES"){ echo "checked";}?>/> </td>
		</tr>
		<tr>
		<td>4.</td><td>Higher Diploma</td> <td><input name="txthigher_Diploma" type="checkbox" value="YES"  <?php if($rowqua['HigherDiploma']=="YES"){ echo "checked";}?>/> </td>
		</tr>
		<tr>
		<td>5.</td><td>First Degree</td> <td><input name="txtFirst_Degree" type="checkbox" value="YES"  <?php if($rowqua['FirsDegree']=="YES"){ echo "checked";}?>/> </td>
		</tr>
		<tr>
		<td>6.</td><td>Postgraduate</td> <td> </td>
		</tr>
		<tr>
		<td> </td><td>One Year </td> <td><input name="txtPost_One_Year" type="checkbox" value="YES"  <?php if($rowqua['Post_OneYear']=="YES"){ echo "checked";}?>/></td>
		</tr>
		<tr>
		<td> </td><td>Two Years</td> <td><input name="txtPost_Two_Year" type="checkbox" value="YES"  <?php if($rowqua['Post_TwoYears']=="YES"){ echo "checked";}?>/></td>
		</tr>
		<tr>
		<td>7.</td>
		<td>Others : </td><td><input type="checkbox" id="myCheck"  onclick="myFunction()"  <?php if($rowqua['Others']!=""){ echo "checked";}?>></td>
		</tr>
		</td>
		</tr>
	  </table>
	  <?php if ($rowqua['Others']!=""){?>
	  
			<p id="text" >
			<textarea rows="4" cols="50" name="txtothers" type="text" > <?php echo $rowqua['Others']?>

			</textarea>

			</p>
			<?php } else{ ?>
			<p id="text" style="display:none" >
			<textarea rows="4" cols="50" name="txtothers" type="text" > <?php echo $rowqua['Others']?>

			</textarea>

			</p>
<?php }?>
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
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;"/></p>
</form>

<?php
   }
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
 $pagetitle = "Edit Student - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>Edit Student</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>