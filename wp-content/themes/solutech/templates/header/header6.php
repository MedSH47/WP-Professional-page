<?php /* Header Type 5 */
$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : get_the_ID();
if( class_exists( 'WooCommerce' ) && pixtheme_is_woo_page() && pixtheme_get_option('woo_header_global','1') ){
    $post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
} elseif (!is_page_template('page-home.php') && get_option('page_for_posts') && pixtheme_get_option('header_like_blog','0')){
    $post_ID = get_option('page_for_posts') ? get_option('page_for_posts') : 0;
}

$pixtheme_header = apply_filters('pixtheme_header_settings', $post_ID);
$pixtheme_header['header_background'] = $pixtheme_header['header_background'] == '' ? 'white' : $pixtheme_header['header_background'];
$pixtheme_header_transparent = $pixtheme_header['header_transparent'] < 100 ? 'transparent' : '';
$pixtheme_logo = $pixtheme_header['header_background'] == 'black' ? $pixtheme_header['logo'] : $pixtheme_header['logo_inverse'];

$pixtheme_logo_stl = pixtheme_get_option('general_settings_logo_width', get_option('pixtheme_default_logo_width')) != '' ? 'width:'.esc_attr(pixtheme_get_option('general_settings_logo_width', get_option('pixtheme_default_logo_width'))).'px;' : '';
$pixtheme_logo_stl = $pixtheme_logo_stl != '' ? 'style="'.($pixtheme_logo_stl).'"' : '';

$pixtheme_logo_text = pixtheme_get_option('general_settings_logo_text') != '' ? '<div class="logo-text">'.wp_kses_post(pixtheme_get_option('general_settings_logo_text')).'</div>' : '';

?>

