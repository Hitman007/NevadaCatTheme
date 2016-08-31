<?php
/*
Template Name: Login
*/
?>

<?php
	$sid = session_id();
	if(!($sid)) {session_start();} 
	get_header();
?>
			
			<div id="content">
			
				<div id="inner-content" class="wrap clearfix">
			

<div id = "login_email_section" class = "form_section">
<h1>Login with your email:</h1>
					    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
													    <?php the_content(); ?>
					    <?php endwhile; ?>	
					    <?php else : ?>			
					    <?php endif; ?>
<br />&nbsp;
				    </div> <!-- end #main -->



<!--
					<div id = "login_divider">
					
					</div>

				</div> <!-- end #inner-content -->

			
    
			</div> <!-- end #content -->
	
			
			
<?php get_footer(); ?>