<?php
require('values.php');
require('functions.php');
html_header("TA Login");
?>

<DIV class=header>
  <A HREF="#"><IMG style="margin:10px; width:500px; height:100px;" src="img/logo.png"></A>
</DIV>

<?php
session_start();
if(isset($_GET['year']))
{
  $_SESSION['year'] = $_GET['year'];
  $_SESSION['season'] = $_GET['season'];
  $_SESSION['season_name'] = $_GET['sname'];
}
if(!isset($_POST['submit'])) //if user has not hit Submit
{
  login_form("");
} //if user has not hit submit

else //user Has hit submit, check validity.
{
  $username = $_POST['user'];
  $password = $_POST['pass'];

  $username= trim($username);

  if( empty($username))
  { try_again("Please enter a username.",$username);}
  else if( empty($password))
  { try_again("Please enter a password.",$username);}

  else try
  {
   //open db
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "select count(*) from login where username = '$username' and password = '$password'";
    $result = $db->query($sql)->fetch();
    if( $result[0] == 0)
    {
      //if you're not in the login db, this may be your first time.
      //username is first char of first name and full last name
      //"first time" password is sid
      
      //check to see if "first time" password is used.
      //DO NOT ADMIT THEM if they are already in login database.
      $fchar = $username[0];
      $lname = substr($username, 1);

      $sql2 = "select count(*)
               from (
                 SELECT sid FROM ta
                 WHERE name_first LIKE '$fchar%' AND LOWER(name_last) = '$lname' 
                     AND sid = '$password' 
                 EXCEPT
                 SELECT sid FROM login
                 WHERE sid = '$password'
                  )
                 ;";
                 
      $result2 = $db->query($sql2)->fetch();

      if( $result2[0] == 0)
      {
	//if user wants to go to land of unicorns
	 if($password=="takemetothelandofunicorns")
      	 {
           print'
	    <div style="position:absolute;z-index:0;left:0;top:0;width:100%;height:100%">
  	     <img src="img/rainbow.gif" style="width:100%;height:100%" alt="[]" />
	    </div>
            <script src="js/unicorn.js"></script>
            <style> body, a, a:hover { cursor:url(http://www.dolliehost.com/dolliecrave/cursors/cursors-all/animals01.gif), auto }
	    </style>
           ';
	    try_again("Welcome...to the land of unicorns...",$username);

      	 }
	else
	{
        //you were just plain wrong.
          try_again("Username/password pair not found.",$username);
	}
      }
      else
      {
        //you are logging in for the first time. We'll bring you to the signup page.
        $_SESSION['ta_id'] = $password;
        $sql3 = "select name_first, name_last, department from ta where sid = '$password';";
        $result3 = $db->query($sql3)->fetch();
        $name = $result3['name_first']." ".$result3['name_last'];
        if($name == " ") $name = "Unknown TA";
        $_SESSION['ta_name'] = $name;
        $_SESSION['tadept'] = $result3['department'];
        $_SESSION['noob'] = 'TRUE';
        // go to next page.
        session_regenerate_id(true);
        session_write_close();
        header("Location:signup.php");
        exit();

      }
    }
    else
    {
     //you had a valid login
     // get TA ID and name for the entire session.
     $sql = "select sid from login where username = '$username' and password = '$password'";
     $result = $db->query($sql)->fetch();
     $_SESSION['ta_id'] = $result[0];
     $sql = "select name_first, name_last, department from ta where sid = '$result[0]'";
     $result = $db->query($sql)->fetch();
     $_SESSION['ta_name'] = $result['name_first']." ".$result['name_last'];
     $_SESSION['tadept'] = $result['department'];
     // go to next page.
     session_regenerate_id(true);
     session_write_close();
     header("Location:info.php");
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
