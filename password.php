<?php
require('values.php');
require('functions.php');
session_start();
if(!isset($_SESSION['ta_id']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:login.php");
}
if(isset($_POST['password']))
{
  //check that passwords match.
  if($_POST['p1'] != $_POST['p2'])
    $status = array("error-message","Passwords do not match.");
  else
  {
    $status = update_password($_SESSION['ta_id'], $_POST['p1']);
  }
}
?>
<head>
    <link rel="shortcut icon" href="icon.ico" >
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/example.css">
    <link href="css/styles.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="test_files/css3menu13/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>
    <link rel="stylesheet" href="css/thumbnailviewer.css" type="text/css" />
    <script src="js/thumbnailviewer.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/jssor.core.js"></script>
    <script type="text/javascript" src="js/jssor.utils.js"></script>
    <script type="text/javascript" src="js/jssor.slider.js"></script>
    <script type="text/javascript" src="js/jssor.main.js"></script>

</head>
<?php title($_SESSION['ta_name']); ?>

<body>

<?php nav("password.php"); ?>
<h3> <center> Change your password below </center></h3>

<br>
<fieldset style="margin-right:25%%; margin-left: 25%">
<legend>Change Your Password </legend>
<div>
  <form action="password.php" method="post">

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
