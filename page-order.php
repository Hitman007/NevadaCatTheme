<?php
/*
Template Name: Order Form
*/
//re-direct to login page if not logged in.
session_start();

//This checks to see if the user is logged in. If not, goes to the login page.
crg_auth_redirect();

//Allows the user to delete a subscription
if(isset($_GET["crg_delete"])){
	$id = $_GET["crg_delete"] ;	
	wp_delete_post($id);	
}

//loads product list
global $products;
global $prices;
include ('products_list.php');

get_header();
?>
<div id="content">

<div id="inner-content" class="wrap clearfix">
<div id="main" role="main">
<!-- ORDER FORM -->
<!-- CAT SUBSCRIPTION SERVICE -->
<form method="post" id="payment-form" enctype="multipart/form-data" action = "https://asiascatcreations.com/order-now/payment/">

<div id = "welcome_back_div" class = "form_section" style="display:<?php echo $welcome_back_div_display ?>">
	<?php get_currentuserinfo(); ?>
	<h1>Welcome, <a href = "https://asiascatcreations.com/profile/" target = "_BLANK"><?php global $current_user;     
      echo  $current_user->display_name;
      ?><img src = "https://asiascatcreations.com/wp-content/uploads/2013/04/info-icon.png"></a>
</h1>On this page you can place a one time order, and you can start or stop a monthly subscription.
<br /><br />
</div>

<div class = "form_section" id = "subscriptions_form_section">
<?php
$type = 'custom_type';
$args=array('post_type' => $type);
$subscription_total = 0;
$my_query = null;
$my_query = new WP_Query($args);
$subscription_count = 13;
if( $my_query->have_posts() ) {
	while ($my_query->have_posts()) : $my_query->the_post(); 
		$user_id = get_the_author_ID();
		if($user_id==$current_user->ID){
			$subscription_count = $subscription_count + 1;
			if ($subscription_count == 17){$subscription_count = 16;}
			$post_id = get_the_ID() ;
			$sel_paid_first="SELECT meta_value FROM wp_postmeta where post_id='".$post_id."' AND meta_key='paid_first'";
			$rs_paid_first=mysql_query($sel_paid_first);
			$paid_first = mysql_fetch_array($rs_paid_first);
			$sel_product="SELECT meta_value FROM wp_postmeta where post_id='".$post_id."' AND meta_key='product'";
			$rs_product=mysql_query($sel_product);
			$products = mysql_fetch_array($rs_product);  
			$product = $products["meta_value"];
			if($paid_first["meta_value"]=='FALSE'){
				$subscription_total = $subscription_total + $prices[$subscription_count];
				if ($product == 5){$subscription_total = $subscription_total + 5;}
				if ($product == 6){$subscription_total = $subscription_total + 5;}
				if ($product == 7){$subscription_total = $subscription_total + 5;}
				if ($product == 8){$subscription_total = $subscription_total + 5;}
			}
		}
	endwhile;
}
// Restore global post data stopped by the_post().
wp_reset_query(); 
?>

<h1 id = "subscription_div_title">Add a New Subscription for only, $<?php echo ($prices[($subscription_count + 1)]);?>/mo:</h1>
<div id = "promo_explanation"></div>
<div id = "subscriptions_activator_div">It's less than $2 a day for perr-fect feline nutrition! Subscritptions have enough food for 30 days, arrive once a month, and continue every month until cancelled. The regular price is $59.99 a month. Your second cat is $29.99 a month. Then additional cats are only $24.99 a month each.<br /><br /><input type = "button" id = "show_subscriptions_area_button" value = "Click here to add a new subscription" style="float:right;" /><br /><br />

</div>

<div id = "hidden_subscriptions_area">
<label for = "cat_name">Cat's Name: (i.e. "Fluffy" or "Mushy")</label>
<input type="input" autocomplete="off" name="cat_name" id="cat_name" onkeyup="clear_error_msg('cat_name','add_cat_error_msg');" />&nbsp; <span class="ship_to_error_msg" id="add_cat_error_msg"></span>
        Gender: <select name="gender" id="gender">
        <option value="MALE">Male</option>
        <option value="FEMALE">Female</option>
        </select>
<br/><br />
<label for = "cat_image"></label>
<input type="file" name="cat_image" id="cat_image" />
        <br /><br />
		<?php
		$cat_weight = array('Kitten'=>"Kitten",'Small'=>"Small (6-9 lbs.)",'Medium'=>"Medium (9-12 lbs.)",'Large'=>"Large (12+ lbs.)");
		?>
		<label for = "cat_weight">Cat's Weight: </label>
		<select name = "cat_weight" id = "cat_weight">
			<option value="Choose Cat Weight">Choose Cat Weight</option>
			<?php foreach ($cat_weight as $codes => $weight){	?>
			     <option value="<?php echo $codes?>"  <?php if($codes==get_usermeta($current_user->ID,'cat_weight')) { echo "selected"; } ?>><?php echo $weight?></option>
 			<?php } ?>
	
			</select>
			<span class="ship_to_error_msg" id="add_cat_error_msg3"></span>
        <br /><br />
		<div id = "subscription_products">
        <input type="radio" name="food_type" id="rd1" value="1"> KittenCaboodle [30 days of food]<br />
		<input type="radio" name="food_type" value="2" id="rd2" > ChickenPuddin [Adult Cat Food]<br />
		<input type="radio" name="food_type" value="3" id="rd3" > Skinny Cat [Weight loss food]<br />
        <input type="radio" name="food_type" value="4" id="rd4" > The Mountain [Mature / low energy cats]<br />
        &nbsp; <span class="ship_to_error_msg" id="add_cat_error_msg2"></span>
        <br />
		<input type="checkbox" name="treat" value="1" /> &nbsp; Add treats for $5!<br /><br />
		</div>
		<input type="submit" id = "addcat" name="addcat" value="Add Cat" /><br /><br />
        <input type="hidden" name="frmsubmit" id="frmsubmit" value="" />
