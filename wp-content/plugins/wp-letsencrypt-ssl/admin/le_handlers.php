<?php

require_once WPLE_DIR . 'classes/le-core.php';
/**
 * Todo:
 * A file to disable force https completely when site lockout
 */
class WPLE_Handler {
    public function __construct() {
        add_action( 'admin_init', [$this, 'admin_init_handlers'], 1 );
    }

    public function admin_init_handlers() {
        $this->wple_auto_handler();
        $this->primary_ssl_install_request();
        $this->force_https_upon_success();
        $this->wple_download_files();
        $this->wple_intro_pricing_handler();
        $this->wple_vulnerabilities_update();
        $this->wple_ssllabs_new_scan();
    }

    public function wple_auto_handler() {
        if ( isset( $_GET['wpleauto'] ) ) {
            if ( get_option( 'wple_order_refreshed' ) ) {
                delete_option( 'wple_order_refreshed' );
            }
            $leopts = get_option( 'wple_opts' );
            new WPLE_Core($leopts);
            //continue verification
        }
    }

    private function primary_ssl_install_request() {
        //single domain ssl
        if ( isset( $_POST['generate-certs'] ) ) {
            if ( !wp_verify_nonce( $_POST['letsencrypt'], 'legenerate' ) || !current_user_can( 'manage_options' ) ) {
                die( 'Unauthorized request' );
            }
            if ( empty( $_POST['wple_email'] ) ) {
                wp_die( esc_html__( 'Please input valid email address', 'wp-letsencrypt-ssl' ) );
            }
            ///delete_option('wple_sourceip_enable');
            $leopts = array(
                'email'           => sanitize_email( $_POST['wple_email'] ),
                'date'            => date( 'd-m-Y' ),
                'expiry'          => '',
                'type'            => 'single',
                'send_usage'      => ( isset( $_POST['wple_send_usage'] ) ? 1 : 0 ),
                'include_www'     => ( isset( $_POST['wple_include_www'] ) ? 1 : 0 ),
                'include_mail'    => ( isset( $_POST['wple_include_mail'] ) ? 1 : 0 ),
                'include_webmail' => ( isset( $_POST['wple_include_webmail'] ) ? 1 : 0 ),
                'agree_gws_tos'   => ( isset( $_POST['wple_agree_gws_tos'] ) ? 1 : 0 ),
                'agree_le_tos'    => ( isset( $_POST['wple_agree_le_tos'] ) ? 1 : 0 ),
            );
            if ( isset( $_POST['wple_domain'] ) && !is_multisite() ) {
                $leopts['subdir'] = 1;
                //flag domain as primary domain of subdir site
                $leopts['domain'] = sanitize_text_field( $_POST['wple_domain'] );
            }
            update_option( 'wple_opts', $leopts );
            WPLE_Trait::wple_cpanel_identity();
            new WPLE_Core($leopts);
        }
    }

    private function force_https_upon_success() {
        //since 2.4.0
        //force https upon success
        if ( isset( $_POST['wple-https'] ) ) {
            if ( !wp_verify_nonce( $_POST['sslready'], 'wplehttps' ) || !current_user_can( 'manage_options' ) ) {
                exit( 'Unauthorized access' );
            }
            $basedomain = str_ireplace( array('http://', 'https://'), array('', ''), addslashes( site_url() ) );
            //4.7
            if ( false !== stripos( $basedomain, '/' ) ) {
                $basedomain = substr( $basedomain, 0, stripos( $basedomain, '/' ) );
            }
            $client = WPLE_Trait::wple_verify_ssl( $basedomain );
            if ( !$client && !is_ssl() ) {
                wp_redirect( admin_url( '/admin.php?page=wp_encryption&success=1&nossl=1', 'http' ) );
                exit;
            }
            // $SSLCheck = @fsockopen("ssl://" . $basedomain, 443, $errno, $errstr, 30);
            // if (!$SSLCheck) {
            //   wp_redirect(admin_url('/admin.php?page=wp_encryption&success=1&nossl=1', 'http'));
            //   exit();
            // }
            ///$reverter = uniqid('wple');
            $savedopts = get_option( 'wple_opts' );
            $savedopts['force_ssl'] = 1;
            ///$savedopts['revertnonce'] = $reverter;
            ///WPLE_Trait::wple_send_reverter_secret($reverter);
            update_option( 'wple_opts', $savedopts );
            delete_option( 'wple_error' );
            //complete
            update_option( 'wple_ssl_screen', 'success' );
            update_option( 'siteurl', str_ireplace( 'http:', 'https:', get_option( 'siteurl' ) ) );
            update_option( 'home', str_ireplace( 'http:', 'https:', get_option( 'home' ) ) );
            wp_redirect( admin_url( '/admin.php?page=wp_encryption', 'https' ) );
            exit;
        }
    }

