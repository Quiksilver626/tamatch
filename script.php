<?php
require('ExcelPHP/Excel/reader.php');
require('ExcelPHP/Excel/Writer.php');
require('Classes/PHPExcel.php');
require('values.php');
require('functions.php');
/*this script will be run EVERY DAY. It expects the existence of 
    ../final/section_data_final.txt
  which should have the headers
    CRNs/Times/Department/Course/Section/Professors
  and be separated by / (not commas.)
  A sample of this file is as follows:

    32396/4:10-6:00PM,MW/ARE/018/MDSCC180/001/Maxey,J/MW 16-18
    32479/6:10-7:00PM,M/ARE/100A/WICKSN1020/A01/Marder,J/M 18-19
    32479/10:00-10:50AM,MWF/ARE/100A/CHEM179/A01/Marder,J/MWF 10-11
    32480/7:10-8:00PM,M/ARE/100A/WICKSN1020/A02/Marder,J/M 19-20
    32480/10:00-10:50AM,MWF/ARE/100A/CHEM179/A02/Marder,J/MWF 10-11
    32481/5:10-6:00PM,R/ARE/100A/WICKSN1038/A03/Marder,J/R 17-18

  Our goal is to input new depts and courses and sections, and update existing section data.
*/

//Our first goal is to get the current quarter (year, season) from qy.txt.
//  It takes form year|season_num.
$fp = fopen("../final/qy.txt", 'r');
$line = fgets($fp);
$l = explode("|", $line);
$year = $l[0];
$season = $l[1];
fclose($fp);

//Now time to read the file.
//ASSUMPTION: If it only happens one day a week, it is a discussion.
// This means we count labs as discussions.

//first get headers out of the way
$fp = fopen("../final/section_data_final.txt", 'r');
fgetcsv($fp);

$db = new PDO(DB_PATH, DB_LOGIN, DB_PW);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try
{
  //first get rid of all sections, events for this quarter.
/*
  $exec = $db->prepare("DELETE FROM section 
                        WHERE quarter_year = $year AND quarter_season = $season;
                       ");
  $exec->execute();
*/
  $exec = $db->prepare("DELETE FROM event
                        WHERE quarter_year = $year AND quarter_season = $season;
                       ");
  $exec->execute();
  
  while(($row = fgetcsv($fp, 9999, '/')) !== FALSE)
  {
    $crn = $row[0];
    $times = $row[1];
    $dept = $row[2];
    $course = $row[3];
    $location = $row[4];
    $section = $row[5];
    $prof = $row[6];
    $vtime = $row[7];
    //first see whether we have a new department.
    $sql = "SELECT count(*) FROM department WHERE code = '$dept';";
    $result = $db->query($sql)->fetch();
    if($result[0] == 0)
    {
      //New department! Add to dept table and create new staff login.
      $exec = $db->prepare("INSERT INTO department(code) VALUES(?);");
      $exec->execute(array($dept));
      new_staff($dept);
    } //new department
    //see whether we have a new course.
    $sql = "SELECT count(*) FROM course WHERE department = '$dept' AND name = '$course';";
    $result = $db->query($sql)->fetch();
    if($result[0] == 0)
    {
      //Add course to DB
      //Default: Every course is worth 2 units and weighted 1.
      $exec = 
        $db->prepare("INSERT INTO course(name, units, weight, department, level, status)
                            VALUES(?,?,?,?,?,?);");
      $exec->execute(array($course, "2", "1", $dept, $course[0],"crawled"));
    } //new course
    //see whether we have a new professor.
    $sql = "SELECT count(*) FROM professor 
            WHERE department = '$dept' AND name_full = '".sql_clean($prof)."';";
    //echo $sql;
    $result = $db->query($sql)->fetch();
    if($result[0] == 0)
    {
      //Add prof to DB
      $exec = $db->prepare("INSERT INTO professor(name_full, department)
                            VALUES(?,?);");
      if($prof!="")
        $exec->execute(array(sql_clean($prof), $dept));
    } //new course
    //Now insert new section.
    $sql = "SELECT count(*) FROM section
            WHERE department = '$dept' AND course = '$course' AND name = '$section'
              AND quarter_year = $year AND quarter_season = $season;";
    $result = $db->query($sql)->fetch();
    if($result[0] == 0)
    {
      $exec = $db->prepare("INSERT INTO section(course, department, professor_name, professor_dept, quarter_year, quarter_season, crn, name, times, vtime, location, supersection, status) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?);");
      $exec->execute(array($course, $dept, $prof, $dept, $year, $season, $crn, $section, $times, $vtime, $location, $section[0], "crawled"));
    } //if section is new
    else //need to update section
    {
      $exec = $db->prepare("
        UPDATE section SET professor_name = ?, crn = ?, times = ?, vtime = ?, location = ?
        WHERE department = '$dept' AND course = '$course' AND name = '$section'
          AND quarter_year = $year AND quarter_season = $season;
      ");
      $exec->execute(array($prof, $crn, $times, $vtime, $location, ));
    } //section is not new
      //Next add corresponding event(s). This is all dependent on $times.
      if(substr($times, 0, 3) != "TBA")
      {
        $t = explode(",",$times);
        $days = $t[1];
        if(strlen($days)==1 && $course != "022AL" || strlen($days)==1 && $course != "219L")
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
//        echo "$dept $course $section $days $start $end $ampm\n";
       //input events
       for($i=0; $i<strlen($days);$i++)
       {
         //check duplicates becuase registrar SUUUCKS
         $sql2 = "SELECT count(*) FROM event 
           WHERE section = '$section' AND course = '$course' AND department = '$dept'
             AND quarter_year = $year AND quarter_season = $season AND start = $start
             AND day = '".$days[$i]."'
         ;";
//puts($sql2);
         $result2 = $db->query($sql2)->fetch();
         if($result2[0] == 0)
         {
           $exec = $db->prepare("INSERT INTO event(section, course, department, type, day, start, end, quarter_year, quarter_season, location) VALUES(?,?,?,?,?,?,?,?,?,?);");
           $exec->execute(array($section, $course, $dept, $type, $days[$i], $start, $end, $year, $season, $location));
         } //only insert if no dupes
       } //for each day
     } //we have actual times
  } //while still lines
}//try
catch(PDOException $e)
{echo $e->getMessage();}

fclose($fp);
?>
