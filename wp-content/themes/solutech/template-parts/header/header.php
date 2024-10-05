<?php

if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) :

    $post_ID = isset( $wp_query ) ? $wp_query->get_queried_object_id() : ( get_the_ID() > 0 ? get_the_ID() : '' );

    $solutech_header_color = ( in_array( get_post_meta( $post_ID, 'solutech_header_color', true ), array( 'global', '' ) ) || $post_ID == '' ) ? solutech_get_option( 'header_color', 'text-default' ) : get_post_meta( $post_ID, 'solutech_header_color', true );
    $solutech_header_sticky = solutech_get_option( 'header_sticky', '' );
    
    ?>

    <header class="header <?php echo esc_attr( $solutech_header_color ); ?> <?php echo esc_attr( $solutech_header_sticky ); ?>">
        <?php
        if ( !is_page_template( 'templates/home-template.php' ) && class_exists( 'Pix_Settings' ) && solutech_get_option( 'use_bg_parallax', true ) ) :
            ?>
            <div id="parallax" class="parallax-levels in-header">
                <div class="level1">
                    <div class="parallax-item-1 h-3 parallax-item left"></div>
                    <div class="parallax-item-4 h-5 parallax-item right"></div>
                </div>
                <div class="level2">
                    <div class="parallax-item-2 h-2 parallax-item right"></div>
                    <div class="parallax-item-3 h-4 parallax-item left"></div>
                    <div class="parallax-item-6 h-7 parallax-item left"></div>
                    <div class="parallax-item-7 h-6 parallax-item left"></div>
                </div>
                <div class="level3">
                    <div class="parallax-item-5 h-4 parallax-item left"></div>
                    <div class="parallax-item-8 h-8 parallax-item left"></div>
                    <div class="parallax-item-13 h-12 parallax-item right"></div>
                </div>
            </div>
            <?php
        endif;
        
        get_template_part( 'template-parts/header/header', 'navigation' );
        if ( ! is_page_template( 'templates/home-template.php' ) ) :
            get_template_part( 'template-parts/header/header', 'title' );
        endif;
        ?>
    </header>

<?php
endif;
