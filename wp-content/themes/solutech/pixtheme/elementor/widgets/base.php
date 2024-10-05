<?php

namespace Pixtheme_Elementor;

use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

abstract class Base extends Widget_Base {

    public function get_categories() {
        return [ 'pixtheme' ];
    }

}
