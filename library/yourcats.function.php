<?php

function your_cats(){

	global $current_user;

	$user_id = get_current_user_id();

	$args = array(
			'post_type' => 'feline',
			'author' => $user_id,
	);
	$your_cats_roll = new WP_Query( $args );
	if( $your_cats_roll->have_posts() ) {
		while($your_cats_roll->have_posts() ) {
			$your_cats_roll->the_post();
			echo '<div class = "cat_roll_item"><div class = "cat_roll_title">';
			?>
			  <a href="<?php the_permalink();?>">
			<?php
			the_title(); ?> </a> <?php echo '</div>';
			  if ( has_post_thumbnail()) { ?>
     <?php echo the_post_thumbnail(); ?>
     <?php } else { ?>	
		<img src = "http://asiascatcreations.com/wp-content/uploads/2012/12/cat_default_img.jpg" width="128" height="128" >
      <?php }	
           echo  '</div>';

			

		}

	 }else{

		echo "You haven't added any cats yet.";

	}

}

