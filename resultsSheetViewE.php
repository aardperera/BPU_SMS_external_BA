<script language="javascript"></script>
<style>
table {
    border-collapse: collapse;
}

table,
th,
td {
    border: 1px solid black;
}

.vTableHeader1 {
    text-align: center;
	text-size:10pt;
    transform: rotate(270deg);
	
	max-width:50px;
}

.vTableHeader2 {
    text-align: center;
	text-size:10pt;
    transform: rotate(270deg);
    height: 150px;
	word-wrap: break-word;
	word-break: keep-all;
	max-width:50px;
}

.vTableHeader {
    text-align: center;
	text-size:10pt;
    transform: rotate(270deg);
    height: 75px;
	max-width:50px;
}
    
/*
    #floating-scrollbar { border-bottom: 2px solid #000 !important; }
    .sample { overflow: auto; border: 2px solid #000; background: #181818; color: #F8F8F8; }
.sample + #floating-scrollbar { margin-left: 2px; }
*/
    
</style>
<script>

(function($){
  var // A few reused jQuery objects.
      win = $(this),
      html = $('html'),

      // All the elements being monitored.
      elems = $([]),

      // The current element.
      current,

      // The previous current element.
      previous,

      // Create the floating scrollbar.
      scroller = $('<div id="floating-scrollbar"><div/></div>'),
      scrollerInner = scroller.children();

  // Initialize the floating scrollbar.
  scroller
    .hide()
    .css({
      position: 'fixed',
      bottom: 0,
      height: '30px',
      overflowX: 'auto',
      overflowY: 'hidden'
    })
    .scroll(function() {
      // If there's a current element, set its scroll appropriately.
      current && current.scrollLeft(scroller.scrollLeft())
    });

  scrollerInner.css({
    border: '1px solid #fff',
    opacity: 0.01
  });

  // Call on elements to monitor their position and scrollness. Pass `false` to
  // stop monitoring those elements.
  $.fn.floatingScrollbar = function( state ) {
    if ( state === false ) {
      // Remove these elements from the list.
      elems = elems.not(this);
      // Stop monitoring elements for scroll.
      this.unbind('scroll', scrollCurrent);
      if ( !elems.length ) {
        // No elements remain, so detach scroller and unbind events.
        scroller.detach();
        win.unbind('resize scroll', update);
      }
    } else if ( this.length ) {
      // Don't assume the set is non-empty!
      if ( !elems.length ) {
        // Adding elements for the first time, so bind events.
        win.resize(update).scroll(update);
      }
      // Add these elements to the list.
      elems = elems.add(this);
    }
    // Update.
    update();
    // Make chainable.
    return this;
  };

  // Call this to force an update, for instance, if elements were inserted into
  // the DOM before monitored elements, changing their vertical position.
  $.floatingScrollbarUpdate = update;

  // Hide or show the floating scrollbar.
  function setState( state ) {
    scroller.toggle(!!state);
  }

  // Sync floating scrollbar if element content is scrolled.
  function scrollCurrent() {
    current && scroller.scrollLeft(current.scrollLeft())
  }

  // This is called on window scroll or resize, or when elements are added or
  // removed from the internal elems list.
  function update() {
    previous = current;
    current = null;

    // Find the first element whose content is visible, but whose bottom is
    // below the viewport.
    elems.each(function(){
      var elem = $(this),
          top = elem.offset().top,
          bottom = top + elem.height(),
          viewportBottom = win.scrollTop() + win.height(),
          topOffset = 30;

      if ( top + topOffset < viewportBottom && bottom > viewportBottom ) {
        current = elem;
        return false;
      }
    });

    // Abort if no elements were found.
    if ( !current ) { setState(); return; }

    // Test to see if the current element has a scrollbar.
    var scroll = current.scrollLeft(),
        scrollMax = current.scrollLeft(90019001).scrollLeft(),
        widthOuter = current.innerWidth(),
        widthInner = widthOuter + scrollMax;

    current.scrollLeft(scroll);

    // Abort if the element doesn't have a scrollbar.
    if ( widthInner <= widthOuter ) { setState(); return; }

    // Show the floating scrollbar.
    setState(true);

    // Sync floating scrollbar if element content is scrolled.
    if ( !previous || previous[0] !== current[0] ) {
      previous && previous.unbind('scroll', scrollCurrent);
      current.scroll(scrollCurrent).after(scroller);
    }

    // Adjust the floating scrollbar as-necessary.
    scroller
      .css({
        left: current.offset().left - win.scrollLeft(),
        width: widthOuter
      })
      .scrollLeft(scroll);

    scrollerInner.width(widthInner);
  }

});

$(function() {
  $('.sh .highlight, .sample').floatingScrollbar();
});
</script>
<center>
    <?php
	  include('dbAccess.php');
      ob_start();
$db = new DBOperations();
	 $courseID=$_GET['courseID'];
	 $subcrsID=$_GET['subcrsID'];
	 $emonth=$_GET['emonth'];
	 $acyear=$_GET['acyear'];
	
echo '<img src="logo.png" width="75" height="75" />';

