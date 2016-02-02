<?php
require('values.php');
require('functions.php');
html_header("Staff Login");
?>
<body >

<DIV class=header>
  <A HREF="#"><IMG style="width:500px; height:100px; margin:15px;" src="img/logo.png"></A>
</DIV>


<?php
if(!isset($_POST['submit'])) //if user has not hit Submit
{
  login_form("","","staff");
} //if user has not hit submit

else //user Has hit submit, check validity.
{
  $username = $_POST['user'];
  $password = $_POST['pass'];

  $username= trim($username);

  if( empty($username))
  { try_again("Please enter a username.",$username,"staff");}
  else if( empty($password))
  { try_again("Please enter a password.",$username,"staff");}

  else try
  {
   //open db
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "select count(*) from login_staff where username = '$username' and password = '$password'";
    $result = $db->query($sql)->fetch();
    if( $result[0] == 0)
    {
      //you were just plain wrong.
      try_again("Username/password pair not found.",$username,"staff");
    }
    else
    {
      //you had a valid login
     // get TA ID and name for the entire session.
    session_start();
    $_SESSION['name'] = $username;
    $sql = "select department from login_staff where username = \"$username\";";
    $result = $db->query($sql)->fetch();
    $_SESSION['dept'] = $result['department'];
     // go to next page.
    session_regenerate_id(true);
    session_write_close();
    header("Location:quarterstaff.php");
    exit();
    }
  }
  catch(PDOException $e)
  {
    puts('Exception : '.$e->getMessage());
    $db = NULL;
  }

} //check user creds
?>


</html>
