<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Row
 */
$el_class = $full_height = $parallax_speed_bg = $parallax_speed_video = $full_width = $equal_height = $flex_row = $columns_placement = $content_placement = $parallax = $parallax_image = $css = $el_id = $video_bg = $video_bg_url = $video_bg_parallax = '';
$disable_element = '';
$output = $after_output = $paralax_fix_before = $paralax_fix_after = $bg_image_src = $class_slider = $pix_bg_class = $pix_bg_color = $pix_decor_class = $pix_gradient = $pix_gradient_style = $pix_gradient_class = $pix_padding_top = $pix_padding_bottom = $radius = '';
$pdecor = $pdecor_bottom = $overflow = '';
$shadows_arr = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );

wp_enqueue_script( 'wpb_composer_front_js' );

/////////////////////////////////////////////
$class_preset_text = $ptextcolor == 'White' ? ' text-'.strtolower($ptextcolor).'-color text-shadow' : '';
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
    $pix_top_offset = 'jQuery(function($){$("head").append("<style>.'.esc_attr($pix_offset_class).'.pix-row-overflow{z-index:1;top:'.esc_attr($top_offset).';}.'.esc_attr($pix_offset_class).'.pix-row-overflow > .vc_column_container > .vc_column-inner{margin-bottom:'.esc_attr($top_offset).'}</style>");});';
    wp_add_inline_script( 'pixtheme-common', $pix_top_offset );
}

$overflow = $overflow == 'on' ? 'pix-row-overflow' : '';


$shadow_class = pixtheme_get_shadow($shadows_arr);
/////////////////////////////////////////////

$el_class = $this->getExtraClass( $el_class );

$css_classes = array(
	'vc_row',
	'wpb_row', //deprecated
	'vc_row-fluid',
	$el_class,
    $pix_padding_top,
    $pix_padding_bottom,
	$overflow,
	$pix_offset_class,
	$class_preset_text,
	$radius,
	$pix_decor_class,
	$shadow_class,
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
	) ) || $video_bg || $parallax
) {
	$css_classes[] = 'vc_row-has-fill';
}

if ( ! empty( $atts['gap'] ) ) {
	$css_classes[] = 'vc_column-gap-' . $atts['gap'];
}

if ( ! empty( $atts['rtl_reverse'] ) ) {
	$css_classes[] = 'vc_rtl-columns-reverse';
}

$wrapper_attributes = array();
// build attributes for wrapper
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
if ( ! empty( $full_width ) ) {
	$wrapper_attributes[] = 'data-vc-full-width="true"';
	$wrapper_attributes[] = 'data-vc-full-width-init="false"';
	if ( 'stretch_row_content' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
	} elseif ( 'stretch_row_content_no_spaces' === $full_width ) {
		$wrapper_attributes[] = 'data-vc-stretch-content="true"';
		$css_classes[] = 'vc_row-no-padding';
	}
	$after_output .= '<div class="vc_row-full-width vc_clearfix"></div>';
}

if ( ! empty( $full_height ) ) {
	$css_classes[] = 'vc_row-o-full-height';
	if ( ! empty( $columns_placement ) ) {
		$flex_row = true;
		$css_classes[] = 'vc_row-o-columns-' . $columns_placement;
		if ( 'stretch' === $columns_placement ) {
			$css_classes[] = 'vc_row-o-equal-height';
		}
	}
}

