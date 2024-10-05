<?php

class PixAdmin {

	public $title;
	public $menu_title;
	public $description; // optional description for this page
	public $capability; // user permissions needed to edit this panel
	public $id; // id of this page
	public $sections = array(); // array of sections to display on this page
	public $show_button = true; // whether or not to show the Save Changes button

	public $setup_function = 'add_options_page'; // WP function to register the page


	public function __construct( $args ) {

		// Parse the values passed
		$this->parse_args( $args );
	}


	private function parse_args( $args ) {
		foreach ( $args as $key => $val ) {
			switch ( $key ) {

				case 'id' :
					$this->{$key} = esc_attr( $val );

				default :
					$this->{$key} = $val;

			}
		}
	}


	public function modify_required_capability( $cap ) {
		return $this->capability;
	}


	public function add_admin_menu() {
		call_user_func( $this->setup_function, $this->title, $this->menu_title, $this->capability, $this->id, array( $this, 'display_admin_menu' ) );
	}


	public function add_section( $section ) {

		if ( !$section ) {
			return;
		}

		$this->sections[ $section->id ] = $section;

	}


	public function register_admin_menu() {

		foreach ( $this->sections as $section ) {
			$section->add_settings_section();

			foreach ( $section->settings as $setting ) {
				$setting->add_settings_field( $section->id );
			}
		}

		register_setting( $this->id, $this->id, array( $this, 'sanitize_callback' ) );

		// Modify capability required to save the settings if it's not
		// the default 'manage_options'
		if ( !empty( $this->capability ) && $this->capability !== 'manage_options') {
			add_filter( 'option_page_capability_' . $this->id, array( $this, 'modify_required_capability' ) );
		}
	}


	public function sanitize_callback( $value ) {

		if ( empty( $_POST['_wp_http_referer'] ) ) {
			return $value;
		}

		// Get the current page/tab so we only update those settings
		parse_str( $_POST['_wp_http_referer'], $referrer );
		$current_page = $this->get_current_page( $referrer );

		// Use a new empty value so only values for settings that were added are
		// passed to the db.
		$new_value = array();

		foreach ( $this->sections as $section ) {
			foreach ( $section->settings as $setting ) {
				if ( $setting->tab == $current_page ) {
					$setting_value = isset( $value[$setting->id] ) ? $value[$setting->id] : '';
					$new_value[$setting->id] = $setting->sanitize_callback_wrapper( $setting_value );
				}
			}
		}

		// Pull in the existing values so we never overwrite values that were
		// on a different tab
		$old_value = get_option( $this->id );

		if ( is_array( $old_value ) ) {
			return array_merge( $old_value, $new_value );
		} else {
			return $new_value;
		}

	}


	public function get_current_page( $request ) {

		if ( !empty( $request['tab'] ) ) {
			return $request['tab'];
		} elseif ( !empty( $this->default_tab ) ) {
			return $this->default_tab;
		} else {
			return $this->id;
		}

	}


	public function display_admin_menu() {

		if ( !$this->title && !count( $this->settings ) ) {
			return;
		}

		if ( !current_user_can( $this->capability ) ) {
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}

		$current_page = $this->get_current_page( $_GET );

		?>
			<div class="wrap">

				<?php $this->display_page_title(); ?>

                <?php if( isset($_GET['settings-updated']) ) { ?>
                <div id="message" class="updated">
                    <p><strong><?php _e('Settings saved.', 'pixcars') ?></strong></p>
                </div>
                <?php } ?>
                
				<?php if ( isset( $this->default_tab ) ) : ?>
				<h2 class="nav-tab-wrapper pix">
				<?php
				foreach( $this->sections as $section ) {

                    if ( isset( $section->is_tab ) && $section->is_tab === true ) {

                        $tab_url = add_query_arg(
                            array(
                                'settings-updated' => false,
                                'tab' => $section->id
                            )
                        );

                        $active = $current_page == $section->id ? ' nav-tab-active' : '';
                        echo '<a href="' . esc_url( $tab_url ) . '" title="' . esc_attr( $section->title ) . '" class="nav-tab' . $active . '">';
                        echo esc_html( $section->title );
                        echo '</a>';
                    }
                }
				?>
                    <div class="pix-help-links">
                        <p class="pix-customizer"><?php _e('Header settings can be found', 'pixcars') ?> <a target="_blank" href="<?php echo esc_url(get_site_url() . '/wp-admin/customize.php'); ?>"><?php esc_html_e('in the Customizer', 'pixcars') ?></a>.</p>
                        <div class="pix-customizer">
                            <a class="pix-email" href="mailto:pixtheme.help@gmail.com">pixtheme.help@gmail.com</a>
                            <a class="pix-button" target="_blank" href="https://solutech.true-emotions.studio/_documentation/index.html"><?php esc_html_e('Theme Documentation', 'pixcars') ?></a>
                            <a class="pix-button" target="_blank" href="https://help.pix-theme.com/forums/forum/solutech-security-multipurpose/"><?php esc_html_e('Pix Help', 'pixcars') ?></a>
                        </div>
                    </div>
				</h2>
				<?php endif; ?>


				<form method="post" action="options.php">
					<?php settings_fields( $this->id ); ?>
					<?php do_settings_sections( $current_page ); ?>
					<?php if ( $this->show_button ) { submit_button(); } ?>
				</form>
			</div>

		<?php
	}


	public function display_page_title() {

		if ( empty( $this->title ) ) {
			return;
		}
		?>
			<h1><?php echo $this->title; ?></h1>
		<?php
	}

}
