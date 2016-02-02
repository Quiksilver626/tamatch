<?php

class Pref 
{
  public $section;
  public $ta;
  public $value;
}

function html_header($title) 
{
print '<!DOCTYPE html>';
print '<html lang="en">';
print '<head>';
print '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
print '<title>';
print $title;
print '</title>';
print '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">';
print '<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">';
print '<link rel="stylesheet" type="text/css" href="css/styles.css">';
print '<link rel="shortcut icon" href="icon.ico" >';
print '<style>';
print '.modal-footer {   border-top: 20px; }';
print '.modal-content { margin-top: 100px; }';
print 'h1{';
print '  font-family: "Lucida Sans Unicode", "Arial", "sans-serif";';
print '}';
print '.btn-primary{';
print '  background-color: #002855;';
print '  border-color: #002855;';
print '}';
print 'a{';
print '  color: #002855;';
print '}';
print '</style>';
print '<!-- Site Header Content //-->';
print '</head>';
} //html_header


function staffheader($name, $filename, $year, $season_name, $season)
{
  if((isset($_SESSION['scipfile_exists']) && $_SESSION['scipfile_exists'] != $season) || 
     (isset($_SESSION['gsfile_exists']) && $_SESSION['gsfile_exists'] != $season )|| 
     (isset($_SESSION['scipfile2_exists']) && $_SESSION['scipfile2_exists'] != $season))
  {
    unset($_SESSION['scipfile_exists']);
    unset($_SESSION['gsfile_exists']);
    unset($_SESSION['scipfile2_exists']);
  }
print'
<head>
	<link rel="stylesheet" type="text/css" href="css/styles.css">
	<link rel="shortcut icon" href="icon.ico" >
</head>
	<link rel="stylesheet" href="test_files/css3menu1/style.css" type="text/css" /><style type="text/css">._css3m{display:none}</style>
	<link href="http://code.jquery.com/ui/1.9.2/themes/flick/jquery-ui.css" rel="stylesheet" type="text/css" />
	<script src="http://code.jquery.com/jquery-1.8.3.js" type="text/javascript"></script>
	<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js" type="text/javascript"></script>
       <IMG id="logo" style="height:100px; width:500px;" src="img/logo.png"/>
    <a href="loginstaff.php" class="logout rounded blue effect-3">Logout</a>
';

if($filename=="ta.php" || $filename=="tacal.php" || $filename=="conflicts.php" || $filename == "scip.php" || $filename == "scipk.php" || $filename == "mancourse.php" || $filename == "mansection.php" || $filename == "quarterstaff.php" || $filename == "noresponse.php" || $filename == "coursepref.php")
{
   print'<p class="quarterid"> '.$season_name.' '.$year.' </p>';
   print'<p class="welcome">Welcome, '.$name.'</p>';
}
if($filename == "tapref.php") 
{
   print'<p class="quarterid" style="margin-top:2%"> '.$season_name.' '.$year.' </p>';
   print'<p class="welcome">Welcome, '.$name.'</p><br><br>';
}
print'
<ul id="css3menu1" class="topmenu">
	<li class="topfirst"><a href="quarterstaff.php" style="';
if($filename == "quarterstaff.php" || $filename == "passwordstaff.php") print 'color:gold;';
print 'height:30px;line-height:30px;"><span>Select Quarter</a></span>
        <ul>
        <li class="subfirst"><a ';
if($filename == "passwordstaff.php") print 'style="color:gold"';
print 'href="passwordstaff.php">Change Password</a></li>
        </ul></li>
	<li class="topmenu"><a href="ta.php" style="';
if($filename == "ta.php" || $filename == "tacal.php") print 'color:gold;';
print 'height:30px;line-height:30px;"><span>Manage TAs</a></span>
        <ul>
        <li class="subfirst"><a ';
if($filename == "tacal.php") print 'style="color:gold"';
print 'href="tacal.php">TA Schedules</a></li>
        </ul></li>
	<li class="topmenu"><a href="mancourse.php" style="';
if($filename == "mancourse.php") print 'color:gold;';
print 'height:30px;line-height:30px;">Manage Courses</a></li>
        <li class="topmenu"><a href="coursepref.php" style="';
if($filename == "coursepref.php" || $filename == "tapref.php" || $filename == "noresponse.php") print 'color:gold;';
print 'height:30px;line-height:30px;"><span>TA Stats</span></a>
        <ul>
        <li class ="subfirst"><a ';
if($filename == "tapref.php") print 'style="color:gold"';
print 'href="tapref.php">TA Preferences</a></li>
        <li><a ';
if($filename == "noresponse.php") print 'style="color:gold"';
print 'href="noresponse.php">TAs Not Responded</a></li>
        </ul></li>
	<li class="topmenu"><a href="conflicts.php" style="';
if($filename == "conflicts.php") print 'color:gold;';
print 'height:30px;line-height:30px;">Add Constraints</a></li>
        <li class="toplast"><a href="scip.php" style="';
if($filename == "scip.php") print 'color:gold;';
print 'height:30px;line-height:30px;">View Results</a></li>
</ul><p class="_css3m"><a href="http://css3menu.com/">menu drop down</a> by Css3Menu.com</p>
<body>
';
}


function title($ta_name)
{
print '
       <IMG id="logo" style="width: 505px; height:100px; margin: 10px;" src="img/logo.png"/>
    <a href="login.php" class="logout rounded blue effect-3">Logout</a>

<h1 id="welcome"> <center> Welcome, '.$ta_name.' </center></h1>
';
}

function nav($filename)
{
print'
<ul id="css3menu1" class="topmenu">
	<li class="topfirst"><a href="info.php" style="';
if($filename == "info.php" || $filename == "password.php") print 'color:gold;';
print ' height:30px;line-height:30px;"><span>Information</span></a>
	<ul>
	<li class="subfirst"><a ';
if($filename == "password.php")	print 'style="color:gold"';
print 'href="password.php">Change Password</a></li>
	</ul></li>
	<li class="topmenu"><a href="calendar.php?dept='.$_SESSION['tadept'].'" style="';
if($filename == "calendar.php" || $filename == "quarter.php") print 'color:gold;';
print'"height:30px;line-height:30px;"><span>Calendar</span></a>';
/*	<ul>
		<li class="subfirst"><a '; 
if($filename == "quarter.php")	print 'style="color:gold;"';
print 'href="quarter.php">Select Quarter</a></li>
	</ul></li>*/
print'	<li class="toplast"><a href="MathCode.php" style="';
if($filename == "MathCode.php")	print 'color:gold;';
print' height:30px;line-height:30px;">Preferences</a></li>
</ul><p class="_css3m"><a href="http://css3menu.com/"></a></p>

<hr>
';
}

function login_form($status,$username,$staff) {
print '<!--login modal-->';
print '<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">';
print '  <div class="modal-dialog">';
print '  <div class="modal-content">';
print '      <div class="modal-header">';
if(!isset($staff))
  print '          <img type="image" src="img/info.gif" id="tooltipbutton" value="Test" title="If this is your first time logging in, your username is the first letter of your first name and your entire last name (all lowercase) and your password is your UC Davis student ID.">';
print '          <h1 class="text-center">Login</h1>';
print '      </div>';
print '      <div class="modal-body">';
print '      <div id="error-message">';
print $status;
print '      </div>';
print '          <form class="form col-md-12 center-block" action="';
if(isset($staff)) print 'loginstaff.php'; else print 'login.php';
print'" method="post">';
print '            <div class="form-group">';
print '              <input type="text" class="form-control input-lg "';
if(empty($username)) 
{
  print 'placeholder="Username" ';
}
else
{
  print 'value="';
  print $username;
  print '" ';
} 
print 'id="user" name="user">';
print '            </div>';
print '            <div class="form-group">';
print '              <input type="password" class="form-control input-lg" placeholder="Password" id="pass" name="pass">';
print '            </div>
';
print '            <div class="form-group">';
print '              <input type="submit" name="submit" id="submit" value="Submit" class="btn btn-primary btn-lg btn-block" />';
print '            </div>';
print '          </form>';
print '      </div>';
print '      <div class="modal-footer">';
print '          <div class="col-md-12">';
print '      </div>';
print '  </div>';
print '  </div>';
print '</div>';

} //login_form

function print_ranked($neutral, $like, $dislike, $type)
{
  print '<p>Neutral '.$type.':</p><ul>';
  foreach($neutral as $n)
  {
    if( $n != "[object HTMLOListElement]")
      print '<li>'.$n.'</li>';
  }
  print '</ul><br />';
  print '<p>Liked '.$type.':</p><ul>';
  foreach($like as $l)
  {
    if( $l != "[object HTMLOListElement]")
      print '<li>'.$l.'</li>';
  }
  print '</ul><br />';
  print '<p>Disliked '.$type.':</p><ul>';
  foreach($dislike as $d)
  {
    if( $d != "[object HTMLOListElement]")
      print '<li>'.$d.'</li>';
  }
  print '</ul><br />';
} //print_ranked

function input_courses($ta, $list, $flag)
{
  // This function inputs the course preferences into the database.
  // $flag should be 0 if we are dealing with the neutral list, and -1 or 1 otherwise,
  //   depending on whether we are dealing with liked or disliked courses.
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $count = count($list);
  for($i=0; $i<$count; $i++)
  {
    //get course name
    $words = explode(" ", $list[$i]);
    $course = $words[1];
    $dept = $words[0];
    $supersection = '0';
    if(count($words) > 2) $supersection = $words[2];
//print '<p>'.$sql.' '.$id.'</p><br />';
      //update if value exists, insert otherwise
      try {
      $sql = "select count(*) from rcourse
             where sid = $ta and course = '$course' AND department = '$dept'
               AND supersection = '$supersection';";
      $result = $db->query($sql)->fetch();
//print '<p>'.$sql.' '.$result[0].'</p><br />';
      if( $result[0] > 0)
      {
        $exec = $db->prepare("UPDATE rcourse SET value = ? WHERE sid = ? and course = ? and department = ? AND supersection = ?;");
        $exec->execute(array((($i+1)*$flag), $ta, $course, $dept, $supersection));
      }
      else
      {
        $exec = $db->prepare("INSERT into rcourse(sid, course, department, supersection, value) values (?,?,?, ?, ?)");
        $exec->execute(array($ta, $course, $dept, $supersection, (($i+1)*$flag)));
      }
      }
     catch(PDOException $e) {
        echo $e->getMessage();
    }
  } 
}

function input_times($ta, $list, $flag)
{
  // This function inputs the tod preferences into the database.
  // $flag should be 0 if we are dealing with the neutral list, and -1 or 1 otherwise,
  //   depending on whether we are dealing with liked or disliked tods.
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $count = count($list);
  for($i=0; $i<$count; $i++)
  {
    $tod = $list[$i];
//print '<p>'.$sql.' '.$id.'</p><br />';
      //update if value exists, insert otherwise
    if($tod != "[object HTMLOListElement]")
    try {
    $sql = 'select count(*) from rtod where sid = '.$ta.' and tod = "'.$tod.'";';
    $result = $db->query($sql)->fetch();
//print '<p>'.$sql.' '.$result[0].'</p><br />';
      if( $result[0] > 0)
      {
        $exec = $db->prepare("UPDATE rtod SET value = ? WHERE sid = ? and tod = ?;");
        $exec->execute(array((($i+1)*$flag), $ta, $tod));
      }
      else
      {
        $exec = $db->prepare("INSERT into rtod(sid, tod, value) values (?, ?, ?)");
        $exec->execute(array($ta, $tod, (($i+1)*$flag)));
      }
     }
     catch(PDOException $e) {
        echo $e->getMessage();
    }
  }
}

function parse_courses($raw, $ta)
{
  $lists = explode( '|', $raw);
  $neutral = explode( ',', $lists[0]);
  $like = explode( ',', $lists[1]);
  $dislike = explode( ',', $lists[2]);
  //print_ranked($neutral, $like, $dislike, "Courses");
  input_courses($ta, $neutral, "0");
  input_courses($ta, $like, "1");
  input_courses($ta, $dislike, "-1");
} //parse_courses

function parse_tods($raw, $ta)
{
  $lists = explode( '|', $raw);
  $neutral = explode( ',', $lists[2]);
  $like = explode( ',', $lists[0]);
  $dislike = explode( ',', $lists[1]);
//  print_ranked($neutral, $like, $dislike, "Times");
  input_times($ta, $neutral, "0");
  input_times($ta, $like, "1");
  input_times($ta, $dislike, "-1");
} //parse_courses

function puts($string) {
  echo $string . "<br/>";
}

function try_again($str,$str2,$str3) {
  puts(""); //reset the modal
  login_form($str,$str2,$str3);

}

