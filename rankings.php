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
?>

<head>
<link rel="stylesheet" href="test_files/css3menu13/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="icon.ico" >
</head>

<?php
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);

 title($_SESSION['ta_name']); ?>

<body>
<ul id="css3menu1" class="topmenu">
	<li class="topfirst"><a href="info.php" style="height:29px;line-height:29px;" align="center"><span>Info</span></a>
	<ul>
        	<li class="subfirst"><a href="password.php">Change Password</a></li>
        </ul></li>
	<li class="topmenu"><a href="calendar.php" style="height:29px;line-height:29px;"align="center"><span>Calendar</span></a>
	<ul>
		<li class="subfirst"><a href="quarter.php">Select Quarter</a></li>
	</ul></li>
	<li class="toplast"><a href="MathCode.php" style="height:29px;line-height:29px;" align="center">Preferences</a></li>
</ul><p class="_css3m"><a href="http://css3menu.com/"></a> </p>

<hr>

<h2 style="margin-left:20px">You're done!</h2>
<p style="margin-left:20px">I think this is a good time to go get some ice cream.</p>
<br><br>
<p style="margin-left:20px">You can come back and change your preferences at any time before the deadline set by your staff member.</p>

</body>
