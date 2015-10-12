<?php
/**
 * @link              http://robosoft.co/robogallery
 * @since             1.0.0
 * @package           Robo_Gallery
 *
 * @wordpress-plugin
 * Plugin Name:       Robo Gallery
 * Plugin URI:        http://robosoft.co/robogallery
 * Description:       A responsive, easy and elegant way to show gallery.
 * Version:           1.3.5
 * Author:            RoboSoft (c)
 * Author URI:        http://robosoft.co/robogallery
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rbs_gallery
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) )  die;
define("ROBO_GALLERY", 1); 
define("ROBO_GALLERY_VERSION", '1.3.5'); 
define("ROBO_GALLERY_PATH", plugin_dir_path( __FILE__ ));
define("ROBO_GALLERY_SPECIAL", 1); 

add_action( 'plugins_loaded', 'rbs_gallery_load_textdomain' );
function rbs_gallery_load_textdomain() {
  load_plugin_textdomain( 'rbs_gallery', false, dirname(plugin_basename( __FILE__ )) . '/languages' ); 
}

if( file_exists(WP_PLUGIN_DIR.'/robogallerykey/robogallerykey.php') ){
	define("ROBO_GALLERY_PRO", 1);
	define("ROBO_GALLERY_KEY_PATH", plugin_dir_path(WP_PLUGIN_DIR.'/robogallerykey/robogallerykey.php' ));
} else if( file_exists(ROBO_GALLERY_PATH.'robogallerykey.php') ){
	define("ROBO_GALLERY_PRO", 1);
	define("ROBO_GALLERY_KEY_PATH", plugin_dir_path(ROBO_GALLERY_PATH.'robogallerykey.php' ));
} else {
	define("ROBO_GALLERY_PRO", 0);
}

define("ROBO_GALLERY_INCLUDES_PATH", ROBO_GALLERY_PATH.'includes/');
define("ROBO_GALLERY_FRONTEND_PATH", ROBO_GALLERY_INCLUDES_PATH.'frontend/');
define("ROBO_GALLERY_CMB_PATH", ROBO_GALLERY_PATH.'cmb2/');
define("ROBO_GALLERY_CMB_FILEDS_PATH", ROBO_GALLERY_CMB_PATH.'fields/');

define("ROBO_GALLERY_URL", plugin_dir_url( __FILE__ ));

function activateRoboGallery() {
	require_once ROBO_GALLERY_INCLUDES_PATH.'rbs_class_activator.php';
	RoboGalleryActivator::activate();
}
register_activation_hook( __FILE__, 'activateRoboGallery' );

function deactivateRoboGallery() {
	require_once ROBO_GALLERY_INCLUDES_PATH.'rbs_class_activator.php';
	RoboGalleryActivator::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivateRoboGallery' );

if( file_exists(ROBO_GALLERY_INCLUDES_PATH.'rbs_gallery_init.php') )  require_once ROBO_GALLERY_INCLUDES_PATH.'rbs_gallery_init.php';