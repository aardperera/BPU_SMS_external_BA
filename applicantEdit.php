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

<script>
    $(document).ready(function () {

        // Denotes total number of rows
        var rowIdx = 0;
        var rowId = 0;

        let value = document.getElementById("addBtn").value;

            rowId = value;
            rowIdx = value;

        // jQuery button click event to add a row
        $('#addBtn').on('click', function () {

            
            if (rowId < 10) {
                ++rowId;
                // Adding a row inside the tbody.
                $('#tbody').append(`<tr id="R${++rowIdx}">
             <td class="row-index text-center">
                <p style="font-size:8px;">${rowIdx}</p>
             </td>
            <td><div class="autocomplete"><input id="q_degree${rowId}" name="q_degree${rowId}" style="width:100%" type="text" value="" maxlength="150" onclick="adegree('q_degree${rowId}');" required/></div></td>
            <td><div class="autocomplete"><input id="q_institute${rowId}" name="q_institute${rowId}" style="width:100%" type="text" value="" maxlength="150" onclick="ainstitute('q_institute${rowId}');" required/></div></td>
            <td><input id="q_indexno${rowId}" name="q_indexno${rowId}" style="width:100%" type="text" value="" maxlength="50" required/></td>
            <td><input id="q_year${rowId}" name="q_year${rowId}" style="width:100%" type="number" min="1900" max="2100"/></td>
            <td><input id="q_subjects${rowId}" name="q_subjects${rowId}" style="width:100%" type="text" value="" maxlength="300" required/></td>
            <td>
            <select id="q_class${rowId}" name="q_class${rowId}" required>
                    <option value="Pending">Pending</option>
                    <option value="Pass">Pass</option>
                    <option value="Second Class Lower">Second Class Lower</option>
                    <option value="Second Class Upper">Second Class Upper</option>
                    <option value="First Class">First Class</option>
            </select>
             </td>
             <td><input id="q_contacts${rowId}" name="q_contacts${rowId}" style="width:100%" type="text" value="" maxlength="300" required/></td>
             <td class="text-center">
                    <button style="font-size:10px;" class="btn btn-danger remove" type="button">Remove</button>
                </td>
            </tr>`);
            }
        });

        // jQuery button click event to remove a row.
        $('#tbody').on('click', '.remove', function () {

            // Getting all the rows next to the row
            // containing the clicked button
            var child = $(this).closest('tr').nextAll();

            // Iterating across all the rows 
            // obtained to change the index

            child.each(function () {

                // Getting <tr> id.
                var id = $(this).attr('id');

                // Getting the <p> inside the .row-index class.
                var idx = $(this).children('.row-index').children('p');

                // Gets the row number from <tr> id.
                var dig = parseInt(id.substring(1));

                // Modifying row index.
                idx.html(`${dig - 1}`);

                // Modifying row id.
                $(this).attr('id', `R${dig - 1}`);
            });

            // Removing the current row.
            $(this).closest('tr').remove();

            // Decreasing total number of rows by 1.
            rowIdx--;
        });
    });
</script>


<style>
    table,
    th,
    td {
        border: 1px solid #fff;
        padding: 5px;
    }
</style>

<style>

/*the container must be positioned relative:*/
.autocomplete {
  position: relative;
  display: inline-block;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}
</style>


<h1>Applicant Edit</h1>
<?php
include('dbAccess.php');

$db = new DBOperations();

if(isset($_GET['page'])) $pageNum = $_GET['page'];
if(isset($_GET['select'])) $select = $_GET['select'];
if(isset($_GET['acyear'])) $acyear = $_GET['acyear'];


