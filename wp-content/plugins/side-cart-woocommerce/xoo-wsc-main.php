<?php
/**
* Plugin Name: Side Cart WooCommerce
* Plugin URI: http://xootix.com/side-cart-woocommerce
* Author: XootiX
* Version: 2.5.4
* Text Domain: side-cart-woocommerce
* Domain Path: /languages
* Author URI: http://xootix.com
* Description: Manage your cart from just a click away
* Tags: popup,floating cart,ajax,cart,slider
*/


//Exit if accessed directly
if( !defined('ABSPATH') ){
	return;
}

if ( ! defined( 'XOO_WSC_PLUGIN_FILE' ) ) {
	define( 'XOO_WSC_PLUGIN_FILE', __FILE__ );
}

/**
 * Initialize
 *
 * @since    1.0.0
 */
function xoo_wsc_init(){

	if( !class_exists( 'woocommerce' ) ) return;

	do_action( 'xoo_wsc_before_plugin_activation' );

	if ( ! class_exists( 'Xoo_Wsc_Loader' ) ) {
		require_once 'includes/class-xoo-wsc-loader.php';
	}

	xoo_wsc();

	
}
add_action( 'plugins_loaded','xoo_wsc_init', 15 );

function xoo_wsc(){
	return Xoo_Wsc_Loader::get_instance();
}