</div>
        <div id = "subscription_total_div"><h1>Sub Total:$<span id="subscription_total"><?
        if($subscription_total>0){
            $unpadded_s = round($subscription_total, 2);
            $padded_s = sprintf('%0.2f', $unpadded_s);
			echo $padded_s;
		}else{
			echo ("<style>#subscription_total_div {display: none;}</style>");
		}
		?></span></h1>
		</div>
<?php
$type = 'custom_type';
$args=array('post_type' => $type);
$subscription_total = 0;
$my_query = null;
$my_query = new WP_Query($args);
$subscription_count = 13;
if( $my_query->have_posts() ) {
	while ($my_query->have_posts()) : $my_query->the_post(); 
		$user_id = get_the_author_ID();
		if($user_id==$current_user->ID){
			$subscription_count = $subscription_count + 1;
			if ($subscription_count == 17){$subscription_count = 16;}
			$post_id = get_the_ID() ;
			$sel_paid_first="SELECT meta_value FROM wp_postmeta where post_id='".$post_id."' AND meta_key='paid_first'";
			$rs_paid_first=mysql_query($sel_paid_first);
			$paid_first = mysql_fetch_array($rs_paid_first);
			$sel_product="SELECT meta_value FROM wp_postmeta where post_id='".$post_id."' AND meta_key='product'";
			$rs_product=mysql_query($sel_product);
			$products = mysql_fetch_array($rs_product);  
			$product = $products["meta_value"];
			if($paid_first["meta_value"]=='FALSE'){
				$subscription_total = $subscription_total + $prices[$subscription_count];
				if ($product == 5){$subscription_total = $subscription_total + 5;}
				if ($product == 6){$subscription_total = $subscription_total + 5;}
				if ($product == 7){$subscription_total = $subscription_total + 5;}
				if ($product == 8){$subscription_total = $subscription_total + 5;}
			}
			$feat_image = wp_get_attachment_url(get_post_thumbnail_id($my_query->ID));
			if($feat_image==""){$feat_image = 'https://asiascatcreations.com/wp-content/uploads/2012/12/cat_default_img.jpg';}
			echo ('<div id = "subscription_roll"><img src ="');
			echo $feat_image;
			echo ('" class = "subscription_roll_img" /> &nbsp; <span class ="subscription_roll_text1">');
			the_title();
			echo ('</span> <a href="?crg_delete=');
			echo the_ID();
			echo ('" onclick="return confirm(\'Are you sure you want to cancel this subscription?\')">Cancel</a></div>');
		}
	endwhile;
}
// Restore global post data stopped by the_post().
wp_reset_query(); 
?>
</div>


<!--ONE TIME ORDERS -->
<div id = "one_time" class = "form_section" >
	<div id = "user_display_name">
		<h1>One time orders, $<?php include ('products_list.php');echo ($prices[10]);?> each:</h1>
	</div>
	<input type = "button" id = "show_one_time" value = "Click here to place a one time order" style = "float:right;" /><br /><br />
	<div id = "one_time_text" style = "display:none;">
	<table>
			<tr><td></td><td></td><td><span id = "price_label">Price:</span></td></tr>
				<td><?php echo ($products[9]);?> [Lasts approx. 2 weeks per kitten]</td>
				<td><span class = "quantity">&nbsp;&nbsp;Quantity</span><input type = "input" size = "2" name = "product_9_quantity" id = "product_9_quantity" class = "product_quantity" value="
<?php
if (isset($_POST['product_9_quantity'])){
	echo $_POST['product_9_quantity'];
}else{
	echo $_SESSION['product_9_quantity'];
};				
?>" onchange="findtotal();" />
                <input type="hidden" name="product_9_price" id="product_9_price" value="<?php echo ($prices[9]);?>"  />
                <input type="hidden" name="product_9_subtotal" id="product_9_subtotal_txt" value="<?php echo $_POST["product_9_subtotal"];?>"  />
                </td>
				<td><span class = "computed_subtotal" id = "product_9_subtotal"><?php if($_POST["product_9_subtotal"]!="") 
				 echo "$".$_POST["product_9_subtotal"]; ?></span></td>
			</tr>
			<tr>
				<td><?php echo ($products[10]);?> [Adult Cat Food, 7 packs]</td>
				<td><span class = "quantity">&nbsp;&nbsp;Quantity</span><input type = "input" size = "2"  name = "product_10_quantity" id = "product_10_quantity" class = "product_quantity" value="<?php
