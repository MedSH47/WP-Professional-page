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

class PixAdminSettingMultiToggle extends PixAdminSetting {

	public $sanitize_callback = 'sanitize_text_field';
	public $default_value = '';

	public $scripts = array(
		'pix-multitoggle' => array(
			'path'			=> 'js/multitoggle.js',
			'dependencies'	=> array( 'jquery' ),
			'version'		=> '1.0.0',
			'footer'		=> true,
		),
	);

	public function display_setting() {
	
		$input_name = $this->get_input_name();
		$open = $select = $check_values ='';
        $values = !isset($this->value) || $this->value == '' ? @json_decode($this->default_value, true) : json_decode(html_entity_decode($this->value), true);
        //print_r(json_decode(html_entity_decode($this->value), true));

        if ($values !== NULL) {
            if (!empty($values['select'])) {
                $open = '<button class="pix-toggle-btn" type="button"><i class="fas fa-caret-right"></i><i class="fas fa-caret-down"></i></i></button>';
                $select = '
                <div class="pix-select-sortable-wrapper pix-slide-up"> 
                    <div class="pix-select-sortable">';
                foreach ($values['select'] as $key => $val) {
                    $class_visible = !$val['visible'] ? '' : 'visible';
                    $can_delete = !isset($val['delete']) ? '' : '
                                    <button class="pix-edit" type="button"><i class="fas fa-pencil-alt"></i></button>
                                    <button class="pix-delete" type="button"><i class="far fa-trash-alt"></i></button>';
                    $select .= '<div class="pix-select-option" data-field="' . esc_attr($input_name) . '" data-id="' . esc_attr($val['id']) . '" >
                                    <span>' . wp_kses_post($val['name']) . '</span>
                                    '.wp_kses_post($can_delete).'
                                    <button class="pix-visible ' . esc_attr($class_visible) . '" type="button"><i class="far fa-lightbulb"></i></button>
                                </div>';
                }
                $select .= '
                        <div class="pix-select-option pix-add-new hide-fields" data-field="' . esc_attr($input_name) . '" data-id="" >
                            <button class="pix-add pix-btn-icon" type="button"><i class="far fa-lightbulb"></i> ' . __('Add New', 'pixcars') . '</button>
                            <div class="pix-add-fields hide">
                                <input type="text" placeholder="' . esc_attr__('Name', 'pixcars') . '" class="pix-option-name" value="">
                                <button class="pix-save pix-btn-icon" type="button"><i class="fas fa-plus"></i>' . __('Add', 'pixcars') . '</button>
                                <button class="pix-cancel pix-btn-icon" type="button"><i class="fas fa-ban"></i>' . __('Cancel', 'pixcars') . '</button>
                            </div>
                        </div>
                    </div>
                </div>';
            }
            $checked_first = $values['checked-first'] == 'on' ? 'checked' : '';
            $checked_second = $values['checked-second'] == 'on' ? 'checked' : '';
        } else {
            $check_values = !isset($this->value) || $this->value == '' ? explode(',', $this->default_value) : explode(',', $this->value);
            $checked_first = $check_values[0] == 'on' ? 'checked' : '';
            $checked_second = $check_values[1] == 'on' ? 'checked' : '';
        }


		?>

            <div class="pix-multitoggle-boxes" data-field="<?php echo esc_attr($input_name) ?>">
                <?php
                    echo wp_kses_post($open);
                ?>
                <label class="switch switch-green pix-first">
                  <input type="checkbox" class="switch-input pix-switch-button-field" data-id="checked-first" <?php echo esc_attr($checked_first) ?> />
                  <span class="switch-label" data-on="On" data-off="Off"></span>
                  <span class="switch-handle"></span>
                </label>

                <label class="switch switch-green pix-last">
                  <input type="checkbox" class="switch-input pix-switch-button-field" data-id="checked-second" <?php echo esc_attr($checked_second) ?> />
                  <span class="switch-label" data-on="On" data-off="Off"></span>
                  <span class="switch-handle"></span>
                </label>

                <div class="clearfix"></div>
                <?php
                    echo $select;
                ?>
                <input type="hidden" class="pix-hidden-text" name="<?php echo $input_name; ?>" id="<?php echo $input_name; ?>" value="<?php echo $this->value; ?>"/>
            </div>

		<?php

		$this->display_description();

	}

}
