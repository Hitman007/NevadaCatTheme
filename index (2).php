<?php
/*
Plugin Name: CRG Login
Plugin URI: http://customrayguns.com
Description: The best way to login/register users in wordpress.
Version: 1.0
Author: Custom Ray Guns
Author URI: http://customrayguns.com
*/
session_start();

add_shortcode( 'crg_login_form', 'crg_login_form' );
add_action( 'set_current_user', 'crg_login_email_logic' );

global $crg_login_state;
global $crg_login_email;
global $crg_login_error_msg;
global $wpdb;

$crg_login_email = $_POST['crg_login_email'];
$crg_login_email = strtolower($crg_login_email);

if (isset($_GET['crg_login_state'])){
	$crg_login_state = $_GET['crg_login_state'];
}

//ASIAS CAT CREATIONS SPECIFIC PROMO
//promo nonce



function crg_login_email_logic(){
	global $wpdb;
	global $crg_login_email;
	global $crg_login_state;
	global $crg_login_error_msg;
		
	if (isset($_POST['crg_login_email'])){
		if (!(crg_login_isValidEmail($crg_login_email))){
			//error check email address
			$crg_login_error_msg = $crg_login_error_msg . "<span class = 'error_msg'>Please enter a valid email address.</span>";
			$crg_login_state = 1;
			return;
		}
		if( email_exists( $crg_login_email)) {
			//email exists^
			$id_a = email_exists($crg_login_email);

			//password check:
			if (isset($_POST['crg_password'])){
				//pw is given^
				
				$stored_pw = get_usermeta($id_a, 'crg_password'); 
				$given_password = $_POST['crg_password'];
				if ($stored_pw == $given_password){
					//pw match^
					$creds = array();
					$creds['user_login'] = $crg_login_email;
					$creds['user_password'] = $given_password;
					$creds['remember'] = true;
					$user = wp_signon( $creds, true );
					$crg_login_state = 4;
					if (isset($_SESSION['crg_login_redirect_url'])){
						$crg_login_redirect_url = $_SESSION['crg_login_redirect_url'];
						wp_redirect($crg_login_redirect_url);
					}
					$crg_login_state = 4;

				 }else{
					//pw dont match
					$crg_login_error_msg = $crg_login_error_msg . "<span class = 'error_msg'>Error: Password/email don't match.</span>";
					$crg_login_state = 2;
				}
			 }else{
				//pw is not given
				$crg_login_state = 2;
			}			
		}
		 else{
			//email doesn't exist
			$random_password = "notset";
			wp_create_user($crg_login_email,$random_password,$crg_login_email);
			$creds = array();
			$creds['user_login'] = $crg_login_email;
			$creds['user_password'] = $random_password;
			$creds['remember'] = true;
			$user = wp_signon( $creds, true );
			$x = $user->ID;
			update_user_meta($x, 'crg_password', "notset");
			$z = 0;
			while (($crg_login_email[$z] != null)){
				if ($crg_login_email[$z] == "@"){break;}
				$email_word = $email_word . $crg_login_email[$z];
				++$z;
			}
			$xyz = crg_trim_email($email_word);
			update_user_meta( $x, 'nickname', $xyz);
			$wpdb->query("UPDATE $wpdb->users SET display_name = '$xyz' WHERE ID = $x");
			if (isset($_SESSION['crg_login_redirect_url'])){
				$crg_login_redirect_url = $_SESSION['crg_login_redirect_url'];
				wp_redirect($crg_login_redirect_url);
			}
			$crg_login_state = 4;
		}

	 }

	if (isset($_GET['crg_login_fp'])){
		$forgot_pw_email = $_GET['crg_login_fp'];
		if (crg_login_isValidEmail($forgot_pw_email)){
			crg_send_login_email($forgot_pw_email);
			$crg_login_state = 3;
		}
	}
	
	if (isset($_GET['cr3gx'])){
		//user has clicked the sent email link
		//gets the id from the sent code
		$sent_key = $_GET['cr3gx'];
		$not_z = true;
		$x=0;
		while ( ($not_z == true) && ($x < 35) ){
			$sent_id = $sent_id . $sent_key[$x];
			$y = $x + 1;
			if ($sent_key[$y] == "z"){
				$not_z = false;
			}
			++$x;
		}
		
		if (isset($_GET['crg_login_redirect_url'])){
			$_SESSION['crg_login_redirect_url'] = $_GET['crg_login_redirect_url'];
		}
		$sent_user = get_userdata($sent_id);
		$sent_email = $sent_user->user_email;
		$random_password = "notset";
		$creds = array();

		$creds['user_password'] = "notset";
		$creds['remember'] = true;
		$user = get_user_by( 'email', $sent_email );
		$user_id = $user->ID;
		$user_info = get_userdata($user_id);
		$creds['user_login'] = $user_info->user_login;
		wp_set_password( $random_password, $user_id );

		wp_signon( $creds, true );
		$crg_login_state = 4;
		if (isset($_SESSION['crg_login_redirect_url'])){
			$crg_login_redirect_url = $_SESSION['crg_login_redirect_url'];
			wp_redirect($crg_login_redirect_url);
			}
		$crg_login_state = 4;
	}

}

