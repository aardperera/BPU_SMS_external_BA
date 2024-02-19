<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if (!isset($_SESSION['authenticatedUser'])) {
    echo $_SESSION['authenticatedUser'];
    header("Location: index.php");
}
?>

<?php
    error_reporting(E_ALL & ~E_WARNING);
?>

<script type="text/javascript" language="javascript">
 	function MsgOkCancel()
	{
		var message = "Please confirm to DELETE this applicant...";
		var return_value = confirm(message);
		return return_value;
	}

	function quickSearch()
	{
		var regNo = document.getElementById('txtSearch').value;
		if (regNo == "")
			alert("Enter a Registration No");
		else
			document.location.href ='studentDetails.php?studentID='+regNo;
	}

    function myFunction() {
        var selectedName = $("#myName").val();
        $("#studentID").val(selectedName);
    }
</script>
<?php
//print $_SESSION['courseID'] ;

include('dbAccess.php');
$db = new DBOperations();

$stud = "";

if (isset($_GET['cmd']) && $_GET['cmd']=="delete")
{
	$regNo = $db->cleanInput($_GET['studentID']);
	$delQuery = "DELETE FROM ba_applicant WHERE applicantID ='$regNo'";
	$result = $db->executeQuery($delQuery);

    $delQuery = "DELETE FROM ba_qualifications WHERE applicantID ='$regNo'";
	$result = $db->executeQuery($delQuery);
}



$date="";
if (isset($_GET['date'])) {
    $date = $_GET['date'];
}

//session_start();

$rowsPerPage = 15;
$pageNum = 1;
$select = '';
$acyear = '';

if(isset($_GET['page']))    $pageNum = $_GET['page'];
if(isset($_POST['page']))   $pageNum = $_POST['page'];
if(isset($_GET['select']))  $select  = $_GET['select'];
if(isset($_POST['select'])){$select  = $_POST['select']; $pageNum = 1; }
if(isset($_GET['acyear']))  $acyear  = $_GET['acyear'];
if(isset($_POST['acyear'])){$acyear  = $_POST['acyear']; $pageNum = 1; }

if(isset($_POST['select1'])) $select  = $_POST['select1'];
if(isset($_POST['acyear1'])) $acyear  = $_POST['acyear1'];
if(isset($_POST['txtnic'])) $nic  = $_POST['txtnic'];



$query = "SELECT * FROM ba_applicant WHERE courseID='".$_SESSION['courseId']."'";

$queryyr = "SELECT acyear FROM ba_applicant WHERE courseID='".$_SESSION['courseId']."'";
if($select != ''){
    $queryyr = $queryyr . " AND selection = '".$select."'";
}
$queryyr = $queryyr . " GROUP BY acyear";
$resulty = $db->executeQuery($queryyr);

if($select != ''){
    $query = $query . " AND selection = '".$select."'";
}

if($acyear != ''){
    $query = $query . " AND acyear = '".$acyear."'";
}

if($nic !=' '){
    //$query = $query . " AND nic = '".$nic."'";
}
$query = $query . " order by applicantID";
//print $query;

// counting the offset
$offset = ($pageNum - 1) * $rowsPerPage;
$numRows = $db->Row_Count($db->executeQuery($query));
$numPages = ceil($numRows/$rowsPerPage);

$pageQuery = $query." LIMIT $offset, $rowsPerPage";
$pageResult = $db->executeQuery($pageQuery);

if($db->numRows($pageResult) == 0 && $pageNum > 1){
    $pageNum--;
    $offset = ($pageNum - 1) * $rowsPerPage;
    
    $pageQuery = $query." LIMIT $offset, $rowsPerPage";
    $pageResult = $db->executeQuery($pageQuery);
}

$subcrsID="";
if(isset($_POST["subcrsID"]))
{
    $subcrsID=strip_tags($_POST["subcrsID"]);
}
?>


