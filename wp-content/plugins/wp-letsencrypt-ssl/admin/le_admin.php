<?php

/**
 * @package WP Encryption
 *
 * @author     Go Web Smarty
 * @copyright  Copyright (C) 2019-2024, Go Web Smarty
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link       https://gowebsmarty.com
 * @since      Class available since Release 1.0.0
 *
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 */
/**
 * Autoloader
 * 
 * @since 5.1.1
 */
require_once plugin_dir_path( __DIR__ ) . 'vendor/autoload.php';
use WPLEClient\LEFunctions;
require_once WPLE_DIR . 'admin/le_ajax.php';
require_once WPLE_DIR . 'admin/le_handlers.php';
require_once WPLE_DIR . 'classes/le-core.php';
require_once WPLE_DIR . 'classes/le-subdir-challenge.php';
/**
 * WPLE_Admin class
 * 
 * Handles all the aspects of plugin page & cert generation form
 * @since 1.0.0
 */
class WPLE_Admin {
    public function __construct() {
        new WPLE_Ajax();
        new WPLE_Handler();
        ///wple_fs()->add_filter('freemius_pricing_js_path', [$this, 'my_custom_pricing_js_path']);
        add_action( 'admin_enqueue_scripts', array($this, 'wple_admin_styles') );
        add_action( 'admin_menu', array($this, 'wple_admin_menu_page') );
        add_action(
            'before_wple_admin_form',
            array($this, 'wple_debug_log'),
            20,
            1
        );
        add_action( 'plugins_loaded', array($this, 'wple_load_plugin_textdomain') );
        add_action( 'admin_init', [$this, 'wple_basic_get_requests'] );
        //review request
        $show_rev = get_option( 'wple_show_review' );
        if ( $show_rev != FALSE && $show_rev == 1 && FALSE === get_option( 'wple_show_review_disabled' ) ) {
            add_action( 'admin_notices', array($this, 'wple_rateus') );
        }
        if ( FALSE !== get_option( 'wple_show_reminder' ) ) {
            //ssl expiring in 10 days
            add_action( 'admin_notices', [$this, 'wple_reminder_notice'] );
        }
        if ( FALSE !== get_option( 'wple_mixed_issues' ) && FALSE === get_option( 'wple_mixed_issues_disabled' ) ) {
            //since 5.3.12
            add_action( 'admin_notices', [$this, 'wple_mixed_content_notice'] );
        }
        if ( isset( $_GET['successnotice'] ) ) {
            //settings saved
            add_action( 'admin_notices', array($this, 'wple_success_notice') );
        }
        /** Admin Notices End */
        add_action( 'wple_show_reviewrequest', array($this, 'wple_set_review_flag') );
        add_action( 'wple_show_mxalert', array($this, 'wple_set_mxerror_flag') );
        add_action( 'wple_ssl_reminder_notice', [$this, 'wple_start_show_reminder'] );
        add_filter( 'fs_uninstall_reasons_wp-letsencrypt-ssl', [$this, 'wple_oneyearprom'], 1 );
        add_action( 'wple_init_ssllabs', [$this, 'wple_initialize_ssllabs'] );
        add_action( 'wple_ssl_expiry_update', [$this, 'wple_update_expiry_ssllabs'] );
    }

    // function my_custom_pricing_js_path($default_pricing_js_path)
    // {
    //   return WPLE_DIR . '/admin/pricing/dist/freemius-pricing.js';
    // }
    /**
     * Enqueue admin styles
     * 
     * @since 1.0.0
     * @return void
     */
    public function wple_admin_styles() {
        wp_enqueue_style(
            WPLE_NAME,
            WPLE_URL . 'admin/css/le-admin.min.css',
            FALSE,
            WPLE_PLUGIN_VER,
            'all'
        );
        wp_enqueue_script(
            WPLE_NAME . '-popper',
            WPLE_URL . 'admin/js/popper.min.js',
            array('jquery'),
            WPLE_PLUGIN_VER,
            true
        );
        wp_enqueue_script(
            WPLE_NAME . '-tippy',
            WPLE_URL . 'admin/js/tippy-bundle.iife.min.js',
            array('jquery'),
            WPLE_PLUGIN_VER,
            true
        );
        wp_enqueue_script(
            WPLE_NAME,
            WPLE_URL . 'admin/js/le-admin.js',
            array('jquery', WPLE_NAME . '-tippy', WPLE_NAME . '-popper'),
            WPLE_PLUGIN_VER,
            true
        );
        wp_enqueue_script(
            WPLE_NAME . '-fs',
            'https://checkout.freemius.com/checkout.min.js',
            array('jquery'),
            WPLE_PLUGIN_VER,
            false
        );
        wp_localize_script( WPLE_NAME, 'SCAN', array(
            'adminajax' => admin_url( '/admin-ajax.php' ),
            'base'      => site_url( '/', 'https' ),
        ) );
    }

    /**
     * Register plugin page
     *
     * @since 1.0.0
     * @return void
     */
    public function wple_admin_menu_page() {
        add_menu_page(
            WPLE_NAME,
            WPLE_NAME,
            'manage_options',
            WPLE_SLUG,
            array($this, 'wple_menu_page'),
            plugin_dir_url( __DIR__ ) . 'admin/assets/icon.png',
            100
        );
    }