function print_movables($type,$sql)
{
  //Queries the db with the SQL statement and prints out each corresponding course
  //name as a movable list item. 
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try{
    $result = $db->query($sql);
    foreach($result as $name)
    {
      if($type == "course")
      {
          print '<li class="'.$type.'"><i style="float:left" class="icon-move"></i><div style="text-align:center">'.$name['department'].' '.$name['name'];
          $sql2 = "select count(*) from section
                   where department = '".$name['department']."'
                     AND course = '".$name['name']."' AND supersection = 'A';";
          $result2 = $db->query($sql2)->fetch();
          if($result2[0] > 0) 
            print ' '.$name['supersection'];
          print '</div></li>';
     
      }
      else
      print '<li class="'.$type.'"><i style="float:left" class="icon-move"></i><div style="text-align:center">'.$name['name'].'</div></li>';
    }
    }
  catch(PDOException $e)
  {    echo $e->getMessage();}

}

function populate_neutral_courses($ta, $dept, $season, $year)
{
  //This function has two parts. First we must find all courses not yet ranked by this TA.
  //Then we want all courses ranked 0 by this TA.
    $sql = "select c.name as name, c.department as department, s.supersection as supersection
            from course c, ta t, section s
            where c.department = t.department
              AND s.department = c.department AND s.course = c.name
              AND t.sid = '$ta' and c.department = '$dept'
              AND s.status != 'deleted' and c.status !='deleted'
              AND s.quarter_season = '$season' AND s.quarter_year = '$year'
              AND s.status != 'staff'
            group by c.department, c.name, supersection
          except
            select course, department, supersection
            from rcourse
            where sid = '$ta' and department = '$dept' ;";
    print_movables("course",$sql);
    $sql = "select r.course as name, r.department, r.supersection
            from rcourse r, course c
            where r.sid = '$ta' and r.department = '$dept' and r.value = 0
               and r.course = c.name and r.department = c.department 
               and c.status != 'deleted';";
    print_movables("course",$sql);
} //populate neutral courses

function populate_liked_courses($ta, $dept, $season, $year)
{
    $sql = "select course as name, department, supersection
            from rcourse
            where sid = '$ta' and department = '$dept' and value > 0
            order by value asc;";
    print_movables("course",$sql);
} //populate liked courses

function populate_disliked_courses($ta, $dept, $season, $year)
{
    $sql = "select course as name, department, supersection
            from rcourse
            where sid = '$ta' and department = '$dept' and value < 0
            order by value desc;";
    print_movables("course",$sql);
} //populate disliked courses

function populate_neutral_times($ta)
{
  //This function has two parts. First we must find all times not yet ranked by this TA.
  //Then we want all courses ranked 0 by this TA.
    $sql = "select name, start from tod except select t.name, t.start from tod t, rtod r where r.sid = '$ta' and r.tod = t.name order by start asc;";
    print_movables("time",$sql);
    $sql = "select t.name, t.start from tod t, rtod r where r.sid='$ta' and r.tod = t.name and r.value=0 order by t.start asc;";
    print_movables("time",$sql);
} //populate neutral times

function populate_liked_times($ta)
{
    $sql = "select t.name, r.value from tod t, rtod r where r.sid='$ta' and r.tod = t.name and r.value>0 order by r.value asc;";
    print_movables("time",$sql);
} //populate liked courses

function populate_disliked_times($ta)
{
    $sql = "select t.name from tod t, rtod r where r.sid='$ta' and r.tod = t.name and r.value<0 order by r.value desc;";
    print_movables("time",$sql);
} //populate disliked courses

function set_pref_values($ta, $block, $btb, $sameday, $ct)
{ 
  //We put the four integer preference values into the TA's record.
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try
    {
      $sql = "select count(*) from pref where sid = $ta;";
      $result = $db->query($sql)->fetch();
      if( $result[0] > 0)
      {
        $exec = $db->prepare("UPDATE pref SET block = ?, same_day = ?, back_to_back = ?, courses_vs_times = ? WHERE sid = ?;");
        $exec->execute(array($block, $sameday, $btb, $ct, $ta));
      }
      else
      {
        $exec = $db->prepare("INSERT INTO pref(block, same_day, back_to_back, courses_vs_times, sid) VALUES(?,?,?,?,?);");
        $exec->execute(array($block, $sameday, $btb, $ct, $ta));
      }
    }
    catch(PDOException $e)
    {    echo $e->getMessage();}

   
} //set ta's preference values

function print_pref_value($field, $ta, $value)
{
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if($field == 'back-to-back')
      $value = 0;
    $sql = 'SELECT count(*) FROM pref WHERE sid = "'.$ta.'" AND '.$field.' = "'.$value.'";';
    $result = $db->query($sql)->fetch();
    if( $result[0] != 0)
      print 'selected="selected"';
}

function populate_professors()
{
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM professor ORDER BY name_full;';
    $result = $db->query($sql);
    print '<option value="0">None</option>';
    foreach($result as $name)
    {
      print '<option value="'.$name['id'].'">'.$name['name_first'].' '.$name['name_last'].'</option>';
    }
 
} //populate professors

function populate_quarters()
{
    //first get current quarter and then go to next quarter.
    $date =  getdate();
    $year = $date["year"];
    $month = ($date["mon"]);
    if($month < 3) $season = 1;
    else if($month < 6) $season = 2;
    else if($month < 8) $season = 3;
    else if($month < 10) $season = 4;
    else if($month <= 12) $season = 5;
    $season++;
    if($season == 3 || $season == 4)
      $season = 5;
    if($season > 5)
    {
      $season = 1;
      $year++;
    }
    //next show current quarter and future/past  quarters
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'select * from quarter WHERE (year*10+season_num) <= '.$year.$season.' ORDER BY year DESC,season_num DESC LIMIT 5;';
    $result = $db->query($sql);
    foreach($result as $quarter)
    {
      print '<option 
        value="'.$quarter['year'].'|'.$quarter['season_num'].'|'.$quarter['season'].'"';
      if($quarter['year'] == $year && $quarter['season_num'] == $season)
        print ' selected="selected" ';
      print '>'.$quarter['season'].' '.$quarter['year'].'</option>';
    }
}

function populate_depts()
{
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT * FROM department ORDER BY code ASC;';
    try{
    $result = $db->query($sql);
    foreach($result as $dept)
    {
      if($dept['code'] == $_SESSION['dept'])
      print '<option selected="selected" value="'.$dept['code'].'">'.$dept['code'].'</option>';
      else if($dept['code'] != "Course")
      print '<option value="http://tamatch.math.ucdavis.edu/MathWeb/calendar.php?dept='.$dept['code'].'">'.$dept['code'].'</option>';
    }
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}

}

function populate_courses($dept, $url)
{
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT c.name FROM course c, event e WHERE c.department = \"$dept\" AND e.course = c.name AND e.department = c.department AND e.quarter_year = ".$_SESSION['year']." AND e.quarter_season = ".$_SESSION['season'];
    if($url == "http://tamatch.math.ucdavis.edu/MathWeb/scip.php")
      $sql.=" AND c.level < 2 AND e.type = 'discussion'
              GROUP BY c.name ORDER BY c.level ASC;";
    else if($url == "http://tamatch.math.ucdavis.edu/MathWeb/coursepref.php")
      $sql.=" GROUP BY c.name ORDER BY 1 ASC;";
    
    else
      $sql.=" GROUP BY c.name ORDER BY 1 DESC;";
    
    try{
    $result = $db->query($sql);
    print '<option value="'.$url.'?dept='.$dept.'&course=NULL">--Select a Course--</option>'; 
    foreach($result as $course)
    {
      if($course['name'] == $_SESSION['course'])
      print '<option selected = "selected" value="'.$course['name'].'">'.$course['name'].'</option>';
      else
      print '<option value="'.$url.'?dept='.$dept.'&course='.$course['name'].'">'.$course['name'].'</option>';
    }
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}

}

function populate_sections($course, $dept, $url)
{
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT s.name 
            FROM section s, event e 
            WHERE e.course = s.course AND e.department = s.department
              AND e.section = s.name AND e.course = "'.$course.'"  
              AND e.department ="'.$dept.'" AND e.quarter_year = '.$_SESSION['year'].' 
              AND e.quarter_season ='.$_SESSION['season'].' 
              AND s.status != "deleted"
            GROUP BY s.name ORDER BY s.name ASC;';
  try{
    $result = $db->query($sql);
    print '<option value="'.$url.'?dept='.$dept.'&course='.$course.'&section=NULL">--Select a Section--</option>';
    foreach($result as $section)
    {
      print '<option value="'.$url.'?dept='.$dept.'&course='.$course.'&section='.$section['name'].'"';
      if($section['name'] == $_SESSION['section']) print ' selected="selected"';
      print '>'.$section['name'].'</option>';
    }
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}

}
function add_event($input, $entry, $year, $season, $sid)
{
    $section="";
    $course="";
    $dept = "";

    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    try 
    {
      //if we came in with section name, we also have dept and course.

      if($entry == "section")
      {
        $section = $input;
        $course = $_SESSION['course'];
        $dept = $_SESSION['dept'];
      }
      else if($entry == "crn")
      {
        //if we came in with crn, need to get section, course, dept from crn.
        $crnerror=1;
        $sql = "SELECT * FROM section WHERE crn = $input AND quarter_year = $year AND quarter_season = $season;";
        $result = $db->query($sql);
        foreach($result as $s)
        {
          //find events, check for conflicts, add to calendar.
          $section = $s['name'];
          $course = $s['course'];
          $dept = $s['department'];
          $crnerror--;
        }
        if($crnerror == 1) return("CRN $crn does not exist.");
      }
      //Now we have the section data. Find all corresponding events.
      $sql = "SELECT * FROM event WHERE section = \"$section\" AND course = \"$course\" AND department = \"$dept\" AND quarter_year = $year AND quarter_season = $season;";
      $events = $db->query($sql);
      $i=0;
      foreach($events as $event)
      {
        $i++;
        //first get all user events of this quarter.
         $sql2 = "SELECT * FROM calendar WHERE sid = $sid AND quarter_year = $year AND quarter_season = $season;";
         $uevents = $db->query($sql2);
         foreach($uevents as $uevent)
         {
           //check time conflict between $event and $uevent.
           if($event['day'] == $uevent['day'] && 
               (($event['end']>$uevent['start'] && $uevent['start']>=$event['start']) ||
                ($uevent['end']>$event['start'] && $event['start']>=$uevent['start'])))
           {
             $error = "This section conflicts with your current schedule. ";
             return($error);
           }

           //check duplicate section in a course.
           if($uevent['course'] == $event['course'] && 
              $uevent['department'] == $event['department'])
           {
             $error = "You are already signed up for a section in this course. ";
             return($error);
           }

         } //foreach uevents as uevent
       } //for each event
       //if there are no conflicts, now add event to db
      $sql3 = "SELECT * FROM event WHERE section = \"$section\" AND course = \"$course\" AND department = \"$dept\" AND quarter_year = $year AND quarter_season = $season;";
    $events2 = $db->query($sql3);
    foreach($events2 as $event2)
    {
      //insert into calendar all these events
        $exec = $db->prepare("INSERT into calendar(sid, section, course, department, day, start, end, type, quarter_year, quarter_season) values (?,?,?,?,?,?,?,?,?,?)");
        $exec->execute(array($sid, $event2['section'], $event2['course'], $event2['department'], $event2['day'], $event2['start'], $event2['end'], $event2['type'], $event2['quarter_year'], $event2['quarter_season']));
    }
          // return('Reached the End!'.$i);
      return("");

  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}
}

function populate_assigned($sid, $year, $season)
{
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM calendar WHERE sid = $sid AND quarter_year = $year AND quarter_season = $season GROUP BY department, course, section;"; 
    try
    {
      $sections = $db->query($sql);
      foreach($sections as $section)
      {
        print '<option value="'.$section['department'].'|'.$section['course'].'|'.$section['section'].'">'.$section['department'].' '.$section['course'].' '.$section['section'].'</option>';
      }
    }
  catch(PDOException $e)
  {    echo $e->getMessage();}

}

