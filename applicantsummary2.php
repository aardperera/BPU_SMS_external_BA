<?php
//Buffer larger content areas like the main page content
ob_start();
session_start();
if (!isset($_SESSION['authenticatedUser'])) {
    echo $_SESSION['authenticatedUser'];
    header("Location: index.php");
}

//print $_SESSION['courseID'] ;

include('dbAccess.php');
$db = new DBOperations();

$yquery = "SELECT distinct acyear FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' order by acyear";

$ddata = ["P.G.D. - Buddhist Studies", "M.A (One Year/Two Year) - in Sri Lanka", "M.A (One Year/Two Year) - Affiliated College", "M.Phil.", "Ph.D"];

$resulty = $db->executeQuery($yquery);

while($rowy = $db->Next_Record($resulty)){
    //P.G.D. B.S.
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'P.G.D. - Buddhist Studies' AND acyear='".$rowy[0]."' AND country='Sri Lanka'";
    $data[$rowy[0]][0][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'P.G.D. - Buddhist Studies' AND acyear='".$rowy[0]."' AND country!='Sri Lanka'";
    $data[$rowy[0]][0][1] = $db->numRows($db->executeQuery($query));

    //affiliate - No - Countries MA
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND (affiliate = '' OR affiliate is null) AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND country='Sri Lanka'";
    $data[$rowy[0]][1][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND (affiliate = '' OR affiliate is null) AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND country!='Sri Lanka'";
    $data[$rowy[0]][1][1] = $db->numRows($db->executeQuery($query));

    //affiliate - Yes - Countries MA
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND affiliate = 'Yes' AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND country='Sri Lanka'";
    $data[$rowy[0]][2][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND affiliate = 'Yes' AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND country!='Sri Lanka'";
    $data[$rowy[0]][2][1] = $db->numRows($db->executeQuery($query));

    //M.Phil.
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'M.Phil.' AND acyear='".$rowy[0]."' AND country='Sri Lanka'";
    $data[$rowy[0]][3][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'M.Phil.' AND acyear='".$rowy[0]."' AND country!='Sri Lanka'";
    $data[$rowy[0]][3][1] = $db->numRows($db->executeQuery($query));

    //Phd.
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'Phd.' AND acyear='".$rowy[0]."' AND country='Sri Lanka'";
    $data[$rowy[0]][4][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'Phd.' AND acyear='".$rowy[0]."' AND country!='Sri Lanka'";
    $data[$rowy[0]][4][1] = $db->numRows($db->executeQuery($query));
}

$queryc[] = "SELECT distinct country FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree='P.G.D. - Buddhist Studies'";
$queryc[] = "SELECT distinct country FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND (affiliate = '' OR affiliate is null) AND degree LIKE '%M.A.%'";
$queryc[] = "SELECT distinct country FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND affiliate='Yes' AND degree LIKE '%M.A.%'";
$queryc[] = "SELECT distinct country FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree='M.Phil.'";
$queryc[] = "SELECT distinct country FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree='Phd.'";


// for gender
$resulty = $db->executeQuery($yquery);
while($rowy = $db->Next_Record($resulty)){
    //PGD BS
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'P.G.D. - Buddhist Studies' AND acyear='".$rowy[0]."' AND gender = 'Male'";
    $datag[$rowy[0]][0][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'P.G.D. - Buddhist Studies' AND acyear='".$rowy[0]."' AND gender = 'Female'";
    $datag[$rowy[0]][0][1] = $db->numRows($db->executeQuery($query));

    //affiliate - No - Countries MA
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND (affiliate = '' OR affiliate is null) AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND gender = 'Male'";
    $datag[$rowy[0]][1][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND (affiliate = '' OR affiliate is null) AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND gender = 'Female'";
    $datag[$rowy[0]][1][1] = $db->numRows($db->executeQuery($query));

    //affiliate - Yes - Countries MA
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND affiliate = 'Yes' AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND gender = 'Male'";
    $datag[$rowy[0]][2][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND affiliate = 'Yes' AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND gender = 'Female'";
    $datag[$rowy[0]][2][1] = $db->numRows($db->executeQuery($query));

    //M.Phil.
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'M.Phil.' AND acyear='".$rowy[0]."' AND gender = 'Male'";
    $datag[$rowy[0]][3][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'M.Phil.' AND acyear='".$rowy[0]."' AND gender = 'Female'";
    $datag[$rowy[0]][3][1] = $db->numRows($db->executeQuery($query));

    //Phd.
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'Phd.' AND acyear='".$rowy[0]."' AND gender = 'Male'";
    $datag[$rowy[0]][4][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'Phd.' AND acyear='".$rowy[0]."' AND gender = 'Female'";
    $datag[$rowy[0]][4][1] = $db->numRows($db->executeQuery($query));
}

// for title
$resulty = $db->executeQuery($yquery);
while($rowy = $db->Next_Record($resulty)){
    //PGD BS
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'P.G.D. - Buddhist Studies' AND acyear='".$rowy[0]."' AND title = 'Ven.'";
    $datat[$rowy[0]][0][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'P.G.D. - Buddhist Studies' AND acyear='".$rowy[0]."' AND title != 'Ven.'";
    $datat[$rowy[0]][0][1] = $db->numRows($db->executeQuery($query));


    //affiliate - No - Countries MA
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND (affiliate = '' OR affiliate is null) AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND title = 'Ven.'";
    $datat[$rowy[0]][1][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND (affiliate = '' OR affiliate is null) AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND title != 'Ven.'";
    $datat[$rowy[0]][1][1] = $db->numRows($db->executeQuery($query));

    //affiliate - Yes - Countries MA
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND affiliate = 'Yes' AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND title = 'Ven.'";
    $datat[$rowy[0]][2][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND affiliate = 'Yes' AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND title != 'Ven.'";
    $datat[$rowy[0]][2][1] = $db->numRows($db->executeQuery($query));

    //M.Phil.
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'M.Phil.' AND acyear='".$rowy[0]."' AND title = 'Ven.'";
    $datat[$rowy[0]][3][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'M.Phil.' AND acyear='".$rowy[0]."' AND title != 'Ven.'";
    $datat[$rowy[0]][3][1] = $db->numRows($db->executeQuery($query));

    //Phd.
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'Phd.' AND acyear='".$rowy[0]."' AND title = 'Ven.'";
    $datat[$rowy[0]][4][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'Phd.' AND acyear='".$rowy[0]."' AND title = 'Ven.'";
    $datat[$rowy[0]][4][1] = $db->numRows($db->executeQuery($query));
}

// for meidum
$resulty = $db->executeQuery($yquery);
while($rowy = $db->Next_Record($resulty)){
    //PGD BS
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'P.G.D. - Buddhist Studies' AND acyear='".$rowy[0]."' AND medium = 'Sinhala'";
    $datam[$rowy[0]][0][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'P.G.D. - Buddhist Studies' AND acyear='".$rowy[0]."' AND medium = 'English'";
    $datam[$rowy[0]][0][1] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'P.G.D. - Buddhist Studies' AND acyear='".$rowy[0]."' AND medium != 'English' AND medium != 'Sinhala'";
    $datam[$rowy[0]][0][2] = $db->numRows($db->executeQuery($query));


    //affiliate - No - Countries MA
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND (affiliate = '' OR affiliate is null) AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND medium = 'Sinhala'";
    $datam[$rowy[0]][1][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND (affiliate = '' OR affiliate is null) AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND medium = 'English'";
    $datam[$rowy[0]][1][1] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND (affiliate = '' OR affiliate is null) AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND medium != 'English' AND medium != 'Sinhala'";
    $datam[$rowy[0]][1][2] = $db->numRows($db->executeQuery($query));

    //affiliate - Yes - Countries MA
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND affiliate = 'Yes' AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND medium = 'Sinhala'";
    $datam[$rowy[0]][2][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND affiliate = 'Yes' AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND medium = 'English'";
    $datam[$rowy[0]][2][1] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND affiliate = 'Yes' AND degree LIKE '%M.A.%' AND acyear='".$rowy[0]."' AND medium != 'English' AND medium != 'Sinhala'";
    $datam[$rowy[0]][2][2] = $db->numRows($db->executeQuery($query));

    //M.Phil.
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'M.Phil.' AND acyear='".$rowy[0]."' AND medium = 'Sinhala'";
    $datam[$rowy[0]][3][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'M.Phil.' AND acyear='".$rowy[0]."' AND medium = 'English'";
    $datam[$rowy[0]][3][1] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'M.Phil.' AND acyear='".$rowy[0]."' AND medium != 'English' AND medium != 'Sinhala'";
    $datam[$rowy[0]][3][2] = $db->numRows($db->executeQuery($query));

    //Phd.
    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'Phd.' AND acyear='".$rowy[0]."' AND medium = 'Sinhala'";
    $datam[$rowy[0]][4][0] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'Phd.' AND acyear='".$rowy[0]."' AND medium = 'English'";
    $datam[$rowy[0]][4][1] = $db->numRows($db->executeQuery($query));

    $query = "SELECT id FROM ma_applicant WHERE courseID='".$_SESSION['courseId']."' AND degree = 'Phd.' AND acyear='".$rowy[0]."' AND medium != 'English' AND medium != 'Sinhala'";
    $datam[$rowy[0]][4][2] = $db->numRows($db->executeQuery($query));
}
?>



<h1>
    All Applicants Summary
</h1>

<h2>
    All Applicants - Course Wise
</h2>

<form method="post" action="" class="plain" id="form1" name="form1">
    <table class="applicant" style="width:80%">
        <tr>
            <th style="width:4%;">
                S/No
            </th>
            <th style="width:30%;">
                Course
            </th>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
            <th style="width:10%;">
                <?php echo $rowy[0]; ?>
            </th>
            <?php
            }
            ?>
            <th style="width:10%;">
                Total (All Years)
            </th>
        </tr>
        
        <tbody>
            <?php for($i = 0 ; $i<=4 ; $i++) { ?>
            <tr>
                <td align="center">
                    <?php echo ($i + 1) ; ?>
                </td>
                <td>
                    <?php echo $ddata[$i] ; ?>
                </td>
                <?php
                      $total = 0;
                      $resulty = $db->executeQuery($yquery);
                      while($rowy = $db->Next_Record($resulty)){
                ?>
                <td align="center">
                    <?php $total = $total + $data[$rowy[0]][$i][0] + $data[$rowy[0]][$i][1]; echo ($data[$rowy[0]][$i][0] + $data[$rowy[0]][$i][1]); ?>
                </td>
                <?php
                      }
                ?>
                <td align="center">
                    <?php echo $total; ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</form>

<h2>
    All Applicants - Local / Foreign Wise
</h2>

<form method="post" action="" class="plain" id="form1" name="form1">
    <table class="applicant">
        <tr>
            <th rowspan="2" style="width:10%;">
                S/No
            </th>
            <th rowspan="2">
                Course
            </th>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
                <th colspan="2">
                    <?php echo $rowy[0]; ?>
                </th>
            <th rowspan="2" style="width:10%;">
                Total
            </th>
            <?php
            }
            ?>
            <th rowspan="2" style="width:10%;">
                Total (All Years)
            </th>
        </tr>
        <tr>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
            <th style="width:10%;">
                Local
            </th>
            <th style="width:10%;">
                Foreign
            </th>
            <?php
            }
            ?>
        </tr>
        <tbody>
            <?php for($i = 0 ; $i<=4 ; $i++) { ?>
            <tr>
                <td align="center">
                    <?php echo ($i + 1) ; ?>
                </td>
                <td>
                    <?php echo $ddata[$i] ; ?>
                </td>
                <?php
                      $total = 0;
                $resulty = $db->executeQuery($yquery);
                while($rowy = $db->Next_Record($resulty)){
                ?>
                <td align="center">
                    <?php echo $data[$rowy[0]][$i][0] ; ?>
                </td>
                <td align="center">
                    <?php echo $data[$rowy[0]][$i][1] ; ?>
                </td>
                <td align="center">
                    <?php $total = $total + $data[$rowy[0]][$i][0] + $data[$rowy[0]][$i][1]; echo ($data[$rowy[0]][$i][0] + $data[$rowy[0]][$i][1]); ?>
                </td>
                <?php
                }
                ?>
                <td align="center">
                    <?php echo $total; ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
</form>

<h2>
    All Applicants - Gender Wise
</h2>

<form method="post" action="" class="plain" id="form1" name="form1">
    <table class="applicant">
        <tr>
            <th rowspan="2" style="width:10%;">
                S/No
            </th>
            <th rowspan="2">
                Course
            </th>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
            <th colspan="2">
                <?php echo $rowy[0]; ?>
            </th>
            <th rowspan="2" style="width:10%;">
                Total
            </th>
            <?php
            }
            ?>
            <th rowspan="2" style="width:10%;">
                Total (All Years)
            </th>
        </tr>
        <tr>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
            <th style="width:10%;">
                Male
            </th>
            <th style="width:10%;">
                Female
            </th>
            <?php
            }
            ?>
        </tr>
        <tbody>
            <?php for($i = 0 ; $i<=4 ; $i++) { ?>
            <tr>
                <td align="center">
                    <?php echo ($i + 1) ; ?>
                </td>
                <td>
                    <?php echo $ddata[$i] ; ?>
                </td>
                <?php
                      $total = 0;
                      $resulty = $db->executeQuery($yquery);
                      while($rowy = $db->Next_Record($resulty)){
                ?>
                <td align="center">
                    <?php echo $datag[$rowy[0]][$i][0] ; ?>
                </td>
                <td align="center">
                    <?php echo $datag[$rowy[0]][$i][1] ; ?>
                </td>
                <td align="center">
                    <?php $total = $total + $datag[$rowy[0]][$i][0] + $datag[$rowy[0]][$i][1]; echo ($datag[$rowy[0]][$i][0] + $datag[$rowy[0]][$i][1]); ?>
                </td>
                <?php
                      }
                ?>
                <td align="center">
                    <?php echo $total; ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</form>

<h2>
    All Applicants - Monk / Lay Wise
</h2>

<form method="post" action="" class="plain" id="form1" name="form1">
    <table class="applicant">
        <tr>
            <th rowspan="2" style="width:10%;">
                S/No
            </th>
            <th rowspan="2">
                Course
            </th>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
            <th colspan="2">
                <?php echo $rowy[0]; ?>
            </th>
            <th rowspan="2" style="width:10%;">
                Total
            </th>
            <?php
            }
            ?>
            <th rowspan="2" style="width:10%;">
                Total (All Years)
            </th>
        </tr>
        <tr>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
            <th style="width:10%;">
                Monk
            </th>
            <th style="width:10%;">
                Lay
            </th>
            <?php
            }
            ?>
        </tr>
        <tbody>
            <?php for($i = 0 ; $i<=4 ; $i++) { ?>
            <tr>
                <td align="center">
                    <?php echo ($i + 1) ; ?>
                </td>
                <td>
                    <?php echo $ddata[$i] ; ?>
                </td>
                <?php
                      $total = 0;
                      $resulty = $db->executeQuery($yquery);
                      while($rowy = $db->Next_Record($resulty)){
                ?>
                <td align="center">
                    <?php echo $datat[$rowy[0]][$i][0] ; ?>
                </td>
                <td align="center">
                    <?php echo $datat[$rowy[0]][$i][1] ; ?>
                </td>
                <td align="center">
                    <?php $total = $total + $datat[$rowy[0]][$i][0] + $datat[$rowy[0]][$i][1]; echo ($datat[$rowy[0]][$i][0] + $datat[$rowy[0]][$i][1]); ?>
                </td>
                <?php
                      }
                ?>
                <td align="center">
                    <?php echo $total; ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</form>

<h2>
    All Applicants - Medium Wise
</h2>

<form method="post" action="" class="plain" id="form1" name="form1">
    <table class="applicant">
        <tr>
            <th rowspan="2" style="width:10%;">
                S/No
            </th>
            <th rowspan="2" style="width:25%;">
                Course
            </th>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
            <th colspan="3">
                <?php echo $rowy[0]; ?>
            </th>
            <th rowspan="2" style="width:10%;">
                Total
            </th>
            <?php
            }
            ?>
            <th rowspan="2" style="width:10%;">
                Total (All Years)
            </th>
        </tr>
        <tr>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
            <th style="width:7%;">
                Sinhala
            </th>
            <th style="width:7%;">
                English
            </th>
            <th style="width:7%;">
                Other
            </th>
            <?php
            }
            ?>
        </tr>
        <tbody>
            <?php for($i = 0 ; $i<=4 ; $i++) { ?>
            <tr>
                <td align="center">
                    <?php echo ($i + 1) ; ?>
                </td>
                <td>
                    <?php echo $ddata[$i] ; ?>
                </td>
                <?php
                      $total = 0;
                      $resulty = $db->executeQuery($yquery);
                      while($rowy = $db->Next_Record($resulty)){
                ?>
                <td align="center">
                    <?php echo $datam[$rowy[0]][$i][0] ; ?>
                </td>
                <td align="center">
                    <?php echo $datam[$rowy[0]][$i][1] ; ?>
                </td>
                <td align="center">
                    <?php echo $datam[$rowy[0]][$i][2] ; ?>
                </td>
                <td align="center">
                    <?php $total = $total + $datam[$rowy[0]][$i][0] + $datam[$rowy[0]][$i][1] + $datam[$rowy[0]][$i][2]; echo ($datam[$rowy[0]][$i][0] + $datam[$rowy[0]][$i][1] + $datam[$rowy[0]][$i][2]); ?>
                </td>
                <?php
                      }
                ?>
                <td align="center">
                    <?php echo $total; ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</form>

<h2>
    All Applicants - Country Wise
</h2>

<form method="post" action="" class="plain" id="form1" name="form1">
    <table class="applicant">
        <tr>
            <th rowspan="2">
                S/No
            </th>
            <th rowspan="2">
                Course
            </th>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
            <th colspan="2">
                <?php echo $rowy[0]; ?>
            </th>
            <?php
            }
            ?>
            <th rowspan="2" style="width:10%;">
                Total (All Years)
            </th>
        </tr>
        <tr>
            <?php
            $resulty = $db->executeQuery($yquery);
            while($rowy = $db->Next_Record($resulty)){
            ?>
            <th style="width:10%;">
                Local
            </th>
            <th style="width:10%;">
                Foreign
            </th>
            <?php
            }
            ?>
        </tr>
        <tbody>
            <?php for($i = 0 ; $i<=4 ; $i++) { ?>
            <tr>
                <td align="center">
                    <?php echo ($i + 1) ; ?>
                </td>
                <td style="font-weight:bold">
                    <?php echo $ddata[$i] ; ?>
                </td>
                <?php
                      $total = 0;
                      $resulty = $db->executeQuery($yquery);
                      while($rowy = $db->Next_Record($resulty)){
                ?>
                <td align="center">
                    <?php echo $data[$rowy[0]][$i][0] ; ?>
                </td>
                <td align="center">
                    <?php echo $data[$rowy[0]][$i][1] ; ?>
                </td>
                    <?php $total = $total + $data[$rowy[0]][$i][0] + $data[$rowy[0]][$i][1]; ?>
                <?php
                      }
                ?>
                <td align="center">
                    <?php echo $total; ?>
                </td>
            </tr>
            <?php

            //for countries
            $resultc = $db->executeQuery($queryc[$i] . " order by field(country, 'Sri Lanka') DESC");
            while($rowc = $db->Next_Record($resultc)){
            ?>
            <tr>
                <td></td>
                <td align="right">
                    <?php echo $rowc[0]; ?>
                </td>

                <?php
                $total = 0;
                $resulty = $db->executeQuery($yquery);
                while($rowy = $db->Next_Record($resulty)){
                if($rowc[0] == 'Sri Lanka'){
                    ?>
                <td align="center">
                    <?php
                    $query = str_replace('distinct country', 'id', $queryc[$i]) . " AND acyear='".$rowy[0]."' AND country ='".$rowc[0]."'";
                    echo $db->numRows($db->executeQuery($query));
                    ?>
                </td>
                <td align="center">
                    <?php echo '-'; ?>
                </td>
                <?php 
                } 
                else{
                ?>
                <td align="center">
                    <?php echo '-'; ?>
                </td>
                <td align="center">
                    <?php
                    $query = str_replace('distinct country', 'id', $queryc[$i]) . " AND acyear='".$rowy[0]."' AND country ='".$rowc[0]."'";
                    echo $db->numRows($db->executeQuery($query));
                    ?>
                </td>
                <?php
                }
                ?>
                <?php $total = $total + 0; ?>
                <?php
                }
                ?>
                <td align="center">
                    <?php echo $total; ?>
                </td>
            </tr>

            <?php
            }
            ?>

            <?php } ?>
        </tbody>
    </table>

</form>


<?php
//Assign all Page Specific variables
$pagemaincontent = ob_get_contents();
ob_end_clean();
$pagetitle = "Summary of All Applicant - Students - Student Management System (External) - Buddhist & Pali University of Sri Lanka";
$navpath = "<ul><li><a href='home.php'>Home </a></li><li><a href='applicantAdmin.php'>Applicants </a></li><li>Summary of Applicant</li></ul>";
//Apply the template
include("master_sms_external.php");
?>