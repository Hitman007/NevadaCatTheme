<?php

/*

Template Name: 


?>





<?

crg_auth_redirect();

global $current_user;

$user_id = get_current_user_id();

if (isset($_POST['form_submit_button'])){

if($_POST['cat_name']=="")

  {

  $error=" Please Enter Your Cat Name";  

  } 

$gender = $_POST['gender'];

  if ($gender=="")

{   

   $error=" Please Enter Your Cat Gander";  

}

  

  

	// Create post object

   else{

	// Create post object



	$new_entry = array();

	$last = $new_entry['post_title'] = $_POST['cat_name'];	

	$new_entry['post_content'] = 'content';

	$new_entry['post_status'] = 'publish';

	$new_entry['post_type'] = 'feline';

	$new_entry['post_author'] = $user_id;

	// Insert the post into the database

	$entry_id = wp_insert_post( $new_entry );

	add_post_meta($entry_id,'sex',$_POST["gender"]);     

	add_post_meta($entry_id,'food_type',$_POST["food_type"]); 	

	add_post_meta($entry_id,'treat',$_POST["treat"]);		

	add_post_meta($entry_id,'suspend','FALSE');		

	add_post_meta($entry_id,'paid_first','FALSE'); 

	add_post_meta($entry_id,'cat_name',$_POST["cat_name"]); 

	add_post_meta($entry_id,'product',$productid);

	if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );

	 $uploadedfile = $_FILES['cat_image'];

	$upload_overrides = array( 'test_form' => false );

	echo $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

	if ( $movefile ) {

		$wp_filetype = $movefile['type'];

		$filename = $movefile['file'];

		$wp_upload_dir = wp_upload_dir();

		$attachment = array(

        		'guid' => $wp_upload_dir['url'] . '/' . basename( $filename ),

        		'post_mime_type' => $wp_filetype,

			'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),

			'post_content' => '',

			'post_status' => 'inherit'

    		);



		$attach_id = wp_insert_attachment( $attachment, $filename);

		set_post_thumbnail( $entry_id, $attach_id );

		//wpuf_set_post_thumbnail( $entry_id, $attach_id );



   

	}

	header('Location:http://asiascatcreations.com/feline/'.$last);	

	

}	

}

	if ($_POST['form_submit_button'] == "Proceed to Payment"){

		header('Location: http://asiascatcreations.com/payment/');

	}

get_header();

?>	

 

<div id="content">

<div id="inner-content" class="wrap clearfix">

<div id="main" class="ninecol first clearfix" role="main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

<h1>Your Cats:</h1>

<?php your_cats();?>

<div style = "width:100%;clear:both;"></div><hr />

<section class="entry-content">

<h3  style="color:#ff0000;" ><?php  echo  $error; ?></h3>

<?php the_content(); ?>

<?php endwhile; ?>	

<?php else : ?>

<?php endif; ?>



	<form id="addform" method = "post" enctype="multipart/form-data" action="#">

	<div id = "add_cat_left_side">

		<label for = "cat_name">Cat's Name:	</label>

		<input type = "input" name = "cat_name" id = "cat_name" onkeyup = "clear_error_msg('cat_name','add_cat_error_msg');" placeholder = "i.e. Sparkles or Mushy" required />

		<div class="error_msg" id="add_cat_error_msg"></div>

		<label for = "gender">  Gender:</label>

		<input type = "radio" name = "gender" id = "gender" value = "boy" /> Boy

		<input type = "radio" name = "gender" id = "gender" value = "girl" /> Girl

	</div>	<!--end #add_cat_left_side -->



	<div id = "add_cat_image">

        <label for = "cat_image" style="float:left; width:100%">Upload Cat's Image: (Optional, we'll put it on the box!)</label>

		<div class="default_img"><img src = "http://asiascatcreations.com/wp-content/uploads/2012/12/cat_default_img.jpg" >	</div>

		<input type="file" name="cat_image" id="cat_image" />        

	</div>

	<div id = "subscription_products">

		<input type="radio" name="food_type" id="rd1" value="1"> KittenCaboodle [30 days of food]<br />

		<input type="radio" name="food_type" value="2" id="rd2" > ChickenPuddin [Adult Cat Food]<br />

		<input type="radio" name="food_type" value="3" id="rd3" > Skinny Cat [Weight loss food]<br />

        	<input type="radio" name="food_type" value="4" id="rd4" > The Mountain [Mature / low energy cats]<br />

        <br />

		<input type="checkbox" name="treat" value="1" /> &nbsp; Add treats for $5!<br /><br />

		</div>

		<input type="submit" name="form_submit_button" class = "cat_button" value="Add Another Cat" /><br />

		<input type = "submit" name = "form_submit_button" class = "cat_button" value = "Proceed to Payment" />

	</form>	



</section> <!-- end article section -->	

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



