<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
   if (!isset($_SESSION['authenticatedUser'])) {
   echo $_SESSION['authenticatedUser'];
   header("Location: index.php");
   }
?>
<script language="javascript">
function MsgOkCancel() {
    var message = "Please confirm to DELETE this entry...";
    var return_value = confirm(message);
    return return_value;
}
</script>
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
	if (isset($_POST['lstSubject']))
	{
		$SubjectID=$_POST['lstSubject'];
	}
if (isset($_POST['medium']))
	{
		$medium=$_POST['medium'];
	}
if (isset($_POST['examc']))
	{
		$examc=$_POST['examc'];
	}
//incude submit button for view report
if (isset($_POST['btnSubmit']))
	{
				
			header("location:markingSheet.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&medium=$medium&SubjectID=$SubjectID&examc=$examc");
	}

  //print $acyear;
  if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
  {
	$effortID = $db->cleanInput($_GET['effortID']);
	$delQuery = "DELETE FROM exameffort WHERE effortID='$effortID'";
	$result = $db->executeQuery($delQuery);
  }
  session_start();
  //$enrollid=array();
  
  //$query = $_SESSION['query'];
?>
<h1>Mark Sheet</h1>
<br />
<?php
//if ($db->Row_Count($result)>0){
?>
<form method="post" action="" name="form1" id="form1" class="plain">
    <br />
    <table width="230" class="searchResults">
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
                </label>
            </td>
        </tr>
        <tr>
            <td width="127">Course :</td>
            <td width="91"><select id="CourseID" name="CourseID" onchange="document.form1.submit()">
                    <option value="">---</option>
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
                </select>
                <script type="text/javascript" language="javascript">
                document.getElementById('CourseID').value = "<?php if(isset($courseID)){echo $courseID;}?>";
                </script>
            </td>
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
                    document.getElementById('subcrsID').value = "<?php echo $subcrsID;?>";
                    </script>
                </label>
            </td>
        </tr>
      
        <tr>
            <tr>
    	<td>Subject : </td>
        <td><select name="lstSubject" id="lstSubject" style="width:auto">
        	<?php
			
			//$query2 = "select * from crs_enroll where indexNo='$indexNo'";
						
						
			$query = "SELECT * FROM crs_subject c,subject s WHERE c.CourseID= '$courseID' and c.subcrsid='$subcrsID' and c.subjectID=s.subjectID";
			$result = $db->executeQuery($query);
			for ($i=0;$i<$db->Row_Count($result);$i++)
			{
				$rID = mysql_result($result,$i,"subjectID");
				$rCode = mysql_result($result,$i,"codeEnglish");
				$rSubject = mysql_result($result,$i,"nameEnglish");
              	echo "<option value=\"".$rID."\">".$rCode." - ".$rSubject."</option>";
        	} 
			?>
        	</select>
        </td>
    </tr><tr>
       <td>Medium  : </td>
      <td><select id="medium" name="medium"  >
      <option value="">---</option>
          <?php
			 echo '<option value="S">Sinhala</option>'; 
			  echo '<option value="E">English</option>'; 
			?>
        </select>
        <script type="text/javascript" language="javascript">
		document.getElementById('CourseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
		</script>
      </td>
        </tr>
        <tr>
       <td>Exam Center : </td>
      <td><select id="examc" name="examc"  >
      <option value="">---</option>
          <?php
			 echo '<option value="1">Buddhist and pali university</option>'; 
			  
			?>
        </select>
        <script type="text/javascript" language="javascript">
		document.getElementById('CourseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
		</script>
      </td>
        </tr>
         <tr><td><p><input name="btnSubmit" type="submit" value="View Report" class="button" /></p></td></tr>
    </table>
    
    <?php
	/*
  	$indexNo = array();
  	for ($i=0;$i<$db->Row_Count($resultall);$i++)
	{
			$indexNo[$i] = mysql_result($resultall,$i,"indexNo");
	}
	$_SESSION['indexNo'] = $indexNo; */
  ?>
    <br /><br />
</form>
<?php 
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Enter Results - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='examAdmin.php'>Exam Efforts </a></li><li>Enter Results</li></ul>";
  include("master_sms_external.php");
?>