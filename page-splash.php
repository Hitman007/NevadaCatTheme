<?php
/*
Template Name: Splash Page
*/
?>
<!DOCTYPE html>
<body>

<style>
html {height:100%; width:100%;padding: 0; margin: 0;}
body{height:100%; width:100%; padding: 0; margin: 0;}
#pic_1{height:100%; width:100%; padding: 0; margin: 0;
background-image:url('http://asiascatcreations.com/1.jpg');
background-repeat:no-repeat;
background-attachment:fixed;
}

.text {color: red; font-size:5em; font-family: 'Shadows Into Light Two', cursive;}
#text_1 {position: absolute; top: 20%; left: 20%; z-index:4;}
#text_2 {position: absolute; top: 20%; left: 20%; z-index: 4;}
#text_3 {position: absolute; top: 20%; left: 20%; z-index: 4;}
#text_4 {position: absolute; top: 20%; left: 20%; z-index: 4;font-size:5em;}
</style>


<link href='http://fonts.googleapis.com/css?family=Amatic+SC:700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light+Two' rel='stylesheet' type='text/css'>

<script>
jQuery(document).ready(function(){
$("#text_1").hide(0);
$("#text_2").hide(0);
$("#text_3").hide(0);
$("#text_4").hide(0);

function crg_textr(){
var del = 1800;
var ldel = 6000;
$("#text_1").fadeIn(del).delay(del).fadeOut(del, function()
{
$("#text_2").fadeIn(del).delay(del).fadeOut(del, function()
{
$("#text_3").fadeIn(del).delay(del).fadeOut(del, function()
{
$("#text_4").fadeIn(del).delay(ldel).fadeOut(del, crg_textr);
});
});
});
};

crg_textr();
});
</script>

<div id = "pic_1">
</div>
<div id = "text_1" class = "text" >
HEY YOU!
</div>
<div id = "text_2" class = "text">
Would you feed junk food to a baby?
</div>
<div id = "text_3" class = "text">
Then why you are you feeding it to your cat?
</div>
<div id = "text_4" class = "text">
Love your cat. Feed him 100% grain-free and all-natural Asia's Cat Creations. Prepared by hand with real human-grade meat, bones, and organs.
</div>
</body>
</html>
