<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Brands
 */
$css_animation = $popup = $greyscale = '';
$carousel_arr = array();
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$carousel_arr = pixtheme_vc_get_params_array($atts, 'carousel');
extract( $atts );

$brands_per_page = is_numeric($brands_per_page) ? $brands_per_page : 5;
$gallery_class = $popup == 'on' ? 'pix-popup-gallery' : '';
$greyscale = ($greyscale == 'off') ? '' : 'pix-img-greyscale';

$image_size = array(100, 100);
if( pixtheme_retina() ){
    $image_size = array(200, 200);
}

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

$brands = vc_param_group_parse_atts( $atts['brands'] );
$brands_out = array();
foreach($brands as $key => $item){

    $href = isset($item['link']) ? vc_build_link( $item['link'] ) : '';
    $url = empty($href['url']) ? '#' : $href['url'];
    $target = empty($href['target']) ? '' : 'target="'.esc_attr($href['target']).'"';
    if(isset($item['image']) && $item['image'] != ''){
        $img_id = preg_replace( '/[^\d]/', '', $item['image'] );
        $img_path = wp_get_attachment_image_src( $img_id, 'pixtheme-original' );
        $img_path = isset($img_path[0]) ? $img_path[0] : '';
        $img_full = wp_get_attachment_image_src( $img_id, 'full' );
        $url = $popup == 'on' ? $img_full[0] : $url;
        $title = isset($item['title']) ? $item['title'] : '';
        $brands_out[] = '
        <div class="item pix-logo-img">
            <a '.wp_kses_post( $target ).' href="' . esc_url( $url ) . '"><img class="pix-no-lazy-load" src="'.esc_url($img_path).'" alt="'.esc_attr($title).'"></a>
        </div>';
    }

}

$options_arr = pixtheme_get_carousel($carousel_arr, '');
$data_carousel = empty($options_arr) ? '' : 'data-owl-options=\''.json_encode($options_arr).'\'';
$carousel_class = !empty($options_arr) ? 'owl-carousel owl-theme' : 'disable-owl-carousel pix-col-'.esc_attr($brands_per_page);

$out = '
    <div class="pix-brand-box '.esc_attr($gallery_class).' '.esc_attr($carousel_class).' owl-theme '.esc_attr($greyscale).'" '.wp_kses_post($data_carousel).' >
        '.implode( "\n", $brands_out ).'
    </div>
';

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}