if (isset($_POST['product_10_quantity'])){
	echo $_POST['product_10_quantity'];
}else{
	echo $_SESSION['product_10_quantity'];
};				
?>" onchange="findtotal();" />
                <input type="hidden" name="product_10_price" id="product_10_price" value="<?php echo ($prices[10]);?>"  />
                <input type="hidden" name="product_10_subtotal" id="product_10_subtotal_txt" value="<?php echo $_POST["product_10_subtotal"];?>"  />
                </td>
				<td><span class = "computed_subtotal" id = "product_10_subtotal"><?php if($_POST["product_10_subtotal"]!="") 
				 echo "$".$_POST["product_10_subtotal"]; ?></span></td>
			</tr>
			<tr>
				<td><?php echo ($products[11]);?> [Adult Weight Loss Food, 7 packs]</td>
				<td><span class = "quantity">&nbsp;&nbsp;Quantity</span><input type = "input" size = "2"  name = "product_11_quantity" id = "product_11_quantity" class = "product_quantity"  value="<?php
if (isset($_POST['product_11_quantity'])){
	echo $_POST['product_11_quantity'];
}else{
	echo $_SESSION['product_11_quantity'];
};				
?>" onchange="findtotal();" />
                 <input type="hidden" name="product_11_subtotal" id="product_11_subtotal_txt" value="<?php echo $_POST["product_11_subtotal"];?>"  />
                <input type="hidden" name="product_11_price" id="product_11_price" value="<?php echo ($prices[11]);?>"  />
                </td>
				<td><span class = "computed_subtotal" id = "product_11_subtotal"><?php if($_POST["product_11_subtotal"]!="") 
				 echo "$".$_POST["product_11_subtotal"]; ?></span></td>
			</tr>
			<tr>
				<td><?php echo ($products[12]);?> [Mature / Reduced Energy Cats, 7 packs]</td>
				<td><span class = "quantity">&nbsp;&nbsp;Quantity</span><input type = "input" size = "2"  name = "product_12_quantity" id = "product_12_quantity" class = "product_quantity" value="<?php
if (isset($_POST['product_12_quantity'])){
	echo $_POST['product_12_quantity'];
}else{
	echo $_SESSION['product_12_quantity'];
};				
?>" onchange="findtotal();" />
                 <input type="hidden" name="product_12_price" id="product_12_price" value="<?php echo ($prices[12]);?>"  />
                   <input type="hidden" name="product_12_subtotal" id="product_12_subtotal_txt" value="<?php echo $_POST["product_12_subtotal"];?>"  />
                </td>
				<td><span class = "computed_subtotal" id = "product_12_subtotal"><?php if($_POST["product_12_subtotal"]!="") 
				 echo "$".$_POST["product_12_subtotal"]; ?></span></td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td><?php echo ($products[13] . " ($" . $prices[13] . ")"); ?></td>
				<td><span class = "quantity">&nbsp;&nbsp;Quantity</span><input type = "input" size = "2" name = "product_13_quantity" id = "product_13_quantity" class = "product_quantity" value="<?php
if (isset($_POST['product_13_quantity'])){
	echo $_POST['product_13_quantity'];
}else{
	echo $_SESSION['product_13_quantity'];
};				
?>" onchange="findtotal();"  />
                 <input type="hidden" name="product_13_price" id="product_13_price" value="<?php echo ($prices[13]);?>"  />
                  <input type="hidden" name="product_13_subtotal" id="product_13_subtotal_txt" value="<?php echo $_POST["product_13_subtotal"];?>"  />
                  <input type="hidden" name="total" id="total_txt" value="<?php if(isset($_POST["total"])) { echo $_POST["total"]; } else { echo $subscription_total;  }?>"  />
                   <input type="hidden" name="product_total" id="product_total_txt" value="<?php echo $_POST["product_total"];?>"  />
                   <input type="hidden" name="subscription_total" id="subscription_total_txt" value="<?php echo $subscription_total; ?>"  />
                </td>
				<td><span class="computed_subtotal" id = "product_13_subtotal"><?php if($_POST["product_13_subtotal"]!="") 
				 echo "$".$_POST["product_13_subtotal"]; ?></span></td>
			</tr>
		</table>
        <div id = "one_time_sub_total_div"><h1>Sub Total:$<span id="product_total"></span></h1></div>
</div>
</div>
	