function drop_section($section, $course, $dept, $year, $season, $sid)
{
  //got section id, now go and drop all related cal events.
    if(!isset($db))
    {
      $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    try
    {
      //drop the calendar events of this section 
      $exec = $db->prepare("DELETE FROM calendar WHERE sid = ? AND section = ? AND course = ? AND department = ? AND quarter_year = ? AND quarter_season = ?;");
      $exec->execute(array($sid, $section, $course, $dept, $year, $season));
    }
    catch(PDOException $e)
    {    echo $e->getMessage();}
}

function populate_calendar_body($sid, $year, $season)
{
  print '<tbody>';
  $ten = new DateInterval("PT10M");
  $time = new DateTime('0730');
  for($i=0; $i<87; $i+=1)
  {
     print '<tr>';
     if($i%3 == 0)
     {
       print '<td rowspan="3" style="text-align:center;"><p2 class="shadow40" style="text-align:center;width:100%;">'.$time->format('h:i A').'</p2></td>';
    //   print '<td rowspan="3">'.($time->format('H')*100+$time->format('i')).'</td>';
     } 
    for($day=1; $day<=5; $day++)
    {
       //If there is an event starting now, print it with proper rowspan.
       //If there is an event going on now, print nothing.
       //Otherwise, print empty cell.
     
      $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      try
      {
        //First gather all sections in an array, for implicit numbering.
        $sql = "SELECT course, department
                FROM calendar
                WHERE quarter_year = $year AND quarter_season = $season AND sid = $sid
                GROUP BY department, course;";
        $result = $db->query($sql);
        $courses = array();
        foreach($result as $r)
          array_push($courses, $r['department'].' '.$r['course']);
        //Get all events for this TA on this day.
        if($day==1) $d = "M";
        if($day==2) $d = "T";
        if($day==3) $d = "W";
        if($day==4) $d = "R";
        if($day==5) $d = "F";
        $sql = "SELECT * FROM calendar WHERE sid = $sid AND quarter_year = $year AND quarter_season = $season AND day = \"$d\";";
        $events = $db->query($sql);
        $found = 0;
        foreach($events as $event)
        {
          //check for starting now. 
          $now = ($time->format('H')*100+$time->format('i'));
          if($now == $event['start'])
          {
            //start a cell that spans as long as it needs to.
            $a = (string)$event['start'];
            $b = (string)$event['end'];
            if(strlen($a)==3) $a = '0'.$a;
            if(strlen($b)==3) $b = '0'.$b;
            $ad = new DateTime($a);
            $bd = new DateTime($b);
            $interval = $ad->diff($bd);
            $span = ($interval->format("%H")*60+$interval->format("%i"))/10;
            $title = $event['department'].' '.$event['course'].' '.$event['section'];
            print '<td id="nonempty" class="color';
            //now get course # mod 6 and print it
            for($j=0; $j< count($courses); $j++)
            {
              if($courses[$j] == $event['department'].' '.$event['course'])
              print $j; 
            }
            print '" rowspan="'.$span.'">'.$title.'</td>';
            $found++;
          }
          //check for overlapping now.
          if($now > $event['start'] && $now < $event['end'])
          {
            //do nothing. Literally.
            //except say we found a match.
            $found++;
          }
        }
        //if we haven't found a time match, nothing is here. print normal cell.
        if(!$found) print '<td id="empty'.($i%3).'"></td>';
      }
      catch(PDOException $e)
      {    echo $e->getMessage();}
    }
    print '</tr>';
    $time->add($ten);
  }
  print '</tbody>';
}

function quote($string)
{
  return '"'.$string.'"';
}

function insert_ta($data, $i, $year, $season, $dept)
{
  $units = $data->sheets[0]['cells'][$i][4];
  $sid = $data->sheets[0]['cells'][$i][5];
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //from here we know what form the data takes- namely that the headers are
    //Name, Rank, Units, SID, Department, Status
    //So we can insert a ta based on the data in this row.
    //assume name takes the form of "FirstName LastName"
    //ONLY INSERT IF sid is unique!!
    if($sid != NULL)
    {
      $sql = "SELECT count(*) FROM ta WHERE sid = $sid and department = '$dept';";
      $result = $db->query($sql)->fetch();
      if($result[0] == 0)
      {
      $exec = $db->prepare("DELETE FROM ta where sid = ?;");
      $exec->execute(array($sid));
      $exec = $db->prepare("DELETE FROM units where sid = ?;");
      $exec->execute(array($sid));

      $exec = $db->prepare("INSERT into 
                            ta(rank, name_first, name_last, status, sid, department)
                            values (?, ?, ?, ?, ?, ?)");
      $exec->execute(array(
                         $data->sheets[0]['cells'][$i][3],$data->sheets[0]['cells'][$i][1],
                         $data->sheets[0]['cells'][$i][2],$data->sheets[0]['cells'][$i][6],
                         $data->sheets[0]['cells'][$i][5],"$dept"
                  ));
      $exec = $db->prepare("INSERT into units(sid, year, season, value)
                                        values (?, ?, ?, ?)");
      $exec->execute(array($sid, $year,$season,$units));
      } //no blank SID
    } //sid unique
  } //try
  catch(PDOException $e)
  {echo $e->getMessage();}
}

function drop_table($table, $dept, $year, $season)
{
  //remember that $season is season_num.
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    if($table == "section")
    {
      //delete all sections, events of this quarter and dept.
      $exec = $db->prepare('DELETE FROM event WHERE quarter_year = '.$year.' AND quarter_season = '.$season.' AND department = "'.$dept.'";');
      $exec->execute();
      $exec = $db->prepare('DELETE FROM section WHERE quarter_year = '.$year.' AND quarter_season = '.$season.' AND department = "'.$dept.'";');
      $exec->execute();
    } 
    else if($table == "ta")
    {
      $sql = "SELECT t.sid FROM ta t, units u WHERE t.sid = u.sid
                AND u.year = $year AND u.season = $season AND t.department = \"$dept\";";
      $result = $db->query($sql);
      foreach($result as $r)
      {
        $exec = $db->prepare("DELETE FROM units WHERE sid = ?;");
        $exec->execute(array($r['sid']));
      }
      $exec = $db->prepare("DELETE FROM ta WHERE department = \"$dept\";");
      $exec->execute();
    }
  }
  catch(PDOException $e)
  {echo $e->getMessage();}

} //drop_table

function parse_times($times)
{

  //Assume Times is in form "DDD T-T, D T-T T-T,..." with D days of week and T times.
  //first we must break up the comma separated chunks.
  $chunks = explode(",",$times);
  $ccount = count($chunks);
  $events = array();
  for($i=0; $i<$ccount; $i++)
  {
    $blocks = explode(" ",$chunks[$i]);
    $j=0;
    if($blocks[$j]=="")
      $j++;
    $bcount = count($blocks);
    //first block should be a string of days.
    $days = $blocks[$j];
    $j++;
    for($j; $j < $bcount; $j++)
    {
      //each following block should be take the form of T-T, T times.
      $t = explode("-",$blocks[$j]);
      //make an event for this time period coupled with each day.
      for($k=0; $k < strlen($days); $k++)
      {
        array_push($events, $days[$k], $t[0]*100, $t[1]*100);
      }
    }
  }
  return($events);

}

function insert_section($data, $i, $year, $season)
{
  //season is int.
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //from here we know what form the data takes- namely that the headers are
    //CRN, Course, Dept, Name, Times
    //So we can insert a section based on the data in this row.
    $exec = $db->prepare("INSERT into section(course, department, professor_name, professor_dept,quarter_year,quarter_season, crn, name, times) values (?, ?, NULL,NULL, ?, ?, ?, ?,?);");
    $exec->execute(array($data->sheets[0]['cells'][$i][2],$data->sheets[0]['cells'][$i][3],
                $year, $season,$data->sheets[0]['cells'][$i][1],$data->sheets[0]['cells'][$i][4],
                $data->sheets[0]['cells'][$i][5]));
    //We have inserted the raw Times data but we need to make all the corresponding events.
    $events = parse_times($data->sheets[0]['cells'][$i][5]);
    //For each event i:i%3==0; i is the day, i+1 is the start time, i+2 the end time.
    for($j=0; $j<count($events); $j+=3)
    {
    //HACK: Put all events in as lectures and then change the T/R ones to discussion.
    $exec = $db->prepare("INSERT into event(section, course, department, type, day, start, end, quarter_year, quarter_season) values (?, ?, ?, ?, ?, ?, ?, ?,?);");
    $exec->execute(array($data->sheets[0]['cells'][$i][4],$data->sheets[0]['cells'][$i][2],
                         $data->sheets[0]['cells'][$i][3],"lecture",$events[$j],$events[$j+1],
                         $events[$j+2], $year, $season));
    $exec = $db->prepare("UPDATE event SET type = 'discussion' WHERE day = 'T';");
    $exec->execute();
    $exec = $db->prepare("UPDATE event SET type = 'discussion' WHERE day = 'R';");
    $exec->execute();
    //HACK: Change 22AL to a lecture as opposed to discussion so that later when we input section times 22AL will show up in the spreadsheet
    $exec = $db->prepare("UPDATE event SET type = 'lecture' WHERE course = '022AL' and department = 'MAT';");
    $exec->execute();   
    }
  }
  catch(PDOException $e)
  {echo $e->getMessage();}

}

function get_prefs($ta, $year, $season, $dept, $model)
{
  //Given a TA sid, we find all their course/tod prefs and compute their section prefs.
  //Returns array of section pref objects for all sections this quarter.
  //Note that a pref object has members value, ta (sid), and section (course and name).
 
  //First we need this TA's course vs time value.
  if(!isset($db))
  {
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  try
  {
    $sql = "select courses_vs_times from pref where sid = $ta;";
    $result = $db->query($sql);
    $cvt = 0;
    $t = 1;
    $c = 1;
    foreach($result as $r)
      $cvt = $r['courses_vs_times'];
    if($cvt == 2)
      $t = 0;
    if($cvt == 1)
      $c = 2; 
    if($cvt == -1)
      $t = 2; 
    if($cvt == -2)
      $c = 0;
    $num_courses = 0;
    $num_tods = 0;
    $sql = "select count(*) from rcourse where sid = $ta;";
    $result = $db->query($sql)->fetch();
    $num_courses = $result[0];
    $sql = "select count(*) from rtod where sid = $ta;";
    $result = $db->query($sql)->fetch();
    $num_tods = $result[0];
    //for every section, we must compute prefs.
    $sql = sql_section($dept, $year, $season);
    $result = $db->query($sql);
    $prefs = array();
    foreach($result as $r) 
    {
      $p = new Pref; 
      $p->ta = $ta;
      if($model == "victor")
        $p->section = $r['course']."-".strtolower($r['name'][0])."-".$r['name'][2];
      else if($model == "scip")
        $p->section = $r['course']." ".$r['name'];
      //now to get that value.
      //have c,t, and #s, need cp, tp.
      $course = $r['course'];
      $section = $r['name'];
      $supersection = $r['supersection'];
      $dept = $r['department'];
      $sql2 = "select value from rcourse 
               where sid = $ta and course = '$course' and department = '$dept'
                  and supersection = '$supersection';";
//puts($sql2);
      $result2 = $db->query($sql2);
      $cr = 0;
      foreach($result2 as $r2)
         $cr = $r2['value']; 
      /*if($ta == '994067483' && $cr != 0)
        echo "$course = $cr\n ::::::";*/
      if($cr > 0)
	{
        $cp = 100 - 50*($cr - 1)/$num_courses;
	/*echo $course;
        echo "=POSITIVE";
        echo "\n";*/
	}
      else if ($cr < 0)
      {
        $cp = 50*(1 - $cr)/$num_courses;
   	/*echo $course;
        echo "=NEGATIVE";
 	echo "\n";*/
	}
      else //$cr == 0 or errors
        $cp = 50;
      //now we need to get TOD from section. 
      //For Victor hack, just get times of T/R event. If none exists, $tp = 50.
      $tp = 50;
      $tr = 0;
      $start = 0;
      $end = 0;
      $sql2 = 
      "SELECT start, end from event where quarter_year = $year and quarter_season = $season 
               AND section = \"$section\" AND course = \"$course\" 
               AND department = \"$dept\" AND day =\"T\"
      UNION
       SELECT start, end from event where quarter_year = $year and quarter_season = $season 
               AND section = \"$section\" AND course = \"$course\"
               AND department = \"$dept\" AND day =\"R\";";
      $result2 = $db->query($sql2);
      foreach($result2 as $r2) 
      {
         $start = $r2['start'];
         $end = $r2['end'];
	 $time_full = $start.'-'.$end;
      }
      $sql2 = "SELECT value FROM rtod r, tod t WHERE sid = $ta AND r.tod = t.name AND t.start <= $start AND $end <= t.end;"; 
      $result2 = $db->query($sql2);
      foreach($result2 as $r2) 
         $tr = $r2['value']; 
      if($tr > 0)
        $tp = 100 - 50*($tr - 1)/$num_tods;
      else if ($tr < 0)
        $tp = 50*(1 - $tr)/$num_tods;
      //finally we have what we need to get the pref value.
      $p->value = ($cp * $c + $tp * $t) / ($c + $t);
	/*if($ta == '11')
	{
        echo $course;
	echo " ";
	echo $section;
        echo ' ('.$cp.'*'.$c.'+'.$tp.'*'.$t.') / ('.$c.'+'.$t.')'; 
	echo "=";
	echo $p->value;
	echo "<br/>>>>";
	}*/
      //Override the  value to -100 if we have a conflict with this professor.
      $sql2 = 
        "SELECT count(*)
         FROM professor_conflict p, section s
         WHERE s.professor_name = p.professor_name AND s.professor_dept = p.professor_dept
           AND p.sid = $ta AND p.quarter_year = $year AND p.quarter_season = $season
           AND s.department = '$dept' AND s.course = '$course' and s.name = '$section'  
        ;"; 
      $result2 = $db->query($sql2)->fetch();
      if($result2[0] > 0)
        $p->value = -100;
      //for now, discard the value if it is 50. We don't need it for Victor's code.
      if($p->value != 50 || $model == "scip" )
        array_push($prefs, $p);
    }
    /*
    if($ta == '11')   
      for($i=0;$i<count($prefs);$i++)
      {
        if($prefs[$i]->value > 50)
        {
          echo $prefs[$i]->section;
          echo "Positive<br/>";
        }
        else if($prefs[$i]->value < 50)
      	{
          echo $prefs[$i]->section;
          echo "Negative<br/>";
        }
      }
    */
    return($prefs);
  }
  catch(PDOException $e)
  {echo $e->getMessage();}
} //get_prefs

function prefcmp($a, $b)
{
  return($a->value < $b->value);
}

function prefcmpr($a, $b)
{
  return($a->value > $b->value);
}

function write_excel1($quarter,$dept)
{
  $xls = new Excel('TAData');
  $xls->home();
  $xls->top();
  $xls->label("Name");
  $xls->right();
  $xls->label("Likes");
  $xls->right();
  $xls->label("Hates");
  $xls->right();
  $xls->label("Conflicts");
  $xls->right();
  $xls->label("# Classes Taught");
  $xls->right();
  $xls->label("Ranking");
  $xls->right();
  $xls->label("Units");
  $xls->right();
  $xls->label("%");
  $xls->home();
  $xls->down();

  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //for each TA we need to gather the prefs and blacklist not given in the input file.
    $sql = "SELECT * from ta WHERE department = \"$dept\";";
    $results = $db->query($sql);
    foreach($results as $re)
    {
      //The headers are as seen above. We tackle each in turn.
      $xls->label($re['name_full']);
      $xls->right();
      $prefs = get_prefs($re['sid'], $quarter);
      $likes = array();
      $dislikes = array();
      for($i=0;$i<count($prefs);$i++)
      {
        if($prefs[$i]->value > 50)
         array_push($likes, $prefs[$i]);
        else if($prefs[$i]->value < 50)
         array_push($dislikes, $prefs[$i]);
        usort($likes, prefcmp);
        usort($dislikes, prefcmpr);
      }
      $likes_full = "";
      for($i=0;$i<(count($likes) - 1);$i++)
      {
        $likes_full .= $likes[$i]->section;
        $likes_full .= ", ";
      }
      $likes_full .= $likes[count($likes) - 1]->section;
//   if($re['sid'] == 6260) puts($likes_full);
      $dislikes_full = "";
      for($i=0;$i<(count($dislikes)- 1);$i++)
      {
        $dislikes_full .= $dislikes[$i]->section;
        $dislikes_full .= ", ";
      }
      $dislikes_full .= $dislikes[count($dislikes) - 1]->section;
//   if($re['sid'] == 6260) puts($dislikes_full);
      $xls->label($likes_full);
      $xls->right();
      $xls->label($dislikes_full);
      $xls->right();
      //Now conflicts. This should be as simple as adding together all the events of TA.
      $sql2 = 'SELECT e.start, e.end, e.day FROM event e, calendar c WHERE c.id_event=e.id
               AND c.id_ta = '.$re['sid'].' AND e.id_quarter = '.$quarter.';';
      $result2 = $db->query($sql2);
      $conflict_full = "";
      foreach($result2 as $r2)
      {
        $conflict_full .= $r2['day'].' '.round($r2['start']/100).'-'.round($r2['end']/100).', ';
      }
      $conflict_full = substr($conflict_full, 0, -2);
//   if($re['sid'] == 6260) puts($conflict_full);
      $xls->label($conflict_full);
      $xls->right();
      $u = $re['units'];
      $xls->label((int) ($u/2));
      $xls->right();
      $xls->label($re['rank']);
      $xls->right();
      $xls->label((int)($u));
      $xls->right();
      $xls->label((int)($u*12.5));
      $xls->down();
      $xls->home();
    //  puts($re['name_full']."|".$likes_full);
    //  print_r($likes);
    //  print_r($dislikes);
      
    }
    $xls->send();
  }
  catch(PDOException $e)
  {echo $e->getMessage();}
}

