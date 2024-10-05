<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $image
 * @var $title
 * @var $link
 * @var $button_text
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Box_Service
 */
$css_animation = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$href = vc_build_link( $link );
$link = isset($href['url']) ? $href['url'] : ''; 

$img_id = preg_replace( '/[^\d]/', '', $image );
$img_link = wp_get_attachment_image_src( $img_id, 'large' );
$img_link = $img_link[0];
$image_meta = pixtheme_wp_get_attachment($img_id);
$image_alt = $image_meta['alt'] == '' ? $image_meta['title'] : $image_meta['alt'];	

$finalbutton = ($button_text == '') ? '': '<a href="'.esc_url($link).'" class="btn btn-default">'.esc_attr($button_text).'</a>';

$wdata = 'data-widget-id="common_feature_box" data-widget-name="C Feature Box"';
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

$out = '<div '.wp_kses_post($wdata).' '.wp_kses_post($animate).' >';
$out .= '
<div class="b-advantages">
	<div class="b-advantages__icon"><a href="'.esc_url($link).'"><img src="'.esc_url($img_link).'" alt="'.esc_attr($image_alt).'"></a></div>
    <span></span>
    <h3 class="b-advantages__title">'.wp_kses_post($title).'</h3>
    <div class="b-advantages__info">'.do_shortcode($content).'</div>
    '.$finalbutton.'

</div>
'; 
$out .= '</div>';

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}