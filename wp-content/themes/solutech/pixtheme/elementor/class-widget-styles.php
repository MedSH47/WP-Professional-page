<?php

namespace Pixtheme_Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Widget_Styles {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {

        add_action( 'elementor/frontend/after_register_styles', [ $this, 'after_register_styles' ] );

        add_action( 'elementor/editor/after_enqueue_styles', [ $this, 'enqueue_editor_styles' ] );

    }

    /**
     * Register styles for widgets.
     */
    public function after_register_styles() {

    }

    /**
     * enqueue styles in editor mode.
     */
    public function enqueue_editor_styles() {
        wp_enqueue_style( 'solutech-elementor-editor', get_template_directory_uri() . '/pixtheme/elementor/assets/css/editor.css' );
    }

}

Widget_Styles::instance();
