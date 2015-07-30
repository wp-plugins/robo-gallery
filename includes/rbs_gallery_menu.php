<?php 
/*
*      Robo Gallery     
*      Version: 1.0
*      By Robosoft
*
*      Contact: http://robosoft.co
*      Created: 2015
*      Licensed under the GPLv2 license - http://opensource.org/licenses/gpl-2.0.php
*
*      Copyright (c) 2014-2015, Robosoft. All rights reserved.
*      Available only in http://robosoft.co/
*/

if(!function_exists('robo_gallery_fix_menu')){
	function robo_gallery_fix_menu(){
		if( 
			isset($_GET['post_type']) && $_GET['post_type']=='robo_gallery_table' &&
			isset($_GET['page']) && $_GET['page']=='robo-gallery-support' 
		) wp_redirect( "http://robosoft.co/go.php?product=gallery&task=support" );

		if( 
			isset($_GET['post_type']) && $_GET['post_type']=='robo_gallery_table' &&
			isset($_GET['page']) && $_GET['page']=='robo-gallery-demo' 
		) wp_redirect( "http://robosoft.co/go.php?product=gallery&task=demo" );

		if( 
			isset($_GET['post_type']) && $_GET['post_type']=='robo_gallery_table' &&
			isset($_GET['page']) && $_GET['page']=='robo-gallery-guides' 
		) wp_redirect( "http://robosoft.co/go.php?product=gallery&task=guides" );
	}
	add_action( 'init', 'robo_gallery_fix_menu' );
}



add_action('admin_menu', 'robo_gallery_about_submenu_page');
function robo_gallery_about_submenu_page() {
	add_submenu_page( 'edit.php?post_type=robo_gallery_table', 'About Robo Gallery', 'About', 'manage_options', 'robo-gallery-about', function(){
		 rbs_gallery_include('rbs_gallery_about.php', ROBO_GALLERY_INCLUDES_PATH);
	} );
}

add_action('admin_menu', 'robo_gallery_support_submenu_page');
function robo_gallery_support_submenu_page() {
	add_submenu_page( 'edit.php?post_type=robo_gallery_table', 'Robo Gallery Support', 'Support', 'manage_options', 'robo-gallery-support', function(){ 
			echo '<script> window.open("http://robosoft.co/go.php?product=gallery&task=support", "_bank"); window.open("edit.php?post_type=robo_gallery_table", "_self"); </script>'; 
	} );
}

add_action('admin_menu', 'robo_gallery_demo_submenu_page');
function robo_gallery_demo_submenu_page() {
	add_submenu_page( 'edit.php?post_type=robo_gallery_table', 'Robo Gallery Demo', 'Gallery Demo', 'manage_options', 'robo-gallery-demo', function(){} );
}

add_action('admin_menu', 'robo_gallery_guides_submenu_page');
function robo_gallery_guides_submenu_page() {
	add_submenu_page( 'edit.php?post_type=robo_gallery_table', 'Robo Gallery Video Guides', 'Video Guides', 'manage_options', 'robo-gallery-guides', function(){} );
}

if(!function_exists('rbs_gallery_menuConfig')){
	function rbs_gallery_menuConfig(){
		wp_enqueue_script('robo-gallery-menu', ROBO_GALLERY_URL.'js/admin/menu.js', array( 'jquery' ), ROBO_GALLERY_VERSION, true ); 
	}
	add_action( 'in_admin_header', 'rbs_gallery_menuConfig' );
}