<div id = "billing_and_shipping" class = "form_section">
	<div id = "billing" class = "half_form_section_left" >
		<small class = "jquery_shipping_filler">&nbsp;</small> 
		<h1>Bill to:</h1>
		<div class = "ship_to_label"><label for = "bill_to_first_name">First Name:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_first_name" id = "bill_to_first_name" value="<?php echo get_usermeta($current_user->ID,'bill_to_first_name');?>" onkeyup="clear_error_msg('bill_to_first_name','bill_to_first_name_error_msg');" />
			<div id = "bill_to_first_name_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_first_name_error_msg); ?></div>
		<br/>
		<div class = "clearfix"></div>
		<div class = "ship_to_label"><label for = "bill_to_last_name">Last Name:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_last_name" id = "bill_to_last_name" value="<?php echo get_usermeta($current_user->ID,'bill_to_last_name');?>" onkeyup="clear_error_msg('bill_to_last_name','bill_to_last_name_error_msg');" />
			<div id = "bill_to_last_name_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_last_name_error_msg); ?></div>
		<br/>		<div class = "clearfix"></div>
		<div class = "ship_to_label"><label for = "bill_to_address1">Address:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_address1" id = "bill_to_address1" value="<?php echo get_usermeta($current_user->ID,'bill_to_address1'); ?>" onkeyup="clear_error_msg('bill_to_address1','bill_to_address1_error_msg');" />
		<br/>		<div class = "clearfix"></div>
		<div class = "ship_to_label">&nbsp;</div>
			<input type = "input"class = "ship_to_input" name = "bill_to_address2" id = "bill_to_address2" value="<?php echo get_usermeta($current_user->ID,'bill_to_address2'); ?>" onkeyup="clear_error_msg('bill_to_address2','bill_to_address2_error_msg');" />
			<div id = "bill_to_address_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_address_error_msg); ?></div>		                
			<br/><div class = "clearfix"></div><div class = "ship_to_label"><label for = "bill_to_city">City:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_city" id = "bill_to_city" value="<?php echo get_usermeta($current_user->ID,'bill_to_city'); ?>" onkeyup="clear_error_msg('bill_to_city','bill_to_city_error_msg');"  />
			<div id = "bill_to_city_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_city_error_msg); ?></div>
		<br/>		<div class = "clearfix"></div><div class = "ship_to_label"><label for = "bill_to_state">State:</label></div><?php $states = array('AL'=>"AL",'AK'=>"AK",'AZ'=>"AZ",'AR'=>"AR",'CA'=>"CA",'CO'=>"CO",'CT'=>"CT",'DE'=>"DE",'DC'=>"DC",'FL'=>"FL",'GA'=>"GA",'HI'=>"HI",'ID'=>"ID",'IL'=>"IL",  'IN'=>"IN",'IA'=>"IA",  'KS'=>"KS",  'KY'=>"KY",  'LA'=>"LA",  'ME'=>"ME",  'MD'=>"MD",  'MA'=>"MA",  'MI'=>"MI",  'MN'=>"MN",  'MS'=>"MS",  'MO'=>"MO",  'MT'=>"MT",'NE'=>"NE",'NV'=>"NV",'NH'=>"NH",'NJ'=>"NJ",'NM'=>"NM",'NY'=>"NY",'NC'=>"NC",'ND'=>"ND",'OH'=>"OH",  'OK'=>"OK",  'OR'=>"OR",  'PA'=>"PA",'PR'=>"PR",  'RI'=>"RI",  'SC'=>"SC",  'SD'=>"SD",'TN'=>"TN",  'TX'=>"TX",  'UT'=>"UT",  'VT'=>"VT",  'VA'=>"VA",  'WA'=>"WA",  'WV'=>"WV",  'WI'=>"WI",  'WY'=>"WY");?>
		<select name = "bill_to_state" id = "bill_to_state" class = "ship_to_input" onchange="clear_error_msg('bill_to_state','bill_to_state_error_msg');">
		<option value="">Choose State</option>
		<?php foreach ($states as $code => $state){	?>
		     <option value="<?php echo $code?>" <?php if($code==get_usermeta($current_user->ID,'bill_to_state')) { echo "selected"; } ?>><?php echo $state?></option>
			<?php } ?>
		</select>
			<!--<input type = "input" class = "ship_to_input" name = "bill_to_state" id = "bill_to_state" value="<?php echo get_usermeta($current_user->ID,'bill_to_state'); ?>" onkeyup="clear_error_msg('bill_to_state','bill_to_state_error_msg');"  />-->
			<div id = "bill_to_state_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_state_error_msg); ?></div>
				<div class = "clearfix"></div><div class = "ship_to_label"><label for = "bill_to_zip">Zip:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_zip" id = "bill_to_zip"  value="<?php echo get_usermeta($current_user->ID,'bill_to_zip'); ?>"onkeyup="clear_error_msg('bill_to_zip','bill_to_zip_error_msg');" />
			<div id = "bill_to_zip_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_zip_error_msg); ?></div>
				<div class = "clearfix"></div><div class = "ship_to_label"><label for = "bill_to_city">Phone:</label></div>
			<input type = "input" class = "ship_to_input" name = "bill_to_phone" id = "bill_to_phone" value="<?php echo get_usermeta($current_user->ID,'bill_to_phone'); ?>" onkeyup="clear_error_msg('bill_to_phone','bill_to_phone_error_msg');"  />
			<div id = "bill_to_phone_error_msg" class = "ship_to_error_msg"><?php echo ($bill_to_phone_error_msg); ?></div>
			<!-- clearfix --><div style = "width:100%;clear:both;">&nbsp;</div>
	</div>
	<div id = "shipping" class = "half_form_section_right" >
		<small class = "jquery_shipping_filler"><input type="checkbox" name="shipping_filler" id ="shipping_filler" checked> Shipping the same as billing</small> 
		<h1>Ship to:</h1>
		<div class = "ship_to_label"><label for = "ship_to_first_name">First Name:</label></div>
			<input type = "input" class = "ship_to_input" name = "ship_to_first_name" id = "ship_to_first_name" value="<?php if(isset($_POST["ship_to_first_name"])) { echo $_POST["ship_to_first_name"]; } else { echo get_usermeta($current_user->ID,'first_name'); } ?>" onkeyup="clear_error_msg('ship_to_first_name','ship_to_first_name_error_msg');" />
			<div id = "ship_to_first_name_error_msg" class = "ship_to_error_msg"><?php echo ($ship_to_first_name_error_msg); ?></div>
		<br/><div class = "ship_to_label"><label for = "ship_to_last_name">Last Name:</label></div>
			<input type = "input" class = "ship_to_input" name = "ship_to_last_name" id = "ship_to_last_name" value="<?php if(isset($_POST["ship_to_last_name"])) { echo $_POST["ship_to_last_name"]; } else { echo get_usermeta($current_user->ID,'last_name'); } ?>" onkeypress="clear_error_msg('ship_to_last_name','ship_to_last_name_error_msg');" />
			<div id = "ship_to_last_name_error_msg" class = "ship_to_error_msg"><?php echo ($ship_to_last_name_error_msg); ?></div>
		<br/><div class = "ship_to_label"><label for = "ship_to_address1">Address:</label></div>
			<input type = "input" class = "ship_to_input" name = "ship_to_address1" id = "ship_to_address1" value="<?php echo get_usermeta($current_user->ID,'address1'); ?>" onkeypress="clear_error_msg('ship_to_address','ship_to_address_error_msg');" />
		<br/><div class = "ship_to_label"></div>
			<input type = "input" class = "ship_to_input" name = "ship_to_address2" id = "ship_to_address2" value="<?php echo get_usermeta($current_user->ID,'address2'); ?>" onkeypress="clear_error_msg('ship_to_address','ship_to_address_error_msg');" />
			<div id = "ship_to_address_error_msg" class = "ship_to_error_msg"><?php echo ($ship_to_address_error_msg); ?></div>		                
		<br/><div class = "ship_to_label"><label for = "ship_to_city">City:</label></div>
			<input type = "input" class = "ship_to_input" name = "ship_to_city" id = "ship_to_city" value="<?php echo get_usermeta($current_user->ID,'city'); ?>" onkeypress="clear_error_msg('ship_to_city','ship_to_city_error_msg');"  />
			<div id = "ship_to_city_error_msg" class = "ship_to_error_msg"><?php echo ($ship_to_city_error_msg); ?></div>
		<br/><div class = "ship_to_label"><label for = "ship_to_state">State:</label></div><?php $states = array('AL'=>"AL",'AK'=>"AK",'AZ'=>"AZ",'AR'=>"AR",'CA'=>"CA",'CO'=>"CO",'CT'=>"CT",'DE'=>"DE",'DC'=>"DC",'FL'=>"FL",'GA'=>"GA",'HI'=>"HI",'ID'=>"ID",'IL'=>"IL",  'IN'=>"IN",'IA'=>"IA",  'KS'=>"KS",  'KY'=>"KY",  'LA'=>"LA",  'ME'=>"ME",  'MD'=>"MD",  'MA'=>"MA",  'MI'=>"MI",  'MN'=>"MN",  'MS'=>"MS",  'MO'=>"MO",  'MT'=>"MT",'NE'=>"NE",'NV'=>"NV",'NH'=>"NH",'NJ'=>"NJ",'NM'=>"NM",'NY'=>"NY",'NC'=>"NC",'ND'=>"ND",'OH'=>"OH",  'OK'=>"OK",  'OR'=>"OR",  'PA'=>"PA",'PR'=>"PR",  'RI'=>"RI",  'SC'=>"SC",  'SD'=>"SD",'TN'=>"TN",  'TX'=>"TX",  'UT'=>"UT",  'VT'=>"VT",  'VA'=>"VA",  'WA'=>"WA",  'WV'=>"WV",  'WI'=>"WI",  'WY'=>"WY");?>
		<select name = "ship_to_state" id = "ship_to_state" class = "ship_to_input" onchange="clear_error_msg('ship_to_state','ship_to_state_error_msg');">
		<option value="">Choose State</option>
		<?php foreach ($states as $code => $state){	?>
		     <option value="<?php echo $code?>" <?php if($code==get_usermeta($current_user->ID,'state')) { echo "selected"; } ?>><?php echo $state?></option>
			<?php } ?>
		</select>
			<!--<input type = "input" class = "ship_to_input" name = "ship_to_state" id = "ship_to_state" value="<?php echo get_usermeta($current_user->ID,'state'); ?>" onkeypress="clear_error_msg('ship_to_state','ship_to_state_error_msg');"  />-->
			<div id = "ship_to_state_error_msg" class = "ship_to_error_msg"><?php echo ($ship_to_state_error_msg); ?></div>
	<div class = "ship_to_label"><label for = "ship_to_zip">Zip:</label></div>
			<input type = "input" class = "ship_to_input" name = "ship_to_zip" id = "ship_to_zip"  value="<?php echo get_usermeta($current_user->ID,'zip'); ?>"onkeypress="clear_error_msg('ship_to_zip','ship_to_zip_error_msg');" />
			<div id = "ship_to_zip_error_msg" class = "ship_to_error_msg"><?php echo ($ship_to_zip_error_msg); ?></div>
		<div class = "ship_to_label"><label for = "ship_to_city">Phone:</label></div>
			<input type = "input" class = "ship_to_input" name = "ship_to_phone" id = "ship_to_phone" value="<?php echo get_usermeta($current_user->ID,'phone'); ?>" onkeypress="clear_error_msg('ship_to_phone','ship_to_phone_error_msg');"  />
			<div id = "ship_to_phone_error_msg" class = "ship_to_error_msg"><?php echo ($ship_to_phone_error_msg); ?></div>
			<!-- clearfix --><div style = "width:100%;clear:both;">&nbsp;</div>
	</div>
	<div class = "clearfix"><br /></div>
