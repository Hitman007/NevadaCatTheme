<div id="sidebar1" class="sidebar threecol last clearfix form_section" role="complementary">
<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>
<div id = "order_now_button">
<div id = "slide_1">
	<a href = "http://asiascatcreations.com/add-cat/" >
		<img id = "slide_1_img" src = "https://asiascatcreations.com/wp-content/themes/asias_cat_creations/library/images/order_now_1.jpg" width = "100%" />
	</a>
</div>
</div>
<script>
jQuery('document').ready(function(){
});
function crg_slider(){
	setTimeout(function(){jQuery("#slide_1_img").attr('src','https://asiascatcreations.com/wp-content/themes/asias_cat_creations/library/images/order_now_2.jpg');},1500);
	setTimeout(function(){jQuery("#slide_1_img").attr('src','https://asiascatcreations.com/wp-content/themes/asias_cat_creations/library/images/order_now_1.jpg');},3000);
}
	
function crg_back_slider(){

}


</script>					
<?php 
dynamic_sidebar( 'sidebar1' );
?>
<?php else : ?>
<!-- This content shows up if there are no widgets defined in the backend. -->
<div class="alert help">
<p><?php _e("Please activate some Widgets.", "bonestheme");  ?></p>
</div>
<?php endif; ?>
</div>