    /**
     * Download cert files based on clicked link
     *
     * certs for multisite mapped domains cannot be downloaded yet
     * @since 1.0.0
     * @return void
     */
    public function wple_download_files() {
        if ( isset( $_GET['le'] ) && current_user_can( 'manage_options' ) ) {
            switch ( $_GET['le'] ) {
                case '1':
                    $file = uniqid() . '-cert.crt';
                    file_put_contents( $file, file_get_contents( WPLE_Trait::wple_cert_directory() . 'certificate.crt' ) );
                    break;
                case '2':
                    $file = uniqid() . '-key.pem';
                    file_put_contents( $file, WPLE_Trait::wple_get_private_key() );
                    break;
                case '3':
                    $file = uniqid() . '-cabundle.crt';
                    // if (file_exists(ABSPATH . 'keys/cabundle.crt')) {
                    $cabundlefile = file_get_contents( WPLE_Trait::wple_cert_directory() . 'cabundle.crt' );
                    // } else {
                    ///$cabundlefile = file_get_contents(WPLE_DIR . 'cabundle/ca.crt');
                    //}
                    file_put_contents( $file, $cabundlefile );
                    break;
            }
            header( 'Content-Description: File Transfer' );
            header( 'Content-Type: text/plain' );
            header( 'Content-Length: ' . filesize( $file ) );
            header( 'Content-Disposition: attachment; filename=' . basename( $file ) );
            readfile( $file );
            if ( file_exists( $file ) ) {
                unlink( $file );
            }
            exit;
        }
    }

