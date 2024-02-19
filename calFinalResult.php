<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if ( !isset( $_SESSION['authenticatedUser'] ) ) {
    echo $_SESSION['authenticatedUser'];
    header( 'Location: index.php' );
}
?>

<?php
    error_reporting(E_ALL & ~E_WARNING);
?>
<script language='javascript'>
function MsgOkCancel() {
    var message = 'Please confirm to DELETE this entry...';
    var return_value = confirm(message);
    return return_value;
}
</script>
<?php
include('dbAccess.php' );
$db = new DBOperations();

if ( isset( $_POST['CourseID'] ) )
{
    $courseID = $_POST['CourseID'];
	//print $courseID ;
}
if ( isset( $_POST['subcrsID'] ) )
{
    $subcrsID = $_POST['subcrsID'];
}
if ( isset( $_POST['acyear'] ) )
{
    $acyear = $_POST['acyear'];
}
if ( isset( $_POST['SubjectID'] ) )
{
    $SubjectID = $_POST['SubjectID'];
}
if ( isset( $_POST['pfa'] ) )
{
    $pfa = $_POST['pfa'];
}
//print $acyear;


if (isset($_POST['btnSubmit']))
{
    
    $acyear = ($_POST['acyear']);
    $courseID = ($_POST['CourseID']);
    $subcrsID = ($_POST['subcrsID']);
    
    
    




    $queryall = "SELECT c.indexNo,c.Enroll_id from crs_enroll c where c.yearEntry='$acyear' and c.courseID='$courseID' and c.subcrsID='$subcrsID'";

    //print indexNo;
    $resultall = $db->executeQuery( $queryall );
    //print 'll';
    //			print $query12;
    //$result12 = $db->executeQuery( $query12 );
    
    while ( $row =  $db->Next_Record( $resultall ) )
    {
        $AB=0;
		$MD=0;
		$MK=0;
		$MK2=0;
        //print $row['indexNo'];
        $indexNo = $row['indexNo'];
        $Enroll_id = $row['Enroll_id'];

        // $query111 = "SELECT * FROM `exameffort` where indexNo='20186347' and `acYear`='2018'";
        $query11123 = "SELECT indexNo,marks from exameffort where acYear='$acyear' and indexNo='$indexNo';";
       
        $result11123 = $db->executeQuery($query11123);
        //print_r($result111);
        while ( $row1 =  $db->Next_Record( $result11123 ) ){
           
            //		 $aa= $row1[1];
            //		 print $aa;
            if ($row1[1]=='AB'){
                
                $AB=$AB+1;
            }
            else if ($row1[1]=='MD')
            {
                $MD=$MD+1; 
            }
            else if ($row1[1]<40 && $row1[1]>=0){
                $MK=$MK+1;
            }	
            else if ($row1[1]>=40 && $row1[1]<=100){
                $MK2=$MK2+1;
            }
        }
        // print 'mark'; print $row1[1];print 'hh';print $AB;print 'jj';print $MD;print 'KK';print $MK;print 'll';print '$MK2';
        $result111 = $db->executeQuery($query11123);
        $rowcount= $db->Row_Count($result111);

        if($rowcount==$AB){
            $query111 = "Insert into final_result (enroll_id,status) values ('$Enroll_id','Absent')";
        }
        else if ($rowcount==$MD){
            $query111 = "Insert into final_result (enroll_id,status) values ('$Enroll_id','Medical')";
        }
        else if ($rowcount==$MK2){
            $query111 = "Insert into final_result (enroll_id,status) values ('$Enroll_id','Complete')";  
        }
        else{
            $query111 = "Insert into final_result (enroll_id,status) values ('$Enroll_id','Not Complete')"; 
        } $db->executeQuery($query111);
        
		

    }
}
?>
<h1>Update Complete Status</h1>
<br />
<?php
//if ( $db->Row_Count( $result )>0 ) {
?>
<form method='post' action='' name='form1' id='form1' class='plain'>
    <br />
    <table width='230' class='searchResults'>
        <tr>
            <td>Academic Year: </td>
            <td>
                <label>
                    <?php
                    echo '<select name="acyear" id="acyear"  onChange="document.form1.submit()" class="form-control">';
                    // Open your drop down box
                    $sql = 'SELECT distinct yearEntry FROM crs_enroll';
                    $result = $db->executeQuery( $sql );
                    //echo '<option value="all">All</option>';
                    while ( $row =  $db->Next_Record( $result ) ) {
                        echo '<option value="'.$row['yearEntry'].'">'.$row['yearEntry'].'</option>';
                    }
                    echo '</select>';
                    // Close drop down box
                    ?>
                    <script>
                    document.getElementById('acyear').value = "<?php echo $acyear;?>";
                    </script>
                </label>
            </td>
        </tr>
        <tr>
            <td width='127'>Course :</td>
            <td width='91'><select id='CourseID' name='CourseID' onchange='document.form1.submit()'>
                    <option value=''>---</option>
                    <?php
                    $query = 'SELECT courseID,courseCode FROM course;';
                    $result = $db->executeQuery( $query );
                    while ( $data =  $db->Next_Record( $result ) )
                    {
                        if ( $_SESSION['courseId'] == 0 )
                        {
                            echo '<option value="'.$data[0].'">'.$data[1].'</option>';
                        } else {
                            if ( $_SESSION['courseId'] == $data[0] )
                            {
                                echo '<option value="'.$data[0].'">'.$data[1].'</option>';
                            }
                        }
                    }
                    ?>
                </select>
                <script type='text/javascript' language='javascript'>
                document.getElementById('CourseID').value = "<?php if(isset($courseID)){echo $courseID;}?>";
                </script>
            </td>
        </tr>
        <tr>
            <td>SubCourse: </td>
            <td><label>
                    <?php
                    echo '<select name="subcrsID" id="subcrsID"  onChange="document.form1.submit()" class="form-control">';
                    // Open your drop down box
                    $sql = "SELECT * FROM `crs_sub` WHERE `courseID` ='".$_SESSION['courseId']."' ";
                    $result = $db->executeQuery( $sql );
                    //echo '<option value="all">Select All</option>';
                    while ( $row =  $db->Next_Record( $result ) ) {
                        echo '<option value="'.$row['id'].'">'.$row['description'].'</option>';
                    }
                    echo '</select>';
                    // Close drop down box
                    ?>
                    <script>
                    document.getElementById('subcrsID').value = "<?php echo $subcrsID;?>";
                    </script>
                </label>
            </td>
        </tr>


    </table>
    <table class='searchResults'>
        <tr>
      
            <th>Index No.</th>
            <th>Status</th>
       
        </tr>
        <?php


        $queryall = "SELECT c.indexNo from crs_enroll c where c.yearEntry='$acyear' and c.courseID='$courseID' and c.subcrsID='$subcrsID' order by indexNo ";

        
        $resultall = $db->executeQuery( $queryall );
        //print 'll';
        //			print $query12;
        //$result12 = $db->executeQuery( $query12 );
        while ( $row =  $db->Next_Record( $resultall ) )
        {
            $AB=0;
            $MD=0;
            $MK=0;
            $MK2=0;
            $indexNo = $row['indexNo'];
            //print $indexNo;
            // $query111 = "SELECT * FROM `exameffort` where indexNo='20186347' and `acYear`='2018'";
            $query123 = "SELECT indexNo,marks from exameffort where acYear='$acyear' and indexNo='$indexNo'";
            $result123 = $db->executeQuery( $query123 );
            while ( $row1 =  $db->Next_Record( $result123 ) ){
                if ($row1[1]=='AB'){
                    $AB=$AB+1;
                }
                else if ($row1[1]=='MD')
                {
                    $MD=$MD+1; 
                }
                else if ($row1[1]<40 && $row1[1]>=0){
                    $MK=$MK+1;
                }	
                else if ($row1[1]>=40 && $row1[1]<=100){
                    $MK2=$MK2+1;
                }
                
            }
            $result123 = $db->executeQuery($query123);
            $rowcount= $db->Row_Count($result123);

        ?>
        <tr><td><?php echo $row['indexNo'];  ?></td>
		
		
		<?php if($rowcount==$AB){ ?>
            <td><?php echo 'Absent' ?></td>
          <?php } 
              else if ($rowcount==$MD){?>
           <td><?php echo 'Medical' ?></td>
		   <?php }elseif ($rowcount==$MK2){
           ?>
		   <td><?php echo 'Complete' ?></td><?php
              } else{
                                            ?>
		   <td><?php echo 'Not Complete' ?></td>
        </tr>
        <?php			
              }
        }
        ?>
        <tr>
            <td rowspan="3" colspan=4 style="text-align: center;"><br><input name="btnSubmit" type="submit"
                    value="Update" class="button" /><br>
                <h6></h6>
            </td>

        </tr>
    </table>

   
    <br /><br />
</form>
<?php
//} else echo '<p>No exam details available.</p>';
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = 'Enrollment Related - Payment Details - Student Management System (External) - Buddhist & Pali University of Sri Lanka';
$navpath = "<ul><li><a href='index.php'>Home </a></li><li><a href='examAdmin.php'>Exam Related </a></li><li>Update Complete Status</li></ul>";
//Apply the template
include( 'master_sms_external.php' );
?>