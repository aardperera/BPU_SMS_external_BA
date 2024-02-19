<?php
  //Buffer larger content areas like the main page content
  ob_start();
?>
<?php
	include('dbAccess.php');

$db = new DBOperations();	
?>

<?php

//if (!isset($_POST['submit'])) 

?>
<h1>Identify Certificate</h1>
<form name = "form118" id = "form118" method="POST" action="marptstudentIdentify.php">



<table>
 <tr>
	<td><h6>Registration No:</h6></td>
      <td><select name="IndexNoId" id="IndexNoId" style="width:auto" onchange = "int_check(this)">
			<option value="sel"> Select</option> 
			<?php
			$query123 = "SELECT regNo FROM crs_enroll";
			$result = $db->executeQuery($query123);
			while ($roww =  $db->Next_Record($result))
			{
				$id = $roww["regNo"];
				//$dname = $roww["Division_Name"]; 
				echo "<OPTION VALUE=".$id.">".$id."</OPTION>";
			}
			?>
			</td>
    </tr>
	
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'mastudentIdentify.php';"  class="button" style="width:60px;"/>&nbsp;&nbsp;&nbsp;
   <input name="btnSubmit" id="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;"/></p>
</form>

<?php

  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Exam Schedule - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li>Exam Schedule</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>