</div>

<div class = "form_section">
	<div class = "half_form_section_left" id = "promo_div">
		<h1 id = "promo_title">Promo Code:</h1>
		<div id = "promo_text">
			<input type = "text" id = "promo" name = "promo" value = "
<?php 
$promo_output = "*optional";
$nonce_id = $current_user->ID;
$nonce_promo = 	get_user_meta($nonce_id, "nonce_promo", TRUE);
if ($nonce_promo != ""){
	$promo_output = $nonce_promo;
	delete_user_meta( $nonce_id, "nonce_promo" );
}
if (isset($_SESSION['promo'])){$promo_output = $_SESSION['promo'];}
echo ($promo_output);
?>" onkeyup= "promo_function();" />
		</div>
	</div>
	<div class = "half_form_section_right" id = "total_div">
		<h1 id = "hide_total_on_bottom">Total:$<span id="total"></span></h1>
		<input name="submit14" id = "submit14" type="submit" value="Click here to proceed to payment" /><br /><br />
	</div>
	<div class = "clearfix"><br /></div>
</div>
<br /><br />	
<!-- THE WORDPRESS LOOP --><?php if (have_posts()) : while (have_posts()) : the_post();the_content();endwhile;else:endif;?>
</form>
</div> <!-- end #main -->  
</div> <!-- end #inner-content -->
</div> <!-- end #content -->
<?php get_footer();
function cost_of_new_subscription(){};
?>
<script language="javascript" type="text/javascript">
	var ship_to_first_name = "*Please enter a first name";
	var ship_to_last_name = "*Please enter a last name";
	var ship_to_address = "*Please enter an address";
	var ship_to_city = "*Please enter a city";
	var ship_to_state = "*Please enter a state";
	var ship_to_zip = "*Please enter a zip";
	var add_cat_msg = "*Please enter cat's name";
	var ship_to_phone = "*Please enter a phone";
	var cat_name_error_code = "*Please enter a cat's name";
	var add_cat_error_msg2 = "*Please select a product";
	
