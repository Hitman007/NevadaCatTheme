<?php
/*
The comments page for Bones
*/

// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if ( post_password_required() ) { ?>
  	<div class="alert help">
    	<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", "bonestheme"); ?></p>
  	</div>
  <?php
    return;
  }
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	
	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
	 	</ul>
	</nav>
	
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=bones_comments'); ?>
	</ol>
	
	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
		</ul>
	</nav>
  
	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
    	<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
	
	<!-- If comments are closed. -->
	<!--p class="nocomments"><?php _e("Comments are closed.", "bonestheme"); ?></p-->

	<?php endif; ?>

<?php endif; ?>


<?php if ( comments_open() ) : ?>

<section id="respond" class="respond-form form_section">

	<h1>Got somethin' to say?</h1>
<?php 	if ( ! (is_user_logged_in() )) {?>
	<a href="http://asiascatcreations.com/wp-login.php?loginFacebook=1&redirect=https://asiascatcreations.com/products/" onclick="window.location = 'http://asiascatcreations.com/wp-login.php?loginFacebook=1&redirect='+window.location.href; return false;">
	<div class="new-fb-btn new-fb-1 new-fb-default-anim"><div class="new-fb-1-1"><div class="new-fb-1-1-1">CONNECT WITH</div></div></div></a>
<?php }else{
	echo ("<h4>You're logged in as <a href = 'http://asiascatcreations.com/profile'>" . $user_identity . "</a></h4>");
}
?>
	<div id="cancel-comment-reply">
		<p class="small"><?php cancel_comment_reply_link(); ?></p>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
  	<div class="alert help">
  		<p><?php printf( 'You must be %1$slogged in%2$s to post a comment.', '<a href="<?php echo wp_login_url( get_permalink() ); ?>">', '</a>' ); ?></p>
  	</div>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ( is_user_logged_in() ) : ?>



	<?php else : ?>
	
	<ul id="comment-form-elements" class="clearfix">
		
		<li>
		  <label for="author"><?php _e("Name", "bonestheme"); ?> <?php if ($req) _e("(required)"); ?></label>
		  <input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e('Your Display Name', 'bonestheme'); ?>" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
		  <div class = "comment_notices">*We may publish this.</div>
		</li>
		
		<li>
		  <label for="email"><?php _e("Mail", "bonestheme"); ?> <?php if ($req) _e("(required)"); ?></label>
		  <input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e('Your E-Mail', 'bonestheme'); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
		  <div class = "comment_notices">*We will never share this.</div>
		</li>
	</ul>

	<?php endif; ?>
	
	<p><textarea name="comment" id="comment" placeholder="<?php _e('Your Comment here...', 'bonestheme'); ?>" tabindex="4"></textarea></p>
	
	<p>
	  <input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit', 'bonestheme'); ?>" />
	  <?php comment_id_fields(); ?>
	</p>
	

	
	<?php do_action('comment_form', $post->ID); ?>
	
	</form>
	
	<?php endif; // If registration required and not logged in ?>
</section>

<?php endif; // if you delete this the sky will fall on your head ?>
