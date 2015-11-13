<?php
if ( ! defined( 'WPINC' ) )  die;

if(!function_exists('rbs_gallery_ajax_callback')){
	add_action( 'wp_ajax_rbs_gallery', 'rbs_gallery_ajax_callback' );
	function rbs_gallery_ajax_callback(){
		if(isset($_POST['function']) && $_POST['function']){
			$functionName = 'rbs_ajax_'.$_POST['function'];
			if( function_exists( $functionName ) ) $functionName();
		}
		wp_die();
	}
}

