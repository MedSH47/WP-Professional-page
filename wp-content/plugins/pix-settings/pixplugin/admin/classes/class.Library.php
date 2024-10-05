<?php
if ( !class_exists( 'PixAdminLibrary' ) ) {

class PixAdminLibrary {

    
	public $lib_url;

	
	public $pages = array();
	
	public $errors = array();
	
	public $debug_mode = false;


	public function __construct( $args ) {
	    
		if ( !isset( $args['lib_url'] ) ) {
			$this->set_error(
				array(
					'id' 		=> 'no-lib-url',
					'desc'		=> 'No URL path to the library provided when the libary was created.',
					'var'		=> $args,
					'line'		=> __LINE__,
					'function'	=> __FUNCTION__
				)
			);
		} else {
			$this->lib_url = $args['lib_url'];
		}
		
		if ( isset( $args['debug_mode'] ) && $args['debug_mode'] === true ) {
			$this->debug_mode = true;
		}
		
		require_once(ABSPATH . '/wp-admin/includes/plugin.php');
		
		$this->load_class( 'PixAdmin', 'class.Admin.php' );
		$this->load_class( 'PixAdminSection', 'class.Admin.Section.php' );
		$this->load_class( 'PixAdminSetting', 'class.Admin.Setting.php' );
		
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_action( 'wp_ajax_pix_fields_order', array( $this, 'pix_fields_order' ) );
        add_action( 'wp_ajax_nopriv_pix_fields_order', array( $this, 'pix_fields_order' ) );

	}

	
	private function load_class( $class, $file ) {

		if ( !class_exists( $class ) ) {
			require_once( $file );
		}
	}

	
	private function get_setting_classname( $type ) {

		switch( $type ) {

            case 'header' :
				require_once('class.Admin.Setting.Header.php');
				return 'PixAdminSettingHeader';

			case 'text' :
				require_once('class.Admin.Setting.Text.php');
				return 'PixAdminSettingText';

			case 'textarea' :
				require_once('class.Admin.Setting.Textarea.php');
				return 'PixAdminSettingTextarea';

			case 'select' :
				require_once('class.Admin.Setting.Select.php');
				return 'PixAdminSettingSelect';

			case 'toggle' :
				require_once('class.Admin.Setting.Toggle.php');
				return 'PixAdminSettingToggle';

			case 'multi-toggle' :
				require_once('class.Admin.Setting.MultiToggle.php');
				return 'PixAdminSettingMultiToggle';

			case 'segment-toggle' :
				require_once('class.Admin.Setting.SegmentToggle.php');
				return 'PixAdminSettingSegmentToggle';

			case 'radio-image' :
				require_once('class.Admin.Setting.RadioImage.php');
				return 'PixAdminSettingRadioImage';

			case 'image' :
				require_once('class.Admin.Setting.Image.php');
				return 'PixAdminSettingImage';

			case 'color' :
				require_once('class.Admin.Setting.Color.php');
				return 'PixAdminSettingColor';

			case 'post' :
				require_once('class.Admin.Setting.SelectPost.php');
				return 'PixAdminSettingSelectPost';

			case 'taxonomy' :
				require_once('class.Admin.Setting.SelectTaxonomy.php');
				return 'PixAdminSettingSelectTaxonomy';

			case 'editor' :
				require_once('class.Admin.Setting.Editor.php');
				return 'PixAdminSettingEditor';

			case 'html' :
				require_once('class.Admin.Setting.HTML.php');
				return 'PixAdminSettingHTML';

			case 'address' :
				require_once('class.Admin.Setting.Address.php');
				return 'PixAdminSettingAddress';

			default :

				// Exit early if a custom type is declared without providing the
				// details to find the type class
				if ( ( !is_array( $type ) || !isset( $type['id'] ) ) ||
					( !isset( $type['class'] ) || !isset( $type['filename'] ) ) ) {
					return false;
				}

				// Load the custom type file. Look for the file in the library's
				// folder or check the custom library extension path.
				if ( file_exists( $type['filename'] ) ) {
					require_once( $type['filename'] );
				} else {
					return false;
				}

				return $type['class'];

		}

	}

	
	public function add_page( $menu_location, $args = array() ) {

		// default should be 'options'
		$class = 'PixAdmin';

		if ( $menu_location == 'menu' ) {
			$this->load_class( 'PixAdminMenu', 'class.Admin.Menu.php' );
			$class = 'PixAdminMenu';
		} elseif ( $menu_location == 'submenu' ) {
			$this->load_class( 'PixAdminSubmenu', 'class.Admin.Submenu.php' );
			$class = 'PixAdminSubmenu';
		}

		if ( class_exists( $class ) ) {
			$this->pages[ $args['id'] ] = new $class( $args );
		}

	}
	
	public function add_section( $page, $args = array() ) {

		if ( !isset( $this->pages[ $page ] ) ) {
			return false;
		} else {
			$args['page'] = $page;
		}

		$class = 'PixAdminSection';
		if ( class_exists( $class ) ) {
			$this->pages[ $page ]->add_section( new $class( $args ) );
		}

	}

	
	public function add_setting( $page, $section, $type, $args = array() ) {

		if ( !isset( $this->pages[ $page ] ) || !isset( $this->pages[ $page ]->sections[ $section ] ) ) {
			return false;
		} else {
			$args['page'] = $page;
			$args['tab'] = $this->pages[$page]->sections[ $section ]->get_page_slug();
		}

		$class = $this->get_setting_classname( $type );
		if ( $class && class_exists( $class ) ) {
			$this->pages[ $page ]->sections[ $section ]->add_setting( new $class( $args ) );
		}

	}
	
	
	public function add_admin_menus() {

		// If the library is run in debug mode, check for any errors in content,
		// print any errors found, and don't add the menu if there are errors
		if ( $this->debug_mode ) {
			$errors = array();
			foreach ( $this->pages as $page ) {
				foreach ( $page->sections as $section ) {
					if ( count( $section->errors ) ) {
						array_merge( $errors, $section->errors );
					}
					foreach ( $section->settings as $setting ) {
						if ( count( $setting->errors ) ) {
							$errors = array_merge( $errors, $setting->errors );
						}
					}
				}
			}
			if ( count( $errors ) ) {
				print_r( $errors );
				return;
			}
		}

		// Add the action hooks
		foreach ( $this->pages as $id => $page ) {
			add_action( 'admin_menu', array( $page, 'add_admin_menu' ) );
			add_action( 'admin_init', array( $page, 'register_admin_menu' ) );
		}
	}

	public function pix_fields_order() {

        if( true && check_ajax_referer( 'pix_fields_order_nonce', 'nonce') ){

            $pix_car_order = $_POST['fields_order'];
            $pix_section_id = $_POST['section_id'];
            update_option($pix_section_id, $pix_car_order);

            wp_send_json_success($pix_section_id);

        } else {
            wp_send_json_error( array( 'error' => 'Empty Data' ) );
        }

    }

	
	public function enqueue_scripts() {

		$screen = get_current_screen();

		foreach ( $this->pages as $page_id => $page ) {

			// Only enqueue assets for the current page
			if ( strpos( $screen->base, $page_id ) !== false ) {
				wp_enqueue_style( 'pix-admin-style', $this->lib_url . 'css/admin.css' );
				wp_enqueue_media();

				foreach ( $page->sections as $section ) {
					foreach ( $section->settings as $setting ) {
						foreach( $setting->scripts as $handle => $script ) {
							wp_enqueue_script( $handle, $this->lib_url . $script['path'], $script['dependencies'], $script['version'], $script['footer'] );
						}
						foreach( $setting->styles as $handle => $style ) {
							wp_enqueue_style( $handle, $this->lib_url . $style['path'], $style['dependencies'], $style['version'], $style['media'] );
						}
					}
				}
			}
		}
	}
	
	public function set_error( $error ) {
		$this->errors[] = array_merge(
			$error,
			array(
				'class'		=> get_class( $this ),
				'id'		=> $this->id,
				'backtrace'	=> debug_backtrace()
			)
		);
	}

}
} // endif;
