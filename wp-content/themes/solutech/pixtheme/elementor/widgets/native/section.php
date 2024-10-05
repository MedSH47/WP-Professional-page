<?php

namespace solutech_Elementor;

use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Transform_Widget_Section {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {
        add_action( 'elementor/element/section/section_background/after_section_end', [ $this, 'section_background' ] );
    }

    public function section_background( $element ) {

        $element->start_injection( [
            'type' => 'control',
            'at' => 'before',
            'of' => 'tabs_background',
        ] );

        $element->add_control(
            'bg_global',
            [
                'label' => esc_html__( 'Use Global Section Background', 'solutech' ),
                'description' => esc_html__( 'Leave empty normal background settings for use global section background', 'solutech' ),
                'label_block' => false,
                'type' => Controls_Manager::SWITCHER,
                'prefix_class' => 'pix-elementor-section-',
                'return_value' => 'global-bg',
            ]
        );

        $element->end_injection();

    }
}

Transform_Widget_Section::instance();
