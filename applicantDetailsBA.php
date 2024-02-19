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
    function validate_form(thisform) {
        with (thisform) {
            if (!validate_required(txtStudentID) || !validate_required(txtNameEnglish)) { alert("One or more mandatory fields are kept blank."); return false; }
        }
    }
</script>

<style>
    table,
    th,
    td {
        border: 1px solid #fff;
        padding: 5px;
    }
</style>

<h1>BA Applicant Details</h1>
<?php
include('dbAccess.php');

$db = new DBOperations();

if(isset($_GET['page'])) $pageNum = $_GET['page'];
if(isset($_GET['select'])) $select = $_GET['select'];
if(isset($_GET['acyear'])) $acyear = $_GET['acyear'];

if (isset($_POST['btnSubmit'])) {
    $studentID = $db->cleanInput($_POST['txtStudentID']);
    $selection = $_POST['selection'];

    $pageNum = $db->cleanInput($_POST['pageNum']);
    $select = $db->cleanInput($_POST['select']);
    $acyear = $db->cleanInput($_POST['acyear']);
        
    $c_payment = $db->cleanInput($_POST['c_payment']);
    $stream = $db->cleanInput($_POST['bsls']);
    
    $c_payment_date = $db->cleanInput($_POST['txtCPaymentDate']);
    if ($c_payment_date == '') {
        $c_payment_date = '1970-01-01';
    }
    $selection_date = $db->cleanInput($_POST['txtSelectionDate']);
    if ($selection_date == '') {
        $selection_date = '1970-01-01';
    }
    
        //=======================================================================================================================

        $studentID = $db->cleanInput($_POST['txtStudentID']);
   
        $acyear = $db->cleanInput($_POST['txtacyear']);
        $nic = $db->cleanInput($_POST['txtNic']);
        $passport = $db->cleanInput($_POST['txtPassport']);
        //$acyear = $db->cleanInput($_POST['txtacyear']);
        $title = $_POST['lstTitle'];
        $nameEnglish = $db->cleanInput($_POST['txtNameEnglish']);
        $fullNameEnglish = $db->cleanInput($_POST['txtFullNameEnglish']);
        $initials = $db->cleanInput($_POST['txtInitials']);
        $nameSinhala = $db->cleanInput($_POST['txtNameSinhala']);
        $addressE1 = $db->cleanInput($_POST['txtAddressE1']);
        $addressE2 = $db->cleanInput($_POST['txtAddressE2']);
        $addressE3 = $db->cleanInput($_POST['txtAddressE3']);
        $addressS1 = $db->cleanInput($_POST['txtAddressS1']);
        $addressS2 = $db->cleanInput($_POST['txtAddressS2']);
        $addressS3 = $db->cleanInput($_POST['txtAddressS3']);
    
        $city = $db->cleanInput($_POST['txtCity']);
        $postalcode = $db->cleanInput($_POST['txtPostalCode']);
        $districtstate = $db->cleanInput($_POST['txtDistrict']);
        $country = $db->cleanInput($_POST['txtCountry']);
        $gender = $db->cleanInput($_POST['txtGender']);
    
        //$degree = $db->cleanInput($_POST['txtDegree']);
      
    
      
        $contactNo = $db->cleanInput($_POST['txtContactNo0']);
       
        $email = $db->cleanInput($_POST['txtEmail']);
        $birthday = $db->cleanInput($_POST['txtBirthday']);
        $age = $db->cleanInput($_POST['txtAge']);
        $citizenship = $db->cleanInput($_POST['txtCitizenship']);
        $religion = $db->cleanInput($_POST['txtReligion']);
        $civilStatus = $_POST['txtCivilStatus'];
        $employment = $db->cleanInput($_POST['txtEmployment']);
        $employer = $db->cleanInput($_POST['txtEmployer']);
    
        
       
    
    
        //=========================================================================================================================

        $query = "UPDATE ba_applicant SET selection = '$selection', c_payment='$c_payment', selection_date='$selection_date', c_payment_date='$c_payment_date', stream= '$stream'  WHERE applicantID='$studentID'";
        if (($selection=='Selected') && ($c_payment>'0')){
   
           $query1 = "INSERT INTO student_a SET studentID='$studentID', acyear = '$acyear', nic='$nic', title='$title', nameEnglish='$nameEnglish', nameSinhala='$nameSinhala', addressE1='$addressE1', addressE2='$addressE2', addressE3='$addressE3', addressS1='$addressS1', addressS2='$addressS2', addressS3='$addressS3', contactNo='$contactNo0', email='$email', birthday='$birthday', citizenship='$citizenship', religion='$religion', civilStatus='$civilStatus', employment='$employment', employer='$employer', courseID='" . $_SESSION['courseId'] . "'";
        }
   
       $result = $db->executeQuery($query);
       $result = $db->executeQuery($query1);


    //header("location:applicantAdmin.php?page=$pageNum&select=$select&acyear=$acyear");
}

