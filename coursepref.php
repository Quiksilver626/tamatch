<?php
require('values.php');
require('functions.php');
session_start();
/*
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
*/

if(!isset($_SESSION['dept']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:loginstaff.php");
}
if(!isset($_SESSION['name']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:loginstaff.php");
}
if(!isset($_SESSION['year']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:quarterstaff.php");
}
if(isset($_GET['tapref']))
{
  $_SESSION['ta_id'] = $_GET['tapref'];
}

if(isset($_GET['course']))
  $_SESSION['course'] = $_GET['course'];
else unset($_SESSION['course']);

if(isset($_GET['section']))
  $_SESSION['section'] = $_GET['section'];
else unset($_SESSION['section']);

if(!isset($_SESSION['pref']))
{
  $status = scip_input($_SESSION['year'],$_SESSION['season'], $_SESSION['dept'], $_SESSION['season_name']);
  $_SESSION['pref'] = 'created';
}

staffheader($_SESSION['name'],"coursepref.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']);

?>

<br><br>
<form>
<fieldset>
<p>
   Select a section below to view TA preferences for that section. The TAs will be ranked in order of preference for that section, with the TA that wants it most at the top. <b><font color="green">GREEN</font></b> TAs like this section, <b><font color = "gold">YELLOW</font></b> TAs are neutral, and <b><font color = "red">RED</font></b> TAs dislike the section.
</p>
</fieldset>
</form>
        <label class="selections" for="course"><p2 class="shadow40" style="margin-left:65%"><b>Course:</b></p2></label>
        <select id="course" name="course" class="selection_drops" onchange="redirectMe(this);">
          <?php populate_courses($_SESSION['dept'], "http://tamatch.math.ucdavis.edu/MathWeb/coursepref.php" ); ?>
        </select>
	<br>
        <label  class="selections" for="section"><p2 class="shadow40" style="margin-left:65%"><b>Section:</b></p2></label>
        <select <?php if(!isset($_GET['course'])) print 'disabled'?> id="section" name="section" class="selection_drops" onchange="redirectMe(this);">
          <?php if(isset($_GET['course']) )populate_sections($_GET['course'], $_SESSION['dept'], "http://tamatch.math.ucdavis.edu/MathWeb/coursepref.php"); ?>
        </select>

<br />
<?php
//unset($_SESSION['pref']);
if(isset($_GET['section']))
{
  //1. Make sure pref.csv exists.
  //$status = scip_input($_SESSION['year'],$_SESSION['season'], $_SESSION['dept'], $_SESSION['season_name']);
  if(!isset($status))
  {
    //2. Get all values from TAs for this section (equates to the proper row in csv)
    $fp = fopen("csv/pref_".$_SESSION['dept'].$_SESSION['year'].$_SESSION['season'].".csv", "r");
    //get headers (TA Names), note that first one is blank
    $tas = fgetcsv($fp);  
    while(($row = fgetcsv($fp)) !== FALSE)
    {
        $x = explode(' ', $row[0]);
        $course = $x[0];  $section = $x[1];
        if($course == $_SESSION['course'] && $section == $_GET['section'])
        {
          //now row and tas serve as the array we need. But I think an array of Prefs would be nicer.
          $prefs = array();
          $count = 0;
          foreach($tas as $ta)
          {
            $p = new Pref;
            $p->ta = $ta;
            $p->value = $row[$count];
            array_push($prefs, $p);
            $count++;
          }
          usort($prefs, prefcmp);

          //3. Display prettily.
          print '<table class="stafftable"  border="1"><tbody>';
          foreach($prefs as $p)
          {
            if($p->ta != "")
            {
              print '<tr class="';
              //get color value. this is dependent only on value.
              if($p->value > 50)
                print 'liked';
              else if($p->value < 50)
                print 'disliked';
              else  print 'neutral'; //value == 50
              print '"><td>'.$p->ta.'</td></tr>';
             } //don't print out blanks
           } //print out each TA 
           print '</tbody></table>';
        } //when we have a match, display the results.
     
      } //getting rows from pref.csv
    fclose($fp);
  }
  else puts($status);
}
?>

<script>
  function redirectMe (sel) { 
    var url = sel[sel.selectedIndex].value;
    window.location = url; 
  }

</script>
			
</body></html>
