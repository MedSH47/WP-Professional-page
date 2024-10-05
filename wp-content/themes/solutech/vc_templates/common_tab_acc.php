<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Tab_Acc
 */
$out = $toggle_type = $collapse = $link_type = $btn_link_txt = $css_animation = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( $atts );

$wdata = 'data-widget-id="common_tab_acc" data-widget-name="Tabs-Accordion"';
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

if($toggle_type == 'accordion'){

    $accordion = (array)vc_param_group_parse_atts($accordion);
    $acc_arr = array();
    $i = 0;
    foreach ($accordion as $data) {

        $class_active = 'collapsed';
        $class_active_cont = '';
        if($i == 0 && $collapse != 'on'){
            $class_active = '';
            $class_active_cont = 'show';
        }
        
        $id = isset($data['tab_id_a']) ? $data['tab_id_a'].'-'.$i : $i;
        $acc_arr[$i] = '
            <div class="pix-accordion-row">
                <div class="pix-accordion-btn">
                    <button class="'.esc_attr($class_active).'" type="button" data-toggle="collapse" data-target="#'.esc_attr($id).'">
                        '.wp_kses_post($data['label_a']).'
                    </button>
                </div>

                <div id="'.esc_attr($id).'" class="collapse '.esc_attr($class_active_cont).'" data-parent="#pix-question-accordion">
                    <div class="pix-accordion-body">'.wp_kses_post($data['content_a']).'</div>
                </div>
            </div>
        ';

        $i++;
    }

    $out .= '
    <div class="" id="pix-question-accordion">
        '.implode($acc_arr).' 
    </div>';

} else {

    $tabs = (array)vc_param_group_parse_atts($tabs);
    $tabs_labels = $tabs_contents = array();
    $btn_link = '';
    $i = 0;
    foreach ($tabs as $data) {
        $href = vc_build_link( $data['link'] );
        $target = empty($href['target']) ? '' : 'target="'.esc_attr($href['target']).'"';
        if(!empty( $href['url'] )){
            $btn_link_class = $link_type == 'button' ? 'pix-button' : 'pix-link';
            $btn_link = ($btn_link_txt == '') ? '' : '<a href="'.esc_url($href['url']).'" class="'.esc_attr($btn_link_class).'" '.wp_kses_post($target).'>'.wp_kses_post($btn_link_txt).'</a>';
        }

        $class_active = $class_active_cont = '';
        if($i == 0){
            $class_active = 'active';
            $class_active_cont = 'show active';
        }
        $id = isset($data['tab_id']) ? $data['tab_id'].'-'.$i : $i;
        $tabs_labels[$i] = '
            <li>
                <a class="'.esc_attr($class_active).'" data-toggle="tab" href="#'.esc_attr($id).'">'.wp_kses_post($data['label']).'</a>
            </li>
        ';
        $tabs_contents[$i] = '
            <div class="tab-pane fade '.esc_attr($class_active_cont).'" id="'.esc_attr($id).'">
                <p>'.wp_kses_post($data['content_t']).'</p>
                '.wp_kses_post($btn_link).'
            </div>
        ';

        $i++;
    }

    $out .= '
    <div class="pix-section-tabs">
        <ul class="nav">
            '.implode($tabs_labels).'
        </ul>
        <div class="tab-content">
            '.implode($tabs_contents).'
        </div>
    </div>';

}

$out .= '</div>';

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}