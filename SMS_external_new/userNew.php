<?php
  //Buffer larger content areas like the main page content
   ob_start();
  
?>
<script type="text/javascript" language="javascript">
 	function MsgInvalid()
	{
		var query1 = "SELECT courseID FROM user_tbl WHERE courseID='$courseCode'";
		var result1 = $db->executeQuery($query1);
		var row =  $db->Next_Record($result1);
	    
		var numRows = @$db->Row_Count($db->executeQuery($query1));
		
		if(numRows > 0){
			return MsgInvalid();
		}
		else{
			var query = "INSERT INTO user_tbl SET userID='$userId1', password=md5('$password1'), courseID='$courseCode'";
		
		    var result = $db->executeQuery($query);
		
		}
		
	}
	
	
	
	
 </script>
<h1>New Lecture</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	
	if (isset($_POST['btnSubmit']))
	{
		$userId1 = $_POST['userId1'];
		$password1 = $_POST['password1'];
		$courseCode = $_POST['CourseID'];
		
		$query1 = "SELECT courseID FROM user_tbl WHERE courseID='$courseCode'";
		$result1 = $db->executeQuery($query1);
		$row =  $db->Next_Record($result1);
	    //$courseID = $row['courseID'];
		$numRows = @$db->Row_Count($db->executeQuery($query1));
		//print $numRows
		
		
		
		

		if($numRows > 0){
		 
		 echo '<script language="javascript">';
         echo 'alert("Invalid user ")';
         echo '</script>';
		 
		}
		else{
		$query = "INSERT INTO user_tbl SET userID='$userId1', password=md5('$password1'), courseID='$courseCode'";
		//echo $query;
		$result = $db->executeQuery($query);
		//header("location:lectureSchedule.php");
		}
	}
?>
<form method="post" class="plain">
<table class="searchResults">
    <tr>
    	<td>User Id : </td><td><input id="userId1" name="userId1" placeholder="user Id" type="text">  </td>
    </tr>
    <tr>
    	<td>Password : </td><td><input id="password1" name="password1" placeholder="password" type="password">  </td>
    </tr>
    <tr>
    	<td>Course ID  : </td>
      <td><select id="CourseID" name="CourseID" onchange="document.form1.submit()" >
      <option value="">---</option>
          <?php
			$query = "SELECT courseID,courseCode FROM course;";
			$result = $db->executeQuery($query);
			while ($data= $db->Next_Record($result)) 
			{
			echo '<option value="'.$data[0].'">'.$data[1].'</option>';
        	} 
			?>
        </select>
        <script type="text/javascript" language="javascript">
		document.getElementById('CourseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
		</script>
      </td>
    </tr>
        
</table>
<br/><br/>
<p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'lectureSchedule.php';"  class="button"/>&nbsp;&nbsp;&nbsp;
<input name="btnSubmit" type="submit" value="Submit" onclick="MsgInvalid();" class="button" /></p>
</form>
<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "New Lecture - Lecture Schedule - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='lectureSchedule.php'>Lecture Schedule </a></li><li>New Lecture</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>