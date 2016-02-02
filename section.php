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

if(isset($_POST['section']))
{
  //get section data from file and input to db.
  if ($_FILES["file"]["error"] > 0)
  {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
  else
  {
    $filename = $_FILES["file"]["tmp_name"];
    $data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('CP1251');
    $data->read($filename);
    drop_table("section",$data->sheets[0]['cells'][2][3],$_SESSION['year'],$_SESSION['season']);
    for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++)
    {
      $status = insert_section($data, $i, $_SESSION['year'],$_SESSION['season']);
    }
    if(($status == NULL)) $status = array("success-message","Section file uploaded successfully.");
  }  
}

staffheader($_SESSION['name'],"section.php", $_SESSION['year'], $_SESSION['season_name']); 
?>

<h3> <center> Please Upload the Section Sheet </center></h3>

		
	<form id="singlesection" name="section" action="section.php" enctype="multipart/form-data" method="post">
	<fieldset class="scheduler-border">
	<legend class="scheduler-border">Section Excel Sheet Upload:</legend>
		<p>
		Please upload the section excel sheet below:<br>
		<input type="file" name="file">
		</p>
		<div>
		<input type="submit" name="section" value="Upload" style="float:right">
		</div>
<?php
if(isset($status))
{
  print '<div id="'.$status[0].'">'.$status[1].'</div>';
}
?>
	</fieldset>
	</form>
<form action="section.php" method="post">
<p style="text-align:center;">
<input type="submit" name="sectionlist" id ="sectionlist" value="View Section List">
</p>
</form>
<?php
if(isset($_POST['sectionlist']))
{
  section_table($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
}
?>



</body></html>
