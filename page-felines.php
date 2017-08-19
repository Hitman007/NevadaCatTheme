<?php get_header(); ?>
<div id="content">
<h1>page single-feline.php </h1>
<div id="inner-content" class="wrap clearfix">
<div id="main" class="ninecol first" role="main">
<div class = "form_section">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<header class="article-header">
<h1 class="entry-title single-title" itemprop="headline"><?php the_title(); ?></h1>
</header> <!-- end article header -->
<section class="entry-content clearfix" itemprop="articleBody">HELLO THERE!!
<div class="page_img_right"><img src = "<?php global $post; $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); echo $url;?>" /></div>
<?php the_content(); ?>
</section> <!-- end article section -->
<footer class="article-footer">
</footer> <!-- end article footer -->
<?php endwhile; ?>
<?php else : ?>

							<article id="post-not-found" class="hentry clearfix">
					    		<header class="article-header">
					    			<h1><?php _e("Oops, Post Not Found!", "bonestheme"); ?></h1>
					    		</header>
					    		<section class="entry-content">
					    			<p><?php _e("Uh Oh. Something is missing. Try double checking things.", "bonestheme"); ?></p>
					    		</section>
					    		<footer class="article-footer">
					    		    <p><?php _e("This is the error message in the single.php template.", "bonestheme"); ?></p>
					    		</footer>
							</article>

						<?php endif; ?>

</div>
<div class = "twelvecol first">
<?php comments_template(); ?>
</div>
					</div> <!-- end #main -->
					<?php get_sidebar(); ?>


				</div> <!-- end #inner-content -->

			</div> <!-- end #content -->

<?php get_footer(); ?>
