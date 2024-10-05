<?php

    if(function_exists('pix_vc_add_param')){
        pix_vc_add_param( 'radio_images', 'pixtheme_radio_images_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_radio_images.js' );
        pix_vc_add_param( 'switch_button', 'pixtheme_switch_button_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_switch_button.js' );
        pix_vc_add_param( 'segmented_button', 'pixtheme_segmented_button_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_segmented_button.js' );
        pix_vc_add_param( 'range_slider', 'pixtheme_range_slider_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_range_slider.js' );
        pix_vc_add_param( 'cars_filter', 'pixtheme_cars_filter_param_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_cars_filter.js' );
        pix_vc_add_param( 'tab_id_text', 'pixtheme_vc_tab_id_settings_field', get_template_directory_uri() . '/vc_templates/js/vc_segmented_button.js' );
    }

	function pixtheme_radio_images_param_settings_field( $settings, $value ) {
		$output = array();
		$col = isset($settings['col']) ? $settings['col'] : 2;
		$values = isset( $settings['value'] ) && is_array( $settings['value'] ) ? $settings['value'] : array( esc_html__( 'Yes', 'solutech' ) => 'true' );
		if ( ! empty( $values ) ) {
			foreach ( $values as $label => $v ) {
				$checked = $value == $v ? 'checked' : '';
				$label_arr = explode(';', $label);
				$label = isset($label_arr[0]) ? $label_arr[0] : '';
				$title = isset($label_arr[1]) ? '<span>'.wp_kses_post($label_arr[1]).'</span>' : '';
				$output[] = '
				<div class="radio-image-item">
					<input id="pixid-' . $v . '" value="' . $v . '" type="radio" class="pix-radio-images-field" ' . $checked . '>
					<label class="vc_checkbox-label" for="pixid-' . $v . '"> <img src="'.esc_url(get_template_directory_uri() . '/images/elements/'.$label).'" >'.wp_kses_post($title).'</label>
				</div>';
			}
		}
	    return '<div class="my_param_block pix-vc-radio-images pix-col-'.esc_attr($col).'">'.implode($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-radio-images hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value="' . $value . '"/></div>';
	}


    function pixtheme_switch_button_param_settings_field( $settings, $value ) {
        if( (!isset($value) || $value == '') && isset( $settings['value'] ) && $settings['value'] != '' ){
            $value = $settings['value'];
        } elseif( (!isset($value) || $value == '') && (!isset( $settings['value'] ) || $settings['value'] == '') ) {
            $value = 'off';
        }
        $checked = $value == 'on' ? 'checked' : '';
        $output = '
            <label class="switch switch-green">
              <input type="checkbox" class="switch-input pix-switch-button-field" '.esc_attr($checked).'>
              <span class="switch-label" data-on="On" data-off="Off"></span>
              <span class="switch-handle"></span>
            </label>
        ';
        return '<div class="my_param_block pix-vc-switch-button">'.($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-switch-button hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value="' . $value . '"/></div>';
    }


    function pixtheme_segmented_button_param_settings_field( $settings, $value ) {
        $output = array();
        $values = isset( $settings['value'] ) && is_array( $settings['value'] ) ? $settings['value'] : array( esc_html__( 'Yes', 'solutech' ) => 'true' );
        if ( ! empty( $values ) ) {
            $i=0;
            $cnt = count($values)-1;
            $defalut = '';
            $pix_rand = 'pixid-'.rand().'-';
            foreach ( $values as $label => $v ) {
                if( $i == 0 ){
                    $defalut = $label == 'default' ? $v : 'undefined';
                }
                $class = '';
                if( $i == 1 ){
                    $class = 'first';
                } elseif ( $i == $cnt ){
                    $class = 'last';
                }
                $checked = '';
                if( (!isset($value) || empty($value)) && $value == $defalut ){
                    $checked = 'checked';
                } elseif( $value == $v ){
                    $checked = 'checked';
                }

                if($defalut != 'undefined' && $i > 0) {
                    $output[] = '<input id="' . $pix_rand . $v . '" value="' . $v . '" type="radio" class="pix-segmented-button-field" ' . $checked . '>
                    <label class="' . $class . '" for="' . $pix_rand . $v . '"> ' . $label . ' </label>';
                }
                $i++;
            }
        }
        return '<div class="my_param_block pix-vc-segmented-button">'.implode($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-segmented-button hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value="' . $value . '"/></div>';
    }
    

    function pixtheme_range_slider_param_settings_field( $settings, $value ) {
        $values = isset( $settings['value'] ) && is_array( $settings['value'] ) ? $settings['value'] : array( esc_html__( 'Yes', 'solutech' ) => 'true' );
        if ( ! empty( $values ) ) {
            $i=0;
            $defalut = $min = $max = '';
            $unit = 'px';
            $step = '1';
            foreach ( $values as $label => $v ) {

                if( $label == 'min' ){
                    $min = $v;
                } elseif ( $label == 'max' ){
                    $max = $v;
                } elseif( $label == 'default' ){
                    $defalut = $v;
                } elseif( $label == 'step' ){
                    $step = $v;
                } elseif( $label == 'unit' ){
                    $unit = $v;
                } else
                    $defalut = '0';

                if( !isset($value) || empty($value) ){
                    $value = $defalut;
                }
                $i++;
            }
        }
        $output = '
            <input type="text" class="pix-range-slider-field" data-unit="'.esc_attr($unit).'" data-min="'.esc_attr($min).'" data-max="'.esc_attr($max).'" data-step="'.esc_attr($step).'" value="'.esc_attr((int)$value).'">
            <div class="range-values range-single-input">
                <input data-type="number" class="range-value">
            </div>
        ';
        return '<div class="my_param_block pix-vc-range-slider">'.($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-range-slider hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value="' . (int)$value . '"/></div>';
    }

    function pixtheme_cars_filter_param_settings_field( $settings, $value ){
        $title_arr = array(
            'makes' => array(
                'title' => esc_html__('Makes', 'solutech'),
                'placeholder' => esc_html__('Select Car Make', 'solutech'),
            ),
            'models' => array(
                'title' => esc_html__('Models', 'solutech'),
                'placeholder' => esc_html__('Select Car Model', 'solutech'),
            ),
            'years' => array(
                'title' => esc_html__('Year', 'solutech'),
                'placeholder' => esc_html__('Years', 'solutech'),
            ),
            'price' => array(
                'title' => esc_html__('Price', 'solutech'),
                'placeholder' => esc_html__('Price', 'solutech'),
            ),
            'body' => array(
                'title' => esc_html__('Body Type', 'solutech'),
                'placeholder' => esc_html__('Select Body Type', 'solutech'),
            ),
            'fuel' => array(
                'title' => esc_html__('Fuel', 'solutech'),
                'placeholder' => esc_html__('Select Fuel', 'solutech'),
            ),
            'transmission' => array(
                'title' => esc_html__('Transmission', 'solutech'),
                'placeholder' => esc_html__('Select Transmission', 'solutech'),
            ),
            'engine' => array(
                'title' => esc_html__('Engine Capacity', 'solutech'),
                'placeholder' => esc_html__('Engine Capacity', 'solutech'),
            ),
            'mileage' => array(
                'title' => esc_html__('Mileage', 'solutech'),
                'placeholder' => esc_html__('Mileage', 'solutech'),
            ),
        );

        if( !isset($value) || empty($value) ){
            $values = array(
                array(
                    'id' => 'makes',
                    'name' => $title_arr['makes']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'models',
                    'name' => $title_arr['models']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'years',
                    'name' => $title_arr['years']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'price',
                    'name' => $title_arr['price']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'body',
                    'name' => $title_arr['body']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'fuel',
                    'name' => $title_arr['fuel']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'transmission',
                    'name' => $title_arr['transmission']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'engine',
                    'name' => $title_arr['engine']['placeholder'],
                    'show' => true,
                ),
                array(
                    'id' => 'mileage',
                    'name' => $title_arr['mileage']['placeholder'],
                    'show' => true,
                ),
            );
            $value = json_encode($values);
        } else {
            $values = json_decode(html_entity_decode($value), true);
        }
        
        $output = '<div class="pix-widget-sortable ' . esc_attr($settings['param_name']) . '">';

        foreach($values as $key => $val){
            $checked = $val['show'] ? 'checked' : '';
            $output .= '
            <div class="pix-widget-option" data-field="'.esc_attr($val['id']).'">
                
                <label>'.esc_attr($title_arr[ $val['id'] ]['title']).': <input type="text" placeholder="'.esc_attr( $title_arr[ $val['id'] ]['placeholder'] ).'" value="'.esc_attr( $val['name'] ).'" '.($checked == 'checked' ? '' : 'disabled').' /></label>

                <label class="switch switch-green">
                  <input type="checkbox" class="switch-input" '.esc_attr($checked).' />
                  <span class="switch-label" data-on="On" data-off="Off"></span>
                  <span class="switch-handle"></span>
                </label>
            </div>';
        }

        $output .= '</div>';

        return '<div class="my_param_block pix-vc-cars-filter">'.($output).'<input type="text" name="' . esc_attr($settings['param_name']) . '" class="wpb_vc_param_value wpb-textinput pix-input-vc-cars-filter hidden-field-value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" value="' . ($value) . '"/></div>';
    }


    function pixtheme_vc_tab_id_settings_field( $settings, $value ) {
        if( (!isset($value) || $value == '') && (!isset( $settings['value'] ) || $settings['value'] == '') ) {
            $value = rand();
        }
        return '<div class="my_param_block">'
               . '<input name="' . $settings['param_name']
               . '" class="wpb_vc_param_value wpb-textinput '
               . $settings['param_name'] . ' ' . $settings['type'] . '_field" type="text" value="'
               . $value . '" />'
               . '</div>';
        // TODO: Add data-js-function to documentation
    }
    
?>