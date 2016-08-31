<?php
/*
Template Name: Blog
*/
?>

<?php get_header(); ?>
			
			<div id="content">
			
				<div id="inner-content" class="wrap clearfix">
			
				    <div id="main" class="ninecol first clearfix form_section" role="main">
					
	<?php query_posts('category_name=blog&post_status=publish,future');?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
	<p><?php the_excerpt(); ?>
	<?php endwhile; else: endif; ?>

				    </div> <!-- end #main -->
    				    <?php get_sidebar(); ?>
		    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->
	
			
			
<?php get_footer(); ?>