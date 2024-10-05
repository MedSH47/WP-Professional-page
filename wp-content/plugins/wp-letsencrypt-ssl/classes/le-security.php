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
 * WPLE_Security Class
 * Handles all the security actions
 * 
 * @since 7.0.0
 */
class WPLE_Security
{
  private $enabledSettings;

  public function __construct()
  {
    $this->enabledSettings = get_option('wple_security_settings') ? get_option('wple_security_settings') : array();

    add_action('init', [$this, 'wple_security_inits']);
  }

  public function wple_security_inits()
  {
    if (in_array('hide_wp_version', $this->enabledSettings)) {
      $this->wple_remove_wp_versions();
    }

    if (in_array('stop_user_enumeration', $this->enabledSettings)) {
      $this->wple_stop_user_enumeration();
    }

    if (in_array('hide_login_error', $this->enabledSettings)) {
      add_filter('wp_login_errors', [$this, 'wple_hide_login_error']);
    }

    if (in_array('disable_pingback', $this->enabledSettings)) {
      add_filter('xmlrpc_methods', array($this, 'wple_disable_pingback_methods'));
      add_filter('wp_headers', array($this, 'wple_disable_pingback_header'));
    }

    if (in_array('remove_feeds', $this->enabledSettings)) {
      $this->wple_remove_feeds();
    }
  }

  /**
   * Stop user enumeration   
   */
  public function wple_stop_user_enumeration()
  {
    if (!is_admin() && isset($_SERVER['REQUEST_URI'])) {
      if (preg_match('/(wp-comments-post)/', $_SERVER['REQUEST_URI']) === 0 && !empty($_REQUEST['author'])) {
        wp_die(__('Author info access is forbidden', 'rrr'), 403);
      }
    }
    add_filter('oembed_response_data', array($this, 'wple_oembed_user_enumeration'), 10, 1);
    add_filter('rest_request_before_callbacks', array($this, 'wple_rest_user_enumeration'), 10, 1);
  }

  public function wple_oembed_user_enumeration($response)
  {
    unset($response['author_name']);
    unset($response['author_url']);
    return $response;
  }

  public function wple_rest_user_enumeration($response)
  {
    $rest_route = !empty($_GET['rest_route']) ? $_GET['rest_route'] : (empty($_SERVER['REQUEST_URI']) ? '' : (string) parse_url(urldecode($_SERVER['REQUEST_URI']), PHP_URL_PATH));
    $rest_route = trim($rest_route, '/');

    if ('' != $rest_route && !current_user_can('edit_others_posts')) {
      if (preg_match('/wp\/v2\/users$/i', $rest_route)) {
        $error = new WP_Error('wple_users_list_forbidden', 'Access to users list is forbidden');
        $response = rest_ensure_response($error);
      } elseif (preg_match('/wp\/v2\/users\/+(\d+)$/i', $rest_route, $matches)) {
        $id = empty($matches) ? 0 : (int) $matches[1];
        if (get_current_user_id() !== $id) {
          $error = new WP_Error('wple_user_details_forbidden', 'Access to user details is forbidden', array('status' => 403));
          $response = rest_ensure_response($error);
        }
      }
    }
    return $response;
  }

  /**
   * Remove WP version info
   */
  public function wple_remove_wp_versions()
  {
    add_filter('the_generator', array($this, 'wple_remove_wp_meta'));
    add_filter('style_loader_src', array($this, 'wple_replace_wpver_with_hash'));
    add_filter('script_loader_src', array($this, 'wple_replace_wpver_with_hash'));
  }
  public function wple_remove_wp_meta()
  {
    return '';
  }
  public function wple_replace_wpver_with_hash($src)
  {
    global $wp_version;
    static $wp_hash = null;

    if (empty($src)) return '';

    if (stripos($src, 'ver=' . $wp_version) !== false) {
      if (!$wp_hash) {
        $wp_hash = wp_hash($wp_version);
      }
      $src = add_query_arg('ver', $wp_hash, $src);
    }
    return $src;
  }