function update_password($sid, $password, $staff)
{
  //first check to see that the password is nonempty. Really I don't mind any other stupid
  //  password that users want to use.
  if($password == "")
    return array("error-message", "Please enter a password.");
  //next we need to ensure the password has at least one letter
  if(!preg_match('/[A-Za-z]/', $password))
    return(array("error-message","Password must contain at least one letter."));
  //next we need to ensure the password has at least one number
  if(!preg_match('/[0-9]/', $password))
      return(array("error-message","Password must contain at least one number."));

  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    if($staff == "staff")
    $exec = $db->prepare("UPDATE login_staff SET password = ? WHERE username = ?;");
    else
    $exec = $db->prepare("UPDATE login SET password = ? WHERE sid = ?;");

    $exec->execute(array($password, $sid));
    return array("success-message", "Password changed.");
  }
  catch(PDOException $e)
  {echo $e->getMessage();}
}

function write_excel2($year, $season, $dept, $sname)
{
  //initialize Excel file with proper headers

  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);

  define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

  $xl = new PHPExcel();
  $xl->getProperties()->setTitle("TA_Data");
  $xl->setActiveSheetIndex(0)
     ->setCellValue('A1', 'Name')
     ->setCellValue('B1', 'Likes')
     ->setCellValue('C1', 'Hates')
     ->setCellValue('D1', 'Conflicts')
     ->setCellValue('E1', '# Classes Taught')
     ->setCellValue('F1', 'Ranking')
     ->setCellValue('G1', 'Units')
     ->setCellValue('H1', '%');
  $xl->getActiveSheet()->setTitle('TA');

  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {

    //for each TA we need to gather the prefs and blacklist not given in the input file.
    $sql = "SELECT t.name_first, t.name_last, t.sid, t.rank, t.status, u.value
            FROM ta t, units u
            WHERE t.sid = u.sid 
            AND t.department = \"$dept\" AND u.year = $year AND u.season = $season;";
    $results = $db->query($sql);
    $t=1;
    foreach($results as $re)
    {
      //The headers are as seen above. We tackle each in turn.
      $t++;
      $xl->setActiveSheetIndex(0)->setCellValue("A$t", $re['name_first'].' '.$re['name_last']);
      $prefs = get_prefs($re['sid'], $year, $season, $dept, "victor");
      $likes = array();
      $dislikes = array();
      for($i=0;$i<count($prefs);$i++)
      {
        if($prefs[$i]->value > 50)
         array_push($likes, $prefs[$i]);
        else if($prefs[$i]->value < 50)
	 array_push($dislikes, $prefs[$i]);
        usort($likes, 'prefcmp');
        usort($dislikes, 'prefcmpr');
      }
      
      $likes_full = "";
      for($i=0;$i<(count($likes) - 1);$i++)
      {
        $likes_full .= $likes[$i]->section;
        $likes_full .= ", ";
      }
      if(count($likes) > 0)
        $likes_full .= $likes[max(0, count($likes) - 1)]->section;
   //if($re['sid'] == 11) puts($likes_full);
      $dislikes_full = "";
      for($i=0;$i<(count($dislikes)- 1);$i++)
      {
        $dislikes_full .= $dislikes[$i]->section;
        $dislikes_full .= ", ";
      }
      if(count($dislikes) > 0)
        $dislikes_full .= $dislikes[max(0, count($dislikes) - 1)]->section;
   //if($re['sid'] == 11) puts($dislikes_full);
      $xl->setActiveSheetIndex(0)->setCellValue("B$t", $likes_full);
      $xl->setActiveSheetIndex(0)->setCellValue("C$t", $dislikes_full);
      //Now conflicts. This should be as simple as adding together all the events of TA.
      $sql2 = 'SELECT start, end, day FROM calendar WHERE sid = '.$re['sid'].' 
               AND quarter_year = '.$year.' AND quarter_season = '.$season.';';
      $result2 = $db->query($sql2);
      $conflict_full = "";
      foreach($result2 as $r2)
      {
        $conflict_full .= $r2['day'].' '.round($r2['start']/100).'-'.ceil($r2['end']/100.0).', '; 
      }
      if($conflict_full!="") $conflict_full = substr($conflict_full, 0, -2);
//   if($re['sid'] == 6260) puts($conflict_full);
      $xl->setActiveSheetIndex(0)->setCellValue("D$t", $conflict_full);

      $u = $re['value'];
      $xl->setActiveSheetIndex(0)->setCellValue("E$t", (int) $u/2);
      $xl->setActiveSheetIndex(0)->setCellValue("F$t", $re['rank']);
      $xl->setActiveSheetIndex(0)->setCellValue("G$t", (int)($u));
      $xl->setActiveSheetIndex(0)->setCellValue("H$t", (int)($u*12.5));
    //  puts($re['name_full']."|".$likes_full);
    //  print_r($likes);
    //  print_r($dislikes);
    } //for each TA
    //Now we must write all sections of this department and quarter to the second sheet.
    $xl->createSheet();
    //First headers.
    $xl->setActiveSheetIndex(1)
       ->setCellValue('A1', 'CRN')
       ->setCellValue('B1', 'Classes')
       ->setCellValue('C1', 'Times')
       ->setCellValue('D1', 'Allow Outside Tas to teach')
       ->setCellValue('E1', 'Black List');
    $xl->getActiveSheet()->setTitle('Section');
    //Now we must fill the sheet.
    $sql = "SELECT s.name, s.course, s.department, s.crn, s.times, s.vtime, c.level
            FROM section s, course c, event e
            WHERE c.name = s.course AND c.department = s.department AND
                  s.quarter_year = $year AND s.quarter_season = $season AND
                  s.department = \"$dept\" AND c.level < 2 AND
                  s.course = e.course AND s.department = e.department AND s.name = e.section
                  AND e.type = 'discussion' 
            GROUP BY s.name, s.course, s.department
            ORDER BY c.level ASC, s.course ASC;";
    $result = $db->query($sql);
    $i = 1;
    foreach($result as $section)
    {
      $i++;
      $classes = $section['course']."-".strtolower($section['name'][0])."-".$section['name'][2];

      $times = $section['vtime'];

      //get times in the Victor style.
      /* 
      $t = explode(",", $section['times']);
              $days = $t[1];
        if(strlen($days)==1)
          $type = "discussion";
        else $type = "lecture";
        $t2 = explode("-", $t[0]);
        $s = explode(":", $t2[0]);
        $start = ((int)$s[0])*100 + (int)$s[1];
        $ampm = substr($t2[1], -2);
        $e = explode(":", substr($t2[1], 0, strlen($t2[1])-1));
        $end = ((int)$e[0])*100 + (int)$e[1];
        if($ampm == "PM")
        {
          if($start < 1200)
            $start+=1200;
          if($end < 1200)
            $end+=1200;
        }
      */

      //HACK: Assume that all 0-level courses cannot be taught by outside TAs
      $xl->getActiveSheet()
         ->setCellValue("A$i", $section['crn'])
         ->setCellValue("B$i", $classes)
         ->setCellValue("C$i", $times)
         ->setCellValue("D$i", $section['level']);
    }

    $xl->setActiveSheetIndex(0);
    $filename = $sname.'_'.$year.'_'.$dept; 
    $objWriter = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
    $objWriter->save($filename.'.xls');
    $cmd = "echo '$filename.xls' | python MatchingSoftware.py";
    exec($cmd, $output);
    $cmd = 'mv '.$filename.'final.xls xls';
    exec($cmd, $output);
    $cmd = 'rm -f '.$filename.'.xls';
//    exec($cmd, $output);
    
  } //try
  catch(PDOException $e)
  {echo $e->getMessage();}
}

function victor_table($dept, $year, $season, $sheet)
{
  /*
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
*/
  $filename ='xls/'.$season.'_'.$year.'_'.$dept.'final.xls'; 
  $data = new Spreadsheet_Excel_Reader();
  $data->setOutputEncoding('CP1251');
  $data->read($filename);
  print '<table id="assignments" border="1">
           <thead>
             <tr>
               <th>TA Name</th>
               <th>Assigned Section</th>
             </tr>
           </thead>
           <tbody>';
  $i = 2;
  for($i=2; $i <= $data->sheets[$sheet]['numRows'] && 
            $data->sheets[$sheet]['cells'][$i][1] != ""; $i++)
  {
    print '<tr>';
    print '<td>'.$data->sheets[$sheet]['cells'][$i][1].'</td>';
    $section = explode("-", $data->sheets[$sheet]['cells'][$i][3]);
    print '<td>'.$section[0].' '.strtoupper($section[1]).'0'.$section[2].'</td>';
    print '</tr>';
  } //for assigned TAs
  
  print '</tbody></table>';

  //now print table with Unassigned TAs.
  print '<table id="unassigned" border="1">
           <thead>
             <tr>
               <th>Unassigned TAs</th>
             </tr>
           </thead>
           <tbody>';
  while( $data->sheets[$sheet]['cells'][$i][1] == "") $i++;
  for($j = $i+1; $j <= $data->sheets[$sheet]['numRows'] &&
            $data->sheets[$sheet]['cells'][$j][1] != ""; $j++)
  {
     print '<tr><td>'.$data->sheets[$sheet]['cells'][$j][1].'</td></tr>';
  }

  print '</tbody></table>';
}
function insert_single_ta($dept, $fname, $lname, $rank, $units, $sid, $status, $year, $season)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    $sql = "select count(*) from ta where sid = $sid and department = '$dept';";
    $result = $db->query($sql)->fetch();
    if($result[0] > 0)
    {
      //Duplicate TA == Bad Times.
      return(array("error-message", "The TA with SID $sid is already in the database with department $dept."));
    }
    //from here we know what form the data takes- namely that the headers are
    //Name, Rank, Units, SID, Department, Status
    //So we can insert a ta based on the data in this row.
    //assume name takes the form of "FirstName LastName"
      $exec = $db->prepare("DELETE FROM ta where sid = ?;");
      $exec->execute(array($sid));
      $exec = $db->prepare("DELETE FROM units where sid = ?;");
      $exec->execute(array($sid));
    $exec = $db->prepare("INSERT into ta(rank, name_first, name_last, status, sid, department) values (?, ?, ?, ?, ?, ?)");
    $exec->execute(array($rank,$fname,$lname,$status,$sid,$dept));
    $exec = $db->prepare("INSERT into units(sid, year, season, value) values (?, ?, ?, ?)");
    $exec->execute(array($sid,$year,$season,$units));
  }
  catch(PDOException $e)
  {echo $e->getMessage();}
}

