<?php

class PixAdminSettingRadioImage extends PixAdminSetting {

	public $sanitize_callback = 'sanitize_text_field';
	public $default_value = '';
	public $images = array();

	public function display_setting() {
	
		$input_name = $this->get_input_name();
        $output = array();
        $value = !isset($this->value) || $this->value == '' ? $this->default_value : $this->value;

		if ( !empty( $this->images ) ) {
			foreach ( $this->images as $key => $image ) {
				$checked = $value == $key ? 'checked' : '';
				$output[] = '
				<div class="radio-image-item">
					<input id="pixid-' . esc_attr($input_name.'-'.$key) . '" name="'. esc_attr($input_name) .'" value="' . esc_attr($key) . '" type="radio" class="pix-radio-images-field" ' . wp_kses_post($checked) . '>
					<label class="vc_checkbox-label" for="pixid-' . esc_attr($input_name.'-'.$key) . '"> <img src="'.esc_url(PIX_PLUGIN_URL . '/assets/images/'.$image).'" ></label>
				</div>';
			}
		}

		?>

        <div class="pix-radio-images">
            <?php
                echo implode($output);
            ?>
        </div>

		<?php

		$this->display_description();

	}

}
