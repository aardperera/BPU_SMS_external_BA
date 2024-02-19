<script language="javascript"></script>
<style>
table {
    border-collapse: collapse;
}

table,
td,
th {
    border: 1px solid black;
}

.no-border {
    border: none !important;
}
</style>
<div style="margin-left: 40px; margin-right: 40px;">
    <center>
        <?php
	  include('dbAccess.php');

$db = new DBOperations();
	 $courseID=$_GET['courseID'];
	 $subcrsID=$_GET['subcrsID'];
	 $emonth=$_GET['emonth'];
	 $acyear=$_GET['acyear'];
echo '<img src="logo.png" width="75" height="75" />';
?>
        <h3><u>BUDDHIST AND PALI UNIVERSITY OF SRI LANKA<br>
                <?php
$examCourse = 'Bachlor of Arts (General) External Degree I Examination';
echo $examCourse; echo ' - '; echo date("Y"); echo ' ('; echo date('F'); echo ')';
?> </u></h3>
    </center>
    <br>
    <p>This is to inform you that you have obtained following results at the <?php echo $examCourse;?> held in
        <?php echo date('Y F');?></p>
    <br>
    <table class="no-border">
        <tr>
            <td class="no-border">Name</td>
            <td class="no-border">:</td>
            <td class="no-border"></td>
        </tr>
        <tr>
            <td class="no-border">Index No.</td>
            <td class="no-border">:</td>
            <td class="no-border"></td>
        </tr>
        <tr>
            <td class="no-border">Medium</td>
            <td class="no-border">:</td>
            <td class="no-border"></td>
        </tr>
    </table>
    <br><br>
    <div style="overflow: auto;  white-space: nowrap; margin-left: 0px; margin-right: 0px;">
        <form method="post">
            <table>
                <!-- Main Heading Row -->
                <tr style="text-align: center;">
                    <!-- Fixed -->
                    <th>
                        Code of the Unit
                    </th>
                    <th>
                        Title of the Question Paper
                    </th>
                    <th>
                        Grade
                    </th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
        </form>
        <table class="no-border" style="width: 100%;">
            <tr>
                <td class="no-border" style="text-align: left;">Prepared by:</td>
                <td class="no-border" style="text-align: left;">Checked by:</td>
                <th class="no-border" rowspan="2">
                    <table style="width: 90%;">
                        <tr>
                            <td colspan="3">Grading Scheme</td>
                        </tr>
                        <tr>
                            <td>Marks</td>
                            <td>Grade</td>
                            <td>Credit<br>Value</td>
                        </tr>
                        <tr>
                            <td>85-100</td>
                            <td>A+</td>
                            <td>4.00</td>
                        </tr>
                        <tr>
                            <td>70-84</td>
                            <td>A</td>
                            <td>4.00</td>
                        </tr>
                        <tr>
                            <td>65-69</td>
                            <td>A-</td>
                            <td>3.70</td>
                        </tr>
                        <tr>
                            <td>60-64</td>
                            <td>B+</td>
                            <td>3.30</td>
                        </tr>
                        <tr>
                            <td>55-59</td>
                            <td>B</td>
                            <td>3.00</td>
                        </tr>
                        <tr>
                            <td>50-54</td>
                            <td>B-</td>
                            <td>2.70</td>
                        </tr>
                        <tr>
                            <td>45-49</td>
                            <td>C+</td>
                            <td>2.30</td>
                        </tr>
                        <tr>
                            <td>40-44</td>
                            <td>C</td>
                            <td>2.00</td>
                        </tr>
                        <tr>
                            <td>35-39</td>
                            <td>C-</td>
                            <td>1.70</td>
                        </tr>
                        <tr>
                            <td>30-34</td>
                            <td>D+</td>
                            <td>1.30</td>
                        </tr>
                        <tr>
                            <td>25-29</td>
                            <td>D</td>
                            <td>1.00</td>
                        </tr>
                        <tr>
                            <td>00-24</td>
                            <td>E</td>
                            <td>0.00</td>
                        </tr>
                    </table>
                </th>
            </tr>
            <tr>
                <td style="vertical-align: bottom;" class="no-border" colspan="2">Ven Boghamuwe Dheerananda
                    Thero<br>Deputy
                    Registrar (Acting)<br>(Postgraduate Degrees and
                    External
                    Examination)<br>For Registrar
                    <br><br><br><br>
                    <b style="font-size: 12px;">**The candidates should obtain at least 40% marks to pass a subject.</b>
                </td>
            </tr>
        </table>
    </div>
</div>