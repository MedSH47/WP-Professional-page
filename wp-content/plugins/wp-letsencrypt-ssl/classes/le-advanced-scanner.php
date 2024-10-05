<?php

/**
 * @package WP Encryption
 *
 * @author     Go Web Smarty
 * @copyright  Copyright (C) 2019-2024, Go Web Smarty. All Rights Reserved.
 * @link       https://gowebsmarty.com
 * @since      Class available since Release 5.7.0
 *
 */

class WPLE_DeepScanner
{
  private $permalinks_list = [];
  private $insecure_links_within_posts = [];
  private $permalink_vs_mxresource = [];
  private $permalink_vs_inlinemx = [];
  private $widget_issues = [];
  private $merged_widget_issues = [];

  public function __construct()
  {
    $this->get_all_permalinks();

    if (!empty($this->permalinks_list)) {
      foreach ($this->permalinks_list as $PID => $link) {
        $webpage = $this->retrieve_content($link);
        $this->parse_content_for_http_links($PID, $link, $webpage);
        $this->find_inline_insecure_items($PID, $link, $webpage);
      }
    }

    //$this->p($this->insecure_links_within_posts);
    $this->find_widgets_insecure_items();
    //$this->p($this->widget_issues);
    ///$this->p($this->merged_widget_issues);
    //$this->p($this->permalink_vs_mxresource);
    //$this->p($this->permalink_vs_inlinemx);

    //Table starts
    if (empty($this->permalink_vs_mxresource)) {
      delete_option('wple_mixed_issues');
      echo 'success';
      exit();
    }

    //have issues   

    update_option('wple_mixed_issues', 1);

    $table = '<table id="wple-advanced-scanner">
    <th>Type</th>
    <th>Insecure URL<br><small>URLs that needs updating to <strong>https://</strong></small></th>
    <th>Source File<br><small>Where it\'s coming from?</small></th>';

    foreach ($this->permalink_vs_mxresource as $ID => $research) {
      if (empty($research['mx_resources'])) continue;

      $table .= '<tr>
      <td colspan="3" class="wple-scan-head">Analyzed Page URL: ' . esc_url($research['webpage']) . ' (ID=' . (int) $ID . ')</td>      
      </tr>';

      $issue_found = false;
      foreach ($research['mx_resources'] as $key => $data) {
        if (empty($data) || (count($data) == 1 && false !== stripos($data[0], '/svg'))) continue;

        if ($key == 'secure_css' || $key == 'secure_js') { //insecure items within secure files
          $issue_found = true;
          foreach ($data as $key => $files_w_issue) {
            $table .= '<tr>
          <td class="issue_type">' . esc_html__('Insecure links within css/js files', 'wp-letsencrypt-ssl') . '</td>';
            $rcount = 1;
            foreach ($files_w_issue['issues'] as $key => $items) {
              $table .= '<td>http://' . implode("<br>http://", $items) . '</td>';
              $rcount++;
            }
            $table .= '<td class="wple-tooltip" data-tippy="Find & fix these insecure urls via Appearance ~ Theme Editor">' . esc_url($files_w_issue['resource']) . '</td>';
            $table .= '</tr>';
          }
        } else {

          $tds = '';
          $tdcount = 1;
          foreach ($data as $resource) {
            if (stripos($resource, '/svg')) {
              continue;
            }

            $issue_found = true;

            $issue_location = '';
            $issue_tooltip = 'Try updating Site & WordPress urls to https:// protocol in Settings > General to resolve this issue. Likewise, this could be coming from your active theme files or active plugin files.';

            if (in_array($resource, $this->merged_widget_issues)) {
              $issue_location = '<a href="' . admin_url("widgets.php") . '" target="_blank">WIDGET</a>';
              $issue_tooltip = 'Update this insecure url via Appearance > Widgets on left sidebar';
            }

            if (isset($this->insecure_links_within_posts[$ID])) {
              foreach ($this->insecure_links_within_posts[$ID] as $type => $items) {
                if (in_array($resource, $items)) {
                  $ID = (int) $ID;
                  $issue_location = '<a href="' . admin_url("post.php?post=$ID&action=edit") . '" target="_blank">POST CONTENT</a>';
                  $issue_tooltip = 'Update this insecure url via Edit Post';
                }
              }
            }

            if (isset($this->permalink_vs_inlinemx[$ID])) {
              foreach ($this->permalink_vs_inlinemx[$ID]['mx_resources'] as $indx => $arr) {
                if (in_array($resource, $arr)) {
                  $issue_location = 'INLINE STYLE / SCRIPT';
                  $issue_tooltip = 'This issue is found within webpage html and might be coming from custom css / js section of your active theme or plugins.';
                }
              }
            }

            $tds .= '<tr><td>' . esc_url($resource) . '</td><td class="wple-tooltip" data-tippy="' . esc_attr($issue_tooltip) . '">' . $issue_location . '</td></tr>';
            $tdcount++;
          }
          if ($tdcount > 1) {
            $table .= '<tr>
            <td rowspan="' . $tdcount . '" class="issue_type">' . esc_html($key) . '</td>
            ' . $tds . '          
            </tr>';
          }
        }
      }

      if (!$issue_found) {
        $table .= '<tr>
            <td colspan="3" class="issue_type">Great!.. No mixed content issues found.</td>       
            </tr>';
      }
    }

    $table .= '</table>';

    echo wp_kses_post($table);
  }

