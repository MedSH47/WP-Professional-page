<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Cform7 extends Base {

    public function get_name() {
        return 'pixtheme-cform7';
    }

    public function get_title() {
        return esc_html__( 'Contact form 7', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_keywords() {
        return [ 'contact', 'form' ];
    }

    protected function register_controls() {
        $this->add_section_content();

    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Contact form 7', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $args = array( 'post_type' => 'wpcf7_contact_form', 'numberposts' => -1 );
        $forms = get_posts( $args );
        $cform7 = array();
        if ( empty( $forms['errors'] ) ) {
            foreach( $forms as $form ) {
                $cform7[$form->ID] = $form->post_title;
            }
        }

        $this->add_control(
            'cform',
            [
                'label' => esc_html__( 'Choose form', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => '0',
                'options' => [ '0' => '- ' . esc_html__( 'No contact form selected', 'solutech' ) . ' -' ] + $cform7,
                'label_block' => true
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ( ! empty( $settings['cform'] ) && $settings['cform'] != '0' && get_post_type( $settings['cform'] ) === 'wpcf7_contact_form' ):
            echo do_shortcode( '[contact-form-7 id="' . esc_attr( $settings['cform'] ) . '"]' );
        endif;

    }

}