if ( ! empty( $equal_height ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-equal-height';
}

if ( ! empty( $content_placement ) ) {
	$flex_row = true;
	$css_classes[] = 'vc_row-o-content-' . $content_placement;
}

if ( ! empty( $flex_row ) ) {
	$css_classes[] = 'vc_row-flex';
}

$has_video_bg = ( ! empty( $video_bg ) && ! empty( $video_bg_url ) && vc_extract_youtube_id( $video_bg_url ) );

$parallax_speed = $parallax_speed_bg;
if ( $has_video_bg ) {
	$parallax = $video_bg_parallax;
	$parallax_speed = $parallax_speed_video;
	$parallax_image = $video_bg_url;
	$css_classes[] = 'vc_video-bg-container';
	wp_enqueue_script( 'vc_youtube_iframe_api_js' );
}

if ( ! empty( $parallax ) ) {
	wp_enqueue_script( 'vc_jquery_skrollr_js' );
	$wrapper_attributes[] = 'data-vc-parallax="' . esc_attr( $parallax_speed ) . '"'; // parallax speed
	$css_classes[] = 'vc_general vc_parallax vc_parallax-' . $parallax;
	if ( false !== strpos( $parallax, 'fade' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fade';
		$wrapper_attributes[] = 'data-vc-parallax-o-fade="on"';
	} elseif ( false !== strpos( $parallax, 'fixed' ) ) {
		$css_classes[] = 'js-vc_parallax-o-fixed';
	}
}

if ( ! empty( $parallax_image ) ) {
	if ( $has_video_bg ) {
		$parallax_image_src = $parallax_image;
	} else {
		$parallax_image_id = preg_replace( '/[^\d]/', '', $parallax_image );
		$parallax_image_src = wp_get_attachment_image_src( $parallax_image_id, 'full' );
		if ( ! empty( $parallax_image_src[0] ) ) {
			$parallax_image_src = $parallax_image_src[0];
		}
	}
	$wrapper_attributes[] = 'data-vc-parallax-image="' . esc_attr( $parallax_image_src ) . '"';
}
if ( ! $parallax && $has_video_bg ) {
	$wrapper_attributes[] = 'data-vc-video-bg="' . esc_attr( $video_bg_url ) . '"';
}
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
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
    $("head").append("<style>.vc_row-overlay.'.$pix_gradient_class.'{background: '.esc_attr($gradient_colors[0]['gradient_color']).';background: -webkit-linear-gradient('.$pix_directions_arr[$gradient_direction]['-webkit'].esc_attr($pix_gradient).');background: -o-linear-gradient('.$pix_directions_arr[$gradient_direction]['-o-linear'].esc_attr($pix_gradient).');background: -moz-linear-gradient('.$pix_directions_arr[$gradient_direction]['-moz-linear'].esc_attr($pix_gradient).');background: linear-gradient('.$pix_directions_arr[$gradient_direction]['linear'].esc_attr($pix_gradient).');opacity:'.esc_attr($gradient_opacity).';}</style>");
});
';
}
wp_add_inline_script( 'pixtheme-common', $pix_gradient_style );
if( $pix_gradient_class != '') {
	$output .= '<span class="vc_row-overlay ' . esc_attr($pix_gradient_class) . '" ></span>';
}else{
	$decor_dg = preg_split('/\{/', $css);
	preg_match_all( '/{([^\}]+)/i', $css, $matches, PREG_OFFSET_CAPTURE );
	if(isset($matches[1][0][0])){
		foreach( explode( ';', $matches[1][0][0] ) as $val ){
			if( substr_count($val, 'background')>0 && substr_count($val, 'rgba')>0 ){
				foreach( explode( ' ', $val ) as $val_exp ){
					if( substr_count($val_exp, 'rgba')>0 ){
						$output .= '<span class="vc_row-overlay" style="background-color: '.$val_exp.' !important;"></span>';
					}
				}
			}
			if( substr_count($val, 'background')>0 && substr_count($val, '#')>0 ){
				foreach( explode( ' ', $val ) as $val_exp ){
					if( substr_count($val_exp, '#')>0 ){
						$pix_sep_element = isset($decor_dg[0]) ? '
jQuery(function($){
    $("head").append("<style> '.$decor_dg[0]. ' .section-heading.white-heading .sep-element:after{ background: '.$val_exp.';}</style>");
});' : '';
						wp_add_inline_script( 'pixtheme-common', $pix_sep_element );
					}
				}
			}
		}
	}
}

$output .= wpb_js_remove_wpautop( $content );


if($pdecor == 'on' && $decor_points_top != ''){
    $section_points_top = explode( ' ', $decor_points_top );

    $pix_rand = isset($css_id[0]) && $css_id[0] != '' ? $css_id[0] : rand();
    $pix_decor_class = 'pix-decor-shape-'.$pix_rand;
    $pix_decor_height = isset($decor_height) ? $decor_height : 100;
    $pix_decor_border = isset($decor_border) ? $decor_border : 0;
    $decor_color = $sect_color ? $sect_color : ( $sect_rgba ? $sect_rgba : '#f5f5f5');
    $pix_main_color = get_post_meta(get_the_ID(), 'page_main_color', 1) != '' ? get_post_meta(get_the_ID(), 'page_main_color', 1) : autodealer_get_option('style_settings_main_color', get_option('autodealer_default_main_color'));
    $output .= '
		<div class="section-decor-wrap top" data-top="'.esc_attr($pix_decor_height).'" data-height="'.esc_attr($pix_decor_height).'" style="top: -'.esc_attr($pix_decor_height-1).'px; height:'.esc_attr($pix_decor_height).'px">
			<svg width="100%" data-height="'.esc_attr($pix_decor_height).'" height="'.esc_attr($pix_decor_height).'px">
				<defs>';
    $output .= '
					<pattern id="'.esc_attr($pix_decor_class).'" preserveAspectRatio="none" patternUnits="userSpaceOnUse" x="0" y="0" width="100%" data-height="'.esc_attr($pix_decor_height).'" height="'.esc_attr($pix_decor_height).'0px" viewBox="0 0 100 1000">';
    $points_top = $border_top = '';
    foreach($section_points_top as $val) {
        $xy = explode( ',', $val );
        $pix_offset = $pix_decor_border == 1 && $xy[1] > 97 ? 3 : 0;
        $points_top .= $xy[0].','.(100-$xy[1]+$pix_offset).' ';
        $border_top .= $xy[0].','.(100-$xy[1]+$pix_offset-3).' ';
    }
    if($decor_opacity != ''){
        $output .= '
								<linearGradient id="linear-gradient-'.esc_attr($pix_rand).'" x1="0" y1="0" x2="0" y2="100%">
									<stop offset="0%" stop-color="' . esc_attr($decor_color) . '" stop-opacity="'.esc_attr($decor_opacity).'"></stop>
									<stop offset="100%" stop-color="' . esc_attr($decor_color) . '" stop-opacity="1"></stop>
								</linearGradient>
						';
        $decor_color = 'url(#linear-gradient-'.esc_attr($pix_rand).')';
    }
    $output .= '<polygon fill="' . esc_attr($decor_color) . '" points="0,100 ' . esc_attr($points_top) . ' 100,100 "></polygon>';
    if($pix_decor_border){
        $decor_points_rev = array_reverse($section_points_top);
        foreach($decor_points_rev as $val) {
            $xy = explode( ',', $val );
            $pix_offset = $pix_decor_border == 1 && $xy[1] > 97 ? 3 : 0;
            $border_top .= $xy[0].','.(100-$xy[1]+$pix_offset+3).' ';
        }
        $output .= '<polygon fill="' . esc_attr($pix_main_color) . '" points="' . esc_attr($border_top) . '"></polygon>';
    }

    $output .= '
					</pattern>
				</defs>
				<rect x="0" y="0" width="100%" data-height="'.esc_attr($pix_decor_height).'" height="'.esc_attr($pix_decor_height).'px" fill="url(#'.esc_attr($pix_decor_class).')"></rect>';
    $output .= '
			</svg>
		</div>
	';
}