<div class="pix-header menu-aroundblock <?php echo esc_attr($pixtheme_header['header_background']) ?> <?php echo esc_attr( $pixtheme_header_transparent ) ?> <?php echo esc_attr($pixtheme_header['header_sticky']) ?>">
    <div class="<?php echo esc_attr($pixtheme_header['header_layout']) ?>">

        <div class="row">
            <div class="col-md-4">
                <nav>
                    <ul>
                        <li id="js-slide-menu"><i class="fa fa-bars" aria-hidden="true"></i></li>
                    </ul>
                </nav>
            </div>

            <div class="col-md-4">
                <div class="menu-logo">
                    <a class="navbar-brand scroll" href="<?php echo esc_url(home_url('/')) ?>" <?php echo wp_kses_post($pixtheme_logo_stl)?>>
                        <?php if ($pixtheme_logo): ?>
                            <img class="normal-logo"
                                 src="<?php echo esc_url($pixtheme_logo) ?>"
                                 alt="<?php esc_attr_e('Logo', 'solutech') ?>"/>
                        <?php else: ?>
                            <img class="normal-logo"
                                 src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php esc_attr_e('Logo', 'solutech') ?>"/>
                        <?php endif ?>
                    </a>
                    <?php echo wp_kses_post($pixtheme_logo_text); ?>
                </div>
            </div>

            <div class="col-md-4">
                <nav>
                    <?php if ( $pixtheme_header['header_socials'] ) : ?>
                    <ul class="social hidden-xs">
                        <?php if (pixtheme_get_option('social_facebook', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_facebook', '')); ?>"
                                                              target="_blank"><i class="fa fa-facebook"></i></a></li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_vk', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_vk', '')); ?>"
                                                              target="_blank"><i class="fa fa-vk"></i></a></li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_youtube', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_youtube', '')); ?>"
                                                              target="_blank"><i class="fa fa-youtube"></i></a></li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_vimeo', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_vimeo', '')); ?>"
                                                              target="_blank"><i class="fa fa-vimeo"></i></a></li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_twitter', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_twitter', '')); ?>"
                                                              target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_google', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_google', '')); ?>"
                                                              target="_blank"><i class="fa fa-google-plus"></i></a></li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_tumblr', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_tumblr', '')); ?>"
                                                              target="_blank"><i class="fa fa-tumblr"></i></a></li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_instagram', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_instagram', '')); ?>"
                                                              target="_blank"><i class="fa fa-instagram"></i></a></li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_pinterest', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_pinterest', '')); ?>"
                                                              target="_blank"><i class="fa fa-pinterest"></i></a></li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_linkedin', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_linkedin', '')); ?>"
                                                              target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_custom_url_1', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_custom_url_1', '')); ?>"
                                                              target="_blank"><i
                                            class="fa <?php echo esc_attr(pixtheme_get_option('social_custom_icon_1', '')); ?>"></i></a>
                            </li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_custom_url_2', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_custom_url_2', '')); ?>"
                                                              target="_blank"><i
                                            class="fa <?php echo esc_attr(pixtheme_get_option('social_custom_icon_2', '')); ?>"></i></a>
                            </li>
                        <?php } ?>
                        <?php if (pixtheme_get_option('social_custom_url_3', '')) { ?>
                            <li class="header-social-link"><a href="<?php echo esc_url(pixtheme_get_option('social_custom_url_3', '')); ?>"
                                                              target="_blank"><i
                                            class="fa <?php echo esc_attr(pixtheme_get_option('social_custom_icon_3', '')); ?>"></i></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php endif; ?>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="menu-left">
    <div class="menu-logo">
        <a class="navbar-brand scroll" href="<?php echo esc_url(home_url('/')) ?>" <?php echo wp_kses_post($pixtheme_logo_stl)?>>
            <?php if ($pixtheme_logo): ?>
                <img class="normal-logo"
                     src="<?php echo esc_url($pixtheme_logo) ?>"
                     alt="<?php esc_attr_e('Logo', 'solutech') ?>"/>
            <?php else: ?>
                <img class="normal-logo"
                     src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="<?php esc_attr_e('Logo', 'solutech') ?>"/>
            <?php endif ?>
        </a>
        <?php echo wp_kses_post($pixtheme_logo_text); ?>
    </div>
    <div class="menu-search">
        <?php if (class_exists('WooCommerce') && $pixtheme_header['header_minicart']) : ?>
            <div class="cart-container">
                <a href="<?php echo wc_get_cart_url(); ?>">
                    <div class="pix-cart-items">
                        <?php echo WC()->cart->cart_contents_count > 0 ? '<i class="icon-basket-loaded"></i>' : '<i class="icon-basket"></i>'; ?>
                        <span class="pix-cart-count"><?php echo WC()->cart->cart_contents_count; ?></span>
                    </div>
                </a>
            </div>
        <?php endif; ?>
        <?php if ( $pixtheme_header['header_search'] ) : ?>
        <div class="search-container">
            <i class="icon-magnifier js-search-toggle" aria-hidden="true"></i>
        </div>
        <?php endif; ?>
    </div>
    <nav>
        <?php
        if ( has_nav_menu( 'primary_nav' ) ) {
            wp_nav_menu(array(
                'theme_location'  => 'primary_nav',
                'container'       => false,
                'depth'           => 1
            ));
        }
        ?>
    </nav>
    <div class="menu-left__footer">
        <?php if ( $pixtheme_header['header_socials'] ) : ?>
        <div class="menu-left__footer-social">
            <?php if (pixtheme_get_option('social_facebook', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_facebook', '')); ?>"
                                                  target="_blank"><i class="fa fa-facebook"></i></a>
            <?php } ?>
            <?php if (pixtheme_get_option('social_vk', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_vk', '')); ?>"
                                                  target="_blank"><i class="fa fa-vk"></i></a>
            <?php } ?>
            <?php if (pixtheme_get_option('social_youtube', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_youtube', '')); ?>"
                                                  target="_blank"><i class="fa fa-youtube"></i></a>
            <?php } ?>
            <?php if (pixtheme_get_option('social_vimeo', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_vimeo', '')); ?>"
                                                  target="_blank"><i class="fa fa-vimeo"></i></a>
            <?php } ?>
            <?php if (pixtheme_get_option('social_twitter', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_twitter', '')); ?>"
                                                  target="_blank"><i class="fa fa-twitter"></i></a>
            <?php } ?>
            <?php if (pixtheme_get_option('social_google', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_google', '')); ?>"
                                                  target="_blank"><i class="fa fa-google-plus"></i></a>
            <?php } ?>
            <?php if (pixtheme_get_option('social_tumblr', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_tumblr', '')); ?>"
                                                  target="_blank"><i class="fa fa-tumblr"></i></a>
            <?php } ?>
            <?php if (pixtheme_get_option('social_instagram', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_instagram', '')); ?>"
                                                  target="_blank"><i class="fa fa-instagram"></i></a>
            <?php } ?>
            <?php if (pixtheme_get_option('social_pinterest', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_pinterest', '')); ?>"
                                                  target="_blank"><i class="fa fa-pinterest"></i></a>
            <?php } ?>
            <?php if (pixtheme_get_option('social_linkedin', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_linkedin', '')); ?>"
                                                  target="_blank"><i class="fa fa-linkedin"></i></a>
            <?php } ?>
            <?php if (pixtheme_get_option('social_custom_url_1', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_custom_url_1', '')); ?>"
                                                  target="_blank"><i
                                class="fa <?php echo esc_attr(pixtheme_get_option('social_custom_icon_1', '')); ?>"></i></a>
                
            <?php } ?>
            <?php if (pixtheme_get_option('social_custom_url_2', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_custom_url_2', '')); ?>"
                                                  target="_blank"><i
                                class="fa <?php echo esc_attr(pixtheme_get_option('social_custom_icon_2', '')); ?>"></i></a>
                
            <?php } ?>
            <?php if (pixtheme_get_option('social_custom_url_3', '')) { ?>
                <a href="<?php echo esc_url(pixtheme_get_option('social_custom_url_3', '')); ?>"
                                                  target="_blank"><i
                                class="fa <?php echo esc_attr(pixtheme_get_option('social_custom_icon_3', '')); ?>"></i></a>
                
            <?php } ?>
        </div>
        <?php endif; ?>
        <span><?php esc_html_e('&copy; 2013-2018 ', 'solutech')?><?php esc_html_e('All Rights Reserved', 'solutech')?></span>
    </div>
</div>