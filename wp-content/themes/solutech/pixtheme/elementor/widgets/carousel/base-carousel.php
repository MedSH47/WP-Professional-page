<?php

namespace Pixtheme_Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

abstract class Base_Carousel extends Base {

    protected $slide_prints_count = 0;

    protected function register_controls() {
        $this->add_section_options();
    }

    private function add_section_options() {
        $this->start_controls_section(
            'section_carousel_options',
            [
                'label' => esc_html__( 'Carousel Options', 'solutech' ),
            ]
        );
        
        $this->add_control(
			'slider',
			[
				'label' => esc_html__( 'Carousel', 'solutech' ),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => 'on',
                'default' => 'on',
			]
		);

        $this->add_responsive_control(
            'slides_per_view',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__( 'Slides Per View', 'solutech' ),
                'description' => esc_html__( "Number of slides per view (slides visible at the same time on slider's container).", 'solutech' ),
                'options'  => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ),
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
            ]
        );

         $this->add_responsive_control(
            'slides_per_group',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__( 'Slides per swipe.', 'solutech' ),
                'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'solutech' ),
                'options'  => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                    '7' => '7',
                    '8' => '8',
                    '9' => '9',
                    '10' => '10',
                ),
                'default'        => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
                'condition' => [
                    'slider' => 'on',
                ],
            ]
        );

        $this->add_responsive_control(
            'slides_per_column',
            [
                'type' => Controls_Manager::SELECT,
                'label' => esc_html__( 'Number of slides per column', 'solutech' ),
                'description' => esc_html__( 'Number of slides per column, for multirow layout ( Number of slides per column > 1) is currently not compatible with loop mode (loop: true)', 'solutech' ),
                'options'  => array(
                    '1' => '1',
                    '2' => '2',
                ),
                'default'        => '1',
                'tablet_default' => '1',
                'mobile_default' => '1',
                'condition' => [
                    'slider' => 'on',
                ],
            ]
        );

        $this->add_responsive_control(
            'space',
            [
                'label'   => esc_html__( 'Space Between', 'solutech' ),
                'type'    => Controls_Manager::NUMBER,
                'min'     => 0,
                'max'     => 200,
                'step'    => 1,
                'default' => 30,
            ]
        );

        $this->add_control(
            'speed',
            [
                'label'   => esc_html__( 'Transition Duration', 'solutech' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1000,
                'condition' => [
                    'slider' => 'on',
                ],
            ]
        );

        $this->add_control(
            'loop',
            [
                'label'   => esc_html__( 'Infinite Loop', 'solutech' ),
                'description' => esc_html__( 'For multirow layout ( Number of slides per column > 1) is currently not compatible with loop mode (loop: true)', 'solutech' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
                'condition' => [
                    'slider' => 'on',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__( 'Auto Play', 'solutech' ),
                'description' => esc_html__( 'Delay between transitions (in ms). For e.g: 3000. Leave blank to disabled. Input 1 to make smooth transition.', 'solutech' ),
                'type' => Controls_Manager::NUMBER,
                'default' => '',
                'condition' => [
                    'slider' => 'on',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label'   => esc_html__( 'Pause on Hover', 'solutech' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => [
                    'slider' => 'on',
                ],
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Arrows', 'solutech' ),
                'default' => 'yes',
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'label_on' => esc_html__( 'Show', 'solutech' ),
                'condition' => [
                    'slider' => 'on',
                ],
            ]
        );

        $this->add_control(
            'show_dots',
            [
                'type' => Controls_Manager::SWITCHER,
                'label' => esc_html__( 'Dots', 'solutech' ),
                'default' => 'yes',
                'label_off' => esc_html__( 'Hide', 'solutech' ),
                'label_on' => esc_html__( 'Show', 'solutech' ),
                'condition' => [
                    'slider' => 'on',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function update_slider_settings( $settings, $slider_settings ) {
        return $slider_settings;
    }

    protected function get_slider_settings( array $settings ) {
    	
    	$col = isset($settings['slides_per_column']) ? $settings['slides_per_column'] : 5;
        $slider = isset($settings['slider']) && $settings['slider'] == 'on' ? 'pix-swiper pix-swiper-widget' : 'pix-swiper-disable pix-col-'.$col;
    	
        $slider_settings = [
            'class' => [ $slider ],
            'data-lg-slides-per-view' => isset($settings['slides_per_view']) ? $settings['slides_per_view'] : 3,
            'data-md-slides-per-view' => isset($settings['slides_per_view_tablet']) ? $settings['slides_per_view_tablet'] : 2,
            'data-sm-slides-per-view' => isset($settings['slides_per_view_mobile']) ? $settings['slides_per_view_mobile'] : 1,
            'data-lg-slides-per-group' => isset($settings['slides_per_group']) ? $settings['slides_per_group'] : 3,
            'data-md-slides-per-group' => isset($settings['slides_per_group_tablet']) ? $settings['slides_per_group_tablet'] : 2,
            'data-sm-slides-per-group' => isset($settings['slides_per_group_mobile']) ? $settings['slides_per_group_mobile'] : 1,
            'data-lg-slides-per-column' => isset($settings['slides_per_column']) ? $settings['slides_per_column'] : 3,
            'data-md-slides-per-column' => isset($settings['slides_per_column_tablet']) ? $settings['slides_per_column_tablet'] : 2,
            'data-sm-slides-per-column' => isset($settings['slides_per_column_mobile']) ? $settings['slides_per_column_mobile'] : 1,
            'data-lg-space' => isset($settings['space']) ? $settings['space'] : '40',
            'data-md-space' => isset($settings['space_tablet']) ? $settings['space_tablet'] : '30',
            'data-sm-space' => isset($settings['space_mobile']) ? $settings['space_mobile'] : '20',
        ];

        if ( ! empty( $settings['speed'] ) ) {
            $slider_settings['data-speed'] = $settings['speed'];
        }

        if ( ! empty( $settings['autoplay'] ) ) {
            $slider_settings['data-autoplay'] = $settings['autoplay'];
        }

        if ( ! empty( $settings['pause_on_hover'] ) && 'yes' === $settings['pause_on_hover'] ) {
            $slider_settings['data-pause-on-hover'] = '1';
        }

         if ( ! empty( $settings['loop'] ) && 'yes' === $settings['loop'] ) {
            $slider_settings['data-loop'] = '1';
        }

        if ( ! empty( $settings['show_arrows'] ) && 'yes' === $settings['show_arrows'] ) {
            $slider_settings['data-arrows'] = '1';
        }

        if ( ! empty( $settings['show_dots'] ) && 'yes' === $settings['show_dots'] ) {
            $slider_settings['data-dots'] = '1';
        }

        if ( ! empty( $settings['vertical_align'] ) ) {
            $slider_settings['class'][] = 'v-' . $settings['vertical_align'];
        }

        if ( ! empty( $settings['horizontal_align'] ) ) {
            $slider_settings['class'][] = 'h-' . $settings['horizontal_align'];
        }

        $slider_settings = $this->update_slider_settings( $settings, $slider_settings );

        return $slider_settings;
    }

    protected function get_slide_image_url( $slide, array $settings, $image_size_key = 'image_size' ) {
        $image_url = Group_Control_Image_Size::get_attachment_image_src( $slide['image']['id'], $image_size_key, $settings );

        if ( ! $image_url ) {
            $image_url = $slide['image']['url'];
        }

        return $image_url;
    }

    protected function get_slide_image_alt( $slide, array $settings ) {
        $image_alt = get_post_meta( $slide['image']['id'], '_wp_attachment_image_alt', true );

        return $image_alt;
    }

    protected function render() {
        $this->print_slider();
    }

}
