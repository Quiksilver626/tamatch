<?php
require('ExcelPHP/Excel/reader.php');
require('ExcelPHP/Excel/Writer.php');
require('Classes/PHPExcel.php');
require('values.php');
require('functions.php');
session_start();
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
$filename = 'xls/'.$_SESSION['season_name'].'_'.$_SESSION['year'].'_'.$_SESSION['dept'].'final.xls';
if(!isset($_POST['a1']) && !isset($_POST['a2']))
  write_excel2($_SESSION['year'],$_SESSION['season'], $_SESSION['dept'], $_SESSION['season_name']);
staffheader($_SESSION['name'],"results.php", $_SESSION['year'], $_SESSION['season_name']);


?>


<h3> <center> View the Results or Download a Hard Copy Below </center></h3>

<!-- Let this button download VictorStylefinal.xls to the user. -->
<form action="results.php" method="post">
<div id="resultset">
<input type="button" name="download" id ="download" value="Download TA Assignment Sheet (.xls)" onClick="window.location.href='<?php print $filename; ?>'">
<input type="submit" name="a1" id ="a1" value="View Assignment #1">
<input type="submit" name="a2" id ="a2" value="View Assignment #2">
</div>		
</form>

<?php
//If one of the Views were clicked, then display a table with the contents of the appropriate sheet.
if(isset($_POST['a1']))
  victor_table($_SESSION['dept'], $_SESSION['year'], $_SESSION['season_name'], "0");
if(isset($_POST['a2']))
  victor_table($_SESSION['dept'], $_SESSION['year'], $_SESSION['season_name'], "1");
?>
</body></html>