function ta_table($dept, $year, $season)
{
  print '<table id="tatable" class="stafftable" border="1">
           <thead>
             <tr>
               <th>Name</th>
               <th>Student ID</th>
               <th>Units</th>
               <th>Ranking</th>
               <th>Status</th>
             </tr>
           </thead>
           <tbody>';
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    $sql = "SELECT t.name_first, t.name_last, t.sid, t.rank, t.status, u.value
            FROM ta t, units u
            WHERE t.sid = u.sid 
            AND t.department = \"$dept\" AND u.year = $year AND u.season = $season;";
    $result = $db->query($sql);
    foreach($result as $ta)
    {
      print '<tr>';
      print '<td>'.$ta['name_first'].' '.$ta['name_last'].'</td>';
      print '<td>'.$ta['sid'].'</td>';
      print '<td>'.$ta['value'].'</td>';
      print '<td>'.$ta['rank'].'</td>';
      print '<td>'.$ta['status'].'</td>';
      print '</tr>';
    }
    print '</tbody></table>';
  }
  catch(PDOException $e)
  {echo $e->getMessage();}
}

function section_table($dept, $year, $season)
{
  print '<table id="sectiontable" class="stafftable" border="1">
           <thead>
             <tr>
               <th>CRN</th>
               <th>Course</th>
               <th>Name</th>
               <th>Times</th>
             </tr>
           </thead>
           <tbody>';
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    $sql = "SELECT s.crn, s.course, s.name, s.times, c.level 
            FROM section s, course c 
            WHERE s.department = \"$dept\" AND s.department = c.department
            AND c.name = s.course
            AND s.quarter_year=$year AND s.quarter_season = $season
            ORDER BY c.level ASC, s.course ASC;";
    $result = $db->query($sql);
    foreach($result as $ta)
    {
      print '<tr>';
      print '<td>'.$ta['crn'].'</td>';
      print '<td>'.$ta['course'].'</td>';
      print '<td>'.$ta['name'].'</td>';
      print '<td>'.$ta['times'].'</td>';
      print '</tr>';
    }
    print '</tbody></table>';
  }
  catch(PDOException $e)
  {echo $e->getMessage();}
}

function ta_excel($year, $season, $dept, $sname)
{
  //initialize Excel file with proper headers
  /*
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
  */
  define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

  $xl = new PHPExcel();
  $xl->getProperties()->setTitle("TA_Data");
  $xl->setActiveSheetIndex(0)
     ->setCellValue('A1', 'First Name')
     ->setCellValue('B1', 'Last Name')
     ->setCellValue('C1', 'Ranking')
     ->setCellValue('D1', 'Units')
     ->setCellValue('E1', 'SID')
     ->setCellValue('F1', 'Status');
  $xl->getActiveSheet()->setTitle('TA');

  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    $sql = "SELECT t.name_first, t.name_last, t.sid, t.rank, t.status, t.sid, t.department,                    u.value
            FROM ta t, units u
            WHERE t.sid = u.sid
            AND t.department = '$dept' AND u.year = $year AND u.season = $season;";
    $result = $db->query($sql);
    $i=1;
    foreach($result as $ta)
    {
      $i++;
      $xl->setActiveSheetIndex(0)
         ->setCellValue("A$i", $ta['name_first'])
         ->setCellValue("B$i", $ta['name_last'])
         ->setCellValue("C$i", $ta['rank'])
         ->setCellValue("D$i", $ta['value'])
         ->setCellValue("E$i", $ta['sid'])
         ->setCellValue("F$i", $ta['status']);
    }
    $filename = 'xls/'.$sname.'_'.$year.'_'.$dept.'_TAdata.xls'; 
    $objWriter = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
    $objWriter->save($filename);


  }//try
  catch(PDOException $e)
  {echo $e->getMessage();}
}
function scip_input($year, $season, $dept, $sname)
{
/*
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
*/
  //so we have three csv files to make: ta, section, pref.
  $tacsv = array ();
  $prefcsv = array ();
  $sectioncsv = array ();

  //Each row gets its own array; let's start with headers.
  $header = array ('Name', 'Ranking', 'Units', 'Status', 'Block', 'Sameday', 'Btb', 'Conflicts', 'NULL');
  array_push($tacsv, $header);
  $header = array ('Course', 'Section', 'Instructor', 'Day', 'Time', 'Units', 'TAs','NULL');
  array_push($sectioncsv, $header);
  //given a TA, we already have a function to find all section prefs. So let the list of 
  //  section names be the pref header.
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {

    //first we want to loop through all current sections of this dept. 
    $sql = count_sections($dept, $year, $season);
    $result = $db->query($sql)->fetch();
    if($result[0] == 0)
      return(array("error-message", "Department $dept has no section data for $sname $year."));
    $sql = sql_section($dept, $year, $season);
//puts($sql);
    $result = $db->query($sql);
    $header = array("");
    foreach($result as $r)
    {
      $course = $r['course'];
      $row = array($course, $r['name'], "");
      //Now to get the times.
      $sql2 = "SELECT *
               FROM event
               WHERE quarter_year = $year and quarter_season = $season
                 AND department = '$dept' AND course = '".$r['course']."' 
                 AND section = '".$r['name']."' AND type = 'lecture'
                 AND day != 'U' AND day != 'S'
               GROUP BY day;";
      $result2 = $db->query($sql2);
      $days = "";
      $start = "";
      $end = "";
      foreach($result2 as $r2)
      {
        $days.=$r2['day'];
        $start =  $r2['start'];
        $end = $r2['end'];
      } //Gather all the lecture days and get times.
      $time_full = $start.'-'.$end;
      array_push($row, $days);
      array_push($row, $time_full);
      array_push($row, $r['units']);
      array_push($row, $r['weight']);
      array_push($row, "0");
      $row2 = array("", "", "");
      $sql2 = "SELECT *
               FROM event
               WHERE quarter_year = $year and quarter_season = $season
                 AND department = '$dept' AND course = '".$r['course']."'
                 AND day != 'U' AND day != 'S'
                 AND section = '".$r['name']."' AND type = 'discussion';";
//puts($sql2);
      $result2 = $db->query($sql2);
      $discussion = 0;
      $days = "";
      $start = "";
      $end = "";
      foreach($result2 as $r2)
      {
        $days = $r2['day'];
        $start =  $r2['start'];
        $end = $r2['end'];
        $discussion = 1;
        array_push($row2, $days);
        $time_full = $start.'-'.$end;
        array_push($row2, $time_full);
      } //enter the discussion.
      array_push($row2, $r['units']);
      array_push($row2, $r['weight']);
      array_push($row2, "0");
      //only put in sections with discussions
      array_push($header, $course.' '.$r['name']);
      array_push($sectioncsv, $row);
      array_push($sectioncsv, $row2);
    } //for all sections.
    array_push($prefcsv, $header);
    //Now we get all TAs. We can fill pref.csv as we go here.
    $sql = "SELECT t.name_first, t.name_last, t.rank, t.status, t.sid, u.value
            FROM ta t, units u
            WHERE u.sid = t.sid
              AND t.department = '$dept' AND u.year = $year AND u.season = $season;";
//puts($sql);
    $result = $db->query($sql);
    foreach($result as $r)
    {
      $fullname = scip_clean($r['name_first']).' '.scip_clean($r['name_last']);
      $sid = $r['sid'];
      $row = array($fullname, $r['rank'], $r['value'], strtolower($r['status']));
      $sql2 = "SELECT * FROM pref WHERE sid = ".$r['sid'].";";
      $r2 = $db->query($sql2);
      $p = array();
      $countr2= 0;
      foreach($r2 as $rr2)
      {
        $countr2++;
        $p = array($rr2['block'], $rr2['same_day'], $rr2['back_to_back']);
      }
      if($countr2 == 0)
       $p = array(0,0,0);
      foreach($p as $p2)
        array_push($row, $p2);
      //finally we need to get all time conflicts in form D|SSSS|EEEE D|SSSS|EEEE....
      $sql2 = "SELECT day, start, end 
               FROM calendar
               WHERE sid = $sid AND quarter_year = $year AND quarter_season = $season;";
      $result2 = $db->query($sql2);
      $conflicts = "";
      foreach($result2 as $r2)
      {
        $conflicts.=$r2['day'].'|'.$r2['start'].'|'.$r2['end'].' '; 
      } //for each event of this TA
      array_push($row, $conflicts);
      array_push($row, "0");
      array_push($tacsv, $row);
      $prefs = get_prefs($sid, $year, $season, $dept, "scip");
      $prow = array($fullname);
      for($i=0; $i < count($prefs); $i++)
      {
        array_push($prow, ($prefs[$i]->value));
     //   array_push($prow, ($prefs[$i]->value." ".$prefs[$i]->section));
      }

      array_push($prefcsv, $prow);
    } //foreach ta
  }//try
  catch(PDOException $e)
  {echo $e->getMessage();}

  //Now we can save the csv files in the scip folder.
  $fp = fopen('scip/ta.csv', 'w');
  foreach ($tacsv as $fields) 
  {
    fputcsv2($fp, str_replace(array("(",")"), "-", $fields));
  }
  fclose($fp);
  $fp = fopen('scip/section.csv', 'w');
  foreach ($sectioncsv as $fields) 
  {
    fputcsv2($fp, $fields);
  }
  fclose($fp);
  $fp = fopen('scip/pref.csv', 'w');
  foreach (transpose($prefcsv) as $fields) 
  {
    fputcsv2($fp, str_replace(array("(",")"), "-", $fields));
  }
  $fp = fopen("csv/pref_$dept$year$season.csv", 'w');
  foreach (transpose($prefcsv) as $fields) 
  {
    fputcsv2($fp, str_replace(array("(",")"), "-", $fields));
  }
  fclose($fp);
}

function transpose($array) {
    array_unshift($array, null);
    return call_user_func_array('array_map', $array);
}

function fputcsv2($fp, $row)
{
  //row is an array of things that need to be added to the file fp.
  fputs($fp, implode($row, ',')."\n");
}

function new_login($sid, $password, $username)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //first we need to ensure the username is unique.
    $sql = "SELECT count(*) FROM login WHERE username = '$username';";
    $result = $db->query($sql)->fetch();
    if($result[0] > 0)
      return(array("error-message","That username is already in use. Please try another."));
    //next we need to ensure the password has at least one char
    if(!preg_match('/[A-Za-z]/', $password))
      return(array("error-message","Password must contain at least one letter."));
    //next we need to ensure the password has at least one number 
    if(!preg_match('/[0-9]/', $password))
      return(array("error-message","Password must contain at least one number."));
    //now we can add this username-password pair to the db.
    $exec = $db->prepare("INSERT INTO LOGIN(username, password, sid) VALUES(?,?,?);");
    $exec->execute(array($username, $password, $sid));
    return(array("success-message","Login added."));

  }//try
  catch(PDOException $e)
  {echo $e->getMessage();}
}
function reset_calendar()
{
  unset($_SESSION['section']);
  unset($_SESSION['course']);
  unset($_SESSION['dept']);
  //redirect so that we get the proper dept
  session_regenerate_id(true);
  session_write_close();
  header("Location:calendar.php?dept=".$_SESSION['tadept']);
}

