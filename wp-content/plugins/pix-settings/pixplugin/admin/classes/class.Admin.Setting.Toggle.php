<?php

/**
 * Register, display and save an option with a single checkbox.
 *
 * This setting accepts the following arguments in its constructor function.
 *
 * $args = array(
 *		'id'			=> 'setting_id', 	// Unique id
 *		'title'			=> 'My Setting', 	// Title or label for the setting
 *		'description'	=> 'Description', 	// Help text description
 *		'label'			=> 'Label', 		// Checkbox label text
 *		);
 * );
 *
 * @since 1.0
 * @package Simple Admin Pages
 */

class PixAdminSettingToggle extends PixAdminSetting {

	public $sanitize_callback = 'sanitize_text_field';
	public $default_value = '';

	/**
	 * Display this setting
	 * @since 1.0
	 */
	public function display_setting() {
	
		$input_name = $this->get_input_name();
		$value = !isset($this->value) || $this->value == '' ? $this->default_value : $this->value;
		$checked = $value == 'on' ? 'checked' : '';

		?>
        <div class="pix-switch-container">
            <label class="switch switch-green">
              <input type="checkbox"  class="switch-input pix-switch-button" <?php echo esc_attr($checked) ?> />
              <span class="switch-label" data-on="On" data-off="Off"></span>
              <span class="switch-handle"></span>
            </label>
            <input type="hidden" class="pix-switch-value" name="<?php echo esc_attr($input_name) ?>" value="<?php echo esc_attr($value) ?>" >
        </div>

		<?php

		$this->display_description();

	}

}