  private function get_all_permalinks()
  {
    global $wpdb;
    $ptypes_query = array();
    $args = array(
      'public'   => true,
    );

    $ptypes = get_post_types($args);
    foreach ($ptypes as $post_type) {
      $ptypes_query[] = " post_type = '" . $post_type . "'";
    }

    $sql = implode(" OR ", $ptypes_query);
    $sql = "SELECT ID, post_content FROM $wpdb->posts where post_status='publish' and (" . $sql . ") LIMIT 25";

    $res = $wpdb->get_results($sql);

    if (!empty($res)) {
      foreach ($res as $item) {
        if (@!in_array(get_permalink($item->ID), $this->permalinks_list))
          $this->permalinks_list[$item->ID] = get_permalink($item->ID);
      }

      $this->locate_insecure_items_in_posts($res);
    }
  }

  private function locate_insecure_items_in_posts($results)
  {
    $url_pattern = '([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?)(?:[\'|\"])';
    $image_pattern = '([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?[.jpg|.gif|.jpeg|.png|.svg])(?:((\?.*[\'|"])|[\'|"]))';
    $script_pattern = '([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?[.js])(?:((\?.*[\'|\"])|[\'|\"]))';
    $style_pattern = '([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?[.css])(?:((\?.*[\'|\"])|[\'|\"]))';

    $patterns = array(
      'inline_css' => '/url\([\'"]?\K(http:\/\/)()' . $image_pattern . '/i',
      'link' => '/<link[^>].*?href=[\'"]\K(http:\/\/)()' . $style_pattern . '/i',
      'meta' => '/<meta property="og:image" .*?content=[\'"]\K(http:\/\/)()' . $image_pattern . '/i',
      'img' => '/<(?:img)[^>].*?src=[\'"]\K(http:\/\/)()' . $image_pattern . '/i',
      'iframe' => '/<(?:iframe)[^>].*?src=[\'"]\K(http:\/\/)()' . $url_pattern . '/i',
      'script' => '/<script[^>]*?src=[\'"]\K(http:\/\/)()' . $script_pattern . '/i',
      'form' => '/<form[^>]*?action=[\'"]\K(http:\/\/)()' . $url_pattern . '/i',
      'inline_js' => '/"url":"\K(http:\/\/)()' . $image_pattern . '/i',
    );

    foreach ($results as $res) {
      foreach ($patterns as $key => $pattern) {
        $matches = [];
        if (preg_match_all($pattern, $res->post_content, $matches, PREG_PATTERN_ORDER)) {
          $this->insecure_links_within_posts[$res->ID][$key] = $matches[3];
        }
      }
    }
  }

  private function retrieve_content($url)
  {

    if (strpos($url, "//") === 0) $url = "https:" . $url;

    $home = WPLE_Trait::get_root_domain(false);
    if (strpos($url, $home) !== FALSE) {
      $url = add_query_arg('wpen_scan', time(), $url);
    }

    $res = wp_remote_get($url);
    $maincontent = "";

    if (is_array($res)) {
      $maincontent = wp_remote_retrieve_body($res);
    }

    if (is_wp_error($res)) {
      return '';
    }

    return $maincontent;
  }

  private function parse_content_for_http_links($pid, $link, $content)
  {
    $patterns = array(
      "/(http:\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?[.jpg|.gif|.jpeg|.png])(?:((\?.*[\'|\"])|['|\"]))/",
      "/(http:\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?\.mp4)(?:((\?.*[\'|\"])|['|\"]))/",
      "/(http:\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?\.js)(?:((\?.*[\'|\"])|['|\"]))/",
      "/(http:\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?\.css)(?:((\?.*[\'|\"])|['|\"]))/",
    );

    $mx_resources = [];
    $matches = [];
    $count = 0;
    foreach ($patterns as $pattern) {
      $key = ($count == 2) ? 'insecure_js' : ($count == 3 ? 'insecure_css' : 'insecure_images');
      if (preg_match_all($pattern, $content, $matches, PREG_PATTERN_ORDER)) {
        $mx_resources[$key] = $matches[2];
      }
      $count++;
    }


    $patterns = array(
      "/(http:\/\/|https:\/\/|\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?\.js)(?:((\?.*[\'|\"])|['|\"]))/",
      "/(http:\/\/|https:\/\/|\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?\.css)(?:((\?.*[\'|\"])|['|\"]))/",
    );
    $all_cssjs_files = [];
    foreach ($patterns as $index => $pattern) {
      $key = ($index == 0) ? 'secure_js' : 'secure_css';
      if (preg_match_all($pattern, $content, $matches, PREG_PATTERN_ORDER)) {
        $all_cssjs_files[$key] = $matches[2];
      }
    }

    foreach ($all_cssjs_files as $key => $items) {

      foreach ($items as $index => $cssjsfile) {
        $foundissues = $this->check_mxissues_within_cssjs('https://' . $cssjsfile);
        if (!empty($foundissues)) {
          $mx_resources[$key][$index] = [
            'resource' => $cssjsfile,
            'issues' => $foundissues
          ];
        }
      }
    }

    if (!empty($mx_resources)) {
      $this->permalink_vs_mxresource[$pid] = [
        'webpage' => $link,
        'mx_resources' => $mx_resources
      ];
    }
  }

