<?php
/*
Template Name: affiliate
*/
session_start();
if ($_GET['promo_action'] == "login"){$_SESSION['crg_login_redirect_url'] = "http://asiascatcreations.com/affiliate/"; crg_auth_redirect();}

if (isset($_POST['bill_to_first_name'])){
	update_user_meta( $current_user->ID, 'bill_to_first_name', $_POST['bill_to_first_name']);
	update_user_meta( $current_user->ID, 'bill_to_last_name', $_POST['bill_to_last_name']);
	update_user_meta( $current_user->ID, 'bill_to_address1', $_POST['bill_to_address1']);
	update_user_meta( $current_user->ID, 'bill_to_address2', $_POST['bill_to_address2']);
	update_user_meta( $current_user->ID, 'bill_to_zip', $_POST['bill_to_zip']);
	update_user_meta( $current_user->ID, 'bill_to_state', $_POST['bill_to_state']);
	update_user_meta( $current_user->ID, 'bill_to_phone', $_POST['bill_to_phone']);
	update_user_meta( $current_user->ID, 'bill_to_city', $_POST['bill_to_city']);
	update_user_meta( $current_user->ID, 'is_promoter', 'TRUE');

}
?>

<?php get_header(); ?>
<div id="content">
<div id="inner-content" class="wrap clearfix">
<div id="main" class="ninecol first clearfix" role="main">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">
<header class="article-header">
<h1 class="page-title"><?php the_title(); ?></h1>
<?php
if (!(is_user_logged_in())){
	$_SESSION['crg_login_redirect_url'] = "http://asiascatcreations.com/affiliate/";
	echo ("<br /><a href = 'https://asiascatcreations.com/login/'>Click Here</a> to login and register a site.");
}
?>
</header> <!-- end article header -->
<?php
if (isset($_POST['crg_request']) ){
	echo ("<span class = 'robo_text'>Your request has been received.</span><br />");
	$user_email = "support@asiascatcreations.com";
	$subject = "Cards have been requested.";
	$headers = 'Content-type: text/html';
	$message  = "FN: " . $_POST['bill_to_first_name'] . "<br />LN: " . $_POST['bill_to_last_name']. "<br />addy1: ". $_POST['bill_to_address1']. "<br />addy2: " . $_POST['bill_to_address2'] . "<br />city: " . $_POST['bill_to_city'] . "<br />state: " . $_POST['bill_to_state'] . "<br />zip: " . $_POST['bill_to_zip'] . "<br />phone: " . $_POST['bill_to_phone'] . "<br />Code: zx" . $current_user->ID . "v" . "<br/>Email: " . $current_user->user_email;
    wp_mail($user_email, $subject, $message,$headers);  
}
?>
 <section class="entry-content">
<?php 
the_content();

?>

<form method = "post" style = "

<?php
if (!(is_user_logged_in())){
	echo ("display: none;");
}?>">

