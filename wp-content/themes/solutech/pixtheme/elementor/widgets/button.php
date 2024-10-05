<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Button extends Base {

    public function get_name() {
        return 'pixtheme-button';
    }

    public function get_title() {
        return esc_html__( 'Button', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_keywords() {
        return [ 'button' ];
    }

    protected function register_controls() {
        $this->add_section_content();

    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Button', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => esc_html__( 'Type', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'btn-accent',
                'options' => [
                    'btn-accent' => esc_html__( 'Classic - Accent color', 'solutech' ),
                    'btn-compliment' => esc_html__( 'Classic - Compliment color', 'solutech' ),
                    'btn-black' => esc_html__( 'Classic - Black color', 'solutech' ),
                    'btn-outline-accent' => esc_html__( 'Outline - Accent color', 'solutech' ),
                    'btn-outline-compliment' => esc_html__( 'Outline - Compliment color', 'solutech' ),
                    'btn-outline-black' => esc_html__( 'Outline - Black color', 'solutech' ),
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
                'default' => esc_html__( 'Click here', 'solutech' ),
                'placeholder' => esc_html__( 'Click here', 'solutech' ),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'solutech' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'solutech' ),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__( 'Alignment', 'solutech' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => esc_html__( 'Left', 'solutech' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'solutech' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'solutech' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justified', 'solutech' ),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
            ]
        );

        $this->add_control(
            'size',
            [
                'label' => esc_html__( 'Size', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__( 'Default', 'solutech' ),
                    'btn-sm' => esc_html__( 'Small', 'solutech' ),
                    'btn-lg' => esc_html__( 'Big', 'solutech' ),
                ],
                'style_transfer' => true,
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__( 'Icon', 'solutech' ),
                'type' => Controls_Manager::ICONS,
                'recommended' => Widget_Options::get_list_recommended_social_icons(),
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label' => esc_html__( 'Icon Position', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => esc_html__( 'Before', 'solutech' ),
                    'right' => esc_html__( 'After', 'solutech' ),
                ],
                'condition' => [
                    'icon[value]!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label' => esc_html__( 'Icon Spacing', 'solutech' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'default'        => [
                    'size' => 7,
                ],
                'selectors' => [
                    '{{WRAPPER}} .pix-btn-wrapper .pix-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .pix-btn-wrapper .pix-align-icon-left' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__( 'View', 'solutech' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'wrapper', 'class', 'pix-btn-wrapper' );

        if ( ! empty( $settings['align'] ) ) {
            $this->add_render_attribute( 'wrapper', 'class', 'text-' . $settings['align'] );
        }

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_link_attributes( 'button', $settings['link'] );
        }

        $this->add_render_attribute( 'button', 'class', 'btn' );
        $this->add_render_attribute( 'button', 'role', 'button' );

        if ( ! empty( $settings['type'] ) ) {
            $this->add_render_attribute( 'button', 'class', $settings['type'] );
        }

        if ( ! empty( $settings['size'] ) ) {
            $this->add_render_attribute( 'button', 'class', $settings['size'] );
        }

        $icon_align = $settings['icon_align'];

        echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) . '>';
            echo '<a ' . $this->get_render_attribute_string( 'button' ) . '>';
                if ( ! empty( $settings['icon']['value'] ) && 'left' === $icon_align ) :
                    echo '<span class="pix-align-icon-' . esc_attr( $icon_align ) . '">';
                    Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
                    echo '</span>';
                endif;
                echo '<span>' . $settings['text'] . '</span>';
                if ( ! empty( $settings['icon']['value'] ) && 'right' === $icon_align ) :
                    echo '<span class="pix-align-icon-' . esc_attr( $icon_align ) . '">';
                    Icons_Manager::render_icon( $settings['icon'], [ 'aria-hidden' => 'true' ] );
                    echo '</span>';
                endif;
            echo '</a>';
        echo '</div>';

    }

    protected function content_template() {
        ?>
        <#
            var iconsHTML = {};
            var iconAlign = settings.icon_align;

            if ( settings.icon ) {
                iconsHTML = elementor.helpers.renderIcon( view, settings.icon, {}, 'i', 'object' );
            }
            #>
            <div class="pix-btn-wrapper text-{{{ settings.align }}}">
                <a class="btn {{{ settings.type }}} {{{ settings.size }}}" href="{{{ settings.link.url }}}" role="button">
                    <# if ( settings.icon && 'left' === iconAlign ) { #>
                        <span class="pix-align-icon-{{{ iconAlign }}}">
                            {{{ iconsHTML.value }}}
                        </span>
                    <# } #>
                    <span>{{{ settings.text }}}</span>
                    <# if ( settings.icon && 'right' === iconAlign ) { #>
                        <span class="pix-align-icon-{{{ iconAlign }}}">
                            {{{ iconsHTML.value }}}
                        </span>
                    <# } #>
                </a>
            </div>
        <?php
    }

}
