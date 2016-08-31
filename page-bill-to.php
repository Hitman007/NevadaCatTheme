<?php
/*
Template Name: Bill to
*/
get_header();
session_start();
?>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<div id="content">
<div id="inner-content" class="wrap clearfix">
<div id="main" role="main">
<?php
global $email_output;
$email_output = "";
global $products;
global $prices;
include ('products_list.php');
global $bill_to_output;
global $products_subtotal;
global $display_name , $user_email;
global $subscription_subtotal;
global $total_4_today;
get_currentuserinfo();
if ((isset($_POST['promo'])) && ($_POST['promo'] != '*optional')){$_SESSION['promo'] = $_POST['promo'];}
if ( ! ($_POST['frmsubmit'] == "stripe")){input_validator();}
add_cat_subscription();
one_time_orders_subtotals();
confirmation_data_output();
$bill_to_output = $bill_to_output . "</div></form>";
stripe_widget();

echo ($bill_to_output);

function input_validator(){

if ($_POST['frmsubmit'] != "addcat"){
	$current_user = wp_get_current_user();
	if ( $_POST['bill_to_first_name'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'bill_to_first_name', $_POST['bill_to_first_name']);}
	if ( $_POST['bill_to_last_name'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'bill_to_last_name', $_POST['bill_to_last_name']);}
	if ( $_POST['bill_to_address1'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'bill_to_address1', $_POST['bill_to_address1']);}
	update_user_meta( $current_user->ID, 'bill_to_address2', $_POST['bill_to_address2']);
	if ( $_POST['bill_to_city'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'bill_to_city', $_POST['bill_to_city']);}
	if ( $_POST['bill_to_state'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'bill_to_state', $_POST['bill_to_state']);}
	if ( $_POST['bill_to_zip'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'bill_to_zip', $_POST['bill_to_zip']);}
	if ( $_POST['bill_to_phone'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'bill_to_phone', $_POST['bill_to_phone']);}
	
	if ( $_POST['ship_to_first_name'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'ship_to_first_name', $_POST['ship_to_first_name']);}
	if ( $_POST['ship_to_last_name'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'ship_to_last_name', $_POST['ship_to_last_name']);}
	if ( $_POST['ship_to_address1'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'ship_to_address1', $_POST['ship_to_address1']);}
	update_user_meta( $current_user->ID, 'ship_to_address2', $_POST['ship_to_address2']);
	if ( $_POST['ship_to_city'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'ship_to_city', $_POST['ship_to_city']);}
	if ( $_POST['ship_to_state'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'ship_to_state', $_POST['ship_to_state']);}
	if ( $_POST['ship_to_zip'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'ship_to_zip', $_POST['ship_to_zip']);}
	if ( $_POST['ship_to_phone'] == "" ){boing();}
	else{update_user_meta( $current_user->ID, 'ship_to_phone', $_POST['ship_to_phone']);}
		
};
}
function one_time_orders_subtotals(){
global $email_output;
global $products;
global $prices;
global $bill_to_output;
global $products_subtotal;
$total_number_of_products = 0;
$total_number_of_products = $total_number_of_products + $_POST['product_9_quantity'] + $_POST['product_10_quantity'] + $_POST['product_11_quantity'] + $_POST['product_12_quantity'] + $_POST['product_13_quantity'];
$products_subtotal = 0;
if ($total_number_of_products > 0){
	$bill_to_output = $bill_to_output . "<h1>Products:</h1>";
	if ($_POST['product_9_quantity'] > 0){
		$bill_to_output = $bill_to_output . "<input type = \"hidden\" name  = \"product_9_quantity\" value = \"" . $_POST['product_9_quantity'] . "\" />" . $products[9] . "(" . $_POST['product_9_quantity'] . ")....... $" . ($_POST['product_9_quantity'] * $prices[9] . "<br />");
		$email_output = $email_output . $products[9] . "(" . $_POST['product_9_quantity'] . ")....... $" . ($_POST['product_9_quantity'] * $prices[9] . "<br />");
		$products_subtotal = $products_subtotal + ($_POST['product_9_quantity'] * $prices[9]);
	}
	if ($_POST['product_10_quantity'] > 0){
		$bill_to_output = $bill_to_output . "<input type = \"hidden\" name  = \"product_10_quantity\" value = \"" . $_POST['product_10_quantity'] . "\" />". $products[10] . "(" . $_POST['product_10_quantity'] . ")....... $" . ($_POST['product_10_quantity'] * $prices[10]. "<br />");
		$email_output = $email_output . $products[10] . "(" . $_POST['product_10_quantity'] . ")....... $" . ($_POST['product_10_quantity'] * $prices[10]. "<br />");

		$products_subtotal = $products_subtotal + ($_POST['product_10_quantity'] * $prices[10]);
	}
	if ($_POST['product_11_quantity'] > 0){
		$bill_to_output = $bill_to_output . "<input type = \"hidden\" name  = \"product_11_quantity\" value = \"" . $_POST['product_11_quantity'] . "\" />". $products[11] . "(" . $_POST['product_11_quantity'] . ")....... $" . ($_POST['product_11_quantity'] * $prices[11]. "<br />");
		$email_output = $email_output . $products[11] . "(" . $_POST['product_11_quantity'] . ")....... $" . ($_POST['product_11_quantity'] * $prices[11]. "<br />");	
		$products_subtotal = $products_subtotal + ($_POST['product_11_quantity'] * $prices[11]);
	}
	if ($_POST['product_12_quantity'] > 0){
		$email_output = $email_output . $products[12] . "(" . $_POST['product_12_quantity'] . ")....... $" . ($_POST['product_12_quantity'] * $prices[12]. "<br />");
		$bill_to_output = $bill_to_output . "<input type = \"hidden\" name  = \"product_12_quantity\" value = \"" . $_POST['product_12_quantity'] . "\" />". $products[12] . "(" . $_POST['product_12_quantity'] . ")....... $" . ($_POST['product_12_quantity'] * $prices[12]. "<br />");
		$products_subtotal = $products_subtotal + ($_POST['product_12_quantity'] * $prices[12]);
	}
	if ($_POST['product_13_quantity'] > 0){
		$bill_to_output = $bill_to_output . "<input type = \"hidden\" name  = \"product_13_quantity\" value = \"" . $_POST['product_13_quantity'] . "\" />". $products[13] . "(" . $_POST['product_13_quantity'] . ")....... $" . ($_POST['product_13_quantity'] * $prices[13]. "<br /><br />");
		$email_output = $email_output . $products[13] . "(" . $_POST['product_13_quantity'] . ")....... $" . ($_POST['product_13_quantity'] * $prices[13]. "<br /><br />");
		$products_subtotal = $products_subtotal + ($_POST['product_13_quantity'] * $prices[13]);
	}
	$bill_to_output = $bill_to_output . "Subtotal: $" . $products_subtotal . "<br /><br />";	
}
};

