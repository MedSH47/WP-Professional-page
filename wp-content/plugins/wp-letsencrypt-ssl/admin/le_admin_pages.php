<?php

/**
 * @package WP Encryption
 *
 * @author     Go Web Smarty
 * @copyright  Copyright (C) 2019-2024, Go Web Smarty
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link       https://gowebsmarty.com
 * @since      Class available since Release 5.0.0
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
require_once WPLE_DIR . 'admin/le_admin_page_wrapper.php';
require_once WPLE_DIR . 'classes/le-advanced-scanner.php';
require_once WPLE_DIR . 'classes/le-security.php';
class WPLE_SubAdmin extends WPLE_Admin_Page {
    private $threats = array();

    public function __construct() {
        add_action( 'admin_menu', [$this, 'wple_register_admin_pages'], 11 );
        add_action( 'admin_menu', [$this, 'wple_register_secondary_admin_pages'], 20 );
        add_action( 'admin_init', [$this, 'wple_force_https_handler'] );
        add_action( 'wp_ajax_wple_email_certs', [$this, 'wple_email_certs_setting'] );
        add_action( 'wp_ajax_wple_review_notice', [$this, 'wple_review_notice_disable'] );
        add_action( 'wp_ajax_wple_mxerror_ignore', [$this, 'wple_mx_ignore'] );
        add_action( 'wp_ajax_wple_update_settings', [$this, 'wple_update_settings'] );
        add_action( 'wp_ajax_wple_update_security', [$this, 'wple_update_security'] );
        //7.0.0
        add_action( 'admin_bar_menu', [$this, 'wple_ssl_toolbar'], 100 );
        add_filter( 'site_status_tests', [$this, 'wple_vulnerable_components'] );
        //since 6.7.0
        add_filter( 'wp_headers', [$this, 'wple_enforce_security_headers'] );
    }

    /**
     * Register sub pages
     *
     * @since 5.0.0
     * @return void 
     */
    public function wple_register_admin_pages() {
        $ecount = get_option( 'wple_ssl_errors' );
        $notifications = ( FALSE !== $ecount ? '<span class="awaiting-mod">' . (int) $ecount . '</span>' : '' );
        add_submenu_page(
            'wp_encryption',
            'SSL Health and Headers',
            __( 'SSL Health and Headers', 'wp-letsencrypt-ssl' ) . ' ' . $notifications . '',
            'manage_options',
            'wp_encryption_ssl_health',
            [$this, 'wple_sslhealth_page']
        );
        add_submenu_page(
            'wp_encryption',
            'Vulnerability Scanner & Security',
            __( 'Vulnerability Scanner & Security', 'wp-letsencrypt-ssl' ),
            'manage_options',
            'wp_encryption_security',
            [$this, 'wple_security_page']
        );
        add_submenu_page(
            'wp_encryption',
            'Download SSL Certificates',
            __( 'Download SSL Certificates', 'wp-letsencrypt-ssl' ),
            'manage_options',
            'wp_encryption_download',
            [$this, 'wple_download_page']
        );
        add_submenu_page(
            'wp_encryption',
            'Force HTTPS',
            __( 'Force HTTPS', 'wp-letsencrypt-ssl' ),
            'manage_options',
            'wp_encryption_force_https',
            [$this, 'wple_force_https_page']
        );
        //if (FALSE != ($mx = get_option('wple_mx')) && $mx) {
        add_submenu_page(
            'wp_encryption',
            'Mixed Content Scanner',
            __( 'Mixed Content Scanner', 'wp-letsencrypt-ssl' ),
            'manage_options',
            'wp_encryption_mixed_scanner',
            [$this, 'wple_mixed_scanner_page']
        );
        //}
        add_submenu_page(
            'options.php',
            'Debug log',
            __( 'Debug log', 'wp-letsencrypt-ssl' ),
            'manage_options',
            'wp_encryption_log',
            [$this, 'wple_debug_log_page']
        );
        //if (wple_fs()->can_use_premium_code__premium_only()) {
        //if (wple_fs()->is_plan('firewall', true)) {
        //TODO
        ///add_submenu_page('wp_encryption', 'CDN', __('CDN', 'wp-letsencrypt-ssl'), 'manage_options', 'wp_encryption_cdn', [$this, 'wple_cdn_page__premium_only']);
        //}
        //}
    }

    /**
     * Register sub pages
     *
     * @since 5.0.0
     * @return void
     */
    public function wple_register_secondary_admin_pages() {
        add_submenu_page(
            'options.php',
            'How-To Videos',
            __( 'How-To Videos', 'wp-letsencrypt-ssl' ),
            'manage_options',
            'wp_encryption_howto_videos',
            [$this, 'wple_howto_page']
        );
        add_submenu_page(
            'options.php',
            'FAQ',
            __( 'FAQ', 'wp-letsencrypt-ssl' ),
            'manage_options',
            'wp_encryption_faq',
            [$this, 'wple_faq_page']
        );
        // if (wple_fs()->is__premium_only()) {
        //   add_submenu_page('wp_encryption', 'sitelock_monitor', __('SiteLock Monitor', 'wp-letsencrypt-ssl'), 'manage_options', 'wp_encryption_sitelock', [$this, 'wple_sitelockmonitor__premium_only']);
        // }
        add_submenu_page(
            'wp_encryption',
            'Reset',
            __( 'RESET', 'wp-letsencrypt-ssl' ),
            'manage_options',
            'wp_encryption_reset',
            [$this, 'wple_tools_block']
        );
    }

    /**
     * Force HTTPS page
     *
     * @since 5.0.0
     * @source le_admin.php moved
     * @return void
     */
    public function wple_force_https_page() {
        $action = 'install-plugin';
        $slug = 'backup-bolt';
        $pluginstallURL = wp_nonce_url( add_query_arg( array(
            'action' => $action,
            'plugin' => $slug,
        ), admin_url( 'update.php' ) ), $action . '_' . $slug );
        $page = '<h2>' . __( 'Force HTTPS', 'wp-letsencrypt-ssl' ) . '</h2>';
        if ( !is_plugin_active( 'backup-bolt/backup-bolt.php' ) ) {
            $page .= '<div class="le-powered">		  
    <span><strong>Recommended:-</strong> Before enforcing HTTPS, We highly recommend taking a backup of your site using some good backup plugin like <strong>"Backup Bolt"</strong> - <a href="' . $pluginstallURL . '" target="_blank">Install & Activate Backup Bolt</a></span>    
	  </div>';
        }
        $leopts = get_option( 'wple_opts' );
        $checked = ( isset( $leopts['force_ssl'] ) && $leopts['force_ssl'] === 1 ? 'checked' : '' );
        $htaccesschecked = ( isset( $leopts['force_ssl'] ) && $leopts['force_ssl'] === 2 ? 'checked' : '' );
        $disablechecked = ( !isset( $leopts['force_ssl'] ) || $checked == '' && $htaccesschecked == '' ? 'checked' : '' );
        $page .= "<div class=\"wple-force\">\r\n      <p>" . WPLE_Trait::wple_kses( __( "If you still don't see a green padlock or notice <b>mixed content</b> warning in your browser console - please enable the below option to force HTTPS on all resources of site.", 'wp-letsencrypt-ssl' ) ) . ' ' . sprintf( __( "If you still notice mixed content issues or issues with browser padlock not showing on your site, please use %sMixed Content Scanner%s to scan and identify exact issues causing browser padlock to not show!.", "wp-letsencrypt-ssl" ), '<strong>', '</strong>' ) . "</p>";
        $htaccesswritable = is_writable( ABSPATH . '.htaccess' );
        $htaccessdisabled = ( $htaccesswritable ? '' : 'disabled' );
        $htaccessdisabledmsg = ( $htaccesswritable ? '' : ' (Disabled: Your <strong>.htaccess</strong> file is <a href="https://wpencryption.com/make-htaccess-writable-wordpress/" target="_blank">not writable</a>)' );
        if ( stripos( $_SERVER['SERVER_SOFTWARE'], 'apache' ) === false ) {
            $htaccessdisabled = 'disabled';
            $htaccessdisabledmsg = ' (Better suitable for Apache server. Please use below php method.)';
        }
        $page .= '<form method="post">
      <label class="checkbox-label" style="float:left">
      <input type="radio" name="wple_forcessl" value="0" ' . $disablechecked . '>
        <span class="checkbox-custom rectangular"></span>
      </label>

      <label>' . esc_html__( 'Disable', 'wp-letsencrypt-ssl' ) . '</label><br /><br />

      <label class="checkbox-label" style="float:left">
      <input type="radio" name="wple_forcessl" value="2" ' . $htaccessdisabled . ' ' . $htaccesschecked . '>
        <span class="checkbox-custom rectangular"></span>
      </label>

      <label class="' . $htaccessdisabled . '">' . esc_html__( 'Force SSL via HTACCESS (Server level 301 redirect - Faster)', 'wp-letsencrypt-ssl' ) . ' - ' . esc_html__( 'Most suitable for new sites & sites using proxies', 'wp-letsencrypt-ssl' ) . $htaccessdisabledmsg . '</label><br /><br />

      <label class="checkbox-label" style="float:left">
      <input type="radio" name="wple_forcessl" value="1" ' . $checked . '>
        <span class="checkbox-custom rectangular"></span>
      </label>

      <label>' . esc_html__( 'Force SSL via WordPress (Alternate solution if htaccess redirect cause any issues)', 'wp-letsencrypt-ssl' ) . ' - ' . esc_html__( 'Most suitable for old sites with lots of assets, links.', 'wp-letsencrypt-ssl' ) . '</label><br /><br />

      ' . wp_nonce_field(
            'wpleforcessl',
            'site-force-ssl',
            false,
            false
        ) . '
      <button type="submit" name="wple_ssl">' . esc_html__( 'Save', 'wp-letsencrypt-ssl' ) . '</button>
      </form>
    </div>';
        $this->generate_page( $page );
    }

    /**
     * Force HTTPS Handler
     *
     * @since 5.0.0
     * @source le_admin.php moved
     * @return void
     */
    public function wple_force_https_handler() {
        //force ssl
        if ( isset( $_POST['site-force-ssl'] ) ) {
            if ( !wp_verify_nonce( $_POST['site-force-ssl'], 'wpleforcessl' ) || !current_user_can( 'manage_options' ) ) {
                die( 'Unauthorized request' );
            }
            $basedomain = str_ireplace( array('http://', 'https://'), array('', ''), site_url() );
            //4.7
            if ( stripos( $basedomain, '/' ) !== false ) {
                $basedomain = substr( $basedomain, 0, stripos( $basedomain, '/' ) );
            }
            $client = WPLE_Trait::wple_verify_ssl( $basedomain );
            $reverter = uniqid( 'wple' );
            $leopts = get_option( 'wple_opts' );
            $prevforce = ( isset( $leopts['force_ssl'] ) ? $leopts['force_ssl'] : 0 );
            $leopts['force_ssl'] = (int) $_POST['wple_forcessl'];
            if ( !$client && $leopts['force_ssl'] != 0 && !is_ssl() ) {
                $nossl = '<p>' . esc_html__( 'We could not detect valid SSL on your site!. Please double check SSL certificate is properly installed on your cPanel / Server. You can also try opening wp-admin via https:// and then enable force HTTPS.', 'wp-letsencrypt-ssl' ) . '</p>';
                $nossl .= '<p>' . esc_html__( 'Switching to HTTPS without properly installing the SSL certificate might break your site.', 'wp-letsencrypt-ssl' ) . '</p>';
                $nossl .= '<a href="?page=wp_encryption&forceenablehttps=' . wp_create_nonce( 'hardforcessl' ) . '&forcetype=' . (int) $leopts['force_ssl'] . '" style="background: #f55656; color: #fff; padding: 10px; text-decoration: none; border-radius: 5px;        display: inline-block; margin:0 0 10px;"><strong>' . esc_html__( 'CLICK TO FORCE ENABLE HTTPS (Do it at your own risk)', 'wp-letsencrypt-ssl' ) . '</strong></a><br />
        <small>' . sprintf( esc_html__( 'In case you break the site, here is revert back to HTTP:// instructions - %s', 'wp-letsencrypt-ssl' ), 'https://wordpress.org/support/topic/locked-out-unable-to-access-site-after-forcing-https-2/' ) . '</small>';
                wp_die( $nossl );
                exit;
            }
            if ( $leopts['force_ssl'] == 1 ) {
                $leopts['revertnonce'] = $reverter;
            }
            update_option( 'wple_opts', $leopts );
            if ( $leopts['force_ssl'] != 0 ) {
                update_option( 'siteurl', str_ireplace( 'http:', 'https:', get_option( 'siteurl' ) ) );
                update_option( 'home', str_ireplace( 'http:', 'https:', get_option( 'home' ) ) );
                if ( $leopts['force_ssl'] == 1 ) {
                    if ( $prevforce == 2 ) {
                        $this->wple_clean_htaccess();
                    }
                    ///WPLE_Trait::wple_send_reverter_secret($reverter);
                } elseif ( $leopts['force_ssl'] == 2 ) {
                    $this->wple_force_ssl_htaccess();
                }
            } else {
                //if ($prevforce == 2) { //previously htaccess forced so remove them
                $this->wple_clean_htaccess();
                //}
                update_option( 'siteurl', str_ireplace( 'https:', 'http:', get_option( 'siteurl' ) ) );
                update_option( 'home', str_ireplace( 'https:', 'http:', get_option( 'home' ) ) );
            }
            wp_redirect( admin_url( 'admin.php?page=wp_encryption_force_https&successnotice=1' ) );
            exit;
        }
        //HARD force ssl since 4.7.2
        if ( isset( $_GET['forceenablehttps'] ) ) {
            if ( !wp_verify_nonce( $_GET['forceenablehttps'], 'hardforcessl' ) || !current_user_can( 'manage_options' ) ) {
                die( 'Unauthorized request' );
            }
            if ( $_GET['forcetype'] == 1 ) {
                //wp redirect method
                $reverter = uniqid( 'wple' );
                $leopts = get_option( 'wple_opts' );
                $leopts['force_ssl'] = 1;
                ///$leopts['revertnonce'] = $reverter;
                update_option( 'wple_opts', $leopts );
                ///WPLE_Trait::wple_send_reverter_secret($reverter);
            } else {
                $leopts = get_option( 'wple_opts' );
                $leopts['force_ssl'] = 2;
                update_option( 'wple_opts', $leopts );
                $this->wple_force_ssl_htaccess();
            }
            update_option( 'siteurl', str_ireplace( 'http:', 'https:', get_option( 'siteurl' ) ) );
            update_option( 'home', str_ireplace( 'http:', 'https:', get_option( 'home' ) ) );
            wp_redirect( admin_url( 'admin.php?page=wp_encryption_force_https&successnotice=1' ) );
            exit;
        }
    }

    /**
     * FAQ
     * 
     * @since 5.0.0   
     * @source le_admin.php moved
     * @return void
     */
    public function wple_faq_page() {
        $page = '<h2>' . esc_html__( 'FREQUENTLY ASKED QUESTIONS', 'wp-letsencrypt-ssl' ) . '</h2>
    <h4>' . esc_html( 'Why choose WP Encryption Pro over other SSL providers?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . esc_html( 'Our support staff is consisted of top notch developers and WordPress experts who can help with SSL implementation for any customized server environments. We have helped with SSL setup for 500+ complex Apache, Nginx, Bitnami, Lightsail, Reverse proxy servers.', 'wp-letsencrypt-ssl' ) . '</p>
    <hr>
    <h4>' . esc_html__( 'Should I configure anything after upgrading to PRO?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . esc_html__( 'If you have already installed SSL on your cPanel/server, auto renewal of SSL will start working in background after upgrading and activating your PRO license. If you have not yet installed SSL on your cPanel/server, please click on STEP 1 in progress bar and run the SSL install form once by entering your email and clicking on Generate SSL button, this will automate the SSL installation as well as the automatic renewal in background.', 'wp-letsencrypt-ssl' ) . '</p>
      <hr>
    <h4>' . esc_html__( 'Does installing the plugin will instantly turn my site https?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . esc_html__( 'Installing SSL certificate is a server side process and not as simple as installing a ready widget and using it instantly. You will have to follow some simple steps to install SSL for your WordPress site. Our plugin acts like a tool to generate and install SSL for your WordPress site. On FREE version of plugin - You should manually go through the SSL certificate installation process following the simple video tutorial. Whereas, the SSL certificates are easily generated by our plugin by running a simple SSL generation form.', 'wp-letsencrypt-ssl' ) . '</p>
      <hr>
      <h4>' . esc_html__( 'How to install SSL for both www & non-www version of my domain?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . WPLE_Trait::wple_kses( __( 'First of all, Please make sure you can access your site with and without www. Otherwise you will be not able to complete domain verification for both www & non-www together. If both of your www and non-www domains are publicly accessible, A new option named <strong>"Generate SSL for both www & non-www"</strong> will be automatically shown on WP Encryption SSL install form. You can also force enable this checkbox by adding <strong>includewww=1</strong> to page url i.e., <strong>/wp-admin/admin.php?page=wp_encryption&includewww=1</strong>', 'wp-letsencrypt-ssl' ) ) . '</p>
      <hr>
      <h4>' . esc_html__( 'Secure webmail & mail server with SSL Certificate', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . sprintf( __( 'Starting from WP Encryption v5.4.8, you can now secure your webmail & incoming/outgoing email server %sfollowing this guide%s', 'wp-letsencrypt-ssl' ), '<a href="https://wpencryption.com/secure-webmail-with-https/" target="_blank">', '</a>' ) . '</p>
      <hr>
      <h4>' . esc_html__( 'Images not loading on HTTPS site', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . esc_html__( 'Images on your site might be loading over http:// protocol, please enable "Force HTTPS" feature via WP Encryption page. If you have Elementor page builder installed, please go to Elementor > Tools > Replace URL and replace your http:// site url with https://. Make sure you have SSL certificates installed and browser padlock shows certificate(valid) before forcing these https measures.', 'wp-letsencrypt-ssl' ) . '</p>
      <p>' . esc_html__( 'If you are still not seeing padlock, We recommend testing your site at whynopadlock.com to determine the exact issue. If you have any image sliders, background images might be loading over http:// url instead of https:// and causing mixed content issues thus making padlock to not show.', 'wp-letsencrypt-ssl' ) . '</p>
      <hr>
      <h4>' . esc_html__( 'How do I renew my SSL certificate before expiry date?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . WPLE_Trait::wple_kses( __( 'Your SSL certificate will be auto renewed if you have <b>WP Encryption PRO</b> plugin purchased (SSL certs will be auto renewed in background just before the expiry date). If you have free version of plugin installed, You can click on STEP 1 in WP Encryption main page & use the same process of "Generate SSL Certificate" to get new certs.', 'wp-letsencrypt-ssl' ) ) . '</p>
      <hr>
      <h4>' . esc_html__( 'How do I install Wildcard SSL?', 'wp-letsencrypt-ssl' ) . '</h4>      
      <p>' . WPLE_Trait::wple_kses( __( 'If you have purchased the <b>WP Encryption PRO</b> version, You can notice Single domain vs Wildcard SSL switch on WP Encryption page.', 'wp-letsencrypt-ssl' ) ) . '</p>
      <hr>      
      <h4>' . esc_html__( 'How to test if my SSL installation is good?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . WPLE_Trait::wple_kses( sprintf( __( 'You can run a SSL test by entering your website url in <a href="%s" rel="%s">SSL Labs</a> site.', 'wp-letsencrypt-ssl' ), 'https://www.ssllabs.com/ssltest/', 'nofollow' ), 'a' ) . '</p>
      <hr>
      <h4>' . esc_html__( 'How to revert back to HTTP in case of force HTTPS failure?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . esc_html__( 'Please follow the revert back instructions given in [support forum](https://wordpress.org/support/plugin/wp-letsencrypt-ssl/).', 'wp-letsencrypt-ssl' ) . '</p>
      <hr>
      <h4>' . esc_html__( 'Have a different question?', 'wp-letsencrypt-ssl' ) . '</h4>
      <p>' . WPLE_Trait::wple_kses( sprintf( __( 'Please use our <a href="%s" target="%s">Plugin support forum</a>. <b>PRO</b> users can register free account & use priority support at gowebsmarty.in. More info - https://wpencryption.com', 'wp-letsencrypt-ssl' ), 'https://wordpress.org/support/plugin/wp-letsencrypt-ssl/', '_blank' ), 'a' ) . '</p>';
        $page .= '<br><hr><h2 id="howitworks">How it works?</h2>
    <p>First of all, thank you for choosing WP Encryption!. In order to transform your <b>HTTP://</b> site to <b>HTTPS://</b>, you need to have valid SSL certificate installed on your site first. The steps are as below:<br><br>1. Run the SSL install form of WP Encryption<br>2. Complete basic domain verification via HTTP file upload or DNS challenge following video tutorials provided on verification page<br>3. Finally download and install the generated <b>SSL certificate file</b> & <b>key</b> on your hosting panel or cPanel. <br>4. If you already have valid SSL certificate installed on site, feel free to skip above steps and directly enable "Force HTTPS" feature of WP Encryption.<br><a href="' . admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=lifetime&pricing_id=7965&currency=usd' ) . '">Upgrade to PRO</a> to enjoy fully <b>automatic</b> domain verification, <b>automatic</b> SSL installation & <b>automatic</b> SSL renewal.</p>
    <br>
    <p>If you don\'t have either cPanel or root SSH access, you can opt for our <a href="' . admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=annual&pricing_id=7965&currency=usd' ) . '">Annual Pro</a> solution which works on ANY hosting platform & offers you free automatic CDN boosting your site speed and firewall security (All you need to do is modify your domain DNS record to finish the setup).</p>
    <br>
    <p>Once after you are done with the challenging part of SSL installation, please go to <b>SSL HEALTH</b> page of WP Encryption and enable necessary HTTPS redirection, mixed content fixer, etc. If one or the other pages on your site is showing insecure padlock, you could run the <b>Advanced Insecure Content Scanner</b> of WP Encryption to detect insecure <b>http://</b> links and change them to <b>https://</b> to resolve the issue.</p>
    <br>
    <i>Last but not least, please do clear your browser cache once after installing SSL certificate.</i>';
        $this->generate_page( $page );
    }

    /**
     * How-To Videos
     * 
     * @since 5.0.0
     * @source le_admin.php moved
     * @return void
     */
    public function wple_howto_page() {
        $page = '<h2>' . __( 'How-To Videos', 'wp-letsencrypt-ssl' ) . '</h2>
    <h3>' . esc_html__( "How to complete domain verification via DNS challenge?", 'wp-letsencrypt-ssl' ) . '</h3>
    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/BBQL69PDDrk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    
    <h3 style="margin-top: 20px;">' . esc_html__( "How to install SSL Certificate on cPanel?", 'wp-letsencrypt-ssl' ) . '</h3>
    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/KQ2HYtplPEk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>  
       
    <h3 style="margin-top: 20px;">' . esc_html__( "How to install SSL Certificate on Non-cPanel site via SSH access?", 'wp-letsencrypt-ssl' ) . '</h3>
    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/PANs_C2SI5Q" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>  
      
    <h3 style="margin-top: 20px;">' . esc_html__( "PRO - Automate DNS verification for Godaddy", 'wp-letsencrypt-ssl' ) . '</h3>  
    <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/7Dztj-02Ebg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        $this->generate_page( $page );
    }

    /**
     * Download SSL Certs
     *
     * @since 5.1.0
     * @return HTML
     */
    public function wple_download_page() {
        $cert = WPLE_Trait::wple_cert_directory() . 'certificate.crt';
        $forced_completion = get_option( 'wple_backend' );
        $html = '<div class="download-certs" data-update="' . wp_create_nonce( 'wpledownloadpage' ) . '">';
        $emailattachment = esc_html__( 'Email SSL certs as attachment when SSL is generated / auto renewed.', 'wp-letsencrypt-ssl' );
        $emailcerts = get_option( 'wple_email_certs' );
        $emailcertswitch = '<div class="plan-toggler" style="text-align: left; margin: 40px 0 0px;"><span></span><label class="toggle">
    <input class="toggle-checkbox email-certs-switch" type="checkbox" ' . checked( $emailcerts, true, false ) . '>
    <div class="toggle-switch" style="transform: scale(0.9);"></div>
    <span class="toggle-label">' . $emailattachment . '</span>
    </label>
    </div>';
        if ( file_exists( $cert ) ) {
            $leopts = get_option( 'wple_opts' );
            if ( !$forced_completion ) {
                $html .= '<h3 style="margin:10px 13px 30px">' . esc_html__( 'Your generated SSL certificate expires on', 'wp-letsencrypt-ssl' ) . ': <b>' . esc_html( $leopts['expiry'] ) . '</b></h3>';
                WPLE_Trait::wple_copy_and_download( $html );
            }
            $html .= $emailcertswitch;
        } else {
            if ( !$forced_completion ) {
                $html .= '<div class="wple-no-certs">' . sprintf( __( "You don't have any SSL certificates generated yet! Please %sgenerate your single/wildcard SSL certificate%s first before you can download it here.", 'wp-letsencrypt-ssl' ), '<a href="' . admin_url( '/admin.php?page=wp_encryption' ) . '">', '</a>' ) . '</div>';
            }
            $html .= $emailcertswitch;
        }
        $html .= '</div>';
        $this->generate_page( $html );
    }

    public function wple_debug_log_page() {
        $file = WPLE_DEBUGGER . 'debug.log';
        $html = '<h3>' . esc_html__( 'Please share below debug log when requesting support', 'wp-letsencrypt-ssl' ) . '</h3>';
        if ( file_exists( $file ) ) {
            $log = file_get_contents( $file );
            $hideh2 = '';
            if ( isset( $_GET['dnsverified'] ) || isset( $_GET['dnsverify'] ) ) {
                $hideh2 = 'hideheader';
            }
            $html .= '<div class="le-debugger running ' . $hideh2 . '"><h3>' . esc_html__( 'Debug Log', 'wp-letsencrypt-ssl' ) . ':</h3>' . wp_kses_post( nl2br( $log ) ) . '</div>';
        } else {
            $html .= '<div class="le-debugger">' . esc_html__( "Full response will be shown here", 'wp-letsencrypt-ssl' ) . '</div>';
        }
        $this->generate_page( $html );
    }

    /**
     * Handy Tools
     *
     * @since 4.5.0
     * @source le_admin.php moved since 5.1.0
     * @return $html
     */
    public function wple_tools_block() {
        $html = '<h3>' . esc_html__( 'Reset / Delete Keys folder and restart the process', 'wp-letsencrypt-ssl' ) . '</h3>';
        $html .= '<p>' . esc_html__( "Use this handy tool to reset the SSL process and start again in case you get some error like 'no account exists with provided key'. This reset action will ONLY delete the generated certificate, keys folder and reset SSL install form to initial state. This won't affect SSL installed on your site or any other part of your site.", 'wp-letsencrypt-ssl' ) . '</p>';
        $html .= '<a href="' . wp_nonce_url( admin_url( 'admin.php?page=wp_encryption' ), 'restartwple', 'wplereset' ) . '" class="wple-reset-button">' . esc_html__( 'RESET KEYS AND CERTIFICATE', 'wp-letsencrypt-ssl' ) . '</a>';
        $this->generate_page( $html );
    }

    public function wple_clean_htaccess() {
        if ( is_writable( ABSPATH . '.htaccess' ) ) {
            $htaccess = file_get_contents( ABSPATH . '.htaccess' );
            $group = "/#\\s?BEGIN\\s?WP_Encryption_Force_SSL.*?#\\s?END\\s?WP_Encryption_Force_SSL/s";
            if ( preg_match( $group, $htaccess ) ) {
                $modhtaccess = preg_replace( $group, "", $htaccess );
                //insert_with_markers(ABSPATH . '.htaccess', '', $modhtaccess);
                file_put_contents( ABSPATH . '.htaccess', $modhtaccess );
            }
        } else {
            wp_die( esc_html__( '.htaccess file not writable. Please remove WP_Encryption_Force_SSL block from .htaccess file manually using FTP or File Manager.', 'wp-letsencrypt-ssl' ) );
            exit;
        }
    }

    public function wple_mixed_scanner_page() {
        $html = '<h2>' . esc_html__( 'Advanced Insecure Content Scanner', 'wp-letsencrypt-ssl' ) . '</h2><p style="margin: -20px auto 40px auto; font-size: 16px; text-align: center; width: 1400px; max-width: 100%;">' . WPLE_Trait::wple_kses( __( 'Scan your entire site (public posts + pages) for mixed/insecure content issues that are causing secure browser padlock to not show even if SSL certificate is installed correctly. SOURCE column shows you where the insecure url is coming from, you can easily find the mixed content url and update it to https:// to resolve the issue. Issues arising from Widgets or Inline are global issues which could be breaking HTTPS padlock on several of your webpages. Resolve the issues, reload and re-scan to confirm everything is resolved.', 'wp-letsencrypt-ssl' ) ) . '.</p>';
        $html .= "<p style=\"margin: -20px auto 40px auto; font-size: 16px; text-align: center; width: 1400px; max-width: 100%;font-style:italic;color:#666;\">We're working hard to add more features. Please consider upgrading to <a href=\"" . admin_url( '/admin.php?page=wp_encryption-pricing' ) . "\">PRO</a> version if you wish to support the development.</p>";
        $html .= '<div id="wple-scanner">
    <button class="wple-scan" data-nc="' . wp_create_nonce( 'wplemixedscanner' ) . '">' . esc_html__( 'START THE SCAN', 'wp-letsencrypt-ssl' ) . '</button>
    </div>';
        $html .= '<div id="wple-scanner-iframe">
    <div class="wple-scanbar"></div>    
    <div class="wple-frameholder"></div>
    </div>
    
    <div id="wple-scanresults"></div>';
        $this->generate_page( $html );
    }

    /**
     * CDN Page
     *
     * @since 5.2.14
     * @return void
     */
    // public function wple_cdn_page__premium_only()
    // {
    //   $html = '<h2><span class="dashicons dashicons-superhero"></span>&nbsp;WP ENCRYPTION CDN</h2>';
    //   //TODO
    //   $this->generate_page($html);
    // }
    /**
     * Enabled/Disable Email certs setting
     *
     * @since 5.3.5
     * @return void
     */
    public function wple_email_certs_setting() {
        if ( !wp_verify_nonce( $_POST['nc'], 'wpledownloadpage' ) ) {
            exit( 'failed' );
        }
        if ( !current_user_can( 'manage_options' ) ) {
            exit( 'failed' );
        }
        $val = ( $_POST['emailcert'] == 'true' ? true : false );
        update_option( 'wple_email_certs', $val );
        echo "success";
        exit;
    }

    /**
     * Review admin notice ajax
     *
     * @since 5.3.12
     * @return void
     */
    public function wple_review_notice_disable() {
        if ( !wp_verify_nonce( $_POST['nc'], 'wplereview' ) || !current_user_can( 'manage_options' ) ) {
            exit( 'Unauthorized' );
        }
        $ch = (int) $_POST['choice'];
        if ( $ch == 2 ) {
            //remind later
            delete_option( 'wple_show_review' );
            wp_schedule_single_event( strtotime( '+3 day', time() ), 'wple_show_reviewrequest' );
        } else {
            //already reviewed //dont show again
            update_option( 'wple_show_review_disabled', true );
            delete_option( 'wple_show_review' );
        }
        exit;
    }

    /**
     * Ignore mixed content errors and hire expert prom
     *
     * @since 5.3.12
     * @return void
     */
    public function wple_mx_ignore() {
        if ( current_user_can( 'manage_options' ) ) {
            delete_option( 'wple_mixed_issues' );
            if ( isset( $_POST['remind'] ) && $_POST['remind'] == 'true' ) {
                wp_schedule_single_event( strtotime( '+1 day', time() ), 'wple_show_mxalert' );
            } else {
                update_option( 'wple_mixed_issues_disabled', true );
            }
            //5.7.4
            delete_option( 'wple_renewal_failed_notice' );
            echo "success";
        }
        exit;
    }

    /**
     * New SSL health page with score
     *
     * @since 5.5.0
     * @return void
     */
    public function wple_sslhealth_page() {
        $html = '<div id="wple-ssl-health">';
        $html .= $this->wple_ssl_score();
        $html .= $this->wple_ssl_settings();
        $html .= '</div>';
        echo $html;
    }

    private function wple_ssl_score() {
        $scorecard = array(
            'valid_ssl'           => 10,
            'ssl_redirect'        => 10,
            'mixed_content_fixer' => 10,
            'hsts'                => 10,
            'security_headers'    => 10,
            'httponly_cookies'    => 10,
            'tls_version'         => 10,
            'ssl_auto_renew'      => 10,
            'improve_security'    => 0,
            'ssl_monitoring'      => 0,
            'advanced_security'   => 20,
        );
        $scoredefinitions = array(
            'valid_ssl'           => 'Valid SSL Certificate exists (<a href="' . get_site_url() . '/wp-admin/admin.php?page=wp_encryption">Install SSL Now</a>).',
            'ssl_redirect'        => 'HTTP to HTTPS redirect enabled (<a href="' . get_site_url() . '/wp-admin/admin.php?page=wp_encryption_force_https">Enable Redirection</a>)',
            'mixed_content_fixer' => 'Mixed content fixer enabled',
            'hsts'                => 'HSTS Strict Transport header enabled',
            'security_headers'    => 'Important security headers enabled',
            'httponly_cookies'    => 'HttpOnly secure cookies enabled',
            'ssl_monitoring'      => 'SSL monitoring enabled',
            'tls_version'         => 'TLS version up-to-date',
            'ssl_auto_renew'      => 'SSL certificate is set to auto renew (<a href="' . get_site_url() . '/wp-admin/admin.php?page=wp_encryption-pricing">Premium</a>)',
            'advanced_security'   => 'Advanced security headers enabled (<a href="' . get_site_url() . '/wp-admin/admin.php?page=wp_encryption-pricing">Premium</a>)',
            'improve_security'    => 'Improve security with WP Encryption Pro (<a href="' . get_site_url() . '/wp-admin/admin.php?page=wp_encryption-pricing">Premium</a>)',
        );
        $score = 0;
        $featurelist = '<ul>';
        $error_count = 0;
        $viaAlternateMethod = array();
        // Enabled through secondary sources
        // $response = wp_safe_remote_head(site_url(), array());
        // $dictionary = wp_remote_retrieve_headers($response);
        // $currentHeaders = $dictionary ? $dictionary->getAll() : array();
        foreach ( $scoredefinitions as $key => $desc ) {
            $isenabled = $this->wple_feature_check( $key );
            if ( $isenabled == 2 ) {
                $viaAlternateMethod[] = $key;
            }
            $sayyesno = '<span class="wple-no">no</span>';
            if ( $isenabled ) {
                $sayyesno = '<span class="wple-yes">Yes</span>';
                $score += (int) $scorecard[$key];
            } else {
                $error_count++;
            }
            $featurelist .= '<li class="' . esc_attr( $key ) . '">' . $sayyesno . WPLE_Trait::wple_kses( $desc, 'a' ) . (( $key == 'tls_version' ? '<span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="TLS version should be 1.2 or above. Contact your hosting support to update TLS version or our Annual PRO plan can offer TLS1.2 protocol."></span>' : (( $key == 'security_headers' ? '<span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="X-XSS and X-Content-Type-Options header"></span>' : '' )) )) . '</li>';
        }
        set_transient( 'wple_alternate_headers', $viaAlternateMethod, 60 * 60 );
        //1 hour
        $featurelist .= '<br /><li class="wplenote note-info"><strong>Recommended:</strong> Run Insecure content scanner & make sure no issue exists (<a href="/wp-admin/admin.php?page=wp_encryption_mixed_scanner">Scan now</a>)</li>';
        //5.7.0
        $plugin = false;
        if ( defined( 'rsssl_plugin' ) ) {
            $plugin = "Really Simple SSL";
        } elseif ( defined( 'AIFS_VERSION' ) ) {
            $plugin = "Auto-Install Free SSL";
        } elseif ( defined( 'WPSSL_VER' ) ) {
            $plugin = "WP Free SSL";
        } elseif ( defined( 'SSL_ZEN_PLUGIN_VERSION' ) ) {
            $plugin = "SSL Zen";
        } elseif ( defined( 'WPSSL_VER' ) ) {
            $plugin = "WP Free SSL";
        } elseif ( defined( 'SSLFIX_PLUGIN_VERSION' ) ) {
            $plugin = "SSL Insecure Content Fixer";
        } elseif ( class_exists( 'OCSSL', false ) ) {
            $plugin = "One Click SSL";
        } elseif ( class_exists( 'JSM_Force_SSL', false ) ) {
            $plugin = "JSM's Force HTTP to HTTPS (SSL)";
        } elseif ( function_exists( 'httpsrdrctn_plugin_init' ) ) {
            $plugin = "Easy HTTPS (SSL) Redirection";
        } elseif ( defined( 'WPSSL_VER' ) ) {
            $plugin = "WP Free SSL";
        } elseif ( defined( 'WPFSSL_OPTIONS_KEY' ) ) {
            $plugin = "WP Force SSL";
        } elseif ( defined( 'ESSL_REQUIRED_PHP_VERSION' ) ) {
            $plugin = "EasySSL";
        }
        if ( $plugin !== false ) {
            $featurelist .= '<li class="wplenote note-warning"><strong style="color:red">WARNING:</strong> ' . sprintf( __( 'We have detected the %s plugin on your website.', 'wp-letsencrypt-ssl' ), '<strong>' . $plugin . '</strong>' ) . '&nbsp;' . __( 'As WP Encryption handles all the functionality this plugin provides, we recommend disabling this plugin to prevent unexpected behaviour.', 'wp-letsencrypt-ssl' ) . '</li>';
        }
        if ( stripos( $_SERVER['SERVER_SOFTWARE'], 'nginx' ) >= 0 && file_exists( ABSPATH . 'keys/private.pem' ) && @file_get_contents( site_url( 'keys/private.pem' ) ) !== FALSE ) {
            $featurelist .= '<li class="wplenote note-warning"><strong style="color:red">WARNING:</strong> ' . sprintf( __( 'You will manually need to %sfollow our nginx tutorial%s to restrict access to private key file on your Nginx server.', 'wp-letsencrypt-ssl' ), '<a href="https://wpencryption.com/restrict-private-key-access-nginx/" target="_blank">', '</a>' ) . '</li>';
        }
        update_option( "wple_ssl_errors", $error_count );
        $featurelist .= '</ul>';
        $scorecolor = ( $score >= 30 && $score <= 70 ? 'e2d754' : (( $score > 70 ? '67d467' : 'ff5252' )) );
        $output = '<div class="wple-ssl-score">
    <h2 style="color:#444">SSL Score</h2>';
        $output .= '<div class="wple-score">' . (int) $score . '</div>
    <div class="wple-scorebar"><span data-width="' . (int) $score . '" style="width:' . (int) $score . '%;background:#' . esc_attr( $scorecolor ) . '"></span></div>';
        if ( $score == 70 ) {
            $output .= '<h3 class="score-prom" style="margin-bottom:30px">You still have major task pending!</h3>';
        }
        $output .= $featurelist;
        ///$output .= WPLE_Trait::wple_other_plugins(true);
        $output .= '</div>';
        return $output;
    }

    private function wple_feature_check( $key ) {
        switch ( $key ) {
            case 'valid_ssl':
                $rootdomain = WPLE_Trait::get_root_domain( false );
                $client = WPLE_Trait::wple_verify_ssl( $rootdomain );
                if ( $client || is_ssl() ) {
                    update_option( 'wple_ssl_valid', true );
                    return 1;
                }
                update_option( 'wple_ssl_valid', false );
                break;
            case 'ssl_redirect':
                $rootdomain = WPLE_Trait::get_root_domain( false );
                $gethead = wp_remote_head( 'http://' . $rootdomain, array(
                    'sslverify'   => false,
                    'redirection' => 0,
                    'timeout'     => 10,
                ) );
                if ( is_wp_error( $gethead ) ) {
                    return 0;
                }
                $privatearray = $gethead['headers']->getAll();
                if ( isset( $privatearray['location'] ) && untrailingslashit( $privatearray['location'] ) == 'https://' . $rootdomain ) {
                    return 1;
                }
                $opts = get_option( 'wple_opts' );
                if ( FALSE !== $opts && isset( $opts['force_ssl'] ) && $opts['force_ssl'] >= 1 ) {
                    return 1;
                }
                break;
            case 'httponly_cookies':
                if ( get_option( 'wple_' . $key ) ) {
                    return 1;
                }
                $arr = session_get_cookie_params();
                if ( $arr['httponly'] ) {
                    return 2;
                }
                break;
            case 'mixed_content_fixer':
            case 'hsts':
            case 'ssl_monitoring':
            case 'disable_directory_listing':
                if ( get_option( 'wple_' . $key ) ) {
                    return 1;
                }
                break;
            case 'security_headers':
                if ( get_option( 'wple_xxss' ) && get_option( 'wple_xcontenttype' ) ) {
                    return 1;
                }
                break;
            case 'advanced_security':
                break;
            case 'tls_version':
                $tls = '1.2';
                if ( function_exists( 'curl_init' ) ) {
                    $ch = curl_init( 'https://www.howsmyssl.com/a/check' );
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                    curl_setopt( $ch, CURLOPT_TIMEOUT, 5 );
                    $json = curl_exec( $ch );
                    curl_close( $ch );
                    $json = json_decode( $json );
                    if ( !empty( $json->tls_version ) ) {
                        $tls = str_replace( "TLS ", "", $json->tls_version );
                    }
                }
                if ( version_compare( $tls, '1.2', '>=' ) ) {
                    return 1;
                }
                break;
            case 'ssl_auto_renew':
                break;
            case 'improve_security':
                break;
        }
        return 0;
    }

    private function wple_ssl_settings() {
        $output = '<div class="wple-activessl-info">
    
    <div class="wple-activessl-info-inner">
    
    <h2>Active SSL Info</h2>';
        $output .= WPLE_Trait::wple_active_ssl_info();
        $output .= '</div><!--wple-activessl-info-inner-->
    </div>';
        $sslopts = array(
            'Enable Mixed Content Fixer'     => [
                'key'  => 'mixed_content_fixer',
                'desc' => 'Fixes basic mixed content issues like images, urls, stylesheets, etc.,',
            ],
            'Enable HttpOnly Secure Cookies' => [
                'key'  => 'httponly_cookies',
                'desc' => 'Cookies are made accessible server side only. Even if XSS flaw exists in client side or user accidently access a link exploting the flaw, client side script cannot read the cookies',
            ],
            'Disable directory listing'      => [
                'key'  => 'disable_directory_listing',
                'desc' => 'Disable directory browsing on Apache servers to avoid visibility of file structure on front-end',
            ],
            'Enable SSL Monitoring'          => [
                'key'  => 'ssl_monitoring',
                'desc' => 'You will get automated email as well as dashboard notification when SSL is expiring within 10 days',
            ],
        );
        $sec_headers = array(
            'Enable Upgrade Insecure Requests Header' => [
                'key'  => 'upgrade_insecure',
                'desc' => 'Upgrades insecure HTTP requests to HTTPS',
            ],
            'Enable HSTS Strict Transport Header'     => [
                'key'  => 'hsts',
                'desc' => 'HSTS Strict Transport blocks all insecure assets & resources which cannot be served over HTTPS',
            ],
            'Enable X-XSS Header'                     => [
                'key'  => 'xxss',
                'desc' => 'Blocks page loading when cross site scripting attacks are detected',
            ],
            'Enable X-Content-Type-Options Header'    => [
                'key'  => 'xcontenttype',
                'desc' => 'Protects against MIME sniffing vulnerabilities',
            ],
            'Enable X-Frame-Options Header (Premium)' => [
                'key'     => 'xframe',
                'desc'    => 'Blocks embedding of your site on other domains to avoid click-jacking attacks',
                'premium' => 1,
            ],
            'Enable Referrer-Policy Header (Premium)' => [
                'key'     => 'referrer',
                'desc'    => 'Blocks referrer info transfer when HTTPS to HTTP scheme downgrade happens',
                'premium' => 1,
            ],
        );
        $output .= '<div class="wple-ssl-settings" data-update="' . wp_create_nonce( 'wplesettingsupdate' ) . '">
    <h2>Settings</h2>';
        $output .= '<ul>';
        $enabledViaAlternate = get_transient( 'wple_alternate_headers' );
        //from wple_feature_check
        $enabledViaAlternate = ( is_array( $enabledViaAlternate ) ? $enabledViaAlternate : array() );
        foreach ( $sslopts as $optlabel => $optarr ) {
            $output .= '<li><label>' . esc_html( $optlabel ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr( $optarr['desc'] ) . '"></span></label>';
            $disabled = ( isset( $optarr['premium'] ) ? $optarr['premium'] : 0 );
            $isActive = get_option( "wple_" . esc_attr( $optarr['key'] ) );
            $viaSecondary = false;
            if ( in_array( $optarr['key'], $enabledViaAlternate ) ) {
                $isActive = $viaSecondary = 1;
            }
            $output .= '<div class="plan-toggler" style="text-align: left; margin: 40px 0 0px;">';
            if ( $viaSecondary ) {
                $output .= '<span class="dashicons dashicons-info-outline wple-tooltip" style="margin: 7px 0; color: #ff8900;" data-tippy="We have detected that this header is already enforced via other sources like wp-config, htaccess or php.ini"></span>';
            }
            $output .= '
      <label class="toggle">
      <input class="toggle-checkbox wple-setting" data-opt="' . esc_attr( $optarr['key'] ) . '" type="checkbox" ' . checked( $isActive, "1", false ) . disabled( $disabled, '1', false ) . '>
      <div class="toggle-switch disabled' . intval( $disabled ) . '" style="transform: scale(0.6);"></div>
      
      </label>';
            $output .= '</div>
      </li>';
        }
        $output .= '</ul>
    <br />
    <h2>Security Headers</h2>
    <ul>';
        foreach ( $sec_headers as $optlabel => $optarr ) {
            $output .= '<li><label>' . esc_html( $optlabel ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr( $optarr['desc'] ) . '"></span></label>';
            $disabled = ( isset( $optarr['premium'] ) ? $optarr['premium'] : 0 );
            $output .= '<div class="plan-toggler" style="text-align: left; margin: 40px 0 0px;">
      <span></span>
      <label class="toggle">
      <input class="toggle-checkbox wple-setting" data-opt="' . esc_attr( $optarr['key'] ) . '" type="checkbox" ' . checked( get_option( "wple_" . esc_attr( $optarr['key'] ) ), "1", false ) . disabled( $disabled, '1', false ) . '>
      <div class="toggle-switch disabled' . intval( $disabled ) . '" style="transform: scale(0.6);"></div>
      
      </label>
      </div>';
            $output .= '</li>';
        }
        $output .= '<li class="wple-setting-error"><label>' . __( 'You must have a valid SSL certificate installed on your site before enabling this feature', 'wp-letsencrypt-ssl' ) . '!.</label></li>
    <li class="wple-sec-scanner"><a href="https://securityheaders.com/" target="_blank" rel="nofollow">Security Header Scanner <span class="dashicons dashicons-external"></span></a></li>';
        $output .= '</ul>';
        $output .= '</div>';
        return $output;
    }

    public function wple_update_settings() {
        if ( !current_user_can( 'manage_options' ) || !wp_verify_nonce( $_POST['nc'], 'wplesettingsupdate' ) ) {
            echo 0;
            exit;
        }
        $opt = $_POST['opt'];
        $val = (int) $_POST['val'];
        $allowed = array(
            'mixed_content_fixer',
            'hsts',
            'security_headers',
            'upgrade_insecure',
            'disable_directory_listing',
            'httponly_cookies',
            'ssl_monitoring',
            'xxss',
            'xcontenttype',
            'xframe',
            'referrer',
            'vulnerability_scan',
            'daily_vulnerability_scan',
            'notify_vulnerability_scan',
            'autofix_vulnerability_scan'
        );
        if ( !in_array( $opt, $allowed ) ) {
            echo 0;
            exit;
        }
        $out = 0;
        $xxss_header = get_option( 'wple_xxss' );
        $xctype_header = get_option( 'wple_xcontenttype' );
        // if (wple_fs()->can_use_premium_code__premium_only()) {
        //   $xframe = get_option('wple_xframe');
        //   $refer = get_option('wple_referrer');
        // }
        $score_exclusions = array(
            'upgrade_insecure',
            'disable_directory_listing',
            'ssl_monitoring',
            'vulnerability_scan',
            'daily_vulnerability_scan',
            'notify_vulnerability_scan',
            'autofix_vulnerability_scan'
        );
        $no_writing = array(
            'ssl_monitoring',
            'vulnerability_scan',
            'daily_vulnerability_scan',
            'notify_vulnerability_scan',
            'autofix_vulnerability_scan'
        );
        //file writing not required
        $ssl_not_required = array(
            'httponly_cookies',
            'disable_directory_listing',
            'ssl_monitoring',
            'xxss',
            'xcontenttype',
            'xframe',
            'referrer',
            'vulnerability_scan',
            'daily_vulnerability_scan',
            'notify_vulnerability_scan',
            'autofix_vulnerability_scan'
        );
        if ( $val == 0 ) {
            delete_option( "wple_" . $opt );
            if ( $opt == 'daily_vulnerability_scan' ) {
                wp_clear_scheduled_hook( 'wple_init_vulnerability_scan' );
            }
            if ( !in_array( $opt, $score_exclusions ) ) {
                $out = -10;
            }
            if ( $opt == 'xxss' && $xctype_header ) {
                $out = 0;
            }
            if ( $opt == 'xcontenttype' && $xxss_header ) {
                $out = 0;
            }
            if ( !in_array( $opt, $no_writing ) ) {
                $this->wple_addremove_security_headers( $out, $opt, $val );
            }
        } else {
            if ( $opt == 'daily_vulnerability_scan' ) {
                wp_schedule_event( strtotime( 'now' ), 'daily', 'wple_init_vulnerability_scan' );
            }
            if ( !in_array( $opt, $score_exclusions ) ) {
                $out = 10;
            }
            if ( $opt == 'xxss' && !$xctype_header ) {
                $out = 0;
            }
            if ( $opt == 'xcontenttype' && !$xxss_header ) {
                $out = 0;
            }
            if ( false == get_option( 'wple_ssl_valid' ) && !in_array( $opt, $ssl_not_required ) ) {
                //no valid ssl detected
                $out = 1;
                echo $out;
                exit;
            }
            update_option( "wple_" . $opt, 1 );
            if ( !in_array( $opt, $no_writing ) ) {
                $this->wple_addremove_security_headers( $out, $opt, $val );
            }
        }
        echo $out;
        exit;
    }

    private function wple_addremove_security_headers( &$out, $opt, $val ) {
        if ( $opt == 'xxss' || $opt == 'xcontenttype' || $opt == 'xframe' || $opt == 'referrer' || $opt == 'upgrade_insecure' || $opt == 'hsts' ) {
            // if (!is_writable(ABSPATH . '.htaccess')) {
            //   delete_option('wple_' . $opt);
            //   $out = 'htaccessnotwritable';
            //   return $out;
            // }
            if ( $val == 1 ) {
                //add request
                if ( is_writable( ABSPATH . '.htaccess' ) ) {
                    WPLE_Trait::wple_clean_security_headers();
                    //complete block
                    $htaccess = file_get_contents( ABSPATH . '.htaccess' );
                    $getrules = WPLE_Trait::compose_htaccess_security_rules();
                    // $wpruleset = "# BEGIN WordPress";
                    // if (strpos($htaccess, $wpruleset) !== false) {
                    //   $newhtaccess = str_replace($wpruleset, $getrules . $wpruleset, $htaccess);
                    // } else {
                    //   $newhtaccess = $htaccess . $getrules;
                    // }
                    insert_with_markers( ABSPATH . '.htaccess', 'WP_Encryption_Security_Headers', $getrules );
                }
            } else {
                //remove request
                WPLE_Trait::wple_clean_security_headers( $opt );
            }
            return $out;
        } else {
            if ( $opt == 'disable_directory_listing' ) {
                if ( !is_writable( ABSPATH . '.htaccess' ) ) {
                    delete_option( "wple_{$opt}" );
                    $out = 'htaccessnotwritable';
                    return $out;
                }
                if ( $val == 1 ) {
                    //add request
                    if ( is_writable( ABSPATH . '.htaccess' ) ) {
                        WPLE_Trait::wple_remove_directory_listing();
                        $htaccess = file_get_contents( ABSPATH . '.htaccess' );
                        $getrules = WPLE_Trait::compose_directory_listing_rules();
                        // $wpruleset = "# BEGIN WordPress";
                        // if (strpos($htaccess, $wpruleset) !== false) {
                        //   $newhtaccess = str_replace($wpruleset, $getrules . $wpruleset, $htaccess);
                        // } else {
                        //   $newhtaccess = $htaccess . $getrules;
                        // }
                        insert_with_markers( ABSPATH . '.htaccess', 'WP_Encryption_Disable_Directory_Listing', $getrules );
                    }
                } else {
                    //remove request
                    WPLE_Trait::wple_remove_directory_listing();
                }
                return $out;
            } else {
                if ( $opt == 'httponly_cookies' ) {
                    if ( !is_writable( ABSPATH . 'wp-config.php' ) ) {
                        delete_option( "wple_{$opt}" );
                        $out = 'wpconfignotwritable';
                        return $out;
                    }
                    if ( $val == 1 ) {
                        $config = file_get_contents( ABSPATH . "wp-config.php" );
                        if ( FALSE == strpos( $config, 'WP_ENCRYPTION_COOKIES' ) ) {
                            $config = preg_replace( "/^([\r\n\t ]*)(\\<\\?)(php)?/i", '<?php ' . "\n" . '# BEGIN WP_ENCRYPTION_COOKIES' . "\n" . "@ini_set('session.cookie_httponly', true);" . "\n" . "@ini_set('session.use_only_cookies', true);" . "\n" . "@ini_set('session.cookie_secure', true);" . "\n" . '# END WP_ENCRYPTION_COOKIES' . "\n", $config );
                            file_put_contents( ABSPATH . "wp-config.php", $config );
                        }
                    } else {
                        if ( is_writable( ABSPATH . 'wp-config.php' ) ) {
                            $htaccess = file_get_contents( ABSPATH . 'wp-config.php' );
                            $group = "/#\\s?BEGIN\\s?WP_ENCRYPTION_COOKIES.*?#\\s?END\\s?WP_ENCRYPTION_COOKIES/s";
                            if ( preg_match( $group, $htaccess ) ) {
                                $modhtaccess = preg_replace( $group, "", $htaccess );
                                file_put_contents( ABSPATH . 'wp-config.php', $modhtaccess );
                            }
                        }
                    }
                    return $out;
                }
            }
        }
    }

    public function wple_ssl_toolbar( $admin_bar ) {
        $ecount = get_option( 'wple_ssl_errors' );
        $notifications = ( FALSE !== $ecount ? '<span class="ab-label">' . (int) $ecount . '</span>' : '' );
        $admin_bar->add_menu( array(
            'id'    => 'wple-ssl-health',
            'title' => "SSL {$notifications}",
            'href'  => admin_url( 'admin.php?page=wp_encryption_ssl_health' ),
            'meta'  => array(
                'title' => __( 'SSL Health', 'wp-letsencrypt-ssl' ),
            ),
        ) );
    }

    // public function wple_sitelockmonitor__premium_only()
    // {
    //   $page = '<div class="sitelock-recommend">
    //   <h2>' . __('Sitelock Monitor', 'wp-letsencrypt-ssl') . '</h2>
    //   <p>Don\'t leave your website security behind!, Access wide range of tools like Malware scanner, Spam scanner, Risk score assessment, Vulnerability scanner & SSL scanner including access to your private SiteLock Monitor Dashboard with our <b>SITELOCK</b> plan.</p>
    //   <img src="https://wpencryption.com/wp-content/uploads/2023/03/sitelock-monitor-1405x1536.png"/>';
    //   $lic = wple_fs()->_get_license();
    //   if (FALSE != $lic) {
    //     if ($lic->expiration != '') { //annual
    //       $page .= '<a href="' . admin_url('admin.php?page=wp_encryption-pricing&checkout=true&plan_id=20784&plan_name=sitelock&billing_cycle=annual&currency=usd') . '">UPGRADE TO SITELOCK PLAN</a>';
    //     } else { //lifetime
    //       $page .= '<a href="https://checkout.freemius.com/mode/dialog/plugin/5090/plan/20784/" target="_blank">BUY SITELOCK PLAN</a>';
    //     }
    //   }
    //   $page .= '</div>';
    //   $this->generate_page($page);
    // }
    /**
     * WP Site Health Tests
     *
     * @since 6.3.5
     * @param array $tests
     * @return $tests
     */
    public function wple_vulnerable_components( $tests ) {
        $this->threats = get_transient( 'wple_vulnerability_scan' );
        if ( is_array( $this->threats ) && count( $this->threats ) > 0 ) {
            // echo '<pre>';
            // print_r($this->threats);
            // exit();
            //core
            foreach ( $this->threats as $slug => $data ) {
                if ( array_key_exists( 'type', $data ) && $data['type'] == 'core' ) {
                    $tests['direct']['wple_core_vuln'] = array(
                        'label' => __( 'Core Vulnerabilities' ),
                        'test'  => [$this, 'wple_core_vuln_test'],
                    );
                    break;
                }
            }
            //plugin
            foreach ( $this->threats as $slug => $data ) {
                if ( !array_key_exists( 'type', $data ) && $data[0]['type'] == 'plugin' ) {
                    $tests['direct']['wple_plugin_vuln'] = array(
                        'label' => __( 'Plugin Vulnerabilities' ),
                        'test'  => [$this, 'wple_plugin_vuln_test'],
                    );
                    break;
                }
            }
            //theme
            foreach ( $this->threats as $slug => $data ) {
                if ( !array_key_exists( 'type', $data ) && $data[0]['type'] == 'theme' ) {
                    $tests['direct']['wple_theme_vuln'] = array(
                        'label' => __( 'Theme Vulnerabilities' ),
                        'test'  => [$this, 'wple_theme_vuln_test'],
                    );
                    break;
                }
            }
        }
        return $tests;
    }

    public function wple_core_vuln_test() {
        $desc = '';
        foreach ( $this->threats as $slug => $data ) {
            if ( array_key_exists( 'type', $data ) && $data['type'] == 'core' ) {
                $desc = $data['desc'];
            }
        }
        $result = array(
            'label'       => __( 'There are vulnerabilities in WordPress Core' ),
            'status'      => 'critical',
            'badge'       => array(
                'label' => __( 'Security' ),
                'color' => 'red',
            ),
            'description' => '<p>' . esc_html( $desc ) . '</p><br><a href="' . admin_url( '/update-core.php' ) . '">Update WordPress Core</a><br><br><a href="' . admin_url( '/admin.php?page=wp_encryption_ssl_health' ) . '">View / Re-run vulnerablility scan</a>',
            'actions'     => '',
            'test'        => 'wple_core_vulnerability',
        );
        return $result;
    }

    public function wple_plugin_vuln_test() {
        $table = '<table border="1" cellpadding="10" style="border-collapse:collapse;">
    <th>Name</th>
    <th>Description</th>
    <th>Severity</th>
    <th>Reference</th>';
        foreach ( $this->threats as $slug => $data ) {
            if ( !array_key_exists( 'type', $data ) && $data[0]['type'] == 'plugin' ) {
                $data = $data[0];
                $table .= '<tr>
        <td>' . esc_html( $data['label'] ) . '</td>
        <td>' . esc_html( $data['desc'] ) . '</td>
        <td>' . esc_html( strtoupper( $data['severity'] ) ) . '</td>
        <td>' . esc_url( $data['reference'] ) . '</td>
        </tr>';
            }
        }
        $table .= '</table>';
        $result = array(
            'label'       => __( 'There are vulnerabilities in Plugins' ),
            'status'      => 'critical',
            'badge'       => array(
                'label' => __( 'Security' ),
                'color' => 'red',
            ),
            'description' => '<p>' . $table . '</p><br><a href="' . admin_url( '/update-core.php' ) . '">Update Plugins</a><br><br><a href="' . admin_url( '/admin.php?page=wp_encryption_ssl_health' ) . '">View / Re-run vulnerablility scan</a>',
            'actions'     => '',
            'test'        => 'wple_plugins_vulnerability',
        );
        return $result;
    }

    public function wple_theme_vuln_test() {
        $table = '<table border="1" cellpadding="10" style="border-collapse:collapse;">
    <th>Name</th>
    <th>Description</th>
    <th>Severity</th>
    <th>Reference</th>';
        foreach ( $this->threats as $slug => $data ) {
            if ( !array_key_exists( 'type', $data ) && $data[0]['type'] == 'theme' ) {
                $data = $data[0];
                $table .= '<tr>
        <td>' . esc_html( $data['label'] ) . '</td>
        <td>' . esc_html( $data['desc'] ) . '</td>
        <td>' . esc_html( strtoupper( $data['severity'] ) ) . '</td>
        <td>' . esc_url( $data['reference'] ) . '</td>
        </tr>';
            }
        }
        $table .= '</table>';
        $result = array(
            'label'       => __( 'There are vulnerabilities in Themes' ),
            'status'      => 'critical',
            'badge'       => array(
                'label' => __( 'Security' ),
                'color' => 'red',
            ),
            'description' => '<p>' . $table . '</p><br><a href="' . admin_url( '/update-core.php' ) . '">Update Theme</a><br><br><a href="' . admin_url( '/admin.php?page=wp_encryption_ssl_health' ) . '">View / Re-run vulnerablility scan</a>',
            'actions'     => '',
            'test'        => 'wple_themes_vulnerability',
        );
        return $result;
    }

    public function wple_enforce_security_headers( $headers = array() ) {
        if ( get_option( 'wple_upgrade_insecure' ) ) {
            $headers['Content-Security-Policy'] = 'upgrade-insecure-requests';
        }
        if ( get_option( 'wple_hsts' ) ) {
            $headers['Strict-Transport-Security'] = 'max-age=31536000;includeSubDomains';
        }
        if ( get_option( 'wple_xxss' ) ) {
            $headers['x-xss-protection'] = '1; mode=block';
        }
        if ( get_option( 'wple_xcontenttype' ) ) {
            $headers['X-Content-Type-Options'] = 'nosniff';
        }
        return $headers;
    }

    /**
     * Security page
     *
     * @return html
     */
    public function wple_security_page() {
        $html = '<div id="wple-ssl-health" class="wple-security">';
        $html .= '<div class="wple-activessl-info">
    <div class="wple-activessl-info-inner">
    <h2>Vulnerability Scan</h2>
    <small>By enabling this option, you grant access to list of installed plugins, themes to scan for known vulnerabilities using <a href="https://vulnerability.wpsysadmin.com/" target="_blank" rel="noreferrer nofollow">WPVulnerability API</a>.</small>
    <ul>';
        $vuln_headers = array(
            'Enable Vulnerability Scanner'                    => [
                'key'     => 'vulnerability_scan',
                'desc'    => 'Scans installed versions of your WordPress core, plugins, themes for known vulnerabilities.',
                'premium' => 0,
            ],
            'Enable Daily Scan (Premium)'                     => [
                'key'     => 'daily_vulnerability_scan',
                'desc'    => 'Automatically Scans installed versions of your WordPress core, plugins, themes for known vulnerabilities everyday.',
                'premium' => 1,
            ],
            'Enable Instant Notification (Premium)'           => [
                'key'     => 'notify_vulnerability_scan',
                'desc'    => 'Immediately notifies you via email / admin notice when a medium+ vulnerability is found.',
                'premium' => 1,
            ],
            'Enable Automatic Vulnerability Fixing (Premium)' => [
                'key'     => 'autofix_vulnerability_scan',
                'desc'    => 'Automatically update vulnerable plugin, theme, core as soon as updated patch is found',
                'premium' => 1,
            ],
        );
        $output = '';
        foreach ( $vuln_headers as $optlabel => $optarr ) {
            $output .= '<li><label>' . str_ireplace( 'Premium', '<a href="' . admin_url( 'admin.php?page=wp_encryption-pricing' ) . '">Premium</a>', esc_html( $optlabel ) ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr( $optarr['desc'] ) . '"></span></label>';
            $disabled = ( isset( $optarr['premium'] ) ? $optarr['premium'] : 0 );
            $output .= '<div class="plan-toggler" style="text-align: left; margin: 40px 0 0px;">
      <span></span>
      <label class="toggle">
      <input class="toggle-checkbox wple-setting" data-opt="' . esc_attr( $optarr['key'] ) . '" type="checkbox" ' . checked( get_option( "wple_" . esc_attr( $optarr['key'] ) ), "1", false ) . disabled( $disabled, '1', false ) . '>
      <div class="toggle-switch disabled' . intval( $disabled ) . '" style="transform: scale(0.6);"></div>
      
      </label>
      </div>';
            $output .= '</li>';
        }
        $threats = get_transient( 'wple_vulnerability_scan' );
        $threatcount = 0;
        $vuln_table = '<h3 style="text-align:center">Please run the scan to detect vulnerabilities</h3>';
        if ( is_array( $threats ) && count( $threats ) == 0 ) {
            $vuln_table = '<h3 style="text-align:center">All good! No vulnerabilities found.</h3>';
        }
        if ( is_array( $threats ) && count( $threats ) > 0 ) {
            $threatcount = count( $threats );
            //vulnerabilities found
            $vuln_table = '<h3 style="text-align:center">Vulnerabilities Found! Please update WordPress, Themes, Plugins accordingly.</h3>
      <table id="wple-vuln-table">
      <thead>
      <th>Name</th>
      <th>Type</th>
      <th>Severity</th>
      </thead>
      <tbody>';
            $sevr = array(
                'c'       => 'critical',
                'h'       => 'high',
                'm'       => 'medium',
                'l'       => 'low',
                'unknown' => 'unknown',
            );
            foreach ( $threats as $slug => $data ) {
                if ( $slug == 'wordpress' ) {
                    $severity = '';
                    if ( array_key_exists( 'severity', $data ) ) {
                        $severity = ( array_key_exists( $data['severity'], $sevr ) ? $sevr[$data['severity']] : $data['severity'] );
                    }
                    $vuln_table .= '<tr class="wple-vuln-row">
          <td><b>' . ucfirst( esc_html( $data['label'] ) ) . '</b> <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr( $data['desc'] ) . '"></span></td>
          <td>' . ucfirst( esc_html( $data['type'] ) ) . '</td>
          <td class="' . esc_attr( $severity ) . '">' . ucfirst( esc_html( $severity ) ) . '</td>
          </tr>';
                } else {
                    $severity = '';
                    if ( array_key_exists( 'severity', $data[0] ) ) {
                        $severity = ( array_key_exists( $data[0]['severity'], $sevr ) ? $sevr[$data[0]['severity']] : (( array_key_exists( 'severity', $data ) ? $data['severity'] : '' )) );
                    }
                    $vuln_table .= '<tr class="wple-vuln-row">
        <td><b>' . ucfirst( esc_html( $data[0]['label'] ) ) . '</b> <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr( $data[0]['desc'] ) . '"></span></td>
        <td>' . ucfirst( esc_html( $data[0]['type'] ) ) . '</td>
        <td class="' . esc_attr( $severity ) . '">' . ucfirst( esc_html( $severity ) ) . '</td>
        </tr>';
                }
            }
            $vuln_table .= '</tbody>
      </table>';
            $vuln_table .= '<div class="wple-vuln-pro">Above vulnerablities might exist on your site since many days!. Upgrade to Pro version & be notified as soon as a vulnerability is found in daily scan.</div>';
        }
        $vuln_style = '';
        if ( !get_option( 'wple_vulnerability_scan' ) ) {
            $vuln_style = 'display:none';
        }
        $vulnerabilityexists = ( $threatcount > 0 ? 'wple-vuln-active' : '' );
        $output .= '</ul>

    <div id="wple-vulnerability-scanner" style="' . esc_attr( $vuln_style ) . '">
      <div class="wple-vuln-count">
      <div class="wple-vuln-countinner ' . esc_attr( $vulnerabilityexists ) . '">
        <strong>' . esc_html( $threatcount ) . '</strong><br/>
        <small>Vulnerabilities</small>
      </div>
      </div>
      <div class="wple-vuln-results">
      ' . $vuln_table . '
      <div class="wple-vuln-scan"><a href="' . wp_nonce_url( admin_url( 'admin.php?page=wp_encryption_security' ), 'wple_vulnerability', 'wple_vuln' ) . '"><span class="dashicons dashicons-image-rotate"></span> Scan Now</a></div>     
      </div>
    </div>
    
    </div>
    </div>';
        $html .= $output;
        $html .= '<div class="wple-ssl-score">
    <h2>Security</h2>
    ' . $this->wple_security_settings() . '
    </div>';
        $security_actions = array(array('Rename default database prefix of wp_', 'WordPress database tables use wp_ prefix by default. Rename it to random prefix to further enhance database security.', 'rename_db_prefix'), array('User with username "admin" exists on site', 'Having "admin" user on site is first target for attackers to perform bruteforce / password guessing attacks. Rename username to something else.', 'rename_admin'), array('One of the administrator have same username & display name', 'While having username as display name, Attackers already know your login username and can perform bruteforce / password guessing attacks. Edit profile to change display name different than login username.', 'rename_displayname'));
        $actions_ul = '';
        if ( empty( $security_actions ) ) {
            $actions_ul = '<h3>All good!. No actions required at this moment.</h3>';
        } else {
            $actions_ul .= '<ul>';
            foreach ( $security_actions as $saction ) {
                $actions_ul .= '<li>
        <span>
          <h4>' . esc_html( $saction[0] ) . '</h4>
          <small>' . esc_html( $saction[1] ) . '</small>
        </span>
        <button class="wple-actions" data-action="' . esc_attr( $saction[2] ) . '">Resolve</button>
        </li>';
            }
            $actions_ul .= '</ul>
      <span class="wple-premium-actions">
      <span>
      <p>Monitor important actions required to safeguard your site with WP Encryption Pro.</p>
      <a href="' . admin_url( 'admin.php?page=wp_encryption-pricing' ) . '">Go Pro</a>
      </span>
      </span>';
        }
        $html .= '<div class="wple-ssl-settings wple-actions" data-update="' . wp_create_nonce( 'wplesettingsupdate' ) . '">
      <h2>Actions Needed</h2>
      <div id="wple-sec-actions">
      ' . $actions_ul . '    
      </div>
    </div>';
        $html .= '</div>';
        echo $html;
    }

    public function wple_security_settings() {
        $stored_opts = ( get_option( 'wple_security_settings' ) ? get_option( 'wple_security_settings' ) : array() );
        $opts = array(
            'stop_user_enumeration' => [
                'label' => 'Stop user enumeration',
                'desc'  => 'Prevent exposure of USERNAME on /wp-json/wp/v2/users, /?author=1 & oEmbed requests.',
            ],
            'hide_wp_version'       => [
                'label' => 'Hide WordPress version',
                'desc'  => 'Hackers target exposed vulnerabilities based on WP version. Hide your WordPress version with WP hash.',
            ],
            'disallow_file_edit'    => [
                'label' => 'Disallow File Edit',
                'desc'  => 'Disallow editing of theme, plugin PHP files via wp-admin interface. Built-in file editors are first tool used by attackers if they are able to login.',
            ],
            'anyone_can_register'   => [
                'label' => 'Disable anyone can register option',
                'desc'  => 'Disable user registration on site.',
            ],
            'hide_login_error'      => [
                'label' => 'Hide login error',
                'desc'  => 'WordPress shows whether a username or email is valid on wp-login page. This setting will hide that exposure.',
            ],
            'disable_pingback'      => [
                'label' => 'Disable pingbacks',
                'desc'  => 'Protect against WordPress pingback vulnerability via DDOS attacks.',
            ],
            'remove_feeds'          => [
                'label' => 'Remove RSS & Atom feeds',
                'desc'  => 'RSS & Atom feeds can be used to read your site content and even site scraping. If you are not using feeds to share your site content, you can disable it here.',
            ],
            'deny_php_uploads'      => [
                'label' => 'Deny php execution in uploads directory',
                'desc'  => 'Deny execution of any php files inside wp-content/uploads/ directory which is meant for images & files.',
            ],
        );
        $output = '<form id="wple-security-settings" data-update="' . wp_create_nonce( 'wple_security' ) . '">
    <ul>';
        foreach ( $opts as $key => $item ) {
            $ischecked = '';
            if ( in_array( $key, $stored_opts ) ) {
                $ischecked = 'checked="checked"';
            }
            if ( $key == 'anyone_can_register' && !get_option( 'users_can_register' ) ) {
                $ischecked = 'checked="checked"';
            }
            $output .= '<li>
      <label>' . esc_html( $item['label'] ) . ' <span class="dashicons dashicons-editor-help wple-tooltip" data-tippy="' . esc_attr( $item['desc'] ) . '"></span></label>
      <div class="plan-toggler" style="text-align: left; margin: 40px 0 0px;">
      <label class="toggle">
      <input class="toggle-checkbox" name="' . esc_attr( $key ) . '" type="checkbox" ' . $ischecked . '>
      <div class="toggle-switch disabled0" style="transform: scale(0.6);"></div>      
      </label>
      </div>
      </li>';
        }
        $output .= '</ul>
    </form>';
        return $output;
    }

    /**
     * Update security settings
     *
     * @since 7.0.0
     */
    public function wple_update_security() {
        if ( !current_user_can( 'manage_options' ) || !wp_verify_nonce( $_POST['nc'], 'wple_security' ) ) {
            echo 0;
            exit;
        }
        $save = [];
        $security_class = new WPLE_Security();
        foreach ( $_POST['opt'] as $setting ) {
            $key = sanitize_text_field( $setting['name'] );
            $save[] = $key;
            //one time actions
            if ( $key == 'disallow_file_edit' ) {
                $security_class->wple_disallow_file_edit();
            } else {
                if ( $key == 'anyone_can_register' ) {
                    $security_class->wple_anyone_can_register( false );
                } else {
                    if ( $key == 'deny_php_uploads' ) {
                        $security_class->wple_deny_php_in_uploads( true );
                    }
                }
            }
        }
        //remove of disabled settings
        $prevopts = ( get_option( 'wple_security_settings' ) ? get_option( 'wple_security_settings' ) : array() );
        if ( in_array( 'disallow_file_edit', $prevopts ) && !in_array( 'disallow_file_edit', $save ) ) {
            $security_class->wple_disallow_file_edit( 'false' );
        }
        if ( in_array( 'anyone_can_register', $prevopts ) && !in_array( 'anyone_can_register', $save ) ) {
            $security_class->wple_anyone_can_register( true );
        }
        if ( in_array( 'deny_php_uploads', $prevopts ) && !in_array( 'deny_php_uploads', $save ) ) {
            $security_class->wple_deny_php_in_uploads( false );
        }
        update_option( 'wple_security_settings', $save );
        echo 1;
        exit;
    }

}
