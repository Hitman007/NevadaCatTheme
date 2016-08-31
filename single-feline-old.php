<?php

crg_auth_redirect();
global $current_user;
get_currentuserinfo();
  $user_id = get_current_user_id();
  $author = $current_user->display_name ; 
if (isset($_POST['form_submit_button'])){
 $auther=$_POST['auther'];
 if($auther == $user_id){ 
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
	$new_entry = array();
	$new_entry['post_title'] = $_POST['cat_name'];
	$new_entry['post_content'] = 'content';
	$new_entry['post_status'] = 'publish';
	$new_entry['post_type'] = 'feline';
	$new_entry['post_author'] = $user_id;

	// Insert the post into the database

	$entry_id = wp_update_post( $new_entry );
	update_post_meta($entry_id,'sex',$_POST["gender"]); 	
    update_post_meta($entry_id,'food_type',$_POST["food_type"]);	
	update_post_meta($entry_id,'treat',$_POST["treat"]);	
	update_post_meta($entry_id,'suspend',$_POST["suspend"]);	
	if($_POST["suspend"]==""){
	update_post_meta($entry_id,'suspend','FALSE');
	}	
	update_post_meta($entry_id,'paid_first','FALSE'); 
	update_post_meta($entry_id,'cat_name',$_POST["cat_name"]); 
	update_post_meta($entry_id,'product',$productid);
	
	if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );	
	$uploadedfile = $_FILES['cat_image'];
	$upload_overrides = array( 'test_form' => false );
	$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
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
 if ($filename ==""){
 
 }else{
		$attach_id = wp_insert_attachment( $attachment, $filename);
		set_post_thumbnail( $entry_id, $attach_id );
	}	//wpuf_set_post_thumbnail( $entry_id, $attach_id );

	}
	}
	if ($_POST['form_submit_button'] == "Proceed to Payment"){
		header('Location: http://asiascatcreations.com/payment/');
	}
 }else{
  $error ="You can not Update this page";
 }
}

get_header();
?>	

<div id="content">
<div id="inner-content" class="wrap clearfix">
<div id="main" class="ninecol first clearfix" role="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
<h1>Your Cats:</h1>
<div style = "width:100%;clear:both;"></div><hr />
<section class="entry-content">
<h3 style="color:#ff0000;"><?php  echo  $error; ?></h3>
<?php  the_content(); ?>

<form method = "post" enctype="multipart/form-data" >
<input type="hidden" value="<?php the_author_ID(); ?>" name="auther"  />
	<div id = "add_cat_left_side">   
		<label for = "cat_name">Cat's Name:	</label>
		<input type = "input" readonly name = "cat_name" required id = "cat_name" onkeyup = "clear_error_msg('cat_name','add_cat_error_msg');" placeholder = "i.e. Sparkles or Mushy" value="<?php echo get_post_meta($post->ID, 'cat_name', true); ?>" />
		<div class="error_msg" id="add_cat_error_msg"></div>
		<label for = "gender"> Gender: </label>
 <?php $sex= get_post_meta($post->ID, 'sex', true);
       if($sex=='boy'){
	   $sex=1;	 
	   } 
  if($sex=='girl'){
     $sex=2;	  
	   } 
  ?>
		<input type = "radio" name = "gender" id = "gender" value = "boy"<?php if($sex==1){ ?>  checked="checked" <?php } ?> /> Boy
		<input type = "radio" name = "gender" id = "gender" value = "girl" <?php if($sex==2){ ?>  checked="checked" <?php } ?> /> Girl

	</div>	<!--end #add_cat_left_side -->
	<div id = "add_cat_image">
     <label for = "cat_image" style="float:left; width:100%">Upload Cat's Image: (Optional, we'll put it on the box!)</label>
	 <?php  if ( has_post_thumbnail()) { ?>
     <?php echo the_post_thumbnail(); ?>
     <?php } else { ?>	
		<img src = "http://asiascatcreations.com/wp-content/uploads/2012/12/cat_default_img.jpg" >
     <?php } ?>			
		<input type="file" name="cat_image" id="cat_image" />
	</div>

	<div id = "subscription_products">
 <?php  $food= get_post_meta($post->ID, 'food_type', true);  ?>
		<input type="radio" name="food_type" id="rd1" value="1" <?php if($food==1){ ?>  checked="checked" <?php } ?> > KittenCaboodle [30 days of food]<br />
		<input type="radio" name="food_type" value="2" id="rd2" <?php if($food==2){ ?>  checked="checked" <?php } ?> > ChickenPuddin [Adult Cat Food]<br />
		<input type="radio" name="food_type" value="3" id="rd3" <?php if($food==3){ ?>  checked="checked" <?php } ?> > Skinny Cat [Weight loss food]<br />
        <input type="radio" name="food_type" value="4" id="rd4" <?php if($food==4){ ?>  checked="checked" <?php } ?> > The Mountain [Mature / low energy cats]<br />

        <br />
         <?php  $treat= get_post_meta($post->ID, 'treat', true);  ?>
         <input type="checkbox" name="treat" value="1" <?php if($treat==1){ ?>  checked="checked" <?php } ?> /> &nbsp; Add treats for $5!<br /><br />
        
      <?php  $suspend= get_post_meta($post->ID, 'suspend', true);  ?>
        <input type="checkbox" name="suspend" value="TRUE" <?php if($suspend=="TRUE"){ ?>  checked="checked" <?php } ?> /> &nbsp; Temporarily Suspend Subscription<br /><br />
		</div>
		<input type="submit" name="form_submit_button" class = "cat_button" value="Update Cat" onClick="ValidateForm(this.form)"  /><br />
		<input type = "submit" name = "form_submit_button" class = "cat_button" value = "Proceed to Payment" />

	</form>	
<?php endwhile; ?>
<?php else : ?>
<?php endif; ?>
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