function confirmation_data_output(){
	global $bill_to_output;
	global $products_subtotal;
	global $subscription_subtotal;
	global $total_4_today;
	global 	$email_output;
	$x = "<form action = \"https://asiascatcreations.com/order-now/\" method = \"post\"><div class = \"form_section\">
	<div class = \"half_form_section_left\"><h1>Bill to:</h1>" . $_POST['bill_to_first_name'] . "&nbsp;" . $_POST['bill_to_last_name'] . "<br />" . $_POST['bill_to_address1'] . "<br />";
	if($_POST['bill_to_address2'] != ""){$x = $x . $_POST['bill_to_address2']. "<br />";}
	$x = $x . $_POST['bill_to_city'] . ", " . $_POST['bill_to_state'] . " " . $_POST['bill_to_zip']. "<br />" . $_POST['bill_to_phone']."" . "</div><div class = \"half_form_section_right\"><h1>Ship to:</h1>" . $_POST['ship_to_first_name'] . "&nbsp;" . $_POST['ship_to_last_name'] . "<br />" . $_POST['ship_to_address1'] . "<br />";
	if($_POST['ship_to_address2'] != ""){$x = $x . $_POST['ship_to_address2']. "<br />";}
	$x = $x . $_POST['ship_to_city'] . ", " . $_POST['ship_to_state'] . " " . $_POST['ship_to_zip']. "<br />" . $_POST['ship_to_phone'] . "</div><div class = \"clearfix\"></div>";
	$x = $x . $bill_to_output;
	$total_4_today = $products_subtotal + $subscription_subtotal;
	$x = $x . "<h1>Total: $" . $total_4_today . "</h1><input type = \"submit\" value = \"Edit Order\" /><br /><br />";
	$bill_to_output = $x;
	
	$email_output = $email_output . "Bill to:<br />" . $_POST['bill_to_first_name'] . "&nbsp;" . $_POST['bill_to_last_name'] . "<br />" . $_POST['bill_to_address1'] . "<br />";
	if($_POST['bill_to_address2'] != ""){$email_output = $email_output . $_POST['bill_to_address2']. "<br />";}
	$email_output = $email_output . $_POST['bill_to_city'] . ", " . $_POST['bill_to_state'] . " " . $_POST['bill_to_zip']. "<br />" . $_POST['bill_to_phone']."" . "<br /><br />Ship to:</br>" . $_POST['ship_to_first_name'] . "&nbsp;" . $_POST['ship_to_last_name'] . "<br />" . $_POST['ship_to_address1'] . "<br />";
	if($_POST['ship_to_address2'] != ""){$email_output = $email_output . $_POST['ship_to_address2']. "<br />";}
	$email_output = $email_output . $_POST['ship_to_city'] . ", " . $_POST['ship_to_state'] . " " . $_POST['ship_to_zip']. "<br />" . $_POST['ship_to_phone'];
	$total_4_today = $products_subtotal + $subscription_subtotal;
	$email_output = $email_output . "<br />Total: $" . $total_4_today . "</br><br />";
	};

