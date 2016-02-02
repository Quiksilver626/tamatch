<?php
require('values.php');
require('functions.php');

session_start();
if(!isset($_SESSION['year']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:quarter.php");
}
if(!isset($_SESSION['ta_id']))
{
    session_regenerate_id(true);
    session_write_close();
    header("Location:login.php");
}
if(check_deadline($_SESSION['tadept'], $_SESSION['year'], $_SESSION['season']))
{
    $d = get_deadline($_SESSION['tadept'], $_SESSION['year'],
                      $_SESSION['season']);
    $_SESSION['deadline'] = $d[1].'/'.$d[2].'/'.$d[0];
    session_regenerate_id(true);
    session_write_close();
    header("Location:deadline.php");
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

<body style="background-image:url()">


<?php nav("info.php"); ?>
<br>

<fieldset style="margin:20px">
<legend>About this tool</legend>
The purpose of the TA ranking tool is to allow TAs such as yourself to rank their preferences of classes they want to teach in the upcoming quarter.  For information about how to use this tool, please see the tutorial below.
</fieldset>

<!--BEGIN TUTORIAL-->

<body>
    <div id="slider3_container" style="position: relative; top: 0px; left: 0px; width: 701px; height: 302px; background: #fff; overflow: hidden; margin-left:20px">

        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 99px; top: 0px; width: 600px; height: 300px; border: 1px solid gray; -webkit-filter: blur(0px); background-color: #fff; overflow: hidden;">
        <!--<div>
          <div style="margin: 10px; overflow: hidden; color: #000;"><p>The following provides a guide for how to use the quarter page. (Click to enlarge)</p><hr></div>
  		<div class="span6">
    	     	  <div id="slides">
	 	    <a href="img/quarter/quarter1.png" rel="thumbnail"><img src="img/quarter/quarter1.png"  /></a>
                    <a href="img/quarter/quarter2.png" rel="thumbnail"><img src="img/quarter/quarter2.png"  /></a>
      		    <a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
      		    <a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
    	          </div>
  	        </div>
             <div u="thumb">Quarter Page</div>
          </div>-->
        <div>
          <div style="margin: 10px; overflow: hidden; color: #000;"><p>The following provides a guide for how to use the calendar page. (Click to enlarge)</p><hr></div>
                <div class="span6">
                  <div id="slides2">
                    <a href="img/calendar/calendar1.png" rel="thumbnail"><img src="img/calendar/calendar1.png"  /></a>
                    <a href="img/calendar/calendar2.png" rel="thumbnail"><img src="img/calendar/calendar2.png"  /></a>
                    <a href="img/calendar/calendar3.png" rel="thumbnail"><img src="img/calendar/calendar3.png"  /></a>
                    <a href="img/calendar/calendar4.png" rel="thumbnail"><img src="img/calendar/calendar4.png"  /></a>
                    <a href="img/calendar/calendar5.png" rel="thumbnail"><img src="img/calendar/calendar5.png"  /></a>
                    <a href="img/calendar/calendar6.png" rel="thumbnail"><img src="img/calendar/calendar6.png"  /></a>
                    <a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
                    <a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
                  </div>

                </div>
             <div u="thumb">Calendar Page</div>
          </div>
        <div>
          <div style="margin: 10px; overflow: hidden; color: #000;"><p>The following provides a guide for how to use the preferences page. (Click to enlarge)</p><hr></div>
                <div class="span6">
                  <div id="slides3">
                    <a href="img/ranking/ranking1.png" rel="thumbnail"><img src="img/ranking/ranking1.png"  /></a>
                    <a href="img/ranking/ranking2.gif" rel="thumbnail"><img src="img/ranking/ranking2.gif"  /></a>
                    <a href="img/ranking/ranking3.png" rel="thumbnail"><img src="img/ranking/ranking3.png"  /></a>
                    <a href="img/ranking/ranking4.png" rel="thumbnail"><img src="img/ranking/ranking4.png"  /></a>
                    <a href="img/ranking/ranking5.png" rel="thumbnail"><img src="img/ranking/ranking5.png"  /></a>
                    <a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
                    <a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
                  </div>
                </div>
             <div u="thumb">Preferences Page</div>
          </div>
	</div>

        <!-- ThumbnailNavigator Skin Begin -->
        <div u="thumbnavigator" class="jssort13" style="position: absolute; width: 100px; height: 150px; left: 0px; top: 0px;">
            <!-- Thumbnail Item Skin Begin -->
            <div u="slides" style="cursor: move; top:0px; left:0px; border-top: 1px solid gray;">
                <div u="prototype" class="p" style="POSITION: absolute; WIDTH: 100px; HEIGHT: 30px; TOP: 0; LEFT: 0; padding:0px;">
                    <div class=w><ThumbnailTemplate class="c" style=" WIDTH: 100%; HEIGHT: 100%; position:absolute; TOP: 0; LEFT: 0; line-height:28px; text-align:center;"></ThumbnailTemplate></div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div>
        <!-- ThumbnailNavigator Skin End -->

        <a style="display: none" href="http://www.jssor.com">slideshow</a>
    </div>

<!--TUTORIAL END -->

<br><br>


<div class="button-row">
    <a href="calendar.php" class="button blue" style="padding: 5px; font-size: small" >Continue</a>
</div>
</body>

  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <script src="js/jquery.slides.min.js"></script>
  <script>
    $(function() {
      $('#slides').slidesjs({
        width: 940,
        height: 528,
        navigation: false
      });
    });
    $(function() {
      $('#slides2').slidesjs({
        width: 940,
        height: 528,
        navigation: false
      });
    });
    $(function() {
      $('#slides3').slidesjs({
        width: 940,
        height: 528,
        navigation: false
      });
    });
  </script>


