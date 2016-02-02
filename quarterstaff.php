<?php
require('values.php');
require('functions.php');
session_start();
if(!isset($_SESSION['name']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:quarterstaff.php");
}
if(!isset($_POST['submit'])) //if user has not hit Submit
{
  staffheader($_SESSION['name'],"quarterstaff.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']);
?>

<h3> <center> Please select the quarter </center></h3>

  <form name="quarter_form" id="quarter_form" action="quarterstaff.php" method="post" style="margin-left: 50px">
  <p style="margin-left:20px"> Select a quarter: <select name="quarter" id="quarter">
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
    header("Location:ta.php");
}
?>