<br /><h4>Websites you have registered:</h4>
<span class = "robo_text">You have not registered any sites.</span>
<br />
<br /><h4>Enter a domain to register:</h4>
<input type = "text" name = "crg_register_domain" /><br />
<input type = "submit" value = "Register" id = "crg_request" name = "crg_request" />
<br /><br />
<h4>Address:</h4>
<div class = "half_form_section_left">
<div class = "ship_to_label"><label for = "bill_to_first_name">First Name:</label></div>
<input type = "input" class = "ship_to_input" name = "bill_to_first_name" id = "bill_to_first_name" value="<?php echo get_usermeta($current_user->ID,'bill_to_first_name');?>" onkeyup="clear_error_msg('bill_to_first_name','bill_to_first_name_error_msg');" />
		<div id = "bill_to_first_name_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_first_name_error_msg); ?></div>
		<br/>
		<div class = "clearfix"></div>
		<div class = "ship_to_label"><label for = "bill_to_last_name">Last Name:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_last_name" id = "bill_to_last_name" value="<?php echo get_usermeta($current_user->ID,'bill_to_last_name');?>" onkeypress="clear_error_msg('bill_to_last_name','bill_to_last_name_error_msg');" />
			<div id = "bill_to_last_name_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_last_name_error_msg); ?></div>
		<br/>		<div class = "clearfix"></div>
		<div class = "ship_to_label"><label for = "bill_to_address1">Address:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_address1" id = "bill_to_address1" value="<?php echo get_usermeta($current_user->ID,'bill_to_address1'); ?>" onkeypress="clear_error_msg('bill_to_address1','bill_to_address1_error_msg');" />
		<br/>		<div class = "clearfix"></div>
		<div class = "ship_to_label">&nbsp;</div>
			<input type = "input"class = "ship_to_input" name = "bill_to_address2" id = "bill_to_address2" value="<?php echo get_usermeta($current_user->ID,'bill_to_address2'); ?>" onkeypress="clear_error_msg('bill_to_address2','bill_to_address2_error_msg');" />
			<div id = "bill_to_address_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_address_error_msg); ?></div>		                
			<br/><div class = "clearfix"></div><div class = "ship_to_label"><label for = "bill_to_city">City:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_city" id = "bill_to_city" value="<?php echo get_usermeta($current_user->ID,'bill_to_city'); ?>" onkeypress="clear_error_msg('bill_to_city','bill_to_city_error_msg');"  />
			<div id = "bill_to_city_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_city_error_msg); ?></div>
		<br/>		<div class = "clearfix"></div><div class = "ship_to_label"><label for = "bill_to_state">State:</label></div><?php $states = array('AL'=>"AL",'AK'=>"AK",'AZ'=>"AZ",'AR'=>"AR",'CA'=>"CA",'CO'=>"CO",'CT'=>"CT",'DE'=>"DE",'DC'=>"DC",'FL'=>"FL",'GA'=>"GA",'HI'=>"HI",'ID'=>"ID",'IL'=>"IL",  'IN'=>"IN",'IA'=>"IA",  'KS'=>"KS",  'KY'=>"KY",  'LA'=>"LA",  'ME'=>"ME",  'MD'=>"MD",  'MA'=>"MA",  'MI'=>"MI",  'MN'=>"MN",  'MS'=>"MS",  'MO'=>"MO",  'MT'=>"MT",'NE'=>"NE",'NV'=>"NV",'NH'=>"NH",'NJ'=>"NJ",'NM'=>"NM",'NY'=>"NY",'NC'=>"NC",'ND'=>"ND",'OH'=>"OH",  'OK'=>"OK",  'OR'=>"OR",  'PA'=>"PA",'PR'=>"PR",  'RI'=>"RI",  'SC'=>"SC",  'SD'=>"SD",'TN'=>"TN",  'TX'=>"TX",  'UT'=>"UT",  'VT'=>"VT",  'VA'=>"VA",  'WA'=>"WA",  'WV'=>"WV",  'WI'=>"WI",  'WY'=>"WY");?>
		<select name = "bill_to_state" id = "bill_to_state" class = "ship_to_input" onchange="clear_error_msg('bill_to_state','bill_to_state_error_msg');">
		<option value="">Choose State</option>
		<?php foreach ($states as $code => $state){	?>
		     <option value="<?php echo $code?>" <?php if($code==get_usermeta($current_user->ID,'bill_to_state')) { echo "selected"; } ?>><?php echo $state?></option>
			<?php } ?>
		</select>
			<!--<input type = "input" class = "ship_to_input" name = "bill_to_state" id = "bill_to_state" value="<?php echo get_usermeta($current_user->ID,'bill_to_state'); ?>" onkeypress="clear_error_msg('bill_to_state','bill_to_state_error_msg');"  />-->
			<div id = "bill_to_state_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_state_error_msg); ?></div>
				<div class = "clearfix"></div><div class = "ship_to_label"><label for = "bill_to_zip">Zip:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_zip" id = "bill_to_zip"  value="<?php echo get_usermeta($current_user->ID,'bill_to_zip'); ?>"onkeypress="clear_error_msg('bill_to_zip','bill_to_zip_error_msg');" />
			<div id = "bill_to_zip_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_zip_error_msg); ?></div>
				<div class = "clearfix"></div><div class = "ship_to_label"><label for = "bill_to_city">Phone:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_phone" id = "bill_to_phone" value="<?php echo get_usermeta($current_user->ID,'bill_to_phone'); ?>" onkeypress="clear_error_msg('bill_to_phone','bill_to_phone_error_msg');"  />
			<div id = "bill_to_phone_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_phone_error_msg);?></div>

<input type = "submit" value = "Submit" id = "crg_request" name = "crg_request" style = "float:right;" />		</div>
		<div class = "clearfix"></div>
			</form>
<br /><h4>Click a question to see the answer:</h4>

<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />How can I become an affiliate</div><div class="answer">Anyone with a website can become an affiliate. It's 100% free to setup, you just need to be willing to run our advertizement on your site. Simply fill out the form on this page, put the banner on your site, and we'll send you a check for $100 when someone buys a subscription after having been refered from you site.</div>
<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />How and when do I get paid?</div>
<div class="answer">We will send a check for $100 to the name and adress you list here. Your check will ship with 24 hours of the customer paying for the second month. They must not cancel before the second month for you to get paid.</div>
<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />How can you tell which website refered the customer?</div>
<div class="answer">When you access Our site, we record the "referring website", which means the site the site you visited right before you came here. For instance, you came from:
<div class = "robo_text"><?php
echo ($_SESSION['origin_url']);
?></div>

</div>

<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />What if I have any questions?</div>
<div class="answer">You can <a href = "http://asiascatcreations.com/contact/">contact us</a>, or use the form at the bottom of the page. We will respond within 24 hours.</div>

			
			
			



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
	
			
			
<?php get_footer(); ?>