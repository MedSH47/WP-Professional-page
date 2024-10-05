<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Special_Offers
 */
$href_before = $href_after = $is_animate = $css_animation = $animate = $animate_data = '';
$carousel_arr = $shadows_arr = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$carousel_arr = pixtheme_vc_get_params_array($atts, 'carousel');
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );

$shadow_class = pixtheme_get_shadow($shadows_arr);

$image_size = 'pixtheme-original-col-3';
$image_size .= pixtheme_retina() ? '-retina' : '';

$offers = vc_param_group_parse_atts( $atts['offers'] );
$offers_out = array();
$count = 1;
$cnt = count($offers);
$i = $offset = 0;
foreach($offers as $key => $item){

    if($css_animation != '' && $is_animate == 'on') {
        $animate = 'animated';
        $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
        $animate_data = ' data-animation="'.esc_attr($css_animation).'"';
        $wow_group = !empty($wow_group) ? $wow_group : 1;
        $wow_group_delay = !empty($wow_group_delay) ? $wow_group_delay : 0;
        $wow_delay = !empty($wow_delay) ? $wow_delay : 0;
        $animate_data .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
        $animate_data .= !empty($wow_delay) || $wow_group_delay > 0 ? ' data-wow-delay="'.esc_attr($wow_delay + $offset * $wow_group_delay).'s"' : '';
        $animate_data .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
        $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';

        $offset = $i % $wow_group == 0 ? ++$offset : $offset;
    }

    $image = '';
    $href = isset($item['link']) ? vc_build_link( $item['link'] ) : '';
    $target = empty($href['target']) ? '_self' : $href['target'];

    if( isset($item['image']) && $item['image'] != ''){
        $img = wp_get_attachment_image_src( $item['image'], $image_size );
        $img_output = $img[0];
        $image =  '<img src="'.esc_url($img_output).'" alt="'.esc_attr($item['title']).'">';
    }
    if(!empty( $href['url'] )){
        $href_before = '<a ' . wp_kses_post($target) . ' href="' . esc_url($href['url']) . '" class="pix-shadow-link">';
        $href_after = '</a>';
    }
    $subtitle = isset($item['subtitle']) && $item['subtitle'] != '' ? $item['subtitle'] : '';

    $class_red = $count % 2 == 0 ? 'pix-offer-slider-item-red' : '';
    $offers_out[] = '
        <div class="pix-offer-slider-item '.esc_attr($class_red).' '.esc_attr($animate).'" '.wp_kses_post($animate_data).'>
            <div class="pix-offer-img">
                '.wp_kses_post($image).'
            </div>
            <div class="pix-offer-box">
                <div class="pix-offer-box-title pix-h3">
                    '.wp_kses_post($href_before).wp_kses_post($item['title']).wp_kses_post($href_after).'
                </div>
                <div class="pix-offer-box-desc">'.wp_kses_post($subtitle).'</div>
                <div class="pix-offer-box-text">
                    '.wp_kses_post($item['content_d']).'
                </div>
            </div>
        </div>
    ';

    $count ++;
}

$options_arr = pixtheme_get_carousel($carousel_arr);
$data_carousel = empty($options_arr) ? '' : 'data-owl-options=\''.json_encode($options_arr).'\'';
$col = isset($options_arr['items']) != '' ? $options_arr['items'] : 3;
$carousel_class = !empty($options_arr) ? 'owl-carousel owl-theme' : 'disable-owl-carousel pix-col-'.esc_attr($col);


$out = '
<div class="pix-special-offer-slider '.wp_kses_post($carousel_class).' '.esc_attr($radius).' " '.wp_kses_post($data_carousel).'>

    '.implode( "\n", $offers_out ).'

</div>';


if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}
