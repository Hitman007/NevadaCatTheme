<?php
/*
Author: Jim Karlinski
URL: htp://customrayguns.com
*/

function my_login_stylesheet() {
	$x = get_template_directory_uri();
	$x = $x . "/library/css/login.css";
	echo ('<link rel="stylesheet" id="custom_wp_admin_css"  href="' .$x . '" type="text/css" media="all" />');
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

require_once('library/bones.php'); // if you remove this, bones will break

require_once('library/custom-post-type.php'); // you can disable this if you like

/*
3. library/admin.php
    - removing some default WordPress dashboard widgets
    - an example custom dashboard widget
    - adding custom login css
    - changing text in footer of admint
4. library/translation/translation.php
    - adding support for other languages
*/
// require_once('library/translation/translation.php'); // this comes turned off by default
/************* THUMBNAIL SIZE OPTIONS *************/
// Thumbnail sizes
/*
add_action( 'admin_head', 'style_thumbsss' );

function style_thumbsss(){   

    echo '
    <style type="text/css">
    .inside p.hide-if-no-js a img.attachment-post-thumbnail { width: 230px!important; height: 160px!important; }
    </style>';
}

add_image_size( 'bones-thumb-600', 600, 150, true );

add_image_size( 'bones-thumb-300', 300, 100, true );

/* 
to add more sizes, simply copy a line from above 
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.
To call a different size, simply change the text
inside the thumbnail function.
For example, to call the 300 x 300 sized image, 
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>
You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/
// Sidebars & Widgetizes Areas

function bones_register_sidebars() {

    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => 'Sidebar 1',
    	'description' => 'The first (primary) sidebar.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
    /* 
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code. In order to call 
    your new sidebar just use the following code:
    Just change the name to whatever your new
    sidebar's id is, for example:
 

    register_sidebar(array(

    	'id' => 'sidebar2',

    	'name' => 'Sidebar 2',

    	'description' => 'The second (secondary) sidebar.',

    	'before_widget' => '<div id="%1$s" class="widget %2$s">',

    	'after_widget' => '</div>',

    	'before_title' => '<h4 class="widgettitle">',

    	'after_title' => '</h4>',

    ));

    

    To call the sidebar in your template, you can just copy

    the sidebar.php file and rename it to your sidebar's name.

    So using the above example, it would be:

    sidebar-sidebar2.php

    

    */

} // don't remove this bracket!



/************* COMMENT LAYOUT *********************/

		

// Comment Layout

function bones_comments($comment, $args, $depth) {

   $GLOBALS['comment'] = $comment; ?>

	<li <?php comment_class(); ?>>

		<article id="comment-<?php comment_ID(); ?>" class="clearfix">

			<header class="comment-author vcard">

			    <?php 

			    /*

			        this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:

			        echo get_avatar($comment,$size='32',$default='<path_to_url>' );

			    */ 

			    ?>

			    <!-- custom gravatar call -->

			    <?php

			    	// create variable

			    	$bgauthemail = get_comment_author_email();

			    ?>

			    <img data-gravatar="https://www.gravatar.com/avatar/<?php echo md5($bgauthemail); ?>" class="load-gravatar avatar photo" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />

			    <!-- end custom gravatar call -->

				<?php

				$comment_author_id = username_exists( $bgauthemail );

				$comment_autor_nickname = get_user_meta($comment_author_id, "Nickname", TRUE);

				$user_info = get_userdata($comment_author_id);

				//$user_display_name = $user_info->display_name;





				echo "<h4 style = 'float:left;'>$user_display_name</h4>";

				?>

				<span style = 'float:right;text-align:right;'><time datetime="<?php echo comment_time('Y-m-j'); ?>"><?php comment_time('F jS, Y'); ?></time></span>

				



			</header>



			<?php if ($comment->comment_approved == '0') : ?>

       			<div class="alert info">

          			<p><?php _e('Your comment is awaiting moderation.', 'bonestheme') ?></p>

          		</div>

			<?php endif; ?>

<br />

				<?php comment_text() ?>



			<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>

		</article>

    <!-- </li> is added by WordPress automatically -->

<?php

} // don't remove this bracket!



/************* SEARCH FORM LAYOUT *****************/



// Search Form

function bones_wpsearch($form) {

    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >

    <label class="screen-reader-text" for="s">' . __('Search for:', 'bonestheme') . '</label>

    <input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','bonestheme').'" />

    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search') .'" />

    </form>';

    return $form;

} // don't remove this bracket!



//add_filter('show_admin_bar', '__return_false');



if ((isset($_POST['crg_promo'])) && ($_POST['crg_promo'] != '*optional') && ($_POST['crg_promo'] != "") ){$_SESSION['promo'] = $_POST['crg_promo'];}



