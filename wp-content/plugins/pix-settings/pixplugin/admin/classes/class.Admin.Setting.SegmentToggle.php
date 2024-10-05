<?php

class PixAdminSettingSegmentToggle extends PixAdminSetting {

	public $sanitize_callback = 'sanitize_text_field';
	public $default_value = '';
	public $options = array();

	public $scripts = array(
		'pix-multitoggle' => array(
			'path'			=> 'js/segment-toggle.js',
			'dependencies'	=> array( 'jquery' ),
			'version'		=> '1.0.0',
			'footer'		=> true,
		),
	);

	public function display_setting() {
	
		$input_name = $this->get_input_name();
        $output = array();
        $value = !isset($this->value) || $this->value == '' ? $this->default_value : $this->value;

        if ( ! empty( $this->options ) ) {
            $i=0;
            $cnt = count($this->options)-1;
            $defalut = '';
            $pix_rand = 'pixid-'.rand().'-';
            foreach ( $this->options as $key => $label ) {

                $class = '';
                if( $i == 0 ){
                    $class = 'first';
                } elseif ( $i == $cnt ){
                    $class = 'last';
                }
                $checked = '';
                if( $value == $key ){
                    $checked = 'checked';
                }

                $output[] = '<input id="' . $pix_rand . $key . '" name="'. $input_name .'" value="' . $key . '" type="radio" class="pix-segmented-button-field" ' . $checked . '>
                <label class="' . $class . '" for="' . $pix_rand . $key . '"> ' . $label . ' </label>';

                $i++;
            }
        }

		?>
            <div class="pix-segment-buttons pix-vc-segmented-button">
            <?php
                echo implode($output);
            ?>
            </div>

		<?php

		$this->display_description();

	}

}