function add_cat_subscription(){
global $email_output;
global $prices;
global $current_user;
global $products;
global $subscription_subtotal;
global $bill_to_output;
if($_POST["cat_name"]!="" && $_POST["food_type"]!="" ){
		if($_POST["treat"]==1){$productid = $_POST["food_type"] + 4 ;}
		else{$productid = $_POST["food_type"];}
	$today = date("j");
	if($today > 28){$today = 1 ;}
	$day = $today . "th";
	if($today==21){$day="21st";}
	if($today==1){$day="1st";}
	if($today==2){$day="2nd";}
	if($today==22){$day="22nd";}
	if($today==23){$day="23rd";}
	if($today==3){$day="3rd";}
	$title = $_POST['cat_name'] . " subscribes to " . $products[$productid] . ". Ships on the ".$day." of the month.";
	// Create post object
	$my_post = array(
	  'post_title'    => $title,
	  'post_content'  => $title,
	  'product'   => $productid,
	  'post_status'   => 'publish',
	  'post_author'   => $current_user->ID,
	  'post_type' => 'custom_type'
	);
	// Insert the post into the database
	$lastid = wp_insert_post( $my_post );
	$update_post="update `wp_posts` set product='".$productid."' where ID='".$lastid."'";
	mysql_query($update_post);
	$update_status="update `wp_posts` set paid_first='FALSE' where ID='".$lastid."'";
	mysql_query($update_status);
	add_post_meta($lastid,'sex',$_POST["gender"]); 
	add_post_meta($lastid,'cat_weight',$_POST["cat_weight"]); 
	add_post_meta($lastid,'paid_first','FALSE'); 
	add_post_meta($lastid,'cat_name',$_POST["cat_name"]); 
	add_post_meta($lastid,'product',$productid);
	if($_FILES["cat_image"]["name"]!=""){
	    if (!function_exists('wp_generate_attachment_metadata')){
			require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			require_once(ABSPATH . "wp-admin" . '/includes/file.php');
			require_once(ABSPATH . "wp-admin" . '/includes/media.php');
            }
            if ($_FILES) {
                foreach ($_FILES as $file => $array) {
                    if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                        return "upload error : " . $_FILES[$file]['error'];
                    }
                    $attach_id = media_handle_upload( $file, $new_post );
                }   
            }
            if ($attach_id > 0){
                //and if you want to set that image as Post  then use:
                update_post_meta($lastid,'_thumbnail_id',$attach_id);
            }
	}		

	if ($_POST['frmsubmit'] == "addcat"){nice_boing();};
}
//get $unpaid_subscriptions
$args = array('author'=> $current_user->ID,'post_type'=>'custom_type');
query_posts($args);
$total_subscriptions = 0;
while ( have_posts() ) : the_post();
	++$total_subscriptions;
endwhile;
wp_reset_query();
$args = array(
	'meta_key'=>'paid_first',
    'meta_value'=>'FALSE',
    'author'=> $current_user->ID,
    'post_type'=>'custom_type'
);
query_posts($args);
$unpaid_subscriptions = 0;
while ( have_posts() ) : the_post();
	++$unpaid_subscriptions;
