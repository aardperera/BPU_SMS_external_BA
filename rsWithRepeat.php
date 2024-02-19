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
    
    include('dbAccess.php');
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
    if ( isset( $_POST['effortNo'] ) )
    {
        $effortNo = $_POST['effortNo'];
    }
    if (isset($_POST['btnSubmit']))
    {				
		header("location:drsWithRepeat.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&effortNo=$effortNo");
    }   
        
        
?>

<h1>Detailed Result Sheet with Repeat Results</h1>

<form method='post' action='' name='form1' id='form1' class='plain'>
    <br />
    <table width='230' class='searchResults'>
        <tr>
            <td>Academic Year: </td>
            <td>
                <label>
                    <?php
                        echo '<select name="acyear" id="acyear"  onChange="document.form1.submit()" class="form-control">';
                        $sql = 'SELECT distinct yearEntry FROM crs_enroll';
                        $result = $db->executeQuery( $sql );
                        while ( $row =  $db->Next_Record( $result ) ) {
                            echo '<option value="'.$row['yearEntry'].'">'.$row['yearEntry'].'</option>';
                        }
                        echo '</select>';
                    ?>
                    <script>
                        document.getElementById('acyear').value = "<?php echo $acyear;?>";
                    </script>
                </label>
            </td>
        </tr>
        
        <tr>
            <td>Exam Year: </td>
            <td>
                <label>
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
            <td width='127'>Course :</td>
            <td width='100'>
                <select id='CourseID' name='CourseID' onchange='document.form1.submit()'>
                    <!-- <option value=''>---</option> -->
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
            <td>Effort:</td>
            <td>
                <select id="effortNo" name="effortNo">
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit" name="btnSubmit">View Report</button>
            </td>
        </tr>
    </table> 
</form>

<?php
    // Assign all Page Specific variables

    //n
    $pagemaincontent = ob_get_contents();
    ob_end_clean();
    $pagetitle = "Applicant - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
    $navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='applicantAdmin.php'>Applicant</a></li></ul>";
    // Apply the template
    include("master_sms_external.php");
?>
