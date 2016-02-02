<?php
require('ExcelPHP/Excel/reader.php');
require('ExcelPHP/Excel/Writer.php');
require('Classes/PHPExcel.php');
require('values.php');
require('functions.php');

session_start();
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

if(isset($_POST['conflict']))
{
  //make sure they have selected a TA and prof.
  $cta = explode('=',$_POST['cta']);
  if(!($_POST['cprof']=="NULL" || count($cta)==1))
  {
    //make a new record of this conflict.
    prof_conflict($cta[1], $_POST['cprof'], $_SESSION['year'], $_SESSION['season'], $_SESSION['dept']);
  }
}
if(isset ($_POST['remove']))
{
  $l = explode("|", $_POST['taprof']);
  //remove this record from the db.
  drop_conflict($l[0], $l[1], $_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
}
if(isset($_POST['match']))
{
  //make sure every field is set.
  $mta = explode('=',$_POST['mta']);
  $c = explode('=',$_POST['course']);
  $s = explode('=',$_POST['section']);
  if(!((count($mta)==1) || (count($c)==3) || (count($s)==1) ))
  {
    //make a record of this matching.
$error =    force_match($_SESSION['dept'], $_SESSION['year'], $_SESSION['season'], $mta[1], $c[0], $s[3]);
$status = array();
if(isset($error)) $status = array("error-message", $error);
  }
  unset($_SESSION['course']);
  unset($_SESSION['section']);
}

if(isset ($_POST['mremove']))
{
  $l = explode("|", $_POST['tamatch']);
  //remove this record from the db.
  drop_match($l[0], $l[1], $l[2], $_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
}

if(isset($_GET['course']))
  $_SESSION['course'] = $_GET['course'];
if(isset($_GET['section']))
  $_SESSION['section'] = $_GET['section'];
staffheader($_SESSION['name'],"conflicts.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']);
?>


<div style="width: 100%;"> <!-- FULL DOC-->

<h5 style="margin-left:25%; margin-right:25%">If you would like to add in constraints of your own, the tools below will allow you to either force a TA to teach a course or add conflicts between TAs and professors:</h5>
<?php
if(isset($status))
{
  print '<div id="'.$status[0].'" style="float:right;margin-right:12%;">'.$status[1].'</div>';
}
?>
<div style="float:left;clear:left; width: 49%;"> <!--LEFT SIDE-->

<h3 style="text-align:center"> Add Conflicts between Professors and TAs </h3>


<form action="conflicts.php" method="post" id="scip">
 <fieldset style="border-color:#3BA4C7">
  <legend><b>Add a Conflict</b></legend>
  <select name="cta">
    <?php populate_tas($_SESSION['year'], $_SESSION['season'], $_SESSION['dept']); ?>
  </select>
  <select name="cprof">
    <?php populate_profs($_SESSION['dept']); ?>
  </select>
  <br>
  <input style="float:right" type="submit" name="conflict" value="Add Conflict" id="scipbutton" onclick="displayconflicttable()">
 </fieldset>
</form>
<?php conflict_body($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']); ?>
</table>

</div>

<div style="float:right; width: 49%;"> <!-- THE RIGHT COLUMN -->

<h3 style="text-align:center">Assign TAs to Courses Directly</h3>

<form action="conflicts.php" method="post" id="scip">
 <fieldset style="border-color:#3BA4C7">
  <legend><b>Assign TAs Manually</b></legend>
  <select id="course" name="course" class="selection_drops" onchange="redirectMe(this);">
    <?php populate_courses($_SESSION['dept'], "http://tamatch.math.ucdavis.edu/MathWeb/conflicts.php"); ?>
  </select>
  <br>
  <select <?php if(!isset($_GET['course'])) print 'disabled'?> id="section" name="section" class="selection_drops" onchange="redirectMe(this);">
    <?php if(isset($_GET['course']) )populate_sections($_GET['course'], $_SESSION['dept'], "http://tamatch.math.ucdavis.edu/MathWeb/conflicts.php"); ?>
  </select>
  <br>
  <select name="mta">
    <?php populate_tas($_SESSION['year'], $_SESSION['season'], $_SESSION['dept']); ?>
  </select>
  <br>
  <input style="float:right" type="submit" name="match" value="Force Match" id="scipbutton">
 </fieldset>
</form>
  <?php match_body($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']); ?>
</table>
</div>
</div>

<br>

<script type="text/javascript">

function redirectMe (sel)
{
  var url = sel[sel.selectedIndex].value;
  window.location = url;
}

</script>


