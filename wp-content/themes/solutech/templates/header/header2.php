<?php /* Header Type 2 */
	$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : get_the_ID();
	if( class_exists( 'WooCommerce' ) && pixtheme_is_woo_page() && pixtheme_get_option('woo_header_global','1') ){
		$post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
	} elseif (!is_page_template('page-home.php') && get_option('page_for_posts') && pixtheme_get_option('header_like_blog','0')){
		$post_ID = get_option('page_for_posts') ? get_option('page_for_posts') : 0;
	}

	$pixtheme_header = apply_filters('pixtheme_header_settings', $post_ID);
	$pixtheme_header['header_background'] = $pixtheme_header['header_background'] == '' ? 'white' : $pixtheme_header['header_background'];
	$pixtheme_header_transparent = $pixtheme_header['header_transparent'] < 100 ? 'transparent' : '';
	$pixtheme_logo = isset($pixtheme_header['logo']) && $pixtheme_header['logo'] != '' ? $pixtheme_header['logo'] : get_template_directory_uri().'/images/logo.svg';
	$pixtheme_header['top_bar_background'] = $pixtheme_header['top_bar_background'] == '' ? 'black' : $pixtheme_header['top_bar_background'];
	$pixtheme_top_bar_transparent = $pixtheme_header['top_bar_transparent'] < 100 ? 'transparent' : '';

	$pixtheme_logo_stl = pixtheme_get_option('general_settings_logo_width', get_option('pixtheme_default_logo_width')) != '' ? 'width:'.esc_attr(pixtheme_get_option('general_settings_logo_width', get_option('pixtheme_default_logo_width'))).'px;' : '';
	$pixtheme_logo_stl = $pixtheme_logo_stl != '' ? 'style="'.($pixtheme_logo_stl).'"' : '';

	$pixtheme_logo_text = pixtheme_get_option('general_settings_logo_text') != '' ? '<div class="logo-text">'.wp_kses_post(pixtheme_get_option('general_settings_logo_text')).'</div>' : '';

?>

	<header class="pix-header menu-aroundblock <?php echo esc_attr($pixtheme_header['header_background']) ?> <?php echo esc_attr( $pixtheme_header_transparent ) ?> <?php echo esc_attr($pixtheme_header['header_sticky']) ?>
    <?php if ($pixtheme_header['header_bar']) : ?>header-topbar-view<?php endif; ?> ">
    
    <?php
    if ($pixtheme_header['header_bar']) {
        get_template_part('templates/header/header_top');
    }
    ?>
    
		<div class="<?php echo esc_attr($pixtheme_header['header_layout']) ?>">
		    <div class="row">
		        <div class="col">
                    <nav class="pix-menu-center-logo-left">
                        <ul class="main-menu-elements">
                            <?php if ( $pixtheme_header['header_socials'] && !$pixtheme_header['header_bar'] ) : ?>
                                <?php if (pixtheme_get_option('social_facebook', '')) { ?>
                                    <li class="header-social-link">
                                        <a href="<?php echo esc_url(pixtheme_get_option('social_facebook', '')); ?>" target="_blank"><i class="fab fa-facebook-square"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if (pixtheme_get_option('social_twitter', '')) { ?>
                                    <li class="header-social-link">
                                        <a href="<?php echo esc_url(pixtheme_get_option('social_twitter', '')); ?>" target="_blank"><i class="fab fa-twitter-square"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if (pixtheme_get_option('social_instagram', '')) { ?>
                                    <li class="header-social-link">
                                        <a href="<?php echo esc_url(pixtheme_get_option('social_instagram', '')); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if (pixtheme_get_option('social_youtube', '')) { ?>
                                    <li class="header-social-link">
                                        <a href="<?php echo esc_url(pixtheme_get_option('social_youtube', '')); ?>" target="_blank"><i class="fab fa-youtube-square"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if (pixtheme_get_option('social_pinterest', '')) { ?>
                                    <li class="header-social-link">
                                        <a href="<?php echo esc_url(pixtheme_get_option('social_pinterest', '')); ?>" target="_blank"><i class="fab fa-pinterest-square"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if (pixtheme_get_option('social_custom_url_1', '')) { ?>
                                    <li class="header-social-link">
                                        <a href="<?php echo esc_url(pixtheme_get_option('social_custom_url_1', '')); ?>" target="_blank"><i class="fa <?php echo esc_attr(pixtheme_get_option('social_custom_icon_1', '')); ?>"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if (pixtheme_get_option('social_custom_url_2', '')) { ?>
                                    <li class="header-social-link">
                                        <a href="<?php echo esc_url(pixtheme_get_option('social_custom_url_2', '')); ?>" target="_blank"><i class="fa <?php echo esc_attr(pixtheme_get_option('social_custom_icon_2', '')); ?>"></i></a>
                                    </li>
                                <?php } ?>
                                <?php if (pixtheme_get_option('social_custom_url_3', '')) { ?>
                                    <li class="header-social-link">
                                        <a href="<?php echo esc_url(pixtheme_get_option('social_custom_url_3', '')); ?>" target="_blank"><i class="fa <?php echo esc_attr(pixtheme_get_option('social_custom_icon_3', '')); ?>"></i></a>
                                    </li>
                                <?php } ?>
                            <?php endif; ?>
                        </ul>
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary_left_nav',
                            'container' => false,
                            'menu_class' => 'main-menu nav navbar-nav',
                            'walker' => new PixTheme_Walker_Menu(),
                        ));
                        ?>
                    </nav>
                </div>

                <div class="col-3">
                    <div class="menu-logo">
                        <a class="navbar-brand scroll" href="<?php echo esc_url(home_url('/')) ?>" <?php echo wp_kses_post($pixtheme_logo_stl)?>>
                            <img class="pix-header-logo" src="<?php echo esc_url($pixtheme_logo) ?>" alt="<?php esc_attr_e('Logo', 'solutech') ?>"/>
                        </a>
                        <?php echo wp_kses_post($pixtheme_logo_text); ?>
                    </div>
                </div>

                <div class="col">
                    <nav class="pix-menu-center-logo-right">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary_right_nav',
                            'container' => false,
                            'menu_class' => 'main-menu nav navbar-nav',
                            'walker' => new PixTheme_Walker_Menu(),
                        ));
                        ?>
                        <ul class="main-menu-elements">
                            
                            <li id="js-search-container" class="search">
                                <?php if ( $pixtheme_header['header_search'] ) : ?>
                                <a><i class="fas fa-search"></i></a>
                                <?php endif; ?>
                            </li>
                            
                            <li class="cart">
                                <?php if (class_exists('WooCommerce') && $pixtheme_header['header_minicart']) : ?>
                                <a href="<?php echo wc_get_cart_url(); ?>">
                                    <div class="pix-cart-items">
                                        <?php echo WC()->cart->cart_contents_count > 0 ? '<i class="icon-basket-loaded"></i>' : '<i class="icon-basket"></i>'; ?>
                                        <span class="pix-cart-count"><?php echo WC()->cart->cart_contents_count; ?></span>
                                    </div>
                                </a>
                                <?php endif; ?>
                            </li>
                            
                        </ul>
                    </nav>
                    <?php if ( $pixtheme_header['header_search'] ) : ?>
                    <div class="search-container">
                        <div class="input-container"></div>
                        <a class="pix-search-close"><i class="far fa-times-circle"></i></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
		</div>
	</header>
