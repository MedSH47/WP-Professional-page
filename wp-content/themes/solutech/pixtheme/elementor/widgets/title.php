<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Title extends Base {

    public function get_name() {
        return 'pixtheme-title';
    }

    public function get_title() {
        return esc_html__( 'Title', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-t-letter';
    }

    public function get_keywords() {
        return [ 'heading', 'title', 'text' ];
    }

    protected function register_controls() {
        $this->add_section_content();
    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'solutech' ),
            ]
        );
        
        $this->add_control(
            'pre_title',
            [
                'label' => esc_html__( 'Pre Title', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( 'Default pre title', 'solutech' ),
                'placeholder' => esc_html__( 'Type your pre title here', 'solutech' ),
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
            'after_title_text',
            [
                'label' => esc_html__( 'After Title Text', 'solutech' ),
                'type' => Controls_Manager::TEXTAREA,
                'default' => esc_html__( 'Default text', 'solutech' ),
                'placeholder' => esc_html__( 'Type your text here', 'solutech' ),
            ]
        );
        
        $this->add_control(
            'position',
            [
                'label' => esc_html__( 'Position', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'text-center',
                'options' => [
                    'text-left' => esc_html__( 'Left', 'solutech' ),
                    'text-center' => esc_html__( 'Center', 'solutech' ),
                    'text-right' => esc_html__( 'Right', 'solutech' ),
                ],
            ]
        );
        
        $this->add_control(
            'no_wrap',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'No Wrap', 'solutech' ),
                'default' => 'no',
                'label_off' => esc_html__( 'Off', 'solutech' ),
                'label_on' => esc_html__( 'On', 'solutech' ),
            ]
        );

        $this->add_control(
            'bottom_padding_style',
            [
                'label' => esc_html__( 'Bottom padding style', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default', 'solutech' ),
                    'custom' => esc_html__( 'Custom', 'solutech' ),
                ],
            ]
        );

        $this->add_responsive_control(
            'bottom_padding',
            [
                'type' => Controls_Manager::SECTION,
                'label' => esc_html__( 'Bottom padding', 'solutech' ),
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 120,
                    ],
                ],
                'size_units' => [ 'px' ],
                'default' => [
                    'size' => 60,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .pix-section-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'bottom_padding_style' => 'custom',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $title = $settings['title'];
        $no_wrap = ($settings['no_wrap'] === 'yes') ? 'pix-no-wrap' : '';
        $pre_title = ($settings['pre_title'] == '') ? '' : '<div class="pix-pre-title"><span>'.wp_kses($settings['pre_title'], 'post').'</span></div>';
        $after_title_text = ($settings['after_title_text'] == '') ? '' : '<p>'.wp_kses($settings['after_title_text'], 'post').'</p>';

        if ( ! empty( $title ) ) {
            echo '
            <div class="pix-section-title ' . esc_attr( $settings['position'] ) . '">
                '.wp_kses($pre_title, 'post').'
                <h2 class="pix-title-h2 ' . esc_attr( $no_wrap ) . '">' . $title . '</h2>
                '.wp_kses($after_title_text, 'post').'
            </div>';
        }
    }

    protected function content_template() {
        ?>
        <#
            var title = settings.title,
                pre_title = settings.pre_title,
                after_title_text = settings.after_title_text;
            #>
            <# if ( '' !== title ) { #>
                <div class="pix-section-title {{{ settings.position }}}">
                    <# if ( '' !== pre_title ) { #>
                    <div class="pix-pre-title"><span>{{{ pre_title }}}</span></div>
                    <# } #>
                    <h2 class="pix-title-h2 {{{ settings.no_wrap }}}">{{{ title }}}</h2>
                    <# if ( '' !== after_title_text ) { #>
                    <p>{{{ after_title_text }}}</p>
                    <# } #>
                </div>
            <# } #>
        <?php
    }
}
