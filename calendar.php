<?php
require('values.php');
require('functions.php');
session_start();
$error = '';
if(!isset($_SESSION['year']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:quarter.php");
}
if(!isset($_SESSION['ta_id']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:login.php");
}
if(isset($_GET['dept']))
  $_SESSION['dept'] = $_GET['dept'];
else if(!isset($_SESSION['dept']))
{
  //redirect so that we get the proper dept
    session_regenerate_id(true);
    session_write_close();
    header("Location:calendar.php?dept=".$_SESSION['tadept']);
}

if(isset($_GET['course']))
  $_SESSION['course'] = $_GET['course'];

if(isset($_GET['section']))
  $_SESSION['section'] = $_GET['section'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>UC Davis Mathematics :: TA Ranking</title>
<link rel="stylesheet" type="text/css" href="css/styles.css">
<link rel="stylesheet" href="test_files/css3menu13/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>
<link rel="stylesheet" type="text/css" href="css/calendar.css">
<link rel="shortcut icon" href="icon.ico" >			
</head>

<?php title($_SESSION['ta_name']); ?>
<body>
<?php nav("calendar.php"); ?>

<?php
print '<h3> <center> Please add the classes you are enrolled in for '.$_SESSION['season_name'].' '.$_SESSION['year'].'.<br>You may add by <font color="red">CRN</font> or by <font color="red">course</font>.</center></h3>';

if(isset($_GET['section']))
{  
 //then find events, check for conflicts, add to calendar.
 $_SESSION['error'] = add_event($_SESSION['section'], "section",$_SESSION['year'],$_SESSION['season'],$_SESSION['ta_id']);
  reset_calendar();
}

if(isset($_POST['submit']))
{
 $_SESSION['crn'] = $_POST['crn'];
 //get section id from CRN or return NOT FOUND
 $_SESSION['error'] = add_event($_SESSION['crn'], "crn",$_SESSION['year'],$_SESSION['season'],$_SESSION['ta_id']);
  reset_calendar();
}

if(isset($_POST['drop']))
{
  //drop this section from db
  //the value comes in as dept|course|section
  $s = explode("|",$_POST['assigned']);
  drop_section($s[2],$s[1],$s[0],$_SESSION['year'],$_SESSION['season'],$_SESSION['ta_id']);
  reset_calendar();
}
?>

</script>


  <form id ="section" name="section" action="calendar.php" method="post">
    <fieldset id = "fcrn">
      <legend><p class="shadow40">CRN</p></legend> 
      <input type="text" name="crn" id="crn" />
      <input type="submit" name="submit" id="submit" value="Add" />
    </fieldset>
    <fieldset id = "selection">
      <legend><p class="shadow40">Add Course</p></legend> 
        <label  class="selections" for="dept"><p2 class="shadow40">Department:</p2></label>
        <select id="dept" name="dept" class="selection_drops" onchange="redirectMe(this);">
          <?php populate_depts();?>
        </select> 
        <label class="selections" for="course"><p2 class="shadow40">Course:</p2></label>
        <select id="course" name="course" class="selection_drops" onchange="redirectMe(this);">
          <?php populate_courses($_GET['dept'], "http://tamatch.math.ucdavis.edu/MathWeb/calendar.php" ); ?>
        </select>     
        <label  class="selections" for="section"><p2 class="shadow40">Section:</p2></label>
        <select <?php if(!isset($_GET['course'])) print 'disabled'?> id="section" name="section" class="selection_drops" onchange="redirectMe(this);">
          <?php if(isset($_GET['course']) )populate_sections($_GET['course'], $_GET['dept'], "http://tamatch.math.ucdavis.edu/MathWeb/calendar.php"); ?>
        </select> 
    </fieldset>
    <label style="margin-left:60px" class="assigned" for="assigned">Remove a Section:</label>
    <select class="selection_drops" id="assigned" name="assigned">
      <?php populate_assigned($_SESSION['ta_id'], $_SESSION['year'],$_SESSION['season']); ?>
    </select>
    <input type="submit" name="drop" id="drop" class="selection_buttons" value="Remove" />
  </form>
  <div id="error-message" name="error">
    <?php
      print $_SESSION['error']; 
      unset($_SESSION['error']);
    ?>
  </div>
  <br />
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
     populate_calendar_body($_SESSION['ta_id'],$_SESSION['year'],$_SESSION['season']); 
    ?>
  </table>
<br />

  <div class="button-row">
    <a href="MathCode.php" class="button blue" style="padding: 5px; font-size: small" >Submit</a>
  </div>

<script>
  function redirectMe (sel) { 
    var url = sel[sel.selectedIndex].value;
    window.location = url; 
  }

</script>


</body>
</html>
