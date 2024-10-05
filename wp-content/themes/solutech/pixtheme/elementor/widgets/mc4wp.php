<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_MC4WP extends Base {

    public function get_name() {
        return 'pixtheme-mc4wp';
    }

    public function get_title() {
        return esc_html__( 'Mailchimp', 'solutech' );
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
                'label' => esc_html__( 'Mailchimp', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'title',
            [
                'label' => esc_html__( 'Title', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Default title', 'solutech' ),
                'placeholder' => esc_html__( 'Type your title here', 'solutech' ),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label' => esc_html__( 'Subtitle', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Default title', 'solutech' ),
                'placeholder' => esc_html__( 'Type your subtitle here', 'solutech' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $title = $settings['title'];
        $subtitle = $settings['subtitle'];
        
        $title_out = $subtitle_out = $out = '';
        $col_class = 'col-md-12';
        if ( ! empty( $title ) ) {
            $title_out = '<div class="section__title"><h3>' . $title . '</h3></div>';
        }
        if ( ! empty( $subtitle ) ) {
            $subtitle_out = '<div class="section__subtitle"><h3>' . $subtitle . '</h3></div>';
        }
        if ( $title_out != '' || $subtitle_out != '' ) {
            $out = '<div class="col-md-4">' . $title_out . $subtitle_out . '</div>';
            $col_class = 'col-md-8';
        }

        echo '
		<div class="row subscribe">
			'.wp_kses($out, 'post').'
			<div class="pix-mc4wp-form '.esc_attr($col_class).' col-sm-12">
				'.do_shortcode('[mc4wp_form]').'
			</div>
		</div>';

    }

}