endwhile;
wp_reset_query();
if ($unpaid_subscriptions > 0){
	$price_offset = $paid_subscriptions - $unpaid_subscriptions;
	$bill_to_output = $bill_to_output . "<h1>Subscriptions:</h1>";
	$args = array(
		'meta_key'=>'paid_first',
		'meta_value'=>'FALSE',
		'author'=> $current_user->ID,
		'post_type'=>'custom_type'
	);
	query_posts($args);
	$usc = 14;
	while ( have_posts() ) : the_post();
		$bill_to_output = $bill_to_output . get_the_title();
		$email_output = $email_output . get_the_title();
		$mystring = get_the_title();
		$findme   = 'Treats';
		$pos = strpos($mystring, $findme);
		if ($pos === false){$treats_addition = 0;}
		  else {$treats_addition = $prices[18];}
		$bill_to_output = $bill_to_output . "....... $";
		$email_output = $email_output . "....... $";
		if ($usc > 17){$usc = 17;}
		$bill_to_output = $bill_to_output . ($prices[$usc] + $treats_addition);
		$email_output = $email_output . ($prices[$usc] + $treats_addition);
		$subscription_subtotal = $subscription_subtotal + ($prices[$usc] + $treats_addition);
		++$usc;		
		$bill_to_output = $bill_to_output .	"<br />";
		$email_output = $email_output .	"<br />";
	endwhile;
	$bill_to_output = $bill_to_output .	"<br />Subscription subtotal (repeats every month)....... $". $subscription_subtotal . "<br />";
	$email_output = $email_output .	"<br />Subscription subtotal (repeats every month)....... $". $subscription_subtotal . "<br />";
	
	
	$c = strtoupper ( $_SESSION['promo']);
	$cc = $c[0] . $c[1];
	if ( (($cc == "AA") && ( (  $c[6] == null) && ($c[5] != null)     ) ) || ($cc = "BX" && ($c[3] == "a" || $c[3] == "A" || $c[4] == "a" || $c[4] == "A" || $c[5] == "a" || $c[5] == "A") ) || ($cc = "ZV" && ($c[3] == "v" || $c[3] == "V" || $c[4] == "v" || $c[4] == "V" || $c[5] == "v" || $c[5] == "V")     )){
		//promo code "A" in the middle.
		$bill_to_output = $bill_to_output . "30 days for $1 promotion....... -$" . ($subscription_subtotal - 1) . "<br />";
		$email_output = $email_output . "30 days for $1 promotion....... -$" . ($subscription_subtotal - 1) . "<br />";
		$subscription_subtotal = 1;
	}
	wp_reset_query();
	}
};

function boing(){
	//there is an error. Return to the order page.
	header("location:http://asiascatcreations.com/order-now/");
	unset($_SESSION['product_9_quantity']);
	unset ($_SESSION['product_10_quantity']);
	unset ($_SESSION['product_11_quantity']);
	unset ($_SESSION['product_12_quantity']); 
	unset ($_SESSION['product_13_quantity']);
	die();
}

function nice_boing(){
	//returns while preserving 1 time order quantities. 
	$_SESSION['product_9_quantity'] = $_POST['product_9_quantity'];
	$_SESSION['product_10_quantity'] = $_POST['product_10_quantity'];
	$_SESSION['product_11_quantity'] = $_POST['product_11_quantity'];
	$_SESSION['product_12_quantity'] = $_POST['product_12_quantity'];
	$_SESSION['product_13_quantity'] = $_POST['product_13_quantity'];
	header("location:http://asiascatcreations.com/order-now/");
	die();
}

