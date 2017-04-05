<?php
/*
Template Name: Front page
*/
?>
<?php get_header(); ?>
<div id="content">
<div id="inner-content" class="wrap clearfix">
<div id="main" class="ninecol first clearfix form_section" role="main">
<h1>Human Grade All Natural Cat Food</h1>
<p>Nevada Cat House products are created using only ingredients sold for human consumption. No "meat bi products" here, whatever that is. Healthy, all natural food for your cat!</p>
	<?php query_posts('category_name=products&post_status=publish,future');?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php $postid = get_the_ID(); $url = wp_get_attachment_url( get_post_thumbnail_id($postid) );?>
		<div class = "front_page_image" id = "front_page_image_<?php echo $postid; ?>">
			<style>
				#front_page_image_<?php echo $postid; ?>{background:url(<?php echo $url;?>);background-size:cover;}
			</style>
		</div>
		<div class = "h2"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div><?php global $post; $slug = $post->post_name; ?>
		<script>
			jQuery( document ).ready(function() {
				jQuery('#subscription_button_<?php echo $slug;?>').click(function(){
					window.location.href = "/subscriptions/?subscription_type=<?php echo $slug;?>";
				});
			jQuery('#info_button_<?php echo $slug;?>').click(function(){
					window.location.href = "/<?php echo $slug;?>";
				});

			});
		</script>
		<?php $e = get_the_excerpt(); echo $e;?><br />
		<input type = "button" name = "subscription" value = "Subscriptions" class = "cat_button" id = "subscription_button_<?php echo $slug;?>" /> - Less than $2/day!<br />
		<input type = "button" name = "recipe" value = "Nutrition Info" class = "cat_button" id = "info_button_<?php echo $slug;?>"/>
		<div style = "width: 100%; clear: both; display:block;">&nbsp;</div>
	<?php endwhile; else: endif; ?>
</div> <!-- end #main -->
<?php get_sidebar(); ?>
</div> <!-- end #inner-content -->
</div> <!-- end #content -->
<?php get_footer(); ?>
