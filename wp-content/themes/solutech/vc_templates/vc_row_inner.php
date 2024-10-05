<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $el_class
 * @var $css
 * @var $el_id
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row_Inner
 */
$el_class = $equal_height = $content_placement = $css = $el_id = $bg_image_src = $pix_gradient = $pix_gradient_style = $pix_gradient_class = $pix_padding_top = $pix_padding_bottom = $radius = '';
$disable_element = '';
$output = $after_output = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$class_preset_text = ($ptextcolor) ? ' text-'.strtolower($ptextcolor) : '';
if ($ptextcolor == "Default")
	$class_preset_text = "";


if ($pix_padding_top == 'padding No'){
    $pix_padding_top = 'pix-top-no-padding';
} elseif($pix_padding_top == 'padding S'){
    $pix_padding_top = 'pix-padding-top-s';
} elseif($pix_padding_top == 'padding M'){
    $pix_padding_top = 'pix-padding-top-m';
} elseif($pix_padding_top == 'padding L'){
    $pix_padding_top = 'pix-padding-top-l';
} elseif($pix_padding_top == 'padding XL'){
    $pix_padding_top = 'pix-padding-top-xl';
} else{
    $pix_padding_top = 'pix-padding-top-l';
}

if ($pix_padding_bottom == 'padding No'){
    $pix_padding_bottom = 'pix-bottom-no-padding';
} elseif($pix_padding_bottom == 'padding S'){
    $pix_padding_bottom = 'pix-padding-bottom-s';
} elseif($pix_padding_bottom == 'padding M'){
    $pix_padding_bottom = 'pix-padding-bottom-m';
} elseif($pix_padding_bottom == 'padding L'){
    $pix_padding_bottom = 'pix-padding-bottom-l';
} elseif($pix_padding_bottom == 'padding XL'){
    $pix_padding_bottom = 'pix-padding-bottom-xl';
} else{
    $pix_padding_bottom = 'pix-padding-bottom-l';
}


$pix_offset_class = '';
if(isset($top_offset) && $overflow == 'on'){
    $pix_offset_class = 'pix-top-offset_'.rand();
    $pix_top_offset = 'jQuery(function($){$("head").append("<style>.'.esc_attr($pix_offset_class).'.pix-row-overflow{z-index:1;top:'.esc_attr($top_offset).';}</style>");});';
    wp_add_inline_script( 'pixtheme-common', $pix_top_offset );
}

$overflow = $overflow == 'on' ? 'pix-row-overflow' : '';


$el_class = $this->getExtraClass( $el_class );
$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_inner',
	'vc_row-fluid',
	$el_class,
    $pix_padding_top,
    $pix_padding_bottom,
	$overflow,
	$pix_offset_class,
	$class_preset_text,
	$radius,
	vc_shortcode_custom_css_class( $css ),
);

if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}

if ( vc_shortcode_custom_css_has_property( $css, array(
	'border',
	'background',
) ) ) {
	$css_classes[] = 'vc_row-has-fill';
}

if ( ! empty( $atts['gap'] ) ) {
	$css_classes[] = 'vc_column-gap-' . $atts['gap'];
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-equal-height';
}

if ( ! empty( $atts['rtl_reverse'] ) ) {
	$css_classes[] = 'vc_rtl-columns-reverse';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_row-flex';
}


$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}

$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( $css_classes ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';

$output .= '<div ' . implode( ' ', $wrapper_attributes ) . '>';

$gradient_colors = vc_param_group_parse_atts( $atts['gradient_colors'] );
if(isset($gradient_colors[0]['gradient_color']) && $gradient_colors[0]['gradient_color'] != ''){
	$pix_gradient_class = 'pix_gradient_colors_'.rand();
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
    $("head").append("<style> .vc_row-overlay.'.$pix_gradient_class.' { background: '.esc_attr($gradient_colors[0]['gradient_color']).'; background: -webkit-linear-gradient('.$pix_directions_arr[$gradient_direction]['-webkit'].esc_attr($pix_gradient).'); background: -o-linear-gradient('.$pix_directions_arr[$gradient_direction]['-o-linear'].esc_attr($pix_gradient).'); background: -moz-linear-gradient('.$pix_directions_arr[$gradient_direction]['-moz-linear'].esc_attr($pix_gradient).'); background: linear-gradient('.$pix_directions_arr[$gradient_direction]['linear'].esc_attr($pix_gradient).'); opacity: '.esc_attr($gradient_opacity).'}</style>");
});
';
}
wp_add_inline_script( 'pixtheme-custom', $pix_gradient_style );
if( $pix_gradient_class != '') {
	$output .= '<span class="vc_row-overlay ' . esc_attr($pix_gradient_class) . '" ></span>';
}else {
	preg_match_all('/{([^\}]+)/i', $css, $matches, PREG_OFFSET_CAPTURE);
	if (isset($matches[1][0][0])) {
		foreach (explode(';', $matches[1][0][0]) as $val) {
			if (substr_count($val, 'background') > 0 && substr_count($val, 'rgba') > 0 && substr_count($val, 'url') > 0) {
				foreach (explode(' ', $val) as $val_exp) {
					if (substr_count($val_exp, 'rgba') > 0) {
						$output .= '<span class="vc_row-overlay" style="background-color: ' . $val_exp . ' !important;"></span>';
					}
				}
			}
		}
	}
}

$output .= wpb_js_remove_wpautop( $content );


$output .= '</div>';
$output .= $after_output;

if(function_exists('pix_out')){
    pix_out($output);
} else {
    echo wp_kses_post($output);
}
