<?php 

require_once("../../../wp-load.php");
echo "hello add value";

crg_auth_redirect();
global $current_user;
$user_id = get_current_user_id();
	
if($_POST['cat_name']=="")
  {
  $error=" Please Enter Your Cat Name";  
  } 
	// Create post object
   else{
	// Create post object

	$new_entry = array();
	$new_entry['post_title'] = $_POST['cat_name'];
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
	echo $uploadedfile = $_FILES['cat_image'];
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

		$attach_id = wp_insert_attachment( $attachment, $filename);
		set_post_thumbnail( $entry_id, $attach_id );
		//wpuf_set_post_thumbnail( $entry_id, $attach_id );
	}
}
	
?>
	