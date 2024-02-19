<?php

  ob_start();
   session_start();
?>

<script language="javascript" src="lib/scw/scw.js"></script>
<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtPaymentID) || !validate_required(PaymentID))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
</script>

<h1>Course Payment Edit</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
 print $_SESSION['courseID'] ;
	if (isset($_POST['btnSubmit']))
	{
		
		$PaymentID = $_GET['PaymentID'];
//print($PaymentID);		
		
		$subcrsID = $_POST['subcrsID'];
		$PaymentType = $_POST['Paymenttxt'];
		$testDescption = $_POST['txtDescription'];
		$Amount = $_POST['txtAmount'];
		$date = $_POST['date'];
		$enddate = $_POST['enddate'];
		
		
		$query = "UPDATE course_payment SET subcrsID='$subcrsID',Description='$testDescption',PaymentType='$PaymentType',Amount='$Amount',StartDate='$date',	EndDate='$enddate' WHERE PaymentID='$PaymentID'";
		
		$result = $db->executeQuery($query);
		header("location:coursepayment.php");
		//print($query);
	}
	
	$PaymentID = $db->cleanInput($_GET['PaymentID']);
	$query = "SELECT * FROM course_payment WHERE PaymentID='$PaymentID'";
	$result = $db->executeQuery($query);
	
	$row =  $db->Next_Record($result);
		$subcrsID=$row['subcrsID'];
		$testDescption=$row['Description'];
		$testAmount=$row['Amount'];
		$date=$row['StartDate'];
		$enddate=$row['EndDate'];
	if ($db->Row_Count($result)>0)
		
	{
		
?>
<form method="post" action="CoursePaymentEdit.php?PaymentID=<?php echo $PaymentID; ?>" onsubmit="return validate_form(this);" class="plain">
  <table class="searchResults">
   
	<tr> 
    <td>Payment ID : </td>
    <td> <?php echo $row['PaymentID']; ?></td>
	</tr>
	 <tr>
    <td>Course :</td>
    <td><?php echo $row['courseID']; ?></td>
  </tr>
	
	
	 <tr>
      <td>Sub Course ID: </td>
      <td>
     	  <?php
	 
								echo '<select name="subcrsID" id="subcrsID" onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
								$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
								
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								
								while ($row =  $db->Next_Record($result)){
									
									echo '<option value="'.$row['id'].'">'.$row['description'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
							
							 <script>
								document.getElementById('description').value="<?php echo $subcrsID; ?>";
							</script>
		</td>
        
    </tr>
	
	 
	<tr>
    	<td>Payment Type : </td><td><select name="Paymenttxt">
        	<option <?php if ($row['PaymentType']=='CourseFree') echo "selected='selected'"; ?> value="CourseFree">Course Free</option>
			<option <?php if ($row['PaymentType']=='Other') echo "selected='selected'"; ?> value="Other">Other</option>	
        </select></td>
    </tr>
	
	
    <tr>
      <td>Description. :</td>
      <td><input name="txtDescription" id="txtDescription" type="text" value="<?php echo $testDescption; ?>"/></td>
    </tr>
  
	  <tr>
      <td>Amount. :</td>
      <td><input name="txtAmount" type="text" value="<?php echo $testAmount; ?>" /></td>
    </tr>
	
	<tr>	
      <td>Start Date: </td>
	  <td> <input type="date" id="date" name="date" value="<?php echo $date; ?>"/></td>
    </tr>
	
	<tr>
      <td>End Date: </td>
      <td> <input type="date" id="enddate" name="enddate" value="<?php echo $enddate ?>"></td>
      
    </tr>
	
	
  </table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'coursepayment.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;"/></p>
</form>

<?php
   }
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
 $pagetitle = "Edit Student - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='coursepayment.php'>Students </a></li><li>Edit Student</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>