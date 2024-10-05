<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Section_Timeline
 */

$is_animate = $css_animation = $animate = $animate_data = $count = '';
$out = '';
$per_page_count = $count_group = '';
$count_item = 0;
$out_cont = array();
$out_cont_2 = array();

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$section_cont = explode( '[/common_timeline_option]', $content );
array_pop($section_cont);
if( is_array($section_cont) && !empty($section_cont) ) {
	foreach( $section_cont as $option ) {
		$out_cont[$count_item] = '';
		$out_cont[$count_item] .= do_shortcode($option.'[/common_timeline_option]');
		$count_item++;
	}
}

$per_page_count = is_numeric($count) && $count > 0 ? $count : $count_item;

$count_group = ceil( $count_item / $per_page_count );
if ( $count_group && is_array($out_cont) && !empty( $out_cont ) ) {
	for ( $i = 0; $i < $count_group; $i++ ) {
		$out_cont_2[$i] = '';
		for ( $j = 0; $j < $per_page_count; $j++ ) {
			if ( ! isset($out_cont[$per_page_count*$i + $j]) ) { $out_cont[$per_page_count*$i + $j] = ''; }
			$out_cont_2[$i] .= $out_cont[$per_page_count*$i + $j];
		}

	}
}

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

$out .= '
	<div class="wrap-timeline '.esc_attr($animate).'" '.wp_kses($animate_data, 'post').'>
		<div class="container-timeline">
			<div class="row top-row">
			    <div class="round-ico big"></div>
				<div class="col-md-12">
					<div class="time-title" id="timel"> <br />
					</div>
				</div>
			</div>
';

foreach ($out_cont_2 as $key => $value) {
	if ( $key === 0 ) {
		$out .= '<div>'.$value.'</div>';
	} else {
		$out .= '<div class="hidden">'.$value.'</div>';
	}
}

if ( $per_page_count < $count_item ) :

$out .= '
		<div class="plus">
			<span data-group="' . esc_attr($count_group) . '" class="plus-ico">+</span>
		</div>
';

else :

$out .= '
		<span class="plus">
			<span class="plus-ico inactive"></span>
		</span>
';
endif;

$out .= '
		</div>
	</div>
';

echo $out;