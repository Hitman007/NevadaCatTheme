<?php
/*
Template Name: Profile
*/
session_start();
global $current_user;
global $wpdb;
crg_auth_redirect();
get_header();

if (isset($_POST['crg_submit'])){
	echo ("Submission accepted.<br />");
	update_user_meta( $current_user->ID, 'bill_to_first_name', $_POST['crg_fn']);
	update_user_meta( $current_user->ID, 'bill_to_last_name', $_POST['crg_ln']);
	$d = $_POST['crg_dn'];
	$i = $current_user->ID;
	$z = 0;
	$crg_login_email = $current_user->user_email;
	while (($crg_login_email[$z] != null)){
		if ($crg_login_email[$z] == "@"){break;}
		$email_word = $email_word . $crg_login_email[$z];
		++$z;
		}
	if ($d == ""){$d= $email_word;}
	$fn = get_usermeta($current_user->ID,'bill_to_first_name');
	$wpdb->query(
	"
	UPDATE $wpdb->users 
	SET display_name = '$d'
	WHERE ID =  $i
	"
	);
	update_user_meta( $current_user->ID, 'nickname', $d);
	$fn = get_usermeta($current_user->ID,'bill_to_first_name');
	$current_user->display_name = $d;
}
if (isset($_POST['crg_pw2'])){
	if ($_POST['crg_pw2'] == $_POST['crg_pw3']){
		$pw = $_POST['crg_pw2'];
		if (!(($pw == "") || ($pw == NULL))){
			$current_user_ID = $current_user->ID;
			update_user_meta($current_user_ID, 'crg_password', $pw);
			wp_set_password( $pw, $current_user_ID);
		}
	 }else{
		echo ("Error. Passwords do not match.");
	}
}

?>
page -profie
<div id="content">
<div id="inner-content" class="wrap clearfix">
<div id="main" class="ninecol first clearfix" role="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
<header class="article-header">
<h1 class="page-title"><?php the_title(); ?></h1>
</header> <!-- end article header -->
<section class="entry-content">
<?php 
the_content();
?>
<br />
<form method = "post" action = "https://asiascatcreations.com/profile/">
<div class = "ship_to_label">Email:</div>&nbsp;&nbsp;<?php echo $current_user->user_email;?><br /><br />
<div class = "ship_to_label">First Name:&nbsp;&nbsp;</div>
<input class = "ship_to_input" type = "text" name = "crg_fn" id = "crg_fn" value = "<?php echo get_usermeta($current_user->ID,'bill_to_first_name');?>" /><br /><br />
<div class = "ship_to_label">Last Name:&nbsp;&nbsp;</div> <input class = "ship_to_input" type = "text" name = "crg_ln" id = "crg_ln" value = "<?php echo get_usermeta($current_user->ID,'bill_to_last_name');?>" /><br /><br />
<div class = "ship_to_label">Display Name:&nbsp;&nbsp;</div><input class = "ship_to_input" type = "text" name = "crg_dn" id = "crg_dn" value = "<?php echo $current_user->display_name;?>" /><br /><br />
<div class = "ship_to_label">Password:&nbsp;&nbsp;</div><input class = "ship_to_input" type = "password" name = "crg_pw2" id = "crg_pw2"  /><br />
<div class = "ship_to_label">Password (again):&nbsp;&nbsp;</div><input class = "ship_to_input" type = "password" name = "crg_pw3" id = "crg_pw3"  /><br /><br />



<input type = "submit" value = "Submit" id = "crg_submit" name = "crg_submit" />
</form>




							
								
								
								
						    </section> <!-- end article section -->
						
						    <footer class="article-footer">
			
							    <p class="clearfix"><?php the_tags('<span class="tags">Tags: ', ', ', '</span>'); ?></p>
							
						    </footer> <!-- end article footer -->					
					    </article> <!-- end article -->
											    <?php comments_template(); ?>
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
        						    <p><?php _e("This is the error message in the page-custom.php template.", "bonestheme"); ?></p>
        						</footer>
        					</article>
					
					    <?php endif; ?>
			
				    </div> <!-- end #main -->
    				    <?php get_sidebar(); ?>
		    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->
	

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>	
<script>
$(document).ready(function(){
	$('#u_0_3').hide();
</script>		
<?php get_footer(); ?>
