<?php
  //Buffer larger content areas like the main page content
  ob_start();
  session_start();
?>

<h1 class="pagetitle">Student Management System</h1><br/>
<table class="panel" width="auto">
	<tr>
        <td valign="top" width="400">
        	<h2>Enrolment Related</h2><br/>
            <ul>
            	<li><a href="studentAdmin.php">Student</a></li>
                <li><a href="courseAdmin.php">Course</a></li>
                <li><a href="subjectAdmin.php">Subject</a></li>
				 <li><a href="subcrs2.php">Sub Course</a></li>
                <li><a href="effortReason.php">Effort Reasons</a></li>
                <li><a href="coursecombination2.php">Course Combination</a></li>
				 <li><a href="crs_subject.php">Combination Subject</a></li>
                <li><a href="reportEnrollRelated.php">Reports</a></li>
            </ul>
        </td>
        <td valign="top" width="400">
        	<h2>Lecture Related</h2><br/>
            <ul>
            	<li><a href="lectureSchedule.php">Lecture Schedule</a></li>
                <li><a href="venue.php">Venue</a></li>
                <li><a href="lecturer.php">Lecturer</a></li>
                <li><a href="timeSlot.php">Time slot</a></li>
                <li><a href="reportTimeTable.php">Reports</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td valign="top">
        	<h2>Exam Related</h2><br/>
            <ul>
            	<li><a href="examAdmin.php">Exam</a></li>
                <li><a href="examSchedule.php">Exam Schedule</a></li>
                <li><a href="examAdmission.php">Admission Card</a></li>
                <li><a href="examAttendance.php">Attendance</a></li>
                <li><a href="examTranscript.php">Academic Transcript</a></li>
                <li><a href="finalResult.php">Exam Result</a></li>
            </ul>
        </td>
		 <td valign="top" width="400">
        	<h2>Reports</h2><br/>
            <ul>
            	<li><a href="paymentDetails.php">Payment Details</a></li>
                <li><a href="admissionList.php">Admission List</a></li>
                
            </ul>
        </td>
        
    </tr>
<tr>

        <td valign="top">
        	<h2>System Users</h2><br/>
            <ul>
            	<li><a href="userNew.php">New User</a></li>
                
            </ul>
        </td>
        <td></td>
    </tr>
</table>

<?php
  //Assign all Page Specific variables
  $pagemaincontent = ob_get_contents();
  ob_end_clean();
  $pagetitle = "Student Management System (External) - Buddhist & Pali University of Sri Lanka";
  $navpath = "<ul><li>Home</li></ul>";
  //Apply the template
  include("master_sms_external.php");
?>