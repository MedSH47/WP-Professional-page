<?php
/*
Font Icons Loader
Plugin URI: https://help.pix-theme.com/
Description: Loader for font icons set.
Version: 1.0.1
Author: PixTheme
Author URI: https://true-emotions.studio/
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

define('FOLDER', 'assets/fonts/');
define('FOLDER_THEME', 'fonts/');

if ( ! class_exists( 'WP_List_Table' ) ) require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );

add_action('admin_menu', 'fil_plugin_setup_menu');

function fil_plugin_setup_menu(){

    add_theme_page('Font Icons Loader', 'Font Icons Loader', 'manage_options', 'fil-plugin', 'fil_init');
    wp_enqueue_style( 'default-fil-styles' , plugin_dir_url( __FILE__ ) . 'assets/css/fil-styles.css' );
}

$fil_plugin = str_replace('pix-font-icons-loader', 'pix-settings', __FILE__);

register_activation_hook( $fil_plugin, 'pixfil_fonts_activate' );
function pixfil_fonts_read($path, $active_fonts){

    $fonts_activate = array();
    if( file_exists($path) ){
        $dirlist = scandir( $path );
        foreach($dirlist as $val){
            if( is_dir($path . $val) && !in_array($val, array('.', '..')) ){

                $files = fil_get_files($path . $val);
				if(!empty($files)){
					$info = pathinfo($files[0]);
					$css_path = explode( $path, $info['dirname'].'/'.$info['basename']);
					$fonts_activate[$val] = $css_path[1];
                        if(!is_array($active_fonts) || !in_array($fonts_activate[$val], $active_fonts))
                            $active_fonts[$val] = $css_path[1];

				}

            }
        }

    }
    return $active_fonts;
}
function pixfil_fonts_activate(){

    $fil_dir = plugin_dir_path( __FILE__ ). FOLDER;
    $active_fonts = get_option('fil_font_icons');
	update_option('fil_font_icons', pixfil_fonts_read($fil_dir, $active_fonts));

    $fil_dir = get_template_directory().'/'. FOLDER_THEME;
    $active_fonts = get_option('fil_font_icons_theme');
    update_option('fil_font_icons_theme', pixfil_fonts_read($fil_dir, $active_fonts));
}

function fil_enqueue_styles() {

    $active_fonts = get_option('fil_font_icons');
    $fil_dir = plugin_dir_path( __FILE__ ). FOLDER;
    if(!empty($active_fonts)){
        foreach($active_fonts as $key => $val){
            if( file_exists($fil_dir . $val) && $val != '' ){
                wp_enqueue_style('fil-'.$key, plugin_dir_url( __FILE__ ) . FOLDER . $val);
                wp_register_style( 'fil_vc_'.$key, plugin_dir_url( __FILE__ ) . FOLDER . $val, false, '1.0', 'screen' );

            }
        }

    }

    $active_fonts = get_option('fil_font_icons_theme');
    $fil_dir = get_template_directory().'/'. FOLDER_THEME;
    if(!empty($active_fonts)){
        foreach($active_fonts as $key => $val){
            if( file_exists($fil_dir . $val) && $val != '' ){
                wp_enqueue_style('fil-theme-'.$key, get_template_directory_uri().'/'. FOLDER_THEME . $val);
                wp_register_style( 'fil_vc_theme_'.$key, get_template_directory_uri().'/'. FOLDER_THEME . $val, false, '1.0', 'screen' );

            }
        }

    }

}
add_action( 'wp_enqueue_scripts', 'fil_enqueue_styles' );
add_action( 'vc_base_register_front_css', 'fil_enqueue_styles' );
add_action( 'vc_base_register_admin_css', 'fil_enqueue_styles' );


$active_fonts = get_option('fil_font_icons');
$fil_dir = plugin_dir_path(__FILE__) . FOLDER;
fil_fonts_switch($fil_dir, $active_fonts);
$active_fonts = get_option('fil_font_icons_theme');
$fil_dir = get_template_directory().'/'. FOLDER_THEME;
fil_fonts_switch($fil_dir, $active_fonts);
function fil_fonts_switch($path, $active_fonts) {

	if (!empty($active_fonts)) {
		$i = 0;
		foreach ($active_fonts as $key => $val) {
			if (file_exists($path . $val) && $val != '') {
				$file_style = $path . $val;

				switch ($key) {
					case 'fontawesome':
						add_filter('vc_iconpicker-type-pixfontawesome', function ($icons) use ($file_style) {
							$typicons_icons = array();

							$cssFileContent = file_get_contents($file_style);
							preg_match_all('/\.fa-(.*)\:/', $cssFileContent, $matches);

							if (isset($matches) && !empty($matches)) {
								if (isset($matches[0]) && isset($matches[1])) {
									$classes = $matches[0];
									$values = $matches[1];
									foreach ($classes as $styleKey => $styleValue) {
										if (isset($values[$styleKey])) {
											$typicons_icons[] = array('fa ' . substr($styleValue, 1, -1) => ucwords(str_replace('-', ' ', $values[$styleKey])));
										}
									}
								}
							}

							return array_merge($icons, $typicons_icons);
						});
						break;
					case 'simple':
						add_filter('vc_iconpicker-type-pixsimple', function ($icons) use ($file_style) {
							$typicons_icons = array();

							$cssFileContent = file_get_contents($file_style);
							preg_match_all('/\.icon-(.*)\:/', $cssFileContent, $matches);

							if (isset($matches) && !empty($matches)) {
								if (isset($matches[0]) && isset($matches[1])) {
									$classes = $matches[0];
									$values = $matches[1];
									foreach ($classes as $styleKey => $styleValue) {
										if (isset($values[$styleKey])) {
											$typicons_icons[] = array(substr($styleValue, 1, -1) => ucwords(str_replace('-', ' ', $values[$styleKey])));
										}
									}
								}
							}

							return array_merge($icons, $typicons_icons);
						});
						break;
					case 'linear':
						add_filter('vc_iconpicker-type-pixlinear', function ($icons) use ($file_style) {
							$typicons_icons = array();

							$cssFileContent = file_get_contents($file_style);
							preg_match_all('/\.lnr-([^\:]+)/', $cssFileContent, $matches);

							if (isset($matches) && !empty($matches)) {
								if (isset($matches[0]) && isset($matches[1])) {
									$classes = $matches[0];
									$values = $matches[1];
									foreach ($classes as $styleKey => $styleValue) {
										if (isset($values[$styleKey])) {
											$typicons_icons[] = array('lnr ' . substr($styleValue, 1) => ucwords(str_replace('-', ' ', $values[$styleKey])));
										}
									}
								}
							}
							
							return array_merge($icons, $typicons_icons);
						});
						break;
					default:
						$i++;
						add_filter("vc_iconpicker-type-pixcustom$i", function ($icons) use ($file_style) {
							$typicons_icons = array();

							$cssFileContent = file_get_contents($file_style);
							preg_match_all('/\.(.*)\:before/', $cssFileContent, $matches);

							if (isset($matches) && !empty($matches)) {
								if (isset($matches[0]) && isset($matches[1])) {
									$classes = $matches[0];
									$values = $matches[1];
									foreach ($classes as $styleKey => $styleValue) {
										if (isset($values[$styleKey])) {
											$typicons_icons[] = array(substr($styleValue, 1, -7) => ucwords(str_replace('-', ' ', $values[$styleKey])));
										}
									}
								}
							}

							return array_merge($icons, $typicons_icons);
						});
						break;

				}
			}
		}

	}
}


function fil_get_files($dir = ".", $ext = 'css'){
     $files = array();
     if ($handle = opendir($dir)) {
          while (false !== ($item = readdir($handle))) {
               $explode = explode('.', $item);
               if (is_file("$dir/$item") && end($explode) == $ext ) {
                    $files[] = "$dir/$item";
               }
               elseif (is_dir("$dir/$item") && ($item != ".") && ($item != "..")){
                    $files = array_merge($files, fil_get_files("$dir/$item", $ext));
               }
          }
          closedir($handle);
     }
     return $files;
}

function fil_init(){


    fil_upload();
    fonts_actions();
    $fonts_vc_desc = get_option('fil_use_vc_icons') ? 'VC Icon Fonts On' : 'VC Icon Fonts Off';
    $fonts_vc = get_option('fil_use_vc_icons') ? 'Switch Off' : 'Switch On';
    ?>
    <div class="fil-container">

        <div class="fil-upload">
            <h3>Upload a File</h3>
            <!-- Form to handle the upload - The enctype value here is very important -->
            <form  method="post" enctype="multipart/form-data">
                <?php wp_nonce_field('fil_upload_action', 'fil_upload_icons'); ?>
                <input type='file' id='fil_upload_icons' name='fil_upload_icons'></input>
                <?php submit_button('Upload') ?>
            </form>
        </div>

        <div class="fil-table">
            <h3>Fonts Table</h3>
            <form  method="post">
                <input type="submit" name="UseVCIcons" value="<?php echo $fonts_vc; ?>"> <?php echo $fonts_vc_desc; ?>
                <table>
                    <thead>
                    <tr>
                        <th></th>
                        <th>Status</th>
                        <th>Font Icons</th>
                        <th>Upload Date</th>
                        <th>Preview</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $fil_dir = get_template_directory().'/'. FOLDER_THEME;
                    $active_fonts = get_option('fil_font_icons_theme');

                    if( file_exists($fil_dir) ){
                        $dirlist = scandir( $fil_dir );

                        foreach($dirlist as $val){
                            if( is_dir($fil_dir . $val) && !in_array($val, array('.', '..')) ){

                                $files_html = fil_get_files($fil_dir . $val, 'html');
                                $html = $info_html = '';
                                if(!empty($files_html)) {
                                    $info_html = pathinfo($files_html[0]);
                                    $html_path = explode( $fil_dir, $info_html['dirname'].'/'.$info_html['basename']);
                                    $info_html = $info_html['basename'];
	                                $html = $html_path[1];
                                }

								$files = fil_get_files($fil_dir . $val);
								if(!empty($files)){
									$info = pathinfo($files[0]);
									$css_path = explode( $fil_dir, $info['dirname'].'/'.$info['basename']);
									echo '<tr>';
                                    echo '<td><input type="checkbox" name="Filtheme-'.$val.'" value="'.$val.'"></td>'."\n";
                                    echo '<td>'.(isset($active_fonts[$val]) ? 'Active' : 'Inactive').'</td>'."\n";
                                    echo '<td>'.$css_path[1].'<input type="hidden" name="Filpaththeme-'.$val.'" value="'.$css_path[1].'"></td>'."\n";
                                    echo '<td><nobr>'.date ("m.d.Y H:i:s", filemtime($fil_dir.$val)).'</nobr></td>'."\n";
                                    echo '<td><a href="'.get_template_directory_uri().'/'. FOLDER_THEME .$html.'" target="_blank">'.$info_html.'</a></td>'."\n";
                                    echo '</tr>';
								}

                            }
                        }

                    }

                    $fil_dir = plugin_dir_path( __FILE__ ). FOLDER;
                    $active_fonts = get_option('fil_font_icons');

                    if( file_exists($fil_dir) ){
                        $dirlist = scandir( $fil_dir );

                        foreach($dirlist as $val){
                            if( is_dir($fil_dir . $val) && !in_array($val, array('.', '..')) ){

                                $files_html = fil_get_files($fil_dir . $val, 'html');
                                $html = $info_html = '';
                                if(!empty($files_html)) {
                                    $info_html = pathinfo($files_html[0]);
                                    $html_path = explode( $fil_dir, $info_html['dirname'].'/'.$info_html['basename']);
                                    $info_html = $info_html['basename'];
	                                $html = $html_path[1];
                                }

								$files = fil_get_files($fil_dir . $val);
								if(!empty($files)){
									$info = pathinfo($files[0]);
									$css_path = explode( $fil_dir, $info['dirname'].'/'.$info['basename']);
									echo '<tr>';
                                    echo '<td><input type="checkbox" name="Fil-'.$val.'" value="'.$val.'"></td>'."\n";
                                    echo '<td>'.(isset($active_fonts[$val]) ? 'Active' : 'Inactive').'</td>'."\n";
                                    echo '<td>'.$css_path[1].'<input type="hidden" name="Filpath-'.$val.'" value="'.$css_path[1].'"></td>'."\n";
                                    echo '<td><nobr>'.date ("m.d.Y H:i:s", filemtime($fil_dir.$val)).'</nobr></td>'."\n";
                                    echo '<td><a href="'.plugin_dir_url( __FILE__ ). FOLDER .$html.'" target="_blank">'.$info_html.'</a></td>'."\n";
                                    echo '</tr>';
								}

                            }
                        }

                    }
                    ?>
                    </tbody>
                </table>
                <input type="submit" name="Active" value="Activate">
                <input type="submit" name="Deactive" value="Deactivate">
                <input type="submit" name="Delete" value="Delete">
            </form>
        </div>
    </div>
    <?php
}

function fil_upload_dir($upload) {


    $upload['basedir'] = plugin_dir_path( __FILE__ );
    $upload['baseurl'] = plugin_dir_url( __FILE__ );

    $upload['subdir'] = FOLDER;
    $upload['path']   = $upload['basedir'] . $upload['subdir'];
    $upload['url']    = $upload['baseurl'] . $upload['subdir'];

    return $upload;

}

function fil_upload() {


    if (empty($_POST['submit'])) return false;

    check_admin_referer('fil_upload_action', 'fil_upload_icons');
	
    $form_fields = array ('fil_upload_icons'); // this is a list of the form field contents I want passed along between page views
    $method = 'ftp'; // Normally you leave this an empty string and it figures it out by itself, but you can override the filesystem method here

    // check to see if we are trying to save a file
    if (isset($_FILES['fil_upload_icons'])) {

        // okay, let's see about getting credentials
        $url = wp_nonce_url('themes.php?page=fil-plugin');
        $in = true;
        if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {

            // if we get here, then we don't have credentials yet,
            // but have just produced a form for the user to fill in, 
            // so stop processing for now

            $in = false; // stop the normal page form from displaying
        }

        // now we have some credentials, try to get the wp_filesystem running
        if ($in && ! WP_Filesystem($creds) ) {
            // our credentials were no good, ask the user for them again
            request_filesystem_credentials($url, $method, true, false, $form_fields);
            $in = false;
        }

        if($in){

            $outputdir = preg_replace("[\\/]", DIRECTORY_SEPARATOR, plugin_dir_path(__FILE__)) . FOLDER ;

            $file = $_FILES['fil_upload_icons'];

            $overrides = array( 'test_form' => false );
            // Use the wordpress function to upload
            // test_upload_pdf corresponds to the position in the $_FILES array
            // 0 means the content is not associated with any other posts
            add_filter('upload_dir', 'fil_upload_dir');
            $uploaded = wp_handle_upload($file, $overrides);
            remove_filter('upload_dir', 'fil_upload_dir');
            // Error checking using WP functions
            if( !$uploaded || isset( $uploaded['error'] ) ){
                echo "Error uploading file: " . $uploaded['error'];
            }else{
                echo "File upload successful!<br>";
                try{
                    $zip = new ZipArchive;
                    $fileinfo = pathinfo($uploaded['file']);
                    $res = $zip->open($uploaded['file']);
                    if ($res === TRUE) {
                        // extract it to the path we determined above
                        $zip->extractTo($outputdir.$fileinfo['filename']);
                        $zip->close();
                        //echo $fileinfo['basename']." extracted to ".$outputdir.$fileinfo['filename'];
                    } else {
                        echo "I couldn't open ".$fileinfo['basename'];
                    }
                } catch (Exception $e){
                    echo $e->getMessage() . "<br/>";
                    return;
                }
            }
        }
    }

    return true;
}

function fonts_actions() {

	if (isset($_POST['UseVCIcons'])) {
        $fonts_vc = get_option('fil_use_vc_icons');
        $fonts_vc = $fonts_vc ? 0 : 1;
        update_option('fil_use_vc_icons', $fonts_vc);
    }

    if (empty($_POST['Active']) && empty($_POST['Deactive']) && empty($_POST['Delete'])) return false;

    if (isset($_POST['Active'])) {
        $fonts_active = get_option('fil_font_icons');
        $fonts_activete = array();
        foreach($_POST as $key => $val){
            if(substr_count($key, "Fil-")>0){
                $path = $_POST['Filpath-'.$val];
                $fonts_activete[$val] = $path;
                if(!in_array($fonts_activete[$val], $fonts_active))
                    $fonts_active[$val] = $path;
            }
        }
        update_option('fil_font_icons', $fonts_active);
        $fonts_active = get_option('fil_font_icons_theme');
        $fonts_activete = array();
        foreach($_POST as $key => $val){
            if(substr_count($key, "Filtheme-")>0){
                $path = $_POST['Filpaththeme-'.$val];
                $fonts_activete[$val] = $path;
                if(!in_array($fonts_activete[$val], $fonts_active))
                    $fonts_active[$val] = $path;
            }
        }
        update_option('fil_font_icons_theme', $fonts_active);
    }

    elseif (isset($_POST['Deactive'])) {
        $fonts_active = get_option('fil_font_icons');
        $fonts_deactivete = array();
        foreach($_POST as $key => $val){
            if(substr_count($key, "Fil-")>0){
                $path = $_POST['Filpath-'.$val];
                $fonts_deactivete[$val] = $path;
            }
        }
        foreach($fonts_active as $key => $val){
            if(isset($fonts_deactivete[$key]))
                unset($fonts_active[$key]);
        }
        update_option('fil_font_icons', $fonts_active);

        $fonts_active = get_option('fil_font_icons_theme');
        $fonts_deactivete = array();
        foreach($_POST as $key => $val){
            if(substr_count($key, "Filtheme-")>0){
                $path = $_POST['Filpaththeme-'.$val];
                $fonts_deactivete[$val] = $path;
            }
        }
        foreach($fonts_active as $key => $val){
            if(isset($fonts_deactivete[$key]))
                unset($fonts_active[$key]);
        }
        update_option('fil_font_icons_theme', $fonts_active);
    }

    elseif (isset($_POST['Delete'])) {
        $fonts_active = get_option('fil_font_icons');
        $fonts_delete = array();
        foreach($_POST as $key => $val){
            if(substr_count($key, "Fil-")>0){
                $id = $val;
                $path = $_POST['Filpath-'.$val];
                $fonts_delete[$val] = $path;
            }
        }
        foreach($fonts_active as $key => $val){
            if(isset($fonts_delete[$key]))
                unset($fonts_active[$key]);
        }
        update_option('fil_font_icons', $fonts_active);

        foreach($fonts_delete as $key => $val){
            if(is_dir(plugin_dir_path( __FILE__ ).FOLDER.$key)){
                $dir = plugin_dir_path( __FILE__ ).FOLDER.$key;
                $it = new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS);
                $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
                foreach($files as $file) {
                    if ($file->isDir()){
                        rmdir($file->getRealPath());
                    } else {
                        unlink($file->getRealPath());
                    }
                }
                rmdir($dir);
            }
            if(file_exists(plugin_dir_path( __FILE__ ).FOLDER.$key.'.zip')){
                unlink(plugin_dir_path( __FILE__ ).FOLDER.$key.'.zip');
            }
        }
    }

    return true;
}