<h1>BA Applicant Administration</h1>
<form method="post" action="" class="plain" id="form1" name="form1">
    <table style="margin-left:8px" class="panel">
        <tr>
            <td>
                <input name="btnNew" type="button" value="New" onclick="document.location.href = 'applicantNewBA.php';" class="button" style="width:60px;" />&#160;&#160;&#160;
            </td>
            <td>
                <select id="select" name="select" onChange="document.form1.submit()">
                    <option value="" >Select an option</option>
                    <option value="Selected"  <?php if ($select == 'Selected') echo 'selected'; ?> >Selected</option>
                    <option value="Rejected"  <?php if ($select == 'Rejected') echo 'selected'; ?> >Rejected</option>
                    <option value="Reviewed"  <?php if ($select == 'Reviewed') echo 'selected'; ?> >Reviewed</option>
                    <option value="Pending"   <?php if ($select == 'Pending')  echo 'selected'; ?> >Pending</option>
                </select>
            </td>
            <td>
                <select id="acyear" name="acyear" onChange="document.form1.submit()">
                  
                    <?php 
                    $entry = false;
                    while($rowy = $db->Next_Record($resulty)) {
                    ?>
                        <option value="<?php echo $rowy[0]; ?>"  <?php if ($acyear == $rowy[0]) {$entry =true; echo 'selected';} ?> ><?php echo $rowy[0]; ?></option>
                    <?php
                    }
                    if($entry ==  false && $acyear != '') { 
                    ?>  <option value="<?php echo $acyear; ?>"  selected ><?php echo $acyear; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </td>
            <td>
                <a href="applicationxlsBA.php" class="button">Export Data</a>
            </td>
            <td>
            <a href="applicationxlsselectedBA.php" class="button">Selected List</a>
                <!--<input name="btnSummary" type="button" value="Summary" onclick="document.location.href = 'applicantsummary.php?acyear=<?php //echo $acyear; ?>';" class="button" style="width:60px;" />&#160;&#160;&#160; -->
            </td>
            <td>
                <!--<input name="btnSummary2" type="button" value="Report" onclick="document.location.href = 'applicantsummary2.php';" class="button" style="width:60px;" />&#160;&#160;&#160; -->
            </td>
            <td>NIC :
				<input name="txtnic" type="text" id="txtSearchN" maxlength="12" onChange="document.form1.submit()" value=" <?php echo $nic; ?>" />
			</td>
            <td>
                <input hidden type="text" id="date" name="date" value=" <?php echo $date; ?> " />
            </td>
            <td>
            <a href="applicantAdmin_BA.php" class="button">Applicant Selection</a>
            </td>
        </tr>
    </table>

    <?php if ($db->Row_Count($pageResult)>0){ ?>
    <br />
    <table class="applicant" width="100%">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Name</th>
            <th>Address</th>
            <th>NIC No.</th>
            <th style="width:120px;">Mobile No.</th>
            
            <th>Medium of Study</th>
            <th>Field of Study</th>
            
            
            <th>Qualification</th>
            <th>Main Subjects</th>
            <th>Elective Subjects</th>

            <th>Course Payment</th>
            <th colspan="3"></th>
        </tr>

        <?php
              while($row = $db->Next_Record($pageResult)) {
        ?>
        <tr>
            <td>
                <?php echo $row['applicantID'] ?>
            </td>
            <td>
                <?php echo $row['title'] ?>
            </td>
            <td style="font-size:110%;">
                <?php echo $row['initials'] ?>
            </td>
            <td style="font-size:110%;">
                <?php  echo str_replace(",",", ",$row['addressE1']. ' ' . $row['addressE2']. ' ' . $row['addressE3']);  ?>
            </td>
            <td>
                <?php echo $row['nic'] ?>
            </td>
            <td>
                <?php echo $row['countrycode2']; ?>-<?php echo $row['contactNo2']; ?>
                <br/>
                <?php echo $row['countrycode3']; ?>-<?php echo $row['contactNo3']; ?>
            </td>
            
            <td>
                <?php echo $row['medium'] ?>
            </td>
            <td>
                <?php echo $row['field'] ?>
            </td>

            <?php
            
                  $applicantID = $row['applicantID'];
                  $queryqua = "SELECT * FROM  ba_qualifications WHERE applicantID='$applicantID'";
                  $resultqua = $db->executeQuery($queryqua);
                  
                  $row['pending'] = false;

                  $rowqua = $db->Next_Record($resultqua);




                  $quli='';
                  if($rowqua['OL']=='1') $quli= 'O/L';
                  elseif ($rowqua['AL']=='1') $quli= 'A/L';
                  elseif ($rowqua['HDEnglish']=='1') $quli= 'Higher Diploma English';
                  elseif ($rowqua['HDPali']=='1') $quli= 'Higher Diploma Pali';
                  elseif ($rowqua['HDSans']=='1') $quli= 'Higher Diploma Sanskrit';
                  elseif ($rowqua['HDBud']=='1') $quli= 'Higher Diploma Buddhisum';
                  elseif ($rowqua['HDDaham']=='1') $quli= 'Higher Diploma DahamSarasawiya';
                  elseif ($rowqua['HDTamil']=='1') $quli= 'Higher Diploma Tamil';
                  elseif ($rowqua['Darmacharya']=='1') $quli= 'Dharmacharya';
                  elseif ($rowqua['PrachinaM']=='1') $quli= 'Prachina Maddhyam';
                  elseif ($rowqua['PrachinaP']=='1') $quli= 'Prachina Praramba';
                  elseif ($rowqua['Degree']=='1') $quli= 'Degree';
                  elseif ($rowqua['Ctest']=='1') $quli= 'Common Test';
                  
                  
/*
                  if($rowqua['class'] == 'Pending'){
                      $row['pending'] = true;
                  }

                  while($rowqua = $db->Next_Record($resultqua)){
                      $row['q_degree'] = $row['q_degree'] . ', ' . $rowqua['degree'];
                      $row['q_institute'] = $row['q_institute'] . ', ' . $rowqua['institute'];
                      $row['q_class'] = $row['q_class'] . ', ' . $rowqua['class'];

                      if($rowqua['class'] == 'Pending'){
                          $row['pending'] = true;
                      }
                  } */
            ?>
             <td>
                <?php echo $quli ?>
            </td>

            <?php
            
            $applicantID = $row['applicantID'];
            $querysub = "SELECT * FROM  ba_subjects WHERE applicantID='$applicantID'";
           
            $resultsub= $db->executeQuery($querysub);
            
            $row['pending'] = false;

            $rowqua = $db->Next_Record($resultsub);

          
            
           
           
            if ($rowqua['bp']=='1') $sub1= 'Buddist Philosophy';
            if ($rowqua['bc']=='1') $sub2= 'Buddist Culture';
            if ($rowqua['pali']=='1') $sub3= 'Pali';
            if ($rowqua['san']=='1') $sub4= 'Sanskrit';
            if ($rowqua['eng']=='1') $sub5= 'English';
            if ($rowqua['arch']=='1') $sub6= 'Archaeology';
            if ($rowqua['rs']=='1') $sub7= 'Religious Study';
            if ($rowqua['sin']=='1') $sub8= 'Sinhala';
            if ($rowqua['esin']=='1')  $sub9= 'Sinhala';
            if ($rowqua['bcon']=='1') $sub10= 'Buddist Councelling';
            if ($rowqua['tamil']=='1') $sub11= 'Tamil';
            if ($rowqua['ctamil']=='1') $sub12= 'Tamil';
           
            
            
/*
            if($rowqua['class'] == 'Pending'){
                $row['pending'] = true;
            }

            while($rowqua = $db->Next_Record($resultqua)){
                $row['q_degree'] = $row['q_degree'] . ', ' . $rowqua['degree'];
                $row['q_institute'] = $row['q_institute'] . ', ' . $rowqua['institute'];
                $row['q_class'] = $row['q_class'] . ', ' . $rowqua['class'];

                if($rowqua['class'] == 'Pending'){
                    $row['pending'] = true;
                }
            } */
      ?>



        <td>
                <?php echo ($sub1."-". $sub2."-". $sub3."-". $sub4."-". $sub5."-". $sub6."-". $sub7."-". $sub8."-". $sub12) ?>
            </td>
            <td>
                <?php echo ($sub9."-". $sub10."-". $sub11) ?>
            </td>

            
            <td align="right" <?php if($row['payment'] < 1000) echo 'bgcolor=#f4a261' ?> >
                <?php echo $row['payment'] ?>
            </td>
            <td align="center">
                <?php if ($row['selection'] == 'Cancel') echo '';  else echo $row['selection']; ?>
            </td>
            <td align="right">
                <?php echo $row['c_payment'] ?>
            </td>
            <td>
                <input name="btnDetails" type="button" style="width:30px; font-size:smaller; padding-bottom:2px; padding-top:2px;" value="Details" onclick="document.location.href ='applicantDetailsBA.php?studentID=<?php echo $row['applicantID'] ?>&page=<?php echo $pageNum?>&select=<?php echo $select?>&acyear=<?php echo $acyear?>'" class="button" style="width:60px;" />
            </td>
            <td>
                <input name="btnEdit" type="button" style="width:30px; font-size:smaller; padding-bottom:2px; padding-top:2px;" value="Edit" onclick="document.location.href ='applicantEditBA.php?studentID=<?php echo $row['applicantID'] ?>&page=<?php echo $pageNum?>&select=<?php echo $select?>&acyear=<?php echo $acyear?>'" class="button" style="width:60px;" />
            </td>
            <td>
                <input name="btnDelete" type="button" style="width:30px; font-size:smaller; padding-bottom:2px; padding-top:2px;" value="Delete" class="button" onclick="if (MsgOkCancel()) document.location.href ='applicantAdmin.php?cmd=delete&studentID=<?php echo $row['studentID'] ?>&page=<?php echo $pageNum?>&select=<?php echo $select?>&acyear=<?php echo $acyear?>'" style="width:60px;" />
            </td>
        </tr>
        <?php
              }

        ?>
    </table>
</form>
<?php
              $self = $_SERVER['PHP_SELF'];
              if ($pageNum > 1)
              {
                  $page  = $pageNum - 1;
                  $prev  = " <a class=\"link\" href=\"$self?page=$page&select=$select&acyear=$acyear\">[Prev]</a> ";
                  $first = " <a class=\"link\" href=\"$self?page=1&select=$select&acyear=$acyear\">[First Page]</a> ";
              }
              else
              {
                  $prev  = '&nbsp;'; // we're on page one, don't print previous link
                  $first = '&nbsp;'; // nor the first page link
              }

              if ($pageNum < $numPages)
              {
                  $page = $pageNum + 1;
                  $next = " <a class=\"link\" href=\"$self?page=$page&select=$select&acyear=$acyear\">[Next]</a> ";
                  $last = " <a class=\"link\" href=\"$self?page=$numPages&select=$select&acyear=$acyear\">[Last Page]</a> ";
              }
              else
              {
                  $next = '&nbsp;'; // we're on the last page, don't print next link
                  $last = '&nbsp;'; // nor the last page link
              }

              echo "
<form id=\"form2\" name=\"form2\" method=\"post\">
<table border=\"0\" align=\"center\" width=\"100%\">
<tr>
<td width=\"20%\">".$first."</td>
<td width=\"10%\">".$prev."</td>
<td width=\"10%\">"."$pageNum of $numPages"."</td>
<td width=\"10%\">".$next."</td>
<td width=\"30%\">".$last."</td>
<td width=\"20%\">
    <label>Page : </label>
    <input id=\"select1\" name=\"select1\" type=\"text\" value=\"".$select."\" hidden />    
    <input id=\"acyear1\" name=\"acyear1\" type=\"text\" value=\"".$acyear."\" hidden />    
    <input id=\"page\" name=\"page\" type=\"number\" min=\"1\" max=\"".$numPages."\" />
    <input type=\"button\" onclick=\"document.form2.submit()\" value=\"Go\" />
</td>
</tr>
</table>
</form>";
          }else echo "<p>No students.</p>";

?>

<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Applicant - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='applicantAdmin.php'>Applicant</a></li></ul>";
//Apply the template
include("master_sms_external.php");
?>