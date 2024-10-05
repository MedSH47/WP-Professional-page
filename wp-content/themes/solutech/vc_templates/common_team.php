<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Team
 */
$carousel_arr = $shadows_arr = array();
$is_animate = $css_animation = $animate = $animate_data = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
$carousel_arr = pixtheme_vc_get_params_array($atts, 'carousel');
$shadows_arr = pixtheme_vc_get_params_array($atts, 'shadow');
extract( $atts );

$shadow_class = pixtheme_get_shadow($shadows_arr);

$image_size = array(350, 350);
if( pixtheme_retina() ){
    $image_size = array(700, 700);
}

$members = vc_param_group_parse_atts( $atts['members'] );
$members_out = array();
$count = 1;
$cnt = count($members);
$i = $offset = 0;
foreach($members as $key => $item){
    $image = '';

    $href = isset($item['link']) ? vc_build_link( $item['link'] ) : '';
    $blank = empty($href['target']) ? '_self' : $href['target'];
    $href = empty($href['url']) ? '#' : $href['url'];

    if($css_animation != '' && $is_animate == 'on') {
        $animate = 'animated';
        $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
        $animate_data = ' data-animation="'.esc_attr($css_animation).'"';
        $wow_group = !empty($wow_group) ? $wow_group : 1;
        $wow_group_delay = !empty($wow_group_delay) ? $wow_group_delay : 0;
        $wow_delay = !empty($wow_delay) ? $wow_delay : 0;
        $animate_data .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
        $animate_data .= !empty($wow_delay) || $wow_group_delay > 0 ? ' data-wow-delay="'.esc_attr($wow_delay + $offset * $wow_group_delay).'s"' : '';
        $animate_data .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
        $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';

        $offset = $i % $wow_group == 0 ? ++$offset : $offset;
    }

    if( isset($item['image']) && $item['image'] != ''){
        $img = wp_get_attachment_image_src( $item['image'], $image_size );
        $img_output = $img[0];
        $image =  '<img src="'.esc_url($img_output).'" alt="'.esc_attr($item['name']).'">';
    }
    $position = isset($item['position']) && $item['position'] != '' ? $item['position'] : '';
    $facebook = isset($item['facebook']) && $item['facebook'] != '' ? '<a href="'.esc_url($item['facebook']).'"><i class="icon-social-facebook"></i></a>' : '';
    $twitter = isset($item['twitter']) && $item['twitter'] != '' ? '<a href="'.esc_url($item['twitter']).'"><i class="icon-social-twitter"></i></a>' : '';
    $instagram = isset($item['instagram']) && $item['instagram'] != '' ? '<a href="'.esc_url($item['instagram']).'"><i class="icon-social-instagram"></i></a>' : '';
    $skype = isset($item['skype']) && $item['skype'] != '' ? '<a href="'.esc_url($item['skype']).'"><i class="icon-social-skype"></i></a>' : '';

    $class_red = $count % 2 == 0 ? 'pix-red-box' : '';
    $members_out[] = '
        <div class="pix-team-item '.esc_attr($animate).'" '.wp_kses_post($animate_data).'>
            <div class="pix-team-item-img">
                '.wp_kses_post($image).'
            </div>
            <div class="pix-team-item-bottom '.esc_attr($class_red).'">
                <div class="pix-team-item-info">
                    <div class="pix-team-item-name">'.wp_kses_post($item['name']).'</div>
                    <div class="pix-team-item-job">'.wp_kses_post($position).'</div>
                </div>
                <div class="pix-team-item-social">
                    '.wp_kses_post($skype).'
                    '.wp_kses_post($facebook).'
                    '.wp_kses_post($twitter).'
                    '.wp_kses_post($instagram).'
                </div>
            </div>
        </div>
    ';

    $count ++;
}

$options_arr = pixtheme_get_carousel($carousel_arr);
$data_carousel = empty($options_arr) ? '' : 'data-owl-options=\''.json_encode($options_arr).'\'';
$col = isset($options_arr['items']) != '' ? $options_arr['items'] : 3;
$carousel_class = !empty($options_arr) ? 'owl-carousel owl-theme' : 'disable-owl-carousel pix-col-'.esc_attr($col);


$out = '
<div class="pix-team-slider '.wp_kses_post($carousel_class).' '.esc_attr($radius).' " '.wp_kses_post($data_carousel).'>

    '.implode( "\n", $members_out ).'

</div>';


if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}
