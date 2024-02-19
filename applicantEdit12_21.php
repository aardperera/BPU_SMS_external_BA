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

<h1>Applicant Edit</h1>
<?php
include('dbAccess.php');

$db = new DBOperations();

if (isset($_POST['btnSubmit'])) {
    $studentID = $db->cleanInput($_POST['txtStudentID']);
    $acyear = $db->cleanInput($_POST['txtacyear']);
    $nic = $db->cleanInput($_POST['txtNic']);
    $passport = $db->cleanInput($_POST['txtPassport']);
    //$acyear = $db->cleanInput($_POST['txtacyear']);
    $title = $_POST['lstTitle'];
    $nameEnglish = $db->cleanInput($_POST['txtNameEnglish']);
    $fullNameEnglish = $db->cleanInput($_POST['txtFullNameEnglish']);
    $initials = $db->cleanInput($_POST['txtInitials']);
    //$nameSinhala = $db->cleanInput($_POST['txtNameSinhala']);
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

    $degree = $db->cleanInput($_POST['txtDegree']);
    $medium = $db->cleanInput($_POST['txtMedium']);
    $field = $db->cleanInput($_POST['txtField']);

    $countryCode0 = $db->cleanInput($_POST['txtCountryCode0']);
    $countryCode1 = $db->cleanInput($_POST['txtCountryCode1']);
    $countryCode2 = $db->cleanInput($_POST['txtCountryCode2']);
    $countryCode3 = $db->cleanInput($_POST['txtCountryCode3']);

    $contactNo0 = $db->cleanInput($_POST['txtContactNo0']);
    $contactNo1 = $db->cleanInput($_POST['txtContactNo1']);
    $contactNo2 = $db->cleanInput($_POST['txtContactNo2']);
    $contactNo3 = $db->cleanInput($_POST['txtContactNo3']);
    $email = $db->cleanInput($_POST['txtEmail']);
    $birthday = $db->cleanInput($_POST['txtBirthday']);
    $age = $db->cleanInput($_POST['txtAge']);
    $citizenship = $db->cleanInput($_POST['txtCitizenship']);
    $religion = $db->cleanInput($_POST['txtReligion']);
    $civilStatus = $_POST['txtCivilStatus'];
    $employment = $db->cleanInput($_POST['txtEmployment']);
    $employer = $db->cleanInput($_POST['txtEmployer']);

    //Details of Qualification
    $ol = $_POST['txtol'];
    $al = $_POST['txtal'];
    $diploma = $_POST['txtdiploma'];
    $higher_Diploma = $_POST['txthigher_Diploma'];
    $First_Degree = $_POST['txtFirst_Degree'];
    $Post_One_Year = $_POST['txtPost_One_Year'];
    $Post_Two_Year = $_POST['txtPost_Two_Year'];
    $others = $_POST['txtothers'];
    //$courseID = $_POST['courseID'];

    $certificate = $_POST['certificate'];
    $photos = $_POST['photos'];
    $payment = $db->cleanInput($_POST['payment']);

    //print $_SESSION['courseID'];

    if ($birthday == '') {
        $birthday = '1970-01-01';
    }

    $query = "UPDATE ma_applicant SET acyear = '$acyear', nic='$nic', passport='$passport', title='$title', nameEnglish='$nameEnglish', initials = '$initials', nameFullEnglish = '$fullNameEnglish', addressE1='$addressE1', addressE2='$addressE2', addressE3='$addressE3', addressS1='$addressS1', addressS2='$addressS2', addressS3='$addressS3', city = '$city', postalcode = '$postalcode', districtstate = '$districtstate', country='$country', gender = '$gender', countrycode0='$countryCode0', countrycode1='$countryCode1', countrycode2='$countryCode2', countrycode3='$countryCode3', contactNo0='$contactNo0', contactNo1='$contactNo1', contactNo2='$contactNo2', contactNo3='$contactNo3', email='$email', birthday='$birthday', age='$age', citizenship='$citizenship', religion='$religion', civilStatus='$civilStatus', employment='$employment', employer='$employer', degree = '$degree', medium='$medium', field='$field', certificate='$certificate', photos='$photos', payment='$payment' WHERE studentID='$studentID'";
    $result = $db->executeQuery($query);

    //print $query;

    $query1 = "UPDATE stu_qualification SET OL='$ol',AL='$al',Diploma='$diploma',HigherDiploma='$higher_Diploma',FirsDegree='$First_Degree',Post_OneYear='$Post_One_Year',Post_TwoYears='$Post_Two_Year',Others='$others' where studentID='$studentID'";
    $result1 = $db->executeQuery($query1);

    header("location:applicantAdmin.php");
}

