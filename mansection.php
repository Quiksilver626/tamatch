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

if(isset($_POST['course'])) $_SESSION['course'] = $_POST['course'];

if(isset($_POST['remove']))
{
  //set this course to 'deleted'
  set_section('deleted', $_SESSION['course'], $_SESSION['dept'], $_POST['section'],$_SESSION['year'],$_SESSION['season']);
}

if(isset($_POST['delete']))
{
  delete_section($_SESSION['course'], $_SESSION['dept'], $_POST['section'],$_SESSION['year'],$_SESSION['season']);
}

if(isset($_POST['add']))
{
  //set this course to 'added'
  set_section('added', $_SESSION['course'], $_SESSION['dept'], $_POST['section'],$_SESSION['year'],$_SESSION['season']);
}
if(isset($_POST['new']))
{
  //add this new section.
  //if we have discussion and lab, let's input that.
    if(isset($_POST['day1']) && isset($_POST['day2']))
      new_section($_POST['crn'],$_SESSION['dept'], $_SESSION['course'], $_POST['addingsection'], $_SESSION['year'], $_SESSION['season'], $_POST['day'],  $_POST['lecturestart'], $_POST['lectureend'], $_POST['day1'], $_POST['discstart'], $_POST['discend'], $_POST['day2'], $_POST['labstart'], $_POST['labend']);
    else if(isset($_POST['day1']))
      new_section($_POST['crn'],$_SESSION['dept'], $_SESSION['course'], $_POST['addingsection'], $_SESSION['year'], $_SESSION['season'], $_POST['day'],  $_POST['lecturestart'], $_POST['lectureend'], $_POST['day1'], $_POST['discstart'], $_POST['discend']);
    else if(isset($_POST['day2']))
      new_section($_POST['crn'],$_SESSION['dept'], $_SESSION['course'], $_POST['addingsection'], $_SESSION['year'], $_SESSION['season'], $_POST['day'],  $_POST['lecturestart'], $_POST['lectureend'], $_POST['day2'], $_POST['labstart'], $_POST['labend']);
   else //just lecture 
      new_section($_POST['crn'],$_SESSION['dept'], $_SESSION['course'], $_POST['addingsection'], $_SESSION['year'], $_SESSION['season'], $_POST['day'],  $_POST['lecturestart'], $_POST['lectureend']);
}

staffheader($_SESSION['name'],"mansection.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']);

?>

<br><br><br>

<p style="text-align:center">
<fieldset class="scheduler-border" style="border-color:#3BA4C7; width: 80%; text-align: center; margin-left: 10%; margin-right: 10%">
<legend><b>Section Management:</b></legend>
<input type="button" onClick="parent.location='mancourse.php'" value="Back to Courses">
        <p>This page can be used to manage the sections offered for <b>
<?php print $_SESSION['dept'].' '.$_SESSION['course'];?>
        .</b></p>
  <table class="gridtable">
    <thead>
      <tr>
        <td>CRN</td>
        <td>Section</td>
        <td>Lecture Times</td>
        <td>Discussion Times</td>
        <td>Remove/Add</td>
      </tr>
    </thead>
   <tbody>
<?php
section_table2($_SESSION['dept'], $_SESSION['year'], $_SESSION['season'], $_SESSION['course']);
?>
</tbody>
</table>
</fieldset>
</p>
<br><br>
<form action="" method="post">
  <fieldset style="margin-right:25%; margin-left:25%">
    <legend><b>Add Section</b></legend>
    <p> This form can be used to add sections to the current list of sections provided by the registrar below:</p>

    <b>Section Name:</b>
      <input type="text" id="addingsection" name="addingsection" maxlength="3"><br><br>
    <b>CRN:</b>
      <input type="text" id="crn" name="crn" maxlength="5"><br><br>
 
    <b>Lecture Days:</b><br>
    <input type="checkbox" name="day[]" value="M">Monday
    <input type="checkbox" name="day[]" value="T">Tuesday        
    <input type="checkbox" name="day[]" value="W">Wednesday
    <input type="checkbox" name="day[]" value="R">Thursday 
    <input type="checkbox" name="day[]" value="F">Friday<br><br>
    
    <b>Lecture Start - Lecture End:</b><br>
    <input name="lecturestart" type="time">
    -
    <input name="lectureend" type="time">
    <br><br>

    <b>Discussion Days:</b><br>
    <input type="radio" name="day1" value="M">Monday
    <input type="radio" name="day1" value="T">Tuesday
    <input type="radio" name="day1" value="W">Wednesday
    <input type="radio" name="day1" value="R">Thursday
    <input type="radio" name="day1" value="F">Friday<br><br>

    <b>Discussion Start - Discussion End:</b><br>
    <input name="discstart" type="time">
    -
    <input name="discend" type="time">
    <br><br>

    <b>Lab Days:</b><br>
    <input type="radio" name="day2" value="M">Monday
    <input type="radio" name="day2" value="T">Tuesday
    <input type="radio" name="day2" value="W">Wednesday
    <input type="radio" name="day2" value="R">Thursday
    <input type="radio" name="day2" value="F">Friday<br><br>

    <b>Lab Start - Lab End:</b><br>
    <input name="labstart" type="time">
    -
    <input name="labend" type="time">
    <br>
    <input id='submit' type='submit' name='new' value="Submit" style="float:right; margin-right:20px">

  </fieldset>
    
</form>




<script>
$('#addingsection').keypress(function (e) {
    var regex = new RegExp("^[a-zA-Z0-9]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }

    e.preventDefault();
    return false;
});

var allRadios = document.getElementsByName('day1');
var booRadio;
var x = 0;
for(x = 0; x < allRadios.length; x++){

        allRadios[x].onclick = function(){

            if(booRadio == this){
                this.checked = false;
        booRadio = null;
            }else{
            booRadio = this;
        }
        };

}

var allRadios = document.getElementsByName('day2');
var booRadio;
var x = 0;
for(x = 0; x < allRadios.length; x++){

        allRadios[x].onclick = function(){

            if(booRadio == this){
                this.checked = false;
        booRadio = null;
            }else{
            booRadio = this;
        }
        };

}

</script>