if (isset($_POST['btnSubmit'])) {
    $studentID = $db->cleanInput($_POST['txtStudentID']);
    $pageNum = $db->cleanInput($_POST['pageNum']);
    $select = $db->cleanInput($_POST['select']);
    $ayear = $db->cleanInput($_POST['acyear']);
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
    if($medium == 'Other') { $medium = $db->cleanInput($_POST['txtOther']); }
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
    $affiliate = $_POST['affiliate'];
    $payment = $db->cleanInput($_POST['payment']);

    //print $_SESSION['courseID'];

    if ($birthday == '') {
        $birthday = '1970-01-01';
    }

    $query = "UPDATE ma_applicant SET acyear = '$acyear', nic='$nic', passport='$passport', title='$title', nameEnglish='$nameEnglish', initials = '$initials', nameFullEnglish = '$fullNameEnglish', addressE1='$addressE1', addressE2='$addressE2', addressE3='$addressE3', addressS1='$addressS1', addressS2='$addressS2', addressS3='$addressS3', city = '$city', postalcode = '$postalcode', districtstate = '$districtstate', country='$country', gender = '$gender', countrycode0='$countryCode0', countrycode1='$countryCode1', countrycode2='$countryCode2', countrycode3='$countryCode3', contactNo0='$contactNo0', contactNo1='$contactNo1', contactNo2='$contactNo2', contactNo3='$contactNo3', email='$email', birthday='$birthday', age='$age', citizenship='$citizenship', religion='$religion', civilStatus='$civilStatus', employment='$employment', employer='$employer', degree = '$degree', medium='$medium', field='$field', certificate='$certificate', photos='$photos', affiliate='$affiliate', payment='$payment' WHERE studentID='$studentID'";
    $result = $db->executeQuery($query);

    //print $query;

    //$query1 = "UPDATE stu_qualification SET OL='$ol',AL='$al',Diploma='$diploma',HigherDiploma='$higher_Diploma',FirsDegree='$First_Degree',Post_OneYear='$Post_One_Year',Post_TwoYears='$Post_Two_Year',Others='$others' where studentID='$studentID'";
    //$result1 = $db->executeQuery($query1);

    $queryqua = "SELECT * FROM  ma_applicant_qualification WHERE studentID='$studentID'";
    $resultqua = $db->executeQuery($queryqua);
    $no_qua = $db->numRows($resultqua);    

    for($i = 1 ; $i <= $no_qua ; $i++){
            $rowqua = $db->Next_Record($resultqua);
            $id = $rowqua['id'];
            $degree = $db->cleanInput($_POST['q_degree' . $i]);
            $institute = $db->cleanInput($_POST['q_institute'.$i]);
            $indexno = $db->cleanInput($_POST['q_indexno'.$i]);
            $year = $db->cleanInput($_POST['q_year'.$i]);
            $subjects = $db->cleanInput($_POST['q_subjects'.$i]);
            $class = $db->cleanInput($_POST['q_class'.$i]);
            $contacts = $db->cleanInput($_POST['q_contacts'.$i]);

            if($degree == ''){
                $query = "DELETE from ma_applicant_qualification WHERE id = '$id'" ;
            }
            else{
                $query = "UPDATE ma_applicant_qualification SET degree='$degree', institute='$institute', indexno='$indexno', `year`='$year', subjects='$subjects', class='$class', contacts='$contacts' WHERE id = '$id'" ;
            }
            $result = $db->executeQuery($query);        
    }

    for ($i = ++$no_qua; $i <= 10; $i++) {
        if (isset($_POST['q_institute' . $i])) {
            $degree = $db->cleanInput($_POST['q_degree' . $i]);
            $institute = $db->cleanInput($_POST['q_institute' . $i]);
            $indexno = $db->cleanInput($_POST['q_indexno' . $i]);
            $year = $db->cleanInput($_POST['q_year' . $i]);
            $subjects = $db->cleanInput($_POST['q_subjects' . $i]);
            $class = $db->cleanInput($_POST['q_class' . $i]);
            $contacts = $db->cleanInput($_POST['q_contacts' . $i]);

            $query = "INSERT INTO ma_applicant_qualification SET degree='$degree', institute='$institute', indexno='$indexno', `year`='$year', subjects='$subjects', class='$class', contacts='$contacts', studentID='$studentID'";
            $result = $db->executeQuery($query);
        }
    }

    header("location:applicantAdmin.php?page=$pageNum&select=$select&acyear=$ayear");
}

$studentID = $db->cleanInput($_GET['studentID']);
$query = "SELECT * FROM ma_applicant WHERE studentID='$studentID'";
//=======