    /**
     * Text Domain
     *
     * @return void
     */
    public function wple_load_plugin_textdomain() {
        load_plugin_textdomain( 'wp-letsencrypt-ssl', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Plugin page HTML
     *
     * @since 1.0.0
     * @return void
     */
    public function wple_menu_page() {
        if ( FALSE === get_option( 'wple_version' ) ) {
            delete_option( 'wple_plan_choose' );
            update_option( 'wple_version', WPLE_PLUGIN_VER );
        } else {
            if ( version_compare( get_option( 'wple_version' ), '6.6.0', '<=' ) ) {
                delete_option( 'wple_plan_choose' );
                update_option( 'wple_version', WPLE_PLUGIN_VER );
            }
        }
        $this->wple_subdir_ipaddress();
        //localhost check
        $eml = '';
        $leopts = get_option( 'wple_opts' );
        $eml = ( is_array( $leopts ) && isset( $leopts['email'] ) ? $leopts['email'] : '' );
        $pluginmode = 'FREE';
        $errorclass = '';
        if ( !wple_fs()->is__premium_only() && wple_fs()->can_use_premium_code() ) {
            $pluginmode = 'FREE plugin with PRO License <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Please upload and activate PRO plugin file via PLUGINS page"></span>';
            $errorclass = ' notproerror';
        }
        if ( wple_fs()->is__premium_only() && !wple_fs()->can_use_premium_code() ) {
            $pluginmode = 'PRO plugin with FREE License <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Please activate PRO license key via Account page or Activate License option under the plugin on PLUGINS page"></span>';
            $errorclass = ' notproerror';
        }
        $html = '
    <div class="wple-header">
      <div>
      <img src="' . WPLE_URL . 'admin/assets/logo.png" class="wple-logo"/> <span class="wple-version">v' . WPLE_PLUGIN_VER . ' <span class="wple-pmode' . $errorclass . '">' . $pluginmode . '</span></span>
      </div>';
        WPLE_Trait::wple_headernav( $html );
        $html .= '</div>';
        if ( isset( $_GET['error'] ) ) {
            $this->wple_error_block( $html );
        }
        if ( FALSE === get_option( 'wple_plan_choose' ) || isset( $_GET['comparison'] ) ) {
            $this->wple_initial_quick_pricing( $html );
            return;
        }
        /** verification page start */
        $isVerifying = ( get_option( 'wple_ssl_screen' ) == 'verification' ? 1 : 0 );
        if ( isset( $_GET['subdir'] ) || $isVerifying ) {
            update_option( 'wple_ssl_screen', 'verification' );
            $this->wple_subdir_challenges( $html, $leopts );
            $this->wple_upgrade_block( $html );
            echo $html;
            return;
        }
        $isComplete = ( get_option( 'wple_ssl_screen' ) == 'complete' ? 1 : 0 );
        if ( isset( $_GET['complete'] ) || $isComplete ) {
            update_option( 'wple_ssl_screen', 'complete' );
            $this->wple_complete_block( $html );
            if ( !wple_fs()->is__premium_only() || !wple_fs()->can_use_premium_code() ) {
                $this->wple_upgrade_block( $html );
            }
            echo $html;
            return;
        }
        //5.1.0
        $isSuccess = ( get_option( 'wple_ssl_screen' ) == 'success' ? 1 : 0 );
        if ( isset( $_GET['success'] ) || $isSuccess ) {
            update_option( 'wple_ssl_screen', 'success' );
            $html .= '<div id="wple-sslgen">';
            $this->wple_success_block( $html );
            $html .= '</div>';
            if ( !wple_fs()->is__premium_only() || !wple_fs()->can_use_premium_code() ) {
                $this->wple_upgrade_block( $html );
            }
            echo $html;
            return;
        }
        /** verification page end */
        // $prosupport = WPLE_Trait::wple_kses(sprintf(
        //   __('Brought to you by %sWP Encryption%s.'),
        //   '<a href="https://wpencryption.com" target="_blank">',
        //   '</a>'
        // ), 'a');
        // if (wple_fs()->is__premium_only()) {
        //   $prosupport = 'Premium support forum - <a href="https://gowebsmarty.in" target="_blank">https://gowebsmarty.in</a>.';
        // }
        if ( !is_plugin_active( 'backup-bolt/backup-bolt.php' ) && FALSE === get_option( 'wple_backup_suggested' ) ) {
            $action = 'install-plugin';
            $slug = 'backup-bolt';
            $pluginstallURL = wp_nonce_url( add_query_arg( array(
                'action' => $action,
                'plugin' => $slug,
            ), admin_url( 'update.php' ) ), $action . '_' . $slug );
            $html .= '
      <div class="le-powered">
      <span style="display: flex;align-items: center;"><strong>Recommended:-</strong> Before enforcing HTTPS, We highly recommend taking a backup of your site using some good backup plugin like <img src="' . WPLE_URL . 'admin/assets/backup-bolt.png" style="max-width:120px"> - <a href="' . $pluginstallURL . '" target="_blank">Install & Activate Backup Bolt</a> | <a href="#" class="wple-backup-skip">Ignore</a></span>    
      </div>';
        }
        $mappeddomain = '';
        $formheader = esc_html__( 'SSL INSTALL FORM - ENTER YOUR EMAIL BELOW & GENERATE SSL CERTIFICATE', 'wp-letsencrypt-ssl' );
        $currentdomain = esc_html( str_ireplace( array('http://', 'https://'), array('', ''), site_url() ) );
        $maindomain = $currentdomain;
        $slashpos = stripos( $currentdomain, '/' );
        if ( false !== $slashpos ) {
            //subdir installation
            $maindomain = substr( $currentdomain, 0, $slashpos );
            $mappeddomain = '<label style="display: block; padding: 10px 5px; color: #aaa;font-size:15px;">' . esc_html__( 'PRIMARY DOMAIN', 'wp-letsencrypt-ssl' ) . '</label>
      <p style="width: 800px; max-width:100%; margin: 5px auto 20px;">' . WPLE_Trait::wple_kses( sprintf( __( '<strong>NOTE:</strong> Since you are willing to install SSL certificate for sub-directory site, SSL certificate will be generated for your primary domain <strong>%s</strong> which will cover your primary domain + All sub-directory sites.', 'wp-letsencrypt-ssl' ), $maindomain ) ) . '</p>
    <input type="text" name="wple_domain" class="wple-domain-input" value="' . esc_attr( $maindomain ) . '" readonly><br />';
        }
        //since 5.3.4
        $tempdomain = '';
        if ( false !== stripos( $maindomain, 'temp.domains' ) || false !== stripos( $maindomain, '~' ) ) {
            $tempdomain = '<p style="width: 800px; max-width:100%; margin: 5px auto 20px;">' . sprintf(
                esc_html__( "%sWARNING:%s You are trying to install SSL for %stemporary domain%s which is not possible. Please point your real domain like wpencryption.com to your site and update your site url in %ssettings%s > %sgeneral%s before you could generate SSL.", "wp-letsencrypt-ssl" ),
                "<strong>",
                "</strong>",
                "<strong>",
                "</strong>",
                "<strong>",
                "</strong>",
                "<strong>",
                "</strong>"
            ) . '</p>';
        }
        if ( isset( $leopts['type'] ) && $leopts['type'] == 'wildcard' ) {
            $html .= '<script>
      jQuery(document).ready(function(){
        jQuery(".single-wildcard-switch").trigger("click");
      });
      </script>';
        }
        $html .= '<div id="wple-sslgen">
    <h2>' . $formheader . '</h2>
    <div style="text-align: center; margin-top: -30px; font-size: 16px; display: block; width: 100%; margin-bottom: 40px;"><a style="text-decoration-style:dashed;text-decoration-thickness: from-font;" href="' . admin_url( 'admin.php?page=wp_encryption_faq#howitworks' ) . '">How it works?</a></div>';
        if ( is_multisite() && !wple_fs()->can_use_premium_code__premium_only() ) {
            $html .= '<p class="wple-multisite">' . WPLE_Trait::wple_kses( __( 'Upgrade to <strong>PRO</strong> version to avail Wildcard SSL support for multisite and ability to install SSL for mapped domains (different domain names).', 'wp-letsencrypt-ssl' ) ) . '</p>';
        }
        $html .= WPLE_Trait::wple_progress_bar();
        //$cname = '';
        //if (FALSE === stripos($currentdomain, '/')) {
        // if (stripos($currentdomain, 'www') === FALSE) {
        //   $cname = '<span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__("Add a CNAME with name 'www' pointing to your non-www domain", 'wp-letsencrypt-ssl') . '. ' . esc_attr__("Refer FAQ if you want to generate SSL for both www & non-www domain.", 'wp-letsencrypt-ssl') . '"></span>';
        // } else {
        //$cname = '<span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__("Refer FAQ if you want to generate SSL for both www & non-www domain.", 'wp-letsencrypt-ssl') . '"></span>';
        //}
        //}
        $bothchecked = '';
        $leadminform = '<form method="post" class="le-genform single-genform">' . $mappeddomain . $tempdomain . '
    <input type="email" name="wple_email" class="wple_email" value="' . esc_attr( $eml ) . '" placeholder="' . esc_attr__( 'Enter your email address', 'wp-letsencrypt-ssl' ) . '" title="' . esc_attr__( 'All email notifications are sent to this email ID', 'wp-letsencrypt-ssl' ) . '" ><br />';
        // if (FALSE === stripos($maindomain, 'www')) {
        //   $altdomain = 'www.' . $maindomain;
        // } else {
        //   $altdomain = str_ireplace('www.', '', $maindomain);
        // }
        // $altdomaintest = wp_remote_head('http://' . $altdomain, array('sslverify' => false, 'timeout' => 30));
        ///if (!is_wp_error($altdomaintest) || isset($_GET['includewww'])) {
        if ( isset( $_GET['includewww'] ) ) {
            $bothchecked = 'checked';
        }
        $leadminform .= '<span class="lecheck">
      <label class="checkbox-label">
      <input type="checkbox" name="wple_include_www" class="wple_include_www" value="1" ' . $bothchecked . '>
        <span class="checkbox-custom rectangular"></span>
      </label>
    ' . esc_html__( 'Generate SSL Certificate for both www & non-www version of domain', 'wp-letsencrypt-ssl' ) . '&nbsp; <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( "Before enabling this - please make sure both www & non-www version of your domain works!. Add a CNAME with name 'www' pointing to your non-www domain in your domain DNS zone editor", 'wp-letsencrypt-ssl' ) . '"></span></label>
    </span><br />';
        ///}
        if ( isset( $_GET['includeemail'] ) ) {
            $leadminform .= '<span class="lecheck">
      <label class="checkbox-label">
      <input type="checkbox" name="wple_include_mail" class="wple_include_mail" value="1">
        <span class="checkbox-custom rectangular"></span>
      </label>
    ' . esc_html__( 'Secure POP/IMAP email server', 'wp-letsencrypt-ssl' ) . '&nbsp; <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . sprintf( esc_attr__( "This option will secure %s but DNS based domain verification is MANDATORY", 'wp-letsencrypt-ssl' ), 'mail.' . $maindomain ) . '"></span></label>
    </span><br />';
            $webmail = 'webmail.' . $maindomain;
            $leadminform .= '<span class="lecheck">
      <label class="checkbox-label">
      <input type="checkbox" name="wple_include_webmail" class="wple_include_webmail" value="1">
        <span class="checkbox-custom rectangular"></span>
      </label>
    ' . sprintf( esc_html__( 'Secure %s', 'wp-letsencrypt-ssl' ), $webmail ) . '&nbsp; <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . sprintf( esc_attr__( "This option will secure %s but DNS based domain verification is MANDATORY", 'wp-letsencrypt-ssl' ), $webmail ) . '"></span></label>
    </span><br />';
        }
        $leadminform .= '<span class="lecheck">
      <label class="checkbox-label">
      <input type="checkbox" name="wple_send_usage" value="1" checked>
        <span class="checkbox-custom rectangular"></span>
      </label>
    ' . esc_html__( 'Anonymously send response data to get better support', 'wp-letsencrypt-ssl' ) . '</label>
    </span><br />';
        $leadminform .= '<span class="lecheck">
    <label class="checkbox-label">
      <input type="checkbox" name="wple_agree_le_tos" class="wple_agree_le" value="1">
      <span class="checkbox-custom rectangular"></span>
    </label>
    ' . WPLE_Trait::wple_kses( sprintf(
            __( "I agree to %sLet's Encrypt%s %sTerms of service%s", "wp-letsencrypt-ssl" ),
            '<b>',
            '<sup style="font-size: 10px; padding: 3px">TM</sup></b>',
            '<a href="' . esc_attr__( 'https://letsencrypt.org/documents/LE-SA-v1.2-November-15-2017.pdf', 'wp-letsencrypt-ssl' ) . '" rel="nofollow" target="_blank" style="margin-left:5px">',
            '</a>'
        ), 'a' ) . '
    </span> 
    <span class="lecheck">
    <label class="checkbox-label">
      <input type="checkbox" name="wple_agree_gws_tos" class="wple_agree_gws" value="1">
      <span class="checkbox-custom rectangular"></span>
    </label>
    ' . WPLE_Trait::wple_kses( sprintf( __( "I agree to <b>WP Encryption</b> %sTerms of service%s", "wp-letsencrypt-ssl" ), '<a href="https://gowebsmarty.com/terms-and-conditions/" rel="nofollow" target="_blank" style="margin-left:5px">', '</a>' ), 'a' ) . '
    </span>        
    ' . wp_nonce_field(
            'legenerate',
            'letsencrypt',
            false,
            false
        ) . '
    <button type="submit" name="generate-certs" id="singledvssl">' . esc_html__( 'Generate SSL Certificate', 'wp-letsencrypt-ssl' ) . '</button>
    </form>
    
