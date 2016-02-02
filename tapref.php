<?php
require('values.php');
require('functions.php');
session_start();

if(!isset($_SESSION['dept']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:loginstaff.php");
}
if(!isset($_SESSION['name']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:loginstaff.php");
}
if(!isset($_SESSION['year']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:quarterstaff.php");
}
if(isset($_GET['tapref']))
{
  $_SESSION['ta_id'] = $_GET['tapref'];
}
?>
  <!DOCTYPE html>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
        <link href="http://johnny.github.io/jquery-sortable/css/vendor.css" rel="stylesheet">
        <link href="http://johnny.github.io/jquery-sortable/css/application.css" rel="stylesheet">
        <link href="jQuery%20Sortable_files/vendor.css" rel="stylesheet">
        <link href="jQuery%20Sortable_files/application.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
        <script src="./jQuery Sortable_files/application.js"></script>       
<!-- Site Header Content //-->
<br>

<?php staffheader($_SESSION['name'],"tapref.php", $_SESSION['year'], $_SESSION['season_name'], $_SESSION['season']); ?>
</head>
<body>
<br><br>
  <legend><p class="shadow40" style="margin-left:2%">Select TA :
  <select id="tapref" name="tapref" onchange="redirectMe(this);">
    <?php populate_tas_pref($_SESSION['year'], $_SESSION['season'], $_SESSION['dept'], $_GET['tapref']); ?>
  </select>
</p></legend>

            <div style="float:left;width:24%">
              <h4>List of Courses <!--<i class="icon-info-sign" data-toggle="tooltip" data-title="Drag any of the following courses into the black box of preferred courses or disliked courses" id='example'></i>--></h4>
              <div style="height:250px;line-height:3em;overflow:auto;padding:5px;">
              <ol class="limited_drop_targets vertical">
<?php
  populate_neutral_courses($_SESSION['ta_id'], $_SESSION['dept'], $_SESSION['season'], $_SESSION['year']);
?>
              </ol>  
            </div>
            </div>
			
			
            <div  style="float:left;width:24%;margin-left:1%;" id="highlight">
				<ol class="limited_drop_targets vertical" id="highlight"><br>
			<h4>Courses you prefer to teach<br>(starting with most preferred)</h4>
<?php
  populate_liked_courses($_SESSION['ta_id'], $_SESSION['dept'], $_SESSION['season'], $_SESSION['year']);
?>
				</ol> <br><br><br>
				<ol style="margin-bottom: 10px" class="limited_drop_targets vertical" id="highlight">
				  <h4>Courses you prefer not to teach<br>(starting with least preferred)</h4>
<?php
  populate_disliked_courses($_SESSION['ta_id'], $_SESSION['dept'], $_SESSION['season'], $_SESSION['year']);
?>
				</ol> <br><br><br>
            </div>
	

	        <div  style="float:left;width:25%;margin-left:1%;" id="highlight">
				<ol class="simple_with_drop vertical" id="highlight"><br>
					<h4>Times you prefer to teach<br>(starting with most preferred)</h4>
<?php
  populate_liked_times($_SESSION['ta_id']);
?>
				</ol> <br><br><br>
				<ol class="simple_with_drop vertical" id="highlight">
				  <h4>Times you prefer not to teach<br>(starting with least preferred)</h4>
<?php
  populate_disliked_times($_SESSION['ta_id']);
?>
				</ol><br><br><br>
            </div>


			<div  style="float:left;width:25%">
              <h4>List of Times	<!--<i class="icon-info-sign" data-toggle="tooltip" data-title="Drag any of the following times into the black box of preferred times or disliked times" id='example'></i>--></h4>
              <div style="height:250px;line-height:3em;overflow:auto;padding:5px;">
              <ol class="simple_with_drop vertical">
<?php
  populate_neutral_times($_SESSION['ta_id']);
?>
              </ol>			  
</div>
			</div>

		<br>	
		<br>	
		<HR style="visibility: hidden" WIDTH="100%" SIZE="3"> 
		<HR WIDTH="100%" SIZE="3"> 
<!--
			<p class="pos_right">Do you have an agreement or a conflict with any professors? 
			<a data-target="#myModal" role="button" class="btn" data-toggle="modal" style="margin: 20px">Yes</a></p>
-->
			<div class="modal fade hide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Agreements and Conflicts</h3>
			  </div>
			  <div class="modal-body">
			  <th> Professor you have a prior agreement with: </th>
				  <select>
                                    <?php populate_professors(); ?>
				  </select>
			  </div>
			  <div class="modal-body">
			  <th> Professor you have a conflict with: </th>
				  <select>
                                    <?php populate_professors(); ?>
				  </select>
			  </div>
			  <div class="modal-footer">
				<button class="btn btn-primary">Save changes</button>
			  </div>
			</div>
                      <form name="prefs" id="prefs" style="clear:left;" action="MathCode.php" method="post">
<br><br>
			<p class="pos_right">Which of the following best describes how you feel about teaching sections in the same course?  
			<!--<i class="icon-info-sign" data-toggle="tooltip" data-title="The term, 'block' is used to denote a group of sections that belong to the same course"></i>--><br>
			<select disabled id="block" name="block">
			  <option value="0" <?php  print_pref_value("block", $_SESSION['ta_id'], "0") ?>>I am indifferent about whether my sections are of the same course or of different courses</option>
			  <option value="1" <?php  print_pref_value("block", $_SESSION['ta_id'], "1") ?>>I prefer teaching multiple sections of the same course</option>
			  <option value="-1" <?php  print_pref_value("block", $_SESSION['ta_id'], "-1") ?>>I would rather teach multiple sections of different courses</option>
			</select> </p>
		
			<p class="pos_right" style="display:none">Which of the following best describes how you feel about back-to-back classes?<br>
			<select name="btb" id="btb" style="display:none">
			  <option value="0" <?php  print_pref_value("back_to_back", $_SESSION['ta_id'], "0") ?>>I am indifferent about whether or not my classes are back-to-back</option>
			  <option value="1" <?php  print_pref_value("back_to_back", $_SESSION['ta_id'], "1") ?>>I like my classes back-to-back</option>
			  <option value="-1" <?php  print_pref_value("back_to_back", $_SESSION['ta_id'], "-1") ?>>I don't like my classes back-to-back</option>
			</select> </p>
	
   			<p class="pos_right">Which of the following best describes how you feel about teaching sections on the same day?<br>
			<select disabled name="sameday" id="sameday" >
			  <option value="0" <?php  print_pref_value("same_day",$_SESSION['ta_id'], "0") ?>>I am indifferent as to whether or not my TA assignments are on the same day</option>
			  <option value="1" <?php  print_pref_value("same_day",$_SESSION['ta_id'], "1") ?>>I like my TA assignments on the same day</option>
			  <option value="-1" <?php  print_pref_value("same_day",$_SESSION['ta_id'], "-1") ?>>I don't like my TA assignments on the same day</option>
			</select></p>
			
			<p class="pos_right">Which of the following best describes how you feel about your course preferences versus your time preferences?<br> 
			<select disabled name="ct" id="ct" >
			  <option value="0"<?php  print_pref_value("courses_vs_times",$_SESSION['ta_id'], "0") ?>>I am indifferent (I don't value courses over times or vice versa)</option>
			  <option value="2"<?php  print_pref_value("courses_vs_times",$_SESSION['ta_id'], "2") ?>>I only care about courses (times will not be considered) </option>
			  <option value="1"<?php  print_pref_value("courses_vs_times",$_SESSION['ta_id'], "1") ?>>I care about courses more than times (courses will be considered over times)</option>
			  <option value="-1"<?php  print_pref_value("courses_vs_times",$_SESSION['ta_id'], "-1") ?>>I care about times more than courses (times will be considered over courses)</option>
			  <option value="-2"<?php  print_pref_value("courses_vs_times",$_SESSION['ta_id'], "-2") ?>>I only care about times (courses will not be considered) </option>
			</select></p>
			
                <input id="serial1" name="serial1" type="hidden" />
                <input id="serial2" name="serial2" type="hidden" />


	</form>

		
                <div id="serialize_output"></div>
                <div id="serialize_output2"></div>

		<script src="js/serialize.js"></script>
	        <script>
		/*
                  $(document).ready(function() {
                  $('#example').tooltip();
                  });
                }*/
                </script>
<script>
  function redirectMe (sel) {
    var url = sel[sel.selectedIndex].value;
    window.location = url;
  }

</script>

			
</body></html>
