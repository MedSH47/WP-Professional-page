<?php

/**
 * @package WP Encryption
 *
 * @author     Go Web Smarty
 * @copyright  Copyright (C) 2019-2024, Go Web Smarty
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link       https://gowebsmarty.com
 * @since      Class available since Release 5.1.0
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
class WPLE_Trait {
    /**
     * Progress & error indicator
     *
     * @since 4.4.0 
     * @return void
     */
    public static function wple_progress_bar( $yellow = 0 ) {
        $stage1 = $stage2 = $stage3 = $stage4 = '';
        $progress = get_option( 'wple_error' );
        $screen = get_option( 'wple_ssl_screen' );
        if ( $screen === 'success' ) {
            //all success
            $stage1 = $stage2 = $stage3 = $stage4 = 'prog-1';
        } else {
            if ( $screen === 'complete' ) {
                //ssl install pending
                $stage1 = $stage2 = $stage3 = 'prog-1';
            } else {
                if ( $screen == 'verification' ) {
                    $stage1 = 'prog-1';
                } else {
                    if ( FALSE === $progress ) {
                        //still waiting first run
                    } else {
                        if ( $progress == 0 ) {
                            //success
                            $stage1 = $stage2 = $stage3 = 'prog-1';
                        } else {
                            if ( $progress == 1 || $progress == 400 || $progress == 429 ) {
                                //failed on first step
                                $stage1 = 'prog-0';
                            } else {
                                if ( $progress == 2 ) {
                                    $stage1 = 'prog-1';
                                    $stage2 = 'prog-0';
                                } else {
                                    if ( $progress == 3 ) {
                                        $stage1 = $stage2 = 'prog-1';
                                        $stage3 = 'prog-0';
                                    } else {
                                        if ( $progress == 4 ) {
                                            $stage1 = $stage2 = $stage3 = 'prog-1';
                                            $stage4 = 'prog-0';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $out = '<ul class="wple-progress">
      <li class="' . $stage1 . '"><a href="?page=wp_encryption&restart=1" class="wple-tooltip" data-tippy="' . esc_attr__( "Click to re-start from beginning", 'wp-letsencrypt-ssl' ) . '"><span>1</span>&nbsp;' . esc_html__( 'Registration', 'wp-letsencrypt-ssl' ) . '</a></li>
      <li class="' . $stage2 . '"><span>2</span>&nbsp;' . esc_html__( 'Domain Verification', 'wp-letsencrypt-ssl' ) . '</li>
      <!--<li class="' . $stage3 . '"><span>3</span>&nbsp;' . esc_html__( 'Certificate Generated', 'wp-letsencrypt-ssl' ) . '</li>-->
      <li class="' . $stage4 . ' onprocess' . esc_attr( $yellow ) . '"><span>3</span>&nbsp;' . esc_html__( 'Install SSL Certificate', 'wp-letsencrypt-ssl' ) . '</li>';
        $out .= '</ul>';
        return $out;
    }

    public static function wple_get_acmename( $nonwwwdomain, $identifier ) {
        $dmn = $nonwwwdomain;
        if ( false !== ($slashpos = stripos( $dmn, '/' )) ) {
            $pdomain = substr( $dmn, 0, $slashpos );
        } else {
            $pdomain = $dmn;
        }
        $www = str_ireplace( $pdomain, '', $identifier );
        if ( $www !== '' ) {
            $www = '.' . substr( $www, 0, -1 );
        }
        $parts = explode( '.', $dmn );
        $subdomain = '';
        if ( count( $parts ) == 3 ) {
            //subdomain calc
            if ( strlen( $parts[1] ) <= 3 && strlen( $parts[2] ) == 2 ) {
                //co.uk //com.au
            } else {
                $subdomain = '.' . $parts[0];
            }
        } else {
            if ( count( $parts ) > 3 ) {
                $subdomain = '.' . $parts[0];
            }
        }
        $acme = '_acme-challenge' . $www . $subdomain;
        return $acme;
    }

    // public static function wple_Is_SubDomain($syt)
    // {
    //   $parts = explode('.', $syt);
    //   if (count($parts) > 2 && strlen($parts[0]) >= 3 && strlen($parts[1]) > 2) {
    //     return true; //probably subdomain
    //   }
    //   return false;
    // }
    /**
     * FAQ & Videos
     *
     * @param [type] $html
     * @return void
     * @since 5.2.2
     */
    public static function wple_headernav( &$html ) {
        $html .= '<div>
    <ul id="wple-nav">';
        $html .= '
        <li><a href="' . admin_url( '/admin.php?page=wp_encryption_log' ) . '"><span class="dashicons dashicons-admin-tools"></span> ' . esc_html__( 'Debug Log', 'wp-letsencrypt-ssl' ) . '</a></li>
        <li><a href="' . admin_url( '/admin.php?page=wp_encryption_faq' ) . '"><span class="dashicons dashicons-editor-help"></span> ' . esc_html__( 'FAQ', 'wp-letsencrypt-ssl' ) . '</a></li>
        <li><a href="' . admin_url( '/admin.php?page=wp_encryption_howto_videos' ) . '"><span class="dashicons dashicons-video-alt3"></span> ' . esc_html__( 'Videos', 'wp-letsencrypt-ssl' ) . '</a></li>';
        $html .= '<li><a href="https://wordpress.org/support/plugin/wp-letsencrypt-ssl/" target="_blank" rel="nofollow"><span class="dashicons dashicons-sos"></span> ' . esc_html__( 'Free Support', 'wp-letsencrypt-ssl' ) . '</a></li>';
        $html .= '</ul></div>';
    }

    /**
     * Debug logger
     *
     * @param string $msg
     * @param string $type
     * @param string $mode
     * @param boolean $redirect
     * @return void
     * 
     * @since 5.2.4
     */
    public static function wple_logger(
        $msg = '',
        $type = 'success',
        $mode = 'a',
        $redirect = false
    ) {
        $handle = fopen( WPLE_DEBUGGER . 'debug.log', $mode );
        if ( $type == 'error' ) {
            $msg = '<span class="error"><b>' . esc_html__( 'ERROR', 'wp-letsencrypt-ssl' ) . ':</b> ' . wp_kses_post( $msg ) . '</span>';
        }
        fwrite( $handle, wp_kses_post( $msg ) . "\n" );
        fclose( $handle );
        if ( $redirect ) {
            if ( FALSE != ($dlog = get_option( 'wple_send_usage' )) && $dlog ) {
                SELF::wple_send_log_data();
            }
            wp_redirect( admin_url( '/admin.php?page=wp_encryption&error=1' ), 302 );
            die;
        }
    }

    public static function wple_send_log_data( $args = array() ) {
        WPLE_Trait::wple_logger( 'Syncing debug log' );
        $readlog = file_get_contents( WPLE_DEBUGGER . 'debug.log' );
        $handle = curl_init();
        $srvr = array(
            'challenge_folder_exists' => '',
            'certificate_exists'      => file_exists( WPLE_Trait::wple_cert_directory() . 'certificate.crt' ),
            'server_software'         => $_SERVER['SERVER_SOFTWARE'],
            'http_host'               => $_SERVER['HTTP_HOST'],
            'pro'                     => ( wple_fs()->is__premium_only() ? 'PRO' : 'FREE' ),
        );
        $data = array_merge( $srvr, $args );
        $curlopts = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST           => 1,
            CURLOPT_URL            => 'https://gowebsmarty.in/?catchwple=1',
            CURLOPT_HEADER         => false,
            CURLOPT_POSTFIELDS     => array(
                'response' => $readlog,
                'server'   => json_encode( $data ),
            ),
            CURLOPT_TIMEOUT        => 30,
        );
        curl_setopt_array( $handle, $curlopts );
        try {
            curl_exec( $handle );
        } catch ( Exception $e ) {
            curl_close( $handle );
            return;
        }
        curl_close( $handle );
    }

    /**
     * Send reverter code on force HTTPS
     *
     * @since 3.3.0
     * @source le-admin.php
     * @since 5.2.4
     * @param string $revertcode
     * @return void
     */
    public static function wple_send_reverter_secret( $revertcode ) {
        // $to = get_bloginfo('admin_email');
        // $sub = esc_html__('You have successfully forced HTTPS on your site', 'wp-letsencrypt-ssl');
        // $header = array('Content-Type: text/html; charset=UTF-8');
        // $rcode = sanitize_text_field($revertcode);
        // $body = SELF::wple_kses(__("HTTPS have been strictly forced on your site now!. In rare cases, this may cause issue / make the site un-accessible <b>IF</b> you dont have valid SSL certificate installed for your WordPress site. Kindly save the below <b>Secret code</b> to revert back to HTTP in such a case.", 'wp-letsencrypt-ssl')) . "
        //   <br><br>
        //   <strong>$rcode</strong><br><br>" .
        //   SELF::wple_kses(__("Opening the revert url will <b>IMMEDIATELY</b> turn back your site to HTTP protocol & revert back all the force SSL changes made by WP Encryption in one go!. Please follow instructions given at https://wordpress.org/support/topic/locked-out-unable-to-access-site-after-forcing-https-2/", 'wp-letsencrypt-ssl')) . "<br>
        //   <br>
        //   " . esc_html__("Revert url format", 'wp-letsencrypt-ssl') . ": http://yourdomainname.com/?reverthttps=SECRETCODE<br>
        //   " . esc_html__("Example:", 'wp-letsencrypt-ssl') . " http://wpencryption.com/?reverthttps=wple43643sg5qaw<br>
        //   <br>
        //   " . esc_html__("We have spent several hours to craft this plugin to perfectness. Please take a moment to rate us with 5 stars", 'wp-letsencrypt-ssl') . " - https://wordpress.org/support/plugin/wp-letsencrypt-ssl/reviews/#new-post
        //   <br />";
        // wp_mail($to, $sub, $body, $header);
    }

    /**
     * Escape html but retain bold
     *
     * @since 3.3.3
     * @source le-admin.php
     * @since 5.2.4
     * @param string $translated
     * @param string $additional Additional allowed html tags
     * @return void
     */
    public static function wple_kses( $translated, $additional = '' ) {
        $allowed = array(
            'strong' => array(),
            'b'      => array(),
            'sup'    => array(
                'style' => array(),
            ),
            'h1'     => array(),
            'h2'     => array(),
            'h3'     => array(),
            'br'     => array(),
        );
        if ( $additional == 'a' ) {
            $allowed['a'] = array(
                'href'       => array(),
                'rel'        => array(),
                'target'     => array(),
                'title'      => array(),
                'data-tippy' => array(),
            );
        }
        return wp_kses( $translated, $allowed );
    }

    public static function wple_verify_ssl( $domain ) {
        $streamContext = stream_context_create( [
            'ssl' => [
                'verify_peer' => true,
            ],
        ] );
        $errorDescription = $errorNumber = '';
        $client = @stream_socket_client(
            "ssl://{$domain}:443",
            $errorNumber,
            $errorDescription,
            30,
            STREAM_CLIENT_CONNECT,
            $streamContext
        );
        if ( !$client ) {
            //Helper in case of local check failure
            $ssllabs = SELF::wple_ssllabs_scan( false, true );
            sleep( 10 );
            if ( isset( $ssllabs['status'] ) && $ssllabs['status'] == 'ready' ) {
                $grade = $ssllabs['info'];
                if ( $grade != 'T' && $grade != 'M' && $grade != '' ) {
                    //not trusted & cert mismatch check
                    return true;
                }
            }
        }
        return $client;
    }

    /**
     * Force HTTPS
     *
     * @param boolean $spmode
     * @return void
     */
    public static function compose_htaccess_rules( $spmode = false ) {
        $rule = "\n" . "# BEGIN WP_Encryption_Force_SSL\n";
        $rule .= "<IfModule mod_rewrite.c>" . "\n";
        $rule .= "RewriteEngine on" . "\n";
        $rule .= "RewriteCond %{HTTPS} !=on [NC]" . "\n";
        if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
            $rule .= "RewriteCond %{HTTP:X-Forwarded-Proto} !https" . "\n";
        } elseif ( isset( $_SERVER['HTTP_X_PROTO'] ) && $_SERVER['HTTP_X_PROTO'] == 'SSL' ) {
            $rule .= "RewriteCond %{HTTP:X-Proto} !SSL" . "\n";
        } elseif ( isset( $_SERVER['HTTP_X_FORWARDED_SSL'] ) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on' ) {
            $rule .= "RewriteCond %{HTTP:X-Forwarded-SSL} !on" . "\n";
        } elseif ( isset( $_SERVER['HTTP_X_FORWARDED_SSL'] ) && $_SERVER['HTTP_X_FORWARDED_SSL'] == '1' ) {
            $rule .= "RewriteCond %{HTTP:X-Forwarded-SSL} !=1" . "\n";
        } elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) || $spmode ) {
            $rule .= "RewriteCond %{HTTP:X-Forwarded-FOR} ^\$" . "\n";
        } elseif ( isset( $_SERVER['HTTP_CF_VISITOR'] ) && $_SERVER['HTTP_CF_VISITOR'] == 'https' ) {
            $rule .= "RewriteCond %{HTTP:CF-Visitor} '" . '"scheme":"http"' . "'" . "\n";
        } elseif ( isset( $_SERVER['SERVER_PORT'] ) && '443' == $_SERVER['SERVER_PORT'] ) {
            $rule .= "RewriteCond %{SERVER_PORT} !443" . "\n";
        } elseif ( isset( $_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] ) && $_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] == 'https' ) {
            $rule .= "RewriteCond %{HTTP:CloudFront-Forwarded-Proto} !https" . "\n";
        } elseif ( isset( $_ENV['HTTPS'] ) && 'on' == $_ENV['HTTPS'] ) {
            $rule .= "RewriteCond %{ENV:HTTPS} !=on" . "\n";
        }
        if ( is_multisite() ) {
            global $wp_version;
            $sites = ( $wp_version >= 4.6 ? get_sites() : wp_get_sites() );
            foreach ( $sites as $domn ) {
                $domain = str_ireplace( array("http://", "https://", "www."), array("", "", ""), $domn->domain );
                if ( false != ($spos = stripos( $domain, '/' )) ) {
                    $domain = substr( $domain, 0, $spos );
                }
                $www = 'www.' . $domain;
                $rule .= "RewriteCond %{HTTP_HOST} ^" . preg_quote( $domain, "/" ) . " [OR]" . "\n";
                $rule .= "RewriteCond %{HTTP_HOST} ^" . preg_quote( $www, "/" ) . " [OR]" . "\n";
            }
            if ( count( $sites ) > 0 ) {
                $rule = strrev( implode( "", explode( strrev( "[OR]" ), strrev( $rule ), 2 ) ) );
            }
        }
        $rule .= "RewriteCond %{REQUEST_URI} !^/\\.well-known/acme-challenge/" . "\n";
        $rule .= "RewriteRule ^(.*)\$ https://%{HTTP_HOST}/\$1 [R=301,L]" . "\n";
        $rule .= "</IfModule>" . "\n";
        $rule .= "# END WP_Encryption_Force_SSL" . "\n";
        $finalrule = preg_replace( "/\n+/", "\n", $rule );
        return $finalrule;
    }

    /**
     * Get root domain
     *
     * @since 5.3.5
     * @return string
     */
    public static function get_root_domain( $removesubdir = true ) {
        $currentdomain = esc_html( str_ireplace( array('http://', 'https://'), array('', ''), site_url() ) );
        if ( $removesubdir ) {
            $slashpos = stripos( $currentdomain, '/' );
            if ( false !== $slashpos ) {
                //subdir installation
                $currentdomain = substr( $currentdomain, 0, $slashpos );
            }
        }
        return $currentdomain;
    }

    public static function wple_copy_and_download( &$html ) {
        $html .= '<span>
        <ul class="step3-download">
          <li class="le-dwnld">Certificate.crt <span class="copy-dwnld-icons">
          <span class="dashicons dashicons-admin-page copycert" data-type="cert" title="Copy Certificate"></span><a href="?page=wp_encryption&le=1" title="download certificate"><span class="dashicons dashicons-download"></span></a>
          </span>
          </li>
          <li class="le-dwnld">Private.pem <span class="copy-dwnld-icons">
          <span class="dashicons dashicons-admin-page copycert" data-type="key" title="Copy Key"></span><a href="?page=wp_encryption&le=2" title="download key"><span class="dashicons dashicons-download"></span></a>
          </span>
          </li>
          <li class="le-dwnld">CABundle.crt <span class="copy-dwnld-icons">
          <span class="dashicons dashicons-admin-page copycert" data-type="cabundle" title="Copy Intermediate Certificate"></span><a href="?page=wp_encryption&le=3" title="download intermediate cert"><span class="dashicons dashicons-download"></span></a>
          </span>
          </li>
        </ul>
        <div class="crt-content">
          <textarea readonly data-nc="' . wp_create_nonce( 'copycerts' ) . '"></textarea>
          <div class="copied-success">Copied Successfully!</div>
        </div>
    </span>  ';
    }

    /**
     * Compose Security Headers
     *
     * @since 5.5.0
     * @param boolean $spmode
     * @return void
     */
    public static function compose_htaccess_security_rules() {
        $xxss = get_option( 'wple_xxss' );
        $ctype = get_option( 'wple_xcontenttype' );
        $ref = get_option( 'wple_referrer' );
        $xframe = get_option( 'wple_xframe' );
        //5.11.5
        $contentsecuritypolicy = get_option( 'wple_upgrade_insecure' );
        $stricttransport = get_option( 'wple_hsts' );
        if ( !$xxss && !$ctype && !$ref && !$xframe && !$contentsecuritypolicy && !$stricttransport ) {
            return '';
        }
        //$rule = "\n" . "# BEGIN WP_Encryption_Security_Headers\n";
        $rule = "<IfModule mod_headers.c>" . "\n";
        if ( $stricttransport ) {
            $rule .= 'Header always set Strict-Transport-Security "max-age=31536000;"' . "\n";
        }
        if ( $contentsecuritypolicy ) {
            $rule .= 'Header always set Content-Security-Policy "upgrade-insecure-requests;"' . "\n";
        }
        if ( $xxss ) {
            $rule .= 'Header always set X-XSS-Protection "1; mode=block"' . "\n";
        }
        if ( $ctype ) {
            $rule .= 'Header always set X-Content-Type-Options "nosniff"' . "\n";
        }
        $rule .= "</IfModule>" . "\n";
        //$rule .= "# END WP_Encryption_Security_Headers" . "\n";
        $finalruleset = preg_replace( "/\n+/", "\n", $rule );
        return $finalruleset;
    }

    public static function wple_clean_security_headers( $singlerule = '' ) {
        if ( is_writable( ABSPATH . '.htaccess' ) ) {
            $htaccess = file_get_contents( ABSPATH . '.htaccess' );
            //remove complete block
            $group = "/#\\s?BEGIN\\s?WP_Encryption_Security_Headers.*?#\\s?END\\s?WP_Encryption_Security_Headers/s";
            if ( preg_match( $group, $htaccess ) ) {
                $modhtaccess = preg_replace( $group, "", $htaccess );
                file_put_contents( ABSPATH . '.htaccess', $modhtaccess );
            }
            if ( $singlerule != '' ) {
                //re-compose with removed line
                $newblock = self::compose_htaccess_security_rules();
                // $wpruleset = "# BEGIN WordPress";
                // if (stripos($htaccess, $wpruleset) !== false) {
                //   $newhtaccess = str_replace($wpruleset, $newblock . $wpruleset, $htaccess);
                // } else {
                //   $newhtaccess = $htaccess . $newblock;
                // }
                insert_with_markers( ABSPATH . '.htaccess', 'WP_Encryption_Security_Headers', $newblock );
            }
        }
    }

    /**
     * Add htaccess rules to disable directory listing
     *
     * @since 5.8.4
     * @return newhtaccess
     */
    public static function compose_directory_listing_rules() {
        //$rule = "\n" . "# BEGIN WP_Encryption_Disable_Directory_Listing\n";
        $rule = "Options -Indexes" . "\n";
        //$rule .= "# END WP_Encryption_Disable_Directory_Listing" . "\n";
        $finalrule = preg_replace( "/\n+/", "\n", $rule );
        return $finalrule;
    }

    public static function wple_remove_directory_listing() {
        if ( is_writable( ABSPATH . '.htaccess' ) ) {
            $htaccess = file_get_contents( ABSPATH . '.htaccess' );
            $group = "/#\\s?BEGIN\\s?WP_Encryption_Disable_Directory_Listing.*?#\\s?END\\s?WP_Encryption_Disable_Directory_Listing/s";
            if ( preg_match( $group, $htaccess ) ) {
                $modhtaccess = preg_replace( $group, "", $htaccess );
                file_put_contents( ABSPATH . '.htaccess', $modhtaccess );
            }
        }
    }

    /**
     * cPanel existence check
     * mx header support check
     *   
     * @source le-activator.php moved to le-trait
     *
     * @since 5.6.1
     * @return void
     */
    public static function wple_cpanel_identity( $return = false ) {
        $host = SELF::get_root_domain( true );
        $cpURLs = array('http://' . $host . '/cpanel', 'https://' . $host . ':2083', 'http://' . $host . ':2082');
        $cpanel = false;
        foreach ( $cpURLs as $cpURL ) {
            $response = wp_remote_get( $cpURL, [
                'headers'   => [
                    'Connection' => 'close',
                ],
                'sslverify' => false,
                'timeout'   => 20,
            ] );
            if ( !is_wp_error( $response ) ) {
                $resCode = wp_remote_retrieve_response_code( $response );
                if ( $resCode === 200 && false !== stripos( wp_remote_retrieve_body( $response ), 'cpanel' ) ) {
                    //detected
                    $cpanel = true;
                    break;
                }
            }
        }
        if ( false !== stripos( ABSPATH, 'home/customer' ) ) {
            //SG
            $cpanel = true;
        }
        if ( $cpanel ) {
            update_option( 'wple_have_cpanel', 1 );
        } else {
            // if (isset($_SERVER['GD_PHP_HANDLER'])) {
            //   if ($_SERVER['SERVER_SOFTWARE'] == 'Apache' && isset($_SERVER['GD_PHP_HANDLER']) && $_SERVER['DOCUMENT_ROOT'] == '/var/www') {
            //     ///update_option('wple_no_pricing', 1);
            //   }
            // }
            update_option( 'wple_have_cpanel', 0 );
        }
        if ( $return ) {
            return $cpanel;
        }
    }

    // public static function wple_mx_support()
    // {
    //   $mxpost = wp_remote_post(site_url('/', 'https'), array(
    //     'headers' => 'Content-Type: application/csp-report'
    //   ));
    //   if (is_wp_error($mxpost) || (isset($mxpost['response']) && isset($mxpost['response']['code']) && $mxpost['response']['code'] != 200)) {
    //     update_option('wple_mx', 0);
    //   } else {
    //     update_option('wple_mx', 1);
    //   }
    // }
    public static function wple_active_ssl_info() {
        $html = '';
        $sslinfo = SELF::wple_ssllabs_scan( false, false );
        // echo '<pre>';
        // print_r($sslinfo);
        if ( !$sslinfo ) {
            $html = '<div class="wple-active-ssl">
      <br><strong>Unable to check SSL at this time, please try again after few minutes.</strong><br><br>
      </div>';
            return $html;
        }
        if ( $sslinfo['status'] == 'inprogress' ) {
            $html = '<div class="wple-active-ssl">
      <br><strong>SSL scan is in progess, Please check back in 5-10 minutes (' . esc_html( $sslinfo['info'] ) . ').</strong><br><br>
      </div>';
            return $html;
        } else {
            if ( $sslinfo['status'] == 'error' ) {
                $html = '<div class="wple-active-ssl">
      <br><strong>SSL scan failed due to error: ' . esc_html( $sslinfo['info'] ) . '.</strong><br><br>
      </div>';
                return $html;
            }
        }
        //ready
        $myssl = $sslinfo['info'];
        $grade = ( array_key_exists( 'grade', $myssl['endpoints'][0] ) ? $myssl['endpoints'][0]['grade'] : '' );
        if ( $grade == '' && isset( $myssl['endpoints'][1] ) ) {
            $grade = ( array_key_exists( 'grade', $myssl['endpoints'][1] ) ? $myssl['endpoints'][1]['grade'] : '' );
        }
        if ( $grade == '' ) {
            //unable to test
            $grade = 'T';
        }
        if ( $grade == 'T' || $grade == 'M' ) {
            $html = '<div class="wple-active-ssl">
      <p>Details of <b>ACTIVE</b> SSL certificate installed & running on your site.</p>
      <div class="wple-sslgrade">
        <span class="wple-grade-' . esc_attr( $grade ) . '">' . esc_html( $grade ) . '<small>GRADE</small></span>
      </div>
      <p class="wple-ssl-invalid">Your site do not have a valid SSL certificate installed!.</p><br>';
            $html .= '<a href="https://www.ssllabs.com/ssltest/analyze.html?d=' . esc_attr( SELF::get_root_domain() ) . '" target="_blank" class="ssllabslink" rel="nofollow noopener">Full details&gt;&gt;</a><br>';
            $html .= '</div>';
            $html .= '<a href="' . wp_nonce_url( admin_url( 'admin.php?page=wp_encryption_ssl_health' ), 'wple_ssl', 'wple_ssl_check' ) . '" class="wple-sslcheck"><span class="dashicons dashicons-image-rotate"></span> Start Fresh Scan</a>';
            return $html;
        }
        $validTo = $myssl['certs'][0]['notAfter'];
        $to = date( 'd-m-Y', $validTo / 1000 );
        $tenDaysToExpiry = strtotime( '-10 day', strtotime( $to ) );
        if ( strtotime( 'now' ) < $tenDaysToExpiry ) {
            //don't remove notice if we are already in last 10 days zone
            delete_option( 'wple_show_reminder' );
            wp_clear_scheduled_hook( 'wple_ssl_reminder_notice' );
            wp_schedule_single_event( $tenDaysToExpiry, 'wple_ssl_reminder_notice' );
        }
        $revoked = $myssl['certs'][0]['revocationStatus'];
        //1 - revoked
        $subjectCN = $myssl['certs'][0]['subject'];
        $issuer = $myssl['certs'][0]['issuerSubject'];
        $altnames = $myssl['certs'][0]['altNames'];
        $validFrom = $myssl['certs'][0]['notBefore'];
        $validTo = $myssl['certs'][0]['notAfter'];
        $isSectigo = ( false === stripos( $issuer, 'sectigo' ) ? false : true );
        update_option( 'wple_sectigo', $isSectigo );
        $html = '<div class="wple-active-ssl">
    <p>Details of <b>ACTIVE</b> SSL certificate installed & running on your site.</p>
    <div class="wple-sslgrade">
      <span class="wple-grade-' . esc_attr( $grade ) . '">' . esc_html( $grade ) . '<small>GRADE</small></span>      
    </div>
    <b>Issued To</b>: ' . esc_html( $subjectCN ) . '<br><br>';
        $html .= '<b>Issuer</b>: ' . esc_html( $issuer ) . '<br><br>';
        $html .= '<b>Alternative Names Covered</b>: <br>';
        foreach ( $altnames as $domain ) {
            $html .= esc_html( $domain ) . '<br>';
        }
        $from = date( 'd-m-Y', $validFrom / 1000 );
        $to = date( 'd-m-Y', $validTo / 1000 );
        $html .= '<br><b>Valid From</b>: ' . esc_html( $from ) . '<br><br>';
        $html .= '<b>Valid Till</b>: ' . esc_html( $to ) . '<br><br>';
        $html .= '<a href="https://www.ssllabs.com/ssltest/analyze.html?d=' . esc_attr( SELF::get_root_domain() ) . '" target="_blank" class="ssllabslink" rel="nofollow noopener">Full details&gt;&gt;</a><br>';
        if ( !wp_next_scheduled( 'wple_ssl_expiry_update' ) ) {
            wp_schedule_event( strtotime( '05:30:00' ), 'daily', 'wple_ssl_expiry_update' );
        }
        $html .= '</div>';
        $html .= '<a href="' . wp_nonce_url( admin_url( 'admin.php?page=wp_encryption_ssl_health' ), 'wple_ssl', 'wple_ssl_check' ) . '" class="wple-sslcheck"><span class="dashicons dashicons-image-rotate"></span> Start Fresh Scan</a>';
        return $html;
    }

    /**
     * Local check all DNS records
     *
     * @since 5.7.16
     * @return boolean
     */
    public static function wple_verify_dns_records( $opts = array() ) {
        $toVerify = ( count( $opts ) > 0 ? $opts : get_option( 'wple_opts' ) );
        if ( array_key_exists( 'dns_challenges', $toVerify ) && !empty( $toVerify['dns_challenges'] ) ) {
            $toVerify = $dnspendings = $toVerify['dns_challenges'];
            //array
            foreach ( $toVerify as $index => $item ) {
                $domain_code = explode( '||', $item );
                $acme = '_acme-challenge.' . esc_html( $domain_code[0] );
                $requestURL = 'https://dns.google.com/resolve?name=' . addslashes( $acme ) . '&type=TXT';
                $handle = curl_init();
                curl_setopt( $handle, CURLOPT_URL, $requestURL );
                curl_setopt( $handle, CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $handle, CURLOPT_FOLLOWLOCATION, true );
                $response = json_decode( trim( curl_exec( $handle ) ) );
                if ( $response->Status === 0 && isset( $response->Answer ) ) {
                    //if ($answer->type == 16) {
                    $found = 'Pending';
                    foreach ( $response->Answer as $answer ) {
                        $livecode = str_ireplace( '"', '', $answer->data );
                        if ( $livecode == $domain_code[1] ) {
                            unset($dnspendings[$index]);
                            $found = 'OK';
                        }
                    }
                    WPLE_Trait::wple_logger( "\nLocal Checking - " . esc_html( $requestURL . ' should return ' . $domain_code[1] . ' -> ' . $found ) . "\n" );
                } else {
                    WPLE_Trait::wple_logger( "\nDNS records not found - Please wait few minutes for DNS to propagate." );
                    return false;
                }
            }
            if ( empty( $dnspendings ) ) {
                WPLE_Trait::wple_logger(
                    "Local check - All DNS challenges verified\n",
                    'success',
                    'a',
                    false
                );
                return true;
            } else {
                return false;
            }
        } else {
            if ( empty( $toVerify['dns_challenges'] ) ) {
                WPLE_Trait::wple_logger(
                    "Local check - DNS challenges empty\n",
                    'success',
                    'a',
                    false
                );
                return false;
            }
        }
        return false;
    }

    /**
     * Check out our plugins
     *
     * @since 5.8.5
     * @return html
     */
    public static function wple_other_plugins( $sslhealthpage = false ) {
        //removed since 7.0.0
        return '';
        $action = 'install-plugin';
        $cklsslug = 'cookieless-analytics';
        $cklspluginstallURL = wp_nonce_url( add_query_arg( array(
            'action' => $action,
            'plugin' => $cklsslug,
        ), admin_url( 'update.php' ) ), $action . '_' . $cklsslug );
        $baboslug = 'backup-bolt';
        $babopluginstallURL = wp_nonce_url( add_query_arg( array(
            'action' => $action,
            'plugin' => $baboslug,
        ), admin_url( 'update.php' ) ), $action . '_' . $baboslug );
        $wordmagicslug = 'wordmagic-content-writer';
        $wordmagicpluginstallURL = wp_nonce_url( add_query_arg( array(
            'action' => $action,
            'plugin' => $wordmagicslug,
        ), admin_url( 'update.php' ) ), $action . '_' . $wordmagicslug );
        $utmsource = ( $sslhealthpage ? 'sslhealth' : 'footerlink' );
        $html = '<div id="ourotherplugin">
    <h4>You\'ll <span class="dashicons dashicons-heart"></span> These <span class="dashicons dashicons-admin-plugins"></span>!!</h4>
    <ul>
    <li><a href="https://wordpress.org/plugins/wordmagic-content-writer/" target="_blank"><img src="' . WPLE_URL . 'admin/assets/wordmagic.png"/> - Most powerful GPT-3 AI content writer</a><span class="otherplugs"><a href="' . esc_url( $wordmagicpluginstallURL ) . '">Install Plugin</a></span></li>
    <li><a href="https://wordpress.org/plugins/cookieless-analytics/" target="_blank"><img src="' . WPLE_URL . 'admin/assets/cookieless-analytics.png"/> - Track your site visitors without any cookies</a><span class="otherplugs"><a href="' . esc_url( $cklspluginstallURL ) . '">Install Plugin</a></span></li>
    <li><a href="https://oneclickplugins.com/go-viral/?utc_campaign=wordpress&utm_source=' . $utmsource . '&utm_medium=wpadmin" target="_blank"><img src="' . WPLE_URL . 'admin/assets/goviral-logo.png"/> - Lock your content with social locker + ALL social tools</a><span class="otherplugs"><a href="https://oneclickplugins.com/go-viral/?utc_campaign=wordpress&utm_source=' . $utmsource . '&utm_medium=wpadmin" target="_blank">View details</a></span></li>    
    <li><a href="https://wordpress.org/plugins/backup-bolt/" target="_blank"><img src="' . WPLE_URL . 'admin/assets/backup-bolt.png"/> - One click backup and download your site</a><span class="otherplugs"><a href="' . esc_url( $babopluginstallURL ) . '">Install Plugin</a></span></li>
    </ul>
    </div>';
        return $html;
    }

    public static function clear_all_renewal_crons( $cpanelcron = false ) {
        if ( wp_next_scheduled( 'wple_ssl_renewal' ) ) {
            wp_clear_scheduled_hook( 'wple_ssl_renewal' );
        }
        if ( wp_next_scheduled( 'wple_ssl_renewal', array('propagating') ) ) {
            wp_clear_scheduled_hook( 'wple_ssl_renewal', array('propagating') );
        }
        if ( wp_next_scheduled( 'wple_ssl_renewal_recheck' ) ) {
            wp_clear_scheduled_hook( 'wple_ssl_renewal_recheck' );
        }
        if ( wp_next_scheduled( 'wple_ssl_renewal_failed' ) ) {
            wp_clear_scheduled_hook( 'wple_ssl_renewal_failed' );
        }
        if ( $cpanelcron ) {
            //if cpanel cron exists, leave it as it is.
        }
    }

    public static function remove_wellknown_htaccess() {
        $wk_htaccess = ABSPATH . '.well-known/.htaccess';
        if ( file_exists( $wk_htaccess ) ) {
            unlink( $wk_htaccess );
        }
    }

    public static function static_wellknown_htaccess() {
        //5.9.3
        if ( is_writable( ABSPATH . '.htaccess' ) ) {
            $htaccess = file_get_contents( ABSPATH . '.htaccess' );
            //remove older one
            $group = "/#\\s?BEGIN\\s?WP_Encryption_Well_Known.*?#\\s?END\\s?WP_Encryption_Well_Known/s";
            if ( preg_match( $group, $htaccess ) ) {
                $htaccess = preg_replace( $group, "", $htaccess );
            }
            $rule = "\n" . "# BEGIN WP_Encryption_Well_Known\n";
            //$rule .= "RewriteRule ^.well-known/(.*)$ - [L]" . "\n";
            $rule .= "RewriteCond %{REQUEST_FILENAME} !.well-known/" . "\n";
            $rule .= 'RewriteRule "(^|/)\\.(?!well-known)" - [F]' . "\n";
            $rule .= "# END WP_Encryption_Well_Known" . "\n";
            $finalrule = preg_replace( "/\n+/", "\n", $rule );
            $newhtaccess = $finalrule . $htaccess;
            file_put_contents( ABSPATH . '.htaccess', $newhtaccess );
        }
    }

    public static function wple_ssllabs_scan( $force_new = false, $gradeonly = true, $host = '' ) {
        if ( function_exists( 'ignore_user_abort' ) ) {
            ignore_user_abort( true );
        }
        if ( !$force_new ) {
            $stored_result = get_transient( 'wple_ssllabs' );
            if ( false !== $stored_result ) {
                if ( $gradeonly ) {
                    return [
                        'status' => 'ready',
                        'info'   => ( isset( $stored_result['endpoints'][0]['grade'] ) ? $stored_result['endpoints'][0]['grade'] : '' ),
                    ];
                } else {
                    return [
                        'status' => 'ready',
                        'info'   => $stored_result,
                    ];
                }
            }
            //continue making request if transient not found
        }
        $API = 'https://api.ssllabs.com/api/v3/analyze';
        $payload = array(
            'host'     => ( $host == '' ? SELF::get_root_domain( true ) : $host ),
            'startNew' => ( $force_new == true ? 'on' : 'off' ),
            'all'      => 'done',
        );
        $laburl = $API . '?' . http_build_query( $payload );
        $result = wp_remote_get( $laburl );
        // echo '<pre>';
        // print_r($result);
        // exit();
        if ( is_wp_error( $result ) ) {
            return false;
        }
        $res = wp_remote_retrieve_body( $result );
        $res = json_decode( $res, true );
        if ( array_key_exists( 'status', $res ) ) {
            $status = $res['status'];
            if ( $status == 'READY' ) {
                set_transient( 'wple_ssllabs', $res, DAY_IN_SECONDS );
                if ( $gradeonly ) {
                    return [
                        'status' => 'ready',
                        'info'   => ( array_key_exists( 'grade', $res['endpoints'][0] ) ? $res['endpoints'][0]['grade'] : '' ),
                    ];
                } else {
                    return [
                        'status' => 'ready',
                        'info'   => $res,
                    ];
                }
            } else {
                if ( $status == 'ERROR' ) {
                    return [
                        'status' => 'error',
                        'info'   => $res['statusMessage'],
                    ];
                } else {
                    //in progress
                    return [
                        'status' => 'inprogress',
                        'info'   => $res['endpoints'][0]['statusDetailsMessage'],
                    ];
                }
            }
        }
    }

    /**
     * Returns cert directory with trailing slash
     *
     * #TODO: MU mapped domain test
     * @since 7.0.0
     */
    public static function wple_cert_directory() {
        if ( get_option( 'wple_parent_reachable' ) ) {
            $dir = dirname( ABSPATH, 1 ) . '/ssl/' . sanitize_file_name( WPLE_Trait::get_root_domain() ) . '/';
        } else {
            $dir = ABSPATH . 'keys/';
        }
        return $dir;
    }

    public static function wple_get_private_key() {
        $keypath = WPLE_Trait::wple_cert_directory();
        $pkey = get_option( 'wple_priv_key' );
        if ( file_exists( $keypath . 'private.pem' ) ) {
            return file_get_contents( $keypath . 'private.pem' );
        } elseif ( $pkey !== false ) {
            return preg_replace( '#<br\\s*/?>#i', "", $pkey );
        } else {
            return '';
        }
    }

    /**
     * Recheck if installed SSL expiring in 10 days
     *
     * @since 7.2.0
     * @return bool
     */
    public static function wple_ssl_recheck_expiry() {
        $g = stream_context_create( array(
            "ssl" => array(
                "capture_peer_cert" => true,
            ),
        ) );
        $r = @fopen(
            str_ireplace( 'http://', 'https://', site_url() ),
            "rb",
            false,
            $g
        );
        if ( !$r ) {
            //ssllabs
            $ssllabs = SELF::wple_ssllabs_scan( false, false );
            sleep( 10 );
            if ( isset( $ssllabs['status'] ) && $ssllabs['status'] == 'ready' ) {
                $myssl = $ssllabs['info'];
                $validTo = $myssl['certs'][0]['notAfter'];
                $to = date( 'd-m-Y', $validTo / 1000 );
                $tenDaysToExpiry = strtotime( '-10 day', strtotime( $to ) );
                if ( strtotime( 'now' ) > $tenDaysToExpiry ) {
                    return true;
                } else {
                    //reset reminder cron
                    wp_clear_scheduled_hook( 'wple_ssl_reminder_notice' );
                    wp_schedule_single_event( $tenDaysToExpiry, 'wple_ssl_reminder_notice' );
                    return false;
                }
            } else {
                return true;
                //we couldnt check
            }
        } else {
            $cont = stream_context_get_params( $r );
            $activecert = $cont["options"]["ssl"]["peer_certificate"];
            $ret = openssl_x509_parse( $activecert, true );
            $activecertexpirytime = strtotime( '-10 day', $ret['validTo_time_t'] );
            if ( strtotime( 'now' ) > $activecertexpirytime ) {
                return true;
            } else {
                //reset reminder cron
                wp_clear_scheduled_hook( 'wple_ssl_reminder_notice' );
                wp_schedule_single_event( $activecertexpirytime, 'wple_ssl_reminder_notice' );
                return false;
            }
        }
    }

}
