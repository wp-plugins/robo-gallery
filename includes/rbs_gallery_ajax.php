<?php
if ( ! defined( 'WPINC' ) )  die;

add_action( 'wp_ajax_rbs_gallery_ajax', 'rbs_gallery_ajax_callback' );
function rbs_gallery_ajax_callback() {
	global $wpdb; 
	$whatever = intval( $_POST['whatever'] );
	$postid = intval( $_POST['postid'] );
	$whatever += 10;
	echo $whatever." id:".$postid;
	wp_die();
}