    /**
     * Intro pricing table handler
     * 
     * @since 5.0.0     
     * @return void
     */
    public function wple_intro_pricing_handler() {
        $goplan = '';
        if ( isset( $_GET['gofree'] ) ) {
            update_option( 'wple_plan_choose', 1 );
            wp_redirect( admin_url( '/admin.php?page=wp_encryption' ), 302 );
            exit;
        } else {
            if ( isset( $_GET['gopro'] ) ) {
                update_option( 'wple_plan_choose', 1 );
                if ( $_GET['gopro'] == 2 ) {
                    //unlimited
                    wp_redirect( admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=annual&pricing_id=10873&currency=usd' ), 302 );
                } else {
                    if ( $_GET['gopro'] == 3 ) {
                        //annual
                        wp_redirect( admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=annual&pricing_id=7965&currency=usd' ), 302 );
                    } else {
                        //single lifetime
                        wp_redirect( admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=lifetime&pricing_id=7965&currency=usd' ), 302 );
                    }
                }
                exit;
            } else {
                if ( isset( $_GET['gofirewall'] ) ) {
                    update_option( 'wple_plan_choose', 1 );
                    ///wp_redirect(admin_url('/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=11394&plan_name=pro&billing_cycle=annual&pricing_id=11717&currency=usd'), 302);
                    wp_redirect( admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=8210&plan_name=pro&billing_cycle=annual&pricing_id=7965&currency=usd' ), 302 );
                    exit;
                } else {
                    if ( isset( $_GET['gositelock'] ) ) {
                        update_option( 'wple_plan_choose', 1 );
                        ///wp_redirect(admin_url('/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=11394&plan_name=pro&billing_cycle=annual&pricing_id=11717&currency=usd'), 302);
                        wp_redirect( admin_url( '/admin.php?page=wp_encryption-pricing&checkout=true&plan_id=20784&plan_name=sitelock&billing_cycle=annual&currency=usd' ), 302 );
                        exit;
                    }
                }
            }
        }
    }

    private function wple_vulnerabilities_update() {
        if ( isset( $_GET['wple_vuln'] ) ) {
            if ( !wp_verify_nonce( $_GET['wple_vuln'], 'wple_vulnerability' ) || !current_user_can( 'manage_options' ) ) {
                exit( 'Authorization Failure' );
            }
            $this->wple_run_vulnerability_scan();
        }
    }

    public function wple_run_vulnerability_scan() {
        if ( function_exists( 'ignore_user_abort' ) ) {
            ignore_user_abort( true );
        }
        global $wp_version;
        $wordpress_core = $wp_version;
        $wordpress_themes = wp_get_themes();
        $wordpress_plugins = get_plugins();
        $threats = array();
        //core scan
        $url = 'https://www.wpvulnerability.net/core/' . $wordpress_core;
        $res = wp_remote_get( $url );
        if ( !is_wp_error( $res ) ) {
            $result = json_decode( wp_remote_retrieve_body( $res ), true );
            if ( is_array( $result['data']['vulnerability'] ) && !empty( $result['data']['vulnerability'] ) ) {
                $threats['wordpress'] = array(
                    'type'     => 'core',
                    'label'    => 'WordPress - ' . sanitize_text_field( $result['data']['vulnerability'][0]['source'][0]['name'] ),
                    'desc'     => sanitize_text_field( $result['data']['vulnerability'][0]['source'][0]['description'] ),
                    'severity' => ( !empty( $result['data']['vulnerability'][0]['impact'] ) ? sanitize_text_field( $result['data']['vulnerability'][0]['impact']['cvss']['severity'] ) : 'unknown' ),
                );
            }
        }
        //}
        //themes
        foreach ( $wordpress_themes as $themeslug => $data ) {
            $url = 'https://www.wpvulnerability.net/theme/' . $themeslug;
            $res = wp_remote_get( $url );
            if ( !is_wp_error( $res ) ) {
                $result = json_decode( wp_remote_retrieve_body( $res ), true );
                if ( is_array( $result['data']['vulnerability'] ) && !empty( $result['data']['vulnerability'] ) ) {
                    $vuln = $result['data']['vulnerability'];
                    foreach ( $vuln as $vul ) {
                        $operator = $vul['operator'];
                        $themever = $data['Version'];
                        if ( version_compare( $themever, $operator['max_version'], $operator['max_operator'] ) ) {
                            $threats[$themeslug][] = array(
                                'type'      => 'theme',
                                'myver'     => sanitize_text_field( $themever ),
                                'label'     => sanitize_text_field( $vul['name'] ),
                                'desc'      => sanitize_textarea_field( $vul['source'][0]['description'] ),
                                'severity'  => ( !empty( $vul['impact'] ) ? sanitize_text_field( $vul['impact']['cvss']['severity'] ) : 'unknown' ),
                                'reference' => esc_url( $vul['source'][0]['link'] ),
                            );
                        }
                    }
                }
            }
        }
        //plugins
        foreach ( $wordpress_plugins as $pluginslug => $data ) {
            $main_slug = substr( $pluginslug, 0, stripos( $pluginslug, '/' ) );
            $url = 'https://www.wpvulnerability.net/plugin/' . $main_slug;
            $res = wp_remote_get( $url );
            if ( !is_wp_error( $res ) ) {
                $result = json_decode( wp_remote_retrieve_body( $res ), true );
                if ( is_array( $result['data']['vulnerability'] ) && !empty( $result['data']['vulnerability'] ) ) {
                    $vuln = $result['data']['vulnerability'];
                    foreach ( $vuln as $vul ) {
                        $operator = $vul['operator'];
                        $pluginver = $data['Version'];
                        if ( version_compare( $pluginver, $operator['max_version'], $operator['max_operator'] ) ) {
                            $threats[$main_slug][] = array(
                                'type'      => 'plugin',
                                'myver'     => sanitize_text_field( $pluginver ),
                                'label'     => sanitize_text_field( $vul['name'] ),
                                'desc'      => sanitize_textarea_field( $vul['source'][0]['description'] ),
                                'severity'  => ( !empty( $vul['impact'] ) ? sanitize_text_field( $vul['impact']['cvss']['severity'] ) : 'unknown' ),
                                'reference' => esc_url( $vul['source'][0]['link'] ),
                            );
                        }
                    }
                }
            }
        }
        set_transient( 'wple_vulnerability_scan', $threats, 0 );
    }

    /**
     * Start new vulnerability scan
     * 
     * @since 6.3.2
     * @return void
     */
    private function wple_ssllabs_new_scan() {
        if ( isset( $_GET['wple_ssl_check'] ) ) {
            if ( !wp_verify_nonce( $_GET['wple_ssl_check'], 'wple_ssl' ) || !current_user_can( 'manage_options' ) ) {
                wp_die( 'Unauthorized request!' );
                exit;
            }
            delete_transient( 'wple_ssllabs' );
            WPLE_Trait::wple_ssllabs_scan( true );
        }
    }

    private function wple_send_vuln_notification_email( $threats ) {
        $high = $critical = $total = 0;
        if ( is_array( $threats ) && count( $threats ) > 0 ) {
            $sevr = array(
                'c'       => 'critical',
                'h'       => 'high',
                'm'       => 'medium',
                'l'       => 'low',
                'unknown' => 'unknown',
            );
            foreach ( $threats as $slug => $data ) {
                $severity = ( array_key_exists( $data['severity'], $sevr ) ? $sevr[$data['severity']] : $data['severity'] );
                if ( $severity == 'high' ) {
                    $total++;
                } else {
                    if ( $severity == 'critical' ) {
                        $total++;
                    }
                }
            }
            if ( $total > 0 ) {
                $to = get_option( 'admin_email' );
                $subject = sprintf( esc_html__( 'ALERT - Vulnerabilities found on %s', 'wp-letsencrypt-ssl' ), str_ireplace( array('https://', 'http://'), array('', ''), site_url() ) );
                $headers = array('Content-Type: text/html; charset=UTF-8');
                $body = '<div style="text-align:center">
        <h2><strong>' . intval( $total ) . '</strong> HIGH-CRITICAL Risk vulnerabilities have been found in your recent vulnerability scan.</h2>
        <p>Please login to your wp-admin, navigate to <strong>SSL Health & Security</strong> page of WP Encryption to view the details. If the developer of affected plugin, theme, core have released have a security patch, please update immediately to fix the vulnerability.</p>
        </div><br />        
        <i>This is an auto generated email notification from WP Encryption Pro WordPress plugin based on your preferences.</i>';
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
    }

}