$(document).ready(function(){
	$('#bill_to_address1').click(function(){
		$('#bill_to_address_error_msg').html('');
	});
	
	$('#bill_to_address2').click(function(){
		$('#bill_to_address_error_msg').html('');
	});


	
	$('.jquery_shipping_filler').show();
	submit_allowed = false;
	$('#cat_weight').change(function() {clear_error_msg("cat_weight","add_cat_error_msg3");});
	$('#payment-form').submit(function(){
		if (submit_allowed == true){return true;}
		if (submit_allowed == false){return false;}
	});
	$('#rd1').click(function(){
		$('#add_cat_error_msg2').html("");
		$('#addcat').removeAttr('disabled');
		$('#submit14').removeAttr('disabled');
	});
	$('#rd2').click(function(){
		$('#add_cat_error_msg2').html("");
		$('#addcat').removeAttr('disabled');
		$('#submit14').removeAttr('disabled');
	});
	$('#rd3').click(function(){
		$('#add_cat_error_msg2').html("");
		$('#addcat').removeAttr('disabled');
		$('#submit14').removeAttr('disabled');
	});
	$('#rd4').click(function(){
		$('#add_cat_error_msg2').html("");
		$('#addcat').removeAttr('disabled');
		$('#submit14').removeAttr('disabled');
	});
	$('#submit14').click(function(){
		var error = 0;
		if (!($('#cat_name').val() == "")){
			if(!( $('#rd1').is(':checked') || $('#rd2').is(':checked') || $('#rd3').is(':checked') || $('#rd4').is(':checked'))){
				$('#add_cat_error_msg2').html("*Please select a product");
				error = 1; 
			}
			if($('#cat_weight').val()=="Choose Cat Weight"){
				$('#add_cat_error_msg3').html("*Please select a weight");
				error = 1 ; 
			}
		}
		if($('#ship_to_first_name').val()==""){
			$('#ship_to_first_name_error_msg').html("*Please enter a first name");
			error = 1 ;
		}else{$('#ship_to_first_name_error_msg').html("");}
		if($('#bill_to_first_name').val()==""){
			$('#bill_to_first_name_error_msg').html("*Please enter a first name");
			error = 1 ;
		}else{$('#bill_to_first_name_error_msg').html("");}
		
		if($('#ship_to_last_name').val()==""){
			$('#ship_to_last_name_error_msg').html(ship_to_last_name);
			error = 1 ;
		}else{$('#ship_to_last_name_error_msg').html("");}
		if($('#bill_to_last_name').val()==""){
			$('#bill_to_last_name_error_msg').html(ship_to_last_name);
			error = 1 ;
		}else{$('#bill_to_last_name_error_msg').html("");}		
		
		if($('#ship_to_address1').val()=="" && $('#ship_to_address2').val()==""){
			$('#ship_to_address_error_msg').html(ship_to_address);
			error = 1 ;
		}else{$('#ship_to_address_error_msg').html("");}
		
		if($('#bill_to_address1').val()=="" && $('#bill_to_address2').val()==""){
			$('#bill_to_address_error_msg').html(ship_to_address);
			error = 1 ;
		}else{$('#bill_to_address_error_msg').html("");}
		if($('#ship_to_city').val()==""){
			$('#ship_to_city_error_msg').html(ship_to_city);
			error = 1 ;
		}else{$('#ship_to_city_error_msg').html("");}
		
		if($('#bill_to_city').val()==""){
			$('#bill_to_city_error_msg').html(ship_to_city);
			error = 1 ;
		}else{$('#bill_to_city_error_msg').html("");}

		if($('#bill_to_zip').val()==""){
			$('#bill_to_zip_error_msg').html("*Please enter a zip code");
			error = 1 ;
		}else{$('#bill_to_zip_error_msg').html("");}
		
		if($('#bill_to_phone').val()==""){
			$('#bill_to_phone_error_msg').html("*Please enter a phone number");
			error = 1 ;
		}else{$('#bill_to_phone_error_msg').html("");}
		
		
		
		if($('#ship_to_state').val()==""){
			$('#ship_to_state_error_msg').html(ship_to_state);
			error = 1 ;
		}else{$('#ship_to_state_error_msg').html("");}	
		
		if($('#ship_to_zip').val()==""){
			$('#ship_to_zip_error_msg').html(ship_to_zip);
			error = 1 ;
		}else{$('#ship_to_zip_error_msg').html("");}
		
		if($('#ship_to_phone').val()==""){
			$('#ship_to_phone_error_msg').html(ship_to_phone);
			error = 1 ;
		}else{$('#ship_to_phone_error_msg').html("");}
		
		if(error==0){
			$("input").removeAttr('disabled');
			$("select").removeAttr('disabled');			
			submit_allowed = true;
		}else{
			submit_allowed = false;
		}
	});
	
	$('#addcat').click(function(){
		$('#addcat').attr('disabled', 'disabled');
		$('#submit14').attr('disabled', 'disabled');
		var error = 0;
		if ($('#cat_name').val() == ""){
			$('#add_cat_error_msg').html("*Please enter a cat's name.");
			error = 1 ; 
		}
		if(!( $('#rd1').is(':checked') || $('#rd2').is(':checked') || $('#rd3').is(':checked') || $('#rd4').is(':checked'))){
			$('#add_cat_error_msg2').html("*Please select a product.");
			error = 1; 
		}
		if($('#cat_weight').val()=="Choose Cat Weight"){
			$('#add_cat_error_msg3').html("*Please select a weight.");
			error = 1 ; 
		}
		if (error == 0){
			$('#frmsubmit').val('addcat');
			submit_allowed = true;
			$("#ship_to_first_name").removeAttr('disabled');
			$("#ship_to_first_name").removeAttr('disabled');
			$('#ship_to_last_name').removeAttr('disabled');
			$('#ship_to_address1').removeAttr('disabled');
			$('#ship_to_address2').removeAttr('disabled');
			$('#ship_to_city').removeAttr('disabled');		
			$('#ship_to_state').removeAttr('disabled');
			$('#ship_to_zip').removeAttr('disabled');
			$('#ship_to_phone').removeAttr('disabled');
			$("#payment-form").submit();
		}
	});
	
	$('#show_subscriptions_area_button').show();
	$('#hide_total_on_bottom').show();
	$('#show_subscriptions_area_button').click(function(){
		$('#hidden_subscriptions_area').slideDown('slow');
		$('#subscriptions_activator_div').hide();
		$('#one_time').fadeOut('slow');
	});
	$('#show_one_time').click(function(){
		$('#show_one_time').hide();
		$('#subscriptions_form_section').slideUp('slow');
		$('#one_time_text').show();
	});
	$('#hidden_subscriptions_area').hide();
	findtotal();

	$('#promo').focus(function(){
		var x = $('#promo').val();
		if (x == "*optional"){
			$('#promo').val('');
		}
	});
	shipping_filler_function();
	
	$('#shipping_filler').click(function(){
		if (($('#shipping_filler').prop('checked')) == false){
			var field_names=new Array("first_name","last_name","address1","address2","city","state","zip","phone");
			for (x in field_names){
				var bill_to_field = "#bill_to_" + field_names[x];
				var ship_to_field = "#ship_to_" + field_names[x];
				var z = "#ship_to_" + field_names[x] + "_error_msg";
				$(z).text("");
				$('ship_to_address_error_msg').text("");
				$(ship_to_field).val("");
				$(ship_to_field).prop('disabled', false);	  
			}
		}
		shipping_filler_function();
	});	
	promo_function();
});

