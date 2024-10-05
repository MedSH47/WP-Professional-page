<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Social_Icons extends Base {

    public function get_name() {
        return 'pixtheme-social-icons';
    }

    public function get_title() {
        return esc_html__( 'Social Icons', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-social-icons';
    }

    public function get_keywords() {
        return [ 'social', 'icon', 'link' ];
    }

    protected function register_controls() {
        $this->add_section_content();
        $this->add_section_style();
    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Social Icons', 'solutech' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'social_icon',
            [
                'label' => esc_html__( 'Icon', 'solutech' ),
                'type' => Controls_Manager::ICONS,
                'fa4compatibility' => 'social',
                'default' => [
                    'value' => 'fab fa-youtube',
                    'library' => 'fa-brands',
                ],
                'recommended' => Widget_Options::get_list_recommended_social_icons(),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'solutech' ),
                'type' => Controls_Manager::URL,
                'show_external' => true,
                'default' => [
                    'url'         => '',
                    'is_external' => true,
                    'nofollow'    => true,
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'solutech' ),
            ]
        );

        $repeater->add_control(
            'icon_color_type',
            [
                'label' => esc_html__( 'Color', 'solutech' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Official Color', 'solutech' ),
                    'custom' => esc_html__( 'Custom', 'solutech' ),
                ],
            ]
        );

        $repeater->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'icon_color_type' => 'custom',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.pix-social-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.pix-social-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__( 'Hover Color', 'solutech' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'icon_color_type' => 'custom',
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.pix-social-icon:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} {{CURRENT_ITEM}}.pix-social-icon:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'social_icon_list',
            [
                'label' => esc_html__( 'Social Icons', 'solutech' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'social_icon' => [
                            'value' => 'fab fa-twitter',
                            'library' => 'fa-brands',
                        ],
                        'link'  => [
                            'url'         => '#',
                            'is_external' => true,
                            'nofollow'    => true,
                        ],
                    ],
                    [
                        'social_icon' => [
                            'value' => 'fab fa-linkedin',
                            'library' => 'fa-brands',
                        ],
                        'link'  => [
                            'url'         => '#',
                            'is_external' => true,
                            'nofollow'    => true,
                        ],
                    ],
                    [
                        'social_icon' => [
                            'value' => 'fab fa-facebook',
                            'library' => 'fa-brands',
                        ],
                        'link'  => [
                            'url'         => '#',
                            'is_external' => true,
                            'nofollow'    => true,
                        ],
                    ],
                    [
                        'social_icon' => [
                            'value' => 'fab fa-instagram',
                            'library' => 'fa-brands',
                        ],
                        'link'  => [
                            'url'         => '#',
                            'is_external' => true,
                            'nofollow'    => true,
                        ],
                    ],
                ],
                'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( social_icon, social, true, migrated, true ) }}}',
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

    private function add_section_style() {
        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Icon', 'solutech' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'flex_align',
            [
                'label' => esc_html__( 'Alignment', 'solutech' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__( 'Left', 'solutech' ),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'solutech' ),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__( 'Right', 'solutech' ),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .pix-social' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icons_size',
            [
                'label' => esc_html__( 'Size', 'solutech' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pix-social-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $icon_spacing = is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};';

        $this->add_responsive_control(
            'icons_spacing',
            [
                'label' => esc_html__( 'Spacing', 'solutech' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .pix-social-icon:not(:last-child)' => $icon_spacing,
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => esc_html__( 'Hover Animation', 'solutech' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $fallback_defaults = [
            'fa fa-twitter',
            'fa fa-facebook',
            'fa fa-linkedin',
            'fa fa-instagram',
        ];

        $class_animation = '';

        if ( ! empty( $settings['hover_animation'] ) ) {
            $class_animation = ' elementor-animation-' . $settings['hover_animation'];
        }

        $migration_allowed = Icons_Manager::is_migration_allowed();

        ?>
        <div class="pix-social">
            <?php
            foreach ( $settings['social_icon_list'] as $index => $item ) {
                $migrated = isset( $item['__fa4_migrated']['social_icon'] );
                $is_new = empty( $item['social'] ) && $migration_allowed;
                $social = '';

                // add old default
                if ( empty( $item['social'] ) && ! $migration_allowed ) {
                    $item['social'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
                }

                if ( ! empty( $item['social'] ) ) {
                    $social = str_replace( 'fa fa-', '', $item['social'] );
                }

                if ( ( $is_new || $migrated ) && 'svg' !== $item['social_icon']['library'] ) {
                    $social = explode( ' ', $item['social_icon']['value'], 2 );
                    if ( empty( $social[1] ) ) {
                        $social = '';
                    } else {
                        $social = str_replace( 'fa-', '', $social[1] );
                    }
                }
                if ( 'svg' === $item['social_icon']['library'] ) {
                    $social = get_post_meta( $item['social_icon']['value']['id'], '_wp_attachment_image_alt', true );
                }

                $link_key = 'link_' . $index;

                $this->add_render_attribute( $link_key, 'class', [
                    'pix-social-icon',
                    'pix-social-icon-' . $social . $class_animation,
                    'elementor-repeater-item-' . $item['_id'],
                ] );

                $this->add_link_attributes( $link_key, $item['link'] );

                echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
                    echo '<span class="elementor-screen-only">' . ucwords( $social ) . '</span>';

                    if ( $is_new || $migrated ) {
                        Icons_Manager::render_icon( $item['social_icon'] );
                    } else {
                        echo '<i class="' . esc_attr( $item['social'] ) . '"></i>';
                    }
                echo '</a>';
            } ?>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <# var iconsHTML = {}; #>
        <div class="pix-social">
            <# _.each( settings.social_icon_list, function( item, index ) {
                var link = item.link ? item.link.url : '',
                    migrated = elementor.helpers.isIconMigrated( item, 'social_icon' );
                    social = elementor.helpers.getSocialNetworkNameFromIcon( item.social_icon, item.social, false, migrated );
                #>
                <a class="pix-social-icon pix-social-icon-{{ social }} elementor-animation-{{ settings.hover_animation }} elementor-repeater-item-{{item._id}}" href="{{ link }}">
                    <span class="elementor-screen-only">{{{ social }}}</span>
                    <#
                        iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.social_icon, {}, 'i', 'object' );
                        if ( ( ! item.social || migrated ) && iconsHTML[ index ] && iconsHTML[ index ].rendered ) { #>
                            {{{ iconsHTML[ index ].value }}}
                        <# } else { #>
                            <i class="{{ item.social }}"></i>
                        <# }
                    #>
                </a>
            <# } ); #>
        </div>
        <?php
    }
}
