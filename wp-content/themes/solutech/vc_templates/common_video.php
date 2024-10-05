<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $title
 * @var $undertitle
 * @var $duration
 * @var $css_animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Video
 */
$out = $title = $color = $radius = $image = $img_bg = $display = $position = $btn_class = $pix_btn = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$height = $height == '' ? '500px' : $height;

$title = ( $title == '' ) ? '' : '<div class="title">'.wp_kses_post($title).'</div>';
$fullcontent = ($content == '') ? '' : '<div class="duration">'.do_shortcode($content).'</div>';
if($image != '') {
    $img_id = preg_replace('/[^\d]/', '', $image);
    $img_path = wp_get_attachment_image_src($img_id, 'large');
    $img_path = isset($img_path[0]) ? $img_path[0] : '';
    $img_bg = 'background: url(' . esc_url($img_path) . ') no-repeat 50% 50%;';
}


$pix_video_class = 'pix_video_' . rand();
if($display == 'button'){
    $height = '70px';
    $btn_class = 'pix-video-button';
    $color = 'transparent';
    $pix_btn = '<div class="pix-button pix-transparent">'.esc_html__('Watch the Video', 'solutech').'</div>';
}
$pix_video_style = 'jQuery("head").append("<style> .'.esc_attr($pix_video_class).'{'.wp_kses_post($img_bg).'display:grid;position:relative;height:'.esc_attr($height).'}.'.esc_attr($pix_video_class).' .pix-video{background-color:'.esc_attr($color).'}</style>");';
wp_add_inline_script( 'pixtheme-common', $pix_video_style );


if($display != 'embed') {
$out .= '
     <div class="'.esc_attr($pix_video_class).' '.esc_attr($radius).'">
        <div class="pix-video '.esc_attr($btn_class).' '.esc_attr($position).'">
            '.wp_kses_post($title).'
            <a class="pix-video-popup" href="'.esc_url($url).'" >
                '.wp_kses_post($pix_btn).'
                <div class="item-pulse">
                    <img class="play" src="'.get_template_directory_uri().'/images/play.svg" alt="'.esc_attr($title).'">
                </div>
            </a>
            '.wp_kses_post($fullcontent).'
        </div>
    </div>';
} else {
    $vendor = parse_url($url);
    $video_id = $vendor_name = '';
    if ($vendor['host'] == 'www.youtube.com' || $vendor['host'] == 'youtu.be' || $vendor['host'] == 'www.youtu.be' || $vendor['host'] == 'youtube.com') {
        if ($vendor['host'] == 'www.youtube.com') {
            parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
            $video_id = $my_array_of_vars['v'];
        } else {
            $video_id = parse_url($url, PHP_URL_PATH);
        }
        $vendor_name = 'youtube';
    } elseif ($vendor['host'] == 'vimeo.com'){
        $video_id = parse_url($url, PHP_URL_PATH);
        $vendor_name = 'vimeo';
    }
    $out .= '
    <div class="' . esc_attr($pix_video_class) . ' '.esc_attr($radius).'">
        <div class="pix-video embed" data-vendor="' . esc_attr($vendor_name) . '" data-embed="' . esc_attr($video_id) . '">
            ' . wp_kses_post($title) . '
                <div class="play-button">
                    <div class="item-pulse">
                        <img class="play" src="' . get_template_directory_uri() . '/images/play.svg" alt="' . esc_attr($title) . '">
                    </div>
                </div>
            ' . wp_kses_post($fullcontent) . '
        </div>
    </div>';
}

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}