function findtotal(){
	//loops through items 9-13
	var x;
	x = 9;
	var subtotal = 0;
	while (x < 14){
		//checks to see if it's a number
		if(isNaN($('#product_'+x+'_quantity').val())==true){$('#product_'+x+'_quantity').val('');}
		if(($('#product_'+x+'_quantity').val()) < 0){
			$('#product_'+x+'_quantity').val('');
		}
		var y = $('#product_'+x+'_quantity').val();
		if (y != 0){
			y = parseInt(y);
			$('#product_'+x+'_quantity').val(y);
		}
		if (y == "0"){$('#product_'+x+'_quantity').val('');}
		y = $('#product_'+x+'_quantity').val();
		
		//computes price
		y = $('#product_'+x+'_quantity').val();
		if (y > 0){
			var z =  $('#product_'+x+'_price').val();
			var computed_price = (y * z);
			subtotal = subtotal + computed_price;
			computed_price = computed_price.toFixed(2);
			computed_price = '$' + computed_price;
			$('#product_total_txt').val(computed_price);
			$('#product_'+x+'_subtotal').html(computed_price);
		}
		if (y == ''){
			$('#product_'+x+'_subtotal').html('');
		}
	//loop counter
	x++;
	}
	//Hide subtotal and price
	if (subtotal == '0'){
		$('#one_time_sub_total_div').hide();
		$('#price_label').hide();
	}else{
		$('#one_time_sub_total_div').slideDown('slow');
		$('#price_label').fadeIn('slow');
		$('#one_time_text').show();
		$('#show_one_time').hide();
	}
	
	//computes subtotal and grand total
	x = subtotal.toFixed(2);
	$('#product_total').html(x);
	var grand_total = $('#subscription_total').html();
	if (isNaN(grand_total)){grand_total = "0";}
	grand_total = parseFloat(grand_total);
	x = parseFloat(x);
	if (grand_total > 0){
		$('#show_subscriptions_area_button').click();
	}
	grand_total = grand_total + x;
	grand_total = grand_total.toFixed(2);
	$('#total').html(grand_total);
	if(grand_total == "0.00"){
		$('#total_div').hide();
		$('#billing_and_shipping').hide();
	}else{
		$('#total_div').fadeIn('slow');
		$("#jquery_submit14").css({"margin-top":"0px"});
		$('#jquery_submit14').fadeIn('slow');
		$('#billing_and_shipping').fadeIn('slow');
	}
}

