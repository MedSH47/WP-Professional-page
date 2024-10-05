<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Booking extends Base {

    public function get_name() {
        return 'pixtheme-booking';
    }

    public function get_title() {
        return esc_html__( 'Booking', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-date';
    }

    public function get_keywords() {
        return [ 'booking', 'form' ];
    }

    protected function register_controls() {
        $this->add_section_content();

    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Appointment Form', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $args = array( 'hide_empty' => false );
		$categories = get_terms( $args );
		$booking = [];
		foreach($categories as $category){
			if( is_object($category) ){
				if( $category->taxonomy == 'booked_custom_calendars' ) {
					$booking[$category->term_id] = $category->name;
				}
			}
		}

        $this->add_control(
            'booking',
            [
                'label' => esc_html__( 'Choose calendar', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [ '0' => '- ' . esc_html__( 'Default Calendar', 'solutech' ) . ' -' ] + $booking,
                'label_block' => true
            ]
        );
		
        $this->add_control(
            'style',
            [
                'label' => esc_html__( 'Color Scheme', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'Light', 'solutech' ),
                    'pix-theme-tone-dark' => esc_html__( 'Dark', 'solutech' ),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $out = '<div class="common-appointment-calendar '.esc_attr($settings['style']).'">';
		$out .= do_shortcode('[booked-calendar calendar='.wp_kses_post($settings['booking']).']');
		$out .= '</div>';
		
		pixtheme_out( $out );
    }

}
