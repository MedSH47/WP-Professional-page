<?php
/**
 * Shortcode class
 * @var $this WPBakeryShortCode_Pix_Calculator
 */
$shadows_arr = $calc_arr = array();
$out = $calc_id = $form_id = $calc_title = $currency = $tone = $shadow = $titles = $btntext = $link = $a_href = $css_animation = '';
$position = 'left';
$decimals = 0;
$form_begin = $form_end = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

if(isset($_POST['pix-calculator'])){
    $calc_arr = $_POST['pix-calculator'];
}

$args = array();

//parse link
$link = ( '||' === $link ) || $form_id > 0 ? '' : $link;
$link = vc_build_link( $link );
$a_href = strlen( $link['url'] ) > 0 ? $link['url'] : '#';


$shadow = $shadow != 'off' ? 'pix-shadow' : '';
$calc_title = $calc_title == '' ? '' : '<div class="pix-calculator-title">'.$calc_title.'</div>';

$out = '
    <section class="pix-calculator '.esc_attr($tone).' '.esc_attr($shadow).'">
        '.($calc_title).'
';

if( $calc_id != '0' && $calc_id != '' ){
    $args = array(
        'post_type' => 'pix-calculator-field',
        'orderby' => 'menu_order',
        'tax_query' => array(
            array(
                'taxonomy' => 'pix-calculator',
                'field'    => 'slug',
                'terms'    => $calc_id
            )
        ),
        'posts_per_page' => -1,
        'order' => 'ASC',
    );
} else {
    $args = array(
        'post_type' => 'pix-calculator-field',
        'orderby' => 'menu_order',
        'tax_query' => array(
            array(
                'taxonomy' => 'pix-calculator',
                'field'    => 'slug',
                'operator' => 'NOT EXISTS'
            )
        ),
        'posts_per_page' => -1,
        'order' => 'ASC',
    );
}

if(!isset($form_id) || $form_id == 0){
    $form_begin = '<form action="'.esc_url($a_href).'" method="post">';
    $form_end = '</form>';
}

$wp_query = new WP_Query( $args );

