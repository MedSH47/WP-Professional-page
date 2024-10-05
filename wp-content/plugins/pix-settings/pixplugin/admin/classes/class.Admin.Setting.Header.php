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
 * @package PixAdmin
 */

class PixAdminSettingHeader extends PixAdminSetting {

	public $sanitize_callback = 'sanitize_text_field';
	public $default_value = '';

	public function display_setting() {
	
		$input_name = $this->get_input_name();

		$header = $this->default_value;
        $header_out = '';

        foreach ($header as $key => $val){
            $header_out .= '<div class="pix-section-header">'.$val.'</div>';
        }
		?>

            <div class="pix-section-header">
                <?php echo wp_kses_post($header_out) ?>
            </div>

		<?php

		$this->display_description();

	}

}
