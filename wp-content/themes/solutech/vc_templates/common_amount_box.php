<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Box_Amount
 */
$css_animation = $icon_type = $icon = $icon_shape = $show_icon = $show_icon_right = $hover_class = $content_position = '';
$icon_size = 'pix-icon-l';
$icon_color = 'pix-icon-color';
$position = 'pix-text-center';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


$css_classes = array(
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts );

if($icon_type == 'font')
    $icon = isset(${"icon_" . $type}) ? ${"icon_" . $type} : '';


if($icon_type == 'image' && isset($image) && $image != ''){
	$img_id = preg_replace( '/[^\d]/', '', $image );
    $img_path = wp_get_attachment_image_src( $img_id, 'thumbnail' );
	$show_icon = '<div class="icon"><img src="'.esc_url($img_path[0]).'" alt="'.esc_attr($title).'"></div>';
} elseif($icon != '') {
	$show_icon = '<div class="icon "><span class="'.esc_attr($icon).'" ></span></div>';
}

if($position == 'pix-text-right'){
    $show_icon_right = $show_icon;
    $show_icon = '';
}

if($show_icon_right == $show_icon){
    $icon_size = 'pix-no-icon';
}

$final_content = ($content == '') ? '' : '<p>'.do_shortcode($content).'</p>';

$wdata = 'data-widget-id="common_amount_box" data-widget-name="Amount Box"';
$animate = '';
if($css_animation != '') {
	$animate = 'class="';
	$animate .= 'animated';
	$animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
	$animate .= '"';
	$animate .= ' data-animation="'.esc_attr($css_animation).'"';
	$animate .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
	$animate .= !empty($wow_delay) ? ' data-wow-delay="'.esc_attr($wow_delay).'s"' : '';
	$animate .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
	$animate .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';
}

$out = '<div class="' . esc_attr($css_class) . '" '.wp_kses_post($wdata).' '.wp_kses_post($animate).' >';
$out .= '
<div class="stats pix-easy-chart">
	<div class="counter-item '.esc_attr($position).' '.esc_attr($icon_size).' '.esc_attr($icon_color).'">
	    '.wp_kses_post($show_icon).'
		<div class="chart " data-percent="'.esc_attr($amount).'">
            <span class="percent">'.wp_kses_post($amount).'</span>
            <span class="percent-plus">+</span>
            <div class="percent-text">'.wp_kses_post($title).'</div>
            <canvas height="0" width="0"></canvas>
	    </div>
	    '.wp_kses_post($show_icon_right).'
    </div>
    '.wp_kses_post($final_content).'
</div>			

	';  
$out .= '</div>'.$this->endBlockComment('common_amount_box');

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}