    <div id="wple-error-popper">    
      <div class="wple-flex">
        <img src="' . WPLE_URL . 'admin/assets/loader.png" class="wple-loader"/>
        <div class="wple-error">Error</div>
      </div>
    </div>';
        $nonwww = str_ireplace( 'www.', '', $currentdomain );
        if ( false !== ($ps = stripos( $nonwww, '/' )) ) {
            $nonwww = substr( $nonwww, 0, $ps );
        }
        $wwwdomain = 'www.' . $nonwww;
        if ( false != stripos( $currentdomain, 'www.' ) ) {
            //reverse the order
            $wwwdomain = $nonwww;
            $nonwww = 'www.' . $nonwww;
        }
        $showonpro = '';
        $html .= '<div class="wple-single-dv-ssl">
    <div class="wple-info-box">
      <h3>' . esc_html__( 'Domains Covered', 'wp-letsencrypt-ssl' ) . '</h3>
      <strong>' . $nonwww . '</strong>
      <div class="wple-www' . $showonpro . '"><strong>' . $wwwdomain . '</strong></div>
      <div class="wple-wc"><strong>*.' . $nonwww . '</strong></div>
    </div>';
        ob_start();
        do_action( 'before_wple_admin_form', $html );
        $html .= ob_get_contents();
        ob_end_clean();
        $html .= apply_filters( 'wple_admin_form', $leadminform );
        ob_start();
        do_action( 'after_wple_admin_form', $html );
        $html .= ob_get_contents();
        ob_end_clean();
        $html .= '</div>';
        $html .= '    
    </div><!--wple-sslgen-->';
        if ( !wple_fs()->is__premium_only() || !wple_fs()->can_use_premium_code() ) {
            $this->wple_upgrade_block( $html );
        } else {
            $this->wple_expert_block( $html );
        }
        echo $html;
    }

    /**
     * log process & error in debug.log file
     *
     * @since 1.0.0
     * @param string $html
     * @return void
     */
    public function wple_debug_log( $html ) {
        if ( !file_exists( WPLE_DEBUGGER ) ) {
            wp_mkdir_p( WPLE_DEBUGGER );
            $htacs = '<Files debug.log>' . "\n" . 'Order allow,deny' . "\n" . 'Deny from all' . "\n" . '</Files>';
            file_put_contents( WPLE_DEBUGGER . '.htaccess', $htacs );
        }
        //show only upon error since 4.6.0
        if ( isset( $_GET['error'] ) ) {
            $html = '<div class="toggle-debugger"><span class="dashicons dashicons-arrow-down-alt2"></span> ' . esc_html__( 'Show/hide full response', 'wp-letsencrypt-ssl' ) . '</div>';
            $file = WPLE_DEBUGGER . 'debug.log';
            if ( file_exists( $file ) ) {
                $log = file_get_contents( $file );
                $hideh2 = '';
                if ( isset( $_GET['dnsverified'] ) || isset( $_GET['dnsverify'] ) ) {
                    $hideh2 = 'hideheader';
                }
                $html .= '<div class="le-debugger running ' . $hideh2 . '"><h3>' . esc_html__( 'Response Log', 'wp-letsencrypt-ssl' ) . ':</h3>' . WPLE_Trait::wple_kses( nl2br( $log ) ) . '</div>';
            } else {
                $html .= '<div class="le-debugger">' . esc_html__( "Full response will be shown here", 'wp-letsencrypt-ssl' ) . '</div>';
            }
            echo $html;
        }
    }

    /**
     * Rate us admin notice
     *
     * @since 2.0.0 
     * @return void
     */
    public function wple_rateus() {
        $cert = WPLE_Trait::wple_cert_directory() . 'certificate.crt';
        if ( file_exists( $cert ) ) {
            if ( isset( $_GET['page'] ) && $_GET['page'] == 'wp_encryption' ) {
                return;
            }
            $reviewnonce = wp_create_nonce( 'wplereview' );
            $html = '<div class="notice notice-info wple-admin-review">
        <div class="wple-review-box">
          <img src="' . WPLE_URL . 'admin/assets/symbol.png"/>
          <span><strong>' . esc_html__( 'Congratulations!', 'wp-letsencrypt-ssl' ) . '</strong><p>' . WPLE_Trait::wple_kses( __( 'SSL certificate generated successfully!. <b>WP Encryption</b> just saved you several $$$ by generating free SSL certificate in record time!. Could you please do us a BIG favor & rate us with 5 star review to support further development of this plugin.', 'wp-letsencrypt-ssl' ) ) . '</p></span>
        </div>
        <a class="wple-lets-review wplerevbtn" href="https://wordpress.org/support/plugin/wp-letsencrypt-ssl/reviews/#new-post" rel="nofollow noopener" target="_blank">' . esc_html__( 'Rate plugin', 'wp-letsencrypt-ssl' ) . '</a>
        <a class="wple-did-review wplerevbtn" href="#" data-nc="' . esc_attr( $reviewnonce ) . '" data-action="1">' . esc_html__( "Don't show again", 'wp-letsencrypt-ssl' ) . '</a>
        <a class="wple-later-review wplerevbtn" href="#" data-nc="' . esc_attr( $reviewnonce ) . '" data-action="2">' . esc_html__( 'Remind me later', 'wp-letsencrypt-ssl' ) . '&nbsp;<span class="dashicons dashicons-clock"></span></a>
      </div>';
            echo $html;
        }
    }

    /**
     * Check if wp install is IP or subdir based
     *
     * @since 2.4.0
     * @return void
     */
    public function wple_subdir_ipaddress() {
        $siteURL = str_ireplace( array('http://', 'https://', 'www.'), array('', '', ''), site_url() );
        $flg = 0;
        if ( filter_var( $siteURL, FILTER_VALIDATE_IP ) ) {
            $flg = 1;
        }
        if ( false !== stripos( $siteURL, 'localhost' ) ) {
            $flg = 1;
        }
        if ( false != stripos( $siteURL, '/' ) && is_multisite() ) {
            $html = '<div class="wrap" id="le-wrap">
      <div class="le-inner">
        <div class="wple-header">
          <img src="' . WPLE_URL . 'admin/assets/logo.png" class="wple-logo"/> <span class="wple-version">v' . esc_html( WPLE_PLUGIN_VER ) . '</span>
        </div>
        <div class="wple-warning-notice">
        <h2>' . esc_html__( 'You do not need to install SSL for each sub-directory site in multisite, Please install SSL for your primary domain and it will cover ALL sub directory sites too.', 'wp-letsencrypt-ssl' ) . '</h2>
        </div>
      </div>
      </div>';
            echo $html;
            wp_die();
        }
        if ( $flg ) {
            $html = '<div class="wrap" id="le-wrap">
      <div class="le-inner">
        <div class="wple-header">
          <img src="' . WPLE_URL . 'admin/assets/logo.png" class="wple-logo"/> <span class="wple-version">v' . esc_html( WPLE_PLUGIN_VER ) . '</span>
        </div>
        <div class="wple-warning-notice">
        <h2>' . esc_html__( 'SSL Certificates cannot be issued for localhost and IP address based WordPress site. Please use this on your real domain based WordPress site.', 'wp-letsencrypt-ssl' ) . ' ' . esc_html__( 'This restriction is not implemented by WP Encryption but its how SSL certificates work.', 'wp-letsencrypt-ssl' ) . '</h2>
        </div>
      </div>
      </div>';
            echo $html;
            wp_die();
        }
    }

    /**
     * Upgrade to PRO
     *
     * @param string $html
     * @since 2.5.0
     * @return void
     */
    public function wple_upgrade_block( &$html ) {
        $upgradeurl = admin_url( '/admin.php?page=wp_encryption-pricing' );
        ///$upgradeurl = admin_url('/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=lifetime&pricing_id=7965&currency=usd&coupon=FIRSTBUY');
        $nopricing = get_option( 'wple_no_pricing' );
        //gdy
        $cp = get_option( 'wple_have_cpanel' );
        // if (FALSE === $nopricing && !$cp) { //not gdy & not cpanel
        //   $nopricing = rand(0, 1);
        // }
        $automatic = esc_html__( 'Automatic', 'wp-letsencrypt-ssl' );
        $manual = esc_html__( 'Manual', 'wp-letsencrypt-ssl' );
        $domain = str_ireplace( array('https://', 'http://', 'www.'), '', site_url() );
        $dverify = $automatic;
        if ( stripos( $domain, '/' ) !== false ) {
            //subdir site
            $dverify = $manual;
        }
        $html .= ' 
      <div id="wple-upgradepro">';
        if ( FALSE !== $cp && $cp ) {
            $html .= '<strong style="display: block; text-align: center; color: #666;">Woot Woot! You have <b>CPANEL</b>! Why struggle with manual SSL renewal every 90 days? - Enjoy 100% automation with PRO version.</strong>';
            ///$upgradeurl = admin_url('/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=lifetime&pricing_id=7965&currency=usd');
        }
        $compareurl = 'https://wpencryption.com/?utm_source=wordpress&utm_medium=comparison&utm_campaign=wpencryption';
        //$compareurl = admin_url('/admin.php?page=wp_encryption&comparison=1');
        if ( $nopricing ) {
            $compareurl = admin_url( '/admin.php?page=wp_encryption&comparison=1' );
            //$upgradeurl = admin_url('/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=11394&plan_name=pro&billing_cycle=annual&pricing_id=11717&currency=usd');
            //$upgradeurl = 'https://checkout.freemius.com/mode/dialog/plugin/5090/plan/10643/'; //CDN
            $html .= '<div class="wple-error-firewall fire-pro wple-procdn">
        <div>
          <img src="' . WPLE_URL . 'admin/assets/firewall-shield-pro.png"/>
        </div>
        <div class="wple-upgrade-features">
          <span><b>Automatic SSL Installation</b><br>Hassle free automatic installation of SSL Certificate - Super simple DNS based setup.</span>
          <span><b>Automatic SSL Renewal</b><br>Your SSL certificate will be automatically renewed in background without the need of any action or manual work.</span>
          <span><b>Security</b><br>Enterprise level protection against known vulnerabilities, Bad Bots, Brute Force, DDOS, Spam & much more attack vectors.</span>
          <span><b>Automatic CDN</b><br>Your site is served from 42 full scale edge locations for faster content delivery and fastest performance.</span>
        </div>
      </div>';
        } else {
            $html .= '<div class="wple-plans">
            <span class="free">* ' . esc_html__( 'FREE', 'wp-letsencrypt-ssl' ) . '</span>
            <span class="pro">* ' . esc_html__( 'PRO', 'wp-letsencrypt-ssl' ) . '</span>
          </div>
          <div class="wple-plan-compare">
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/verified.png"/>
              <h4>' . esc_html__( 'HTTP Verification', 'wp-letsencrypt-ssl' ) . '</h4>
              <span class="wple-free">' . $manual . '</span>
              <span class="wple-pro">' . $automatic . '</span>
            </div>
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/DNS.png"/>
              <h4>' . esc_html__( 'DNS Verification', 'wp-letsencrypt-ssl' ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( 'In case of HTTP verification fail / not possible', 'wp-letsencrypt-ssl' ) . '"></span></h4>
              <span class="wple-free">' . $manual . '</span>
              <span class="wple-pro">' . $automatic . '</span>
            </div>
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/Install.png"/>
              <h4>' . esc_html__( 'SSL Installation', 'wp-letsencrypt-ssl' ) . ' <!--<span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( 'PRO - We offer one time free manual support for non-cPanel based sites', 'wp-letsencrypt-ssl' ) . '"></span>--></h4>
              <span class="wple-free">' . $manual . '</span>
              <span class="wple-pro">' . $automatic . '</span>
            </div>
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/renewal.png"/>
              <h4>' . esc_html__( 'SSL Renewal', 'wp-letsencrypt-ssl' ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( 'Free users must manually renew / re-generate SSL certificate every 90 days.', 'wp-letsencrypt-ssl' ) . '"></span></h4>
              <span class="wple-free">' . $manual . '</span>
              <span class="wple-pro">' . $automatic . '</span>
            </div>
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/wildcard.png"/>
              <h4>' . esc_html__( 'Wildcard SSL', 'wp-letsencrypt-ssl' ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( 'PRO - Your domain DNS must be managed by cPanel or Godaddy for full automation', 'wp-letsencrypt-ssl' ) . '"></span></h4>
              <span class="wple-free">' . esc_html__( 'Not Available', 'wp-letsencrypt-ssl' ) . '</span>
              <span class="wple-pro">' . esc_html__( 'Available', 'wp-letsencrypt-ssl' ) . '</span>
            </div>
            <div class="wple-compare-item">
              <img src="' . WPLE_URL . 'admin/assets/multisite.png"/>
              <h4>' . esc_html__( 'Multisite Support', 'wp-letsencrypt-ssl' ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr__( 'PRO - Support for Multisite + Mapped domains', 'wp-letsencrypt-ssl' ) . '"></span></h4>
              <span class="wple-free">' . esc_html__( 'Not Available', 'wp-letsencrypt-ssl' ) . '</span>
              <span class="wple-pro">' . esc_html__( 'Available', 'wp-letsencrypt-ssl' ) . '</span>
            </div>            
          </div>';
        }
        ///$html .= '<div style="text-align:center"><img src="' . WPLE_URL . '/admin/assets/new-year.png"></div>';
        $html .= '<div class="wple-upgrade-pro">
              <a href="' . $compareurl . '" target="_blank" class="wplecompare">' . esc_html__( 'COMPARE FREE & PRO VERSION', 'wp-letsencrypt-ssl' ) . '  <span class="dashicons dashicons-external"></span></a>';
        // if (isset($_GET['success']) && FALSE == $nopricing) {
        //   $html .= '<a href="' . $upgradeurl . '">' . esc_html__('UPGRADE TO PRO', 'wp-letsencrypt-ssl') . '<span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Requires cPanel or root SSH access"></span></a>
        //             <a href="https://wpencryption.com/#firewall" target="_blank">' . esc_html__('UPGRADE TO FIREWALL', 'wp-letsencrypt-ssl') . '<span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Why buy an SSL alone when you can get Premium SSL + CDN + Firewall Security for even lower cost."></span></a>';
        // } else {
        // if ($nopricing) {
        //   $html .= '<a href="' . $upgradeurl . '">' . esc_html__('UPGRADE TO CDN', 'wp-letsencrypt-ssl') . '</a>';
        // } else {
        $html .= '<a href="' . $upgradeurl . '">' . esc_html__( 'UPGRADE TO PRO', 'wp-letsencrypt-ssl' ) . '</a>';
        //}
        //$html .= '<a href="https://checkout.freemius.com/mode/dialog/plugin/5090/plan/10643/" target="_blank" id="upgradetocdn">' . esc_html__('UPGRADE TO CDN', 'wp-letsencrypt-ssl') . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Sky rocket your WordPress site performance with Fastest Content Delivery Network + Premium Sectigo SSL"></span></a>';
        // }
        $html .= '</div>';
        // $rnd = rand(0, 1);
        // if ($rnd) {
        //   $html .= '<div class="wple-hire-expert"><a href="https://wpencryption.com/cdn-firewall/?utm_campaign=wpencryptionsite&utm_medium=checkoutcdn&utm_source=upgradeblock" target="_blank">Sky Rocket your site speed with our <strong>CDN</strong> plan (<strong>Includes SSL + Performance</strong>) <span class="dashicons dashicons-external"></span></a></div>';
        // } else {
        //   $html .= '<div class="wple-hire-expert"><a href="https://wpencryption.com/hire-ssl-expert/?utm_campaign=wpencryptionsite&utm_medium=hiresslexpert&utm_source=upgradeblock" target="_blank">Too busy? <b>Hire an expert</b> for secure migration to HTTPS (<b>ONE YEAR PRO LICENSE FREE</b>) <span class="dashicons dashicons-external"></span></a></div>';
        // }
        $html .= '</div><!--wple-upgradepro-->';
        $html .= WPLE_Trait::wple_other_plugins();
    }

    /**
     * Complete stage block - ssl installation or enable https still pending
     *
     * @param string $html
     * @since 2.5.0
     * @return void
     */
    public function wple_complete_block( &$html ) {
        $html .= '
      <div id="wple-sslgenerator">
      <div class="wple-success-form">';
        $html .= '<h2><span class="dashicons dashicons-yes"></span>&nbsp;' . WPLE_Trait::wple_kses( __( '<b>Congrats! SSL Certificate have been successfully generated.</b>', 'wp-letsencrypt-ssl' ) ) . '</h2>
        <h3 style="width: 87%; margin: 0px auto; color: #7b8279; font-weight:400;">' . WPLE_Trait::wple_kses( __( 'We just completed major task of generating SSL certificate! Now we have ONE final step to complete.', 'wp-letsencrypt-ssl' ) ) . '</h3>';
        $html .= WPLE_Trait::wple_progress_bar();
        ///$nopricing = get_option('wple_no_pricing');
        //$colclass = FALSE != $nopricing ? 'wple-three-cols' : '';
        $html .= '   

        <div class="wple-success-flex">
        <div class="wple-success-flex-video">
        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/aKvvVlAlZ14" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="wple-success-flex-final">  
        <ul class="download-ssl-certs">
          <li>1. ' . sprintf( __( '%sClick here%s to login into your cPanel.', 'wp-letsencrypt-ssl' ), '<a href="' . site_url( 'cpanel' ) . '" target="_blank">', '</a>' ) . '</li>
          <li>2. ' . sprintf( __( 'Open %sSSL/TLS%s option on your cPanel', 'wp-letsencrypt-ssl' ), '<strong><img src="' . WPLE_URL . '/admin/assets/tls.png" style="width: 20px;margin-bottom: -5px;">&nbsp;', '</strong>' ) . '</li>
          <li>3. ' . sprintf( __( 'Click on %sManage SSL Sites%s option', 'wp-letsencrypt-ssl' ), '<strong>', '</strong>' ) . '</li>          
          <li>4. ' . sprintf(
            __( 'Copy the contents of %sCertificate.crt%s, %sPrivate.pem%s, %sCABundle.crt%s files from below & paste them into its appropriate fields on cPanel', 'wp-letsencrypt-ssl' ),
            '<strong>',
            '</strong>',
            '<strong>',
            '</strong>',
            '<strong>',
            '</strong>'
        ) . '. ' . esc_html( "You can also download the cert files to your local computer, right click > open with notepad to view/copy", "wp-letsencrypt-ssl" ) . '</li>
          <li>';
        WPLE_Trait::wple_copy_and_download( $html );
        $nonroot_instruction = sprintf(
            __( "If you have root SSH access, edit your server config file and point your SSL paths to %scertificate.crt%s & %sprivate.pem%s files located in %s folder. If you don't have either cPanel or root SSH access, Upgrade to %sPRO%s version for automatic SSL installation and automatic SSL renewal.", 'wp-letsencrypt-ssl' ),
            '<strong>',
            '</strong>',
            '<strong>',
            '</strong>',
            '<strong>' . WPLE_Trait::wple_cert_directory() . '</strong>',
            '<a href="' . admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=annual&pricing_id=7965&currency=usd' ) . '"><strong>',
            '</strong></a>'
        );
        if ( !get_option( 'wple_parent_reachable' ) ) {
            $nonroot_instruction = sprintf(
                __( "If you have root SSH access, download certificate.crt & private.pem files from above and upload them onto a secure folder on your server. Then edit your server config file and point the SSL paths to uploaded %scertificate.crt%s & %sprivate.pem%s files. If you don't have either cPanel or root SSH access, Upgrade to %sPRO%s version for automatic SSL installation and automatic SSL renewal.", 'wp-letsencrypt-ssl' ),
                '<strong>',
                '</strong>',
                '<strong>',
                '</strong>',
                '<a href="' . admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=annual&pricing_id=7965&currency=usd' ) . '"><strong>',
                '</strong></a>'
            );
        }
        $html .= '</li>
          <li>5. ' . sprintf( __( 'Click on %sInstall certificate%s', 'wp-letsencrypt-ssl' ), '<strong>', '</strong>' ) . '</li>
          <li>6. ' . sprintf( __( 'Please wait few minutes and click on %sEnable HTTPS Now%s button', 'wp-letsencrypt-ssl' ), '<strong>', '</strong>' ) . '</li>
        </ul>

        </div>
        </div>  

            <div class="wple-success-cols wple-three-cols">
              <div>
                <h3>' . esc_html__( "Don't have cPanel?", 'wp-letsencrypt-ssl' ) . '</h3>
                <p>' . esc_html__( "cPanel link goes to 404 not found page?. ", 'wp-letsencrypt-ssl' ) . $nonroot_instruction . '<br><br><span style="display:none">' . sprintf( __( 'You can also upgrade to our %sCDN%s plan to avail fully automatic SSL + Fastest CDN + Firewall Security.', 'wp-letsencrypt-ssl' ), '<a href="https://wpencryption.com/cdn-firewall/" target="_blank">', '</a>' ) . '</span></p>
              </div>
              <div>
                <h3>' . esc_html__( "Test SSL Installation", 'wp-letsencrypt-ssl' ) . '</h3>
                <p>' . esc_html__( "After installing SSL certs on your cPanel, open your site in https:// and click on padlock to see if valid certificate exists. You can also test your site's SSL on SSLLabs.com", "wp-letsencrypt-ssl" ) . '</p>
              </div>
              <div>
                <h3>' . esc_html__( "By Clicking Enable HTTPS", 'wp-letsencrypt-ssl' ) . '</h3>
                <p>' . esc_html__( 'Your site & admin url will be changed to https:// and all assets, js, css, images will strictly load over https:// to avoid mixed content errors.', 'wp-letsencrypt-ssl' ) . '</p>
              </div>';
        // if (FALSE == $nopricing) {
        //   $html .= '<div>
        //         <h3>' . esc_html__("Looking for instant SSL solution?", 'wp-letsencrypt-ssl') . '</h3>
        //         <p>' . sprintf(__('Why pay for an SSL certificate alone when you can get %sPremium Sectigo SSL%s + %sCDN Performance%s + %sSecurity Firewall%s for even lower cost with our %sCDN%s Service.', 'wp-letsencrypt-ssl'), '<strong>', '</strong>', '<strong>', '</strong>', '<strong>', '</strong>', '<a href="https://wpencryption.com/cdn-firewall/?utm_campaign=wpencryption&utm_source=wordpress&utm_medium=gocdn" target="_blank">', '</a>') . '!.</p>
        //       </div>';
        // }
        $html .= '</div>

          <ul>          
          <!--<li>' . WPLE_Trait::wple_kses( __( '<b>Note:</b> Use below "Enable HTTPS" button ONLY after SSL certificate is successfully installed on your cPanel', 'wp-letsencrypt-ssl' ) ) . '</li>-->
          </ul>';
        if ( isset( $_GET['nossl'] ) ) {
            $html .= '<h3 style="color:#ff4343;margin-bottom:10px;margin: 0 auto 10px; max-width: 800px;">' . esc_html__( 'We could not detect valid SSL certificate installed on your site!. Please try after some time. You can also try opening wp-admin via https:// and click on enable https button.', 'wp-letsencrypt-ssl' ) . '</h3>
        <p>' . esc_html__( 'Switching to HTTPS without properly installing the SSL certificate might break your site.', 'wp-letsencrypt-ssl' ) . '</p>';
        }
        $html .= '<form method="post">
        ' . wp_nonce_field(
            'wplehttps',
            'sslready',
            false,
            false
        ) . '
        <button type="submit" name="wple-https">' . esc_html__( 'ENABLE HTTPS NOW', 'wp-letsencrypt-ssl' ) . '</button>
        </form>
        </div>
        </div><!--wple-sslgenerator-->';
    }

    /**
     * Error Message block
     *
     * @param string $html
     * @since 2.5.0
     * @return void
     */
    public function wple_error_block( &$html ) {
        $error_code = get_option( 'wple_error' );
        $generic = esc_html__( 'There was some issue while generating SSL for your site. Please check debug log or try Reset option once.', 'wp-letsencrypt-ssl' );
        $generic .= '<p style="font-size:16px;color:#888">' . sprintf( esc_html__( 'Feel free to open support ticket at %s for any help.', 'wp-letsencrypt-ssl' ), 'https://wordpress.org/support/plugin/wp-letsencrypt-ssl/#new-topic-0' ) . '</p>';
        $firerec = sprintf( esc_html__( "We highly recommend upgrading to our %sPRO%s annual plan which works on all types of hosting platforms.", 'wp-letsencrypt-ssl' ), '<a href="' . admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=annual&pricing_id=7965&currency=usd' ) . '">', '</a>' );
        $thirdparty = esc_html__( "Your hosting server don't seem to support third party SSL.", "wp-letsencrypt-ssl" );
        if ( $error_code == 1 || $error_code == 400 ) {
            $generic .= '<p class="firepro">' . $thirdparty . ' ' . $firerec . '</p>';
        } else {
            if ( file_exists( WPLE_Trait::wple_cert_directory() . 'certificate.crt' ) ) {
                $generic .= '<br><br>' . WPLE_Trait::wple_kses( __( 'You already seem to have certificate generated and stored. Please try downloading certs from <strong>Download SSL Certificates</strong> page and open in a text editor like notepad to check if certificate is not empty.', 'wp-letsencrypt-ssl' ) );
            }
        }
        if ( $error_code == 429 ) {
            $generic = sprintf( esc_html__( 'Too many registration attempts from your IP address (%s). Please try after 2-3 hours.', 'wp-letsencrypt-ssl' ), 'https://letsencrypt.org/docs/rate-limits/' );
            $generic .= '<p class="firepro">' . $firerec . '</p>';
            $generic .= '<p style="font-size:17px;color:#888">' . sprintf( esc_html__( 'Feel free to open support ticket at %s for any help.', 'wp-letsencrypt-ssl' ), 'https://wordpress.org/support/plugin/wp-letsencrypt-ssl/#new-topic-0' ) . '</p>';
        }
        $html .= '
        <div id="wple-sslgenerator" class="error">
          <div class="wple-error-message">
            ' . $generic . '
          </div>
        </div><!--wple-sslgenerator-->';
    }

    /**
     * Sets review flag to show review request
     * 
     * @since 4.4.0
     */
    public function wple_set_review_flag() {
        update_option( 'wple_show_review', 1 );
    }

    /**
     * Re-enable mx issue admin notice as per remind later action
     *
     * @since 6.3.2
     * @return void
     */
    public function wple_set_mxerror_flag() {
        update_option( 'wple_mixed_issues', 1 );
    }

    /**
     * Handle the reset keys action
     *
     * @since 4.5.0
     * @return void
     */
    public function wple_reset_handler() {
        if ( isset( $_GET['wplereset'] ) ) {
            if ( !current_user_can( 'manage_options' ) ) {
                exit( 'No Trespassing Allowed' );
            }
            if ( !wp_verify_nonce( $_GET['wplereset'], 'restartwple' ) ) {
                exit( 'No Trespassing Allowed' );
            }
            $keys = WPLE_Trait::wple_cert_directory();
            $files = array(
                $keys . 'public.pem',
                $keys . 'private.pem',
                $keys . 'order',
                $keys . 'fullchain.crt',
                $keys . 'certificate.crt',
                $keys . '__account/private.pem',
                $keys . '__account/public.pem'
            );
            foreach ( $files as $file ) {
                if ( file_exists( $file ) ) {
                    unlink( $file );
                }
            }
            //clean ACME
            $acmePath = ABSPATH . '.well-known/acme-challenge/';
            if ( is_dir( $acmePath ) ) {
                $acmefiles = glob( $acmePath . '*', GLOB_MARK );
                foreach ( $acmefiles as $acmefile ) {
                    unlink( $acmefile );
                }
            }
            delete_option( 'wple_error' );
            //error code
            delete_option( 'wple_ssl_screen' );
            //screen stage
            delete_option( 'wple_backend' );
            //forced completion
            delete_option( 'wple_hold_cron' );
            delete_option( 'wple_order_refreshed' );
            delete_transient( 'wple_ssllabs' );
            add_action( 'admin_notices', array($this, 'wple_reset_success') );
        }
    }

    /**
     * Reset success notice
     * 
     * @since 4.5.0
     */
    public function wple_reset_success() {
        echo '<div class="notice notice-success is-dismissable">
    <p>' . esc_html( 'Reset successful!. You can start with the SSL install process again.', 'wp-letsencrypt-ssl' ) . '</p>
    </div>';
    }

    /**
     * Set wple_show_reminder and also mail reminder to admin
     *
     * @see 4.6.0
     * @return void
     */
    public function wple_start_show_reminder() {
        if ( !WPLE_Trait::wple_ssl_recheck_expiry() ) {
            return;
        }
        update_option( 'wple_show_reminder', 1 );
        update_option( 'wple_renewal_failed_notice', 1 );
        if ( FALSE !== get_option( 'wple_ssl_monitoring' ) ) {
            $opts = get_option( 'wple_opts' );
            $to = ( isset( $opts['email'] ) && !empty( $opts['email'] ) ? sanitize_email( $opts['email'] ) : get_option( 'admin_email' ) );
            $subject = sprintf( esc_html__( 'ATTENTION - SSL Certificate of %s expires in just 10 days', 'wp-letsencrypt-ssl' ), str_ireplace( array('https://', 'http://'), array('', ''), site_url() ) );
            $headers = array('Content-Type: text/html; charset=UTF-8');
            $body = '<p>' . sprintf( __( 'Your SSL Certificate is expiring soon!. Please make sure to re-generate new SSL Certificate using %sWP Encryption%s and install it on your hosting server to avoid site showing insecure warning with expired certificate.', 'wp-letsencrypt-ssl' ), '<a href="' . admin_url( '/admin.php?page=wp_encryption', 'http' ) . '">', '</a>' ) . '</p><br /><br />';
            $body .= '<b>' . esc_html__( 'Tired of manual SSL renewal every 90 days?, Upgrade to PRO version for automatic SSL installation and automatic SSL renewal', 'wp-letsencrypt-ssl' ) . '. <br><a href="' . admin_url( '/admin.php?page=wp_encryption-pricing', 'http' ) . '" style="background: #0073aa; text-decoration: none; color: #fff; padding: 12px 20px; display: inline-block; margin: 10px 0; font-weight: bold;">' . esc_html__( 'UPGRADE TO PREMIUM', 'wp-letsencrypt-ssl' ) . '</a></b><br /><br />';
            if ( function_exists( 'wp_mail' ) ) {
                wp_mail(
                    $to,
                    $subject,
                    $body,
                    $headers
                );
            }
        }
    }

    public function wple_reminder_notice() {
        $already_did = wp_nonce_url( admin_url( 'admin.php?page=wp_encryption' ), 'wple_renewed', 'wplesslrenew' );
        $html = '<div class="notice notice-info wple-admin-review">
        <div class="wple-review-box wple-reminder-notice">
          <img src="' . WPLE_URL . 'admin/assets/symbol.png"/>
          <span><strong>WP ENCRYPTION: ' . esc_html__( 'Your SSL certificate expires in less than 10 days', 'wp-letsencrypt-ssl' ) . '</strong><p>' . WPLE_Trait::wple_kses( __( 'Renew your SSL certificate today to avoid your site from showing as insecure. Please support our contribution by upgrading to <strong>Pro</strong> and avail automatic SSL renewal with automatic SSL installation.', 'wp-letsencrypt-ssl' ) ) . '</p></span>
        </div>
        <a class="wple-lets-review wplerevbtn" href="' . admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=lifetime&pricing_id=7965&currency=usd' ) . '">' . esc_html__( 'Upgrade to Pro', 'wp-letsencrypt-ssl' ) . '</a>
        <a class="already-renewed wplerevbtn" href="' . $already_did . '">' . esc_html__( 'I already renewed', 'wp-letsencrypt-ssl' ) . '&nbsp;<span class="dashicons dashicons-smiley"></span></a>
      </div>';
        echo $html;
    }

    /**
     * show manual verification challenges
     *
     * @since 4.7.0
     * @param string $html
     * @param array $opts
     * @return string
     */
    public function wple_subdir_challenges( &$html, $opts ) {
        update_option( 'wple_ssl_screen', 'verification' );
        $html .= '
      <div id="wple-sslgenerator">
      <div class="wple-success-form">
          ' . WPLE_Subdir_Challenge_Helper::show_challenges( $opts ) . '
      </div>
      </div><!--wple-sslgenerator-->';
    }

    /**
     * Simple success notice for admin
     *
     * @since 4.7.2
     * @return void
     */
    public function wple_success_notice() {
        $html = '<div class="notice notice-success">
        <p>' . esc_html__( 'Success', 'wp-letsencrypt-ssl' ) . '!</p>
      </div>';
        echo $html;
    }

    /**
     * Show Pricing table once on activation
     *
     * @since 5.0.0
     * @param string $html
     * @return $html
     */
    public function wple_initial_quick_pricing( &$html ) {
        $cpanel = WPLE_Trait::wple_cpanel_identity( true );
        $html .= '<div id="wple-sslgen">';
        $cppricing = ( false !== stripos( ABSPATH, 'srv/htdocs' ) ? true : false );
        if ( $cpanel || $cppricing ) {
            $html .= $this->wple_cpanel_pricing_table( 1 );
        } else {
            // if (isset($_SERVER['GD_PHP_HANDLER'])) {
            //   if ($_SERVER['SERVER_SOFTWARE'] == 'Apache' && isset($_SERVER['GD_PHP_HANDLER']) && $_SERVER['DOCUMENT_ROOT'] == '/var/www') {
            $html .= $this->wple_firewall_pricing_table();
            //   }
            // } else {
            //   $html .= $this->wple_cpanel_pricing_table('');
            // }
        }
        $html .= '</div>';
        echo $html;
    }

    /**
     * Pricing table html
     *
     * @since 5.0.0
     * @return $table
     */
    public function wple_cpanel_pricing_table( $cpanel = '' ) {
        ob_start();
        ?>

    <h2 class="pricing-intro-head"><?php 
        esc_html_e( 'SAVE MORE THAN $90+ EVERY YEAR IN SSL CERTIFICATE FEE', 'wp-letsencrypt-ssl' );
        ?></h2>

    <h4 class="pricing-intro-subhead">Purchase once and use for lifetime - Trusted Globally by <b>250,000+</b> WordPress Users (Looking for <a href="<?php 
        echo admin_url( '/admin.php?page=wp_encryption&gopro=3' );
        ?>">Annual</a> | <a href="<?php 
        echo admin_url( '/admin.php?page=wp_encryption&gopro=2' );
        ?>">Unlimited Sites License?</a>)</h4>

    <div style="text-align:center">
      <img src="<?php 
        echo WPLE_URL;
        ?>admin/assets/limited-offer.png" style="max-width:650px" />
    </div>

    <!-- <div class="plan-toggler" style="margin:60px 0 -20px !important">
        <span>Annual</span><label class="toggle">
          <input class="toggle-checkbox initplan-switch" type="checkbox" <?php 
        // if ($cpanel == 1) {
        //                                                                       echo 'checked';
        //                                                                     }
        ?>>
          <div class="toggle-switch"></div>
          <span class="toggle-label">Lifetime</span>
        </label>
      </div> -->

    <div id="quick-pricing-table">
      <div class="free-pricing-col wplepricingcol">
        <div class="quick-pricing-head free">
          <h3>FREE</h3>
          <large>$0</large>
        </div>
        <ul>
          <li><strong>Manual</strong> domain verification</li>
          <li><strong>Manual</strong> SSL installation</li>
          <li><strong>Manual</strong> SSL renewal <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="You will manually need to re-generate SSL certificate every 90 days once using WP Encryption"></span></li>
          <li><strong>Mixed</strong> Content Scanner <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Scan your site to detect which insecure assets are causing browser padlock to not show"></span></li>
          <!-- <li><strong>Expires</strong> in 90 days <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="You will manually need to re-generate SSL certificate every 90 days using WP Encryption"></span></li> -->
          <li><strong>Basic</strong> support</li>
        </ul>
        <div class="pricing-btn-block">
          <a href="<?php 
        echo admin_url( '/admin.php?page=wp_encryption&gofree=1' );
        ?>" class="pricingbtn free">Select Plan</a>
        </div>
      </div>

      <div class="pro-pricing-col wplepricingcol proplan">
        <div class="quick-pricing-head pro">
          <span class="wple-trending">Popular</span>
          <h3>PRO</h3>
          <div class="quick-price-row">
            <large>$49<sup></sup></large>
            <small>/lifetime</small>
          </div>
        </div>
        <ul>
          <li><strong>Automatic</strong> domain verification</li>
          <li><strong>Automatic</strong> SSL installation</li>
          <li><strong>Automatic</strong> SSL renewal</li>
          <li><strong>Wildcard</strong> SSL support <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="One SSL certificate to cover all your sub-domains"></span></li>
          <li><strong>Multisite</strong> mapped domains <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Install SSL for different domains mapped to your multisite network with MU domain mapping plugin"></span></li>
          <li><strong>DNS</strong> Automation <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Automatic Domain verification with DNS if HTTP domain verification fails"></span></li>
          <li><strong>Vulnerability</strong> Scanner <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Automate daily scanning of your site for known vulnerabilities and get notified instantly"></span></li>
          <li><strong>Never</strong> expires <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Never worry about SSL again - Your SSL certificate will be automatically renewed in background 30 days prior to its expiry dates"></span></li>
          <li><strong>Priority</strong> support <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="gowebsmarty.in"></span></li>
        </ul>
        <div class="pricing-btn-block">
          <a href="<?php 
        echo admin_url( '/admin.php?page=wp_encryption&gopro=1' );
        ?>" class="pricingbtn free">Select Plan</a>
        </div>
      </div>

    </div>

    <br />
    <?php 
        if ( $cpanel != '' ) {
            ?>
      <div class="quick-refund-policy">
        <strong>7 Days Refund Policy</strong>
        <p>We're showing this recommendation because you have cPanel hosting where our PRO plugin is 100% guaranteed to work. Your purchase will be completely refunded if WP Encryption fail to work on your site.</p>
      </div>
    <?php 
        }
        ?>

  <?php 
        $table = ob_get_clean();
        return $table;
    }

    public function wple_firewall_pricing_table() {
        ob_start();
        ?>

    <h2 class="pricing-intro-head">FLAWLESS SSL SOLUTION FOR LOWEST PRICE EVER <small>(Limited Offer)</small></h2>
    <h4 class="pricing-intro-subhead">Upgrade to PRO today for <strong>Fully automatic SSL</strong> & get automatic <strong>CDN + Security</strong> for FREE! - Trusted Globally by <b>250,000+</b> WordPress Users <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="A complete bundle worth $360!"></span></h4>

    <div style="text-align:center">
      <img src="<?php 
        echo WPLE_URL;
        ?>admin/assets/limited-offer.png" style="max-width:650px" />
    </div>

    <div id="quick-pricing-table" class="non-cpanel-plans">
      <div class="free-pricing-col wplepricingcol">
        <div class="quick-pricing-head free">
          <h3>FREE</h3>
          <large>$0</large>
        </div>
        <ul>
          <li><strong>Manual</strong> domain verification</li>
          <li><strong>Manual</strong> SSL installation</li>
          <li><strong>Manual</strong> SSL renewal <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="You will manually need to re-generate SSL certificate every 90 days once using WP Encryption"></span></li>
          <li><strong>Basic</strong> support</li>
        </ul>
        <div class="pricing-btn-block">
          <a href="<?php 
        echo admin_url( '/admin.php?page=wp_encryption&gofree=1' );
        ?>" class="pricingbtn free">Select Plan</a>
        </div>
      </div>

      <div class="pro-pricing-col wplepricingcol firewallplan">
        <div class="quick-pricing-head pro">
          <span class="wple-trending">Popular</span>
          <h3>PRO</h3>
          <div class="quick-price-row">
            <large>$29</large>
            <small>/year</small>
          </div>
        </div>
        <ul>
          <li><strong>Automatic</strong> Domain Verification</li>
          <li><strong>Automatic</strong> SSL Installation</li>
          <li><strong>Automatic</strong> SSL Renewal</li>
          <li><strong>Wildcard</strong> SSL support <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="One SSL certificate to cover all your sub-domains"></span></li>
          <li><strong>Multisite</strong> mapped domains <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Install SSL for different domains mapped to your multisite network with MU domain mapping plugin"></span></li>
          <li><strong>Vulnerability</strong> Scanner <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Automate daily scanning of your site for known vulnerabilities and get notified instantly"></span></li>
          <li><strong>Automatic</strong> CDN <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Your site is cached and served from 45+ full-scale edge locations worldwide for faster delivery and lowest TTFB thus improving Google pagespeed score"></span></li>
          <li><strong>Security</strong> Firewall <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="All your site traffic routed through secure StackPath firewall offering protection against DDOS attacks, XSS, SQL injection, File inclusion, Common WordPress exploits, CSRF, etc.,"></span></li>
          <li><strong>100%</strong> Compatible <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="Guaranteed to work on ANY hosting platform"></span></li>
          <li><strong>One Year</strong> Support & Updates</li>
        </ul>
        <div class="pricing-btn-block">
          <a href="<?php 
        echo admin_url( '/admin.php?page=wp_encryption&gofirewall=1' );
        ?>" class="pricingbtn free">Select Plan</a>
        </div>
      </div>

    </div>
    <!-- <div class="intro-pricing-refund">
        7 days money back guarantee <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="If you are not satisfied with the service within 7 days of purchase, We will refund your purchase no questions asked"></span>
      </div> -->

<?php 
        $table = ob_get_clean();
        return $table;
    }

    /**
     * Final success block
     *
     * @param string $html
     * @return void
     */
    public function wple_success_block( &$html ) {
        $html .= WPLE_Trait::wple_progress_bar();
        $leopts = get_option( 'wple_opts' );
        $future = strtotime( $leopts['expiry'] );
        //Future date.
        $activecertexpiry = $leopts['expiry'];
        $activecertexpirytime = strtotime( $activecertexpiry );
        $timefromdb = time();
        $timeleft = $activecertexpirytime - $timefromdb;
        $daysleft = round( $timeleft / 24 / 60 / 60 );
        $wple_support = get_option( 'wple_backend' );
        $renewtext = esc_html__( 'Click Here To Renew SSL Certificate', 'wp-letsencrypt-ssl' );
        // $renewlink = '<a href="#" class="letsrenew wple-tooltip disabled" data-tippy="' . esc_html__('This renew button will get enabled during last 30 days of current SSL certificate expiry', 'wp-letsencrypt-ssl') . ' ' . esc_html__('You can also click on STEP 1 in above progress bar to renew/re-generate SSL Certificate again.', 'wp-letsencrypt-ssl') . '">' . $renewtext . '</a>';
        // if ($daysleft <= 30) {
        $renewlink = '<a href="' . admin_url( '/admin.php?page=wp_encryption&restart=1' ) . '" class="letsrenew">' . $renewtext . '</a>';
        // }
        if ( $wple_support ) {
            //forced completion
            $renewlink = '';
        }
        $headline = esc_html__( 'Woohoo! WP Encryption just saved you $$$ in SSL Certificate Fee.', 'wp-letsencrypt-ssl' );
        $sharetitle = urlencode( 'Generated & Installed free SSL certificate using WP ENCRYPTION WordPress plugin within minutes! Thanks for the great plugin.' );
        $html .= '<div id="wple-completed">
        <div class="wple-completed-review">
          <h2>' . $headline . '</h2>
          <p>' . sprintf(
            __( 'Can you please do us a BIG favor by leaving a %s%s%s%s%s rating on WordPress.org', 'wp-letsencrypt-ssl' ),
            '<span class="dashicons dashicons-star-filled"></span>',
            '<span class="dashicons dashicons-star-filled"></span>',
            '<span class="dashicons dashicons-star-filled"></span>',
            '<span class="dashicons dashicons-star-filled"></span>',
            '<span class="dashicons dashicons-star-filled"></span>'
        ) . ' <span class="wple-share-success">' . sprintf(
            __( "or spread the word on %s %s %s %s", "wp-letsencrypt-ssl" ),
            '<a href="https://twitter.com/share?url=https://wpencryption.com&text=' . $sharetitle . '&hashtags=wp_encryption,wordpress_ssl,wordpress_https" target="_blank" title="Twitter" class="tw">T</a>',
            '<a href="https://www.facebook.com/sharer.php?u=wpencryption.com" target="_blank" title="Facebook" class="fb">F</a>',
            '<a href="https://reddit.com/submit?url=wpencryption.com&title=' . $sharetitle . '" target="_blank" title="Reddit" class="rd">R</a>',
            '<a href="https://pinterest.com/pin/create/bookmarklet/?media=https://wpencryption.com/wp-content/uploads/2021/08/banner-772x250-1.png&url=wpencryption.com&description=' . $sharetitle . '" target="_blank" title="Pinterest" class="pt">P</a>'
        ) . '</span></p>
          <a href="https://wordpress.org/support/plugin/wp-letsencrypt-ssl/reviews/#new-post" target="_blank" class="letsrate">' . esc_html__( 'LEAVE A RATING', 'wp-letsencrypt-ssl' ) . ' <span class="dashicons dashicons-external"></span></a>
          ' . $renewlink . '
          <small>' . esc_html__( 'Just takes a moment', 'wp-letsencrypt-ssl' ) . '</small>
        </div>';
        if ( !$wple_support ) {
            $current_ssl = esc_html__( 'Your generated SSL certificate expires on', 'wp-letsencrypt-ssl' );
            $html .= '<div class="wple-completed-remaining">
          <div class="progress--circle progress--' . esc_attr( $daysleft ) . '">
            <div class="progress__number"><strong>' . esc_html( $daysleft ) . '</strong><br><small>' . esc_html__( 'Days', 'wp-letsencrypt-ssl' ) . '</small></div>
          </div>  
          <div class="wple-circle-expires">  
          <strong>' . $current_ssl . ': <br><b>' . esc_html( $activecertexpiry ) . '</b></strong>
          <p>' . WPLE_Trait::wple_kses( __( "Let's Encrypt® SSL Certificate expires in 90 days by default. You can easily re-generate new SSL certificate using <strong>RENEW SSL CERTIFICATE</strong> option found on left or by clicking on <strong>STEP 1</strong> in progress bar.", "wp-letsencrypt-ssl" ) ) . '<br /><br />' . WPLE_Trait::wple_kses( __( 'Major browsers like Chrome will start showing insecure site warning IF you fail to renew / re-generate certs before this expiry date. Please clear your browser cache once.', 'wp-letsencrypt-ssl' ) ) . '</p> 
          <div class="pro-renewal-note"><strong>PLEASE NOTE:</strong> If you are using PRO version - Ignore the above expiry date as your SSL certificates will be auto renewed in background 30 days prior to expiry date.</span>          
          </div>
        </div>';
        }
        $html .= '</div>';
    }

    public function wple_expert_block( &$html, $spmode = 0 ) {
    }

    /**
     * This site have mixed content issues
     *
     * @since 5.3.12
     * @return void
     */
    public function wple_mixed_content_notice() {
        $desc = __( 'Mixed content issues cause browser padlock to show as insecure even if you have installed SSL certificate perfectly. Upgrade to PRO for automatic mixed content fixing.', 'wp-letsencrypt-ssl' );
        $upgradebutton = '<a class="wple-lets-review wplerevbtn" href="' . admin_url( '/admin.php?page=wp_encryption-pricing' ) . '">' . esc_html__( 'Upgrade to Pro', 'wp-letsencrypt-ssl' ) . '</a>';
        $remindlater = '<a class="wple-mx-ignore wplerevbtn wple-hire-later" href="#">' . esc_html__( "Remind me later", 'wp-letsencrypt-ssl' ) . '</a>';
        $html = '<div class="notice notice-info wple-admin-review wple-mx-prom">
      <div class="wple-review-box">
        <img src="' . WPLE_URL . 'admin/assets/symbol.png"/>
        <span><strong>Warning: ' . esc_html__( 'Your site have mixed content issues!', 'wp-letsencrypt-ssl' ) . '</strong><p>' . WPLE_Trait::wple_kses( $desc ) . '</p></span>
      </div>
      ' . $upgradebutton . '
      <a class="wple-mx-ignore wplerevbtn" href="#">' . esc_html__( "Don't show again", 'wp-letsencrypt-ssl' ) . '</a>
      ' . $remindlater . '
    </div>';
        echo $html;
    }

    public function wple_oneyearprom( $reasons ) {
        $reasons['long-term'][] = $reasons['short-term'][] = array(
            'id'                => 20,
            'text'              => '<a href="https://wpencryption.com/?utm_source=wordpress&utm_medium=oneyearsslpro" target="_blank"><img src="' . WPLE_URL . 'admin/assets/1-year-ssl.png"/></a>',
            'input_type'        => '',
            'input_placeholder' => 'oneyearssl',
        );
        return $reasons;
    }

    // public function cdn_termination_alert__premium_only()
    // {
    //   $html = '<div class="notice notice-error wple-alert-box">
    //   <img src="' . WPLE_URL . 'admin/assets/symbol.png"/>
    //   <h3>WP Encryption</h3>
    //   <p><b>IMPORTANT ALERT:</b> We see that your site is pointed towards our SSL proxy(151.139.128.10) which is no longer available. As an alternative solution, Please click on the button below to generate Premium Comodo SSL certificate and install the certificate, private key directly on your hosting panel. You\'re required to complete this action before <strong>March 10, 2023</strong> to avoid site disruption after the SSL proxy service shutdown. This popup will go away once after you complete setup & revert the DNS records back to your hosting server IP address.</p>
    //   <a class="wplerevbtn generate-certpanel" href="' . admin_url('/admin.php?page=wp_encryption&certpanel=1') . '">Generate Premium Certificate</a>
    //   <a class="wplerevbtn readmore-certpanel" href="https://wpencryption.com/introducing-wpencryption-certpanel" target="_blank">Read the Instructions</a>
    //   </div>';
    //   echo $html;
    // }
    public function wple_basic_get_requests() {
        //since 5.1.0
        if ( isset( $_GET['restart'] ) ) {
            //click to restart from beginning
            delete_option( 'wple_ssl_screen' );
            wp_redirect( admin_url( '/admin.php?page=wp_encryption' ), 302 );
            exit;
        }
        if ( isset( $_GET['force_complete'] ) ) {
            //Forced SSL completion flag
            update_option( 'wple_ssl_screen', 'success' );
            update_option( 'wple_backend', 1 );
            WPLE_Trait::clear_all_renewal_crons( true );
            wp_redirect( admin_url( '/admin.php?page=wp_encryption' ), 302 );
            exit;
        }
        //since 4.6.0
        //ssl already renewed selection in reminder notice
        if ( isset( $_GET['wplesslrenew'] ) ) {
            if ( !wp_verify_nonce( $_GET['wplesslrenew'], 'wple_renewed' ) ) {
                exit( 'Unauthorized' );
            }
            delete_option( 'wple_show_reminder' );
            wp_redirect( admin_url( '/admin.php?page=wp_encryption' ), 302 );
        }
        WPLE_Subdir_Challenge_Helper::download_challenge_files();
        //subdir_chfile
        $this->wple_reset_handler();
        //wplereset
        // $estage = get_option('wple_error');
        // //redirections
        // if (FALSE !== $estage && $estage == 2 && !isset($_GET['subdir']) && !isset($_GET['error']) && !isset($_GET['includewww']) && !isset($_GET['wpleauto']) && isset($_GET['page']) && $_GET['page'] == 'wp_encryption' && !isset($_GET['success']) && !isset($_GET['wplereset']) && !isset($_GET['comparison']) && !isset($_GET['lasterror']) && !isset($_GET['annual'])) {
        //   wp_redirect(admin_url('/admin.php?page=wp_encryption&subdir=1'), 302);
        //   exit();
        // }
        // if (wple_fs()->can_use_premium_code__premium_only()) {
        //   if (FALSE !== $estage && $estage == 4 && !isset($_GET['subdir']) && !isset($_GET['error']) && !isset($_GET['includewww']) && !isset($_GET['wpleauto']) && isset($_GET['page']) && $_GET['page'] == 'wp_encryption' && !isset($_GET['success']) && !isset($_GET['resume']) && !isset($_GET['nossl']) && !isset($_GET['wplereset']) && !isset($_GET['comparison']) && !isset($_GET['customdns']) && !isset($_GET['nocpanel']) && !isset($_GET['lasterror']) && !isset($_GET['annual'])) {
        //     wp_redirect(admin_url('/admin.php?page=wp_encryption&nocpanel=1'), 302);
        //     exit();
        //   }
        // }
        // if (FALSE !== $estage && $estage == 5 && !isset($_GET['subdir']) && !isset($_GET['error']) && !isset($_GET['includewww']) && !isset($_GET['wpleauto']) && isset($_GET['page']) && $_GET['page'] == 'wp_encryption' && !isset($_GET['resume']) && !isset($_GET['nossl']) && !isset($_GET['wplereset']) && !isset($_GET['comparison']) && !isset($_GET['nocpanel']) && !isset($_GET['annual'])) {
        //   wp_redirect(admin_url('/admin.php?page=wp_encryption&success=1&resume=1'), 302);
        //   exit();
        // }
        //6.1.0 - update sourceip for LE if not already set
        ///if (array_key_exists('SERVER_ADDR', $_SERVER) && !get_option('wple_sourceip')) update_option('wple_sourceip', $_SERVER['SERVER_ADDR']); //Used later for LE requests
    }

    public function wple_initialize_ssllabs() {
        WPLE_Trait::wple_ssllabs_scan( true );
    }

    public function wple_update_expiry_ssllabs() {
        //init new scan daily once
        WPLE_Trait::wple_ssllabs_scan( true, false );
    }

}
