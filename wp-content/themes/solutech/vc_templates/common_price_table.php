<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $typetable
 * @var $monthtext
 * @var $yeartext
 * @var $monthshort
 * @var $yearshort
 * @var $currency
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Price_Table
 */
$style = $compare_features = $features_title = $features_subtitle = $btn_position = $btntext = $radius = $is_animate = $css_animation = $animate = $animate_data = $box_gap = '';
$shadows_arr = array();

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );

$shadow_class = pixtheme_get_shadow($shadows_arr);
$compare_features = isset($compare_features) ? explode("\n", strip_tags($compare_features)) : array();
$prices = vc_param_group_parse_atts( $atts['prices'] );
$prices_out = array();
$count = 1;
$cnt = count($prices);
$i = $offset = 0;
if( $style != 'pix-price-table' || count($compare_features) == 0 ) {
    foreach ($prices as $key => $item) {
        
        if ($css_animation != '' && $is_animate == 'on') {
            $animate = 'animated';
            $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
            $animate_data = ' data-animation="' . esc_attr($css_animation) . '"';
            $wow_group = !empty($wow_group) ? $wow_group : 1;
            $wow_group_delay = !empty($wow_group_delay) ? $wow_group_delay : 0;
            $wow_delay = !empty($wow_delay) ? $wow_delay : 0;
            $animate_data .= !empty($wow_duration) ? ' data-wow-duration="' . esc_attr($wow_duration) . 's"' : '';
            $animate_data .= !empty($wow_delay) || $wow_group_delay > 0 ? ' data-wow-delay="' . esc_attr($wow_delay + $offset * $wow_group_delay) . 's"' : '';
            $animate_data .= !empty($wow_offset) ? ' data-wow-offset="' . esc_attr($wow_offset) . '"' : '';
            $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="' . esc_attr($wow_iteration) . '"' : '';
            
            $offset = $i % $wow_group == 0 ? ++$offset : $offset;
        }
        
        $image = '';
        
        $class = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'pix-price-box-big' : '';
        $class_button = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'pix-dark' : '';
        
        $href = isset($item['link']) ? vc_build_link($item['link']) : '';
        $url = empty($href['url']) ? '#' : $href['url'];
        $target = empty($href['target']) ? '' : 'target="' . esc_attr($href['target']) . '"';
        $id_product = isset($item['id_product']) && is_numeric($item['id_product']) != '' ? (int)$item['id_product'] : '';
        
        $show_icon = '';
        if($style == 'pix-price-long') {
            $icon_type = $item['type'];
            $icon = isset( $item['icon_'.$icon_type] ) ? $item['icon_'.$icon_type] : '';
            if ($item['icon_type'] == 'image' && isset($item['image']) && $item['image'] != '') {
                $img_id = preg_replace('/[^\d]/', '', $item['image']);
                $img_path = wp_get_attachment_image_src($img_id, 'thumbnail');
                $show_icon = '<div class="pix-icon"><img src="' . esc_url($img_path[0]) . '" alt="' . esc_attr($item['title']) . '"></div>';
            } else {
                $show_icon = '<div class="pix-icon"><span class="' . esc_attr($icon) . '" ></span></div>';
            }
        }
        
        $title = isset($item['title']) && $item['title'] != '' ? '<p>' . wp_kses_post($item['title']) . '</p>' : '';
        $subtitle = isset($item['subtitle']) && $item['subtitle'] != '' ? '<span>' . wp_kses_post($item['subtitle']) . '</span>' : '';
        $price = isset($item['first_price']) && $item['first_price'] != '' ? wp_kses_post($item['first_price']) : '';
        $price_text = isset($item['price_text']) && $item['price_text'] != '' ? '<span class="pix-span-period"> / ' . wp_kses_post($item['price_text']) . '</span>' : '';
        $currency_sign = isset($item['first_price']) && is_numeric($item['first_price']) ? '<span class="pix-span-small">' . wp_kses_post($currency) . '</span>' : '';
        $btntext_box = isset($item['btntext_box']) && $item['btntext_box'] != '' ? $item['btntext_box'] : $btntext;
        if(class_exists('WooCommerce') && $id_product > 0){
            $button = $btntext_box != '' && $url != '' ? '<a class="pix-button ' . esc_attr($class_button) . '" ' . wp_kses_post($target) . ' href="' . esc_url(get_permalink( wc_get_page_id( 'checkout' ) ).'?add-to-cart='.$id_product) . '">' . wp_kses_post($btntext_box) . '</a>' : '';
        } else {
            $button = $btntext_box != '' && $url != '' ? '<a class="pix-button ' . esc_attr($class_button) . '" ' . wp_kses_post($target) . ' href="' . esc_url($url) . '">' . wp_kses_post($btntext_box) . '</a>' : '';
        }
        $price_features = isset($item['price_features']) ? explode("\n", strip_tags($item['price_features'])) : array();
        $price_features = array_map('trim', $price_features);
        $price_features_html = '';
        
        if (count($compare_features) > 0 && $compare_features[0] != '' && count($price_features) > 0) {
            foreach ($compare_features as $val_comp) {
                if (!empty($val_comp)) {
                    $enable_class = in_array(trim($val_comp), $price_features) ? 'pix-enable' : 'pix-disable';
                    $price_features_html .= '<li class="' . esc_attr($enable_class) . '">' . wp_kses_post($val_comp) . '</li>';
                }
            }
            $price_features_html = '<ul class="pix-table-price-content-list pix-compare">' . ($price_features_html) . '</ul>';
        } elseif (count($price_features) > 1) {
            foreach ($price_features as $val) {
                if (!empty($val)) $price_features_html .= '<li>' . wp_kses_post($val) . '</li>';
            }
            $price_features_html = '<ul class="pix-table-price-content-list">' . ($price_features_html) . '</ul>';
        } elseif(isset($price_features[0])) {
            $price_features_html = '<p>' . ($price_features[0]) . '</p>';
        }
        $price_content_html = isset($item['price_content']) ? '<p class="pix-price-table-features-info">' . $item['price_content'] . '</p>' : '';
        
        if ($style != 'pix-price-long') {
            
            $prices_out[] = '
            <div class="pix-price-box ' . esc_attr($class) . ' ' . esc_attr($shadow_class) . ' ' . esc_attr($animate) . '" ' . wp_kses_post($animate_data) . ' >
                <div class="pix-price-box-inner">
                    <div class="pix-price-box-top">
                        ' . wp_kses_post($title) . '
                        ' . wp_kses_post($subtitle) . '
                    </div>
                    <div class="pix-price-box-month">
                        ' . wp_kses_post($currency_sign) . ' <span class="pix-span-big">' . wp_kses_post($price) . '</span>' . wp_kses_post($price_text) . '
                    </div>
                    <div class="pix-price-box-text">
                        ' . wp_kses_post($price_features_html) . '
                        ' . wp_kses_post($price_content_html) . '
                    </div>
                    <div class="pix-price-box-footer">
                        ' . wp_kses_post($button) . '
                    </div>
                </div>
            </div>';
            
        } else {
            
            $prices_out[] = '
            <div class="pix-price-box ' . esc_attr($class) . ' ' . esc_attr($shadow_class) . ' ' . esc_attr($animate) . '" ' . wp_kses_post($animate_data) . ' >
                <div class="pix-price-box-inner">
                    <div class="pix-price-box-left">
                        ' . wp_kses_post($title) . '
                        ' . wp_kses_post($subtitle) . '
                        ' . wp_kses_post($price_features_html) . '
                        ' . wp_kses_post($price_content_html) . '
                    </div>
                    <div class="pix-price-box-right">
                        <div class="pix-price-header">
                            <div class="pix-price">' . wp_kses_post($currency_sign) . ' <span class="pix-span-big">' . wp_kses_post($price) . '</span>' . wp_kses_post($price_text) . '</div>
                            '.($show_icon).'
                        </div>
                        ' . wp_kses_post($button) . '
                    </div>
                </div>
            </div>';
            
        }
        
        $count++;
    }
    
    $style = $style == 'pix-price-box' ? 'pix-price-box-container' : $style;
    $out = '
    <div class="' . esc_attr($style) . ' row no-gutters pix-gap-' . esc_attr($box_gap) . ' ' . esc_attr($radius) . '">
        ' . implode("\n", $prices_out) . '
    </div>';
    
} else {
    
    $table_arr = $table_mobile_arr = array();
    $i = 0;
    $table_head = $table_body = $table_foot = $mobile_select = '';
    
    foreach ($prices as $key => $item) {
        
        $class = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'pix-price-box-big' : '';
        $class_title = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'pix-popular' : '';
        $class_button = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'pix-dark' : '';
        $mobile_selected = isset($item['is_popular']) && $item['is_popular'] == 'on' ? 'selected="selected"' : '';
        $mobile_cell_class = isset($item['is_popular']) && $item['is_popular'] == 'on' ? '' : 'pix-hide-mobile';
    
        $href = isset($item['link']) ? vc_build_link($item['link']) : '';
        $url = empty($href['url']) ? '#' : $href['url'];
        $target = empty($href['target']) ? '' : 'target="' . esc_attr($href['target']) . '"';
        $id_product = isset($item['product_id']) && is_numeric($item['id_product']) != '' ? (int)$item['id_product'] : '';
    
        $title = isset($item['title']) && $item['title'] != '' ? '<div class="pix-price-table-col-title ' . esc_attr($class_title) . '">' . wp_kses_post($item['title']) . '</div>' : '';
        $title_mobile = isset($item['title']) && $item['title'] != '' ? $item['title'] : '';
        $price = isset($item['first_price']) && $item['first_price'] != '' ? wp_kses_post($item['first_price']) : '';
        $price_text = isset($item['price_text']) && $item['price_text'] != '' ? '<span class="pix-span-period"> / ' . wp_kses_post($item['price_text']) . '</span>' : '';
        $price_text_mobile = isset($item['price_text']) && $item['price_text'] != '' ? ' / ' . wp_kses_post($item['price_text']) : '';
        $currency_sign = isset($item['first_price']) && is_numeric($item['first_price']) ? '<span class="pix-span-small">' . wp_kses_post($currency) . '</span>' : '';
        $currency_sign_mobile = isset($item['first_price']) && is_numeric($item['first_price']) ? $currency : '';
        $btntext_box = isset($item['btntext_box']) && $item['btntext_box'] != '' ? $item['btntext_box'] : $btntext;
        if(class_exists('WooCommerce') && $id_product > 0){
            $button = $btntext_box != '' && $url != '' ? '<a class="pix-button ' . esc_attr($class_button) . '" ' . wp_kses_post($target) . ' href="' . esc_url(get_permalink( wc_get_page_id( 'checkout' ) ).'?add-to-cart='.$id_product) . '">' . wp_kses_post($btntext_box) . '</a>' : '';
        } else {
            $button = $btntext_box != '' && $url != '' ? '<a class="pix-button ' . esc_attr($class_button) . '" ' . wp_kses_post($target) . ' href="' . esc_url($url) . '">' . wp_kses_post($btntext_box) . '</a>' : '';
        }
        $price_features = isset($item['price_features']) ? explode("\n", strip_tags($item['price_features'])) : array();
        $price_features = array_map('trim', $price_features);
        
        if( $btn_position == 'pix-header' ) {
            $button = $btntext_box != '' && $url != '' ? '<a class="pix-button pix-v-s pix-h-s ' . esc_attr($class_button) . '" ' . wp_kses_post($target) . ' href="' . esc_url($url) . '">' . wp_kses_post($btntext_box) . '</a>' : '';
            $table_arr[$features_title][$i] =
                '<div class="pix-price-table-header with-button">
                    ' . wp_kses_post($currency_sign) . ' <span class="pix-span-big">' . wp_kses_post($price) . '</span>' . wp_kses_post($price_text) . '
                </div>'
                .$title
                .$button;
        } else {
            $table_arr[$features_title][$i] =
                '<div class="pix-price-table-header">
                    ' . wp_kses_post($currency_sign) . ' <span class="pix-span-big">' . wp_kses_post($price) . '</span>' . wp_kses_post($price_text) . '
                </div>'
                .$title;
        }
        
        $mobile_select .= '<option value="'.esc_attr($i+1).'" '.wp_kses_post($mobile_selected).'>'.wp_kses_post($title_mobile.' - '.$currency_sign_mobile.$price.$price_text_mobile).'</option>';
        $table_mobile_arr[$i] = $mobile_cell_class;
    
        if (count($price_features) > 0) {
            foreach ($compare_features as $val_comp) {
                if (!empty($val_comp)) {
                    $enable_class = in_array(trim($val_comp), $price_features) ? 'pix-enable' : 'pix-disable';
                    $table_arr[$val_comp][$i] = '<span class="' . esc_attr($enable_class) . '"></span>';
                }
            }
        }
        
        if( $btn_position != 'pix-header' ) {
            $table_arr['buttons'][$i] = $button;
        }
    
        $i++;
    
    }
    
    $i = 0;
    foreach($table_arr as $key => $val){
        if($i == 0){
            $table_head .= '<tr>';
            $table_head .= '
                <th class="pix-hide-mobile-cell">
                    <div class="pix-price-table-header">
                        <span class="pix-span-big">'.$key.'</span>
                    </div>
                    <div class="pix-price-table-col-title">
                        ' . wp_kses_post($features_subtitle) . '
                    </div>
                </th>';
            $j = 0;
            foreach($val as $key_td => $val_td){
                $table_head .= '<th colspan="1" class="'.esc_attr($table_mobile_arr[$j]).'">'.$val_td.'</th>';
                $j++;
            }
            $table_head .= '</tr>';
        } elseif($key == 'buttons') {
            $table_foot .= '<tfoot><tr>';
            $table_foot .= '<td class="pix-hide-mobile-cell"></td>';
            $j = 0;
            foreach($val as $key_td => $val_td){
                $table_foot .= '<td colspan="1" class="'.esc_attr($table_mobile_arr[$j]).'">'.$val_td.'</td>';
                $j++;
            }
            $table_foot .= '</tr></tfoot>';
        } else {
            $table_body .= '<tr>';
            $table_body .= '<td>'.$key.'</td>';
            $j = 0;
            foreach($val as $key_td => $val_td){
                $table_body .= '<td class="'.esc_attr($table_mobile_arr[$j]).'">'.$val_td.'</td>';
                $j++;
            }
            $table_body .= '</tr>';
        }
        
        $i++;
    }
        
        $out = '
    <div class="pix-table-viewport ' . esc_attr($radius) . '">
        <div class="pix-compare-table">
            <select class="pix-mobile-table-select">' . ($mobile_select) . '</select>
            <table class="pix-price-compare-table">
                <thead>
                ' . wp_kses_post($table_head) . '
                </thead>
                <tbody>
                ' . wp_kses_post($table_body) . '
                </tbody>
                ' . wp_kses_post($table_foot) . '
            </table>
        </div>
    </div>';

}

 
if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}