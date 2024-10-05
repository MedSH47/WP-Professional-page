<?php

/**
 * @package WP Encryption
 *
 * @author     Go Web Smarty
 * @copyright  Copyright (C) 2019-2024, Go Web Smarty. All Rights Reserved.
 * @link       https://gowebsmarty.com
 * @since      Class available since Release 5.1.7
 *
 */
require_once WPLE_DIR . 'classes/le-advanced-scanner.php';

/**
 * Mixed content scanner
 *
 * @since 5.1.7
 */
class WPLE_Scanner
{

  public function __construct()
  {
    add_action('wp_ajax_wple_start_scanner', [$this, 'wple_cspro']);
  }

  public function wple_cspro()
  {

    if (!wp_verify_nonce($_POST['nc'], 'wplemixedscanner') || !current_user_can('manage_options')) {
      http_response_code(403);
      exit('Unauthorized');
    }

    $basedomain = esc_html(str_ireplace(array('http://', 'https://'), array('', ''), site_url()));

    $client = WPLE_Trait::wple_verify_ssl($basedomain);

    if (!$client) {
      echo 'nossl';
      exit();
    }

    // $matches = [];
    // if (preg_match('/([\w\/]*)/i', $_POST['scanpath'], $matches)) {
    //   $scanurl = trailingslashit(site_url()) . $matches[0];
    new WPLE_DeepScanner();
    exit();
    // } else {
    //   echo 'invalid';
    //   exit();
    // }
  }
}
