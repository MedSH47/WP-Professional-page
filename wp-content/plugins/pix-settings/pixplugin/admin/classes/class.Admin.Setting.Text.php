<?php

/**
 * Register, display and save a text field setting in the admin menu
 *
 * @since 1.0
 * @package Simple Admin Pages
 */

class PixAdminSettingText extends PixAdminSetting {

	public $sanitize_callback = 'sanitize_text_field';

	/**
	 * Placeholder string for the input field
	 * @since 2.0
	 */
	public $class = '';
	public $placeholder = '';

	/**
	 * Display this setting
	 * @since 1.0
	 */
	public function display_setting() {
		?>

		<input name="<?php echo $this->get_input_name(); ?>" type="text" id="<?php echo $this->get_input_name(); ?>" value="<?php echo $this->value; ?>"<?php echo !empty( $this->placeholder ) ? ' placeholder="' . esc_attr( $this->placeholder ) . '"' : ''; ?> class="regular-text <?php echo esc_attr($this->class); ?>" />

		<?php
		
		$this->display_description();
		
	}

}
