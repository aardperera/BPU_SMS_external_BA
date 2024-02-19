<?php
use LDAP\Result;

//Buffer larger content areas like the main page content
ob_start();
session_start();
?>

<script language="javascript" src="lib/scw/scw.js"></script>
<script>
    function validate_form(thisform) {
        with (thisform) {
            if (!validate_required(txtStudentID)) { alert("Student Id cann't be blank."); return false; }
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

<script>
    $(document).ready(function () {

        // Denotes total number of rows
        var rowIdx = 0;
        var rowId = 0;

        // jQuery button click event to add a row
        $('#addBtn').on('click', function () {

            if (rowId < 10) {
                ++rowId;
                // Adding a row inside the tbody.
                $('#tbody').append(`<tr id="R${++rowIdx}">
             <td class="row-index text-center">
                <p style="font-size:8px;">${rowIdx}</p>
             </td>
             <td><input id="q_institute${rowId}" name="q_institute${rowId}" style="width:100%" type="text" value="" maxlength="150" required/></td>
             <td><input id="q_indexno${rowId}" name="q_indexno${rowId}" style="width:100%" type="text" value="" maxlength="50" required/></td>
             <td><input id="q_year${rowId}" name="q_year${rowId}" style="width:100%" type="number" min="1900" max="2100" required/></td>
             <td><input id="q_subjects${rowId}" name="q_subjects${rowId}" style="width:100%" type="text" value="" maxlength="300" required/></td>
             <td><input id="q_class${rowId}" name="q_class${rowId}" style="width:100%" type="text" value="" maxlength="100" required/></td>
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

<h1>New Applicant</h1>
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


    print $_SESSION['courseID'];

    if ($birthday == '') {
        $birthday = '1970-01-01';
    }

    $query = "INSERT INTO ma_applicant SET studentID='$studentID', acyear = '$acyear', nic='$nic', passport='$passport', title='$title', nameEnglish='$nameEnglish', initials = '$initials', nameFullEnglish = '$fullNameEnglish', addressE1='$addressE1', addressE2='$addressE2', addressE3='$addressE3', addressS1='$addressS1', addressS2='$addressS2', addressS3='$addressS3', city = '$city', postalcode = '$postalcode', districtstate = '$districtstate', country='$country', gender = '$gender', countrycode0='$countryCode0', countrycode1='$countryCode1', countrycode2='$countryCode2', countrycode3='$countryCode3', contactNo0='$contactNo0', contactNo1='$contactNo1', contactNo2='$contactNo2', contactNo3='$contactNo3', email='$email', birthday='$birthday', age='$age', citizenship='$citizenship', religion='$religion', civilStatus='$civilStatus', employment='$employment', employer='$employer', degree = '$degree', medium='$medium', field='$field', certificate='$certificate', photos='$photos', payment='$payment', courseID='" . $_SESSION['courseId'] . "'";
    //$query = "INSERT INTO student SET studentID='$studentID', nic='$nic', title='$title', nameEnglish='$nameEnglish', nameSinhala='$nameSinhala', addressE1='$addressE1', addressE2='$addressE2', addressE3='$addressE3', addressS1='$addressS1', addressS2='$addressS2', addressS3='$addressS3', countryCode='$countryCode', contactNo='$contactNo', email='$email', birthday='$birthday', citizenship='$citizenship',civilStatus='$civilStatus', acyear='$acyear',employment='$employment', employer='$employer',courseID='" . $_SESSION['courseId'] . "'";
    //$query = "INSERT INTO student SET studentID='$studentID', nic='$nic', title='$title', nameEnglish='$nameEnglish', nameSinhala='$nameSinhala', addressE1='$addressE1', addressE2='$addressE2', addressE3='$addressE3', addressS1='$addressS1', addressS2='$addressS2', addressS3='$addressS3', contactNo='$contactNo', email='$email', birthday='$birthday', citizenship='$citizenship',civilStatus='$civilStatus', employment='$employment', employer='$employer'";
    //========

    //txtInitials , txtFullNameEnglish , txtCity , txtPostalCode , txtDistrict, txtCountry

    //=========

    $result = $db->executeQuery($query);
    header("location:applicantAdmin.php");


    for ($i = 1; $i <= 10; $i++) {
        if (isset($_POST['q_institute' . $i])) {
            $institute = $db->cleanInput($_POST['q_institute' . $i]);
            $indexno = $db->cleanInput($_POST['q_indexno' . $i]);
            $year = $db->cleanInput($_POST['q_year' . $i]);
            $subjects = $db->cleanInput($_POST['q_subjects' . $i]);
            $class = $db->cleanInput($_POST['q_class' . $i]);
            $contacts = $db->cleanInput($_POST['q_contacts' . $i]);

            $query = "INSERT INTO ma_applicant_qualification SET institute='$institute', indexno='$indexno', `year`='$year', subjects='$subjects', class='$class', contacts='$contacts', studentID='$studentID'";
            $result = $db->executeQuery($query);
        }
    }

    //$query1 = "INSERT INTO stu_qualification SET studentID='$studentID',OL='$ol',AL='$al',Diploma='$diploma',HigherDiploma='$higher_Diploma',FirsDegree='$First_Degree',Post_OneYear='$Post_One_Year',Post_TwoYears='$Post_Two_Year',Others='$others'";
    //$result = $db->executeQuery($query1);

}
?>
<form method="post" action="" onsubmit="return validate_form(this);" class="plain">
    <table>
        <tr>
            <td></td>
            <td>Student ID : </td>
            <td colspan="1"><input name="txtStudentID" id="txtStudentID" type="text" value="" maxlength="20" oninput="verifystudentid(this.value, 'txtStudentID');" /> <span class="validity"></span></td>
            <td>Academic Year : </td>
            <td colspan="1"><input name="txtacyear" type="number" value="" max="2100" min="2000" required /></td>
        </tr>

        <tr>
            <td rowspan="4" style="vertical-align:top;">1.</td>
            <td height="26">Name of Applicant (with initials) : </td>
            <td colspan="3"><input name="txtNameEnglish" type="text" value="" style="width:500px" maxlength="100"
                    required /></td>
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
                    <option value="Ven.">Ven.</option>
                    <option value="Prof.">Prof.</option>
                    <option value="Dr.">Dr.</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Mrs.">Mrs.</option>
                    <option value="Miss.">Miss.</option>
                </select></td>
        </tr>

        <tr>
            <td height="26">Names denoted by initials : </td>
            <td colspan="3"><input name="txtInitials" type="text" value="" maxlength="200" style="width:500px"
                    required /></td>
        </tr>

        <tr>
            <td height="26">Full Name in English : </td>
            <td colspan="3"><input name="txtFullNameEnglish" type="text" value="" maxlength="400" style="width:500px"
                    required /></td>
        </tr>

        <tr>
            <td rowspan="2" style="vertical-align:top;">2.</td>
            <td valign="top">Address (Sinhala) : </td>
            <td colspan="3"><input name="txtAddressS1" type="text" value="" maxlength="200" style="width:500px"
                    required />
                <br />
                <input name="txtAddressS2" type="text" value="" maxlength="200" style="width:500px" />
                <br />
                <input name="txtAddressS3" type="text" value="" maxlength="200" style="width:500px" />
            </td>
        </tr>

        <tr>
            <td valign="top">Address (English) : </td>
            <td colspan="3"><input name="txtAddressE1" type="text" value="" maxlength="200" style="width:500px"
                    required />
                <br />
                <input name="txtAddressE2" type="text" value="" maxlength="200" style="width:500px" />
                <br />
                <input name="txtAddressE3" type="text" value="" maxlength="200" style="width:500px" />
            </td>
        </tr>

        <tr>
            <td>3.</td>
            <td>City : </td>
            <td>
                <input name="txtCity" type="text" value="" maxlength="150" style="width: 150px;" required />
            </td>

            <td>Postal Code : </td>
            <td>
                <input name="txtPostalCode" type="text" value="" maxlength="6" style="width: 150px;" required />
            </td>
        </tr>

        <tr>
            <td>4.</td>
            <td>District/State : </td>
            <td colspan="3"><input name="txtDistrict" type="text" value="" maxlength="100" required /></td>
        </tr>

        <tr>
            <td>5.</td>
            <td>Country : </td>
            <td colspan="3"><input name="txtCountry" type="text" value="" maxlength="100" required /></td>
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
                    value="+94" required placeholder="+xxxx" />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo0" id="txtContactNo0" type="text" maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); verifyconatct(this.value,'txtContactNo0');"
                    placeholder="0/123456789" />
                <span class="validity"></span>
            </td>

            <td>Official : </td>
            <td>
                <input style="width:50px" id="txtCountryCode1" name="txtCountryCode1" type="text" maxlength="6"
                    oninput="this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1'); verifycontrycode(this.value, 'txtCountryCode1');"
                    value="+94" required placeholder="+xxxx" />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo1" id="txtContactNo1" type="text" maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); verifyconatct(this.value, 'txtContactNo1');"
                    placeholder="0/123456789" />
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Mobile : </td>
            <td>
                <input style="width:50px" id="txtCountryCode2" name="txtCountryCode2" type="text" maxlength="6"
                    oninput="this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1'); verifycontrycode(this.value, 'txtCountryCode2');"
                    value="+94" required placeholder="+xxxx" />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo2" id="txtContactNo2" type="text" maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); verifyconatct(this.value, 'txtContactNo2');"
                    placeholder="0/123456789" />
                <span class="validity"></span>
            </td>

            <td>Whatsapp : </td>
            <td>
                <input style="width:50px" id="txtCountryCode3" name="txtCountryCode3" type="text" maxlength="6"
                    oninput="this.value = this.value.replace(/[^0-9+]/g, '').replace(/(\..*)\./g, '$1'); verifycontrycode(this.value, 'txtCountryCode3');"
                    value="+94" required placeholder="+xxxx" />
                <span class="validity"></span>
                <input style="width:100px" name="txtContactNo3" id="txtContactNo3" type="text" maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1'); verifyconatct(this.value, 'txtContactNo3');"
                    placeholder="0/123456789" />
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Email : </td>
            <td colspan="3"><input style="width:500px;" name="txtEmail" type="email" maxlength="60" value="" required />
            </td>
        </tr>

        <tr>
            <td>7.</td>
            <td>NIC No. : </td>
            <td colspan="3"><input name="txtNic" id="txtNic" type="text" placeholder="123456789V or 123456789012"
                    oninput="this.value = this.value.replace(/[^0-9V]/g, '').replace(/(\..*)\./g, '$1'); verifynic(this.value);"
                    required maxlength="12" />
                <span class="validity"></span>
            </td>
        </tr>

        <tr>
            <td>8.</td>
            <td>Passport No. : </td>
            <td><input name="txtPassport" type="text" value="" style="width:250px" maxlength="150" required /></td>
        </tr>

        <tr>
            <td>9.</td>
            <td>Birthday : </td>
            <td><input name="txtBirthday" type="text" value="" onclick="scwShow(this,event);"
                    onfocus="scwShow(this,event);" readonly required /></td>
            <td>Age : </td>
            <td><input name="txtAge" type="number" value="" min="18" max="120" required /></td>
        </tr>

        <tr>
            <td>10.</td>
            <td>Gender : </td>
            <td>
                <input name="txtGender" type="radio" value="Male" checked> Male &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtGender" type="radio" value="Female"> Female
            </td>
        </tr>

        <tr>
            <td>11.</td>
            <td>Civil Status : </td>
            <td><input name="txtCivilStatus" type="text" value="" style="width:300px" maxlength="20" required /></td>
        </tr>

        <tr>
            <td>12.</td>
            <td>Citizenship : </td>
            <td><input name="txtCitizenship" type="text" value="" style="width:300px" maxlength="20" required /></td>
        </tr>

        <tr>
            <td>13.</td>
            <td>Religion : </td>
            <td><input name="txtReligion" type="text" value="" style="width:300px" maxlength="20" required /></td>
        </tr>

        <tr>
            <td>14.</td>
            <td>Occupation : </td>
            <td><input name="txtEmployment" type="text" value="" maxlength="20" style="width:300px" required /></td>
        </tr>

        <tr>
            <td>15.</td>
            <td>Place of the Work : </td>
            <td colspan="3"><input name="txtEmployer" type="text" value="" maxlength="50" style="width:500px;"
                    required /></td>
        </tr>

        <tr>
            <td>16.</td>
            <td>Intended Degree Programme : </td>
            <td>
                <input name="txtDegree" type="radio" value="P.G.D. - Buddhist Studies" checked> P.G.D. - Buddhist
                Studies &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtDegree" type="radio" value="M.A. (One Year)"> M.A. (One Year) &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtDegree" type="radio" value="M.A. (Two Year)"> M.A. (Two Year)
            </td>
        </tr>

        <tr>
            <td>17.</td>
            <td>Medium of Study : </td>
            <td>
                <input name="txtMedium" type="radio" value="Sinhala" checked> Sinhala &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtMedium" type="radio" value="English"> English &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtMedium" type="radio" value="Other"> Other
            </td>
        </tr>

        <tr>
            <td>18.</td>
            <td>Field of Study : </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="4">
                <input name="txtField" type="radio" value="Buddhist Studies"> Buddhist Studies &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Sanskrit"> Sanskrit &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Pali"> Pali &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="Sinhala"> Sinhala &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <input name="txtField" type="radio" value="English"> English
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
                <th>Degree and Name of the University / Higher Education Institute</th>
                <th>Index No.</th>
                <th>Year</th>
                <th>Subjects</th>
                <th>Class / Grade / G.P.A.</th>
                <th>Verification Contact Details (University Telephone No / E-mail,etc.)</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="tbody">

        </tbody>
    </table>

    <table>
        <tr>
            <button class="btn btn-md btn-primary" id="addBtn" type="button">
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
                <input type="checkbox" id="certificate" name="certificate" value="Yes">
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Attached photos : </td>
            <td>
                <input type="checkbox" id="photos" name="photos" value="Yes">
            </td>
        </tr>

        <tr>
            <td></td>
            <td>Payment :</td>
            <td>
                <input id="payment" name="payment" type="number" min="0" max="999999" value="" required />
            </td>
        </tr>

    </table>


    <br /><br />
    <p><input name="btnCancel" type="button" value="Cancel" onclick="document.location.href = 'applicantAdmin.php';"
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
    function verifystudentid(value, id) {
        var val = document.getElementById(id).value;
               
        $.ajax({
        url: "serverScript.php",
        method: "POST",
        data: { "uid": val }
        });



        <?php
        $duplicate = false;       
        
        
        $query = "SELECT studentID FROM  ma_applicant WHERE studentID='$id'";
        $result = $db->executeQuery($query);

        if ($db->numRows($result) > 0) {
            $duplicate = true;
        }

        ?>

        if (!<?php echo $duplicate?>) {
            document.getElementById(id).setCustomValidity("");
        }
        else {
            console.log("duplicate student id");
            document.getElementById(id).setCustomValidity("Invalid field");
        }
    }
</script>

<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "New Student - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='applicantAdmin.php'>Students </a></li><li>New Student</li></ul>";
//Apply the template
include("master_sms_external.php");
?>