<?php

$solutech_logo = ! empty( $solutech_logo = solutech_get_option( 'logo' ) ) ? $solutech_logo : get_template_directory_uri() . '/assets/img/logo.png';
$solutech_logo = ! empty( $solutech_page_logo_id = solutech_get_post_meta( 'header_logo' ) ) ? wp_get_attachment_image_src( $solutech_page_logo_id, 'full' )[0] : $solutech_logo;

$solutech_logo_width = ! empty( $solutech_logo_width = solutech_get_option( 'logo_width', get_option( 'solutech_default_logo_width' ) ) ) ? $solutech_logo_width : '';
$solutech_logo_style = $solutech_logo_width != '' ? 'width:' . esc_attr( $solutech_logo_width ) . 'px;' : '';
$solutech_logo_style = $solutech_logo_style != '' ? 'style="' . esc_attr( $solutech_logo_style ) . '"' : '';

?>

<div class="menu pix-menu">
    <div class="container">
        <div class="menu__inner">
            <a class="logo mt-lg-0 mt-sm-n20" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( bloginfo( 'name' ) ); ?>" <?php echo wp_kses( $solutech_logo_style, 'strip' ); ?>>
                <img src="<?php echo esc_url( $solutech_logo ); ?>" alt="<?php echo esc_attr( bloginfo( 'name' ) ); ?>"/>
            </a>
            <nav>
                <?php
                if ( solutech_use_woo() && solutech_get_option( 'show_header_catalog', true ) ) : ?>
                    <?php get_template_part( 'template-parts/header/header', 'catalog' ); ?>
                <?php endif; ?>
                <?php echo solutech_site_menu(); ?>
                <a class="menu__burger" href="#" title="<?php echo esc_attr__( 'Menu', 'solutech' ); ?>"><i class="pix-icon-menu"></i></a>
            </nav>
            <ul class="menu__icons">
                <?php if ( solutech_get_option( 'show_header_button', false ) ) : ?>
                    <li>
                        <a class="btn" target="_blank" href="<?php echo esc_url(solutech_get_option( 'header_button_link', '#' )) ?>">
                            <span class="pix-button-ripple-title">
                                <span data-text="<?php echo wp_kses(solutech_get_option( 'header_button_text', esc_attr__( 'Button', 'solutech' ) ), 'post') ?>"><?php echo wp_kses(solutech_get_option( 'header_button_text', esc_attr__( 'Button', 'solutech' ) ), 'post') ?></span>
                            </span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ( solutech_get_option( 'show_header_search', true ) ) : ?>
                    <li class="pix-search-popup">
                        <a href="#"><i class="pix-icon-searching"></i></a>
                        <div class="menu__search">
                            <?php get_search_form(); ?>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if ( solutech_use_compare() && solutech_get_option( 'show_header_compare', true ) ) : ?>

                    <?php $solutech_compare_count = WPCleverWoosc::woosc_get_count();
                    $solutech_compare_count_add_class = ( empty( WPCleverWoosc::woosc_get_count() ) ) ? 'invisible' : '';
                    ?>

                    <li class="menu__iconsLink pix-compare-menu-item">
                        <a href="#" class="<?php echo esc_attr( substr( get_option( 'woosc_open_button', '.pix-open-compare-btn' ), 1 ) ); ?>" title="<?php echo esc_attr__( 'Compare', 'solutech' ); ?>">
                            <i class="pix-icon-reload"></i>
                            <span class="badge <?php echo esc_attr( $solutech_compare_count_add_class ); ?>"><?php echo esc_html( $solutech_compare_count ); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ( solutech_use_wishlist() && solutech_get_option( 'show_header_wishlist', true ) ) : ?>

                    <?php $solutech_wishlist_count = WPCleverWoosw::get_count();
                    $solutech_wishlist_count_add_class = ( empty( WPCleverWoosw::get_count() ) ) ? 'invisible' : '';
                    ?>

                    <li class="menu__iconsLink pix-wishlist-menu-item">
                        <a href="<?php echo esc_url( WPCleverWoosw::get_url() ); ?>" title="<?php echo esc_attr__( 'Open wishlist page', 'solutech' ); ?>">
                            <i class="pix-icon-heart"></i>
                            <span class="badge <?php echo esc_attr( $solutech_wishlist_count_add_class ); ?>"><?php echo esc_html( $solutech_wishlist_count ); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ( solutech_use_woo() && solutech_get_option( 'show_header_cart', true ) ) : ?>
                    <li><?php solutech_header_cart(); ?></li>
                <?php endif; ?>
            </ul>
            <?php if ( solutech_get_option( 'header_facebook', '' ) != '' || solutech_get_option( 'header_twitter', '' ) != '' || solutech_get_option( 'header_instagram', '' ) != '' || solutech_get_option( 'header_linkedin', '' ) != '' || solutech_get_option( 'header_social_custom', '' ) != '' ) : ?>
            <ul class="menu__socials">
                <?php if ( solutech_get_option( 'header_facebook', '' ) != '' ) : ?>
                    <li>
                        <a class="" href="<?php echo esc_url(solutech_get_option( 'header_facebook', '#' )) ?>"><i class="fab fa-facebook"></i></a>
                    </li>
                <?php endif; ?>
                <?php if ( solutech_get_option( 'header_twitter', '' ) != '' ) : ?>
                    <li>
                        <a class="" href="<?php echo esc_url(solutech_get_option( 'header_twitter', '#' )) ?>"><i class="fab fa-twitter"></i></a>
                    </li>
                <?php endif; ?>
                <?php if ( solutech_get_option( 'header_instagram', '' ) != '' ) : ?>
                    <li>
                        <a class="" href="<?php echo esc_url(solutech_get_option( 'header_instagram', '#' )) ?>"><i class="fab fa-instagram"></i></a>
                    </li>
                <?php endif; ?>
                <?php if ( solutech_get_option( 'header_linkedin', '' ) != '' ) : ?>
                    <li>
                        <a class="" href="<?php echo esc_url(solutech_get_option( 'header_linkedin', '#' )) ?>"><i class="fab fa-linkedin"></i></a>
                    </li>
                <?php endif; ?>
                <?php if ( solutech_get_option( 'header_social_custom', '' ) != '' ) : ?>
                    <li>
                        <a class="" href="<?php echo esc_url(solutech_get_option( 'header_social_custom_link', '#' )) ?>"><i class="<?php echo esc_attr(solutech_get_option( 'header_social_custom' )) ?>"></i></a>
                    </li>
                <?php endif; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>
</div>
