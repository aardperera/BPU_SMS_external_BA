<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<script language="javascript">
	function popUp(URL) {
		day = new Date();
		id = day.getTime();
		eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=600,height=400,left = 340,top = 312');");
	}
	
	function ChangeColor(tableRow, highLight)
    {
    	if (highLight)
		{
			tableRow.style.backgroundColor = 'rgb(240,240,240)';
			document.body.style.cursor = 'pointer';
		}
    	else
		{
			tableRow.style.backgroundColor = 'white';
			document.body.style.cursor = 'default';
		}
  	}

  	function DoNav(tableRow)
  	{
		var accNo = tableRow.id.toString();
  		document.location.href = 'itemDetails.php?accNo=' + accNo;
  	}
	
	function validateEmpty(fld)
	{
		var error = "";
	 
		if (fld.value.length == 0) {
			fld.style.background = '#FF9999'; 
			error = "The required field has not been filled in.\n"
		} else {
			fld.style.background = 'White';
		}
		return error;  
	}
	
	function validate_required(field)
	{
	with (field)
	  {
	  if (value==null||value=="")
		{
			//alert(alerttxt);
			field.style.background = '#FF9999'; 
			return false;
		}
	  else
		{
			field.style.background = 'White';
			return true;
		}
	  }
	}
</script>
<title>Exam Schedule - Student Management System (External) - Buddhist & Pali University of Sri Lanka</title>
<meta name="description" content="The Buddhist & Paali University of Sri Lanka" />
<meta name="keywords" content="Buddhist, Paali, University, Sri lanka" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" media="screen,projection,print" href="css/layout_setup.css" />
<link rel="stylesheet" type="text/css" media="screen,projection,print" href="css/layout_text.css" />
</head>
<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->
<body>
<!-- Main Page Container -->
<div class="page-container">
  <!-- For alternative headers START PASTE here -->
  <!-- A. header--->
  <div class="header">
    <!-- A.1 header-TOP -->
    <div class="header-top">
      <!-- Navigation Level 1 -->
      <div class="nav1">
        <ul>
          <li><a href="">Home</a></li>
          <li><a href="">Sitemap</a></li>
        </ul>
      </div>
    </div>
    <!-- A.2 header-MIDDLE -->
    <div class="header-middle">
      <!-- Site message
      <div class="sitemessage">
        <h1>EASY &bull; FLEXIBLE &bull; ROBUST</h1>
        <h2>The third generation Multiflex is<br />
          here, now with cooler Design<br />
          features and easier code!</h2>
        <h3> <a href="http://www.free-css.com/">&rsaquo;&rsaquo;&nbsp;More details</a></h3>
      </div> -->
    </div>
    <!-- A.3 header-BOTTOM -->
    <div class="header-bottom">
      <!-- Navigation Level 2 (Drop-down menus) -->
      <div class="nav2">
        <!-- Navigation item -->
        <ul>
          <li><a href="index.php">Home</a></li>
        </ul>
        <!-- Navigation item -->
        <ul>
          <li><a>Enrollment Related
            <!--[if IE 7]><!-->
            </a>
            <!--<![endif]-->
            <!--[if lte IE 6]><table><tr><td><![endif]-->
            <ul>
              <li><a href="studentAdmin.php">Student</a></li>
              <li><a href="courseAdmin.php">Course</a></li>
              <li><a href="subjectAdmin.php">Subject</a></li>
              <li><a href="reportEnrollRelated.php">Reports</a></li>
            </ul>
            <!--[if lte IE 6]></td></tr></table></a><![endif]-->
          </li>
        </ul>
        <!-- Navigation item -->
        <ul>
          <li><a>Lecture Related
            <!--[if IE 7]><!-->
            </a>
            <!--<![endif]-->
            <!--[if lte IE 6]><table><tr><td><![endif]-->
            <ul>
              <li><a href="lectureSchedule.php">Lecture Schedule</a></li>
              <li><a href="venue.php">Venue</a></li>
              <li><a href="lecturer.php">Lecturer</a></li>
              <li><a href="timeSlot.php">Timeslot</a></li>
              <li><a href="reportTimeTable.php">Reports</a></li>
            </ul>
            <!--[if lte IE 6]></td></tr></table></a><![endif]-->
          </li>
        </ul>
        <!-- Navigation item -->
        <ul>
          <li><a>Exam Related
            <!--[if IE 7]><!-->
            </a>
            <!--<![endif]-->
            <!--[if lte IE 6]><table><tr><td><![endif]-->
            <ul>
              <li><a href="examAdmin.php">Exam</a></li>
              <li><a href="examSchedule.php">Exam Schedule</a></li>
              <li><a href="examAdmission">Admission Card</a></li>
              <li><a href="examAttendance.php">Attendance</a></li>
               <li><a href="examTranscript.php">Transcript</a></li>
            </ul>
            <!--[if lte IE 6]></td></tr></table></a><![endif]-->
          </li>
        </ul>
      </div>
    </div>
    <!-- A.4 header-BREADCRUMBS -->
    <!-- Breadcrumbs -->
    <div class="header-breadcrumbs">
     <ul><li><a href='home.php'>Home </a></li><li>Exam Schedule</li></ul>    </div>
  </div>
  <!-- For alternative headers END PASTE here -->
  <!-- B. MAIN -->
  <div class="main">
    <!-- B.1 MAIN NAVIGATION -->
    <div class="main-navigation">
      <!-- Navigation Level 3 -->
      <div class="round-border-topright"></div>
      <h1 class="first">Quick Links</h1>
      <!-- Navigation with grid style -->
      <dl class="nav3-grid">
        <dt> <a href="home.php">Home</a></dt>
        <dt> <a>Enrollment Related</a></dt>
            <dd> <a href="studentAdmin.php">Student</a></dd>
            <dd> <a href="courseAdmin.php">Course</a></dd>
            <dd> <a href="subjectAdmin.php">Subject</a></dd>
            <dd> <a href="reportEnrollRelated.php">Reports</a></dd>
        <dt> <a>Lecture Related</a></dt>
        	<dd> <a href="lectureSchedule.php">Lecture Schedule</a></dd>
            <dd> <a href="venue.php">Venue</a></dd>
            <dd> <a href="lecturer.php">Lecturer</a></dd>
            <dd> <a href="timeSlot.php">Time Slot</a></dd>
            <dd> <a href="reportTimeTable.php">Reports</a></dd>
        <dt> <a>Exam Related</a></dt>
            <dd> <a href="examAdmin.php">Exam</a></dd>
            <dd> <a href="examSchedule.php">Exam Schedule</a></dd>
            <dd> <a href="examAdmission.php">Admission Card</a></dd>
            <dd> <a href="examAttendance.php">Attendance</a></dd>
            <dd> <a href="examTranscript.php">Academic Transcript</a></dd>
      </dl>
    </div>
    <!-- B.1 MAIN CONTENT -->
    <div class="main-content">
      
 <script language="javascript">
 	function MsgOkCancel()
	{
		var message = "Please confirm to DELETE this entry...";
		var return_value = confirm(message);
		return return_value;
	}
 </script>
 
 <h1>Exam Schedule</h1>
 <form method="post" action="rptExamSchedule1.php" class="plain">
  <table style="margin-left:8px" class="panel">
  	<tr>
    	<td><input name="btnNew" type="button" value="New" onclick="document.location.href = 'examNew.php';" class="button" /></td>
        <td>&nbsp;</td>
        <td><input name="btnGetReport" type="submit" value="Get Report" class="button" /></td>
        <td>With Heading</td>
        <td>
		<select name="course">
			<option value="Diploma Level">Diploma Level</option>
			<option value="Certificate Level">Certificate Level</option>
		</select>
		</td>
    </tr>
  	<tr>
        <td align="right">Medium</td>
        <td>
        <select name="Medium">
            <option value='All'>All</option>
            <option  value="English">English</option>
            <option  value="Sinhala">Sinhala</option>
        </select>
        </td>
        <td align="right">Level</td>
        <td align="left">
		<select name="Level">
           	<option value="0">All</option>
           	<option  value="1">1</option>
            <option  value="2">2</option>
            <option  value="3">3</option>
            <option  value="4">4</option>
         </select>
        </td>
        <td>&nbsp;</td>
		 <td>Ac. Year</td>
        <td>
            <select name="lstAcYear" id="lstAcYear" onchange="this.form.submit();">
                        </select>
        </td>
   	</tr>
  
  </form>
<table border="0" align="center" width="50%"><tr><td width="20%">&nbsp;</td><td width="10%">&nbsp;</td><td width="10%"></td><td width="10%">&nbsp;</td><td width="30%">&nbsp;</td></tr></table>
    </div>
  </div>
  <!-- C. FOOTER AREA -->
  <div class="footer">
    <p>Copyright &copy; 2010 Buddhist & Pali University of Sri Lanka | All Rights Reserved</p>
    <p class="credits">Powered by <a href="http://www.accimt.ac.lk">Arthur C. Clarke Institute for Modern Technologies</a></p>
  </div>
</div>
</body>
</html>

