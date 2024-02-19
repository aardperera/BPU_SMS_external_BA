<?php
  //Buffer larger content areas like the main page content
  ob_start();
 ?>
 
 <?php
 
  include('dbAccess.php');

$db = new DBOperations();
  
   
   
   
   session_start();
  
  $rowsPerPage = 10;
  $pageNum = 1;
  
  if(isset($_GET['page'])) $pageNum = $_GET['page'];

 $query = "SELECT * FROM examschedule JOIN subject ON examschedule.subjectID=subject.subjectID";
 
 
  
  //Set filter according  to list box values
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
  	$pageNum = 1;
	$medium = $_POST['lstMedium'];
	$level = $_POST['lstLevel'];
	$acYear = $_POST['lstAcYear'];
	//$month = $_POST['lstMonth'];
	
	$_SESSION['medium'] = $medium;
	$_SESSION['level'] = $level;
	$_SESSION['acYear'] = $acYear;
	//$_SESSION['month'] = $month;
	
	$subQuery = filterQuery($medium,$level,$acYear);
	$query = $query.$subQuery;
  }
  
  else if (isset($_SESSION['medium']) && isset($_SESSION['level']) && isset($_SESSION['acYear']))
  {
	$medium = $_SESSION['medium'];
	$level = $_SESSION['level'];
	$acYear = $_SESSION['acYear'];
  	$subQuery = filterQuery($medium,$level,$acYear);
	$query = $query.$subQuery;
  }
  
  function filterQuery($medium,$level,$acYear)
  {
	$subQuery = "";
	if ($medium<>"0")
	{
		$subQuery = " WHERE medium='".$medium."'"; // (1,_,_)
		if ($level<>0)
		{
			$subQuery = $subQuery." AND level='".$level."'"; // (1,1,_)
			if ($acYear<>0)
				$subQuery = $subQuery." AND acYear='".$acYear."'"; // (1,1,1)
		}
		else if ($acYear<>0)
			$subQuery = $subQuery." AND acYear='".$acYear."'"; // (1,0,1)
	}
	else
	{
		if ($level<>0)
		{
			$subQuery = " WHERE level='".$level."'"; // (0,1,_)
			if ($acYear<>0)
				$subQuery = $subQuery." AND acYear='".$acYear."'"; // (0,1,1)
		}
		else if ($acYear<>0)
			$subQuery = " WHERE acYear='".$acYear."'"; // (0,0,1)
	}
	$subQuery = $subQuery." ORDER BY date";
	return $subQuery;
  }
  
  $_SESSION['query'] = $query;
  
  // counting the offset
	$offset = ($pageNum - 1) * $rowsPerPage;
	$numRows = $db->Row_Count($db->executeQuery($query));
	$numPages = ceil($numRows/$rowsPerPage);
  
  	$pageQuery = $query." LIMIT $offset, $rowsPerPage";
	//echo $pageQuery;
	$pageResult = $db->executeQuery($pageQuery);
	
 ?>
 
 <h1>Exam Schedule</h1>
 <form method="post" action="rptExamSchedule.php" class="plain">
  <table style="margin-left:8px" class="panel">
  	<tr>
		
    	<td><input name="btnNew" type="button" value="New" onclick="document.location.href = 'examNew.php';" class="button" /></td>
        <!--<td>&nbsp;</td>-->
		
        <td><input name="btnGetReport" type="submit" value="Get Report" class="button" /></td>
	</tr>
	<tr>	
        <td>With Heading</td><td><input name="txtReportHeading" type="text" /></td>
		<td>With Time period</td><td><input name="txtTimePeriod" type="text" /></td>
		
    </tr>
  </table>
 </form>
 <form method="post" action="" class="plain">
  <table style="margin-left:8px" class="panel">
  	<tr>
        <td>Medium</td>
        <td>
            <?php
				$medium = "0";
            	if (isset($_POST['lstMedium'])) $medium = $_POST['lstMedium']; 
				else if (isset($_SESSION['medium']))  $medium = $_SESSION['medium'];
			?>
            <select name="lstMedium" id="lstMedium" onchange="this.form.submit();">
            	<option value='0'>All</option>
            	<option <?php if ($medium == 'English') echo "selected='selected'";?> value="English">English</option>
                <option <?php if ($medium == 'Sinhala') echo "selected='selected'";?> value="Sinhala">Sinhala</option>
            </select>
        </td>
        <td>&nbsp;</td>
        <td>Level</td>
        <td>
            <?php
				$level = 0;
            	if (isset($_POST['lstLevel'])) $level = $_POST['lstLevel']; 
				else if (isset($_SESSION['level']))  $level = $_SESSION['level'];
			?>
            <select name="lstLevel" id="lstLevel" onchange="this.form.submit();">
            	<option value="0">All</option>
            	<option <?php if ($level == 1) echo "selected='selected'";?> value="1">1</option>
                <option <?php if ($level == 2) echo "selected='selected'";?> value="2">2</option>
                <option <?php if ($level == 3) echo "selected='selected'";?> value="3">3</option>
                <option <?php if ($level == 4) echo "selected='selected'";?> value="4">4</option>
            </select>
        </td>
        <td>&nbsp;</td>
		
				
        <td>Ac. Year</td>
        <td>
            <select name="lstAcYear" id="lstAcYear" onchange="this.form.submit();">
            <?php
				$result = $db->executeQuery("SELECT acYear FROM examschedule");
				if ($db->Row_Count($result)>0)
				{
					echo "<option value='0'>All</option>";
					while ($row= $db->Next_Record($result))
					{
						if (isset($_POST['lstAcYear']) && $_POST['lstAcYear']==$row['acYear'])
							echo "<option selected='selected' value='".$row['acYear']."'>".$row['acYear']."</option>";
						else if (isset($_SESSION['acYear']) && $_SESSION['acYear']==$row['acYear'])
							echo "<option selected='selected' value='".$row['acYear']."'>".$row['acYear']."</option>";
						else echo "<option value='".$row['acYear']."'>".$row['acYear']."</option>";
					}
				} 
			?> 
            </select>
        </td>
		
		
		
   	</tr>
  </table>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Exam Schedule - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li><a href='index.php'>Home </a></li><li>Exam Schedule</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>