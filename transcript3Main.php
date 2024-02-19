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
 	function MsgOkCancel()	{

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
 if (isset($_POST['SubjectID']))
 {
     $SubjectID=$_POST['SubjectID'];
 }
 if (isset($_POST['indexNo']))
 {
     $indexNo=$_POST['indexNo'];
     
 }
 
 //print $acyear;
 if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
 {
     $effortID = $db->cleanInput($_GET['effortID']);
     $delQuery = "DELETE FROM exameffort WHERE effortID='$effortID'";
     $result = $db->executeQuery($delQuery);
 }
 
 if (isset($_POST['btnSubmit']))
 {
     header("location:transcript3.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&indexNo=$indexNo");
 }
 
 
 //$query = $_SESSION['query'];
 
 ?>

 
<h1>Generate Transcript</h1>
 <br />
  
<?php
 //if ($db->Row_Count($result)>0){
?>
<form method="post" action="" name="form1" id="form1" class="plain">
<br/>
    <table width="230" class="searchResults">
        <tr>
            <td>Academic Year: </td>
            <td>
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
 		    </td>
        </tr>
    <tr> 
        <td width="127">Course  :</td>
	 
        <td width="91"><select id="CourseID" name="CourseID" onchange="document.form1.submit()" >
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
		        document.getElementById('CourseID').value="<?php if(isset($courseID)){echo $courseID;}?>";
		    </script>
        </td>
    </tr>
    <tr>
        <td>SubCourse: </td>
            <td>
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
	    	</td>
        
    </tr>
	<tr>
        <td>Index No.: </td>  
        <td>
     	  <?php
           
           echo '<select name="indexNo" id="indexNo"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box
           $sql="SELECT * FROM `crs_enroll` WHERE `courseID` ='".$_SESSION['courseId']."' and subcrsID='$subcrsID' and yearEntry='$acyear' order by indexNo ";
           $result = $db->executeQuery($sql);
           //echo '<option value="all">Select All</option>';
           
           while ($row =  $db->Next_Record($result)){
               echo '<option value="'.$row['indexNo'].'">'.$row['indexNo'].'</option>';
           }
           echo '</select>';// Close drop down box
           ?>
							
							 <script>
								document.getElementById('indexNo').value = "<?php echo $indexNo;?>";
							</script>
 
		</td>
    </tr>
	<tr>
        <td>
            <input name="btnSubmit" type="submit" value="View Report" class="button" />
        </td>
    </tr>
    </table>
 
 
 
 

    
//<?php
//$queryall = "Select * from crs_enroll c,subject_enroll s,subject j where  c.yearEntry='$acyear' and c.courseID='".$_SESSION['courseId']."'  and c.subcrsID='$subcrsID' and c.Enroll_id=s.Enroll_id and c.indexNo='$indexNo' and j.subjectID=s.subjectID";
////print $queryall;
//$resultall = $db->executeQuery($queryall);
//
//  $indexNo = array();
//  for ($i=0;$i<$db->Row_Count($resultall);$i++)
//  {
//      $indexNo[$i] = $row['indexNo'];
//      //print $indexNo[$i] ;
//  }
//  $_SESSION['indexNo'] = $indexNo;
//  ?>
<br/><br/>
  
</form>

<?php 
//}else echo "<p>No exam details available.</p>";

//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Transcript - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='index.php'>Home </a></li><li><a href='studentAdmin.php'>Students </a></li><li>Transcript</li></ul>";
//Apply the template
include("master_sms_external.php");
?>