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
<script language="javascript">
 	function MsgOkCancel()
	{
		var message = "Please confirm to DELETE this subject...";
		var return_value = confirm(message);
		return return_value;
	}
 </script>
<h1>Subject Connection</h1>
<?php
	include('dbAccess.php');

$db = new DBOperations();
	if (isset($_POST['SubjectID']))
	{
		$SubjectID=$_POST['SubjectID'];
	}
	if (isset($_POST['btnSubmit']))
	{
    $subjectID1 = $db->cleanInput($_POST['SubjectID1']);
    //echo $subjectID1;
    $subjectID2 = $db->cleanInput($_POST['SubjectID2']);
    //echo $subjectID2;
    $subjectID3 = $db->cleanInput($_POST['SubjectID3']);
    //echo $subjectID3;
        $query = "INSERT INTO sub_connect SET  e1='$subjectID1', e2='$subjectID2', e3='$subjectID3'";
        $result = $db->executeQuery($query);
        header("location:subjectAdmin.php");
	}
?>
<form method="post" name="form1" id="form1" action="" onSubmit="return validate_form(this);" class="plain">
  <table width="230" class="searchResults">
    <tr>
      <td width="50" >Examination 1: </td>
      <td><label>
      <select name="SubjectID1">
      <option value="">---</option>
        <?php
			$query2 = "SELECT subjectID,nameEnglish,codeEnglish FROM subject Where subcrsID='7';";
			$result2 = $db->executeQuery($query2);
			while ($data2= $db->Next_Record($result2)) 
			{
			echo '<option value="'.$data2[0].'">'.$data2[2].'--'.$data2[1].'</option>';
        	} 
			?>
      </select>
      </label> <?php 	//print $query2;?></td>
    </tr>
    <tr>
      <td width="50" >Examination 2: </td>
      <td><label>
      <select name="SubjectID2">
      <option value="">---</option>
        <?php
			$query2 = "SELECT subjectID,nameEnglish,codeEnglish FROM subject Where subcrsID='8';";
			$result2 = $db->executeQuery($query2);
			while ($data2= $db->Next_Record($result2)) 
			{
			echo '<option value="'.$data2[0].'">'.$data2[2].'--'.$data2[1].'</option>';
        	} 
			?>
      </select>
      </label> <?php 	//print $query2;?></td>
    </tr>
    <tr>
      <td width="50" >Examination 3: </td>
      <td><label>
      <select name="SubjectID3">
      <option value="">---</option>
        <?php
			$query2 = "SELECT subjectID,nameEnglish,codeEnglish FROM subject Where subcrsID='9';";
			$result2 = $db->executeQuery($query2);
			while ($data2= $db->Next_Record($result2)) 
			{
			echo '<option value="'.$data2[0].'">'.$data2[2].'--'.$data2[1].'</option>';
        	} 
			?>
      </select>
      </label> <?php 	//print $query2;?></td>
    </tr>
  </table>
<br/><br/>
<p><input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" /></p>
<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
   $pagetitle = "Subject Connection - Subjects - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='subjectAdmin.php'>Subjects </a></li><li>Subject Connection</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>
