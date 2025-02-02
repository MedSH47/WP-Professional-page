<?php

/**
 * Register, display and save a section on a custom admin menu
 *
 * @since 1.0
 * @package Simple Admin Pages
 */

class PixAdminSection {

	// Page defaults
	public $id; // unique id for this section
	public $title; // optional title to display above this section
	public $description; // optional description of the section
	public $settings = array(); // Array of settings to display in this option set

	// Array to store errors
	public $errors = array();
	
	public function __construct( $args ) {

		// Parse the values passed
		$this->parse_args( $args );

		// Set an error if there is no id for this section
		if ( !isset( $this->id ) ) {
			$this->set_error(
				array(
					'type'		=> 'missing_data',
					'data'		=> 'id'
				)
			);
		}

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

	
	public function add_setting( $setting ) {

		if ( !$setting ) {
			return;
		}

		if ( method_exists( $setting, 'has_position' ) && $setting->has_position() ) {

			// Top
			if ( $setting->position[0] == 'top' ) {
				$this->settings = array_merge( array( $setting->id => $setting ), $this->settings );
				return;
			}

			// Position setting relative to another setting
			if ( !empty( $setting->position[1] ) ) {

				$new_settings = array();
				foreach( $this->settings as $id => $current ) {

					// Above
					if ( $setting->position[1] == $id && $setting->position[0] == 'above' ) {
						$new_settings[ $setting->id ] = $setting;
					}

					$new_settings[ $id ] = $current;

					// Below
					if ( $setting->position[1] == $id && $setting->position[0] == 'below' ) {
						$new_settings[ $setting->id ] = $setting;
					}
				}

				$this->settings = $new_settings;

				return;
			}
		}

		// Fallback to appending it at the end
		$this->settings[ $setting->id ] = $setting;
	}

	
	public function display_section() {

		if ( !count( $this->settings ) ) {
			return;
		}

		if ( !empty( $this->description ) ) :
		?>

			<p class="description"><?php echo $this->description; ?></p>

		<?php
		endif;
	}

	
	public function add_settings_section() {
		add_settings_section( $this->id, $this->title, array( $this, 'display_section' ), $this->get_page_slug() );
	}

	
	public function get_page_slug() {
		if ( isset( $this->is_tab ) && $this->is_tab === true ) {
			return $this->id;
		} elseif ( isset( $this->tab ) ) {
			return $this->tab;
		} else {
			return $this->page;
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
