<?php
/**
 * Plugin Name: Favorite
 * Plugin URI: #
 * Description: A plugin to add favorite button on posts.
 * Version: 1.0.0
 * Author: Ram
 * Author URI: #
 * Requires at least: 5.2
 * Tested up to: 5.5
 * Requires PHP: 7.0
 * Text Domain: favorite-post
 * Domain Path: /languages/
 * License: GPL2+
 */

if ( !defined( 'ABSPATH') ){
    exit;
}

define ( 'FAVORITE_POST_VERSION' , '1.0.0' );
define ( 'FAVORITE_POST_PLUGIN_DIR' , untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define ( 'FAVORITE_POST_PLUGIN_URL' , plugins_url( basename( plugin_dir_path( __FILE__ ) , basename( __FILE__ ) ) ) );
define ( 'FAVORITE_POST_BASENAME' , plugin_basename( __FILE__ ) );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

require_once dirname(__FILE__) . '/includes/favorite-admin-functions.php';

require_once dirname(__FILE__) . '/includes/favorite-widgets.php';

require_once dirname(__FILE__) . '/includes/favorite-api.php';

add_action( 'wp_enqueue_scripts', 'favorite_post_enqueue_style' );

function favorite_post_enqueue_style() {
    wp_enqueue_style( 'favorite-post', FAVORITE_POST_PLUGIN_URL.'/style.css' );
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'custom-script', FAVORITE_POST_PLUGIN_URL. '/assets/js/custom-script.js', array(), '1.0.0', true );
    wp_localize_script( 'custom-script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));

}