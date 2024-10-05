<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Slider
 */
$is_animate = $css_animation = $animate = $animate_data = '';
$carousel_arr = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$carousel_arr = pixtheme_vc_get_params_array($atts, 'carousel');
extract( $atts );


$options_arr = pixtheme_get_carousel($carousel_arr);
$carousel_tablet = isset($options_arr['tablet']) && !$options_arr['tablet'] ? ' pix-tablet-carousel-off' : '';
unset($options_arr['tablet']);
$carousel_mobile = isset($options_arr['mobile']) && !$options_arr['mobile'] ? ' pix-mobile-carousel-off' : '';
unset($options_arr['mobile']);
$nav_class = isset($options_arr['nav']) && $options_arr['nav'] == 1 ? 'pix-nav-carousel' : '';
$data_carousel = empty($options_arr) ? '' : 'data-owl-options=\''.json_encode($options_arr).'\'';
$col = isset($options_arr['items']) != '' ? $options_arr['items'] : 3;
$carousel_class = !empty($options_arr) ? 'owl-carousel owl-theme' : 'disable-owl-carousel pix-col-'.esc_attr($col);

$i = $offset = 0;
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

$out = '
<div class="'.esc_attr($carousel_class.$carousel_tablet.$carousel_mobile).' '.esc_attr($nav_class).'" '.wp_kses_post($data_carousel).'>

    '.do_shortcode($content).'

</div>';


if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}
