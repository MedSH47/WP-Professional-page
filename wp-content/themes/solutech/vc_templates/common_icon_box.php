<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Icon_Box
 */
$is_animate = $css_animation = $animate = $animate_data = $icon_type = $icon = $icon_shape = $href_container_before = $href_container_after = $href_before = $href_after = $fill_color = $content_position = $hover_class = '';
$border = $filled = $no_padding = 'off';
$link_type = 'overlay';
$icon_size = 'pix-icon-l';
$icon_color = 'pix-icon-color';
$icon_bg_color = 'pix-icon-bg-main-color';
$type = 'pixfontawesome';
$position = $position_with_center = $position_no_center = 'pix-text-left';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );


$href = vc_build_link( $link );

$style = !isset($style) || $style == '' ? 'pix-ibox-top' : $style;
$shadow_class = pixtheme_get_shadow($shadows_arr);
$border_class = $border == 'on' ? 'pix-has-border' : '';
$filled_class = $filled == 'on' ? 'pix-hover-filled' : '';
$overlay = $filled == 'on' ? '<div class="pix-overlay '.esc_attr($fill_color).'"></div>' : '';
$no_padding_class = $no_padding == 'on' ? 'pix-no-padding' : '';

$css_classes = array(
	$radius,
	$border_class,
	$filled_class,
	$no_padding_class,
	$shadow_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts );

if($style == 'pix-ibox-top'){
    $position = $position_with_center;
} else {
    $position = $position_no_center;
}

if($icon_type == 'font')
    $icon = isset( ${"icon_" . $type} ) ? ${"icon_" . $type} : '';
$target = empty($href['target']) ? '' : 'target="'.esc_attr($href['target']).'"';
$class_text = in_array($style, array('pix-ibox-side')) ? 'text '.esc_attr($content_position) : '';
if(!empty( $href['url'] )){
    if($link_type == 'overlay') {
        $href_container_before = '<a ' . ($target) . ' href="' . esc_url($href['url']) . '" class="pix-image-link">';
        $href_container_after = '</a>';
    } else {
        $href_before = '<a ' . ($target) . ' href="' . esc_url($href['url']) . '" class="pix-title-link">';
        $href_after = '</a>';
        $hover_class = 'pix-icon-hover';
    }
}
if($icon_type == 'image' && isset($image) && $image != ''){
	$img_id = preg_replace( '/[^\d]/', '', $image );
    $img_path = wp_get_attachment_image_src( $img_id, 'thumbnail' );
    $img_path = isset($img_path[0]) ? $img_path[0] : '';
	$show_icon = '<div class="icon">'.($href_before).'<img src="'.esc_url($img_path).'" alt="'.esc_attr($title).'">'.($href_after).'</div>';
} else {
	$show_icon = '<div class="icon">'.($href_before).'<span class="'.esc_attr($icon).'" ></span>'.($href_after).'</div>';
}

if(isset($bg_image) && $bg_image != ''){
    $bg_img_id = preg_replace( '/[^\d]/', '', $bg_image );
    $bg_img_path = wp_get_attachment_image_src( $bg_img_id, array(555,555) );
    $bg_image = isset($bg_img_path[0]) ? $bg_img_path[0] : '';
}

$out_icon = '<div class="'.esc_attr($icon_shape).' '.esc_attr($icon_size).' '.esc_attr($icon_color).' '.esc_attr($icon_bg_color).' '.esc_attr($hover_class).'">'.($show_icon).'</div>';
$final_title = empty( $title ) ? '' : '<div class="pix-item-title">'.($title).'</div>';
$final_content = ($content == '') ? '' : '<p>'.do_shortcode($content).'</p>';
$btn_link_class = $link_type == 'button' ? 'pix-button' : 'pix-link';
$final_btn = ($btn_link_txt == '') ? '' : '<a href="'.esc_url($href['url']).'" class="'.esc_attr($btn_link_class).'" '.($target).'>'.($btn_link_txt).'</a>';



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

$out = '<div class="pix-box ' . esc_attr($css_class) . ' '.esc_attr($animate).'" '.($animate_data).'>';

$out .= ($href_container_before).'
		<div class="'.esc_attr($style).' '.esc_attr($position).'">';

if($style == 'pix-ibox-side' && $position_no_center == 'pix-text-review-right'){
    $out .= '
            <div class="pix-block-content">
                <div class="'.esc_attr($class_text).'">
                    '.($final_title).'
                    '.($final_content).'
                    '.($final_btn).'
                </div>
                '.($out_icon).'
            </div>';
} elseif($style == 'pix-ibox-title-side'){
    if($position_no_center == 'pix-text-review-right') {
        $title_top = '
            <div class="pix-ibox-title">'.($final_title).'</div>
            '.($out_icon);
    } else {
        $title_top = '
            '.($out_icon).'
            <div class="pix-ibox-title">'.($final_title).'</div>';
    }
    $out .= '
            '.($overlay).'
            <div class="pix-block-content">
                <div class="pix-ibox-title-side-top">
                    '.($title_top).'
                </div>
                <div class="'.esc_attr($class_text).'">
                    '.($final_content).'
                    '.($final_btn).'
                </div>
			</div>';
} elseif($style == 'pix-ibox-flip'){
    if(isset($flip) && $flip == 'on'){
        $out .= '
                    <div class="pix-icon-box-flip flip">
                        <div class="service-box-3">
                            <div class="service-box-3__container '.esc_attr($icon_size).'">
                                <div class="icon '.esc_attr($icon_color).' ">'.($show_icon).'</div>
                                '.($final_title).'
                            </div>
                            <img src="'.esc_url($bg_image).'" alt="'.esc_attr($title).'">
                        </div>
                        <div class="service-box-3 under">
                            '.($href_before).'
                            <div class="service-box-3__container two">
                                '.($final_title).'
                                '.($final_content).'
                            </div>
                            '.($href_after).'
                            <img src="'.esc_url($bg_image).'" alt="'.esc_attr($title).'">
                        </div>
                    </div>';
    } else {
        $out .= '
                    <div class="pix-icon-box-flip">
                        <div class="service-box-3">
                            '.($href_before).'
                            <div class="service-box-3__container '.esc_attr($icon_size).'">
                                <div class="icon '.esc_attr($icon_color).' ">'.($show_icon).'</div>
                                '.($final_title).'
                            </div>
                            '.($href_after).'
                            <img src="'.esc_url($bg_image).'" alt="'.esc_attr($title).'">
                        </div>
                    </div>';
    }
} else {
    $out .= '
            '.($overlay).'
            <div class="pix-block-content">
                '.($out_icon).'
                <div class="'.esc_attr($class_text).'">
                    '.($final_title).'
                    '.($final_content).'
                    '.($final_btn).'
                </div>
			</div>';
}
$out .= '
		</div>
		'.($href_container_after);

$out .= '</div>'.$this->endBlockComment('common_icon_box');

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo ($out);
}