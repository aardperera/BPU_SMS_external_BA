<?php
    //Buffer larger content areas like the main page content
    ob_start();
    session_start();
    if (!isset($_SESSION['authenticatedUser'])) {
        header("Location: index.php");
        exit; // Stop further execution
    }
    
    // Include necessary files
    include('dbAccess.php');
    $db = new DBOperations();

    // Handling form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['acyear'], $_POST['select'])) {
            $acyear = $_POST['acyear'];
            $select = $_POST['select'];
            // Store selected data in session or process as needed
            $_SESSION['acyear'] = $acyear;
            $_SESSION['select'] = $select;
        }
    }
?>

<h1>Applicant Selection</h1>

<form method="post" action="" name="form1" id="form1" class="plain">  
    <br />
    <table width="230" class="searchResults">
        <tr>
            <td>Academic Year: </td>
            <td>
                <label>
                    <select name="acyear" id="acyear" onChange="document.form1.submit()" class="form-control"> 
                        <?php
                        $sql="SELECT distinct yearEntry FROM crs_enroll ORDER BY yearEntry";
                        $result = $db->executeQuery($sql);
                        while ($row = $db->Next_Record($result)) {
                            $selected = isset($acyear) && $acyear == $row['yearEntry'] ? 'selected' : '';
                            echo '<option value="'.$row['yearEntry'].'" '.$selected.'> '.$row['yearEntry'].' </option>';
                        }
                        ?>
                    </select>
                </label>
            </td>
        </tr>
        <tr>
            <td>Select Criteria:</td>
            <td>
                <select id="select" name="select" onChange="document.form1.submit()">
                    <option value="">Select an option</option>
                    <option value="Selected" <?php echo isset($select) && $select == 'Selected' ? 'selected' : ''; ?>>Selected</option>
                    <option value="Rejected" <?php echo isset($select) && $select == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                    <option value="Pending" <?php echo isset($select) && $select == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                </select>
            </td>
        </tr>
    </table> 
</form>

<?php
    // Check if data is submitted and render Excel button
    if (isset($_SESSION['acyear'], $_SESSION['select'])) {
        echo '<form action="applicantSelectionExcel_BA.php" method="post">
                <input type="hidden" name="acyear" value="'.$_SESSION['acyear'].'">
                <input type="hidden" name="select" value="'.$_SESSION['select'].'">
                <button type="submit">Excel Report</button>
              </form>';
    }
?>

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
