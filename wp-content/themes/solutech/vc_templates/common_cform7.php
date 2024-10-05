<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $form_id
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Block_Cform7
 */
$css_animation = $btn_position = $radius = $box_gap = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$out = '';

$out = $css_animation != '' ? '<div class="animated pix-gap-'.esc_attr($box_gap).' '.esc_attr($radius).' '.esc_attr($btn_position).'" data-animation="' . esc_attr($css_animation) . '">' : '<div class="pix-gap-'.esc_attr($box_gap).' '.esc_attr($radius).' '.esc_attr($btn_position).'">';
$out .= do_shortcode('[contact-form-7 id="'.esc_attr($form_id).'"]');
$out .= '</div>';

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}