function clear_error_msg(id,msgid){
	shipping_filler_function();
	$('#'+msgid).html("");
	$('#addcat').removeAttr('disabled');
	$('#submit14').removeAttr('disabled');
}

function shipping_filler_function(){
		var field_names=new Array("first_name","last_name","address1","address2","city","state","zip","phone");
		if (($('#shipping_filler').prop('checked')) == true){
			for (x in field_names){
				var bill_to_field = "#bill_to_" + field_names[x];
				var ship_to_field = "#ship_to_" + field_names[x];
				$(ship_to_field).val($(bill_to_field).val());
				$(ship_to_field).prop('disabled', true);	
				var z = "#ship_to_" + field_names[x] + "_error_msg";
				$(z).text("");
			}
			$('#ship_to_address_error_msg').text("");
		}
}

function promo_function(){
	var x = $('#promo').val();
	var trip = false;
	var code = x[0] + x[1];
	code = code.toUpperCase();
	whole_code = x.toUpperCase();
	if ( ((code == "AA") && ( (  x[6] == null) && (x[5] != null)     ) ) || (code = "BX" && (x[3] == "a" || x[3] == "A" || x[4] == "a" || x[4] == "A" || x[5] == "a" || x[5] == "A") ) ){
		jQuery('#subscription_div_title').html('PROMO: Add a New Subscription today for only $1.');
		jQuery('#promo_explanation').html('After a month, subscriptions return to the regular price of $59.99, unless you cancel. You may cancel at any time.<br /><br />');
		jQuery('#subscription_total').text('1.00');
		findtotal();
		jQuery('#one_time').hide();
		$('#hidden_subscriptions_area').show();
		$('#subscriptions_activator_div').hide();		
		jQuery('html, body').animate({ scrollTop: jQuery('#welcome_back_div').offset().top }, 'slow');
	}
	if ( ((code == "AA") && ( (  x[6] == null) && (x[5] != null)     ) ) || (code = "ZX" && (x[3] == "v" || x[3] == "A" || x[4] == "v" || x[4] == "V" || x[5] == "v" || x[5] == "V") ) ){
		jQuery('#subscription_div_title').html('PROMO: Add a New Subscription today for only $1.');
		jQuery('#promo_explanation').html('After a month, subscriptions return to the regular price of $59.99, unless you cancel. You may cancel at any time.<br /><br />');
		jQuery('#subscription_total').text('1.00');
		findtotal();
		jQuery('#one_time').hide();
		$('#hidden_subscriptions_area').show();
		$('#subscriptions_activator_div').hide();		
		jQuery('html, body').animate({ scrollTop: jQuery('#welcome_back_div').offset().top }, 'slow');
	}
	if ( ((code == "KC") && ( (  x[6] == null) && (x[5] != null)     ) ) || (code = "KC" && (x[3] == "x" || x[3] == "X" || x[4] == "x" || x[4] == "X" || x[5] == "x" || x[5] == "X") ) ){
		jQuery('#subscription_div_title').html('PROMO: Add a New Subscription today for only $1.');
		jQuery('#promo_explanation').html('After a month, subscriptions return to the regular price of $59.99, unless you cancel. You may cancel at any time.<br /><br />');
		jQuery('#subscription_total').text('1.00');
		findtotal();
		jQuery('#one_time').hide();
		$('#hidden_subscriptions_area').show();
		$('#subscriptions_activator_div').hide();		
		jQuery('html, body').animate({ scrollTop: jQuery('#welcome_back_div').offset().top }, 'slow');
	}
	if (whole_code == "CROHN50"){
		jQuery('#subscription_div_title').html('PROMO: Thank you for your support! Add a New Subscription today, and we will donate $50 to the Crohn\'s Foundation.');
		findtotal();
		jQuery('#one_time').hide();
		$('#hidden_subscriptions_area').show();
		$('#subscriptions_activator_div').hide();		
		jQuery('html, body').animate({ scrollTop: jQuery('#welcome_back_div').offset().top }, 'slow');
	}
	
}


</script>

