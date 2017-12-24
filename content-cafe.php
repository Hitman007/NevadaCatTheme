<?php
//Admin functions required to show taxonomy lists
require_once(ABSPATH.'wp-admin/includes/template.php');
 
$custom = get_post_custom( get_the_ID() );
$address = @$custom["address"][0];
$website = @$custom["website"][0];
$phone = @$custom["phone"][0];
?>
 
<!-- Lazily add resources here - this is bad, do it the right way! -->
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/packages/bootstrap/css/bootstrap.min.css" />
<style>
	.modal {width:900px;margin-left:-440px;}
</style>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/packages/bootstrap/js/bootstrap.min.js"></script>
 
<!-- Modal -->
<form method='post' action="" enctype="multipart/form-data">
	<div id="editModal">
		<div>
			<button type="button" data-dismiss="modal">�</button>
			<h3>Edit Cafe</h3>
		</div>
		<div>
			<input type='hidden' name='frontend' value="true" />
			<input type='hidden' name='ID' value="<?= get_the_ID() ?>" />
			<input type='hidden' name='post_type' value="<?= $post->post_type ?>" />
 
			<div>
				<label for="inputTitle">Title</label>
				<div>
					<input type="text" id="inputTitle" name='post_title' placeholder="Title" value="<?= get_the_title() ?>" />
				</div>
			</div>
			<div>
				<label for="inputURL">URL</label>
				<div>
					<input type="text" id="inputURL" name='website' placeholder="http://your-cafe.com" value="<?= $website ?>" />
				</div>
			</div>
			<div>
				<label for="inputPhone">Phone</label>
				<div>
					<input type="text" id="inputPhone" name='phone' placeholder="(xx) xxxx xxxx" value="<?= $phone ?>" />
				</div>
			</div>
			<div>
				<label for="inputAddress">Address</label>
				<div>
					<textarea id="inputAddress" name='address' rows="5"><?= $address ?></textarea>
				</div>
			</div>
			<div>
				<label for="inputCountries">Countries</label>
				<div>
					<?php wp_terms_checklist(get_the_ID(), array(
						'taxonomy' => 'countries',
					)); ?>
				</div>
			</div>
			<div>
				<label for="inputContent">Description</label>
				<div>
					<?php wp_editor( get_the_content(), 'post_content', array(
						'media_buttons' => false,
					)); ?>
				</div>
			</div>
			<div>
				<label for="inputImages">Images</label>
				<div>
					<?php
						$attachments = get_posts(array(
							'post_type' => 'attachment',
							'numberposts' => -1,
							'post_status' => null,
							'post_parent' => $post->ID
						));
						if ( !$attachments )
							echo "No images";
						else
						{
							?>
							<ul>
								<?php foreach ( $attachments as $attachment ) { ?>
									<li>
										<div>
											<?php the_attachment_link( $attachment->ID , false ); ?>
											<h3><?php echo apply_filters( 'the_title' , $attachment->post_title ); ?></h3>
										</div>
									</li>
								<?php } ?>
							</ul>
							<?php
						}
					?>
					<input type="file" name="image" />
				</div>
			</div>
		</div>
		<div>
			<button data-dismiss="modal">Close</button>
			<button>Save changes</button>
		</div>
	</div>
</form>