function run_scip($year, $season, $dept, $sname, $filename, $phantomTA, $added)
{
/*
  error_reporting(E_ALL);
  ini_set('display_errors', TRUE);
  ini_set('display_startup_errors', TRUE);
*/
  if(!isset($db))
  {
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  try
  {
    if(!isset($phantomTA))
    {
      //find minimum number of phantoms necessary.
      $phantomTA = 0;
      $phantom_units = 4;
      //find total number of section units.
      $sql2 = "select sum(c.weight * c.units)
               FROM course c, section s
               WHERE c.department = s.department AND c.name = s.course
                 AND c.department = '$dept'
                 AND s.quarter_season = $season AND s.quarter_year = $year
                 AND s.status != 'deleted' AND c.status != 'deleted';";
    $result2 = $db->query($sql2)->fetch();
    $section_units = $result2[0];
    //find total number of TA units
    $sql2 = "SELECT sum(u.value)
             FROM units u, ta t
             WHERE u.sid = t.sid AND t.department = '$dept'
               AND u.year = $year AND u.season = $season;";
    $result2 = $db->query($sql2)->fetch();
    $ta_units = $result2[0];
    $p = ($section_units - $ta_units)/$phantom_units;
    if($p > 0) $phantomTA = $p ;
 //   return(array("error-message","You have $ta_units TA units and $section_units section units, so I think you need $phantomTA phantoms."));
    $added = 0;
    }
  }
  catch(PDOException $e) 
  {
    echo $e->getMessage();
  }
//we need to make a zpl file, then run it through SCIP, then parse that to get a csv.
  $cmd = "scip/chemfile scip/ta.csv scip/section.csv scip/pref.csv scip/input.zpl $phantomTA 3";
  exec($cmd, $output);

  $cmd = "scip/zimpl scip/input.zpl scip/chemobjective.zpl scip/constraints.zpl";
  exec($cmd, $output);
  $cmd = "scip/scipmip input.lp scip/scipmip.set > out.txt";
  exec($cmd, $output);
  $cmd = 'grep -F "x$" out.txt | wc -l';
  exec($cmd, $num);
  if($num[0] == "0")
  {
    //infeasible. We should end if we hit the time limit, or else add more phantoms.
    $max_added = 3;
    $timeout = 0;
    $cmd = 'grep -F "time limit reached" out.txt | wc -l';
    exec($cmd, $r);
    if($r[0] == "2") $timeout = 1;
    if($added < $max_added)
    {
      run_scip($year, $season, $dept, $sname, $filename, $phantomTA + 1, $added + 1);
    }
    else if ($timeout) //we added in max phantoms and we're still hitting time limit
    {
    return(array("error-message", "No matching available in this time limit."));
    } 
    else //give up and contact the master
      return(array("error-message", "Matching is infeasible. Please contact Sam Asher at srasher@ucdavis.edu for debugging."));
  } //infeasible
  $cmd = "scip/inparser input.tbl out.txt $filename.csv";
 // $cmd = "scip/a.out input.tbl out.txt 2>&1";
  exec($cmd, $output);
//  $cmd = "rm -f input.tbl input.lp Intermediate.txt test.csv";
//  exec($cmd, $output);
  
} //run_scip

function scip_csv_append($filename, $dept, $year, $season)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $fp = fopen("$filename.csv", "r");
  fgetcsv($fp);

  $count = 0;//for the header
  $first = 0;

  $locationsfile = fopen("location.csv","w");
  fwrite($locationsfile, "Location\n");
  $proffile = fopen("prof.csv","w");
  fwrite($proffile, "Professors\n");
  $timesfile = fopen("timesfile.csv","w");
  fwrite($timesfile, "Times\n");

  while(($row = fgetcsv($fp)) != FALSE)
  {
    $info = $row[1];
    $info2 = explode(" ", $info);
    $course = $info2[0];
    $section = $info2[1];

   $locationsfile = fopen("location.csv","a");


    //Get the number of discussions//
    $sql = 'SELECT count (*) 
            FROM event 
            WHERE section = "'.$section.'" AND course = "'.$course.'" 
             AND department = "'.$dept.'" AND quarter_year = '.$year.' 
             AND quarter_season = '.$season.' AND type = "discussion";';
    $result = $db->query($sql)->fetch();
    $num_disc = $result[0];


    $sql = 'SELECT location 
            FROM event 
            WHERE section = "'.$section.'" AND course = "'.$course.'" 
             AND department = "'.$dept.'" AND quarter_year = '.$year.' 
             AND quarter_season = '.$season.' AND type = "discussion";';
   $result = $db->query($sql);
   
   if($first == 1)
     fwrite($locationsfile, "\n");

   if($num_disc == 0)
   {
     $sql = 'SELECT location 
             FROM event 
             WHERE section = "'.$section.'" AND course = "'.$course.'" 
              AND department = "'.$dept.'" AND quarter_year = '.$year.' 
              AND quarter_season = '.$season.' AND type = "lecture";';
     $result = $db->query($sql);
     
     foreach($result as $entry)
       $location = $entry['location'];
     fwrite($locationsfile, $location);
   }
   if($num_disc == 2)//For Chem discussions
   {
     $gonethrough = 1;
     foreach($result as $entry)
     {
       $location = $entry['location'];

       if($gonethrough == 1)
         fwrite($locationsfile, $location);
       else
         fwrite($locationsfile, "/".$location);

       $gonethrough++;
     }
   }

   if($num_disc == 1)
   {
     foreach($result as $entry)
     {
        $location = $entry['location'];
         fwrite($locationsfile, $location); 
     }
   }
   
   $timesfile = fopen("timesfile.csv","a");

   $sql = 'SELECT start, end, day 
           FROM event 
           WHERE section = "'.$section.'" AND course = "'.$course.'" 
            AND department = "'.$dept.'" AND quarter_year = '.$year.' 
            AND quarter_season = '.$season.' AND type = "discussion";';

   $result = $db->query($sql);

   if($first == 1)
     fwrite($timesfile, "\n");

   if($num_disc == 0)
   {
     $sql = 'SELECT start, end, day 
             FROM event 
             WHERE section = "'.$section.'" AND course = "'.$course.'" 
              AND department = "'.$dept.'" AND quarter_year = '.$year.' 
              AND quarter_season = '.$season.' AND type = "lecture" 
             GROUP BY day;';
     $result = $db->query($sql);
     foreach($result as $entry)
     {
       $start = $entry['start'];
       $end = $entry['end'];
       $day.= $entry['day'];
       $sched = $start."-".$end."(".$day.")";
     }
     fwrite($timesfile, $sched);
   }

   if($num_disc == 2)
   {
     $gonethrough = 1;
     foreach($result as $entry)
     {
       $start = $entry['start'];
       $end = $entry['end'];
       $day = $entry['day'];
       $sched = $start."-".$end."(".$day.")";
       if($gonethrough == 1)
         fwrite($timesfile, $sched);
       else
         fwrite($timesfile, "/".$sched);
       $gonethrough++;
     }
   }
   if($num_disc == 1)
   {
     foreach($result as $entry)
     {
        $start = $entry['start'];
        $end = $entry['end'];
        $day = $entry['day'];
        $sched = $start."-".$end."(".$day.")";
        fwrite($timesfile, $sched);
     }
   }
   $proffile = fopen("prof.csv","a");

    $sql = 'SELECT professor_name
            FROM event e, section s
            WHERE s.name = "'.$section.'" and e.section = "'.$section.'"
	    AND s.department = "'.$dept.'" AND e.department = "'.$dept.'"
	    AND s.course = "'.$course.'" AND e.course = "'.$course.'"
	    AND s.quarter_year = '.$year.' AND e.quarter_year = '.$year.'
	    AND s.quarter_season = '.$season.' AND e.quarter_season = '.$season.'
	    AND e.start = '.$start.' AND e.end = '.$end.' 
            AND e.type = "discussion" AND e.location = "'.$location.'"
	    GROUP BY s.course';

  // print $sql."\n";

   $result = $db->query($sql);

   if($first == 1)
     fwrite($proffile, "\n");

   if($num_disc == 0)
   {
    $sql = 'SELECT professor_name
            FROM event e, section s
            WHERE s.name = "'.$section.'" and e.section = "'.$section.'"
            AND s.department = "'.$dept.'" AND e.department = "'.$dept.'"
            AND s.course = "'.$course.'" AND e.course = "'.$course.'"
            AND s.quarter_year = '.$year.' AND e.quarter_year = '.$year.'
            AND s.quarter_season = '.$season.' AND e.quarter_season = '.$season.'
            AND e.start = '.$start.' AND e.end = '.$end.'
            AND e.type = "lecture" AND e.location = "'.$location.'"
            GROUP BY s.course';

     $result = $db->query($sql);

     foreach($result as $entry)
       $professor = $entry['professor_name'];
     fwrite($proffile, $professor);
   }
   if($num_disc == 2)//For Chem discussions
   {
     $gonethrough = 1;
     foreach($result as $entry)
     {
       $professor = $entry['professor_name'];

       if($gonethrough == 1)
         fwrite($proffile, $professor);
       else
         fwrite($proffile, "/".$professor);

       $gonethrough++;
     }
   }
   if($num_disc == 1)
   {
     foreach($result as $entry)
     {
        $professor = $entry['professor_name'];
         fwrite($proffile, $professor);
     }
   }

   $first = 1;
   $count++;
   $sched = "N/A";
   $location = "N/A";
   $day = "";

   } //while
   
  //$cmd = "rm $filename.csv";
  //exec($cmd, $output);
  $cmd = "tr ',' ' ' < prof.csv > prof2.csv";
  exec($cmd, $output);

  $cmd = "paste -d , $filename.csv location.csv timesfile.csv prof2.csv  > intermediary.csv";
  exec($cmd, $output);
  $cmd = "sed 's/,//' intermediary.csv > $filename.csv";
  exec($cmd, $output);
  $cmd = "rm location.csv timesfile.csv prof.csv prof2.csv";
//  exec($cmd, $output);
}  //scip_csv_append

function scip_table($filename)
{
  $fp = fopen("$filename.csv", "r");
  print '<table id="sciptable" class="stafftable" border="1">
           <thead>
             <tr>
               <th>TAs</th>
               <th>Sections</th>
	       <th>Locations</th>
	       <th>Times</th>
	       <th>Professors</th>';
print'
             </tr>
           </thead>
           <tbody>';
  //get headers
  fgetcsv($fp);
  //expect data to only have TA name and section name.
  while(($row = fgetcsv($fp)) !== FALSE)  
    {
      print '<tr>';
      if(substr($row[0],0, 5) != "Danny")
        print '<td>'.$row[0].'</td>';
      else
        print '<td>Phantom'.(substr($row[0], 5, 8)).'</td>';
      print '<td>'.$row[1].'</td>';//Section Assigned
      print '<td>'.$row[2].'</td>';//Location	
      print '<td>'.$row[3].'</td>';//Times
      print '<td>'.$row[4].'</td>';//Professors
      print '</tr>';
    }
    print '</tbody></table>';
  fclose($fp);
} //scip_table

function csv_xls($filename)
{
  define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
  $fin = fopen("$filename.csv", "r");
  $xl = new PHPExcel();
  for($i=1;($row = fgetcsv($fin)) !== FALSE;$i++)
  {
    for($j=0;$j<count($row);$j++)
    {
      $data = "";
      if(substr($row[$j],0, 5) != "Danny")
        $data = $row[$j];
      else
        $data = 'Phantom'.(substr($row[$j], 5, 8));
      $xl->setActiveSheetIndex(0)->setCellValue(chr(ord('A') + $j).$i, $data);
    }
  }
  $objWriter = PHPExcel_IOFactory::createWriter($xl, 'Excel5');
  $objWriter->save("$filename.xls");
  fclose($fin);
}

function populate_tas($year, $season, $dept, $current_ta)
{
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT t.sid, t.name_first, t.name_last FROM ta t, units u
            WHERE u.year = $year AND u.season = $season AND u.sid = t.sid
              AND t.department = '$dept'
            ORDER BY t.name_last;";
    print '<option value="http://tamatch.math.ucdavis.edu/MathWeb/tacal.php">--Select a TA--</option>'; 
    try{
    $result = $db->query($sql);
    foreach($result as $ta)
    {
      if($ta['sid'] == $current_ta)
      print '<option selected="selected" value="'.$ta['sid'].'">'.$ta['name_first'].' '.$ta['name_last'].'</option>';
      else 
      {
        print '<option value="http://tamatch.math.ucdavis.edu/MathWeb/tacal.php?tacal='.$ta['sid'].'">'.$ta['name_first'].' '.$ta['name_last'].'</option>';
      }

    }
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}

}

function populate_tas_pref($year, $season, $dept, $current_ta)
{
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT t.sid, t.name_first, t.name_last FROM ta t, units u
            WHERE u.year = $year AND u.season = $season AND u.sid = t.sid
              AND t.department = '$dept'
            ORDER BY t.name_last;";
    print '<option value="http://tamatch.math.ucdavis.edu/MathWeb/tapref.php">--Select a TA--</option>'; 
    try{
    $result = $db->query($sql);
    foreach($result as $ta)
    {
      if($ta['sid'] == $current_ta)
      print '<option selected="selected" value="'.$ta['sid'].'">'.$ta['name_first'].' '.$ta['name_last'].'</option>';
      else 
      {
        print '<option value="http://tamatch.math.ucdavis.edu/MathWeb/tapref.php?tapref='.$ta['sid'].'">'.$ta['name_first'].' '.$ta['name_last'].'</option>';
      }

    }
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}

} //populate_tas_pref

