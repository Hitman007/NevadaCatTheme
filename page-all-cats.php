<?php

/*

Template Name: All Cats

*/

global $current_user;

$user_id = get_current_user_id();

get_header();

 ?>	

 

<div id="content">

<div id="inner-content" class="wrap clearfix">

<div id="main" class="ninecol first clearfix" role="main">



<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">



<section class="entry-content">
<?php the_content(); ?>
<?php endwhile; ?>	
<?php else : ?>
<?php endif; ?>
<h1>Your Cats:</h1>
<?php
include_once ((dirname(__FILE__)) . '/library/yourcats.function.php');
your_cats();
echo "<div style = 'width:100%;clear:both;'>
		</div><div id = 'add_a_cat_button'>
		<form action = '/index.php/add-cat/' method = 'post'>
		<input type = 'submit' class = 'cat_button' value = 'Add a Cat' />
		<input type = 'hidden' name = 'new-cat-old-cat-flag' id = 'new-cat-old-cat-flag' value = 'NEWCAT' />
		</form></div><hr />";
echo "<br />";
$args = array('post_type' => 'feline');
$your_cats_roll = new WP_Query( $args );
if( $your_cats_roll->have_posts() ) {
	while( $your_cats_roll->have_posts() ) {
		$your_cats_roll->the_post();
		$x = get_the_author_meta('ID');
		$y = $user_id + 1;
		$z = $x + 1;
		//echo ($y.$z."wtf<br />");
		if ($x == $user_id){continue;}
		?>

		<div class = "cat_roll_item">

		<div class = "cat_roll_title"> <a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a> </div>

		<?php  if ( has_post_thumbnail()) { ?>
     <?php echo the_post_thumbnail(); ?>
     <?php } else { ?>	
		<img src = "http://asiascatcreations.com/wp-content/uploads/2012/12/cat_default_img.jpg" >
      <?php } ?>	

		</div>

		<?php

	}

 }else{

	echo "No Cats.";

}





?>

	

</section> <!-- end article section -->

<footer class="article-footer">

<p class="clearfix"><?php the_tags('<span class="tags">Tags: ', ', ', '</span>'); ?></p>

</footer> <!-- end article footer -->					

</article> <!-- end article -->



</div> <!-- end #main -->

<?php get_sidebar(); ?>

</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<script>

jQuery( document ).ready(function() {

    //alert( "jQuery working!" );

});

</script>		

<?php get_footer(); ?>

