<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Progress
 */
$out = $css_animation = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$atts = $this->convertAttributesToNewProgressBar( $atts );

extract( $atts );

$wdata = 'data-widget-id="common_progress" data-widget-name="R Progress Bar"';
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

$out .= '<div class="pix-progress-bar-section">';

$values = (array) vc_param_group_parse_atts( $values );
$max_value = 0.0;
$graph_lines_data = array();
foreach ( $values as $data ) {
	$new_line = $data;
	$new_line['value'] = isset( $data['value'] ) ? $data['value'] : 0;
	$new_line['label'] = isset( $data['label'] ) ? $data['label'] : '';

	if ( $max_value < (float) $new_line['value'] ) {
		$max_value = $new_line['value'];
	}
	$graph_lines_data[] = $new_line;
}

foreach ( $graph_lines_data as $line ) {
	if ( $max_value > 100.00 ) {
		$percentage_value = (float) $line['value'] > 0 && $max_value > 100.00 ? round( (float) $line['value'] / $max_value * 100, 4 ) : 0;
	} else {
		$percentage_value = $line['value'];
	}
	$out .= '
        <div class="pix-progressbar-box" data-percent="'.esc_attr( $percentage_value ).'">
            <div class="row">
                <div class="col-6">'.wp_kses_post($line['label']).'</div>
                <div class="col-6 text-right">'.esc_attr( $line['value'] ).'%</div>
            </div>
            <div class="pix-progressbar-line">
                <div class="pix-progressbar-full-line" style="width: '.esc_attr( $line['value'] ).'%;"></div>
            </div>
        </div>';
}

$out .= '</div>';

$out .= '</div>';

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}