function populate_profs($dept)
{
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT name_full FROM professor WHERE department = '$dept' ORDER BY name_full;";
    print '<option value="NULL">--Select a Professor--</option>'; 
    try
    {
      $result = $db->query($sql);
      foreach($result as $prof)
      {
        print '<option value="'.$prof['name_full'].'">'.$prof['name_full'].'</option>';

      }
    }
  catch(PDOException $e)
  {    echo $e->getMessage();}
}

function prof_conflict($sid, $prof, $year, $season, $dept)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //now we can add this ta-professor pair to the db.
    $exec = $db->prepare("INSERT INTO professor_conflict(professor_name, professor_dept, sid, quarter_year, quarter_season) VALUES(?,?,?,?,?);");
    $exec->execute(array($prof, $dept, $sid, $year, $season));
  }//try
  catch(PDOException $e)
  {echo $e->getMessage();}
}


function conflict_body($dept, $year, $season)
{
  print'
  <table class="gridtable">
    <thead>
      <tr>
        <td>TA</td>
        <td>Professor</td>
        <td>Remove</td>
      </tr>
    </thead>
  ';
  print '<tbody>';
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT p.professor_name, t.name_first, t.name_last, t.sid 
          FROM professor_conflict p, ta t
          WHERE p.professor_dept = '$dept' AND p.sid = t.sid
            AND p.quarter_year = $year AND p.quarter_season = $season;";
  try
  {
    $result = $db->query($sql);
    foreach($result as $r)
    {
      print '<tr>';
      print '<td>'.$r['name_first'].' '.$r['name_last'].'</td>';
      print '<td>'.$r['professor_name'].'</td>';
      print 
       '<td>
        <form action="conflicts.php" method="post">
        <input name="taprof" value="'.$r['sid'].'|'.$r['professor_name'].'" type="hidden" />
        <input style="width=100%;" type="submit" value="x" name="remove">
        </form>
        </td>
      </tr>';
    }
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}
  print '</tbody>';
}

function drop_conflict($sid, $prof, $dept, $year, $season)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //we will drop this ta-professor pair from the db.
    $exec = $db->prepare("DELETE FROM professor_conflict WHERE professor_name = ? AND sid = ? AND professor_dept = ? AND quarter_year = ? AND quarter_season = ?;");
    $exec->execute(array($prof, $sid, $dept, $year, $season));
  }//try
  catch(PDOException $e)
  {echo $e->getMessage();}

}

function force_match($dept, $year, $season, $sid, $course, $section)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    $error = "";
    $tunits = "";
    $sunits = "";
    $weight = "";
    //CHECKS BOY
    //First, make sure that the course has room for this TA and vice versa.
    $sql = "select c.weight, c.units, u.value
            from course c, ta t, units u
            where c.name = '$course' and c.department = '$dept' and t.sid = $sid
              and u.sid = t.sid and u.year = $year and u.season = $season;";
    $result = $db->query($sql);
    foreach($result as $r)
    {
      $tunits = $r['value'];
      $sunits = $r['units'];
      $weight = $r['weight'];
      //Check TA has room to teach this course
      $sql2 = "SELECT SUM(c.units)
              FROM course c, force_match f
              WHERE f.sid = $sid AND f.quarter_year = $year AND f.quarter_season = $season
                AND f.department = c.department and f.course = c.name
              ;";
      $result2 = $db->query($sql2)->fetch();
      if($tunits - $result2[0] < $sunits)
        $error = "This TA lacks the necessary units to teach this course.";
      //Check course has room for this TA
      if($r['weight'] * $r['units'] == 0)
        $error = "This course has no need for TAs.";
    }
    if($error) return($error);
    //Second check: Course not overassigned.
    $sql = "select count(*)
            from units u, force_match f
            where u.sid = f.sid and f.quarter_year = u.year and f.quarter_season = u.season
              AND u.year = $year AND u.season = $season
              AND f.course = '$course' AND f.section = '$section' AND f.department = '$dept'
              ;";
    $result = $db->query($sql)->fetch();
    if($weight <= $result[0]) //full up.
      $error = "This course is full.";
    //2.5 check: Same TA not assigned twice.
    $sql = "select count(*)
            from force_match
            where quarter_season = '$season' and quarter_year= '$year'
              and course = '$course' and section = '$section' and department = '$dept'
              and sid = $sid;";
    $result = $db->query($sql)->fetch();
    if($result[0] >= 1)
      $error = "This TA has already been assigned to this section."; 
    //Third check: Time conflict.
    $sql = "SELECT * FROM event
              WHERE section = '$section' AND course = '$course' AND department = '$dept' 
                AND quarter_year = $year AND quarter_season = $season
                AND type = 'discussion';";
      $events = $db->query($sql);
      foreach($events as $event)
      {
        //first get all user events of this quarter.
         $sql2 = "SELECT day, start, end
                  FROM calendar 
                  WHERE sid = $sid AND quarter_year = $year AND quarter_season = $season
                  UNION
                  SELECT e.day, e.start, e.end
                  FROM event e, force_match f
                  WHERE f.sid = $sid AND f.quarter_year = $year 
                    AND f.quarter_season = $season 
                    AND f.quarter_season = e.quarter_season 
                    AND f.quarter_year = e.quarter_year
                    AND f.department = e.department AND f.section = e.section
                    AND f.course = e.course AND e.type = 'discussion'
                  ;";
//puts($sql2);
         $uevents = $db->query($sql2);
         foreach($uevents as $uevent)
         {
           //check time conflict between $event and $uevent.
           if($event['day'] == $uevent['day'] && 
               (($event['end']>$uevent['start'] && $uevent['start']>=$event['start']) ||
                ($uevent['end']>$event['start'] && $event['start']>=$uevent['start']) ||
                ($uevent['end'] == $event['start']) || ($event['end'] == $uevent['start'])))
           {
             $error = "This section conflicts with TA schedule. ";
           }
         } //check against all user events
       } //loop through all events of section
    if($error) return($error);
    //now we can add this force match record to the db.
    $exec = $db->prepare("INSERT INTO force_match(sid, department, course, section, quarter_year, quarter_season) VALUES(?,?,?,?,?,?);");
    $exec->execute(array($sid, $dept, $course, $section, $year, $season));
  }//try
  catch(PDOException $e)
  {echo $e->getMessage();}
}

function match_body($dept, $year, $season)
{
  print'
  <table class="gridtable">    
   <thead>
      <tr>
        <td>Section</td>
        <td>TA</td>
        <td>Remove</td>
      </tr>
    </thead>
  <tbody>';
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT f.course, f.section, t.name_first, t.name_last, t.sid 
          FROM force_match f, ta t
          WHERE f.department = '$dept' AND f.sid = t.sid
            AND f.quarter_year = $year AND f.quarter_season = $season;";
  try
  {
    $result = $db->query($sql);
    foreach($result as $r)
    {
      print '<tr>';
      print '<td>'.$r['course'].' '.$r['section'].'</td>';
      print '<td>'.$r['name_first'].' '.$r['name_last'].'</td>';
      print 
       '<td>
        <form action="conflicts.php" method="post">
        <input name="tamatch" value="'.$r['sid'].'|'.$r['course'].'|'.$r['section'].'" type="hidden" />
        <input style="width=100%;" type="submit" value="x" name="mremove">
        </form>
        </td>
      </tr>';
    }
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}
  print '</tbody>';
}

function drop_match($sid, $course, $section, $dept, $year, $season)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //we will drop this forced match from the db.
    $exec = $db->prepare("DELETE FROM force_match WHERE sid = ? AND department = ? AND quarter_year = ? AND quarter_season = ? AND course = ? AND section = ?;");
    $exec->execute(array($sid, $dept, $year, $season, $course, $section));
  }//try
  catch(PDOException $e)
  {echo $e->getMessage();}

}

function make_constraints($year, $season, $dept)
{
  if(!($fp = fopen('scip/constraints.zpl', 'w'))) return;
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //first find all forced matchings for this quarter and department.
    $sql = "SELECT f.course, f.section, t.name_first, t.name_last, t.sid 
          FROM force_match f, ta t
          WHERE f.department = '$dept' AND f.sid = t.sid
            AND f.quarter_year = $year AND f.quarter_season = $season;";
    $result = $db->query($sql);
    foreach($result as $r)
    {
      //write the proper constraint to scip/constraints.zpl.
      fprintf($fp, "\nsubto %s_%s_%s_%s:\nx[\"%s %s\", \"%s %s\"] == 1;\n",
               scip_clean($r['name_first']), scip_clean($r['name_last']), 
               $r['course'], $r['section'],
               scip_clean($r['name_first']), scip_clean($r['name_last']), 
               $r['course'], $r['section']
             );
    }
  }//try
  catch(PDOException $e)
  {echo $e->getMessage();}
  
  fclose($fp);
}

function scip_clean($s)
{
  return(str_replace(array('-','(',')',' ',"'"), '_', $s));
}


function sql_clean($s)
{
  return(str_replace("'", '`', $s));
}

function new_staff($dept)
{
  //this is a new dept and we want a new default login for it.
  $username = 'staff_'.$dept;
  //set a random password.
  $password = generateRandomString();
if(!isset($db))
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
  try
  {
    //we will drop this forced match from the db.
    $exec = $db->prepare("INSERT INTO login_staff(username, password, department) VALUES(?,?,?);");
    $exec->execute(array($username,$password,$dept));
  }//try
  catch(PDOException $e)
  {echo $e->getMessage();}
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function course_table($dept, $year, $season)
{
  print'
  <table class="mancourse">
    <thead>
      <tr>
        <td>Department</td>
        <td>Course</td>
        <td>TA Requirements</td>
        <td>Remove/Add</td>
        <td>View Sections</td>
      </tr>
    </thead>
  ';
  print '<tbody>';
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //get all courses WITH A SECTION offered this quarter.
  $sql = "SELECT c.name as name, c.units as units, c.weight as weight, c.status as status
          FROM course c, section s
          WHERE c.department = s.department AND c.name = s.course
            AND s.quarter_year = '$year' AND s.quarter_season = '$season'
            AND c.department = '$dept'
          UNION
          SELECT name, units, weight, status
          FROM course
          WHERE status != 'crawled' AND department = '$dept'
          GROUP BY department, name
          ;";
  try
  {
    $result = $db->query($sql);
    foreach($result as $r)
    {
      $course = $r['name'];
      $units = $r['units'];
      $weight = $r['weight'];
      $status = $r['status'];
      print '<tr class="'.$status.'">';
      print '<td>'.$dept.'</td>';
      print '<td>'.$course.'</td>
        <form action="mancourse.php" method="post">
          <td> Each section needs <b>
            <input name="weight" id="weight" type="number" value="'.$weight.'"
               min="0" max="10" step="1"></b> TAs, 
            each with <b>
            <input name="units" id="units" type="number" value="'.$units.'"
               min="0" max="10" step="1"></b> units. 
          <input name="course" value="'.$course.'" type="hidden" />
          <input style="width=100%;" type="submit" value="Commit" name="modify">
        </td>
          </form>
        <td>
        <form action="mancourse.php" method="post">
        <input name="course" value="'.$course.'" type="hidden" />';
        if($status == 'deleted')
          print '<input style="width=100%;" type="submit" value="Add" name="add">';
        else
          print '<input style="width=100%;" type="submit" value="Remove" name="remove">';
      print '
        </form>
        </td>
        <td>
        <form action="mansection.php" method="post">
        <input name="course" value="'.$course.'" type="hidden" />
        <input style="width=100%;" type="submit" value="View Sections" name="sections">
        </form>
        </td>
      </tr>';
    }
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}
  print '</tbody>';
}

function set_course($value, $course, $dept)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //set the status of this course to the value specified
    $exec = $db->prepare("UPDATE course SET status = ? WHERE name = ? AND department = ?;");
    $exec->execute(array($value, $course, $dept));
  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}
  
} //set_course

function mod_course($weight, $units, $course, $dept)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //set the weight, units of this course
    $exec = $db->prepare("UPDATE course SET weight = ?, units = ?
                          WHERE name = ? AND department = ?;");
    $exec->execute(array($weight, $units, $course, $dept));
  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}
  
} //mod_course

function add_course($course, $dept)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //add this course
    $exec = $db->prepare("INSERT INTO course(name, units, weight, department, level, status)
                          VALUES(?,?,?,?,?,?);");
    $exec->execute(array($course, "2", "1", $dept, $course[0], "added"));
  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}
  
} //mod_course