  private function check_mxissues_within_cssjs($cssjs_url)
  {
    $url_pattern = '([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?)';
    $patterns = array(
      '/url\([\'"]?\K(http:\/\/)' . $url_pattern . '/i',
      '/<script [^>]*?src=[\'"]\K(http:\/\/)' . $url_pattern . '/i',
      '/<meta property="og:image" .*?content=[\'"]\K(http:\/\/)' . $url_pattern . '/i',
      '/<(?:img|iframe)[^>].*?src=[\'"]\K(http:\/\/)' . $url_pattern . '/i',
      '/<link [^>].*?href=[\'"]\K(http:\/\/)' . $url_pattern . '/i',
    );

    $filestr = file_get_contents($cssjs_url);

    $totalmatches = [];
    foreach ($patterns as $pattern) {
      $matches = [];
      if (preg_match_all($pattern, $filestr, $matches, PREG_PATTERN_ORDER)) {
        $totalmatches[] = $matches[2];
      }
    }

    return $totalmatches;
  }

  private function find_inline_insecure_items($pid, $link, $webpage)
  {
    $url_pattern = '([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?)(?:[\'|\"])';
    $image_pattern = '([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?[.jpg|.gif|.jpeg|.png|.svg])(?:((\?.*[\'|"])|[\'|"]))';

    $patterns = array(
      '/url\([\'"]?\K(http:\/\/)' . $image_pattern . '/i',
      '/<(?:iframe)[^>].*?src=[\'"]\K(http:\/\/)' . $url_pattern . '/i',
      '/<form[^>]*?action=[\'"]\K(http:\/\/)' . $url_pattern . '/i',
    );

    $type = 'inline_style';
    $count = 0;
    $inline_issues = [];
    foreach ($patterns as $pattern) {
      $type = ($count == 1) ? 'inline_iframe' : ($count == 2 ? 'inline_form' : '');
      $matches = [];
      if (preg_match_all($pattern, $webpage, $matches, PREG_PATTERN_ORDER)) {
        $inline_issues[$type] = $matches[2];
      }

      $count++;
    }

    if (!empty($inline_issues)) {
      $this->permalink_vs_inlinemx[$pid] = [
        'webpage' => $link,
        'mx_resources' => $inline_issues
      ];
    }
  }

  private function find_widgets_insecure_items()
  {
    $widget_areas = wp_get_sidebars_widgets();

    foreach ($widget_areas as $widgets) {
      foreach ($widgets as $widget_title) {
        $widget_data = $this->get_widget_data($widget_title);

        if ($widget_data) {
          $patterns = array( //unable to detect embed widget
            "images" => "/(http:\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?[.jpg|.gif|.jpeg|.png|.svg])(?:((\?.*[\'|\"])|['|\"]))/",
            "video" => "/(http:\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?\.mp4)(?:((\?.*[\'|\"])|['|\"]))/",
            "js" => "/(http:\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?\.js)(?:((\?.*[\'|\"])|['|\"]))/",
            "css" => "/(http:\/\/)([\w.,@?^=%&:\/~+#-]*[\w@?^=%&\/~+#-]?\.css)(?:((\?.*[\'|\"])|['|\"]))/",
          );

          foreach ($patterns as $type => $pattern) {
            $matches = [];
            if (preg_match_all($pattern, $widget_data['html'], $matches, PREG_PATTERN_ORDER)) {
              $this->widget_issues[$widget_data['type'] . '-' . $widget_data['id']][] = $matches[2];
              $this->merged_widget_issues = array_merge($this->merged_widget_issues, $matches[2]);
            }
          }
        }
      }
    }
  }

  public function get_widget_data($title)
  {

    $type =  substr($title, 0, strpos($title, '-'));
    $id = substr($title, strpos($title, '-') + 1);

    $widget_array = get_option("widget_" . $type);
    $widget_html = "";
    $widget_title = "";

    $type_found = false;
    if (isset($widget_array[$id]["content"])) {
      $type_found = true;
      $widget_html = $widget_array[$id]["content"];
    }

    if (isset($widget_array[$id]["url"])) {
      $type_found =  true;
      $widget_html = $widget_array[$id]["url"];
    }
    if (isset($widget_array[$id]["text"])) {
      $type_found = true;
      $widget_html = $widget_array[$id]["text"];
    }

    if (isset($widget_array[$id]["title"])) {
      $widget_title = $widget_array[$id]["title"];
    }

    if (isset($widget_array[$id]["html"])) {
      $type_found = true;
      $widget_html = $widget_array[$id]["html"];
    }

    if ($type_found) {
      return array("type" => $type, "id" => $id, "html" => $widget_html, "title" => $widget_title);
    } else {
      return false;
    }
  }
}
