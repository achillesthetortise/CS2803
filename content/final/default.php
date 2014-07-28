<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">

    <title>Final Project</title>

      <link rel="shortcut icon" href="img/brain.ico">

    <script src="http://code.jquery.com/jquery-latest.min.js" ></script>
    <script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
    <script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/sliderStyle.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/loginStyle.css" />
</head>

<body>
      <img id="brain" src="img/brain.jpg" />
      <div id="hiddenGame">Play!</div>
      <header>

      <h1>Middle Brain.</h1>
      <div id="login">Login/Sign Up</div>

      <?php
      if( !empty($_SESSION['username']) ) echo "<span id='loggedIn'>Hello, ".$_SESSION['username']."</span>";

      ?>
      </header>

    <div id="container-main">
    <script type="text/javascript" src="libs/jquery-slider-master/js/jssor.core.js"></script>
    <script type="text/javascript" src="libs/jquery-slider-master/js/jssor.utils.js"></script>
      <script type="text/javascript" src="libs/jquery-slider-master/js/jssor.slider.js"></script>
      <script type="text/javascript">
          var _SlideshowTransitions, _CaptionTransitions, options;
          var JQTWEET;
      </script> 
    <script type="text/javascript" src="js/sliderFactory.js"></script>
    <script>
      
              
      jQuery(document).ready(function ($) {

          /** Right Column RSS feed **/
              var url = 'http://www.nasa.gov/rss/dyn/image_of_the_day.rss';
              $.ajax({
                type: "GET",
                url: document.location.protocol + '//ajax.googleapis.com/ajax/services/feed/load?v=1.0&num=1000&callback=?&q=' + encodeURIComponent(url),
                dataType: 'json',
                error: function(){
                alert('Unable to load feed, Incorrect path or invalid feed');
                },
                success: function(xml){
                values = xml.responseData.feed.entries;
                for(var i = 0; i < values.length; ++i) {
                    $('#right-col').append( "<div class='rss' ><a href='"+values[i]['link']+"'>"+values[i]['title']+"</a> : "+values[i]['publishedDate'].slice(0,values[i]['publishedDate'].length-14)+"<br><p>"+values[i]['contentSnippet']+"</p></div>" );
                }
                }
              });

              /** Left Column JSON feed **/
              $.getJSON(
                  "http://www.reddit.com/r/arduino.json?jsonp=?",
                  function foo(data) {
                      $.each(
                          data.data.children.slice(0, 10),
                          function (i, post) {
                              $("#left-col").append( "<div class='rss'><a href='"+post.data.url+"'>" + post.data.title +"</a></div>");
                          }
                      )
                          }
              );        
          /** Draggable logo that hides easter egg. **/
          $('#brain').draggable();

          $('#hiddenGame').click( function() {
              window.location = "http://localhost:3000";
          }); 
          
          /** Login popup functionality. **/
          $('#login').click( function() {
              $('#screen').css({	"display": "block", opacity: 0.7, "width":$(document).width(),"height":$(document).height()});
              $('body').css({"overflow":"hidden"});
              $('#box').css({"display": "block"});
              $('#box').html( $('#loginTemplate').html() );
              
              $('#loginForm').submit( function(ev) {
                  ev.preventDefault();
                  $.ajax({
                    type: 'POST',
                    url: 'login.php',
                    data: $('#loginForm').serialize(),
                    cache: false,
                          });
                  $('#box').css("display","none");
                  $('#screen').css("display","none");
                  $('body').css("overflow","auto");
                  
              });
              
              $('#signup').click( function(event) {
                  event.preventDefault();
                  $('#box').html( $('#signupTemplate').html() );
                  $('#signupForm').css("display","block");
                  $('#signupForm').submit( function(e) {
                      e.preventDefault();
                      $.ajax({
                        type: 'POST',
                        url: 'signup.php',
                        data: $('#signupForm').serialize(), 
                        cache: false,
                        success: function() {
                            console.log("order submitted");
                        },
                      });

                      $('#box').css("display", "none");
                      $('#screen').css("display", "none");
                      $('body').css("overflow", "auto");
                  });
              });
              
              $('#cancel').click( function() {
                  $(this).closest('form').find("input[type=text], textarea").val("");
                  $(this).closest('form').find("input[type=email], textarea").val("");
                  $('#box').css("display", "none");
                  $('#screen').css("display", "none");
                  $('body').css("overflow","auto");
              });
              $('#screen').click( function() { 
                  $('#box').css("display", "none");
                  $('#screen').css("display", "none"); 
                  $('body').css({"overflow":"auto"});
              });
              
              });
              
              /** Initialize Slider **/
              var jssor_slider1 = new $JssorSlider$("slider1_container", options);
              function ScaleSlider() {
              var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
              if (parentWidth)
                  jssor_slider1.$SetScaleWidth(Math.min(parentWidth, 600));
              else
                  window.setTimeout(ScaleSlider, 30);
              }
              
              ScaleSlider();
              
              if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
                  $(window).bind('resize', ScaleSlider);
              }
              
          });
    </script>
    <!-- Jssor Slider Begin -->
    <div id="slider1_container" style="position: relative; width: 600px; float: left; height: 300px; left: 10px; top: 10px;"> 

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(libs/jquery-slider-master/img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div class="slides" u="slides" style="left: 0px; top: 0px; width: 600px; height: 300px; overflow: hidden;">
            <div>
                <img u=image src="img/slideshow/01.jpg" />
                <div u="thumb" style="overflow: none;">Touch screens are getting better! <a href="http://www.graphenetracker.com/samsung-patents-graphene-based-touch-screen/" style="color: #000000;">Read more!</a></div>
                <div u="caption" t="L" style="position: absolute; top: 20px; left: 20px; width: 500px; height: 30px; color: #000000; font-size: 20px; line-height: 30px;">What does this mean for our digital devices?</div>
                <div u="caption" t="CLIP|LR" style="position: absolute; top: 135px; left: 100px; width: 400px; height: 30px; color: #000000; font-size: 26px; line-height: 30px; text-align: center; overflow: none;">Samsung wants to find out first!</div>
            </div>
            <div>
                <img u=image src="img/slideshow/02.jpg" />
                <div u="thumb" style="overflow: none;">Explore your creativity with open source games.</div>
                <div u="caption" t="MCLIP|L" style="position: absolute; top: 105px; left: 100px; width: 400px; height: 30px; color: #000000; font-size: 26px; line-height: 30px; text-align: center; background: #FFFFFF;">Just an arduino and a few wires!</div>
                <div u="caption" t="LISTH|L" style="position: absolute; top: 165px; left: 100px; width: 400px; height: 30px; color: #000000; font-size: 26px; line-height: 30px; text-align: center; background: #FFFFFF;">Rebuild a nintendo!</div>
            </div>
            <div>
                <img u=image src="img/slideshow/03.jpg" />
                <div u="thumb" style="overflow: none;">Bring your artwork alive with <a href="http://philanthropy.com/article/An-Art-Museum-Uses-Technology/138951/" style="color: black;" >innovation!</a></div>
                <div u="caption" t="WAVE|L" t2="T" style="position: absolute; top: 135px; left: 450px; width: 150px; height: 30px; color: #ffffff; font-size: 26px; line-height: 30px; text-align: center;">interested?</div>
                <div u="caption" t="WAVE|L" t2="T" d="-1150" style="position: absolute; top: 135px; left: 250px; width: 100px; height: 30px; color: #ffffff; font-size: 26px; line-height: 30px; text-align: center;">YOU</div>
                <div u="caption" t="WAVE|L" t2="T" d="-1150" style="position: absolute; top: 135px; left: 50px; width: 100px; height: 30px; color: #ffffff; font-size: 26px; line-height: 30px; text-align: center;">Are</div>
            </div>
            <div>
                <img u=image src="img/slideshow/04.jpg" />
                <div u="thumb" style="overflow: none;">Can we teach robots to paint?</div>
                <div u="caption" t="JUMPDN|R" t2="B" style="position: absolute; top: 185px; left: 50px; width: 200px; height: 30px; color: #000000; font-size: 26px; line-height: 30px; text-align: center;">Robots</div>
                <div u="caption" t="JUMPDN|R" t2="B" d="-850" style="position: absolute; top: 185px; left: 210px; width: 100px; height: 30px; color: #000000; font-size: 26px; line-height: 30px; text-align: center;">and</div>
                <div u="caption" t="JUMPDN|R" t2="B" d="-850" style="position: absolute; top: 185px; left: 350px; width: 150px; height: 30px; color: #000000; font-size: 26px; line-height: 30px; text-align: center;">Humanity</div>
            </div>
            <div>
                <img u=image src="img/slideshow/05.jpg" />
                <div u="thumb" style="overflow: none">3D Printing Pens! <a href="http://www.damngeeky.com/2013/08/13/13300/worlds-first-3d-printing-pen-yaya-by-imakr.html" style="color: black;">Read more</a></div>
                <div u="caption" t="DDG|TR" style="position: absolute; top: 35px; left: 20px; width: 150px; height: 30px; color: #000000; font-size: 26px; line-height: 30px; text-align: center;">Drawing...</div>
                <div u="caption" t="DODGEDANCE|L" style="position: absolute; top: 35px; left: 120px; width: 250px; height: 30px; color: #000000; font-size: 26px; line-height: 30px; text-align: center;">just got cooler!</div>
            </div>
            <div>
                <img u=image src="img/slideshow/06.jpg" />
                <div u="thumb">Allowing us to reach our full potential. <a href="http://www.3ders.org/articles/20130114-3d-printing-celebrates-personalities-while-hiding-lost-limbs.html" style="color: black;">More.</a></div>
                <div u="caption" t="FLUTTER|L" style="position: absolute; top: 135px; left: 100px; width: 180px; height: 30px; color: #000000; font-size: 26px; line-height: 30px; text-align: center;background: #FFFFFF;">biotechnology</div>
                <div u="caption" t="TORTUOUS|VB" style="position: absolute; top: 135px; left: 300px; width: 250px; height: 30px; color: #000000; font-size: 26px; line-height: 30px; text-align: center;background: #FFFFFF;">no limits</div>
            </div>
            <div>
                <img u=image src="img/slideshow/07.jpg" />
                <div u="thumb">International space station</div>
                <div u="caption" t="FADE" style="position: absolute; top: 135px; left: 50px; width: 300px; height: 30px; color: #ffffff; font-size: 26px; line-height: 30px; text-align: center;background: black;">Universal collaboration</div>
                <div u="caption" t="ZMF|10" style="position: absolute; top: 165px; left: 200px; width: 250px; height: 30px; color: #ffffff; font-size: 26px; line-height: 30px; text-align: center;background: black;">on the final frontier.</div>
            </div>
            <div>
                <img u=image src="img/slideshow/08.jpg" />
                <div u="thumb">Don&#39;t be this guy</div>
                <div u="caption" t="RTT|10" style="position: absolute; top: 135px; left: 100px; width: 150px; height: 30px; color: green; font-size: 26px; line-height: 30px; text-align: center; background: black;">So 1337</div>
                <div u="caption" t="RTTL|BR" style="position: absolute; top: 135px; left: 300px; width: 250px; height: 30px; color:green; font-size: 26px; line-height: 30px; text-align: center;background: black;">much hacking.</div>
            </div>
        </div>

        <!-- ThumbnailNavigator Skin Begin -->
        <div u="thumbnavigator" class="slider1-T" style="position: absolute; bottom: 0px; left: 0px; height:60px; width:600px;">
            <div style="filter: alpha(opacity=40); opacity:0.4; position: absolute; display: block;
                background-color: #ffffff; top: 0px; left: 0px; width: 100%; height: 100%;">
            </div>
            <!-- Thumbnail Item Skin Begin -->
            <div u="slides">
                <div u="prototype" style="POSITION: absolute; WIDTH: 600px; HEIGHT: 60px; TOP: 0; LEFT: 0;">
                    <thumbnailtemplate style="font-family: verdana; font-weight: normal; POSITION: absolute; WIDTH: 100%; HEIGHT: 100%; TOP: 0; LEFT: 0; color:#000; line-height: 60px; font-size:20px; padding-left:10px;"></thumbnailtemplate>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div>
        <!-- ThumbnailNavigator Skin End -->
        
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb01" style="position: absolute; bottom: 16px; right: 10px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype" style="POSITION: absolute; WIDTH: 12px; HEIGHT: 12px;"></div>
        </div>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora05l" style="width: 40px; height: 40px; top: 123px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora05r" style="width: 40px; height: 40px; top: 123px; right: 8px">
        </span>
        <!-- Arrow Navigator Skin End -->
    </div>
    <!-- Jssor Slider End -->
      <div id="about">
        <h2>About</h2><br>
              <p>In a world where technology becomes more and more integral to our daily lives, it is important to remain well-balanced.  We must be vigilant in shaping our creative mind in parallel with our technical one.</p>
              <br>
              <p>This website aims to inspire the innovative.  Whether it be from making a major scientific breakthrough or doing a simple experiment, the inspired always find new ways to explore the world in which we live.</p>
      </div>
      <!-- 2 Column Content Begin -->
      <div id="left-col">
              <h3>JSON data from /r/arduino</h3>

      </div>
      <div id="right-col">
              <h3>RSS from NASA</h3><br>

      </div>
      
      <footer>
      <a href="http://github.com/achillesthetortise">Github</a>
      </footer>

</div> <!--Container End-->
 

<!--Login Begin-->
<div id="box"> </div>
<div id="screen"></div>

<div id="loginTemplate">
 <form id="loginForm" method="post" action="">
       <h3>Hey.</h3><br>
       <label>Email</label>
       <input name="email" type="email" placeholder="Type Here">
       <br><br>
       <label>Password</label>
       <input name="password" type="password">
       
    <input class="btn" name="submit" type="submit" value="Submit" />
    <input class="btn" type="button" value="Cancel" />
    
</form>
    <span id="signuptxt" >New here?  <a id="signup" href="#">Sign up!</a> </span>
</div>

<!--Login End-->
<!--Sign up Begin-->
<div id="signupTemplate" >
<div id="success_message" style="display: none">Your message has been sent!</div>
<form id="signupForm" method="post" action="" >
    <h3>Welcome to Middle Brain!</h3>
    <br>
    <label>Email</label>
        <input name="email" type="email" placeholder="Please enter your email" />
    <br><br>
    <label>Password</label>
        <input name="password" type="password" />
    <br><br>
    <label>and again..</label>
        <input name="confirmpassword" type="password" />
    <br>
  <div id="myCaptcha">
<img id="captcha" src="libs/securimage/securimage_show.php" alt="CAPTCHA Image" /><br>
              <label>Enter text: </label>
  <input type="text" name="captcha_code" size="10" maxlength="6" />
              <br><br>
<a href="#" onclick="document.getElementById('captcha').src = 'libs/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
  

    <input id="signupSubmit" class="btn"  name="signupSubmit" type="submit" value="Submit" />
</div>
</form>

</div>

<!--Sign up End-->
</body>

    <script src="js/pageLayout.js">    </script>

</html>

