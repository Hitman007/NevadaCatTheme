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

add_action( 'admin_head', 'style_thumbsss' );

function style_thumbsss()

{   

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

				$user_display_name = $user_info->display_name;





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



add_shortcode('acc_price_list', 'acc_price_list');



function acc_price_list(){

$short_code_output = '

<ul>

	<li>1 Cat - $59/month</li>

	<li>2 Cats - $89/month</li>

	<li>Each additional Cat - $30/month</li>

</ul>

<input type = "button" class = "cat_button" id = "order_now" value = "Order Now" />

<script>

jQuery(document).ready(function(){

	jQuery("#order_now").click(function(){

	window.location.href = "/add-cat";

	});

});

</script>

';

return $short_code_output;

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



?>