function crg_login_form(){
	global $crg_login_state;
    global $crg_login_error_msg;
	$site_url = get_site_url();
	global $crg_login_email;
	$short_code_output =  "
			<form method = 'post' action = '$site_url/login/'>
			<h1>Login with your Email</h1><br />
			<label for ='crg_login_email'>Email:</label>
			<input type = 'input' id = 'crg_login_email' name = 'crg_login_email' />$crg_login_error_msg
			<br /><br />
			<input type = 'submit' value = 'Submit' />
		</form>
	";
	
	if ($crg_login_state == 2) {
	$self_url = $_SERVER['REQUEST_URI'];
		$short_code_output = $crg_login_error_msg . "
			<form method='post' action='$site_url/login/'>
				<h1>Welcome back.</h1><h4>That email is already in our system.</h4><br />
				<label for = 'crg_email'>Email:</label>
				<a href = '$self_url'>$crg_login_email</a><br />
				<label for = 'crg_password'>Password:</label>
				<input type = 'password' id = 'crg_password' name = 'crg_password' /><br />
				<span id = 'forgot_email_link' style = 'font-size:65%'><a href = '$self_url?crg_login_fp=$crg_login_email'>I forgot/don&rsquo;t have my password</a></span><br /><br />
				<input type = 'hidden' id = 'crg_login_email' name = 'crg_login_email' value='$crg_login_email' /><br />
				<input name='login' type = 'submit' value = 'Submit' /><br />
			</form>";
	}
	//asias cat promo code
	$np = $_SESSION['promo'];
	//set promo nonce later set return nonce.
	if ($np != ""){
		$nonce_id = email_exists($crg_login_email);
		update_user_meta( $nonce_id, "nonce_promo", $np );
		$z = get_user_meta($nonce_id, "nonce_promo", TRUE);
	}
	

	if ($crg_login_state == 3) {
		$short_code_output = "<h1>" . $crg_login_email . "</h1>We have sent you an email with a link to login. Please check your spam folder if you can't find it.";
	}

	if ($crg_login_state == 4) {$short_code_output = "<h1>Welcome $crg_login_email,</h1>";}

	
	if ($crg_login_state == 5){$short_code_output = '<h1>Login:</h1><br />
<a href = "https://asiascatcreations.com/wp-login.php?loginFacebook=1&redirect=' . $_SESSION['crg_login_redirect_url'] . '"><img src = "https://asiascatcreations.com/wp-content/plugins/crg_login/facebook_icon.jpg" align ="middle" />Facebook</a><br /><br />
<a href = "http://asiascatcreations.com/login/"><img src = "https://asiascatcreations.com/wp-content/plugins/crg_login/email_icon.jpg" align ="middle" />Email</a>';}
	
	return ($short_code_output);
}

function crg_login_isValidEmail($email){
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

function crg_login_generateRandomString($length) {
    $characters = '123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function crg_send_login_email($forgot_pw_email){
	$user_id = get_user_by('email', $forgot_pw_email);
	$rs = crg_login_generateRandomString(22);
	$activation_code = $user_id->ID . "z" . $rs;
	update_user_meta($user_id, 'crg_login_nonce', $activation_code);
	update_user_meta($user_id, 'crg_password', 'notset');
	wp_set_password( 'notset', $user_id );
	

	$headers[] = 'Content-type: text/html';
	$headers[] = 'From: Asia Mayfield <support@asiascatcreations.com>';
	$blogname = get_bloginfo( "name" );
	$message  = "Hello! Welcome back to " . $blogname . ".<br />";
	$site_url = get_site_url();
	$message  = $message . '<br/><a href="' . $site_url .'/login/?cr3gx=' . $activation_code . '&crg_login_redirect_url=' . $_SESSION['crg_login_redirect_url'] . '">Click here to login</a>.'; 
	$subject = "Login to Asia's Cat Creations";
    wp_mail($forgot_pw_email, $subject, $message, $headers);
}

function crg_auth_redirect(){
	if ( ! (is_user_logged_in() )) {
		$site_url = get_site_url();
		$_SESSION['crg_login_redirect_url'] = $site_url . $_SERVER['REQUEST_URI'];
		wp_redirect( "$site_url/login/?crg_login_state=5");
		die();
	}
}

function is_user_logged_in() {
	$user = wp_get_current_user();
	$user_id = $user->ID;
	if ( $user_id > 0 ){return TRUE;}else{return FALSE;}
}

function crg_trim_email($crg_email){
	//this function returns the first part of an email. i.e. jiminac@gmail.com is trimmed to jiminac
	$arr1 = str_split($crg_email);
	foreach ($arr1 as $l){
		if ($l == "@"){break;}
		$trimmed = $trimmed . $l;
	}
	return $trimmed;
}
?>
