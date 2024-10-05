<?php

if ( ! function_exists( 'elementor_location_exits' ) || ! elementor_location_exits( 'footer', true ) ) {

    get_template_part( 'template-parts/footer/default' );

} else {
    
    if ( function_exists( 'elementor_theme_do_location' ) ) {

        get_template_part( 'template-parts/footer/elementor' );

    }

}
