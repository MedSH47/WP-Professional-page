<?php

/**
 *
 * One Click SSL & Force HTTPS
 *
 * Plugin Name:       WP Encryption - One Click SSL & Force HTTPS
 * Plugin URI:        https://wpencryption.com
 * Description:       Secure your WordPress site with free SSL certificate and force HTTPS. Enable HTTPS padlock. Just activating this plugin won't help! - Please run the SSL install form of WP Encryption found on left panel.
 * Version:           7.4.0
 * Author:            WP Encryption SSL HTTPS
 * Author URI:        https://wpencryption.com
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       wp-letsencrypt-ssl
 * Domain Path:       /languages
 *
 * @author      WP Encryption SSL
 * @category    Plugin
 * @package     WP Encryption
 * @license     http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 * 
 * @copyright   Copyright (C) 2019-2024, Go Web Smarty (vj@gowebsmarty.com)
 *
 * 
 */
/**
 * Die on direct access
 */
if ( !defined( 'ABSPATH' ) ) {
    die( 'Access Denied' );
}
/**
 * Definitions
 */
if ( !defined( 'WPLE_PLUGIN_VER' ) ) {
    define( 'WPLE_PLUGIN_VER', '7.4.0' );
}
if ( !defined( 'WPLE_BASE' ) ) {
    define( 'WPLE_BASE', plugin_basename( __FILE__ ) );
}
if ( !defined( 'WPLE_DIR' ) ) {
    define( 'WPLE_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WPLE_URL' ) ) {
    define( 'WPLE_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WPLE_NAME' ) ) {
    define( 'WPLE_NAME', 'WP Encryption' );
}
if ( !defined( 'WPLE_SLUG' ) ) {
    define( 'WPLE_SLUG', 'wp_encryption' );
}
$wple_updir = wp_upload_dir();
$uploadpath = $wple_updir['basedir'] . '/';
if ( !file_exists( $uploadpath ) ) {
    $uploadpath = ABSPATH . 'wp-content/uploads/wp_encryption/';
}
if ( !defined( 'WPLE_UPLOADS' ) ) {
    define( 'WPLE_UPLOADS', $uploadpath );
}
if ( !defined( 'WPLE_DEBUGGER' ) ) {
    define( 'WPLE_DEBUGGER', WPLE_UPLOADS . 'wp_encryption/' );
}
/**
 * Freemius
 */
if ( function_exists( 'wple_fs' ) ) {
    wple_fs()->set_basename( false, __FILE__ );
} else {
    if ( !function_exists( 'wple_fs' ) ) {
        // Activate multisite network integration.
        if ( !defined( 'WP_FS__PRODUCT_5090_MULTISITE' ) ) {
            define( 'WP_FS__PRODUCT_5090_MULTISITE', true );
        }
        // Create a helper function for easy SDK access.
        function wple_fs() {
            global $wple_fs;
            ///$showpricing = (FALSE !== get_option('wple_no_pricing')) ? false : true;
            $showpricing = true;
            if ( !isset( $wple_fs ) ) {
                // Include Freemius SDK.
                require_once dirname( __FILE__ ) . '/freemius/start.php';
                $wple_fs = fs_dynamic_init( array(
                    'id'             => '5090',
                    'slug'           => 'wp-letsencrypt-ssl',
                    'premium_slug'   => 'wp-letsencrypt-ssl-pro',
                    'type'           => 'plugin',
                    'public_key'     => 'pk_f6a07c106bf4ef064d9ac4b989e02',
                    'is_premium'     => false,
                    'has_addons'     => false,
                    'has_paid_plans' => true,
                    'menu'           => array(
                        'slug'    => 'wp_encryption',
                        'support' => false,
                        'contact' => false,
                        'pricing' => $showpricing,
                    ),
                    'is_live'        => true,
                ) );
            }
            return $wple_fs;
        }

        // Init Freemius.
        wple_fs();
        // Signal that SDK was initiated.
        do_action( 'wple_fs_loaded' );
    }
}
require_once WPLE_DIR . 'classes/le-trait.php';
/**
 * Plugin Activator hook
 */
register_activation_hook( __FILE__, 'wple_activate' );
if ( !function_exists( 'wple_activate' ) ) {
    function wple_activate(  $networkwide  ) {
        require_once WPLE_DIR . 'classes/le-activator.php';
        WPLE_Activator::activate( $networkwide );
    }

}
/**
 * Plugin Deactivator hook
 */
register_deactivation_hook( __FILE__, 'wple_deactivate' );
if ( !function_exists( 'wple_deactivate' ) ) {
    function wple_deactivate() {
        require_once WPLE_DIR . 'classes/le-deactivator.php';
        WPLE_Deactivator::deactivate();
    }

}
/**
 * Class to handle all aspects of plugin page
 */
require_once WPLE_DIR . 'admin/le_admin.php';
new WPLE_Admin();
/**
 * Admin Pages
 * @since 5.0.0
 */
require_once WPLE_DIR . 'admin/le_admin_pages.php';
new WPLE_SubAdmin();
/**
 * Force SSL on frontend
 */
require_once WPLE_DIR . 'classes/le-forcessl.php';
new WPLE_ForceSSL();
/**
 * Scannr
 * 
 * @since 5.1.8
 */
require_once WPLE_DIR . 'classes/le-scanner.php';
new WPLE_Scanner();
if ( function_exists( 'wple_fs' ) && !function_exists( 'wple_fs_custom_connect_message' ) ) {
    function wple_fs_custom_connect_message(  $message  ) {
        $current_user = wp_get_current_user();
        return sprintf( esc_html__( 'Howdy %1$s' ) . ',<br>' . __( 'Due to security nature of this plugin, We <b>HIGHLY</b> recommend you opt-in to our security & feature updates notifications, and <a href="https://freemius.com/wordpress/usage-tracking/5090/wp-letsencrypt-ssl/" target="_blank">non-sensitive diagnostic tracking</a> to get BEST support. If you skip this, that\'s okay! <b>WP Encryption</b> will still work just fine.', 'wp-letsencrypt-ssl' ), ucfirst( $current_user->user_nicename ) );
    }

    wple_fs()->add_filter( 'connect_message', 'wple_fs_custom_connect_message' );
}
/**
 * Support forum URL for Premium
 * 
 * @since 5.3.2
 */
if ( wple_fs()->is_premium() && !function_exists( 'wple_premium_forum' ) ) {
    function wple_premium_forum(  $wp_org_support_forum_url  ) {
        return 'https://gowebsmarty.in/';
    }

    wple_fs()->add_filter( 'support_forum_url', 'wple_premium_forum' );
}
/**
 * Dont show cancel subscription popup
 * 
 * @since 5.3.2
 */
wple_fs()->add_filter( 'show_deactivation_subscription_cancellation', '__return_false' );
/**
 * Security Init
 * 
 * @since 7.0.0
 */
require_once WPLE_DIR . 'classes/le-security.php';
new WPLE_Security();