$studentID = $db->cleanInput($_GET['studentID']);
$query = "SELECT * FROM ba_applicant WHERE applicantID='$studentID'";
//=======


//=====================================
$queryqua = "SELECT * FROM  ba_qualifications WHERE applicantID='$studentID'";
$resultqua = $db->executeQuery($queryqua);
$rowq = $db->Next_Record($resultqua);
//=====

//=====================================
$querysub = "SELECT * FROM  ba_subjects WHERE applicantID='$studentID'";
$resultsub = $db->executeQuery($querysub);
$rowsub = $db->Next_Record($resultsub);
//=====

$result = $db->executeQuery($query);

$row = $db->Next_Record($result);
if ($db->Row_Count($result) > 0) {
?>
<form method="post" action="applicantDetailsBA.php?studentID=<?php echo $studentID; ?>"
    onsubmit="return validate_form(this);" class="plain">
    <table>
        <tr>
            <td></td>
            <td>Applicant ID : </td>
            <td colspan="1"><input name="txtStudentID" type="text" value="<?php echo $row['applicantID']; ?>" readonly />
            </td>
            <td>Academic Year : </td>
            <td colspan="1"><input name="txtacyear" type="text" value="<?php echo $row['acyear']; ?>" readonly /></td>
        </tr>

        <tr>
            <td rowspan="4" style="vertical-align:top;">1.</td>
            <td height="26">Name of Applicant (with initials) : </td>
            <td colspan="3"><input name="txtNameEnglish" type="text" value="<?php echo $row['nameEnglish']; ?>"
                    style="width:500px" readonly /></td>
        </tr>
        <!-- 
        <tr>
            <td>Name (Sinhala) : </td>
            <td><input name="txtNameSinhala" type="text" value="" style="width:500px" /></td>
        </tr>
        -->
        <tr>

            <td>Title : </td>
            <td><select name="lstTitle" disabled>
                    <option value="Ven." <?php if ($row['title'] == 'Ven.')
        echo 'selected'; ?>>Ven.</option>
         <option value="Nun." <?php if ($row['title'] == 'Nun.')
        echo 'selected'; ?>>Nun.</option>
                    <option value="Prof." <?php if ($row['title'] == 'Prof.')
        echo 'selected'; ?>>Prof.</option>
                    <option value="Dr." <?php if ($row['title'] == 'Dr.')
        echo 'selected'; ?>>Dr.</option>
                    <option value="Mr." <?php if ($row['title'] == 'Mr.')
        echo 'selected'; ?>>Mr.</option>
                    <option value="Mrs." <?php if ($row['title'] == 'Mrs.')
        echo 'selected'; ?>>Mrs.</option>
                    <option value="Miss." <?php if ($row['title'] == 'Miss.')
        echo 'selected'; ?>>Miss.</option>
                </select></td>
        </tr>

        <tr>
            <td height="26">Names denoted by initials : </td>
            <td colspan="3"><input name="txtInitials" type="text" value="<?php echo $row['initials']; ?>"
                    style="width:500px" readonly /></td>
        </tr>

        <tr>
            <td height="26">Full Name in English : </td>
            <td colspan="3"><input name="txtFullNameEnglish" type="text" value="<?php echo $row['nameFullEnglish']; ?>"
                    style="width:500px" readonly /></td>
        </tr>

        <tr>
            <td rowspan="2" style="vertical-align:top;">2.</td>
            <td valign="top">Address (Sinhala) : </td>
            <td colspan="3"><input name="txtAddressS1" type="text" value="<?php echo $row['addressS1']; ?>"
                    style="width:500px" readonly />
                <br />
                <input name="txtAddressS2" type="text" value="<?php echo $row['addressS2']; ?>" style="width:500px"
                    readonly />
                <br />
                <input name="txtAddressS3" type="text" value="<?php echo $row['addressS3']; ?>" style="width:500px"
                    readonly />
            </td>
        </tr>

        <tr>
            <td valign="top">Address (English) : </td>
            <td colspan="3"><input name="txtAddressE1" type="text" value="<?php echo $row['addressE1']; ?>"
                    style="width:500px" readonly />
                <br />
                <input name="txtAddressE2" type="text" value="<?php echo $row['addressE2']; ?>" style="width:500px"
                    readonly />
                <br />
                <input name="txtAddressE3" type="text" value="<?php echo $row['addressE3']; ?>" style="width:500px"
                    readonly />
            </td>
        </tr>

        <tr>
            <td>3.</td>
            <td>City : </td>
            <td>
                <input name="txtCity" type="text" value="<?php echo $row['city']; ?>" style="width: 150px;" readonly />
            </td>

            <td>Postal Code : </td>
            <td>
                <input name="txtPostalCode" type="text" value="<?php echo $row['postalcode']; ?>" style="width: 150px;"
                    readonly />
            </td>
        </tr>

        <tr>
            <td>4.</td>
            <td>District/State : </td>
            <td colspan="3"><input name="txtDistrict" type="text" value="<?php echo $row['districtstate']; ?>"
                    readonly /></td>
        </tr>

        <tr>
            <td>5.</td>
            <td>Country : </td>
            <td colspan="3"><input name="txtCountry" type="text" value="<?php echo $row['country']; ?>" readonly /></td>
        </tr>

        <tr>
            <td>6.</td>
            <td>Contact Details : </td>
        </tr>
        <tr>
            <td></td>
            <td>Residence : </td>
            <td>
                <input style="width:50px" id="txtCountryCode0" name="txtCountryCode0" type="text" maxlength="6"
                    value="<?php echo $row['countrycode0']; ?>" required placeholder="+xxxx" readonly />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo0" id="txtContactNo0" type="text" maxlength="10"
                    placeholder="0/123456789" value="<?php echo $row['contactNo0']; ?>" readonly />
                <span class="validity"></span>
            </td>

            <td>Official : </td>
            <td>
                <input style="width:50px" id="txtCountryCode1" name="txtCountryCode1" type="text" maxlength="6"
                    value="<?php echo $row['countrycode1']; ?>" required placeholder="+xxxx" readonly />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo1" id="txtContactNo1" type="text" maxlength="10"
                    placeholder="0/123456789" value="<?php echo $row['contactNo1']; ?>" readonly />
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Mobile : </td>
            <td>
                <input style="width:50px" id="txtCountryCode2" name="txtCountryCode2" type="text" maxlength="6"
                    value="<?php echo $row['countrycode2']; ?>" required placeholder="+xxxx" readonly />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo2" id="txtContactNo2" type="text" maxlength="10"
                    placeholder="0/123456789" value="<?php echo $row['contactNo2']; ?>" readonly />
                <span class="validity"></span>
            </td>

            <td>Whatsapp : </td>
            <td>
                <input style="width:50px" id="txtCountryCode3" name="txtCountryCode3" type="text" maxlength="6"
                    value="<?php echo $row['countrycode3']; ?>" required placeholder="+xxxx" readonly />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo3" id="txtContactNo3" type="text" maxlength="10"
                    placeholder="0/123456789" value="<?php echo $row['contactNo3']; ?>" readonly />
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Email : </td>
            <td colspan="3"><input style="width:500px;" name="txtEmail" type="email"
                    value="<?php echo $row['email']; ?>" readonly /></td>
        </tr>

        <tr>
            <td>7.</td>
            <td>NIC No. : </td>
            <td colspan="3"><input name="txtNic" id="txtNic" type="text" placeholder="123456789V or 123456789012"
                    required maxlength="12" value="<?php echo $row['nic']; ?>" readonly />
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td>8.</td>
            <td>Passport No. : </td>
            <td><input name="txtPassport" type="text" style="width:250px" value="<?php echo $row['passport']; ?>"
                    readonly />
            </td>
        </tr>

        <tr>
            <td>9.</td>
            <td>Birthday : </td>
            <td><input name="txtBirthday" type="text" value="<?php echo $row['birthday']; ?>" readonly /></td>
            <td>Age : </td>
            <td><input name="txtAge" type="number" value="<?php echo $row['age']; ?>" readonly /></td>
        </tr>

        <tr>
            <td>10.</td>
            <td>Gender : </td>
            <td>
                <input name="txtGender" type="radio" value="Male" <?php if ($row['gender'] == 'Male')
        echo 'checked'; ?>
                    readonly disabled/>
                Male &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtGender" type="radio" value="Female" <?php if ($row['gender'] == 'Female')
        echo 'checked'; ?> readonly disabled/> Female
            </td>
        </tr>

        <tr>
            <td>11.</td>
            <td>Civil Status : </td>
            <td><input name="txtCivilStatus" type="text" value="<?php echo $row['civilStatus']; ?>" style="width:300px"
                    readonly /></td>
        </tr>

        <tr>
            <td>12.</td>
            <td>Citizenship : </td>
            <td><input name="txtCitizenship" type="text" value="<?php echo $row['citizenship']; ?>" style="width:300px"
                    readonly /></td>
        </tr>

        <tr>
            <td>13.</td>
            <td>Religion : </td>
            <td><input name="txtReligion" type="text" value="<?php echo $row['religion']; ?>" style="width:300px"
                    readonly />
            </td>
        </tr>

        <tr>
            <td>14.</td>
            <td>Occupation : </td>
            <td><input name="txtEmployment" type="text" value="<?php echo $row['employment']; ?>" style="width:300px"
                    readonly />
            </td>
        </tr>

        <tr>
            <td>15.</td>
            <td>Place of the Work : </td>
            <td colspan="3"><input name="txtEmployer" type="text" value="<?php echo $row['employer']; ?>"
                    style="width:500px;" readonly /></td>
        </tr>


        <tr>
            <td>16.</td>
            <td>Medium of Study : </td>
            <td>
                <input name="txtMedium" type="radio" value="Sinhala" <?php if ($row['medium'] == 'Sinhala')
        echo 'checked'; ?> readonly disabled /> Sinhala &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                <input name="txtMedium" type="radio" value="English" <?php if ($row['medium'] == 'English')
        echo 'checked'; ?> readonly disabled/> English &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;
                <input name="txtMedium" type="radio" value="Other" <?php if ($row['medium'] == 'Sinhala' || $row['medium'] == 'English') echo ''; else echo 'checked'; ?> readonly disabled/>
                Other
            </td>
            <td>
                <p id="text" style="display:<?php if ($row['medium'] == 'Sinhala' || $row['medium'] == 'English') echo 'none'; else echo 'block'; ?>" >
                    <input name="txtOther" id="txtOther" type="text" value="<?php echo $row['medium']; ?>" />
                </p>
            </td>
        </tr>

        <tr>
            <td>17.</td>
            <td>Field of Study : </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4">
                <input name="txtField" type="radio" value="Buddhist Studies" <?php if ($row['field'] == 'Buddhist Studies')
        echo 'checked'; ?> readonly disabled/> Buddhist Studies &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Languages Studies" <?php if ($row['field'] == 'Languages Studies')
        echo 'checked'; ?> readonly disabled/> Languages Studies &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
               
            </td>
        </tr>

        <tr>
            <td>18.</td>
            <td>Subjects : </td>
        </tr>

        <tr> 
      <td></td>
      <td>
	  <table border="0">
		<tr>
        <td>1.</td><td>Main Subjects</td> <td> </td></tr><tr>
		<td></td><td>Buddist Philosophy</td> <td><input name="txtbp" type="checkbox" value="1" <?php if ($rowsub['bp'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
		<tr>
		<td></td><td>Buddist Culture</td> <td><input name="txtbc" type="checkbox" value="1" <?php if ($rowsub['bc'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Pali</td> <td><input name="txtpali" type="checkbox" value="1" <?php if ($rowsub['pali'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Sanskrit</td> <td><input name="txtsan" type="checkbox" value="1" <?php if ($rowsub['san'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>English</td> <td><input name="txteng" type="checkbox" value="1" <?php if ($rowsub['eng'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Archaeology</td> <td><input name="txtarch" type="checkbox" value="1" <?php if ($rowsub['arch'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Religious Study</td> <td><input name="txtrs" type="checkbox" value="1" <?php if ($rowsub['rs'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Sinhala</td> <td><input name="txtsin" type="checkbox" value="1" <?php if ($rowsub['sin'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Tamil</td> <td><input name="txtctamil" type="checkbox" value="1" <?php if ($rowsub['ctamil'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td>2.</td><td>Elective Subjects</td> <td> </td>
		</tr>
		<tr>
		<td></td><td>Sinhala</td> <td><input name="txtesin" type="checkbox" value="1" <?php if ($rowsub['esin'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Buddist Councelling</td> <td><input name="txtbcon" type="checkbox" value="1" <?php if ($rowsub['bcon'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Tamil</td> <td><input name="txttamil" type="checkbox" value="1" <?php if ($rowsub['tamil'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        
		</td>
		</tr>
	  </table>
      <tr>
            <td>18.</td>
            <td>Qualification : </td>
        </tr>

        <tr> 
      <td></td>
      <td>
	  <table border="0">
		<tr>
		<td>1.</td><td>O/L</td> <td><input name="txtol" type="checkbox" value="1" <?php if ($rowq['OL'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
		<tr>
		<td>2.</td><td>A/L</td> <td><input name="txtal" type="checkbox" value="1" <?php if ($rowq['AL'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td>3.</td><td>Higher Diploma</td> <td> </td>
		</tr>
		<tr>
		<td></td><td>English</td> <td><input name="txtdiplomaE" type="checkbox" value="1" <?php if ($rowq['HDEnglish'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Buddhisum</td> <td><input name="txtdiplomaB" type="checkbox" value="1" <?php if ($rowq['HDBud'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Pali</td> <td><input name="txtdiplomaP" type="checkbox" value="1" <?php if ($rowq['HDPali'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Sanskrit</td> <td><input name="txtdiplomaS" type="checkbox" value="1" <?php if ($rowq['HDSans'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>DahamSarasawiya</td> <td><input name="txtdiplomaD" type="checkbox" value="1" <?php if ($rowq['HDDaham'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td></td><td>Tamil</td> <td><input name="txtdiplomaT" type="checkbox" value="1" <?php if ($rowq['HDTamil'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
		<tr>
		<td>4.</td><td>Dharmacharya</td> <td><input name="txtdharma" type="checkbox" value="1" <?php if ($rowq['Darmacharya'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
		<tr>
		<td>5.</td><td>Prachina</td> <td> </td>
		</tr>
		<tr>
		<td> </td><td>Prachina Maddhyam</td> <td><input name="txtpraM" type="checkbox" value="1" <?php if ($rowq['PrachinaM'] == '1') echo 'checked'; ?> readonly disabled/></td>
		</tr>
		<tr>
		<td> </td><td>Prachina Praramba</td> <td><input name="txtpraP" type="checkbox" value="1" <?php if ($rowq['PrachinaP'] == '1') echo 'checked'; ?> readonly disabled/></td>
		</tr>
        <tr>
		<td>6.</td><td>Degree</td> <td><input name="txtdegree" type="checkbox" value="1" <?php if ($rowq['Degree'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        <tr>
		<td>7.</td><td>Common Test</td> <td><input name="txtctest" type="checkbox" value="1" <?php if ($rowq['Ctest'] == '1') echo 'checked'; ?> readonly disabled/> </td>
		</tr>
        
		</td>
		</tr>
	  </table>

        <tr>
            <td>20. </td>
        </tr>

        <tr>
            <td></td>
            <td>Attached certificate : </td>
            <td>
                <input type="checkbox" id="certificate" name="certificate" value="Yes" <?php if ($row['certificate'] == 'Yes')
        echo 'checked'; ?> readonly disabled/>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Attached photos : </td>
            <td>
                <input type="checkbox" id="photos" name="photos" value="Yes" <?php if ($row['photos'] == 'Yes')
                                                                                       echo 'checked'; ?> readonly disabled/>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Affiliate : </td>
            <td>
                <input type="checkbox" id="affiliate" name="affiliate" value="Yes" <?php if ($row['affiliate'] == 'Yes') echo 'checked'; ?> readonly disabled />
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Application Payment :</td>
            <td>
                <input id="payment" name="payment" type="number" min="0" max="999999"
                    value="<?php echo $row['payment']; ?>" required readonly />
            </td>
        </tr>
        <tr>
            <td>
                <input name="pageNum" id="pageNum" type="number" value="<?php echo $pageNum;?>" hidden/>
            </td>
            <td>
                <input name="select" id="select" type="text" value="<?php echo $select;?>" hidden/>
            </td>
            <td>
                <input name="acyear" id="acyear" type="number" value="<?php echo $acyear;?>" hidden/>
            </td>
        </tr>
    </table>

    </br>
    <hr>
    <table>
        
        <tr>
            <td></td>
            <td>Selected : </td>
            <td>
                <select id="selection" name="selection" required>
                    <option disabled selected                                                                >Select Decision</option>
                    <option value="Selected"  <?php if ($row['selection'] == 'Selected') echo 'selected'; ?> >Selected</option>
                    <option value="Rejected"  <?php if ($row['selection'] == 'Rejected') echo 'selected'; ?> >Rejected</option>
                    <option value="Reviewed"  <?php if ($row['selection'] == 'Reviewed') echo 'selected'; ?> >Reviewed</option>
                    <option value="Pending"   <?php if ($row['selection'] == 'Pending')  echo 'selected'; ?> >Pending</option>
                    <option value="Cancel"                                                                   >Cancel</option>
                </select>
            </td>
            <td align="right">
                Date : 
            </td>
            <td>
                <input name="txtSelectionDate" id="txtSelectionDate" type="text" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" readonly value="<?php  echo $row['selection_date'] ? $row['selection_date'] : date("Y-m-d"); ?>" />
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Course Payment :</td>
            <td>
                <input id="c_payment" name="c_payment" type="number" min="0" max="999999" value="<?php echo $row['c_payment']; ?>" />
            </td>
            <td align="right">
                Date : 
            </td>
            <td>
                <input name="txtCPaymentDate" id="txtCPaymentDate" type="text" onclick="scwShow(this,event);" onfocus="scwShow(this,event);" readonly value="<?php echo $row['c_payment_date'] ? $row['c_payment_date'] : date("Y-m-d"); ?>" />
            </td>
        </tr>
        <tr>
            <td></td>
            <td>BS/LS : </td>
            <td>
                <select id="bsls" name="bsls" required>
                    <option disabled selected                                                                >Select LS/BS</option>
                    <option value="Selected"  <?php if ($row['stream'] == 'LS') echo 'LS'; ?> >LS</option>
                    <option value="Rejected"  <?php if ($row['stream'] == 'Rejected') echo 'BS'; ?> >BS</option>
                    
                </select>
            </td>
            
        </tr>
    </table>

    <br /><br />
    <input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'applicantAdmin.php?page=<?php if(isset($_GET['page'])) echo $pageNum;?>&select=<?php if(isset($_GET['select'])) echo $select?>&acyear=<?php if(isset($_GET['acyear'])) echo $acyear?>';"
            class="button" style="width:60px;" />&nbsp;&nbsp;&nbsp;
    <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" />
</form>


<?php
}
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Details of Applicant - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='applicantAdmin.php'>Applicants </a></li><li>Details of Applicant</li></ul>";
//Apply the template
include("master_sms_external.php");
?>