if (isset($_POST['btn-save'])) {
   
   // $dist = $_POST['year'];

   	
			//header("location:newresultsheetE.php?courseID=$courseID&subcrsID=$subcrsID&acyear=$acyear&emonth=$emonth");
           //header("location:http://192.248.85.2/SMS_external_BA/newresultsheetE.php");
           header("Location: newresultsheetE.php");
	

}
?>
    <h3>BUDDHIST AND PALI UNIVERSITY OF SRI LANKA</h3>
    <h4>Bachlor of Arts (General) External Degree - Examination I - <?php echo $acyear;?> </h4>
    <h4>Detailed Result Sheet</h4>
</center>
<div class="sample" style=" white-space: nowrap; margin-left: 50px; margin-right: 50px;">
    <form method="post" action="">
    
        <table>
            <!-- Main Heading Row -->
            <tr>
                <!-- Fixed -->
                <th rowspan="2" class="vTableHeader1">
                    Serial Number
                </th>
                <th rowspan="2" class="vTableHeader1">
                    Reg Number
                </th>
                <th rowspan="2">
                    Index Number
                </th>
                <th rowspan="2">
                    Full Name
                </th>
                <th rowspan="2">
                    Address
                </th>
                <th rowspan="2" class="vTableHeader1">
                    Withheld
                </th>
                <!-- Subjects -->
                <?php
                
                $queryallS = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.suborder;";
				//print $queryallS;
				$resultallS = $db->executeQuery($queryallS);
	 $k=0;
				$subjects;
				
		  			  while ($rowS=  $db->Next_Record($resultallS))
					  {
						 
						 // print 'kkk'; 
  						$nameEnglish = $rowS['nameEnglish'];
						  $subjectID=$rowS['codeEnglish'];
						   $subjects[$k]=$rowS['subjectID'];
						 // print $sujects[k];
						  $k++;
						  $str2=$nameEnglish."       ".$subjectID;
			//	print $subjectID;?>
						  <th colspan="5" class="vTableHeader2"><?php echo wordwrap($str2,15,"<br>\n")?></th>
                    
                   
                    <?php
                }
				$noofsubjects=$k;
				//print 'hh';
				//print $sujects[0];
				//print 'hh';
                ?>
                
                
             
                
                <!-- Fixed -->
                <th rowspan="2" class="vTableHeader1">
                    Sub Total
                </th>
                <th rowspan="2" class="vTableHeader1">
                    %
                </th>
                <th rowspan="2" class="vTableHeader1">
                    Final Results
                </th>
            </tr>
            <!-- Sub-Heading Row -->
            <tr>
                <!-- Single Subject -->
                <?php
				 $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ORDER BY s.suborder";
			//	print $queryallSE;
				$resultallSE = $db->executeQuery($queryallSE);
				// $rowS=  $db->Next_Record($resultmark);
                for ($i=0;$i<$db->Row_Count($resultallSE);$i++)
		         {              ?>
                <td class="vTableHeader">
                    1st Marking
                </td>
                <td class="vTableHeader">
                    2nd Marking
                </td>
                <td class="vTableHeader">
                    Total
                </td>
                <td class="vTableHeader">
                    Grade
                </td>
                <td class="vTableHeader">
                    Points
                </td>
                <?php
                 }
                ?>
            </tr>
            <!-- One Entry -->
            
            
               <?php
                $queryallSE = "Select * from crs_subject c,subject s where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID ";
				//print $queryallSE;
				$resultallSE = $db->executeQuery($queryallSE);
				 $rowSE=  $db->Next_Record($resultallSE);
				//getting exam results
				$queryallSER = "Select distinct indexNo from crs_subject c,subject s,exameffort e where  c.CourseID='$courseID' and c.subcrsid='$subcrsID'  and c.subjectID=s.subjectID  and e.subjectID=s.subjectID and e.acYear='$acyear'  order by e.indexNo";
				//print $queryallSER;
				$resultallSER = $db->executeQuery($queryallSER);
				 //$rowSER= $db->Row_Count($resultallSER);
				$j=0;
                
			
			//print $db->Row_Count($resultallSER);
			//print 'hhh';
			while ($rowSER= $db->Next_Record($resultallSER))
				// for ($j=0;$j<$db->Row_Count($resultallSER);$j++)
		         { 
                    $noWH=0;
					// $rowSER=  $db->Next_Record($resultallSER);
					 $indexNo=$rowSER['indexNo'];
					  $j++;
				//  print $indexNo;
					 $queryallSERM = "Select e.mark1,e.mark2,e.marks,e.grade,e.gradePoint,e.subjectID,e.withhold from exameffort e,subject s  where  e.acYear='$acyear' and e.indexNo='$indexNo' and s.subjectID=e.subjectID ORDER BY s.suborder";
					 $resultallSERM = $db->executeQuery($queryallSERM);
					// $rowSERM= $db->Next_Record($resultallSERM);
					// print $queryallSERM;
					// print $rowSERM[0];print 'll'; print $rowSERM[1];
					// print 'll';
					  $queryallcom = "Select status from final_result r,crs_enroll c  where  c.yearEntry='$acyear' and c.indexNo='$indexNo' and r.enroll_id=c.Enroll_id";
					 $resultallcom = $db->executeQuery($queryallcom);
					 $rowcom= $db->Next_Record($resultallcom);
					 $status1=$rowcom[status];

                     //================Amendment========================================
                     $queryalldetl = "Select c.regNo,r.nameEnglish,r.addressE1,r.addressE2,r.addressE3 from student_a r,crs_enroll c  where  c.yearEntry='$acyear' and c.indexNo='$indexNo' and r.studentID=c.studentID";
                     $resultalldetl = $db->executeQuery($queryalldetl);
					 $rowdetl= $db->Next_Record($resultalldetl);
					 $regNo=$rowdetl[regNo];
                     $nameEnglish=$rowdetl[nameEnglish];
                     $addressE1=$rowdetl[addressE1];
                     $addressE2=$rowdetl[addressE2];
                     $addressE3=$rowdetl[addressE3];


                     //============================================================
					 
				?>
                <!-- Serial Number -->
               <tr>
                <td>
                    <input type="text" value="<?php echo $j; ?>" size="4" />
                </td>
                <!-- regNo Number -->
                <td>
                    <input type="text" value="<?php echo $regNo; ?>" size="15" />
                </td>
               
                <!-- Index Number -->
                <td>
                    <input type="text" value="<?php echo $indexNo; ?>" size="12" />
                </td>
                <!-- Name -->
                <td>
                    <input type="text" value="<?php echo $nameEnglish; ?>" size="60" />
                </td>
                <!-- Address -->
                <td>
                    <input type="text" value="<?php echo $addressE1; echo $addressE2; echo $addressE3;?>" size="70" />
                </td>
                <!-- Withheld -->
                <td>
                    <input type="text" size="4" />
                </td>
                <?php
				//	 print 'ttt';
				//print $queryallSERM	;
					// print 'ttt';
                //print $db->Row_Count($resultallSERM);
					 //$m=0;
					
				 
					 //print 'inside';
					 
              //while ($rowSERM= $db->Next_Record($resultallSERM))
			  
			  {
				  $rowSERM= $db->Next_Record($resultallSERM);
				  //print 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
					//  print $marks2;
					// print 'll';
					 $marks2=0;$a=0;
				   for ($m=0;$m<$noofsubjects;$m++){
				  //print 'forr';
				 //print $m;
					   //print 'forr';
					   //print $rowSERM[$subjectID];print 'y';
					   //print $subjects[$m];
					   //print 'ndd';
					   
					 //  
					//  print $rowSERM['subjectID'];
					 //  print 'kk'; 
					  
				  if ($rowSERM['subjectID']==$subjects[$m]){
                    //print $rowSERM[6];
                    //print $rowSERM['subjectID'];
                    //print $subjects[$m];
                    if($rowSERM[6]=='WH'){
                       $noWH=$noWH+1;
					   //if (true){
                    ?>
                    <!-- One Subject -->
                    <td>
                        <input type="text"  style="background-color: #3CBC8D" value="<?php echo $rowSERM[0]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text"  style="background-color: #3CBC8D" value="<?php echo $rowSERM[1]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text"  style="background-color: #3CBC8D" value="<?php echo $rowSERM[2]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text"  style="background-color: #3CBC8D" value="<?php echo $rowSERM[3]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text" style="background-color: #3CBC8D" value="<?php echo $rowSERM[4]; ?>"  size="3" />
                    </td>

                    <?php
                    }
                    else{
                    ?>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[0]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[1]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[2]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[3]; ?>" size="3" />
                    </td>
                    <td>
                        <input type="text" value="<?php echo $rowSERM[4]; ?>"  size="3" />
                    </td>

                    <?php
                    }
					  $marks2=$marks2+$rowSERM[2];
					 $a=$a+1;
					//  print 'yyyyyyyyyyyyy';
					//  print $rowSERM[2];
					//  print 'yyyyyyyyyyyyy';
					  $rowSERM= $db->Next_Record($resultallSERM);
				  }
					  else{?>
					<td>
                        <input type="text"  size="3" />
                    </td>
                    <td>
                        <input type="text"  size="3" />
                    </td>
                    <td>
                        <input type="text"  size="3" />
                    </td>
                    <td>
                        <input type="text"  size="3" />
                    </td>
                    <td>
                        <input type="text"  size="3" />
                    </td>  
					<?php 
						  }
						  
               // }
			  }
			  }
				 ?>
                <!-- Sub Total -->
                <td> 
                    <input type="text"  value="<?php echo $marks2; ?>" size="7" />
                </td>
                <!-- % -->
                <td>
                    <input type="text" value="<?php echo number_format(($marks2)/$a,2); ?>" size="6" />
                </td>
                <!-- Final Results -->
                <td>
                    <?php 
                   if($noWH=='0'){

                    ?>
                    <input type="text"  value="<?php echo $status1;?>" size="15" />

                    <?php
                   }
                   else{
                    ?>
                    <input type="text"  value="<?php echo "Withheld";?>" size="15" />


                </td>
                </tr>
                 <?php
                   }	
                }
				
				 ?>
            
        </table>
		
    </form>
</div>