if($pdecor_bottom == 'on' && $decor_points_bottom != ''){
    $section_points_bottom = explode( ' ', $decor_points_bottom );

    $pix_rand = isset($css_id[0]) && $css_id[0] != '' ? $css_id[0] : rand();
    $pix_decor_class = 'pix-decor-shape-'.$pix_rand;
    $pix_decor_height = isset($decor_bottom_height) ? $decor_bottom_height : 100;
    $pix_decor_border = isset($decor_bottom_border) ? $decor_bottom_border : 0;
    $decor_color = $sect_color ? $sect_color : ( $sect_rgba ? $sect_rgba : '#f5f5f5');
    $pix_main_color = get_post_meta(get_the_ID(), 'page_main_color', 1) != '' ? get_post_meta(get_the_ID(), 'page_main_color', 1) : autodealer_get_option('style_settings_main_color', get_option('autodealer_default_main_color'));
    $output .= '
		<div class="section-decor-wrap bottom" data-bottom="'.esc_attr($pix_decor_height).'" data-height="'.esc_attr($pix_decor_height).'" style="bottom: -'.esc_attr($pix_decor_height-1).'px; height:'.esc_attr($pix_decor_height).'px">
			<svg width="100%" data-height="'.esc_attr($pix_decor_height).'" height="'.esc_attr($pix_decor_height).'px">
				<defs>';
    $output .= '
					<pattern id="'.esc_attr($pix_decor_class).'" preserveAspectRatio="none" patternUnits="userSpaceOnUse" x="0" y="0" width="100%" data-height="'.esc_attr($pix_decor_height).'" height="'.esc_attr($pix_decor_height).'0px" viewBox="0 0 100 1000">';
    $points_bottom = $border_bottom = '';
    foreach($section_points_bottom as $val) {
        $xy = explode( ',', $val );
        $pix_offset = $pix_decor_border == 1 && $xy[1] > 97 ? 3 : 0;
        $points_bottom .= $xy[0].','.($xy[1]-$pix_offset).' ';
        $border_bottom .= $xy[0].','.($xy[1]-$pix_offset-3).' ';
    }
    if($decor_bottom_opacity != ''){
        $output .= '
								<linearGradient id="linear-gradient-'.esc_attr($pix_rand).'" x1="0" y1="0" x2="0" y2="100%">
									<stop offset="0%" stop-color="' . esc_attr($decor_color) . '" stop-opacity="1"></stop>
									<stop offset="100%" stop-color="' . esc_attr($decor_color) . '" stop-opacity="'.esc_attr($decor_bottom_opacity).'"></stop>
								</linearGradient>
						';
        $decor_color = 'url(#linear-gradient-'.esc_attr($pix_rand).')';
    }
    $output .= '<polygon fill="' . esc_attr($decor_color) . '" points="0,0 ' . esc_attr($points_bottom) . ' 100,0 "></polygon>';
    if($pix_decor_border){
        $decor_points_rev = array_reverse($section_points_bottom);
        foreach($decor_points_rev as $val) {
            $xy = explode( ',', $val );
            $pix_offset = $pix_decor_border == 1 && $xy[1] > 97 ? 3 : 0;
            $border_bottom .= $xy[0].','.($xy[1]-$pix_offset+3).' ';
        }
        $output .= '<polygon fill="' . esc_attr($pix_main_color) . '" points="' . esc_attr($border_bottom) . '"></polygon>';
    }

    $output .= '
					</pattern>
				</defs>
				<rect x="0" y="0" width="100%" data-height="'.esc_attr($pix_decor_height).'" height="'.esc_attr($pix_decor_height).'px" fill="url(#'.esc_attr($pix_decor_class).')"></rect>';
    $output .= '
			</svg>
		</div>
	';
}

$output .= '</div>';
$output .= $after_output;

if(function_exists('pix_out')){
    pix_out($output);
} else {
    echo wp_kses_post($output);
}