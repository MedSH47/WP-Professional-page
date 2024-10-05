<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Logos_Carousel extends Base_Carousel {

    public function get_name() {
        return 'pixtheme-logos-carousel';
    }

    public function get_title() {
        return esc_html__( 'Logos Carousel', 'solutech' );
    }

    public function get_icon() {
        return 'eicon-posts-carousel';
    }

    public function get_keywords() {
        return [ 'logo', 'carousel', 'image' ];
    }

    public function get_script_depends() {
        return [ 'pixtheme-widgets-carousel' ];
    }

    protected function register_controls() {
        $this->add_section_content();
        parent::register_controls();
        $this->update_controls();
    }

    private function add_section_content() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'solutech' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__( 'Image', 'solutech' ),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => esc_html__( 'Link', 'solutech' ),
                'type' => Controls_Manager::URL,
                'default' => [
                    'is_external' => 'true',
                    'nofollow' => 'true',
                ],
                'placeholder' => esc_html__( 'https://your-link.com', 'solutech' ),
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => esc_html__( 'Slides', 'solutech' ),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $this->get_repeater_defaults(),
                'separator' => 'after',
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'type' => Controls_Manager::SLIDER,
                'label' => esc_html__( 'Height', 'solutech' ),
                'size_units' => [ 'px' ],
                'default'        => [
                    'size' => 75,
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
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .logos__item' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_size',
                'default' => 'full',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    protected function get_repeater_defaults() {
        $placeholder_image_src = Utils::get_placeholder_image_src();

        return [
            [
                'image' => [
                    'url' => $placeholder_image_src,
                ],
            ],
            [
                'image' => [
                    'url' => $placeholder_image_src,
                ],
            ],
            [
                'image' => [
                    'url' => $placeholder_image_src,
                ],
            ],
            [
                'image' => [
                    'url' => $placeholder_image_src,
                ],
            ],
            [
                'image' => [
                    'url' => $placeholder_image_src,
                ],
            ],
            [
                'image' => [
                    'url' => $placeholder_image_src,
                ],
            ]
        ];
    }

    private function update_controls() {
        $this->update_responsive_control(
            'slides_per_view',
            [
                'default' => '6',
                'tablet_default' => '4',
                'mobile_default' => '2',
            ]
        );

        $this->update_responsive_control(
            'slides_per_group',
            [
                'default' => '6',
                'tablet_default' => '4',
                'mobile_default' => '2',
            ]
        );

        $this->update_responsive_control(
            'slides_per_column',
            [
                'default'        => '6',
                'tablet_default' => '4',
                'mobile_default' => '2',
            ]
        );

        $this->update_control(
            'show_arrows',
            [
                'type' => Controls_Manager::HIDDEN,
                'default' => 'no',
            ]
        );
    }

    protected function print_slider( array $settings = null ) {
        if ( null === $settings ) {
            $settings = $this->get_settings_for_display();
        }

        $slider_settings = $this->get_slider_settings( $settings );

        $this->add_render_attribute( 'slider', $slider_settings );
        
        $slides_count = count( $settings['slides'] );
        ?>

        <div <?php $this->print_render_attribute_string( 'slider' ); ?>>
            <div class="swiper-container logos">
                <div class="swiper-wrapper">
                    <?php
                    foreach ( $settings['slides'] as $index => $slide ) :
                        $this->slide_prints_count++;
                        ?>
                        <div class="swiper-slide">
                            <div class="logos__item">
                                <?php $this->print_slide( $slide, $settings, 'slide-' . $index . '-' . $this->slide_prints_count ); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ( ! empty( $settings['show_dots'] ) && 'yes' === $settings['show_dots']  ) : ?>
                    <div class="swiper-pagination-wrap"></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    protected function print_slide( array $slide, array $settings, $element_key ) {

        if ( ! empty( $slide['image']['url'] ) ) {
            $this->add_render_attribute( $element_key . '-image', [
                'src' => $this->get_slide_image_url( $slide, $settings ),
                'alt' => $this->get_slide_image_alt( $slide, $settings ),
            ] );
        }

        ?>

        <?php if ( $slide['image']['url'] ) : ?>
            <?php
            $link_url = empty( $slide['link']['url'] ) ? false : $slide['link']['url'];
            $image_wrapper_tag = ! empty( $link_url ) ? 'a' : 'div';
            $image_wrapper_element = 'image_wrapper_' . $slide['_id'];

            $this->add_render_attribute( $image_wrapper_element, 'class', 'logos__item-image' );

            if ( ! empty( $link_url ) ) {
                $this->add_render_attribute( $image_wrapper_element, 'href', $link_url );

                if ( $slide['link']['is_external'] ) {
                    $this->add_render_attribute( $image_wrapper_element, 'target', '_blank' );
                }

                if ( ! empty( $slide['link']['nofollow'] ) ) {
                    $this->add_render_attribute( $image_wrapper_element, 'rel', 'nofollow' );
                }
            }
            ?>
            <?php printf( '<%1$s %2$s><img %3$s></%1$s>', esc_html( $image_wrapper_tag ), $this->get_render_attribute_string( $image_wrapper_element ), $this->get_render_attribute_string( $element_key . '-image' ) ); ?>

        <?php endif; ?>

        <?php
    }

}
