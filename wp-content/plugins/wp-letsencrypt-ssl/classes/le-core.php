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
require_once plugin_dir_path(__DIR__) . 'vendor/autoload.php';
/**
 * require all the lib files for generating certs
 */

use WPLEClient\LEFunctions;
use WPLEClient\LEConnector;
use WPLEClient\LEAccount;
use WPLEClient\LEAuthorization;
use WPLEClient\LEClient;
use WPLEClient\LEOrder;

require_once WPLE_DIR . 'classes/le-trait.php';
/**
 * WPLE_Core class
 * Responsible for handling account registration, certificate generation & install certs on cPanel
 * 
 * @since 1.0.0  
 */
class WPLE_Core
{
    protected $email;

    protected $date;

    protected $basedomain;

    public $domains;

    protected $mdomain = false;

    protected $rootdomain;

    protected $client;

    protected $order;

    protected $pendings;

    protected $wcard = false;

    protected $dnss = false;

    protected $iscron = false;

    protected $noscriptresponse = false;

    protected $disablespmode = false;

    /**
     * construct all params & proceed with cert generation
     *
     * @since 1.0.0
     * @param array $opts
     * @param boolean $gen
     */
    public function __construct(
        $opts = array(),
        $gen = true,
        $wc = false,
        $cron = false
    ) {
        if ($cron) {
            $this->iscron = true;
        }
        if (!empty($opts)) {
            $this->email = sanitize_email($opts['email']);
            $this->date = $opts['date'];
            $optss = $opts;
        } else {
            $optss = get_option('wple_opts');
            $this->email = (isset($optss['email']) ? sanitize_email($optss['email']) : '');
            $this->date = (isset($optss['date']) ? $optss['date'] : '');
        }
        $siteurl = site_url();
        if (isset($optss['subdir'])) {
            $siteurl = sanitize_text_field($optss['domain']);
        }
        $this->rootdomain = str_ireplace(array('http://', 'https://', 'www.'), array('', '', ''), $siteurl);
        $this->basedomain = str_ireplace(array('http://', 'https://'), array('', ''), $siteurl);
        $this->domains = array($this->basedomain);
        //include both www & non-www
        if (isset($optss['include_www']) && $optss['include_www'] == 1) {
            $this->basedomain = $this->rootdomain;
            $this->domains = array($this->rootdomain, 'www.' . $this->rootdomain);
        }
        /** v5.4.8 */
        if (isset($optss['include_mail']) && $optss['include_mail'] == 1) {
            $this->domains[] = 'mail.' . $this->rootdomain;
        }
        if (isset($optss['include_webmail']) && $optss['include_webmail'] == 1) {
            $this->domains[] = 'webmail.' . $this->rootdomain;
        }
        if (get_option('wple_disable_spmode') == true) {
            $this->disablespmode = true;
        }
        if ($gen) {
            $this->wple_generate_verify_ssl();
        }
    }

