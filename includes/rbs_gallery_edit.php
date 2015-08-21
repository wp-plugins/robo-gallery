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

function rbs_gallery_group_metabox() {

	function rbs_gallery_set_checkbox_default_for_new_post( $default ) {
		return rbs_gallery_is_edit_page('edit') ? '' : ( $default ? (string) $default : '' );
	}
	if( rbs_gallery_is_edit_page('edit') ){
		if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_copy.php') )    	require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_copy.php';
	}
	if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_images.php') )		require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_images.php';
    
    if( rbs_gallery_is_edit_page('edit') ){
      if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_shortcode.php') )	require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_shortcode.php';
	}

	if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_size.php') )    	require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_size.php';
	if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_view.php') )    	require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_view.php';
	
	if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_hover.php') )   	require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_hover.php';

	if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_button.php') )		require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_button.php';	

	if( !ROBO_GALLERY_PRO &&  file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_infowide.php') )require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_infowide.php';
	
	if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_loading.php') )		require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_loading.php';

	if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_polaroid.php') )	require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_polaroid.php';

	if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_lightbox.php') )	require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_lightbox.php';

	if( !ROBO_GALLERY_PRO && file_exists(ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_info.php') )	require_once ROBO_GALLERY_INCLUDES_PATH.'options/rbs_gallery_options_info.php';

}
add_action( 'cmb2_init', 'rbs_gallery_group_metabox' );