function stripe_widget(){
global $products_subtotal;
global $bill_to_output;
global $display_name, $user_email, $email_output;
global $total_4_today;
require_once ('library/stripe-php-1.7.15/lib/Stripe.php');
$total_4_today = $total_4_today * 100;
if ($total_4_today == 0){boing();}
if (isset($_POST['stripeToken'])){
	// Set your secret key: remember to change this to your live secret key in production
	// See your keys here https://manage.stripe.com/account
	Stripe::setApiKey("sk_live_nvTKxBvyjWJUbmmWY2raYVqN");
	// Get the credit card details submitted by the form
	$token = $_POST['stripeToken'];
	// Create the charge on Stripe's servers - this will charge the user's card
	try {
		$customer = Stripe_Customer::create(array(
			"card" => $token,
			"description" => $user_email)
		);

Stripe_Charge::create(array(
  "amount" => $total_4_today,
  "currency" => "usd",
  "customer" => $customer->id)
);

}
	
catch(Stripe_CardError $e) {
	// The card has been declined
	echo "Your card was declined.";die();
	}
	header("Location: http://asiascatcreations.com/thank-you/");
	$user_email = "support@asiascatcreations.com";
	$headers = 'Content-type: text/html';
	$message  = $_POST['email_output'];
	$message = $message . "Promo code: " . $_SESSION['promo'];
	$message = $message . " Referring URL: " . $_SESSION["origURL"];
	$subject = "A new order on Asia's Cat Creations";
    wp_mail($user_email, $subject, $message,$headers);  
	die();
}
$bill_to_output = $bill_to_output . '
	<form action = "https://asiascatcreations.com/order-now/payment/" method="POST" id="payment-form" class = "form_section">
	<h1>Credit/Debit Information:</h1>
	<span id="payment-errors"></span>
	<div class="form-row" style="clear:both;">
	<div style="width:250px; float:left; margin-bottom:10px;">
		<label>Card Number</label>
	</div>
		<input type="text" size="20" autocomplete="off" class="card-number" data-stripe="number"/>
    </div>
	<div class="form-row"  style="clear:both;">
	<div style="width:250px; float:left; margin-bottom:10px;">
    <label>CVC</label>
    </div>
    <input type="text" size="4" autocomplete="off" class="card-cvc" data-stripe="cvc"/>
    </div>
          <div class="form-row"  style="margin-bottom:10px; clear:both;">
          
            <div style="width:250px; float:left; margin-bottom:10px;">
              <label>Expiration (MM/YYYY)</label>
            </div>
            <input type="text" size="2" class="card-expiry-month" data-stripe="exp-month"/>
            <span> / </span>
            <input type="text" size="4" class="card-expiry-year" data-stripe="exp-year"/>
          </div>
          <input type = "hidden" id = "frmsubmit" name = "frmsubmit" value = "stripe" />
		  <br/>
		  You are about to be charged $' . ($total_4_today/100) . '<br />
          <button type="button" id = "stripe_submit" >Submit Payment</button>
          <br />
          <br />';

	$bill_to_output = $bill_to_output . "<input type = \"hidden\" id = \"email_output\" name = \"email_output\" value = \"" . $email_output . "\" />";

	$bill_to_output = $bill_to_output . "<input type = \"hidden\" id = \"product_9_quantity\" value = \"";
	$bill_to_output = $bill_to_output . $_POST['product_9_quantity'];
	$bill_to_output = $bill_to_output . "\" name = \"product_9_quantity\" /><input type = \"hidden\" name = \"product_10_quantity\" value = \"";
	$bill_to_output = $bill_to_output . $_POST['product_10_quantity'];
	$bill_to_output = $bill_to_output . "\" /><input type = \"hidden\" name = \"product_11_quantity\" value = \"" . $_POST['product_11_quantity'] . "\" /><input type = \"hidden\" name = \"product_12_quantity\" value = \"" . $_POST['product_12_quantity'] . "\" /><input type = \"hidden\" name = \"product_13_quantity\" value = \"" . $_POST['product_13_quantity'] . "\" /> </form>"; 
		  
}


		  
?>
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script type="text/javascript">
	Stripe.setPublishableKey('pk_live_kCPNxVitTfPyDMUlPC7qUuJj');
    var stripeResponseHandler = function(status, response) {
    var $form = $(this);
    if (response.error) {
      // Show the errors on the form
      $('#payment-errors').text(response.error.message);
    } else {
	 // token contains id, last4, and card type
      var token = response.id;
      // Insert the token into the form so it gets submitted to the server
      $('#payment-form').append($('<input type="hidden" name="stripeToken" />').val(token));
      // and re-submit
      $('#payment-form').submit();
    }
	}; 
	
$(document).ready(function() {
  $('#stripe_submit').click(function() {
	var $form = $('#payment-form');
    Stripe.createToken($form, stripeResponseHandler);
	return false;
  });
});




</script>
</div> <!-- end #main -->  
</div> <!-- end #inner-content -->
</div> <!-- end #content -->
<?php 
get_footer();
?>