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

if(isset($_POST['remove']))
{
  //set this course to 'deleted'
  set_course('deleted', $_POST['course'], $_SESSION['dept']);
}

if(isset($_POST['add']))
{
  //set this course to 'added'
  set_course('added', $_POST['course'], $_SESSION['dept']);
}

if(isset($_POST['modify']))
{
  //change units, weight of this course
  mod_course($_POST['weight'], $_POST['units'], $_POST['course'], $_SESSION['dept']);
  force_checks($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
}

if(isset($_POST['newcourse']))
{
  //add this course
  add_course($_POST['course'], $_SESSION['dept']);
}


staffheader($_SESSION['name'],"mancourse.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']);

?>

        <p style="text-align:center;">
        <fieldset class="scheduler-border" style="border-color:#3BA4C7">
        <legend class="scheduler-border"><b>Course & Section Management:</b></legend>
        <p>This page can be used to manage the courses and sections offered this quarter.</p>
        </p>
        <form action="mancourse.php" method="post">
         <input name="course" type="text"/> 
         <input type="submit" value="Add Course" name="newcourse"/>
        </form>

<?php
course_table($_SESSION['dept'], $_SESSION['year'], $_SESSION['season']);
?>

