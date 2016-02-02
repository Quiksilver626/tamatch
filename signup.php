<?php
require('values.php');
require('functions.php');
html_header("TA Signup");
session_start();
if(!isset($_SESSION['noob']))
{
  //you should only come here from login page.
  session_regenerate_id(true);
  session_write_close();
  header("Location:login.php");
}
if(isset($_POST['signup']))
{
  //check that passwords match.
  if($_POST['p1'] != $_POST['p2'])
    $status = array("error-message","Passwords do not match.");
  else
  {
    $status = new_login($_SESSION['ta_id'], $_POST['p1'], $_POST['username']);
    if($status[0] == "success-message")
    {
      session_regenerate_id(true);
      session_write_close();
      header("Location:info.php");
    }
  }
}

?>
  <DIV class=header>
    <A HREF="#"><IMG src="https://www.math.ucdavis.edu/themes/math2012/images/math_logo-sub_page.png"></A>
  </DIV>
  <h1> <center>Welcome, 
    <?php print $_SESSION['ta_name']; ?>
  </center></h1>
  <h4>This appears to be your first time logging in to the TA Ranking Tool. Please enter your new desired username and password. Please note that passwords must contain at least one letter and one number.</h4>

<br>
  <form id="singlesection" action="signup.php" method="post">
   <fieldset>
    <legend>Create a Username and Password</legend>
      <label class="selections" for="username">Your New Username:</label>
      <input class="input" type="text" name="username" id="username" 
         <?php if(isset($_POST['username'])) print 'value="'.$_POST['username'].'"';?> />
        <br>
      <label class="selections" for="p1">Your New Password:</label>
      <input class="input" type="password" name="p1" id="p1" />
        <br>
      <label class="selections" for="p2">Confirm Your New Password:</label>
      <input class="input" type="password" name="p2" id="p2" />
      <br><br>
      <input id="sectionlist" type="submit" name="signup" value="Submit" style="float:right">
   </fieldset>
  </form>
<?php
if(isset($status))
{
  print '<div id="'.$status[0].'">'.$status[1].'</div>';
}
?>
</body>
</html>