if (isset($_SESSION['promo'])){

	$c = strtoupper ( $_SESSION['promo']);

	$cc = $c[0] . $c[1];

	if (  $cc = "ZX" && ($c[3] == "v" || $c[3] == "V" || $c[4] == "v" || $c[4] == "V" || $c[5] == "v" || $c[5] == "V") ) {

		$x = 2;

		while ( ($c[$x]) != "V"){

			$compiled_user_id = $compiled_user_id . $c[$x];

			$x++;

		}

		if ( is_user_logged_in() ) {

			$current_user = wp_get_current_user();

			$id = $current_user->ID;

			if ($compiled_user_id == $id){

				unset ($_SESSION['promo']);

				wp_redirect( 'https://asiascatcreations.com/100dollars/');exit();

			 }else{

				$_SESSION['crg_login_redirect_url'] == "https://asiascatcreations.com/100dollars/";

			}

		}

	}

}

function frontend_update_cafe()

{

	if ( empty($_POST['frontend']) || empty($_POST['ID']) || empty($_POST['post_type']) || $_POST['post_type'] != 'cafes' )

		return;

 

	// $post global is required so save_cafe_custom_fields() doesn't error out

	global $post;

	$post = get_post($_POST['ID']);

 

	/*

	 * Format taxonomies properly for saving.

	 *

	 * Convert from

	 * $_POST[tax_input] => Array (

	 * 		[countries] => Array (0, 4, ...)

	 * )

	 * to

	 * $_POST[tax_input] => Array (

	 * 		[countries] => Australia,New Zealand

	 * )

	 */

	global $wpdb;

	if ( !empty($_POST['tax_input']) )

		foreach ( $_POST['tax_input'] as $taxonomy_slug=>$ids )

			$_POST['tax_input'][$taxonomy_slug] = implode(',', $wpdb->get_col("



				SELECT name

				FROM $wpdb->terms

				WHERE term_id IN (".implode(",", $ids).")

			"));

 

	$post_id = wp_update_post( $_POST );

 

	//upload images

	foreach ( $_FILES as $file => $details )

	{

		$wp_filetype = wp_check_filetype_and_ext( $details['tmp_name'], $details['name'] );

 

		//Only accept image uploads

		if ( !in_array($wp_filetype['ext'], array('png', 'jpg')) )

			continue;

 

		flynsarmy_add_media($file, $post_id, true);

	}

 

}

add_action('init', 'frontend_update_cafe');

 

// Upload media attachments

// See http://voodoopress.com/including-images-as-attachments-or-featured-image-in-post-from-front-end-form/

function flynsarmy_add_media($file_handler, $post_id, $setthumb='false') {

 

	// check to make sure its a successful upload

	if ( $_FILES[$file_handler]['error'] !== UPLOAD_ERR_OK )

		return false;

 

	require_once(ABSPATH . "wp-admin/includes/image.php");

	require_once(ABSPATH . "wp-admin/includes/file.php");

	require_once(ABSPATH . "wp-admin/includes/media.php");

 

	$attach_id = media_handle_upload( $file_handler, $post_id );

 

	if ( $setthumb )

		update_post_meta($post_id, '_thumbnail_id', $attach_id);

 

	return $attach_id;

}



  




function addcat($atts)
{ 
//crg_auth_redirect();
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
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<?php 
echo "<div id='content'>";
echo "<div id='inner-content' class='wrap clearfix'>";
echo "<div id='main' class='ninecol first clearfix' role='main'>";
echo "<article>";
echo "<section class='entry-content'>";
echo "<h3  style='color:#ff0000;' >".$error."</h3>";

//the_content();
endwhile; 
else :
endif; 
echo "<form id='addform' method = 'post' enctype='multipart/form-data' action='#'>";
echo "<div id = 'add_cat_left_side'>";
echo "<h4><label for = 'cat_name'>Cat's Name: </label></h4>";
echo "<input type = 'input' name = 'cat_name' id = 'cat_name' onkeyup = 'clear_error_msg('cat_name','add_cat_error_msg');' placeholder = 'i.e. Sparkles or Mushy' required />";
echo "<div class='error_msg' id='add_cat_error_msg'></div>";
echo "<label for = 'gender'>  Gender:</label>";
echo "<input type = 'radio' name = 'gender' id = 'gender' value = 'boy' /> Boy";
echo "<input type = 'radio' name = 'gender' id = 'gender' value = 'girl' /> Girl";
echo "</div>";
echo "<div id = 'add_cat_image'>";
echo "<label for = 'cat_image' style='float:left; width:100%'>Upload Cat s Image: (Optional, we will put it on the box!)</label>";
echo "<div class='default_img'><img src = 'http://asiascatcreations.com/wp-content/uploads/2012/12/cat_default_img.jpg' >	</div>";
echo "<input type='file' name='cat_image' id='cat_image' />";       
echo "</div>";
echo "<div id = 'subscription_products'>";
echo "<input type='radio' name='food_type' id='rd1' value='1'> KittenCaboodle [30 days of food]<br />";
echo "<input type='radio' name='food_type' value='2' id='rd2' > ChickenPuddin [Adult Cat Food]<br />";
echo "<input type='radio' name='food_type' value='3' id='rd3' > Skinny Cat [Weight loss food]<br />";
echo "<input type='radio' name='food_type' value='4' id='rd4' > The Mountain [Mature / low energy cats]<br />";
echo "<br />";
echo "<input type='checkbox' name='treat' value='1' /> &nbsp; Add treats for $5!<br /><br />";
echo "</div>";
echo "<input type='submit' name='form_submit_button' class = 'cat_button' value='Add Another Cat' /><br />";
echo "<input type = 'submit' name = 'form_submit_button' class = 'cat_button' value = 'Proceed to Payment' />";
echo "</form>";	

echo "</section>";
echo "</article> ";
echo "</div> ";
get_sidebar();
echo "</div> ";
echo "</div> ";
get_footer();  
}

add_shortcode('show_addcat', 'addcat');


function updatecat($atts)
{ 
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
else{
	$new_entry = array();
	$new_entry['post_title'] = $_POST['cat_name'];
	$new_entry['post_content'] = 'content';
	$new_entry['post_status'] = 'publish';
	$new_entry['post_type'] = 'feline';
	$new_entry['post_author'] = $user_id;

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
	}	
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
global $post;
echo "<div id='content'>";
echo "<div id='inner-content' class='wrap clearfix'>";
echo "<div id='main' class='ninecol first clearfix' role='main'>";
if (have_posts()) : while (have_posts()) : the_post(); 

echo "<article id='post'>";
echo "<h1>Your Cats:</h1>";
echo "<div style = 'width:100%;clear:both;'></div><hr />";
echo "<section class='entry-content'>";
echo "<h3 style='color:#ff0000;'>".$error."</h3>";
the_content();
echo "<form method = 'post' enctype='multipart/form-data'>";
echo "<input type='hidden' value='"?><?php the_author_ID(); ?><?php echo "'name='auther' />"; 
echo "<div id = 'add_cat_left_side'>" ;
echo "<label for = 'cat_name'>Cat s Name:</label>"; 
$catname=get_post_meta($post->ID, 'cat_name', true); 
echo "<input type = 'input' readonly name = 'cat_name' required='required' id = placeholder ='i.e. Sparkles or Mushy' value='".$catname."'/>";
echo "<div class='error_msg' id='add_cat_error_msg'></div>";
echo "<label for = 'gender'> Gender: </label>";
$sex= get_post_meta($post->ID, 'sex', true);
  if($sex=='boy') { $sex=1;} 
  if($sex=='girl'){ $sex=2;}  
echo "<input type = 'radio' name = 'gender' id = 'gender' value = 'boy'"?><?php if($sex==1){ echo "checked='checked'";  } ?> <?php echo "/> Boy";
echo "<input type = 'radio' name = 'gender' id = 'gender' value = 'boy'"?><?php if($sex==2){ echo "checked='checked'";  } ?> <?php echo "/> Girl";
echo "</div>";
echo "<div id = 'add_cat_image'>";
echo "<label for = 'cat_image' style='float:left; width:100%'>Upload Cat s Image: (Optional, we will put it on the box!)</label><div class='default_img'>";
 if ( has_post_thumbnail()) { 
   echo the_post_thumbnail(); 
    } else { 
	echo"<img src = 'http://asiascatcreations.com/wp-content/uploads/2012/12/cat_default_img.jpg' >";
    } 			
echo"</div><input type='file' name='cat_image' id='cat_image' />";
echo"</div>";
echo"<div id = 'subscription_products'>";
$food= get_post_meta($post->ID, 'food_type', true); 
echo"<input type='radio' name='food_type' id='rd1' value='1'"?> <?php if($food==1){ echo "checked='checked'"; } ?> <?php echo "> KittenCaboodle [30 days of food]<br />";
echo"<input type='radio' name='food_type' value='2' id='rd2'"?> <?php if($food==2){ echo "checked='checked'"; } ?> <?php echo "> ChickenPuddin [Adult Cat Food]<br />";
echo"<input type='radio' name='food_type' value='3' id='rd3'"?> <?php if($food==3){ echo "checked='checked'"; } ?> <?php echo "> Skinny Cat [Weight loss food]<br />";
echo"<input type='radio' name='food_type' value='4' id='rd4'"?> <?php if($food==4){ echo "checked='checked'"; } ?> <?php echo "> The Mountain [Mature / low energy cats]<br />";

echo"<br />";
$treat= get_post_meta($post->ID, 'treat', true); 
echo"<input type='checkbox' name='treat' value='1'"?> <?php if($food==1){ echo "checked='checked'"; } ?> <?php echo " /> &nbsp; Add treats for $5!<br /><br />";
        
$suspend= get_post_meta($post->ID, 'suspend', true); 
echo"<input type='checkbox' name='suspend' value='TRUE'" ?><?php if($suspend=="TRUE"){  echo "checked='checked'"; } ?> <?php echo " /> &nbsp; Temporarily Suspend Subscription<br /><br />";
echo"</div>";
echo"<input type='submit' name='form_submit_button' class = 'cat_button' value='Update Cat' /><br />";
echo"<input type = 'submit' name = 'form_submit_button' class = 'cat_button' value = 'Proceed to Payment' />";

echo"</form>";	


 endwhile;
 else : 
 endif; 
echo "</section>"; 
echo "</article>"; 
echo "</div>";
get_sidebar(); 
echo "</div>";
echo "</div>";
get_footer();
}

?>
