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

<h1>Applicant Details</h1>
<?php
include('dbAccess.php');

$db = new DBOperations();



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
            <td colspan="1"><input name="txtStudentID" type="text" value="<?php echo $row['studentID']; ?>" readonly/></td>
            <td>Academic Year : </td>
            <td colspan="1"><input name="txtacyear" type="text" value="<?php echo $row['acyear']; ?>" readonly/></td>
        </tr>

        <tr>
            <td rowspan="4" style="vertical-align:top;">1.</td>
            <td height="26">Name of Applicant (with initials) : </td>
            <td colspan="3"><input name="txtNameEnglish" type="text" value="<?php echo $row['nameEnglish']; ?>" style="width:500px" readonly/></td>
        </tr>
        <!-- 
        <tr>
            <td>Name (Sinhala) : </td>
            <td><input name="txtNameSinhala" type="text" value="" style="width:500px" /></td>
        </tr>
        -->
        <tr>

            <td>Title : </td>
            <td><select name="lstTitle">
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
            <td colspan="3"><input name="txtInitials" type="text" value="<?php echo $row['initials']; ?>"
                    style="width:500px" readonly/></td>
        </tr>

        <tr>
            <td height="26">Full Name in English : </td>
            <td colspan="3"><input name="txtFullNameEnglish" type="text" value="<?php echo $row['nameFullEnglish']; ?>"
                    style="width:500px" readonly/></td>
        </tr>

        <tr>
            <td rowspan="2" style="vertical-align:top;">2.</td>
            <td valign="top">Address (Sinhala) : </td>
            <td colspan="3"><input name="txtAddressS1" type="text" value="<?php echo $row['addressS1']; ?>"
                    style="width:500px" readonly/>
                <br />
                <input name="txtAddressS2" type="text" value="<?php echo $row['addressS2']; ?>" style="width:500px" readonly/>
                <br />
                <input name="txtAddressS3" type="text" value="<?php echo $row['addressS3']; ?>" style="width:500px" readonly/>
            </td>
        </tr>

        <tr>
            <td valign="top">Address (English) : </td>
            <td colspan="3"><input name="txtAddressE1" type="text" value="<?php echo $row['addressE1']; ?>"
                    style="width:500px" readonly/>
                <br />
                <input name="txtAddressE2" type="text" value="<?php echo $row['addressE2']; ?>" style="width:500px" readonly/>
                <br />
                <input name="txtAddressE3" type="text" value="<?php echo $row['addressE3']; ?>" style="width:500px" readonly/>
            </td>
        </tr>

        <tr>
            <td>3.</td>
            <td>City : </td>
            <td>
                <input name="txtCity" type="text" value="<?php echo $row['city']; ?>" style="width: 150px;" readonly/>
            </td>

            <td>Postal Code : </td>
            <td>
                <input name="txtPostalCode" type="text" value="<?php echo $row['postalcode']; ?>"
                    style="width: 150px;" readonly/>
            </td>
        </tr>

        <tr>
            <td>4.</td>
            <td>District/State : </td>
            <td colspan="3"><input name="txtDistrict" type="text" value="<?php echo $row['districtstate']; ?>" readonly/></td>
        </tr>

        <tr>
            <td>5.</td>
            <td>Country : </td>
            <td colspan="3"><input name="txtCountry" type="text" value="<?php echo $row['country']; ?>" readonly/></td>
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
                    value="<?php echo $row['countrycode0']; ?>" required placeholder="+xxxx" readonly/>
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo0" id="txtContactNo0" type="text" maxlength="10"
                    placeholder="0/123456789" value="<?php echo $row['contactNo0']; ?>" readonly/>
                <span class="validity"></span>
            </td>

            <td>Official : </td>
            <td>
                <input style="width:50px" id="txtCountryCode1" name="txtCountryCode1" type="text" maxlength="6"
                    value="<?php echo $row['countrycode1']; ?>" required placeholder="+xxxx" readonly/>
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo1" id="txtContactNo1" type="text" maxlength="10"
                    placeholder="0/123456789" value="<?php echo $row['contactNo1']; ?>" readonly/>
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Mobile : </td>
            <td>
                <input style="width:50px" id="txtCountryCode2" name="txtCountryCode2" type="text" maxlength="6"
                    value="<?php echo $row['countrycode2']; ?>" required placeholder="+xxxx" readonly/>
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo2" id="txtContactNo2" type="text" maxlength="10"
                    placeholder="0/123456789" value="<?php echo $row['contactNo2']; ?>" readonly/>
                <span class="validity"></span>
            </td>

            <td>Whatsapp : </td>
            <td>
                <input style="width:50px" id="txtCountryCode3" name="txtCountryCode3" type="text" maxlength="6"
                    value="<?php echo $row['countrycode3']; ?>" required placeholder="+xxxx" readonly/>
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo3" id="txtContactNo3" type="text" maxlength="10"
                    placeholder="0/123456789" value="<?php echo $row['contactNo3']; ?>" readonly/>
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Email : </td>
            <td colspan="3"><input style="width:500px;" name="txtEmail" type="email"
                    value="<?php echo $row['email']; ?>" readonly/></td>
        </tr>

        <tr>
            <td>7.</td>
            <td>NIC No. : </td>
            <td colspan="3"><input name="txtNic" id="txtNic" type="text" placeholder="123456789V or 123456789012"
                    required maxlength="12" value="<?php echo $row['nic']; ?>" readonly/>
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td>8.</td>
            <td>Passport No. : </td>
            <td><input name="txtPassport" type="text" style="width:250px" value="<?php echo $row['passport']; ?>" readonly/>
            </td>
        </tr>

        <tr>
            <td>9.</td>
            <td>Birthday : </td>
            <td><input name="txtBirthday" type="text" value="<?php echo $row['birthday']; ?>"
                    onclick="scwShow(this,event);" onfocus="scwShow(this,event);" readonly/></td>
            <td>Age : </td>
            <td><input name="txtAge" type="number" value="<?php echo $row['age']; ?>" readonly/></td>
        </tr>

        <tr>
            <td>10.</td>
            <td>Gender : </td>
            <td>
                <input name="txtGender" type="radio" value="Male" <?php if ($row['gender'] == 'Male')
        echo 'checked'; ?> readonly/>
                Male &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtGender" type="radio" value="Female" <?php if ($row['gender'] == 'Female')
        echo 'checked'; ?> readonly/> Female
            </td>
        </tr>

        <tr>
            <td>11.</td>
            <td>Civil Status : </td>
            <td><input name="txtCivilStatus" type="text" value="<?php echo $row['civilStatus']; ?>"
                    style="width:300px" readonly/></td>
        </tr>

        <tr>
            <td>12.</td>
            <td>Citizenship : </td>
            <td><input name="txtCitizenship" type="text" value="<?php echo $row['citizenship']; ?>"
                    style="width:300px" readonly/></td>
        </tr>

        <tr>
            <td>13.</td>
            <td>Religion : </td>
            <td><input name="txtReligion" type="text" value="<?php echo $row['religion']; ?>" style="width:300px" readonly/>
            </td>
        </tr>

        <tr>
            <td>14.</td>
            <td>Occupation : </td>
            <td><input name="txtEmployment" type="text" value="<?php echo $row['employment']; ?>" style="width:300px" readonly/>
            </td>
        </tr>

        <tr>
            <td>15.</td>
            <td>Place of the Work : </td>
            <td colspan="3"><input name="txtEmployer" type="text" value="<?php echo $row['employer']; ?>"
                    style="width:500px;" readonly/></td>
        </tr>

        <tr>
            <td>16.</td>
            <td>Intended Degree Programme : </td>
            <td>
            <input name="txtDegree" type="radio" value="P.G.D. - Buddhist Studies" <?php if ($row['degree'] == 'P.G.D. - Buddhist Studies')
        echo 'checked'; ?> readonly/> P.G.D. - Buddhist Studies &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                <input name="txtDegree" type="radio" value="M.A. (One Year)" <?php if ($row['degree'] == 'M.A. (One Year)')
        echo 'checked'; ?> readonly/> M.A. (One Year) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                <input name="txtDegree" type="radio" value="M.A. (Two Year)" <?php if ($row['degree'] == 'M.A. (Two Year)')
        echo 'checked'; ?> readonly/> M.A. (Two Year)
            </td>
        </tr>

        <tr>
            <td>17.</td>
            <td>Medium of Study : </td>
            <td>
                <input name="txtMedium" type="radio" value="Sinhala" <?php if ($row['medium'] == 'Sinhala')
        echo 'checked'; ?> readonly/> Sinhala &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtMedium" type="radio" value="English" <?php if ($row['medium'] == 'English')
        echo 'checked'; ?>> English &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtMedium" type="radio" value="Other" <?php if ($row['medium'] == 'Other')
        echo 'checked'; ?> readonly/>
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
        echo 'checked'; ?> readonly/> Buddhist Studies &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Sanskrit" <?php if ($row['field'] == 'Sanskrit')
        echo 'checked'; ?> readonly/> Sanskrit &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Pali" <?php if ($row['field'] == 'Pali')
        echo 'checked'; ?> readonly/>
                Pali &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Sinhala" <?php if ($row['field'] == 'Sinhala')
        echo 'checked'; ?> readonly/> Sinhala &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="English" <?php if ($row['field'] == 'English')
        echo 'checked'; ?> readonly/> English
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
        echo 'checked'; ?> readonly/>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Attached photos : </td>
            <td>
                <input type="checkbox" id="photos" name="photos" value="Yes" <?php if ($row['photos'] == 'Yes')
        echo 'checked'; ?> readonly/>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Payment :</td>
            <td>
                <input id="payment" name="payment" type="number" min="0" max="999999"
                    value="<?php echo $row['payment']; ?>" required readonly/>
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
</form>


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