//=====================================
$queryqua = "SELECT * FROM  ma_applicant_qualification WHERE studentID='$studentID'";
$resultqua = $db->executeQuery($queryqua);

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
            <td>Applicant ID : </td>
            <td colspan="1"><input name="txtStudentID" type="text" value="<?php echo $row['studentID']; ?>"
                    maxlength="20" readonly /></td>
            <td>Academic Year : </td>
            <td colspan="1"><input name="txtacyear" type="number" value="<?php echo $row['acyear']; ?>" max="2100"
                    min="2000" required /></td>
        </tr>

        <tr>
            <td rowspan="4" style="vertical-align:top;">1.</td>
            <td height="26">Name of Applicant (with initials) : </td>
            <td colspan="3"><input name="txtNameEnglish" type="text" value="<?php echo $row['nameEnglish']; ?>"
                    style="width:500px" maxlength="100" /></td>
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
            <td colspan="3"><input name="txtInitials" type="text" value="<?php echo $row['initials']; ?>"
                    maxlength="200" style="width:500px" required /></td>
        </tr>

        <tr>
            <td height="26">Full Name in English : </td>
            <td colspan="3"><input name="txtFullNameEnglish" type="text" value="<?php echo $row['nameFullEnglish']; ?>"
                    maxlength="400" style="width:500px" required /></td>
        </tr>

        <tr>
            <td rowspan="2" style="vertical-align:top;">2.</td>
            <td valign="top">Address (Sinhala) : </td>
            <td colspan="3"><input name="txtAddressS1" type="text" value="<?php echo $row['addressS1']; ?>"
                    maxlength="200" style="width:500px" required />
                <br />
                <input name="txtAddressS2" type="text" value="<?php echo $row['addressS2']; ?>" maxlength="200"
                    style="width:500px" />
                <br />
                <input name="txtAddressS3" type="text" value="<?php echo $row['addressS3']; ?>" maxlength="200"
                    style="width:500px" />
            </td>
        </tr>

        <tr>
            <td valign="top">Address (English) : </td>
            <td colspan="3"><input name="txtAddressE1" type="text" value="<?php echo $row['addressE1']; ?>"
                    maxlength="200" style="width:500px" required />
                <br />
                <input name="txtAddressE2" type="text" value="<?php echo $row['addressE2']; ?>" maxlength="200"
                    style="width:500px" />
                <br />
                <input name="txtAddressE3" type="text" value="<?php echo $row['addressE3']; ?>" maxlength="200"
                    style="width:500px" />
            </td>
        </tr>

        <tr>
            <td>3.</td>
            <td>City : </td>
            <td>
                <div class="autocomplete" style="width:300px;">
                
                <input name="txtCity" id="txtCity" type="text" value="<?php echo $row['city']; ?>" maxlength="150"
                    style="width: 150px;" required />
                </div>
            </td>

            <td>Postal Code : </td>
            <td>
                <input name="txtPostalCode" type="text" value="<?php echo $row['postalcode']; ?>" maxlength="6"
                    style="width: 150px;" />
            </td>
        </tr>

        <tr>
            <td>4.</td>
            <td>District/State : </td>
            <td colspan="3">
            <div class="autocomplete" style="width:300px;">
            <input name="txtDistrict" id="txtDistrict" type="text" value="<?php echo $row['districtstate']; ?>"
                    maxlength="100" required />
            </div>
            </td>
        </tr>

        <tr>
            <td>5.</td>
            <td>Country : </td>
            <td colspan="3">
            <div class="autocomplete" style="width:300px;">
                <input name="txtCountry" id="txtCountry" type="text" value="<?php echo $row['country']; ?>" maxlength="100"
                    required />
                </div>
            </td>
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
            <td colspan="3"><input style="width:500px;" name="txtEmail" type="email"
                    value="<?php echo $row['email']; ?>" maxlength="60"/></td>
        </tr>

        <tr>
            <td>7.</td>
            <td>NIC No. : </td>
            <td colspan="3"><input name="txtNic" id="txtNic" type="text" placeholder="123456789V or 123456789012"
                    oninput="this.value = this.value.replace(/[^0-9V]/g, '').replace(/(\..*)\./g, '$1'); verifynic(this.value);"
                    maxlength="12" value="<?php echo $row['nic']; ?>" />
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td>8.</td>
            <td>Passport No. : </td>
            <td><input name="txtPassport" type="text" style="width:250px" value="<?php echo $row['passport']; ?>"
                    maxlength="150"/>
            </td>
        </tr>

        <tr>
            <td>9.</td>
            <td>Birthday : </td>
            <td><input name="txtBirthday" id="txtBirthday" type="date" value="<?php echo $row['birthday']; ?>" onblur="setage('txtBirthday', 'txtAge');" required/></td>
            <td>Age : </td>
            <td><input name="txtAge" id="txtAge" type="number" value="<?php echo $row['age']; ?>" min="18" max="120" required />
            </td>
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
            <td>
                <select name="txtCivilStatus" id="txtCivilStatus" required>
                    <option value="Single" <?php if ($row['civilStatus'] == 'Single') echo 'selected'; ?> >Single</option>
                    <option value="Married"  <?php if ($row['civilStatus'] == 'Married') echo 'selected'; ?> >Married</option>
                    <option value="Separated"  <?php if ($row['civilStatus'] == 'Separated') echo 'selected'; ?> >Separated</option>
                    <option value="Divorced"  <?php if ($row['civilStatus'] == 'Divorced') echo 'selected'; ?> >Divorced</option>
                    <option value="Widowed"  <?php if ($row['civilStatus'] == 'Widowed') echo 'selected'; ?> >Widowed</option>
                </select>    
            </td>
        </tr>

        <tr>
            <td>12.</td>
            <td>Citizenship : </td>
            <td><input name="txtCitizenship" type="text" value="<?php echo $row['citizenship']; ?>" maxlength="20"
                    style="width:300px" required /></td>
        </tr>

        <tr>
            <td>13.</td>
            <td>Religion : </td>
            <td>
            <select name="txtReligion" id="txtReligion" required>
                    <option value="Buddhist" <?php if ($row['religion'] == 'Buddhist') echo 'selected'; ?>>Buddhist</option>
                    <option value="Hindu" <?php if ($row['religion'] == 'Hindu') echo 'selected'; ?>>Hindu</option>
                    <option value="Islam" <?php if ($row['religion'] == 'Islam') echo 'selected'; ?>>Islam</option>
                    <option value="Catholic" <?php if ($row['religion'] == 'Catholic') echo 'selected'; ?>>Catholic</option>
                    <option value="Other" <?php if ($row['religion'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>    
            </td>
        </tr>

        <tr>
            <td>14.</td>
            <td>Occupation : </td>
            <td><input name="txtEmployment" type="text" value="<?php echo $row['employment']; ?>" maxlength="150"
                    style="width:300px" />
            </td>
        </tr>

        <tr>
            <td>15.</td>
            <td>Place of the Work : </td>
            <td colspan="3"><input name="txtEmployer" type="text" value="<?php echo $row['employer']; ?>" maxlength="150"
                    style="width:500px;" /></td>
        </tr>

        <tr>
            <td>16.</td>
            <td>Intended Degree Programme : </td>
            <td>
                <input name="txtDegree" type="radio" value="P.G.D. - Buddhist Studies" <?php if ($row['degree'] == 'P.G.D. - Buddhist Studies')
        echo 'checked'; ?> /> P.G.D. - Buddhist Studies &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

                <input name="txtDegree" type="radio" value="M.A. (One Year)" <?php if ($row['degree'] == 'M.A. (One Year)')
        echo 'checked'; ?> /> M.A. (One Year) &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                <input name="txtDegree" type="radio" value="M.A. (Two Year)" <?php if ($row['degree'] == 'M.A. (Two Year)')
                                                                                       echo 'checked'; ?> /> M.A. (Two Year)
            </td>
        </tr>

        <tr>
            <td>17.</td>
            <td>Medium of Study : </td>
            <td>
                <input name="txtMedium" id="Sinhala" type="radio" value="Sinhala" oninput="medium_other('Sinhala', 'text');" <?php if ($row['medium'] == 'Sinhala') echo 'checked'; ?>> Sinhala &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;
                <input name="txtMedium" id="English" type="radio" value="English" oninput="medium_other('English', 'text');" <?php if ($row['medium'] == 'English') echo 'checked'; ?>> English &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;
                <input name="txtMedium" id="Other" type="radio" value="Other" oninput="medium_other('Other', 'text');" <?php if ($row['medium'] == 'Sinhala' || $row['medium'] == 'English') echo ''; else echo 'checked'; ?> >
                Other
            </td>
            <td>
                <p id="text" style="display:<?php if ($row['medium'] == 'Sinhala' || $row['medium'] == 'English') echo 'none'; else echo 'block'; ?>" >
                    <input name="txtOther" id="txtOther" type="text" value="<?php echo $row['medium']; ?>" />
                </p>
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
        echo 'checked'; ?>> Buddhist Studies &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Sanskrit" <?php if ($row['field'] == 'Sanskrit')
        echo 'checked'; ?>> Sanskrit &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp;
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
        </tr>
    </table>

    <table id="table2" class="table table-bordered" name="table2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Degree</th>
                <th>Name of the University / Higher Education Institute</th>
                <th>Index No.</th>
                <th>Effective Year</th>
                <th>Subjects</th>
                <th>Class / Grade / G.P.A.</th>
                <th>Verification Contact Details (University Telephone No / E-mail,etc.)</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tbody">
            <?php
    $rowIdx = 0;
    foreach ($resultqua as $key => $rowqua) {
        ++$key;
            ?>
            <tr id="R<?php echo ++$rowIdx; ?>">
                <td class="row-index text-center">
                    <p style="font-size:8px;"><?php echo $rowIdx ?></p>
                </td>
                <td><div class="autocomplete"><input id="q_degree<?php echo $key; ?>" name="q_degree<?php echo $key; ?>" style="width:100%" type="text" value="<?php echo $rowqua['degree']; ?>"
                        maxlength="150" onclick="adegree('q_degree<?php echo $key; ?>');" required /></div></td>
                <td><div class="autocomplete"><input id="q_institute<?php echo $key; ?>" name="q_institute<?php echo $key; ?>" style="width:100%" type="text" value="<?php echo $rowqua['institute']; ?>"
                        maxlength="150" onclick="ainstitute('q_institute<?php echo $key; ?>');" required /></div></td>
                <td><input id="q_indexno<?php echo $key;?>" name="q_indexno<?php echo $key;?>" style="width:100%" type="text" value="<?php echo $rowqua['indexno']; ?>"
                        maxlength="50" required /></td>
                <td><input id="q_year<?php echo $key;?>" name="q_year<?php echo $key;?>" style="width:100%" type="number" min="1900" value="<?php echo $rowqua['year']; ?>"
                        max="2100" /></td>
                <td><input id="q_subjects<?php echo $key;?>" name="q_subjects<?php echo $key;?>" style="width:100%" type="text" value="<?php echo $rowqua['subjects']; ?>"
                        maxlength="300" required /></td>
                <td>
                    <select id="q_class<?php echo $key;?>" name="q_class<?php echo $key;?>" required>
                        <option value="Pending" <?php if ($rowqua['class'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Pass" <?php if ($rowqua['class'] == 'Pass') echo 'selected'; ?>>Pass</option>
                        <option value="Second Class Lower"  <?php if ($rowqua['class'] == 'Second Class Lower') echo 'selected'; ?>>Second Class Lower</option>
                        <option value="Second Class Upper"  <?php if ($rowqua['class'] == 'Second Class Upper') echo 'selected'; ?>>Second Class Upper</option>
                        <option value="First Class" <?php if ($rowqua['class'] == 'First Class') echo 'selected'; ?>>First Class</option>
                    </select>
                </td>
                <td><input id="q_contacts<?php echo $key;?>" name="q_contacts<?php echo $key;?>" style="width:100%" type="text" value="<?php echo $rowqua['contacts']; ?>"
                        maxlength="300" required />
                </td>
                <td class="text-center">
                    <button style="font-size:10px;" class="btn btn-danger remove" type="button">Remove</button>
                </td>
            </tr>
            <?php
    }
            ?>
        </tbody>
    </table>

    <table>
            <tr>
                <button class="btn btn-md btn-primary" id="addBtn" type="button" value="<?php echo $db->numRows($resultqua); ?>" >
                    Add a new Qualification
                </button>
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
            <td>Affiliate : </td>
            <td>
                <input type="checkbox" id="affiliate" name="affiliate" value="Yes" <?php if ($row['affiliate'] == 'Yes') echo 'checked'; ?>>
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


    
    <br /><br />
    <p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'applicantAdmin.php<?php if(isset($_GET['page'])) echo '?page='.$pageNum;?>&select=<?php if(isset($_GET['select'])) echo $select?>&acyear=<?php if(isset($_GET['acyear'])) echo $acyear?>';"
            class="button" style="width:60px;" />&nbsp;&nbsp;&nbsp;
        <input name="btnSubmit" type="submit" value="Submit" class="button" style="width:60px;" />
    </p>
</form>

<script>
    function verifyconatct(value, id) {
        var val = document.getElementById(id).value;
        if (val.length == 9 && val.charAt(0) != "0") {
            document.getElementById(id).setCustomValidity("");
        } else if (val.length == 10 && val.charAt(0) == "0") {
            document.getElementById(id).setCustomValidity("");
        }  else if (val.length == 0) {
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
    function setage(id0, id1) {
        setTimeout(function(){
            ;
        },2000); //delay is in milliseconds 

        var value = document.getElementById(id0).value;
        //console.log(value);
        var age = document.getElementById(id1);
        var date0 = new Date(value);
        var date1 = new Date();
        var years = Math.abs(parseInt(date1.getFullYear()) - parseInt(date0.getFullYear()));
        //console.log(years);
        age.value = years;
    }
</script>

<script>
    function medium_other(id0, id1) {
        var value = document.getElementById(id0).value;
        var text = document.getElementById(id1);
        if (value === "Other") {
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }
</script>

<script>
    function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the districts in Sri Lanka*/
var districts = ["Colombo", "Gampaha", "Kalutara", "Kandy", "Matale", "Nuwara Eliya", "Galle", "Matara", "Hambantota", "Jaffna", "Kilinochchi[1]", "Mannar", "Vavuniya", "Mullaitivu", "Batticaloa", "Ampara", "Trincomalee", "Kurunegala", "Puttalam", "Anuradhapura", "Polonnaruwa", "Badulla", "Moneragala", "Ratnapura", "Kegalle"];

/*An array containing all the country names in the world:*/
var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];

var cities = ["Ambalangoda", "Ampara", "Anuradhapura", "Badulla", "Balangoda", "Bandarawela", "Batticaloa", "Beruwala", "Chavakacheri", "Chilaw", "Colombo", "Dambulla", "Eravur", "Galle", "Gampaha", "Gampola", "Hambantota", "Haputale", "Harispattuwa", "Hatton", "Horana", "Ja-Ela", "Jaffna", "Kadugannawa", "Kalmunai", "Kalutara", "Kandy", "Kattankudy", "Katunayake", "Kegalle", "Kelaniya", "Kolonnawa", "Kuliyapitiya", "Kurunegala", "Mannar", "Matale", "Matara", "Minuwangoda", "Moneragala", "Moratuwa", "Mount Lavinia", "Nawalapitiya", "Negombo", "Nugegoda", "Nuwara Eliya", "Panadura", "Peliyagoda", "Point Pedro", "Puttalam", "Ratnapura", "Sainthamarathu", "Seethawakapura", "Sigiriya", "Sri Jayawardenapura", "Talawakele", "Tangalle", "Trincomalee", "Valvettithurai", "Vavuniya", "Wattala", "Wattegama", "Weligama"];

var universities = ["Buddhist and Pali University of Sri Lanka", "Bhiksu University of Sri Lanka", "Eastern University, Sri Lanka", "Gampaha Wickramarachchi University of Indigenous Medicine", "National Institute of Education (NIE)", "Ocean University of Sri Lanka", "Rajarata University of Sri Lanka", "Sabaragamuwa University of Sri Lanka", "South Eastern University of Sri Lanka", "Sri Palee Campus", "The General Sir John Kotelawala Defence University (KDU)", "Trincomalee Campus", "University of Colombo", "University of Jaffna", "University of Kelaniya", "University of Moratuwa", "University of Peradeniya", "University of Ruhuna", "The Open University of Sri Lanka", "University of Sri Jayewardenepura", "University of the Visual & Performing Arts", "University of Vavuniya", "University of Vocational Technology", "Uva Wellassa University of Sri Lanka", "Wayamba University of Sri Lanka"];
        
var degrees = ["Bachelor of Arts Degree", "Pracheena Final", "Master of Arts Degree", "Master of Philosophy Degree", "Doctor of Philosophy Degree"];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("txtDistrict"), districts);
autocomplete(document.getElementById("txtCountry"), countries);
autocomplete(document.getElementById("txtCity"), cities);

    function ainstitute(id) {
        autocomplete(document.getElementById(id), universities);
    }

    function adegree(id) {
        autocomplete(document.getElementById(id), degrees);
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