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
		if (!validate_required(txtAcYear))
		{alert("One or more mandatory fields are kept blank.");return false;}
	  }
}

function getAverage()
{
	
	var average;
	
mark1 = document.examEffort.txtMarks1.value;
mark2 = document.examEffort.txtMarks2.value;
mark1=eval(mark1);
mark2=eval(mark2);
	average=((mark1+mark2)/2);
	document.getElementById('txtMarks').value=average;
	marks=average;
	if (0<=marks && marks<=24) {grade = 'E'; gradePoint='0.0';}
	else if (25<=marks && marks<=29) {grade = 'D'; gradePoint='1.0';}
	else if (30<=marks && marks<=34) {grade = 'D+'; gradePoint='1.3';}
	else if (35<=marks && marks<=39) {grade = 'C-'; gradePoint='1.7';}
	else if (40<=marks && marks<=44) {grade = 'C'; gradePoint='2.0';}
	else if (45<=marks && marks<=49) {grade = 'C+'; gradePoint='2.3';}
	else if (50<=marks && marks<=54) {grade = 'B-'; gradePoint='2.7';}
	else if (55<=marks && marks<=59) {grade = 'B'; gradePoint='3.0';}
	else if (60<=marks && marks<=64) {grade = 'B+'; gradePoint='3.3';}
	else if (65<=marks && marks<=69) {grade = 'A-'; gradePoint='3.7';}
	else if (70<=marks && marks<=84) {grade = 'A'; gradePoint='4.0';}
	else if (85<=marks && marks<=100) {grade = 'A+'; gradePoint='4.0';}
	else grade = '';
	document.getElementById('txtGrade').value = grade;
	document.getElementById('txtGradePoint').value = gradePoint;
}



</script>

<h1>Reserch New</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	 if (isset($_POST['CourseID']))
	{
		$courseID=$_POST['CourseID'];
	}
	
	if (isset($_POST['subcrsID']))
	{
		$subcrsID=$_POST['subcrsID'];
	}
	if (isset($_POST['acyear']))
	{
		$acyear=$_POST['acyear'];
	}
	if (isset($_POST['indexNo']))
	{
		$indexNo=$_POST['indexNo'];
	}
	
	if (isset($_POST['btnSubmit']))
	{
		$indexNo = $_POST['indexNo'];
		$acyear=$_POST['acyear'];
		$topic = $db->cleanInput($_POST['txttopic']);
		$regdate = $db->cleanInput($_POST['regdate']);
		$vivadate = $db->cleanInput($_POST['vivadate']);
		 $reportsubdate= $db->cleanInput($_POST['reportsubdate']);
		
		
		$query = "INSERT INTO subject_R SET indexNo='$indexNo',acyear='$acyear', topic='$topic', reg_date='$regdate',report_sub_date='$reportsubdate',viva_date
='$vivadate'";
		$result = $db->executeQuery($query);
		print $query;
		header("location:ResearchAdmin.php");
	}
?>
<form method="post" name="form1" action="" onsubmit="return validate_form(this);" class="plain">
  <table class="searchResults">
  
    <table class="searchResults" dwcopytype="CopyTableRow">
  <tr> 
      <td width="127">Course :</td>
      <td width="91"><select id="CourseID" name="CourseID" onchange="document.form1.submit()" >
$reportsubdate          <option value="">---</option>
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
	 
								echo '<select name="subcrsID" id="subcrsID"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
								$sql="SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
								$result = $db->executeQuery($sql);
								//echo '<option value="all">Select All</option>';
								
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
                    <option value=''>---</option>
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

      <td>Reserch topic : </td>
      <td><input name="txttopic" type="text" value="" /></td>
    </tr>
    <tr> 
      <td>Registration Date : </td>
      <td><input name="regdate" type="text" value="" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" /></td>
    </tr>
    <tr> 
      <td>Viva Date </td>
      <td><input name="vivadate" type="text" value="" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" /></td>
    </tr>
    <tr> 
      <td>Report Submission date </td>
      <td><input name="reportsubdate" type="text" value="" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" /></td>
    </tr>
  </table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'examAdmin.php';"  class="button"/>&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" /></p>
</form>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "New Effort - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='examAdmin.php'>Exam Efforts </a></li><li>New Effort</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>