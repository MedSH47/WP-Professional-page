<?php

	$carousel = array(
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Carousel', 'solutech' ),
            'param_name' => 'carousel',
            'value' => 'on',
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'on Tablet', 'solutech' ),
            'param_name' => 'carousel_tablet',
            'value' => 'on',
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'on Mobile', 'solutech' ),
            'param_name' => 'carousel_mobile',
            'value' => 'on',
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Items per Page', 'solutech' ),
            'param_name' => 'carousel_items',
            'value' => array(1,2,3,4,5,6,7,8,9,10),
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'on Tablet', 'solutech' ),
            'param_name' => 'carousel_items_tablet',
            'value' => array(1,2,3,4,5,6,7,8,9,10),
            'std' => '2',
            'description' => '',
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'on Mobile', 'solutech' ),
            'param_name' => 'carousel_items_mobile',
            'value' => array(1,2,3,4,5,6,7,8,9,10),
            'std' => '1',
            'description' => '',
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Pagination', 'solutech' ),
            'param_name' => 'carousel_dots',
            'value' => 'on',
            'description' => esc_html__( 'Pagination dots ...', 'solutech' ),
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Navigation', 'solutech' ),
            'param_name' => 'carousel_nav',
            'value' => 'off',
            'description' => esc_html__( 'Navigation arrows < >', 'solutech' ),
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Loop', 'solutech' ),
            'param_name' => 'carousel_loop',
            'value' => 'off',
            'description' => esc_html__( 'Infinity loop', 'solutech' ),
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Margin', 'solutech' ),
            'param_name' => 'carousel_margin',
            'value' => '',
            'description' => esc_html__( 'margin-right(px) on item', 'solutech' ),
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'on Tablet', 'solutech' ),
            'param_name' => 'carousel_margin_tablet',
            'value' => '',
            'description' => '',
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'on Mobile', 'solutech' ),
            'param_name' => 'carousel_margin_mobile',
            'value' => '',
            'description' => '',
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Padding', 'solutech' ),
            'param_name' => 'carousel_stagepadding',
            'value' => '',
            'description' => esc_html__( 'Padding left and right on stage', 'solutech' ),
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'on Tablet', 'solutech' ),
            'param_name' => 'carousel_stagepadding_tablet',
            'value' => '',
            'description' => '',
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => esc_html__( 'on Mobile', 'solutech' ),
            'param_name' => 'carousel_stagepadding_mobile',
            'value' => '',
            'description' => '',
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'edit_field_class' => 'vc_col-sm-4',
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'range_slider',
            'heading' => esc_html__( 'Speed', 'solutech' ),
            'param_name' => 'carousel_speed',
            'value' => array(
                'default' => '1000',
                'min' => '0',
                'max' => '10000',
                'step' => '100',
                'unit' => 'ms',
            ),
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'switch_button',
            'heading' => esc_html__( 'Autoplay', 'solutech' ),
            'param_name' => 'carousel_autoplay',
            'value' => 'off',
            'dependency' => array(
                'element' => 'carousel',
                'value' => 'on'
            ),
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
        array(
            'type' => 'range_slider',
            'heading' => esc_html__( 'Autoplay Speed', 'solutech' ),
            'param_name' => 'carousel_autoplaySpeed',
            'value' => array(
                'default' => '1000',
                'min' => '0',
                'max' => '10000',
                'step' => '100',
                'unit' => 'ms',
            ),
            'dependency' => array(
                'element' => 'carousel_autoplay',
                'value' => 'on'
            ),
            'group' => esc_html__( 'Carousel', 'solutech' ),
        ),
    );

	vc_add_params( 'common_slider', $carousel );
	vc_add_params( 'common_special_offers', $carousel );
	vc_add_params( 'common_team', $carousel );
    vc_add_params( 'common_reviews', $carousel );
    vc_add_params( 'common_posts_block', $carousel );
    vc_add_params( 'common_brands', $carousel );
    vc_add_params( 'common_woocommerce', $carousel );

    function pixtheme_get_carousel($carousel_arr, $animation_func = ''){
        $options_arr = array();

        if( isset($carousel_arr['carousel']) && $carousel_arr['carousel'] == 'on' ) {
            unset($carousel_arr['carousel']);
            $stagepadding_tablet = $stagepadding_mobile = $margin_tablet = $margin_mobile = 0;
            $items_tablet = 2;
            $items_mobile = 1;
            foreach ($carousel_arr as $key => $val) {
                $option = str_replace('carousel_', '', $key);
                if ($option == 'speed') {
                    $options_arr['navSpeed'] = (int)$val;
                    $options_arr['dotsSpeed'] = (int)$val;
                } elseif ($option == 'animation' && $val == 'on') {
                    $options_arr['onTranslate'] = $animation_func;
                } elseif ($option == 'items_tablet') {
                    $items_tablet = (int)$val;
                } elseif ($option == 'items_mobile') {
                    $items_mobile = (int)$val;
                } elseif ($option == 'margin') {
                    $options_arr[$option] = (int)$val;
                } elseif ($option == 'margin_tablet') {
                    $margin_tablet = (int)$val;
                } elseif ($option == 'margin_mobile') {
                    $margin_mobile = (int)$val;
                } elseif ($option == 'stagepadding') {
                    $options_arr['stagePadding'] = (int)$val;
                } elseif ($option == 'stagepadding_tablet') {
                    $stagepadding_tablet = (int)$val;
                } elseif ($option == 'stagepadding_mobile') {
                    $stagepadding_mobile = (int)$val;
                } elseif ( $val == 'on' || $val == 'off' ) {
                    $options_arr[$option] = $val == 'on' ? true : false;
                } else {
                    $options_arr[$option] = $val;
                }
            }
            $options_arr['autoWidth'] = false;
            $options_arr['responsiveClass'] = true;
            $options_arr['responsive'] = array(
                '0' => array(
                    'items' => (int)$items_mobile,
                    'margin' => (int)$margin_mobile,
                    'stagePadding' => (int)$stagepadding_mobile,
                    'autoWidth' => false,
                ),
                '576' => array(
                    'items' => (int)$items_tablet,
                    'margin' => (int)$margin_tablet,
                    'stagePadding' => (int)$stagepadding_tablet,
                    'autoWidth' => false,
                ),
                '1025' => array(
                    'items' => isset($options_arr['items']) ? (int)$options_arr['items'] : 3,
                    'margin' => isset($options_arr['margin']) ? (int)$options_arr['margin'] : 0,
                    'stagePadding' => isset($options_arr['stagePadding']) ? (int)$options_arr['stagePadding'] : 0,
                    'autoWidth' => false,
                )
            );
            $options_arr['navText'] = array('&lt;i class="fas fa-chevron-left"&gt;&lt;/i&gt;', '&lt;i class="fas fa-chevron-right"&gt;&lt;/i&gt;');
        }

        return $options_arr;
    }

?>