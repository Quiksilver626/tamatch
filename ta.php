<?php
require('ExcelPHP/Excel/reader.php');
require('ExcelPHP/Excel/Writer.php');
require('Classes/PHPExcel.php');
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
$fn = 'xls/'.$_SESSION['season_name'].'_'.$_SESSION['year'].'_'.$_SESSION['dept'].'_TAdata.xls'; 

ta_excel($_SESSION['year'], $_SESSION['season'], $_SESSION['dept'], $_SESSION['season_name']);

if(isset($_POST['ta']))
{
  //get ta data from file and input to db.
  if ($_FILES["file"]["error"] > 0)
  {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
  } 
  else 
  {
    drop_table("ta", $_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
    $filename = $_FILES["file"]["tmp_name"];
    $data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('CP1251');
    $data->read($filename);
    for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++)
    {
      $status = insert_ta($data, $i, $_SESSION['year'], $_SESSION['season'], $_SESSION['dept']);
    }
    if(($status == NULL)) $status = array("success-message","File uploaded successfully.");
    ta_excel($_SESSION['year'], $_SESSION['season'], $_SESSION['dept'],$_SESSION['season_name']);
    force_checks($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
  }
}
if(isset($_POST['submit']))
{
$status =   insert_single_ta($_SESSION['dept'], $_POST['fname'], $_POST['lname'], $_POST['rank'], $_POST['units'], $_POST['sid'], $_POST['status'], $_SESSION['year'], $_SESSION['season']);
  ta_excel($_SESSION['year'], $_SESSION['season'], $_SESSION['dept'],$_SESSION['season_name']);
  force_checks($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
}

if(isset($_POST['reset_ta']))
{
  $status = reset_ta($_SESSION['dept'], $_POST['reset']);
}

if(isset($_POST['deadline']))
{
   $d = explode('-',$_POST['deaddate']);
   insert_deadline($_SESSION['dept'], $_SESSION['year'], $_SESSION['season'], $d[0], $d[1], $d[2]);
}

staffheader($_SESSION['name'],"ta.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']);



?>

<!--start main container -->

<script>
$("input[type='checkbox']").button();
$("input[type='checkbox']").tooltip();
</script>
<script src="Zclip/dist/ZeroClipboard.js"></script>


	<p style="text-align:center;">
	<form id="singleta" name="ta" action="ta.php" enctype="multipart/form-data" method="post">
	<fieldset class="scheduler-border" style="border-color:#3BA4C7">
	<legend class="scheduler-border"><b>TA Excel Sheet Upload:</b></legend>
	<p> Please upload the TA Excel Sheet.<br>Note this will delete all TAs in your department and insert the TAs in the Excel sheet.</p>
		<input type="file" name="file">
		</p>
		<div>
		<input type="submit" name="ta" value="Upload" id="submit"</div>
	</p>
<?php
if(isset($status))
{
  print '<div id="'.$status[0].'">'.$status[1].'</div>';
}
?>
	</fieldset>
	</form>
<form id="singleta" name="singleta" action="ta.php" method="post">
  <fieldset class="scheduler-border" style="border-color:#3BA4C7">
    <legend class="scheduler-border"><b>Add A Single TA</b></legend>
	<label  for="fname">First Name:</label>
	<input  type="text" id="fname" name="fname" />
	<label  for="lname">Last Name:</label>
	<input  type="text" id="lname" name="lname" />
        <label  for="sid">UCD Student ID:</label>
        <input  type="text" id="sid" name="sid" />
	<label  for="rank">Rank: <img type="image" src="img/info.gif" id="tooltipbutton" value="Test" title="The rank of the TA can range from 1-5">
</label>
	<input  type="text" id="rank" name="rank" />
	<label  for="units">Units: <img type="image" src="img/info.gif" id="tooltipbutton" value="Test" title="A TA can have 2 or 4 units">
</label>
	<input  type="text" id="units" name="units" />
	<label  for="status">Classes Allowed to Teach: <img type="image" src="img/info.gif" id="tooltipbutton" value="Test" title="TAs can teach 'full' (grad, upper, and lower division classes), 'high' (upper and lower division classes), or 'low' (just lower division classes)">
</label>
	<input class="input" type="text" id="status" name="status" />
	<input type="submit" id="submit" name="submit" value="Submit" style="float:left;clear:left;">
  </fieldset>
 <br>

<fieldset id="singleta" style="border-color:#3BA4C7">
<legend><b>Reset TA Password</b></legend>
<p>You can reset the login information of your TAs here. If you do, their username will be the first letter of their first name followed by their entire last name and their password will be their student ID.
</p>
	<label  for="reset">SID of student to reset: </label>
	<input class="input" type="text" id="reset" name="reset" />
	<input type="submit" id="reset_ta" name="reset_ta" value="Reset" style="float:left;clear:left;">
</fieldset>
<br>

<fieldset id="singleta" style="border-color:#3BA4C7">
<legend><b>TA Site Link</b></legend>
<p>Below is the link to send to your TAs for
<?php
  print $_SESSION['season_name'].' '.$_SESSION['year'].':';
?>
</p>
<textarea name="clipboard-text" id="clipboard-text" cols="85" rows="1">
<?php
print 'http://tamatch.math.ucdavis.edu/MathWeb/login.php?sname='.$_SESSION['season_name'].'&season='.$_SESSION['season'].'&year='.$_SESSION['year'];
?>
</textarea>
<button id="click-to-copy" data-clipboard-target="clipboard-text" style="float:right">Copy To Clipboard</button>
</fieldset>

<br>

<fieldset id="deadline" style="border-color:#3BA4C7">
<legend><b>TA Input Deadline</b></legend>
<p>The current deadline for TAs to rank preferences and input course schedules for
<?php
  print $_SESSION['season_name'].' '.$_SESSION['year'];
?>
 is 11:59 PM on:<b>
<?php
  $deadline = get_deadline($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
  if(!(isset($deadline))) print "No Deadline Set";
  else
  {
    print $deadline[1].'/'.$deadline[2].'/'.$deadline[0];
  }
?>
</b></p>
	<input name="deaddate" type="date" style="width: 90%; margin-left: 5%; margin-right: 5%">
   <br>
   <input name="deadline" type="submit" value="Set Deadline" style="float:right; clear:right; margin-right:20px">
</fieldset>
</form>



<p style="text-align:center">
<input type="button" style="margin-top:0px" name="tdownload" id ="tdownload" value="Download Sample TA Sheet (.xls)" onClick="window.location.href='sample_TA_Data.xls'">
<input type="button" style="margin-top:0px" name="tdownload" id ="tdownload" value="Download Current <?php print $_SESSION['season_name'].' '.$_SESSION['year']?> TA Sheet (.xls)" onClick="window.location.href='<?php print $fn; ?>'">
</p>
<form action="ta.php" method="post">
<p style="text-align:center">
<input type="submit" name="talist" id="talist" value="View TA List">
</p>
</form>
<?php 
if(isset($_POST['talist']))
{
  ta_table($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
}
?>
</body>
<script>
var clientTarget = new ZeroClipboard( $("#click-to-copy"), {
    moviePath: "http://paulund.localhost/playground/demo/zeroclipboard-demo/zeroclipboard/ZeroClipboard.swf",
    debug: false
} );

clientTarget.on( "load", function(clientTarget)
{
    $('#flash-loaded').fadeIn();

    clientTarget.on( "complete", function(clientTarget, args) {
        clientTarget.setText( args.text );
        $('#target-to-copy-text').fadeIn();
    } );
} );

var client = new ZeroClipboard( $("#click-to-copy"), {
              moviePath: "zeroclipboard/ZeroClipboard.swf",
              debug: false
} );

client.on( "load", function(client)
{
    $('#flash-loaded').fadeIn();

    client.on( "complete", function(client, args) {
        client.setText( "Set text copied." );
        $('#click-to-copy-text').fadeIn();
    } );
} );

var client = new ZeroClipboard( document.getElementById("copy-button"), {
  moviePath: "/Zclip/dist/ZeroClipboard.swf"
} );

client.on( "load", function(client) {
  // alert( "movie is loaded" );

  client.on( "complete", function(client, args) {
    // `this` is the element that was clicked
    this.style.display = "none";
    alert("Copied text to clipboard: " + args.text );
  } );
} );

//set path
ZeroClipboard.setMoviePath('http://davidwalsh.name/demo/ZeroClipboard.swf');
//create client
var clip = new ZeroClipboard.Client();
//event
clip.addEventListener('mousedown',function() {
	clip.setText(document.getElementById('box-content').value);
});
clip.addEventListener('complete',function(client,text) {
	alert('copied: ' + text);
});
//glue it to the button
clip.glue('copy');
</script>
</html>