    /**
     * group all different steps into one function & clear debug.log intially.
     *
     * @since 1.0.0
     * @return void
     */
    public function wple_generate_verify_ssl()
    {
        $cpanel = (int) get_option('wple_have_cpanel');
        //since 4.7
        if (!isset($_GET['wpleauto'])) {
            update_option('wple_http_valid', 0);
            if (isset($_POST['wple_send_usage'])) {
                update_option('wple_send_usage', 1);
            } else {
                update_option('wple_send_usage', 0);
            }
            $storage = 'WEB';
            /**
             * Set certificate storage path
             * Re-check permission each time
             * @since 7.1.0
             */
            $keys_above_root = dirname(ABSPATH, 1) . '/ssl/' . sanitize_file_name(WPLE_Trait::get_root_domain());
            if (file_exists($keys_above_root) && is_writable($keys_above_root)) {
                //already created
                $storage = 'ROOT';
                update_option('wple_parent_reachable', true);
            } else {
                if (@mkdir($keys_above_root, 0755, true)) {
                    //directory creation success
                    $testfile = $keys_above_root . '/testfile';
                    @file_put_contents($testfile, 'test123');
                    if (file_exists($testfile) && file_get_contents($testfile) == 'test123') {
                        //file creation possible
                        unlink($testfile);
                        update_option('wple_parent_reachable', true);
                        $storage = 'ROOT';
                    } else {
                        //file creation not possible
                        update_option('wple_parent_reachable', false);
                    }
                } else {
                    update_option('wple_parent_reachable', false);
                }
            }
            $PRO = (wple_fs()->can_use_premium_code__premium_only() ? 'PRO' : '');
            $PRO .= ($this->wcard ? ' WILDCARD SSL ' : ' SINGLE DOMAIN SSL ');
            if (isset($_SERVER['GD_PHP_HANDLER'])) {
                $PRO .= 'GD ';
            }
            if (false !== stripos(ABSPATH, 'home/customer')) {
                $PRO .= 'SG ';
            }
            $PRO .= $cpanel;
            $this->wple_log('<b>' . WPLE_PLUGIN_VER . ' ' . $PRO . ' - ' . esc_html(site_url()) . ' - ' . esc_html($storage) . '</b>', 'success', 'w');
            $this->wple_log("Domain covered:\n" . json_encode($this->domains) . "\n");
        }
        //since v6.6
        if (!function_exists('curl_init')) {
            $this->wple_log(
                "PHP Curl is required & not enabled on your server. Please enable PHP Curl before proceeding.",
                'error',
                'a',
                true
            );
        }
        update_option('wple_stage', 'starting_client');
        $this->wple_create_client();
        update_option('wple_stage', 'generating_order');
        $this->wple_generate_order();
        update_option('wple_stage', 'starting_verification');
        $starthttpverify = $startdnsverify = false;
        if (isset($_GET['wpleauto'])) {
            if ($_GET['wpleauto'] == 'http') {
                $starthttpverify = true;
                $this->wple_log('Starting HTTP verification');
            } else {
                $startdnsverify = true;
                $this->wple_log('Starting DNS verification');
            }
        }
        $this->wple_verify_free_order($starthttpverify, $startdnsverify);
        $this->wple_generate_certs();
        if (FALSE != ($dlog = get_option('wple_send_usage')) && $dlog) {
            $this->wple_send_usage_data();
        }
    }

    /**
     * create ACMEv2 client
     *
     * @since 1.0.0
     * @return void
     */
    protected function wple_create_client()
    {
        try {
            $keydir = WPLE_Trait::wple_cert_directory();
            $sourceIP = get_option('wple_sourceip');
            //since 7.1 restore account key from option
            $acckey_path = $keydir . '__account/private.pem';
            if (!file_exists($acckey_path)) {
                $acckey = (get_option('wple_acc_key') ? get_option('wple_acc_key') : '');
                file_put_contents($acckey_path, preg_replace('#<br\\s*/?>#i', "", $acckey));
            }
            $this->client = new LEClient(
                $this->email,
                LEClient::LE_PRODUCTION,
                LEClient::LOG_STATUS,
                $keydir,
                '__account/',
                $sourceIP
            );
        } catch (Exception $e) {
            update_option('wple_error', 1);
            $mode = ($this->iscron ? 'a' : 'w');
            $this->wple_log(
                "VERSION " . WPLE_PLUGIN_VER . "\n\nCREATE_CLIENT:" . $e,
                'error',
                $mode,
                true
            );
        }
        ///echo '<pre>'; print_r( $client->getAccount() ); echo '</pre>';
    }

    /**
     * Generate order with ACMEv2 client for given domain
     *
     * @since 1.0.0
     * @return void
     */
    protected function wple_generate_order()
    {
        try {
            $this->order = $this->client->getOrCreateOrder($this->basedomain, $this->domains);
        } catch (Exception $e) {
            update_option('wple_error', 1);
            $mode = ($this->iscron ? 'a' : 'w');
            $this->wple_log(
                "VERSION " . WPLE_PLUGIN_VER . "\n\nCREATE_ORDER:" . $e,
                'error',
                $mode,
                true
            );
        }
    }

