<?php
require('values.php');
require('functions.php');
session_start();

unset($_SESSION['section']);
unset($_SESSION['course']);
unset($_SESSION['dept']);

if(!isset($_SESSION['ta_id']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:login.php");
}
?>
<link rel="shortcut icon" href="icon.ico" >
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="test_files/css3menu13/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>

<?php

print '<h3> <center>Your session has expired.</center></h3>';
print '<p><center>Please use the link provided to you by your staff member to log in again.</center></p>';
?>

