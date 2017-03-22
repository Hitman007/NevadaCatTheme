<?php
/*
Template Name: Promo
*/
session_start();
if ($_GET['promo_action'] == "login"){$_SESSION['crg_login_redirect_url'] = "http://asiascatcreations.com/100dollars/"; crg_auth_redirect();}

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
<?php if (is_user_logged_in()){
	echo ('<h1>Welcome, <a href = "https://asiascatcreations.com/profile/">');
	global $current_user;     
    echo  $current_user->display_name;
    echo ('<img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png"></h1></a>');
}?>
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
<?php the_content();?>
<?php
if (is_user_logged_in() ) {
	echo ("<div class=\"h1like\">Your promo code is:</div><span class = 'robo_text'>&nbsp;&nbsp;&nbsp;bx" . $current_user->ID . "a</span><br /><br /><div class=\"h1like\">Your code status:</div><span class = 'robo_text'>&nbsp;&nbsp;&nbsp;No one has activated your code yet.</span><br /><br />");
 }else{
	echo ("<br /><div class=\"h1like\">Your promo code is:</div><span class = 'robo_text'>&nbsp;&nbsp;&nbsp;<a href = 'https://asiascatcreations.com/100dollars?promo_action=login' />Click Here</a> to login and get a code.</span><br /><br />");
 	
 }
?>
<h4>We can send you some business cards:</h4>
<img src = "http://asiascatcreations.com/wp-content/uploads/2013/04/card_face.jpg" style = "max-width:50%"/>
<br />
<form method = "post" style = "
<?php
if (!(is_user_logged_in())){
	echo ("display: none;");
}
?>
">
<h1>Address:</h1>
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

<input type = "submit" value = "Request Cards" id = "crg_request" name = "crg_request" style = "float:right;" />		</div>
		<div class = "clearfix"></div>
			</form>
<br /><h4>Click a question to see the answer:</h4>
<?php
if ( !(is_user_logged_in() )) {
	echo '<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />How do I get a promo code?</div><div class="answer">Anyone can get a code, and it\'s free. Just <a href = "https://asiascatcreations.com/login/">click here</a>, and we will automatically generate one for you.</div>';
	$_SESSION['crg_login_redirect_url'] = "http://asiascatcreations.com/100dollars/";
}
?>
<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />Why would a customer want to use my code?</div>
<div class="answer">Normally, a subscription costs $59.99. When they use their code, the price drops to only $1 for the first month. There is no obligation to continue, and they can cancel any time on the website. After the first month the price returns to the regular price, and they will be billed normally.</div>

<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />How will the customer know the price is only $1?</div>
<div class="answer">You have to tell them! That's the whole point of this promotion, we pay you money to sell out product. They can enter your promo code in the sidebar, or at the bottom of the "Order Now" page on the website. Once a valid code is entered, the website will show the price details to the customer. We can give you business cards to help out, but you can use any technique you want. Make posts on cat websites, tell your friends who have cats, put up a flyer - whatever!</div>

<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />Do I need to wait for business cards before I use the code?</div>
<div class="answer">No. The cards are just a handy way to pass out your code. What's important is that the person enter your promo code on the website when they purchase a subscription. How they get the code doesn't matter. You can advertise your code any way you want. You can write it on our business cards, write it on a napkin, or just tell them.</div>

<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />Can I get more business cards?</div>
<div class="answer">Yes. Just ask. If you actually make a sale, we'll send you plenty of cards.</div>

<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />Can I use the code more than once?</div>
<div class="answer">Yes. Your code is registered to you. Give it out to as many people as possible (that's the point!). There is no limit to how many subscriptions you can sell, and there is no limit to how much money you can make!</div>

<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />How can I tell if my code is being used?</div>
<div class="answer">You will receive an email when someone uses your code to purchase a subscription. You can also visit this page at any time to check on the status of your subscribers.</div>

<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />How will I get paid?</div>
<div class="answer">You will receive a check in the mail. You will receive $100 for every subscriber that purchases our product for three months (1 month @ $1, then 2 months at the regular price). You may monitor the status of the subscriptions you have sold here, but you don't have to do anything to get paid once you qualify. We will automatically send a check to the address you list.</div>

<div class="question"><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png" />What if I forget my code?</div>
<div class="answer">Just come back to this page.</div>

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