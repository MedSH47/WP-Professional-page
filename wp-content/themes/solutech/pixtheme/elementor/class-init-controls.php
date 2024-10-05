<?php

namespace Pixtheme_Elementor;

use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

class Control_Init {

    private static $_instance = null;

    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __construct() {
    	foreach (glob(get_template_directory() . '/pixtheme/elementor/controls/*.php') as $filename){
			require_once($filename);
		}
        add_action( 'elementor/controls/controls_registered', array( $this, 'init_controls' ) );
    }


    public function init_controls( $controls_manager ) {
        $controls_manager = Plugin::$instance->controls_manager;
		$controls_manager->register( new Radio_Images_Control() );
		//$controls_manager->register_control( 'products_filter', new Products_Filter_Control() );
    }
}

Control_Init::instance();
