<?php

/**
 * @package WP Encryption
 *
 * @author     Go Web Smarty
 * @copyright  Copyright (C) 2019-2024, Go Web Smarty
 * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3
 * @link       https://gowebsmarty.com
 * @since      Class available since Release 1.1.0
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
 * WPLE_ForceSSL
 * 
 * Forces all resources to https on frontend
 * @since 1.1.0
 */
class WPLE_ForceSSL
{

  public function __construct()
  {
    if (defined('WPLE_DISABLE_HTTPS')) {
      return;
    }

    $opts = get_option('wple_opts');
    $opts = (FALSE === $opts) ? array() : $opts;

    add_action('wp', array($this, 'wple_revert_force_https'));

    if (isset($opts['force_ssl']) && $opts['force_ssl'] == 1) {

      if (!is_admin()) {
        add_action('wp_loaded', array($this, 'wple_force_ssl'), 20);
      }

      add_action("init", array($this, 'wple_start_buff'));
      add_action("shutdown", array($this, 'wple_end_buff'), 999);
    } else if (!is_admin() && FALSE !== get_option('wple_mixed_content_fixer')) { //frontend only

      add_action("init", array($this, 'wple_start_buff'));
      add_action("shutdown", array($this, 'wple_end_buff'), 999);
    }
  }

  public function wple_force_ssl()
  {
    $this->wple_revert_force_https();
    add_action('wp', array($this, 'wple_ssl_redirect'), 40, 3);
    add_action('wp_print_scripts', array($this, 'wple_forcessl_js'));
  }

  public function wple_forcessl_js()
  {
    $script = '<script>';
    $script .= 'if (document.location.protocol != "https:") {';
    $script .= 'document.location = document.URL.replace(/^http:/i, "https:");';
    $script .= '}';
    $script .= '</script>';

    echo $script;
  }

  public function wple_ssl_redirect()
  {
    if (!is_ssl()) {
      $redirect_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
      wp_redirect($redirect_url, 301);
      exit;
    }
  }

  public function wple_start_buff()
  {
    ob_start(array($this, 'wple_buffer_https'));
  }

  public function wple_end_buff()
  {
    if (ob_get_length()) ob_end_flush();
  }

  public function wple_buffer_https($buffer)
  {
    if (substr($buffer, 0, 5) == "<?xml") return $buffer;

    $home = str_replace("https://", "http://", get_option('home'));

    $eschome = str_replace("/", "\/", $home);

    $src = array(
      $eschome,
      "src='http://",
      'src="http://',
    );

    $ssl_array = str_replace(array("http://", "http:\/\/"), array("https://", "https:\/\/"), $src);

    $buffer = str_replace($src, $ssl_array, $buffer);

    $pattern = array(
      '/url\([\'"]?\K(http:\/\/)(?=[^)]+)/i',
      '/<link [^>]*?href=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
      '/<meta property="og:image" [^>]*?content=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
      '/<form [^>]*?action=[\'"]\K(http:\/\/)(?=[^\'"]+)/i',
    );

    $buffer = preg_replace($pattern, 'https://', $buffer);

    $buffer = preg_replace_callback('/<img[^\>]*[^\>\S]+srcset=[\'"]\K((?:[^"\'\s,]+\s*(?:\s+\d+[wx])(?:,\s*)?)+)["\']/', array($this, 'wple_replace_srcset'), $buffer);

    return $buffer;
  }

  public function wple_replace_srcset($matches)
  {
    return str_replace("http://", "https://", $matches[0]);
  }


  /**
   * Revert to http using secret nonce
   *
   * @since 3.3.0
   * @return void
   */
  public function wple_revert_force_https()
  {
    $opts = get_option('wple_opts');
    $revertnonce = isset($opts['revertnonce']) ? $opts['revertnonce'] : false;
    if (isset($_GET['reverthttps']) && $revertnonce != FALSE && $_GET['reverthttps'] == $revertnonce) {
      $opts['force_ssl'] = 0;
      update_option('wple_opts', $opts);

      global $wpdb;
      $data = array(
        'option_value' => esc_url_raw(str_ireplace('https:', 'http:', get_option('siteurl')))
      );
      $where = array(
        'option_name' => 'siteurl'
      );
      $wpdb->update($wpdb->prefix . 'options', $data, $where);

      $data = array(
        'option_value' => esc_url_raw(str_ireplace('https:', 'http:', get_option('home')))
      );
      $where = array(
        'option_name' => 'home'
      );
      $wpdb->update($wpdb->prefix . 'options', $data, $where);

      exit(esc_html__('Reverted back to HTTP. Access your site now with http:// protocol.', 'wp-letsencrypt-ssl'));
    }
  }
}
