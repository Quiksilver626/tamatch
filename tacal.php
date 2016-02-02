<?php
require('ExcelPHP/Excel/reader.php');
require('ExcelPHP/Excel/Writer.php');
require('Classes/PHPExcel.php');
require('values.php');
require('functions.php');
session_start();
/*  error_reporting(E_ALL);
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


if(isset($_POST['new']))
{
  //new custom event
$_SESSION['error'] = custom_section($_POST['tacal'], '', '', $_POST['name'], $_SESSION['year'], $_SESSION['season'], $_POST['day'], $_POST['eventstart'], $_POST['eventend']);
$_GET['tacal'] = $_POST['tacal'];
} //new custom event  

if(isset($_POST['r']))
{
$_GET['tacal'] = $_POST['tacal'];
  drop_section($_POST['drop'], '', '', $_SESSION['year'], $_SESSION['season'], $_POST['tacal']);
} //remove custom event

staffheader($_SESSION['name'],"tacal.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']);

?>

<link rel="stylesheet" type="text/css" href="css/calendar.css">
<!--start main container -->
<div style="margin-top:10px;" id="error-message">
<?php print $_SESSION['error']; unset($_SESSION['error']);?>
</div>
<fieldset style="background-color:white;">
  <legend><p2 class="shadow40">Select TA :
  <select id="tacal" name="tacal" onchange="redirectMe(this);">
    <?php populate_tas($_SESSION['year'], $_SESSION['season'], $_SESSION['dept'], $_GET['tacal']); ?>
  </select>
</p></legend>
  <table class="schedule" border="0">
    <colgroup>
      <col class="timeColumn"/>
      <col class="wDayColumns" span="5" />
    </colgroup>
    <thead>
      <tr>
        <th><p2 class="shadow40">Time</p2></th>
        <th><p2 class="shadow40">Monday</p2></th>
        <th><p2 class="shadow40">Tuesday</p2></th>
        <th><p2 class="shadow40">Wednesday</p2></th>
        <th><p2 class="shadow40">Thursday</p2></th>
        <th><p2 class="shadow40">Friday</p2></th>
      </tr>
    </thead>
<?php
  if(isset($_GET['tacal']))
  {
    populate_calendar_body($_GET['tacal'],$_SESSION['year'],$_SESSION['season']);
  }
  else
    populate_calendar_body("8888",$_SESSION['year'],$_SESSION['season']);

?>
</table>
</fieldset>

<div style="float:left;clear:left; width: 49%;"> <!--LEFT SIDE-->

<button id="more" name="add" style="width:20%; margin-left:43%; margin-right:43%;">Add a Custom Event</button>

<form id="yourDiv" method="post" action="tacal.php" style="visibility:hidden; margin-left:25%; margin-right:38%; width:90%">
<fieldset id="yourDiv" style="background-color:white; width:70% ">
<legend><b>Add a Custom Event</b></legend>
    <b>Event Name:</b><br>
      <input type="text" id="name" name="name"><br><br>
    
    <b>Event Days:</b><br>
    <input type="checkbox" name="day[]" value="M">Monday
    <input type="checkbox" name="day[]" value="T">Tuesday
    <input type="checkbox" name="day[]" value="W">Wednesday
    <input type="checkbox" name="day[]" value="R">Thursday
    <input type="checkbox" name="day[]" value="F">Friday<br><br>

    <b>Event Start - Event End:</b><br>
    <input name="eventstart" type="time">
    -
    <input name="eventend" type="time">
    <br><br>
    <input name="tacal" type="text" style="visibility:hidden" value="<?php print $_GET['tacal'];?>">

    <input id='submit' type='submit' name='new' value="Submit" style="float:right; margin-right:20px">
</fieldset>
</form>
</div>

<div style="float:right;clear:right; width: 49%;"> <!--RIGHT SIDE-->

<button id="more2" name="remove" style="width:20%; margin-left:43%; margin-right:43%;">Remove a Custom Event</button>

<form id="yourDiv2" method="post" action="tacal.php" style="visibility:hidden; margin-left:25%; margin-right:27%;">
<fieldset id="yourDiv2" style="background-color:white; width: 50%">
<legend><b>Remove a Custom Event</b></legend>

<select name="drop">
<?php populate_custom($_GET['tacal'], $_SESSION['year'], $_SESSION['season']); ?>
</select>

<!--    <input id='submit' type='submit' name='remove_custom' value="Remove" style="float:right; margin-right:20px">
-->
    <input name="tacal" type="text" style="visibility:hidden" value="<?php print $_GET['tacal'];?>">
    <input id='submit' type='submit' name="r" value="Submit" style="float:right; margin-right:20px">

</fieldset>
</form>
</div>
<script>
    var theButton = document.getElementById('more');

    theButton.onclick = function()
    {
        document.getElementById('yourDiv').style.visibility='visible';
    }

  function redirectMe (sel) {
    var url = sel[sel.selectedIndex].value;
    window.location = url;
  }

    var theButton = document.getElementById('more2');

    theButton.onclick = function()
    {
        document.getElementById('yourDiv2').style.visibility='visible';
    }

  function redirectMe (sel) {
    var url = sel[sel.selectedIndex].value;
    window.location = url;
  }

</script>

</body></html>
