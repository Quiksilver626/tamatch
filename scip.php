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
if(!isset($_SESSION['limit']))
  $_SESSION['limit'] = 5;


$filenamescip = 'csv/'.$_SESSION['season_name'].'_'.$_SESSION['year'].'_'.$_SESSION['dept'].'_ip';

if(isset($_POST['generatescip']))
{
  $_SESSION['limit'] = $_POST['limit'];
  set_limit($_POST['limit'], 'scip/scipmip.set');
  //create csv files
  $status = scip_input($_SESSION['year'],$_SESSION['season'], $_SESSION['dept'], $_SESSION['season_name']);
  if(!isset($status))
  {
    force_checks($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
    make_constraints($_SESSION['year'],$_SESSION['season'], $_SESSION['dept']);
    //make zpl file, run through SCIP, get csv
    $status = run_scip($_SESSION['year'],$_SESSION['season'], $_SESSION['dept'],$_SESSION['season_name'], $filenamescip);
    if(!isset($status))
    {
      scip_csv_append($filenamescip, $_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
      csv_xls($filenamescip);
      $_SESSION['scipfile2_exists'] = $_SESSION['season'];
    } //only run if no errors when running SCIP
  } //only run if no errors with input
}

if(isset($_GET['course']))
  $_SESSION['course'] = $_GET['course'];
if(isset($_GET['section']))
  $_SESSION['section'] = $_GET['section'];

staffheader($_SESSION['name'],"scip.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']);
?>

<h2> <center> View the Results or Download a Hard Copy Below </center></h2>

<form action="scip.php" method="post">
<fieldset style="border-color:#3BA4C7; margin-left:30%; margin-right:30%">
<legend><b>The Integer Programming Method</b></legend>
<p>This is the integer programming assignment method. This method of assignment accounts for the preferences of TAs in terms of whether their assigned sections are on the same day or from the same course. It will also account for whether they prefer courses over times or vice versa.</p>
</fieldset>
<fieldset style="border-color:#3BA4C7; margin-left:30%; margin-right:30%; margin-top:15px;">
  <legend><b>Set Time Limit</b></legend>
  <p>Terminate the program after 
    <input name="limit" id="limit" type="number"
      <?php print 'value="'.$_SESSION['limit'].'"'; ?>
     min="5" max="15" step="5"> 
     minutes.
  </p>
</fieldset>

<br>
<?php
if(isset($status))
{
  print '<div id="'.$status[0].'">'.$status[1].'</div>';
}
?>
<div id="generateimageset2" style="display:none">
  <img src="loader.gif" alt="loading...">
</div>
<br>


<div id="formsubmitbutton" style="display:inline;">
<input type="submit"  id ="generatescip2" name="generatescip" value="Generate SCIP Assignment" onclick="ButtonClicked()">
</div>

<input type="button" name="download" id ="generatescip2" value="Download SCIP Assignment Sheet (.xls)" <?php echo !isset($_SESSION['scipfile2_exists']) ? 'disabled' : ''; ?> onClick="window.location.href='<?php print $filenamescip.'.xls'; ?>'">


<div>
<input type="submit" name="displayscip" id ="generatescip2" value="Display SCIP Assignment" <?php echo !isset($_SESSION['scipfile2_exists']) ? 'disabled' : ''; ?>>
</div>
<br>
</form>

<?php
if(isset($_POST['displayscip']))
  scip_table($filenamescip);
?>

<script type="text/javascript">

function redirectMe (sel) 
{
  var url = sel[sel.selectedIndex].value;
  window.location = url;
}

function ButtonClicked()
{
   document.getElementById("formsubmitbutton").style.display = "none"; // to undisplay
   document.getElementById("generateimageset2").style.display = ""; // to display
   return true;
}

var FirstLoading = true;
function RestoreSubmitButton()
{
   if( FirstLoading )
   {
      FirstLoading = false;
      return;
   }
   document.getElementById("formsubmitbutton").style.display = ""; // to display
   document.getElementById("generateimageset2").style.display = "none"; // to undisplay
}
// To disable restoring submit button, disable or delete next line.
document.onfocus = RestoreSubmitButton;

var theButton = document.getElementById('scipbutton');

theButton.onclick = function() 
{ 
  document.getElementById('tableform').style.visibility='hidden';   
}

</script>

</body></html>