    /**
     * Get all pendings orders which need domain verification
     *
     * @since 1.0.0
     * @return void
     */
    protected function wple_get_pendings($dns = false)
    {
        $chtype = LEOrder::CHALLENGE_TYPE_HTTP;
        $http = 1;
        if ($dns) {
            $chtype = LEOrder::CHALLENGE_TYPE_DNS;
            $http = 0;
        }
        try {
            $this->pendings = $this->order->getPendingAuthorizations($chtype);
            if (!empty($this->pendings) && $http == 1) {
                $opts = get_option('wple_opts');
                $opts['challenge_files'] = array();
                foreach ($this->pendings as $chlng) {
                    $opts['challenge_files'][] = array(
                        'file'  => sanitize_text_field(trim($chlng['filename'])),
                        'value' => sanitize_text_field(trim($chlng['content'])),
                    );
                }
                update_option('wple_opts', $opts);
            }
        } catch (Exception $e) {
            $this->wple_log(
                'GET_PENDING_AUTHS:' . $e,
                'error',
                'w',
                true
            );
        }
    }

    /**
     * Finalize and get certificates
     *
     * @since 1.0.0
     * @return void
     */
    public function wple_generate_certs()
    {
        if ($this->order->allAuthorizationsValid()) {
            update_option('wple_stage', 'generated_certificate');
            // Finalize the order
            if (!$this->order->isFinalized()) {
                $this->wple_log(esc_html__('Finalizing the order', 'wp-letsencrypt-ssl'), 'success', 'a');
                $this->order->finalizeOrder();
            }
            // get the certificate.
            if ($this->order->isFinalized()) {
                $this->wple_log(esc_html__('Getting SSL certificates', 'wp-letsencrypt-ssl'), 'success', 'a');
                $this->order->getCertificate();
            }
            delete_option('wple_hold_cron');
            $cert = WPLE_Trait::wple_cert_directory() . 'certificate.crt';
            if (file_exists($cert)) {
                $this->wple_save_expiry_date();
                do_action('cert_expiry_updated');
                //important
            }
            //since 5.3.5
            //$this->wple_email_cert_files();
            $this->wple_send_success_mail();
            update_option('wple_ssl_screen', 'complete');
            $sslgenerated = "<h2>" . esc_html__('SSL Certificate generated successfully', 'wp-letsencrypt-ssl') . "!</h2>";
            $this->wple_log($sslgenerated, 'success', 'a');
            if (FALSE != ($dlog = get_option('wple_send_usage')) && $dlog) {
                $this->wple_send_usage_data();
            }
            /**
             * Case: Couldn't store above web root dir
             * Delete private key and store in option
             * Delete account key and store in option
             * @since 7.0.0
             */
            if (!get_option('wple_parent_reachable')) {
                $priv_key = WPLE_Trait::wple_cert_directory() . 'private.pem';
                $acc_key = WPLE_Trait::wple_cert_directory() . '__account/private.pem';
                if (file_exists($priv_key)) {
                    $priv_key_content = sanitize_textarea_field(file_get_contents($priv_key));
                    $priv_key_content = nl2br($priv_key_content);
                    update_option('wple_priv_key', $priv_key_content);
                    unlink($priv_key);
                    $acc_key_content = sanitize_textarea_field(file_get_contents($acc_key));
                    $acc_key_content = nl2br($acc_key_content);
                    update_option('wple_acc_key', $acc_key_content);
                    unlink($acc_key);
                    $this->wple_log("Stored private key as option");
                }
            }
            wp_redirect(admin_url('/admin.php?page=wp_encryption'), 302);
            exit;
        } else {
            update_option('wple_error', 2);
            // if (get_option('wple_http_valid')) { //rare case
            //   $this->wple_log('Looks like HTTP file verification is not possible on your server. Please complete DNS based verification.');
            //   wp_redirect(admin_url('/admin.php?page=wp_encryption&subdir=1&error=1'), 302);
            //   exit();
            // } else {
            if (method_exists($this->order, 'updateOrderData') && !wple_fs()->is_premium()) {
                $this->order->updateOrderData();
                if ($this->order->status == 'invalid') {
                    update_option('wple_order_refreshed', true);
                    $this->wple_log("Order failed due to failed verification or other reasons. Getting new challenges from new order.\n");
                    $this->wple_create_client();
                    $this->wple_generate_order();
                    $this->wple_verify_free_order();
                }
            }
            $this->wple_log(
                '<h2>' . esc_html__('There are some pending verifications. Please try again with DNS challenges.', 'wp-letsencrypt-ssl') . '</h2>',
                'success',
                'a',
                false
            );
            $this->wple_save_all_challenges();
            //re-update pending challenges
            if (!empty($this->pendings)) {
                $this->wple_log(json_encode($this->pendings));
            }
            $this->wple_log(
                '',
                'success',
                'a',
                true
            );
            //}
        }
    }

