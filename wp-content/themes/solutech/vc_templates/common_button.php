<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $title_before
 * @var $show_decor
 * @var $color
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Button
 */
$size_h = $size_v = $radius = '';
$shadows_arr = array();
$position = 'pix-text-left';
$font_size = 'pix-font-m';
$button_type = 'off';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );

$shadow_class = pixtheme_get_shadow($shadows_arr);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$href = isset($link) ? vc_build_link( $link ) : '';
$blank = empty($href['target']) ? '_self' : $href['target'];
$href = empty($href['url']) ? '#' : $href['url'];

$color = $color == '' || $color == 'default' ? '' : $color;
$transparent = ($transparent == 'off') ? '' : 'pix-transparent';
$button_class = ($button_type == 'on') ? 'pix-link' : 'pix-button';

$out = '
	<div class="pix-button-container ' . esc_attr($css_class) . ' ' . esc_attr($position) . ' ">
		<a target="'.esc_attr($blank).'" href="'.esc_url($href).'" class="'.esc_attr($button_class).' '.esc_attr($font_size).' '.esc_attr($size_h).' '.esc_attr($size_v).' '.esc_attr($transparent).' '.esc_attr($color).' '.esc_attr($radius).' '.esc_attr($shadow_class).'">'.wp_kses_post($text).'</a>
	</div>
'.$this->endBlockComment('common_button');

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}