<?php
error_reporting(0);
session_start();

if (!isset($_SESSION['authenticatedUser'])) {
    header('Location: index.php');
    exit; // Ensure script stops execution after redirect
}

include('dbAccess.php');
$db = new DBOperations();

$courseID = $subcrsID = $acyear = $emonth = '';

if (isset($_POST['CourseID'])) {
    $courseID = $_POST['CourseID'];
}
if (isset($_POST['subcrsID'])) {
    $subcrsID = $_POST['subcrsID'];
}
if (isset($_POST['acyear'])) {
    $acyear = $_POST['acyear'];
}

if (isset($_POST['btnSubmit'])) {
    header("location: rptResultViewNew.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&emonth=$emonth");
    exit; // Ensure script stops execution after redirect
}
?>

<h1>Exam Results View Of Not completed & Absent Students</h1>
<br />

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
                    $result = $db->executeQuery($sql);
                    //echo $result;

                    while ($row = $db->Next_Record($result)) {
                        echo '<option value="' . $row['yearEntry'] . '">' . $row['yearEntry'] . '</option>';
                    }
                    echo '</select>';
                    // Close drop down box
                    ?>
                    <script>
                        document.getElementById('acyear').value = "<?php echo $acyear; ?>";
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
                    $result = $db->executeQuery($query);
                    while ($data = $db->Next_Record($result)) {
                        if ($_SESSION['courseId'] == 0) {
                            echo '<option value="' . $data[0] . '">' . $data[1] . '</option>';
                        } else {
                            if ($_SESSION['courseId'] == $data[0]) {
                                echo '<option value="' . $data[0] . '">' . $data[1] . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
                <script type='text/javascript' language='javascript'>
                    document.getElementById('CourseID').value = "<?php if (isset($courseID)) {
                        echo $courseID;
                    } ?>";
                </script>
            </td>
        </tr>
        <tr>
            <td>SubCourse: </td>
            <td><label>
                    <?php
                    echo '<select name="subcrsID" id="subcrsID"  onChange="document.form1.submit()" class="form-control">';
                    // Open your drop down box
                    $sql = "SELECT * FROM `crs_sub` WHERE `courseID` ='5' ";
                    $result = $db->executeQuery($sql);
                    //echo '<option value="all">Select All</option>';
                    while ($row = $db->Next_Record($result)) {
                        echo '<option value="' . $row['id'] . '">' . $row['description'] . '</option>';
                    }
                    echo '</select>';
                    // Close drop down box
                    ?>
                    <script>
                        document.getElementById('subcrsID').value = "<?php echo $subcrsID; ?>";
                    </script>
                </label>
            </td>
        </tr>
        
        <tr>
            <td>
                <p><input name="btnSubmit" type="submit" value="View Report" class="button" /></p>
            </td>
        </tr>
    </table>
    <br><br>

    <?php
    // Assuming $resultall is supposed to be initialized somewhere in your code
    $indexNo = array();
    if (isset($resultall)) {
        for ($i = 0; $i < $db->Row_Count($resultall); $i++) {
            $indexNo[$i] = mysqli_fetch_array($resultall, $i);
            //print $indexNo[$i] ;
        }
        $_SESSION['indexNo'] = $indexNo;
    }
    ?>
    <br /><br />

</form>
<?php
// Other parts of the code remain unchanged
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = 'Enrollment Related - Payment Details - Student Management System (External) - Buddhist & Pali University of Sri Lanka';
$navpath = "<ul><li><a href='index.php'>Home </a></li><li><a href='examAdmin.php'>Exam Related </a></li><li>Exam Results Brief</li></ul>";
include('master_sms_external.php');
?>