function section_table2($dept, $year, $season, $course)
{/*
  print'
  <table class="gridtable">
    <thead>
      <tr>
        <td>Section</td>
        <td>Lecture Times</td>
        <td>Discussion Times</td>
        <td>Remove/Add</td>
      </tr>
    </thead>
  ';*/
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //get all sections for this course this quarter.
  $sql = "SELECT name, status, crn
          FROM section
          WHERE course = '$course' AND department = '$dept'
            AND quarter_year = $year AND quarter_season = $season; 
          ;";
  try
  {
    $sections = $db->query($sql);
    foreach($sections as $s)
    {
      $section = $s['name'];
      $status = $s['status'];
      $crn = $s['crn'];
      print '<tr class="'.$status.'">';
      print '<td>'.$crn.'</td>';
      print '<td>'.$section.'</td>';
      //get lecture days, times.
      $sql2 = "SELECT day, start, end 
               FROM event
               WHERE quarter_year = $year AND quarter_season = $season
                 AND department = '$dept' AND course = '$course' AND section = '$section'
                 AND type = 'lecture';";
      $lectures = $db->query($sql2);
      foreach($lectures as $l)
      {
        $start = $l['start'];
        $end = $l['end'];
        $days .= $l['day'];

      }
      print "<td>$days $start-$end</td>";
      $start = "";
      $end = "";
      $days = "";
      $sql2 = "SELECT day, start, end 
               FROM event
               WHERE quarter_year = $year AND quarter_season = $season
                 AND department = '$dept' AND course = '$course' AND section = '$section'
                 AND type = 'discussion';";
      $discs = $db->query($sql2);
      print '<td>';
      $i = 0;
      foreach($discs as $d)
      {
        if($i > 0) print ', ';
        $start = $d['start'];
        $end = $d['end'];
        $day = $d['day'];
        $i++;
      print "$day $start-$end";
      }
      print "</td>";
      print '
        <td>
        <form action="mansection.php" method="post">
        <input name="section" value="'.$section.'" type="hidden" />';
        if($status == 'deleted')
          print '<input style="width=100%;" type="submit" value="Add" name="add">';
        else if ($status == 'added' || $status == 'crawled')
          print '<input style="width=100%;" type="submit" value="Remove" name="remove">';
        else if ($status == 'staff')
          print '<input style="width=100%;" type="submit" value="Delete" name="delete">';
      print '
        </form>
        </td>
      </tr>';
    }
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}
}

function set_section($value, $course, $dept, $section, $year, $season)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //set the status of this course to the value specified
    $exec = $db->prepare("UPDATE section SET status = ? WHERE name = ? AND course = ? AND department = ? AND quarter_year = ? AND quarter_season = ?;");
    $exec->execute(array($value, $section, $course, $dept, $year, $season));
  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}
  
} //set_section

function delete_section($course, $dept, $section, $year, $season)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //set the status of this course to the value specified
    $exec = $db->prepare("DELETE FROM section WHERE name = ? AND course = ? AND department = ? AND quarter_year = ? AND quarter_season = ?;");
    $exec->execute(array($section, $course, $dept, $year, $season));
    $exec = $db->prepare("DELETE FROM event WHERE section = ? AND course = ? AND department = ? AND quarter_year = ? AND quarter_season = ?;");
    $exec->execute(array($section, $course, $dept, $year, $season));
  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}
} //delete_section

function new_section($crn, $dept, $course, $section, $year, $season, $ldays, $lstart, $lend, $dday, $dstart, $dend, $dday2, $dstart2, $dend2)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    //add the new section
    $exec = $db->prepare("INSERT INTO section(crn, name, course, department, quarter_year, quarter_season, supersection, status) VALUES(?,?,?,?,?,?,?,?);");
    $exec->execute(array($crn,$section, $course, $dept, $year, $season, $section[0],'staff'));
    if(isset($ldays) and isset($lstart) and isset($lend))
    {
      //insert lecture.
      $x = explode(':', $lstart);
      $start = $x[0].$x[1];
      $x = explode(':', $lend);
      $end = $x[0].$x[1];
      foreach($ldays as $d)
      {
        $exec = $db->prepare("INSERT INTO event(department, section, course, quarter_year, quarter_season, day, start, end, type) VALUES(?,?,?,?,?,?,?,?,?);");
        $exec->execute(array($dept, $section, $course, $year, $season, $d, $start, $end, 'lecture'));
      } //insert lecture event
    } //if we have lectures, insert them.
    if(isset($dday) and isset($dstart) and isset($dend))
    {
      //insert lecture.
      $x = explode(':', $dstart);
      $start = $x[0].$x[1];
      $x = explode(':', $dend);
      $end = $x[0].$x[1];
      $exec = $db->prepare("INSERT INTO event(department, section, course, quarter_year, quarter_season, day, start, end, type) VALUES(?,?,?,?,?,?,?,?,?);");
      $exec->execute(array($dept, $section, $course, $year, $season, $dday, $start, $end, 'discussion'));
    } //if we have discussion, insert it.
    if(isset($dday2) and isset($dstart2) and isset($dend2))
    {
      //insert lecture.
      $x = explode(':', $dstart2);
      $start = $x[0].$x[1];
      $x = explode(':', $dend2);
      $end = $x[0].$x[1];
      $exec = $db->prepare("INSERT INTO event(department, section, course, quarter_year, quarter_season, day, start, end, type) VALUES(?,?,?,?,?,?,?,?,?);");
      $exec->execute(array($dept, $section, $course, $year, $season, $dday2, $start, $end, 'discussion'));
    } //if we have lab, insert it.
  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}
} //new_section

function custom_section($sid, $dept, $course, $section, $year, $season, $ldays, $lstart, $lend)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    if(isset($sid) and isset($ldays) and isset($lstart) and isset($lend))
    {
      $x = explode(':', $lstart);
      $start = $x[0].$x[1];
      $x = explode(':', $lend);
      $end = $x[0].$x[1];
      //check for too early/late.
      if($start < 730)
        return("Please don't enter events before 7:30 AM.");
      if($end > 2200)
        return("Please don't enter events after 10:00 PM.");
      //next we need to round to the nearest 10 minute interval.
      $start = round($start, -1);
      $end = round($end, -1);
      //check for conflicts.
      foreach($ldays as $d)
      {
        //first get all user events of this quarter.
        $sql2 = "SELECT * FROM calendar WHERE sid = $sid 
          AND quarter_year = $year AND quarter_season = $season;";
        $uevents = $db->query($sql2);
        foreach($uevents as $uevent)
        {
          //check time conflict between $event and $uevent.
          if($d == $uevent['day'] &&
            (($end>$uevent['start'] && $uevent['start']>=$start) ||
            ($uevent['end']>$start && $start>=$uevent['start'])))
          {
            $error = "This section conflicts with ".$uevent['department']." ".$uevent['course']." ".$uevent['section'].".";
            return($error);
          }
        } //for each user event

        $exec = $db->prepare("INSERT INTO calendar(sid, department, section, course, quarter_year, quarter_season, day, start, end, type) VALUES(?,?,?,?,?,?,?,?,?,?);");
        $exec->execute(array($sid,$dept, $section, $course, $year, $season, $d, $start, $end, 'custom'));
      } //insert event
    } //if we have events, insert them.
  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}
} //custom_section

function populate_custom($sid, $year, $season)
{
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM calendar WHERE sid = $sid AND quarter_year = $year AND quarter_season = $season AND type = 'custom' GROUP BY department, course, section;"; 
    try
    {
      $sections = $db->query($sql);
      foreach($sections as $section)
      {
        print '<option value="'.$section['section'].'">'.$section['section'].'</option>';
      }
    }
  catch(PDOException $e)
  {    echo $e->getMessage();}

} //populate_custom

function set_limit($limit, $filename)
{
  if(!($fp = fopen($filename, 'w'))) return;
  //remember limit is in minutes
  fprintf($fp, "limits/time = %d", ($limit - 2) * 60);
} //set_limit

function insert_deadline($dept, $year, $season, $y, $m, $d)
{
  //Want to insert the date given into our deadline table.
  //But first need to delete current deadline
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
        $exec = $db->prepare("DELETE FROM deadline WHERE department = '$dept' AND  quarter_year = $year AND quarter_season = $season;");
        $exec->execute();
        $exec = $db->prepare("INSERT into deadline(department, quarter_year, quarter_season, year, month, day) values (?,?,?,?,?,?);");
        $exec->execute(array($dept, $year, $season, $y, $m, $d));
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}
  
} //insert_deadline

function get_deadline($dept, $year, $season)
{
  //return the deadline for this department, year, and season as
  // an array: year, month, day.
    $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM deadline WHERE  quarter_year = $year AND quarter_season = $season AND department = '$dept';"; 
    try
    {
      $sections = $db->query($sql);
      foreach($sections as $section)
      {
        $d[0] = $section['year'];
        $d[1] = $section['month'];
        $d[2] = $section['day'];
      }
      return($d);
    }
  catch(PDOException $e)
  {    echo $e->getMessage();}
} //get_deadline

function check_deadline($dept, $year, $season)
{
  //returns 1 if the deadline has passed, 0 else.
  $d1 = get_deadline($dept, $year, $season);
  //check against current date 
  if(!isset($d1)) return 0;
  $d2 = getdate();
  $d1[2] = str_pad ( $d1[2] , 2 , "0", STR_PAD_LEFT );
  $d2["mday"] = str_pad ( $d2["mday"] , 2 , "0", STR_PAD_LEFT );
  $dead = $d1[0].$d1[1].$d1[2];
  $current = $d2["year"].$d2["mon"].$d2["mday"];
  return( $dead < $current);
} //check_deadline

function reset_ta($dept, $sid)
{
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //first see if TA is in the database under your department
  $sql = "SELECT count(*) FROM ta WHERE sid = $sid AND department = '$dept';"; 
  try
  {
    $result = $db->query($sql)->fetch();
    if($result[0] == 0)
    {
      //This TA is not there.
      return(array("error-message","There is no TA with SID $sid in your department."));
    }
    //Remove the TA
    $exec = $db->prepare("DELETE FROM login WHERE sid = ?;");
    $exec->execute(array($sid));
    return(array("success-message","TA $sid has been reset."));
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}

} //reset_ta

function force_checks($dept, $year, $season)
{
  //something important just happened, and we want to make the constraints are still valid.
  //the plan: take all force matches, drop them, and re-add them.
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //first see if TA is in the database under your department
  $sql = "SELECT * FROM force_match  WHERE department = '$dept' AND quarter_year = $year
                                      AND quarter_season = $season;"; 
  $matches = array();
  try
  {
    $result = $db->query($sql);
    foreach($result as $r)
    {
      array_push($matches, $r);
    }
  }
  catch(PDOException $e)
  {    echo $e->getMessage();}
  foreach($matches as $r)
  {
    //drop and add.
    drop_match($r['sid'], $r[course], $r[section], $r[department], $r[quarter_year], $r[quarter_season]);
    force_match($r[department], $r[quarter_year], $r[quarter_season], $r['sid'], $r[course], $r[section]);
  } 
  
} //force_checks

function noresponse($dept, $year, $season)
{
  //return an array of (the full names of) all TAs who did NOT submit prefs this quarter.
  $tas = array();
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "select * from ta where department = '$dept' and sid not in (select sid from calendar where quarter_year = $year and quarter_season = $season) and sid not in(select sid from rtod) and sid not in (select sid from rcourse);";
  try
  {
    $result = $db->query($sql);
    foreach($result as $r)
    {
      array_push($tas, $r[name_first].' '.$r[name_last]);
    }
  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}
  return($tas);
} //noresponse

function reset_pref($dept)
{
  //deletes all course and time preferences (ie all records for this dept in rcourse and rtod)
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    $exec = $db->prepare("DELETE FROM rcourse WHERE sid in (select sid from ta where department = ?);");
    $exec->execute(array($dept));
    $exec = $db->prepare("DELETE FROM rtod WHERE sid in (select sid from ta where department = ?);");
    $exec->execute(array($dept));
  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}
  
} //reset_pref

function sql_section($dept, $year, $season)
{
    //get all sections of this quarter, department
    $sql = "select s.course, s.name, s.department, s.supersection, c.units, c.weight
            from section s, course c
            where s.department = c.department and c.name = s.course
              and c.department = '$dept' 
              and s.quarter_year = $year and s.quarter_season = $season
              and c.status != 'deleted' and s.status != 'deleted'
            GROUP BY s.course, s.name, s.department
            ORDER BY c.level ASC, s.course ASC;";
  return($sql);
}

function count_sections($dept, $year, $season)
{
    //get all sections of this quarter, department
    $sql = "select count(*)
            from section s, course c
            where s.department = c.department and c.name = s.course
              and c.department = '$dept' 
              and s.quarter_year = $year and s.quarter_season = $season
              and c.status != 'deleted' and s.status != 'deleted'
            ;";
  return($sql);
}

function reset_pref_TA($ta)
{
  //deletes all course and time preferences (ie all records for this dept in rcourse and rtod)
  $db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  try
  {
    $exec = $db->prepare("DELETE FROM rcourse WHERE sid = ?;");
    $exec->execute(array($ta));
    $exec = $db->prepare("DELETE FROM rtod WHERE sid = ?;");
    $exec->execute(array($ta));
  } //try
  catch(PDOException $e)
  {    echo $e->getMessage();}

} //reset_pref



?>
