<?php

namespace Pixtheme_Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Scripts {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {

        add_action( 'elementor/frontend/after_register_scripts', [ $this, 'after_register_scripts' ] );

        add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'enqueue_editor_scripts' ] );

    }

    /**
     * Register scripts for widgets.
     */
    public function after_register_scripts() {
        $theme_version = wp_get_theme()->get( 'Version' );

        $lg_breakpoint = (int) ( class_exists( '\Elementor\Core\Responsive\Responsive' ) && ! empty( $lg_breakpoint = \Elementor\Core\Responsive\Responsive::get_breakpoints()['lg'] ) ) ? $lg_breakpoint : 1025;
        $md_breakpoint = (int) ( class_exists( '\Elementor\Core\Responsive\Responsive' ) && ! empty( $md_breakpoint = \Elementor\Core\Responsive\Responsive::get_breakpoints()['md'] ) ) ? $md_breakpoint : 768;

        wp_register_script( 'pixtheme-swiper-options', get_template_directory_uri() . '/assets/elementor/js/swiper-options.js', array( 'jquery', 'swiper' ), $theme_version, true );

        wp_localize_script( 'pixtheme-swiper-options', 'pixtheme_swiper_options', array(
            'lg' => $lg_breakpoint,
            'md' => $md_breakpoint
        ) );

        wp_register_script( 'pixtheme-widgets-carousel', get_template_directory_uri() . '/pixtheme/elementor/assets/js/widgets/widgets-carousel.js', array( 'jquery', 'swiper', 'pixtheme-swiper-options' ), $theme_version, true );

        wp_register_script( 'countdown', get_template_directory_uri() . '/assets/elementor/js/countdown.min.js', array( 'jquery' ) , NULL, true );
        wp_register_script( 'pixtheme-widgets-countdown', get_template_directory_uri() . '/pixtheme/elementor/assets/js/widgets/widgets-countdown.js', array( 'jquery', 'countdown' ) , $theme_version, true );

        wp_register_script( 'pixtheme-widgets-slider-images', get_template_directory_uri() . '/pixtheme/elementor/assets/js/widgets/widgets-slider-images.js', array( 'jquery' ) , $theme_version, true );

        if ( pixtheme_use_woo() ) {
            wp_register_script( 'pixtheme-widgets-products-filter', get_template_directory_uri() . '/pixtheme/elementor/assets/js/widgets/widgets-products-filter.js', array( 'jquery', 'pixtheme-woo-custom' ) , $theme_version, true );
        }
        
        if ( pixtheme_use_portfolio() ) {
        	wp_register_script( 'pixtheme-widgets-projects-filter', get_template_directory_uri() . '/pixtheme/elementor/assets/js/widgets/widgets-projects-filter.js', array( 'jquery', 'swiper' ) , $theme_version, true );
        }

        wp_register_script( 'isotope-masonry', get_template_directory_uri() . '/assets/elementor/js/isotope.min.js', array( 'jquery', 'imagesloaded' ) , NULL, true );
        wp_register_script( 'pixtheme-widgets-isotope', get_template_directory_uri() . '/pixtheme/elementor/assets/js/widgets/widgets-isotope.js', array( 'jquery', 'imagesloaded', 'isotope-masonry' ), $theme_version, true );

    }

    /**
     * enqueue scripts in editor mode.
     */
    public function enqueue_editor_scripts() {
        $theme_version = wp_get_theme()->get( 'Version' );
        wp_enqueue_script( 'pixtheme-elementor-editor', get_template_directory_uri() . '/pixtheme/elementor/assets/js/editor.js', array( 'jquery' ), $theme_version, true );
    }

}

Widget_Scripts::instance();
