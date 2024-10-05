<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $calendar_id
 * Shortcode class
 * @var $this WPBakeryShortCode_Common_Appointment
 */
$calendar_type = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$out = $calendar = $cats_out = '';

$calendar_type = $calendar_type == '' ? 'switcher' : $calendar_type;

if($calendar_type == 'switcher') {

    $calendar = 'switcher=1';

    $args_port = array(
        'post_type' => 'portfolio',
        'posts_per_page' => -1,
        'meta_key' => 'pix_portfolio_calendar',
        'meta_value' => '0',
        'meta_compare' => '>=',
        'fields' => 'ids',
    );
    $portfolio = get_posts($args_port);

    $tax_ids = array();
    foreach($portfolio as $pid){
        $tax = wp_get_post_terms( $pid, 'portfolio_category' );
        foreach($tax as $term_single) {
            if( !in_array($term_single->term_id, $tax_ids)){
                $tax_ids[] = $term_single->term_id;
                $cats_out .= '<option value="'.esc_attr($term_single->term_id).'">'.wp_kses_post($term_single->name).'</option>';
            }
        }
    }

    $out .= '
        <div class="common-department booked-calendarSwitcher calendar">
            <p>
                <i class="fa fa-user-md"></i>
                <select id="ajax-department">
                    <option value="">' . esc_html__('Select Speciality', 'solutech') . '</option>
                    ' . ($cats_out) . '
                </select>
            </p>
        </div>
    ';

} elseif($calendar_id != '') {
    $calendar = 'calendar='.esc_attr($calendar_id);
}

$out .= '<div class="common-appointment-calendar">
            <div class="calendar-change-loader">
                <span class="calendar-changing">
                    <i class="fa fa-refresh fa-spin"></i>
                </span>
            </div>
        ';
$out .= do_shortcode('[booked-calendar '.wp_kses_post($calendar).']');
$out .= '</div>';

if(function_exists('pix_out')){
    pix_out($out);
} else {
    echo wp_kses_post($out);
}