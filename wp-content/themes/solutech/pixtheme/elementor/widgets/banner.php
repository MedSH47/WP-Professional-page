<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Banner extends Base {

    public function get_name() {
        return 'pixtheme-banner';
    }

    public function get_title() {
        return esc_html__( 'Banner', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-image-rollover';
    }

    public function get_keywords() {
        return [ 'banner' ];
    }

    protected function register_controls() {
        $this->add_section_content();

    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Banner', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__( 'Choose Image', 'solutech' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__( 'Text', 'solutech' ),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => '',
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__( 'Normal', 'solutech' ),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__( 'Text color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .banner__info > span' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'text!' => '',
                ],
            ]
        );

        $this->add_control(
            'text_border_color',
            [
                'label' => esc_html__( 'Text border color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#fff',
                'selectors' => [
                    '{{WRAPPER}} .banner__info > span' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'text!' => '',
                ],
            ]
        );

        $this->add_control(
            'text_bg_color',
            [
                'label' => esc_html__( 'Text background color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner__info > span' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'text!' => '',
                ],
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => esc_html__( 'Overlay color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .banner__info' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__( 'Hover', 'solutech' ),
            ]
        );

        $this->add_control(
            'hover_text_color',
            [
                'label' => esc_html__( 'Hover Text color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .banner__info > span' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'text!' => '',
                ],
            ]
        );

        $this->add_control(
            'hover_text_border_color',
            [
                'label' => esc_html__( 'Hover Text border color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .banner__info > span' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'text!' => '',
                ],
            ]
        );

        $this->add_control(
            'hover_text_bg_color',
            [
                'label' => esc_html__( 'Hover Text background color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .banner__info > span' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'text!' => '',
                ],
            ]
        );

        $this->add_control(
            'hover_overlay_color',
            [
                'label' => esc_html__( 'Hover Overlay color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .banner__info' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'solutech' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'solutech' ),
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'solutech' ),
                'description' => esc_html__( 'Leave empty to use auto height (100%)', 'solutech' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'default' => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .banner' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $link_url = $settings['link']['url'];
        $box_tag = ! empty( $link_url ) ? 'a' : 'div';

        if ( ! empty( $link_url ) ) {
            $this->add_link_attributes( 'banner', $settings['link'] );
        }

        $this->add_render_attribute( 'banner', 'class', 'banner' );

        echo '<' . esc_html( $box_tag ) . ' ' . $this->get_render_attribute_string( 'banner' ) . '>';
        if ( ! empty( $settings['image']['url'] ) ) :
            echo '<span class="banner__img"><img src="' . $settings['image']['url'] . '" alt="' . get_post_meta( $settings['image']['id'], '_wp_attachment_image_alt', true ) . '"></span>';
        endif;
        echo '<span class="banner__info">';
        if ( ! empty( $text = $settings['text'] ) ) :
            echo '<span>' . esc_html( $text ) . '</span>';
        endif;
        echo '</span>';
        echo '</' . esc_html( $box_tag ) . '>';

    }
    protected function content_template() {
        ?>
        <#
            var url = settings.link.url;
            var text= settings.text;
            var imageurl = settings.image.url;
            #>

            <# if ( url ) { #>
                <a href="{{{ url }}}" class="banner">
            <# } else { #>
                <div class="banner">
            <# } #>

                <# if ( '' !== imageurl ) { #>
                    <span class="banner__img"><img src="{{{ imageurl }}}"/></span>
                <# } #>

                <span class="banner__info">
                <# if ( '' !== text ) { #>
                    <span>{{{ text }}}</span>
                <# } #>
                </span>

            <# if ( url ) { #>
                </a>
            <# } else { #>
                </div>
            <# } #>

        <?php
    }

}