if ( $wp_query->have_posts() ) {
    
    $out .= '
        <div class="pix-calculator-fields">'
        .$form_begin;

    $i = $offset = $total = 0;
    while ( $wp_query->have_posts() ) :
        $wp_query->the_post();
        $i++;

        if($css_animation != '') {
            //$animate = 'class="';
            $animate = 'animated';
            $animate .= !empty($wow_duration) || !empty($wow_delay) || !empty($wow_offset) || !empty($wow_iteration) ? ' wow ' . esc_attr($css_animation) : '';
            //$animate .= '"';
            $animate_data .= ' data-animation="'.esc_attr($css_animation).'"';
            $wow_group = !empty($wow_group) ? $wow_group : 1;
            $wow_group_delay = !empty($wow_group_delay) ? $wow_group_delay : 0;
            $animate_data .= !empty($wow_duration) ? ' data-wow-duration="'.esc_attr($wow_duration).'s"' : '';
            $animate_data .= !empty($wow_delay) ? ' data-wow-delay="'.esc_attr($wow_delay + $offset * $wow_group_delay).'s"' : '';
            $animate_data .= !empty($wow_offset) ? ' data-wow-offset="'.esc_attr($wow_offset).'"' : '';
            $animate_data .= !empty($wow_iteration) ? ' data-wow-iteration="'.esc_attr($wow_iteration).'"' : '';

            $offset = $i % $wow_group == 0 ? ++$offset : $offset;
        }

        $post_slug = get_post_field( 'post_name', get_the_ID() );
        $field_type = get_post_meta( get_the_ID(), 'pix-field-type', true );
        $field_empty = get_post_meta( get_the_ID(), 'pix-field-empty', true );
        $operation = get_post_meta( get_the_ID(), 'pix-operation-type', true );
        $field_values = get_post_meta( get_the_ID(), 'pix-field-values', true );
        $description = get_post_field('post_excerpt', get_the_ID()) ? '<span>'.get_the_excerpt().'</span>' : '';

        $out_values = '';
        if(isset($field_values['title'])) {
            foreach ($field_values['title'] as $key => $title ) {
                $price = isset($field_values['price'][$key]) && $field_values['price'][$key] > 0 ? $field_values['price'][$key] : '0';
                $price_html = $price < -1 ? '  ($'.esc_attr($price).')' : '';
                $selected = $checked = '';
                if( (isset($calc_arr['calc_id']) && $calc_arr['calc_id'] == $calc_id) && (isset($calc_arr[$post_slug]) && $calc_arr[$post_slug] == $title) ){
                    $selected = 'selected';
                    $checked = 'checked';
                    $total += $price;
                }
                switch ($field_type) {
                    case 'select' :
                        $out_values .= '<option value="'.esc_attr($title).'" data-price="'.esc_attr($price).'" '.$selected.'>'.esc_html($title).esc_attr($price_html).'</option>';
                        break;
                        
                    case 'multiselect' :
                        $out_values .= '<option value="'.esc_attr($title).'" data-price="'.esc_attr($price).'" '.$selected.'>'.esc_html($title).esc_attr($price_html).'</option>';
                        break;

                    case 'check' :
                        $out_values .= '<label><input name="pix-calculator['.esc_attr($post_slug).']" type="checkbox" '.$checked.' class="pix-calc-value" value="'.esc_attr($title).'" data-title="'.esc_attr(get_the_title()).'" data-operation="'.esc_attr($operation).'" data-price="'.esc_attr($price).'">'.esc_html($title).esc_attr($price_html).'</label>';
                        break;

                    case 'radio' :
                        $out_values .= '<label><input name="pix-calculator['.esc_attr($post_slug).']" type="radio" '.$checked.' class="pix-calc-value" value="'.esc_attr($title).'" data-title="'.esc_attr(get_the_title()).'" data-operation="'.esc_attr($operation).'" data-price="'.esc_attr($price).'">'.esc_html($title).esc_attr($price_html).'</label>';
                        break;
                }
            }
        }
        if($field_type == 'select'){
            $out_values = '
                <select name="pix-calculator['.esc_attr($post_slug).']" data-title="'.esc_attr(get_the_title()).'" data-operation="'.esc_attr($operation).'" class="pix-calc-value">
                    <option value="" data-price="0">'.esc_html($field_empty).'</option>
                    '.($out_values).'
                </select>';
        } elseif($field_type == 'multiselect'){
            $out_values = '
                <select id="'.esc_attr($post_slug).'" name="pix-calculator['.esc_attr($post_slug).']" multiple data-placeholder="'.esc_attr(get_the_title()).'" data-title="'.esc_attr(get_the_title()).'" data-operation="'.esc_attr($operation).'" class="pix-multi-select pix-calc-value">
                    '.($out_values).'
                </select>';
        }
        $field_title = $titles != 'off' ? get_the_title() : '';

        $out .= '
            <div class="pix-calculator-field">
                <div class="pix-calc-title">
                    '.($field_title).'
                    '.($description).'
                </div>
                <div class="pix-calc-values '.esc_attr($field_type).'">
                    ' . ($out_values) . '
                </div>
            </div>';

    endwhile;
    
    $zero = $decimals > 0 ? '0.' : '0';
    for($d = 0; $d < $decimals; $d++){
        $zero .= '0';
    }
    $total = $position == 'left' ? esc_attr( $currency ).'<span>'.esc_attr($zero).'</span>' : '<span>'.esc_attr($zero).'</span>'.esc_attr( $currency );

    $out .= '
            <input type="hidden" name="pix-calculator[calc_id]" value="'.esc_attr($calc_id).'">
            <div class="pix-calc-total">
                <div class="pix-calc-total-price" data-decimals="'.esc_attr($decimals).'">
                    ' . ( $total ) . '
                </div>
                <div class="pix-calc-total-btn">
                    <button type="submit" class="pix-button">' . esc_html( $btntext ) . '</button>
                </div>
            </div>
        '.$form_end.'
        </div>
    ';
}

if(isset($form_id) && $form_id > 0){
   $out .= '
        <div class="pix-form-container">'.do_shortcode('[contact-form-7 id="'.esc_attr($form_id).'"]').'</div>';
}

$out .= '
    </section>';


wp_reset_postdata();

if ( function_exists( 'pix_out' ) ) {
    pix_out( $out );
}