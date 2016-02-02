<?php
require('values.php');
require('functions.php');
session_start();

unset($_SESSION['section']);
unset($_SESSION['course']);
unset($_SESSION['dept']);

if(!isset($_SESSION['ta_id']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:login.php");
}
if(!isset($_POST['submit'])) //if user has not hit Submit
{
?>
<link rel="shortcut icon" href="icon.ico" >
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="test_files/css3menu13/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>

<?php
 title($_SESSION['ta_name']); 
 nav("quarter.php"); 


print '<h3> <center> Please select the quarter in which you will be Teaching  </center></h3>';

if(isset($_POST['submit1']))  $_SESSION['dept'] = $_POST['dept'];
if(isset($_POST['submit2']))  $_SESSION['course'] = $_POST['course'];
if(isset($_POST['submit3']))
{
 $_SESSION['section'] = $_POST['section'];
 //then find events, check for conflicts, add to calendar.
 $error = add_event($_SESSION['section'], "section",$_SESSION['year'],$_SESSION['season'],$_SESSION['ta_id']);
}

if(isset($_POST['submit']))
{
 $_SESSION['crn'] = $_POST['crn'];
 //get section id from CRN or return NOT FOUND
 $error = add_event($_SESSION['crn'], "crn",$_SESSION['year'],$_SESSION['season'],$_SESSION['ta_id']);
}

if(isset($_POST['drop']))
{
  //drop this section from db
  //the value comes in as dept|course|section
  $s = explode("|",$_POST['assigned']);
  drop_section($s[2],$s[1],$s[0],$_SESSION['year'],$_SESSION['season'],$_SESSION['ta_id']);
}
?>

  <form name="quarter_form" id="quarter_form" action="quarter.php" method="post">
  <p style="margin-left: 20px">Select a quarter: <select name="quarter" id="quarter">
<?php  populate_quarters(); ?>
  </select> </p> <input class="button blue" style="padding: 5px; font-size:small; float:right" type="submit" name="submit" id="submit" value="Submit"/>  </form>
<?php
}
else //user has hit submit
{
    $quarter = explode("|",$_POST['quarter']);
    $_SESSION['year'] = $quarter[0];
    $_SESSION['season'] = $quarter[1];
    $_SESSION['season_name'] = $quarter[2];
    session_regenerate_id(true);
    session_write_close();
    header("Location:calendar.php");
}
?>

        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>