    /**
     * Save expiry date of cert dynamically by parsing the cert
     *
     * @since 1.0.0
     * @return void
     */
    public function wple_save_expiry_date()
    {
        $certfile = WPLE_Trait::wple_cert_directory() . 'certificate.crt';
        //TODO: expiry saved separately on each mapped site?
        if (file_exists($certfile)) {
            $opts = get_option('wple_opts');
            $opts['expiry'] = '';
            try {
                $this->wple_getRemainingDays($certfile, $opts);
            } catch (Exception $e) {
                update_option('wple_opts', $opts);
            }
        }
    }

    /**
     * Utility functions
     * 
     * @since 1.0.0 
     */
    public function wple_parseCertificate($cert_pem)
    {
        // if (false === ($ret = openssl_x509_read(file_get_contents($cert_pem)))) {
        //   throw new Exception('Could not load certificate: ' . $cert_pem . ' (' . $this->get_openssl_error() . ')');
        // }
        if (!is_array($ret = openssl_x509_parse(file_get_contents($cert_pem), true))) {
            throw new Exception('Could not parse certificate');
        }
        return $ret;
    }

    public function wple_getRemainingDays($cert_pem, $opts)
    {
        $ret = $this->wple_parseCertificate($cert_pem);
        $expiry = date('d-m-Y', $ret['validTo_time_t']);
        $opts['expiry'] = $expiry;
        update_option('wple_opts', $opts);
        update_option('wple_show_review', 1);
    }

    public function wple_log(
        $msg = '',
        $type = 'success',
        $mode = 'a',
        $redirect = false
    ) {
        $handle = fopen(WPLE_DEBUGGER . 'debug.log', $mode);
        if ($type == 'error') {
            $msg = '<span class="error"><b>' . esc_html__('ERROR', 'wp-letsencrypt-ssl') . ':</b> ' . wp_kses_post($msg) . '</span>';
        }
        fwrite($handle, wp_kses_post($msg) . "\n");
        fclose($handle);
        if ($redirect) {
            if (FALSE != ($dlog = get_option('wple_send_usage')) && $dlog) {
                $this->wple_send_usage_data();
            }
            wp_redirect(admin_url('/admin.php?page=wp_encryption&error=1'), 302);
            die;
        }
    }

