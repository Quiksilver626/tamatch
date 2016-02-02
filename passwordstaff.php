<?php
require('values.php');
require('functions.php');
session_start();
if(!isset($_SESSION['name']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:loginstaff.php");
}
if(isset($_POST['password']))
{
  //check that passwords match.
  if($_POST['p1'] != $_POST['p2'])
    $status = array("error-message","Passwords do not match.");
  else
  {
    $status = update_password($_SESSION['name'], $_POST['p1'], "staff");
  }
}
staffheader($_SESSION['name'],"passwordstaff.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']); 
?>

<h3> <center> Change your password below </center></h3>

<br>
<fieldset style="margin-right:25%%; margin-left: 25%">
<legend>Change Your Password </legend>
<div>
  <form action="passwordstaff.php" method="post">

      <label class="selections" for="p1">Your New Password:</label>
      <input class="input" type="password" name="p1" id="p1" />
        <br>
      <label class="selections" for="p2">Confirm Your New Password:</label>  
      <input class="input" type="password" name="p2" id="p2" />
      <input type="submit" name="password" value="Submit" style="float:right">
  </form>

</div>
<?php
if(isset($status))
{
  print '<div id="'.$status[0].'">'.$status[1].'</div>';
}
?>
</fieldset>

<br>
</body</html>
