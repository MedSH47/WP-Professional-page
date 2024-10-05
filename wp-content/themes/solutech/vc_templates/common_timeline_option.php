<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Timeline_Option
 */

$is_animate = $css_animation = $animate = $animate_data = $title = $type = $image = $date = '';
$out = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$img_id = preg_replace( '/[^\d]/', '', $image );
$img_link = wp_get_attachment_image_src( $img_id, 'full' );
$img_link = $img_link[0];

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

if ( $type == 'right' ) :

$out .= '
	<div class="row right-row '.esc_attr($animate).'" '.wp_kses($animate_data, 'post').'>
		<div class="round-ico big"></div>
		<div class="col-md-6 col-sm-6"></div>
		<div class="col-md-6 col-sm-6 time-item">
			<div class="date">'.wp_kses_post($date).'</div>
			<div class="title">'.wp_kses_post($title).'</div>';
if ( $img_link != '' ) :
	$out .= '
			<div class="time-image">
				<img src="'.esc_url($img_link).'" alt="'.esc_attr($title).'" >
			</div>';
endif;
$out .= '
			<div class="time-content">'.do_shortcode($content).'</div>
		</div>
	</div>';

else :

$out .= '
	<div class="row left-row '.esc_attr($animate).'" '.wp_kses($animate_data, 'post').'>
		<div class="round-ico little"></div>
		<div class="col-md-6 col-sm-6 time-item" data-wow-duration="2s" >
			<div class="date">'.wp_kses_post($date).'</div>
			<div class="title">'.wp_kses_post($title).'</div>
';
if ( $img_link != '' ) :
	$out .= '
			<div class="time-image">
				<img src="'.esc_url($img_link).'" alt="'.esc_attr($title).'" >
			</div>';
endif;
$out .= '
			<div class="time-content">'.do_shortcode($content).'</div>
		</div>
	</div>';

endif;

echo $out;