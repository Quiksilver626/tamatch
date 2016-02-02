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

staffheader($_SESSION['name'],"noresponse.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']);

?>
<br><br>
<center><b>The following TAs have not yet ranked their preferences:</b></center>
<?php

          //noresponse returns an array of TA names who didn't fill out the forms this quarter.
          $tas = noresponse($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
          print '<table class="stafftable"  border="1"><tbody>';
          foreach($tas as $t)
          {
            if($t != "")
            {
              print '<tr><td>'.$t.'</td></tr>';
             } //don't print out blanks
           } //print out each TA 
           print '</tbody></table>';
?>
			
</body></html>
