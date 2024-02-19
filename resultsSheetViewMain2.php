<?php
    error_reporting(E_ALL & ~E_WARNING);
?>
<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if ( !isset( $_SESSION['authenticatedUser'] ) ) {
    echo $_SESSION['authenticatedUser'];
    header( 'Location: index.php' );
}
?>
<script language='javascript'>
function MsgOkCancel() {
    var message = 'Please confirm to DELETE this entry...';
    var return_value = confirm(message);
    return return_value;
}
</script>
<?php
include( 'dbAccess.php' );
$db = new DBOperations();
if ( isset( $_POST['CourseID'] ) )
{
    $courseID = $_POST['CourseID'];
}
if ( isset( $_POST['subcrsID'] ) )
 {
    $subcrsID = $_POST['subcrsID'];
}
if ( isset( $_POST['acyear'] ) )
 {
    $acyear = $_POST['acyear'];
}

if ( isset( $_POST['emonth'] ) )
 {
    $emonth = $_POST['emonth'];
}
//print $acyear;

	if (isset($_POST['btnSubmit']))
	{
				
			header("location:resultsSheetViewE.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&emonth=$emonth");
	}
    if (isset($_POST['btnSubmit1']))
	{
				
			header("location:newresultsheetE.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&emonth=$emonth");
	}
//session_start();
//$enrollid = array();
//$query = $_SESSION['query'];
?>
<h1>Exam Results View</h1>
<br />
<?php
//if ( $db->Row_Count( $result )>0 ) {
?>
<form method='post' action='' name='form1' id='form1' class='plain'>
    <br />
    <table width='230' class='searchResults'>
        <tr>
            <td>Academic Year: </td>
            <td><label>
                    <?php
echo '<select name="acyear" id="acyear"  onChange="document.form1.submit()" class="form-control">';
// Open your drop down box
$sql = 'SELECT distinct yearEntry FROM crs_enroll';
			//	echo $sql;
$result = $db->executeQuery( $sql );
				//echo $result;
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
        <tr>
            <td>Payment Done: </td>
            <td><label>
                    <?php
echo '<select name="emonth" id="emonth" class="form-control">';
// Open your drop down box
echo '<option value="1">January</option>';
echo '<option value="2">February</option>';
echo '<option value="3">March</option>';
echo '<option value="4">April</option>';
echo '<option value="4">May</option>';
echo '<option value="4">June</option>';	
echo '<option value="4">July</option>';
echo '<option value="4">August</option>';
echo '<option value="4">September</option>';	
echo '<option value="4">October</option>';
echo '<option value="4">November</option>';
echo '<option value="4">December</option>';
echo '</select>';
// Close drop down box
?>
                    <script>
                    document.getElementById('pass_state').value = "<?php echo $pass_state;?>";
                    </script>
                </label>
            </td>
        </tr>
        <tr><td><p><input name="btnSubmit" type="submit" value="View Report" class="button" /></p></td></tr>
        <tr><td><p><input name="btnSubmit1" type="submit" value="View Excel Report" class="button" /></p></td></tr>
    </table>
    <br><br>
    
    <?php
$indexNo = array();
for ( $i = 0; $i<$db->Row_Count( $resultall );
$i++ )
 {
    $indexNo[$i] = mysql_result( $resultall, $i, 'indexNo' );
    //print $indexNo[$i] ;
}
$_SESSION['indexNo'] = $indexNo;
?>
    <br /><br />
    
</form>
<?php
//} else echo '<p>No exam details available.</p>';
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = 'Enrollment Related - Payment Details - Student Management System (External) - Buddhist & Pali University of Sri Lanka';
$navpath = "<ul><li><a href='index.php'>Home </a></li><li><a href='examAdmin.php'>Exam Related </a></li><li>Exam Results Brief</li></ul>";
//Apply the template
include( 'master_sms_external.php' );
?>