$studentID = $db->cleanInput($_GET['studentID']);
$query = "SELECT * FROM ma_applicant WHERE studentID='$studentID'";
//=======


//=====================================
$queryqua = "SELECT * FROM  stu_qualification WHERE studentID='$studentID'";
$resultqua = $db->executeQuery($queryqua);

$rowqua = $db->Next_Record($resultqua);








//=====

$result = $db->executeQuery($query);

$row = $db->Next_Record($result);
if ($db->Row_Count($result) > 0) {
?>
<form method="post" action="applicantEdit.php?studentID=<?php echo $studentID; ?>"
    onsubmit="return validate_form(this);" class="plain">
    <table>
        <tr>
            <td></td>
            <td>Student ID : </td>
            <td colspan="1"><input name="txtStudentID" type="text" value="<?php echo $row['studentID']; ?>" maxlength="20" readonly /></td>
            <td>Academic Year : </td>
            <td colspan="1"><input name="txtacyear" type="number" value="<?php echo $row['acyear']; ?>" max="2100" min="2000" required/></td>
        </tr>

        <tr>
            <td rowspan="4" style="vertical-align:top;">1.</td>
            <td height="26">Name of Applicant (with initials) : </td>
            <td colspan="3"><input name="txtNameEnglish" type="text" value="<?php echo $row['nameEnglish']; ?>"
                    style="width:500px" maxlength="100"/></td>
        </tr>
        <!-- 
        <tr>
            <td>Name (Sinhala) : </td>
            <td><input name="txtNameSinhala" type="text" value="" style="width:500px" /></td>
        </tr>
        -->
        <tr>

            <td>Title : </td>
            <td><select name="lstTitle" required>
                    <option value="Ven." <?php if ($row['title'] == 'Ven.')
        echo 'selected'; ?>>Ven.</option>
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
            <td colspan="3"><input name="txtInitials" type="text" value="<?php echo $row['initials']; ?>" maxlength="200" style="width:500px" required/></td>
        </tr>

        <tr>
            <td height="26">Full Name in English : </td>
            <td colspan="3"><input name="txtFullNameEnglish" type="text" value="<?php echo $row['nameFullEnglish']; ?>" maxlength="400" style="width:500px" required/></td>
        </tr>

        <tr>
            <td rowspan="2" style="vertical-align:top;">2.</td>
            <td valign="top">Address (Sinhala) : </td>
            <td colspan="3"><input name="txtAddressS1" type="text" value="<?php echo $row['addressS1']; ?>" maxlength="200" style="width:500px" required/>
                <br />
                <input name="txtAddressS2" type="text" value="<?php echo $row['addressS2']; ?>" maxlength="200" style="width:500px" />
                <br />
                <input name="txtAddressS3" type="text" value="<?php echo $row['addressS3']; ?>" maxlength="200" style="width:500px" />
            </td>
        </tr>

        <tr>
            <td valign="top">Address (English) : </td>
            <td colspan="3"><input name="txtAddressE1" type="text" value="<?php echo $row['addressE1']; ?>" maxlength="200" style="width:500px" required/>
                <br />
                <input name="txtAddressE2" type="text" value="<?php echo $row['addressE2']; ?>" maxlength="200" style="width:500px" />
                <br />
                <input name="txtAddressE3" type="text" value="<?php echo $row['addressE3']; ?>" maxlength="200" style="width:500px" />
            </td>
        </tr>

        <tr>
            <td>3.</td>
            <td>City : </td>
            <td>
                <input name="txtCity" type="text" value="<?php echo $row['city']; ?>" maxlength="150" style="width: 150px;" required/>
            </td>

            <td>Postal Code : </td>
            <td>
                <input name="txtPostalCode" type="text" value="<?php echo $row['postalcode']; ?>" maxlength="6" style="width: 150px;" required/>
            </td>
        </tr>

        <tr>
            <td>4.</td>
            <td>District/State : </td>
            <td colspan="3"><input name="txtDistrict" type="text" value="<?php echo $row['districtstate']; ?>" maxlength="100" required/></td>
        </tr>

        <tr>
            <td>5.</td>
            <td>Country : </td>
            <td colspan="3"><input name="txtCountry" type="text" value="<?php echo $row['country']; ?>" maxlength="100" required/></td>
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
                    oninput="this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1'); verifycontrycode(this.value, 'txtCountryCode0');"
                    value="<?php echo $row['countrycode0']; ?>" required placeholder="+xxxx" />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo0" id="txtContactNo0" type="text" maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); verifyconatct(this.value,'txtContactNo0');"
                    placeholder="0/123456789" value="<?php echo $row['contactNo0']; ?>" />
                <span class="validity"></span>
            </td>

            <td>Official : </td>
            <td>
                <input style="width:50px" id="txtCountryCode1" name="txtCountryCode1" type="text" maxlength="6"
                    oninput="this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1'); verifycontrycode(this.value, 'txtCountryCode1');"
                    value="<?php echo $row['countrycode1']; ?>" required placeholder="+xxxx" />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo1" id="txtContactNo1" type="text" maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); verifyconatct(this.value, 'txtContactNo1');"
                    placeholder="0/123456789" value="<?php echo $row['contactNo1']; ?>" />
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Mobile : </td>
            <td>
                <input style="width:50px" id="txtCountryCode2" name="txtCountryCode2" type="text" maxlength="6"
                    oninput="this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1'); verifycontrycode(this.value, 'txtCountryCode2');"
                    value="<?php echo $row['countrycode2']; ?>" required placeholder="+xxxx" />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo2" id="txtContactNo2" type="text" maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); verifyconatct(this.value, 'txtContactNo2');"
                    placeholder="0/123456789" value="<?php echo $row['contactNo2']; ?>" />
                <span class="validity"></span>
            </td>

            <td>Whatsapp : </td>
            <td>
                <input style="width:50px" id="txtCountryCode3" name="txtCountryCode3" type="text" maxlength="6"
                    oninput="this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1'); verifycontrycode(this.value, 'txtCountryCode3');"
                    value="<?php echo $row['countrycode3']; ?>" required placeholder="+xxxx" />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo3" id="txtContactNo3" type="text" maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); verifyconatct(this.value, 'txtContactNo3');"
                    placeholder="0/123456789" value="<?php echo $row['contactNo3']; ?>" />
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Email : </td>
            <td colspan="3"><input style="width:500px;" name="txtEmail" type="email" value="<?php echo $row['email']; ?>" maxlength="60" required/></td>
        </tr>

        <tr>
            <td>7.</td>
            <td>NIC No. : </td>
            <td colspan="3"><input name="txtNic" id="txtNic" type="text" placeholder="123456789V or 123456789012"
                    oninput="this.value = this.value.replace(/[^0-9V]/g, '').replace(/(\..*)\./g, '$1'); verifynic(this.value);"
                    required maxlength="12" value="<?php echo $row['nic']; ?>" />
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td>8.</td>
            <td>Passport No. : </td>
            <td><input name="txtPassport" type="text" style="width:250px" value="<?php echo $row['passport']; ?>" maxlength="150" required/>
            </td>
        </tr>

        <tr>
            <td>9.</td>
            <td>Birthday : </td>
            <td><input name="txtBirthday" type="text" value="<?php echo $row['birthday']; ?>"
                    onclick="scwShow(this,event);" onfocus="scwShow(this,event);" readonly required/></td>
            <td>Age : </td>
            <td><input name="txtAge" type="number" value="<?php echo $row['age']; ?>" min="18" max="120" required/></td>
        </tr>

        <tr>
            <td>10.</td>
            <td>Gender : </td>
            <td>
                <input name="txtGender" type="radio" value="Male" <?php if ($row['gender'] == 'Male')
        echo 'checked'; ?>>
                Male &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtGender" type="radio" value="Female" <?php if ($row['gender'] == 'Female')
        echo 'checked'; ?>> Female
            </td>
        </tr>

        <tr>
            <td>11.</td>
            <td>Civil Status : </td>
            <td><input name="txtCivilStatus" type="text" value="<?php echo $row['civilStatus']; ?>" maxlength="20" style="width:300px" required/></td>
        </tr>

        <tr>
            <td>12.</td>
            <td>Citizenship : </td>
            <td><input name="txtCitizenship" type="text" value="<?php echo $row['citizenship']; ?>" maxlength="20" style="width:300px" required/></td>
        </tr>

        <tr>
            <td>13.</td>
            <td>Religion : </td>
            <td><input name="txtReligion" type="text" value="<?php echo $row['religion']; ?>" maxlength="20" style="width:300px" required/>
            </td>
        </tr>

        <tr>
            <td>14.</td>
            <td>Occupation : </td>
            <td><input name="txtEmployment" type="text" value="<?php echo $row['employment']; ?>" maxlength="20" style="width:300px" required/>
            </td>
        </tr>

        <tr>
            <td>15.</td>
            <td>Place of the Work : </td>
            <td colspan="3"><input name="txtEmployer" type="text" value="<?php echo $row['employer']; ?>" maxlength="50" style="width:500px;" required/></td>
        </tr>

        <tr>
            <td>16.</td>
            <td>Intended Degree Programme : </td>
            <td>
            <input name="txtDegree" type="radio" value="P.G.D. - Buddhist Studies" <?php if ($row['degree'] == 'P.G.D. - Buddhist Studies')
        echo 'checked'; ?> /> P.G.D. - Buddhist Studies &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                
                <input name="txtDegree" type="radio" value="M.A. (One Year)" <?php if ($row['degree'] == 'M.A. (One Year)')
        echo 'checked'; ?> /> M.A. (One Year) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                <input name="txtDegree" type="radio" value="M.A. (Two Year)" <?php if ($row['degree'] == 'M.A. (Two Year)')
        echo 'checked'; ?> /> M.A. (Two Year)
            </td>
        </tr>

        <tr>
            <td>17.</td>
            <td>Medium of Study : </td>
            <td>
                <input name="txtMedium" type="radio" value="Sinhala" <?php if ($row['medium'] == 'Sinhala')
        echo 'checked'; ?>> Sinhala &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtMedium" type="radio" value="English" <?php if ($row['medium'] == 'English')
        echo 'checked'; ?>> English &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtMedium" type="radio" value="Other" <?php if ($row['medium'] == 'Other')
        echo 'checked'; ?>>
                Other
            </td>
        </tr>

        <tr>
            <td>18.</td>
            <td>Field of Study : </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4">
                <input name="txtField" type="radio" value="Buddhist Studies" <?php if ($row['field'] == 'Buddhist Studies')
        echo 'checked'; ?>> Buddhist Studies &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Sanskrit" <?php if ($row['field'] == 'Sanskrit')
        echo 'checked'; ?>> Sanskrit &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Pali" <?php if ($row['field'] == 'Pali')
        echo 'checked'; ?>>
                Pali &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Sinhala" <?php if ($row['field'] == 'Sinhala')
        echo 'checked'; ?>> Sinhala &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="English" <?php if ($row['field'] == 'English')
        echo 'checked'; ?>> English
            </td>
        </tr>

        <tr>
            <td>19.</td>
            <td>Qualification : </td>
            <td>

        <tr>
            <td></td>
            <td>1. O/L</td>
            <td><input name="txtol" type="checkbox" value="YES" <?php if ($row['OL'] == 'YES')
        echo 'checked'; ?> /> </td>
        </tr>
        <tr>
            <td></td>
            <td>2. A/L</td>
            <td><input name="txtal" type="checkbox" value="YES" <?php if ($row['AL'] == 'YES')
        echo 'checked'; ?> /> </td>
        </tr>
        <tr>
            <td></td>
            <td>3. Diploma</td>
            <td><input name="txtdiploma" type="checkbox" value="YES" <?php if ($row['Diploma'] == 'YES')
        echo 'checked'; ?> /> </td>
        </tr>
        <tr>
            <td></td>
            <td>4. Higher Diploma</td>
            <td><input name="txthigher_Diploma" type="checkbox" value="YES" <?php if ($row['HigherDiploma'] == 'YES')
        echo 'checked'; ?> /> </td>
        </tr>
        <tr>
            <td></td>
            <td>5. First Degree</td>
            <td><input name="txtFirst_Degree" type="checkbox" value="YES" <?php if ($row['FirsDegree'] == 'YES')
        echo 'checked'; ?> /> </td>
        </tr>
        <tr>
            <td></td>
            <td>6. Postgraduate</td>
            <td> </td>
        </tr>
        <tr>
            <td> </td>
            <td>One Year </td>
            <td><input name="txtPost_One_Year" type="checkbox" value="YES" <?php if ($row['Post_OneYear'] == 'YES')
        echo 'checked'; ?> /></td>
        </tr>
        <tr>
            <td> </td>
            <td>Two Years</td>
            <td><input name="txtPost_Two_Year" type="checkbox" value="YES" <?php if ($row['Post_TwoYears'] == 'YES')
        echo 'checked'; ?> /></td>
        </tr>
        <tr>
            <td></td>
            <td>7. Others : </td>
            <td><input type="checkbox" id="myCheck" onclick="myFunction()" value="<?php echo $row['Others']; ?>"></td>
        </tr>

        <tr>
            <td>20. </td>
        </tr>

        <tr>
            <td></td>
            <td>Attached certificate : </td>
            <td>
                <input type="checkbox" id="certificate" name="certificate" value="Yes" <?php if ($row['certificate'] == 'Yes')
        echo 'checked'; ?>>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Attached photos : </td>
            <td>
                <input type="checkbox" id="photos" name="photos" value="Yes" <?php if ($row['photos'] == 'Yes')
        echo 'checked'; ?>>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Payment :</td>
            <td>
                <input id="payment" name="payment" type="number" min="0" max="999999"
                    value="<?php echo $row['payment']; ?>" required />
            </td>
        </tr>
    </table>



    <?php if ($rowqua['Others'] != "") { ?>

    <p id="text">
        <textarea rows="4" cols="50" name="txtothers" type="text"> <?php echo $rowqua['Others'] ?>

			</textarea>

    </p>
    <?php } else { ?>
    <p id="text" style="display:none">
        <textarea rows="4" cols="50" name="txtothers" type="text"> <?php echo $rowqua['Others'] ?>

			</textarea>

    </p>
    <?php } ?>
    <script>
        function myFunction() {
            var checkBox = document.getElementById("myCheck");
            var text = document.getElementById("text");
            if (checkBox.checked == true) {
                text.style.display = "block";
            } else {
                text.style.display = "none";
            }
        }
    </script>


    </table>
    <br /><br />
    <p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'applicantAdmin.php';"
            class="button" style="width:60px;" />&nbsp;&nbsp;&nbsp;
        <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" />
    </p>
</form>

<script>
    function verifyconatct(value,id) {
        var val = document.getElementById(id).value;
        if (val.length == 9 && val.charAt(0) != "0") {
            document.getElementById(id).setCustomValidity("");
        } else if (val.length == 10 && val.charAt(0) == "0") {
            document.getElementById(id).setCustomValidity("");
        }
        else {
            console.log("wrong contact");
            //document.getElementById("txtContactNo").value = "";
            document.getElementById(id).setCustomValidity("Invalid field");
        }
    }
</script>

<script>
    function verifynic(value) {
        var val = document.getElementById("txtNic").value;
        if (val.match(/[V]/g) == "V" && val.charAt(9) == "V" && val.length == 10) {
            document.getElementById("txtNic").setCustomValidity("");
        }
        else if (val.match(/[V]/g) == null && val.length == 12) {
            document.getElementById("txtNic").setCustomValidity("");
        }
        else {
            console.log("wrong nic");
            //document.getElementById("txtNic").value = "";
            document.getElementById("txtNic").setCustomValidity("Invalid field");
        }
    }
</script>

<script>
    function verifycontrycode(value, id) {
        var val = document.getElementById(id).value;
        if (val.charAt(0) == "+" && val.length > 1) {
            document.getElementById(id).setCustomValidity("");
        }
        else {
            console.log("wrong country code");
            //document.getElementById("txtCountryCode").value = "";
            document.getElementById(id).setCustomValidity("Invalid field");
        }
    }
</script>

<script>
    function verifydate(value, id) {
        var val = document.getElementById(id).value;
        if (val.charAt(4) == "-" && val.charAt(7) == "-" && val.length == 10) {
            document.getElementById(id).setCustomValidity("");
        }
        else {
            console.log("wrong date");
            //document.getElementById("txtCountryCode").value = "";
            document.getElementById(id).setCustomValidity("Invalid field");
        }
    }
</script>

<?php
}
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Edit Applicant - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='applicantAdmin.php'>Applicants </a></li><li>Edit Applicant</li></ul>";
//Apply the template
include("master_sms_external.php");
?>