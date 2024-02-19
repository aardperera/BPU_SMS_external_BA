<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();

if (!isset($_SESSION['authenticatedUser'])) {
//	echo $_SESSION['authenticatedUser'];
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
<script language="javascript" src="lib/scw/scw.js"></script>
    <?php
include('dbAccess.php');

$db = new DBOperations();


if (isset($_POST['courseID']))
{
	$courseID=$_POST['courseID'];
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

//print $acyear;
if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
{
	$effortID = $db->cleanInput($_GET['effortID']);
	$delQuery = "DELETE FROM exameffort WHERE effortID='$effortID'";
	$result = $db->executeQuery($delQuery);
}

//session_start();
//$enrollid=array();

//print_r($_POST);

//if (isset($_POST)) {
//    print_r($_POST);
////    echo("button may have been pressed");
//}
if (isset($_POST['btnSubmit'])) {
//echo("button pressed");
//    exit();
$queryall = "Select * from ba_applicant where acyear='$acyear' and selection='Selected' order by applicantID";

	$resultall = $db->executeQuery($queryall);

	while ($row =  $db->Next_Record($resultall))
	{
		$applicantID=$row['applicantID'];


        if ( isset( $_POST[ 'checkBox1' . $applicantID] ) )    { $stream = "BS"; }
       
        if ( isset( $_POST[ 'checkBox2' . $applicantID] ) )    {  $stream = "LS"; }
  

        $sqlupdate = "UPDATE ba_applicant SET stream='$stream' where applicantID='$applicantID' ";
//print $sqlupdate;


            $resultinsert = $db->executeQuery($sqlupdate);
            $stream='';
	}
}



//$query = $_SESSION['query'];

?>
<h1>Enter LS/BS Details</h1>
<br />

<form method="post" action="" name="form1" id="form1" class="plain">
    <br />
    <table width="230" class="searchResults">
        <tr>
            <td>Entry Year: </td>
            <td>
                <label>
                    <?php

					echo '<select name="acyear" id="acyear"  onChange="document.form1.submit()" class="form-control">'; // Open your drop down box

					$sql="SELECT distinct yearEntry FROM crs_enroll order by yearEntry";
					$result = $db->executeQuery($sql);
					//echo '<option value="all">Select All</option>';

					while ($row =  $db->Next_Record($result)){
						echo '<option value="'.$row['yearEntry'].'"> ' . $row['yearEntry'] . ' </option>';
					}
					echo '</select>';// Close drop down box
                    ?>

                    <script>
								document.getElementById('acyear').value = "<?php if(isset($acyear)) echo $acyear;?>";
                    </script>
                </label>
            </td>

        </tr>
       



        


    </table>





    <table class="searchResults">
        <tr>
            <th rowspan="2"  style="width:15%">Registration No.</th>
            <th rowspan="2" style="width:30%">Subjects in Application</th>
            <th rowspan="2" style="width:30%">Enrolled Subjects</th>
            <th colspan="2"  style="width:15%">Course</th>
         
        </tr>
        <tr>
            <th>BS</th>
            <th>LS</th>
            
        </tr>

        <?php
		$queryall = "Select * from ba_applicant where acyear='$acyear' and selection='Selected' order by applicantID";
       //print $queryall;

		$resultall = $db->executeQuery($queryall);

        $tamount1 = 0;
        $tamount2 = 0;
        $tamount3 = 0;

		//print 'll';
		//			print $query12;
		//$result12 = $db->executeQuery($query12);
		//$row12=  $db->Next_Record($result12);
		while ($row=  $db->Next_Record($resultall))
		{
			$applicantID=$row['applicantID'];
			//$query12 = "Select regNo from exameffort where subjectID='$SubjectID' and indexNo=$indexNo 	and acYear='$acyear'";
			//print $query12;
			//$result12 = $db->executeQuery($query12);
			// $row12=  $db->Next_Record($result12);
        ?>
        <tr>
            <td align="center">
                <?php echo $row['applicantID'] ?>
            </td>

         <?php

$querysubject = "Select * from ba_subjects where  applicantID='$applicantID'  order by applicantID";

$resultsubject = $db->executeQuery($querysubject);
while ($rowsubject=  $db->Next_Record($resultsubject))
		{
			
            $sub2=$rowsubject['bp'];
            $sub3=$rowsubject['bc'];
            $sub4=$rowsubject['pali'];
            $sub5=$rowsubject['san'];
            $sub6=$rowsubject['eng'];
            $sub7=$rowsubject['arch'];
            $sub8=$rowsubject['rs'];
            $sub9=$rowsubject['sin'];
            $sub10=$rowsubject['bcon'];
            $sub11=$rowsubject['tamil'];
            $sub12=$rowsubject['esin'];

           ?>
               
                <td align="center">
                <?php 
                 if($sub2=='1'){ 
                echo "Buddist Philosophy"."<br>"; 
              
                 }
                 if ($sub3=='1'){ 
                    echo "Buddist Culture"."<br>"; 
                  
                     }
                    if ($sub4=='1'){ 
                        echo "Pali"."<br>"; 
                      
                         }
                    if ($sub5=='1'){ 
                            echo "Sanskrit "."<br>"; 
                          
                             }
                    if ($sub6=='1'){ 
                                echo "English"."<br>"; 
                              
                                 }
                    if ($sub7=='1'){ 
                                    echo "Archaeology "."<br>"; 
                                  
                                     }
                        if ($sub8=='1'){ 
                                        echo "Religious Study"."<br>"; 
                                      
                                         }
                                         
                        if ($sub9=='1'){ 
                            echo "Sinhala"; 
                                          
                        }       

                ?>

            </td>
            

            <?php

$queryenroll = "Select Enroll_id from crs_enroll where  studentID='$applicantID'  and yearEntry='$acyear' and courseID='5' and subcrsID='7' ";

$enrollid=' ';
$resultenroll = $db->executeQuery($queryenroll);
while ($rowenroll=  $db->Next_Record($resultenroll))
		{
			
            $enrollid=$rowenroll['Enroll_id'];
        }


               

           ?>
               
                <td align="left">
                <?php 
                $querysubject = "Select e.subjectID,s.codeEnglish,s.nameEnglish from subject_enroll as e,subject as s where  e.Enroll_id ='$enrollid'  and e.subjectID=s.subjectID ";
//print $querysubject;
                $resultsubject = $db->executeQuery($querysubject);
                while ($rowsubject=  $db->Next_Record($resultsubject))
                        {
                            echo $rowsubject['codeEnglish'];
                            echo ' - ';
                            echo $rowsubject['nameEnglish'];
                            echo '</br>';
                           
                        }
                                          
                        
                ?>

            </td>

                    


            <?php   
            
          
            
			//$query12 = "Select regNo from exameffort where subjectID='$SubjectID' and indexNo=$indexNo 	and acYear='$acyear'";
			//print $query12;
			//$result12 = $db->executeQuery($query12);
                    	}	// $row12=  $db->Next_Record($result12);
        
			
		?>
            <td>
                <center>
                    <input type='checkBox' name="checkBox1<?php echo $applicantID ?>" id="checkBox1<?php echo $applicantID ?>" value="checkBox1<?php echo $applicantID ?>" <?php if($row['stream']=="BS") echo 'checked'?> />
                </center>
            </td>
         
            <td>
                <center>
                    <input type='checkBox' name="checkBox2<?php echo $applicantID ?>" id="checkBox2<?php echo $applicantID ?>" value="checkBox2<?php echo $applicantID ?>" <?php if($row['stream']=="LS") echo 'checked'?> />
                </center>
            </td>
            

        </tr>

        <?php
		}
        ?>
       
    </table>
    
    <br /><br />
    <p>
        <input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'index.php';" class="button" />&nbsp;&nbsp;&nbsp;<input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" />
    </p>
</form>

<script>
			function Function(item,value){
				var string = ""; string = value;
				document.getElementById(item).value = string;
				document.getElementById(item).innerHTML = value;
				//alert("item : " + item + ", value : " + value);
            }
</script>

<script>
    function payment(id1, id2, id3, id) {
        amount1 = parseInt(document.getElementById(id1).value);
        amount2 = parseInt(document.getElementById(id2).value);
        amount3 = parseInt(document.getElementById(id3).value);

        total = 0;
        if (!isNaN(amount1)) total += amount1;
        if (!isNaN(amount2)) total += amount2;
        if (!isNaN(amount3)) total += amount3;

        document.getElementById(id).value = total;
	}
</script>

<?php
//}else echo "<p>No exam details available.</p>";

//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Enter Results - Exam Efforts - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='index.php'>Enrollment Related </a></li><li>Course Payments</li></ul>";
//Apply the template
include("master_sms_external.php");
?>