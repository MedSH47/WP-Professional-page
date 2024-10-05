<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Title
 */
$out = $css = $pix_not_stretch_content = $no_wrap = $is_animate = $css_animation = $animate = $animate_data = $pix_class = '';
$padding = 'on';
$size = 'pix-l';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$padding = $padding == 'off' ? 'pix-title-no-padding' : '';
$pix_not_stretch_content = $pix_not_stretch_content != 'off' ? $pix_not_stretch_content : '';

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

$css_classes = array(
	$size,
	$padding,
	$pix_not_stretch_content,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts );

$no_wrap = ($no_wrap != 'on') ? '' : 'pix-no-wrap';
$subtitle = ($subtitle == '') ? '' : '<div class="pix-pre-title"><span>'.wp_kses_post($subtitle).'</span></div>';
$final_content = ($content == '') ? '' : '<p>'.do_shortcode($content).'</p>';
$show_decor = ($show_decor == 'off') ? '' : '<span class="sep-element"></span>';
$title = ($title == '') ? '' : '<h2 class="pix-title-h2  '.esc_attr($no_wrap).'">'.wp_kses_post($title).wp_kses_post($show_decor).'</h2>';

$out = '
	<div class="pix-section-title ' . esc_attr($css_class) . ' ' . esc_attr($position) . ' ' . esc_attr($color) . ' ' . esc_attr($pix_class) . ' '.esc_attr($animate).'" '.wp_kses_post($animate_data).'>
		'.wp_kses_post($subtitle).'
		'.wp_kses_post($title).'
		'.wp_kses_post($final_content).'
	</div>
'.$this->endBlockComment('common_title');

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}