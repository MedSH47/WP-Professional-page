<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $width
 * @var $css
 * @var $offset
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Column
 */
$el_class = $width = $css = $offset = $bg_image_src = $pix_padding_top = $pix_padding_bottom = $pix_not_stretch_content = $pix_gradient = $pix_gradient_style = $pix_gradient_class = $pix_gradient_column_class = '';
$output = '';
$is_animate = $css_animation = $animate = $animate_data = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$width = wpb_translateColumnWidthToSpan( $width );
$width = vc_column_offset_class_merge( $offset, $width );

if($css_animation != '' && $is_animate == 'on') {
    $animate = 'animated';
    $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
    $animate_data = ' data-animation="'.esc_attr($css_animation).'"';
    $wow_delay = !empty($wow_delay) ? $wow_delay : 0;
    $animate_data .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
    $animate_data .= !empty($wow_delay) ? ' data-wow-delay="'.esc_attr($wow_delay).'s"' : '';
    $animate_data .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
    $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';
}

$class_preset_text = ($ptextcolor) ? ' text-'.strtolower($ptextcolor) : '';
if ($ptextcolor == "Default")
	$class_preset_text = "";


if ($pix_padding_top == 'padding No'){
    $pix_padding_top = '';
} elseif($pix_padding_top == 'padding S'){
    $pix_padding_top = 'pix-padding-top-s';
} elseif($pix_padding_top == 'padding M'){
    $pix_padding_top = 'pix-padding-top-m';
} elseif($pix_padding_top == 'padding L'){
    $pix_padding_top = 'pix-padding-top-l';
} elseif($pix_padding_top == 'padding XL'){
    $pix_padding_top = 'pix-padding-top-xl';
} else{
    $pix_padding_top = '';
}

if ($pix_padding_bottom == 'padding No'){
    $pix_padding_bottom = '';
} elseif($pix_padding_bottom == 'padding S'){
    $pix_padding_bottom = 'pix-padding-bottom-s';
} elseif($pix_padding_bottom == 'padding M'){
    $pix_padding_bottom = 'pix-padding-bottom-m';
} elseif($pix_padding_bottom == 'padding L'){
    $pix_padding_bottom = 'pix-padding-bottom-l';
} elseif($pix_padding_bottom == 'padding XL'){
    $pix_padding_bottom = 'pix-padding-bottom-xl';
} else{
    $pix_padding_bottom = '';
}

$pix_not_stretch_content = $pix_not_stretch_content != 'off' ? $pix_not_stretch_content : '';

$css_classes = array(
	$this->getExtraClass( $el_class ),
	'wpb_column',
	'vc_column_container',
	$width,
    $pix_not_stretch_content,
	$class_preset_text,
    $animate,
);

if (vc_shortcode_custom_css_has_property( $css, array('border', 'background') )) {
	$css_classes[]='vc_col-has-fill';
}

$gradient_colors = vc_param_group_parse_atts( $atts['gradient_colors'] );
if(isset($gradient_colors[0]['gradient_color']) && $gradient_colors[0]['gradient_color'] != ''){
    $pix_gradient_class = 'pix_gradient_colors_'.rand();
    $pix_gradient_column_class = 'pix_container_gradient';
    $gradient_direction = $gradient_direction == '' ? 'to right' : $gradient_direction;
    $gradient_angle = $gradient_angle == '' ? '90' : $gradient_angle;
    $pix_directions_arr = array(
        'to right' => array('-webkit' => 'left', '-o-linear' => 'right', '-moz-linear' => 'right', 'linear' => 'to right',),
        'to left' => array('-webkit' => 'right', '-o-linear' => 'left', '-moz-linear' => 'left', 'linear' => 'to left',),
        'to bottom' => array('-webkit' => 'top', '-o-linear' => 'bottom', '-moz-linear' => 'bottom', 'linear' => 'to bottom',),
        'to top' => array('-webkit' => 'bottom', '-o-linear' => 'top', '-moz-linear' => 'top', 'linear' => 'to top',),
        'to bottom right' => array('-webkit' => 'left top', '-o-linear' => 'bottom right', '-moz-linear' => 'bottom right', 'linear' => 'to bottom right',),
        'to bottom left' => array('-webkit' => 'right top', '-o-linear' => 'bottom left', '-moz-linear' => 'bottom left', 'linear' => 'to bottom left',),
        'to top right' => array('-webkit' => 'left bottom', '-o-linear' => 'top right', '-moz-linear' => 'top right', 'linear' => 'to top right',),
        'to top left' => array('-webkit' => 'right bottom', '-o-linear' => 'top left', '-moz-linear' => 'top left', 'linear' => 'to top left',),
        'angle' => array('-webkit' => $gradient_angle.'deg', '-o-linear' => $gradient_angle.'deg', '-moz-linear' => $gradient_angle.'deg', 'linear' => $gradient_angle.'deg',),
    
    );
    $gradient_opacity = $gradient_opacity == '' ? 1 : $gradient_opacity;
    foreach($gradient_colors as $val){
        $pix_gradient .= ','.$val['gradient_color'];
    }
    $pix_gradient_style = $pix_gradient == '' && isset($pix_directions_arr[$gradient_direction]) ? '' : '
jQuery(function($){
$("head").append("<style>.vc_row-overlay.'.$pix_gradient_class.'{background: '.esc_attr($gradient_colors[0]['gradient_color']).';background: -webkit-linear-gradient('.$pix_directions_arr[$gradient_direction]['-webkit'].esc_attr($pix_gradient).');background: -o-linear-gradient('.$pix_directions_arr[$gradient_direction]['-o-linear'].esc_attr($pix_gradient).');background: -moz-linear-gradient('.$pix_directions_arr[$gradient_direction]['-moz-linear'].esc_attr($pix_gradient).');background: linear-gradient('.$pix_directions_arr[$gradient_direction]['linear'].esc_attr($pix_gradient).');opacity:'.esc_attr($gradient_opacity).';}</style>");
});
';
}
wp_add_inline_script( 'pixtheme-common', $pix_gradient_style );

$wrapper_attributes = array();

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . ' '.wp_kses_post($animate_data).'>';

$output .= '<div class="vc_column-inner '.esc_attr($pix_gradient_column_class).' '.esc_attr($pix_padding_top).' '.esc_attr($pix_padding_bottom).' ' . esc_attr(trim(vc_shortcode_custom_css_class($css))) . '" >';

if( $pix_gradient_class != '') {
    $output .= '<span class="vc_row-overlay ' . esc_attr($pix_gradient_class) . '" ></span>';
}

$output .= '<div class="wpb_wrapper">';

$output .= wpb_js_remove_wpautop( $content );

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

if(function_exists('pix_out')){
    pix_out($output);
} else {
    echo wp_kses_post($output);
}
