<?php
  //Buffer larger content areas
  ob_start();
session_start();
  
?>

<script>
function validate_form(thisform)
{
	with (thisform)
	  {
		if (!validate_required(txtCourseCode) || !validate_required(txtNameEnglish) || !validate_required(txtNameSinhala))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}
</script>

<h1>New Course</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	 if (isset($_POST['CourseID']))
	{
		$courseID=$_POST['CourseID'];
	}
else{$courseID="";}
	
	if (isset($_POST['subcrsID']))
	{
		$subcrsID=$_POST['subcrsID'];
	}
else{$subcrsID="";}
	if (isset($_POST['acyear']))
	{
		$acyear=$_POST['acyear'];
	}
else{$acyear="";}
if (isset($_POST['lstSupType']))
	{
		$lstSupType=$_POST['lstSupType'];
	}
else{$lstSupType="";}
if (isset($_POST['indexNo']))
	{
		$indexNo=$_POST['indexNo'];
	}
else{$indexNo="";}
if (isset($_POST['sup']))
	{
		$sup=$_POST['sup'];
	}
else{$sup="";}
//$querysu = "Select nameEnglish from sup_dtl where  id='$sup_id'";
//		$resultsu = $db->executeQuery($querysu);
//		$rowsu =  $db->Next_Record($resultsu);
//$nameEnglish=$rowsu[0];
print 'lll';
print $sup_id;

print $acyear;
	if (isset($_POST['btnSubmit']))
	{
		$querys = "Select Enroll_id from crs_enroll where  yearEntry='$acyear' and courseID='".$_SESSION['courseId']."'  and subcrsID='$subcrsID' and indexNo='$indexNo'";
		$results = $db->executeQuery($querys);
		$rows =  $db->Next_Record($results);
		$enroll_id=$rows[0];
		print $enroll_id;
		$query = "INSERT INTO R_sup_dtl SET Enroll_id='$enroll_id',sup_id='$sup', type='$lstSupType'";
		$result = $db->executeQuery($query);
		header("location:student_Sup_Details.php");
	}
?>
<form method="post" action="" name='form1' onsubmit="return validate_form(this);" class="plain">
<table class="searchResults">
  <tr> 
      <td width="127">Course :</td>
      <td width="91"><select id="CourseID" name="CourseID" onchange="document.form1.submit()" >
          <option value="">--Select--</option>
          <?php
			$query = "SELECT courseID,courseCode FROM course;";
			$result = $db->executeQuery($query);
			while ($data= $db->Next_Record($result)) 
			{
			if ($_SESSION['courseId']==0)
			  {
			  echo '<option value="'.$data[0].'">'.$data[1].'</option>'; 
			  }
			  else
			  {
				if ($_SESSION['courseId']==$data[0])
				  {
				  echo '<option value="'.$data[0].'">'.$data[1].'</option>'; 
				  }	
			  }
        	} 
			?>
        </select> <script type="text/javascript" language="javascript">
		document.getElementById('CourseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
		</script> </td>
    </tr>
    <tr> 
      <td>SubCourse: </td>
      <td><label> 
        <?php
	 
								echo '<select name="subcrsID" id="subcrsID"  onChange="document.form1.submit()" class="form-control">';
		  // Open your drop down box
								$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								echo '<option value="">--Select--</option>';
								while ($row =  $db->Next_Record($result)){
									echo '<option value="'.$row['id'].'">'.$row['description'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
        <script>
								document.getElementById('subcrsID').value = "<?php if(isset($subcrsID)){echo $subcrsID;}?>";
							</script>
        </label> </td>
    </tr>
    <tr> 
      <td>Academic Year: </td>
      <td><label> 
        <?php
	 
								echo '<select name="acyear" id="acyear"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
		  			
								$sql="SELECT distinct yearEntry FROM crs_enroll";
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								echo '<option value="">--Select--</option>';	
								while ($row =  $db->Next_Record($result)){
									echo '<option value="'.$row['yearEntry'].'">'.$row['yearEntry'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
        <script>
								document.getElementById('acyear').value = "<?php echo $acyear;?>";
							</script>
        </label> </td>
    </tr> 
     <tr>
            <td width='127'>Index No :</td>
            <td width='91'><select id='indexNo' name='indexNo' onchange='document.form1.submit()'>
                    <option value="">--Select--</option>
                    <?php
$query = "Select * from crs_enroll where  yearEntry='$acyear' and courseID='".$_SESSION['courseId']."'  and subcrsID='$subcrsID'";
				
$result = $db->executeQuery( $query );
//while ( $data =  $db->Next_Record( $result ) )
// $result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
									
								while ($row =  $db->Next_Record($result)){
									echo '<option value="'.$row['indexNo'].'">'.$row['indexNo'].'</option>';
								}
								echo '</select>';
?>
                </select>
              
                <script type='text/javascript' language='javascript'>
                document.getElementById('indexNo').value = "<?php if(isset($indexNo)){echo $indexNo;}?>";
                </script>
            </td>
        </tr> 
     <tr> 
      <td>Supervisor </td>
      <td><label> 
        <?php
	 
								echo '<select name="sup" id="sup"  onChange="document.form1.submit()" class="form-control">
								<option value="">--Select--</option>								'; // Open your drop down box
		  			
								$sql="SELECT distinct nameEnglish,id FROM sup_dtl";
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
									
								while ($row =  $db->Next_Record($result)){
									echo '<option value="'.$row['id'].'">'.$row['nameEnglish'].'</option>';
								}
								echo '</select>';// Close drop down box
							?>
        <script>
			document.getElementById('sup').value ="<?php echo $sup;?>";
							
							</script>
        </label> </td>
    </tr>    

    <tr>
    	<td>Supervisor Type : </td><td><select name="lstSupType">
        	<option value="Supervisor">Supervisor</option>
        	<option value="Examinar">Examinar</option>
            
            
        </select></td>
    </tr>
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'student_Sup_Details.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" /></p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "New Course - Courses - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='student_Sup_Details.php'>Student's Supervisor </a></li><li>New Course</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>