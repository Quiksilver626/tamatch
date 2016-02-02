<?php
require('values.php');
require('functions.php');
session_start();

    $d1 = get_deadline($_SESSION['tadept'], $_SESSION['year'],
                      $_SESSION['season']);
unset($_SESSION['section']);
unset($_SESSION['course']);
unset($_SESSION['dept']);
unset($_SESSION['ta_id']);
?>
<link rel="shortcut icon" href="icon.ico" >
<link href="css/styles.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="test_files/css3menu13/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>

<?php

print '<h3> <center>The deadline to enter preferences has passed.</center></h3>';
print '<p><center>The deadline for '.$_SESSION['season_name'].' '.$_SESSION['year'].' was '.$_SESSION['deadline'].'.</center></p>';
  //check against current date 
  $d2 = getdate();
//  $d1[2] = str_pad ( $d1[2] , 2 , "0", STR_PAD_LEFT );
//  $d["mday"] = str_pad ( $d2["mday"] , 2 , "0", STR_PAD_LEFT );
  $current = $d2["year"].$d2["mon"].$d2["mday"];
print "<br><p>Today is $current.</p>";
  $dead = $d1[0].$d1[1].$d1[2];
print "<br><p>Deadline is $dead.</p>";
?>