    /**
     * Collect usage data to improve plugin
     *
     * @since 2.1.0
     * @return void
     */
    public function wple_send_usage_data()
    {
        WPLE_Trait::wple_logger('Syncing debug log');
        $readlog = file_get_contents(WPLE_DEBUGGER . 'debug.log');
        $handle = curl_init();
        $srvr = array(
            'challenge_folder_exists' => '',
            'certificate_exists'      => file_exists(WPLE_Trait::wple_cert_directory() . 'certificate.crt'),
            'server_software'         => $_SERVER['SERVER_SOFTWARE'],
            'http_host'               => site_url(),
            'pro'                     => (wple_fs()->is__premium_only() ? 'PRO' : 'FREE'),
        );
        $curlopts = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST           => 1,
            CURLOPT_URL            => 'https://gowebsmarty.in/?catchwple=1',
            CURLOPT_HEADER         => false,
            CURLOPT_POSTFIELDS     => array(
                'response' => $readlog,
                'server'   => json_encode($srvr),
            ),
            CURLOPT_TIMEOUT        => 30,
        );
        curl_setopt_array($handle, $curlopts);
        try {
            curl_exec($handle);
        } catch (Exception $e) {
            curl_close($handle);
            return;
        }
        curl_close($handle);
    }

    /**
     * Retrieve file content
     *
     * @since 3.2.0
     * @param string $acmefile
     * @return void
     */
    private function wple_get_file_response($acmefile)
    {
        $args = array(
            'sslverify' => false,
        );
        $remoteget = wp_remote_get($acmefile, $args);
        if (is_wp_error($remoteget)) {
            $rsponse = 'error';
        } else {
            $rsponse = trim(wp_remote_retrieve_body($remoteget));
        }
        return $rsponse;
    }

    /**
     * Save HTTP + DNS challenges for later use
     *
     * @since 4.6.0
     * @return void
     */
    private function wple_save_all_challenges($dnsonly = false)
    {
        $opts = (FALSE === get_option('wple_opts') ? array() : get_option('wple_opts'));
        //DNS
        $chtype = LEOrder::CHALLENGE_TYPE_DNS;
        try {
            $dns_challenges = $this->order->getPendingAuthorizations($chtype);
            if (!empty($dns_challenges)) {
                $opts['dns_challenges'] = array();
                foreach ($dns_challenges as $challenge) {
                    if ($challenge['type'] == 'dns-01' && stripos($challenge['identifier'], $this->rootdomain) !== false) {
                        $identifier = $challenge['identifier'];
                        $opts['dns_challenges'][] = sanitize_text_field($identifier) . '||' . sanitize_text_field($challenge['DNSDigest']);
                    }
                }
            }
        } catch (Exception $e) {
            $this->wple_log(
                'Unable to store DNS challenges:' . $e,
                'error',
                'w',
                true
            );
        }
        if ($opts['type'] != 'wildcard') {
            //HTTP
            $chtype = LEOrder::CHALLENGE_TYPE_HTTP;
            try {
                $httppendings = $this->order->getPendingAuthorizations($chtype);
                if (!empty($httppendings)) {
                    $opts['challenge_files'] = array();
                    foreach ($httppendings as $chlng) {
                        $opts['challenge_files'][] = array(
                            'file'  => sanitize_text_field(trim($chlng['filename'])),
                            'value' => sanitize_text_field(trim($chlng['content'])),
                        );
                    }
                }
            } catch (Exception $e) {
                $this->wple_log(
                    'Unable to store HTTP challenges:' . $e,
                    'error',
                    'w',
                    true
                );
            }
        }
        update_option('wple_opts', $opts);
    }

    protected function wple_goto_manual_challenges()
    {
        $this->wple_save_all_challenges();
        wp_redirect(admin_url('/admin.php?page=wp_encryption&subdir=1'), 302);
        exit;
    }

    /**
     * simple debug log message
     *
     * @since 5.2.6
     * @return void
     */
    private function wple_nocpanel_notice()
    {
        update_option('wple_ssl_screen', 'nocpanel');
        WPLE_Trait::wple_logger("Awaiting SSL installation for Non-cPanel site and SSL validation\n", "success");
        WPLE_Trait::wple_send_log_data();
        do_action('cert_expiry_updated');
        wp_redirect(admin_url('/admin.php?page=wp_encryption&nocpanel=1'), 302);
        exit;
    }

    /**
     * Send email to user on success
     * 
     * @since 3.0.0
     * @moved from le-admin.php on 5.7.2
     */
    private function wple_send_success_mail()
    {
        $opts = get_option('wple_opts');
        $to = sanitize_email($opts['email']);
        $subject = sprintf(esc_html__('Congratulations! Your SSL certificates for %s generated using WP Encryption Plugin', 'wp-letsencrypt-ssl'), WPLE_Trait::get_root_domain());
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $body = '<h3>' . esc_html__('You are just ONE step away from enabling HTTPS for your WordPress site', 'wp-letsencrypt-ssl') . '</h3>';
        $body .= '<p>' . esc_html__('Download the generated SSL certificates from below given links and install it on your cPanel following the video tutorial', 'wp-letsencrypt-ssl') . ' (https://youtu.be/KQ2HYtplPEk). ' . esc_html__('These certificates expires on', 'wp-letsencrypt-ssl') . ' <b>' . esc_html($opts['expiry']) . '</b></p>
        <br/>
        <a href="' . admin_url('/admin.php?page=wp_encryption&le=1', 'http') . '" style="background: #0073aa; text-decoration: none; color: #fff; padding: 12px 20px; display: inline-block; margin: 10px 10px 10px 0; font-weight: bold;">' . esc_html__('Download Cert File', 'wp-letsencrypt-ssl') . '</a>
      <a href="' . admin_url('/admin.php?page=wp_encryption&le=2', 'http') . '" style="background: #0073aa; text-decoration: none; color: #fff; padding: 12px 20px; display: inline-block; margin: 10px; font-weight: bold;">' . esc_html__('Download Key File', 'wp-letsencrypt-ssl') . '</a>
      <a href="' . admin_url('/admin.php?page=wp_encryption&le=3', 'http') . '" style="background: #0073aa; text-decoration: none; color: #fff; padding: 12px 20px; display: inline-block; margin: 10px; font-weight: bold;">' . esc_html__('Download CA File', 'wp-letsencrypt-ssl') . '</a>
      <br/>';
        ///if (FALSE == get_option('wple_no_pricing')) {
        $body .= '<br /><br />';
        $body .= '<b>' . esc_html__('WP Encryption PRO can automate this entire process in one click including SSL installation on cPanel hosting and auto renewal of certificates every 90 days', 'wp-letsencrypt-ssl') . '!. <br><a href="' . admin_url('/admin.php?page=wp_encryption-pricing', 'http') . '" style="background: #0073aa; text-decoration: none; color: #fff; padding: 12px 20px; display: inline-block; margin: 10px 0; font-weight: bold;">' . esc_html__('UPGRADE TO PREMIUM', 'wp-letsencrypt-ssl') . '</a></b><br /><br />';
        $body .= "<h3>" . esc_html__("Don't have cPanel hosting?", 'wp-letsencrypt-ssl') . "</h3>";
        $body .= '<p>We don\'t wanna disappoint you!. Opt for our <a href="' . admin_url('/admin.php?page=wp_encryption-pricing', 'http') . '"><strong>Annual Pro plan</strong><a> and setup SSL for your site hosted on ANY hosting platform including Managed WordPress platforms.' . WPLE_Trait::wple_kses(__('With free version, You can download and send these SSL certificates to your hosting support asking them to install these SSL certificates.', 'wp-letsencrypt-ssl')) . '</p><br /><br />';
        ///}
        if (get_option('wple_email_certs') == true) {
            $certificate = WPLE_Trait::wple_cert_directory() . 'certificate.crt';
            if (class_exists('ZipArchive')) {
                if (file_exists($certificate)) {
                    $this->wple_log('Emailing certs as attachment');
                    $zip = new ZipArchive();
                    $zip->open(WPLE_Trait::wple_cert_directory() . 'certificates.zip', ZipArchive::CREATE);
                    $zip->addFile($certificate, 'certificate.crt');
                    $ret = $this->wple_parseCertificate($certificate);
                    $certexpirydate = date('d-m-Y', $ret['validTo_time_t']);
                    $pemfile = WPLE_Trait::wple_cert_directory() . 'private.pem';
                    $zip->addFile($pemfile, 'private.pem');
                    ///$cabundle = WPLE_DIR . 'cabundle/ca.crt';
                    // if (file_exists(ABSPATH . 'keys/cabundle.crt')) {
                    $cabundle = WPLE_Trait::wple_cert_directory() . 'cabundle.crt';
                    // }
                    $zip->addFile($cabundle, 'cabundle.crt');
                    $zip->close();
                    $body .= '<p>' . esc_html__('Confidential: New SSL cert files have been attached to this email as per your preferences.', 'wp-letsencrypt-ssl') . ' ' . esc_html__('These certificates expires on', 'wp-letsencrypt-ssl') . ' <b>' . esc_html($certexpirydate) . '</b></p>';
                    if (function_exists('wp_mail')) {
                        wp_mail(
                            $to,
                            $subject,
                            $body,
                            $headers,
                            array(WPLE_Trait::wple_cert_directory() . 'certificates.zip')
                        );
                    }
                    unlink(WPLE_Trait::wple_cert_directory() . 'certificates.zip');
                } else {
                    $this->wple_log('Emailing certs skipped as certificate.crt not found.');
                    if (function_exists('wp_mail')) {
                        wp_mail(
                            $to,
                            $subject,
                            $body,
                            $headers
                        );
                    }
                }
            }
        } else {
            if (function_exists('wp_mail')) {
                wp_mail(
                    $to,
                    $subject,
                    $body,
                    $headers
                );
            }
        }
    }

    /**
     * Test if http verification is possible on this server
     *
     * @since 5.9.0
     * @return void
     */
    // public function wple_verify_if_http_possible($domain)
    // {
    //   if (!wple_fs()->is__premium_only()) {
    //     $fpath = ABSPATH . '.well-known/acme-challenge/';
    //     if (!file_exists($fpath)) {
    //       mkdir($fpath, 0775, true);
    //     }
    //     $testfile = $fpath . 'testfile';
    //     if (!file_exists($testfile)) {
    //       file_put_contents($testfile, 'testcontent');
    //     }
    //     $testURL = 'http://' . $domain . '/.well-known/acme-challenge/testfile';
    //     $result = $this->wple_get_file_response($testURL);
    //     if ($result != 'testcontent') {
    //       $this->wple_log($result . ' acme-challenge directory is blocked on this server.');
    //       update_option('wple_http_valid', 1);
    //     }
    //   }
    // }
    public function wple_verify_free_order($starthttpverification = false, $startdnsverification = false)
    {
        if (!$this->order->allAuthorizationsValid()) {
            if (!$starthttpverification && !$startdnsverification) {
                $this->wple_save_all_challenges();
                ///$this->wple_log("HTTP Challenges --> " . json_encode($updated['challenge_files']), 'success', 'a');
                ///$this->wple_log("DNS Challenges --> " . json_encode($updated['dns_challenges']), 'success', 'a');
                $this->wple_log(esc_html__("Offering manual verification procedure.", 'wp-letsencrypt-ssl') . " \n", 'success', 'a');
                if (FALSE != ($dlog = get_option('wple_send_usage')) && $dlog) {
                    $this->wple_send_usage_data();
                }
                update_option('wple_ssl_screen', 'verification');
                wp_redirect(admin_url('/admin.php?page=wp_encryption&subdir=1'), 302);
                exit;
            } else {
                //?wpleauto
                if ($starthttpverification) {
                    WPLE_Trait::static_wellknown_htaccess();
                    $this->wple_get_pendings();
                    //get http challenges
                }
                if ($startdnsverification) {
                    $this->wple_get_pendings(true);
                    //get dns challenges
                }
                if (!empty($this->pendings)) {
                    foreach ($this->pendings as $challenge) {
                        if ($challenge['type'] == 'dns-01' && stripos($challenge['identifier'], $this->rootdomain) !== false) {
                            $this->order->verifyPendingOrderAuthorization($challenge['identifier'], LEOrder::CHALLENGE_TYPE_DNS, false);
                        } else {
                            if ($challenge['type'] == 'http-01' && stripos($challenge['identifier'], $this->rootdomain) !== false) {
                                $acmefile = "http://" . $challenge['identifier'] . "/.well-known/acme-challenge/" . $challenge['filename'];
                                $rsponse = $this->wple_get_file_response($acmefile);
                                if ($rsponse !== trim($challenge['content'])) {
                                    WPLE_Trait::remove_wellknown_htaccess();
                                    ///WPLE_Trait::static_wellknown_htaccess();
                                    //re-try again
                                    $rsponse = $this->wple_get_file_response($acmefile);
                                    //ultimate failure
                                    if ($rsponse !== trim($challenge['content'])) {
                                        update_option('wple_error', 2);
                                    }
                                }
                                $this->order->verifyPendingOrderAuthorization($challenge['identifier'], LEOrder::CHALLENGE_TYPE_HTTP, false);
                            }
                        }
                    }
                } else {
                    $this->wple_log(esc_html__("No pending challenges. Proceeding..", 'wp-letsencrypt-ssl') . " \n", 'success', 'a');
                }
            }
        }
    }
}
