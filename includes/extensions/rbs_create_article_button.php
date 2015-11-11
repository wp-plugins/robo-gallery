<?php
if ( ! defined( 'WPINC' ) )  die;

 //add_action( 'admin_footer', 'rbs_create_article_button_javascript' ); 
		function rbs_create_article_button_javascript() { 
			$postId = 0;
	    	if( isset($_GET['post']) && $_GET['post'] ){
	    		$postId = (int) $_GET['post'];
	    	}

			?>
			<script type="text/javascript" >
			jQuery(document).ready(function($) {

				var data = {
					'action': 'rbs_gallery_ajax',
					'whatever': 1234,
					'postid': <?php echo $postId; ?>, 
				};

				// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
				jQuery.post(ajaxurl, data, function(response) {
					alert('Got this from the server: ' + response);
				});
			});
			</script> <?php
		}