  /**
   * Disallow File Edit
   * 
   * @param boolean $disallow
   */
  public function wple_disallow_file_edit($disallow = 'true')
  {
    $disallow = sanitize_text_field($disallow);
    $conf = ABSPATH . "wp-config.php";
    if (is_writable($conf)) {
      $config = file_get_contents(ABSPATH . "wp-config.php");

      if (FALSE == strpos($config, 'DISALLOW_FILE_EDIT')) {
        $newconfig = preg_replace("/^([\r\n\t ]*)(\<\?)(php)?/i", "<?php " . "\n" . "define('DISALLOW_FILE_EDIT', $disallow);" . "\n", $config);
      } else { //already defined
        $newconfig = preg_replace("/define\(['\"]DISALLOW_FILE_EDIT.*\)/i", "define('DISALLOW_FILE_EDIT', $disallow)", $config);
      }

      file_put_contents(ABSPATH . "wp-config.php", $newconfig);
    }
  }

  /**
   * Hide login error feedback
   */
  public function wple_hide_login_error($errors)
  {
    $arr = ['invalid_username', 'incorrect_password'];
    if (is_wp_error($errors) && in_array($errors->get_error_code(), $arr)) {
      $errors = new WP_Error('invalid', sprintf(__('%sError:%s Incorrect login credentials', 'wp-letsencrypt-ssl'), '<strong>', '</strong>'));
    }

    return $errors;
  }

  /**
   * Control anyone can register option
   * @param bool $enable
   */
  public function wple_anyone_can_register($enable = true)
  {
    update_option('users_can_register', $enable);
  }

  /**
   * Disable XMLRPC Pingbacks
   */
  public function wple_disable_pingback_methods($methods)
  {
    unset($methods['pingback.ping']);
    unset($methods['pingback.extensions.getPingbacks']);
    return $methods;
  }

  public function wple_disable_pingback_header($headers)
  {
    unset($headers['X-Pingback']);
    return $headers;
  }

  /**
   * Remove RSS & Atom feeds
   */
  public function wple_remove_feeds()
  {
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);

    add_action('do_feed', array($this, 'wp_redirect_home'), 1);
    add_action('do_feed_rdf', array($this, 'wp_redirect_home'), 1);

    add_action('do_feed_rss', array($this, 'wp_redirect_home'), 1);
    add_action('do_feed_rss2', array($this, 'wp_redirect_home'), 1);
    add_action('do_feed_rss2_comments', array($this, 'wp_redirect_home'), 1);

    add_action('do_feed_atom', array($this, 'wp_redirect_home'), 1);
    add_action('do_feed_atom_comments', array($this, 'wp_redirect_home'), 1);
  }
  public function wp_redirect_home()
  {
    wp_redirect(home_url());
  }

  /**
   * Deny php execution in uploads folder
   */
  public function wple_deny_php_in_uploads($enable = true)
  {
    $uploads_htaccess = ABSPATH . 'wp-content/uploads/.htaccess';

    if ($enable) {
      $rules = "#BEGIN WP_ENCRYPTION_SECURITY" . "\n" . "<Files *.php>" . "\n" . "deny from all" . "\n" . "</Files>" . "\n" . "# END WP_ENCRYPTION_SECURITY" . "\n";

      $backup = '';
      if (file_exists($uploads_htaccess)) {
        $backup = file_get_contents($uploads_htaccess);
      }

      if (stripos($backup, 'WP_ENCRYPTION_SECURITY') === FALSE) { //dont repeat
        file_put_contents($uploads_htaccess, $rules . $backup);
      }
    } else { //remove the rules

      if (file_exists($uploads_htaccess)) {
        $htaccess = file_get_contents($uploads_htaccess);
        $group = "/#\\s?BEGIN\\s?WP_ENCRYPTION_SECURITY.*?#\\s?END\\s?WP_ENCRYPTION_SECURITY/s";

        if (preg_match($group, $htaccess)) {
          $modhtaccess = preg_replace($group, "", $htaccess);
          file_put_contents($uploads_htaccess, $modhtaccess);
        }
      }
    }
  }
}
