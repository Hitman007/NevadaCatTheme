<footer role="contentinfo">
<div id="inner-footer" class="wrap clearfix">
	<span style="float:left;">Copyright <a href = "http://asiascatcreations.com/wp-admin/index.php">&copy;</a> Asia's Cat Creations. All rights reserved. <a href = "http://asiascatcreations.com/contact/">Contact us.</a> Check us out on <a href = "https://www.facebook.com/pages/Asias-Cat-Creations/168526476626573">Facebook</a>. This site is a <a href = "http://customrayguns.com">Custom Ray Gun.<img align = "MIDDLE" src = "<?php $site_url = get_bloginfo('url'); echo ($site_url . "/wp-content/uploads/2012/12/ray_gun.gif"); ?>" /></a>.</span>
</div> <!-- end #inner-footer -->
</footer> <!-- end footer -->

</div> <!-- end #container -->
<!-- all js scripts are loaded in library/bones.php -->
<?php 
	wp_footer(); 
	if(isset($_SESSION['msg']))
	unset($_SESSION['msg']);
?>
</body>
</html> <!-- end page. what a ride! -->
