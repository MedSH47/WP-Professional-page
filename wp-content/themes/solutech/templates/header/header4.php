<?php /* Header Type 3 */
	$post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : get_the_ID();
	if( class_exists( 'WooCommerce' ) && pixtheme_is_woo_page() && pixtheme_get_option('woo_header_global','1') ){
		$post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
	} elseif (!is_page_template('page-home.php') && get_option('page_for_posts') && pixtheme_get_option('header_like_blog','0')){
		$post_ID = get_option('page_for_posts') ? get_option('page_for_posts') : 0;
	}

	$pixtheme_header = apply_filters('pixtheme_header_settings', $post_ID);
	$pixtheme_header['header_background'] = $pixtheme_header['header_background'] == '' ? 'white' : $pixtheme_header['header_background'];
	$pixtheme_header_transparent = $pixtheme_header['header_transparent'] < 100 ? 'transparent' : '';
    $pixtheme_header_menu_transparent = pixtheme_get_option('header_menu_transparent', '100') < 100 ? 'transparent' : '';
	$pixtheme_logo = isset($pixtheme_header['logo']) && $pixtheme_header['logo'] != '' ? $pixtheme_header['logo'] : get_template_directory_uri().'/images/logo.svg';
	$pixtheme_header['top_bar_background'] = $pixtheme_header['top_bar_background'] == '' ? 'black' : $pixtheme_header['top_bar_background'];
	$pixtheme_top_bar_transparent = $pixtheme_header['top_bar_transparent'] < 100 ? 'transparent' : '';

	$pixtheme_logo_stl = pixtheme_get_option('general_settings_logo_width', get_option('pixtheme_default_logo_width')) != '' ? 'width:'.esc_attr(pixtheme_get_option('general_settings_logo_width', get_option('pixtheme_default_logo_width'))).'px;' : '';
	$pixtheme_logo_stl = $pixtheme_logo_stl != '' ? 'style="'.($pixtheme_logo_stl).'"' : '';

	$pixtheme_logo_text = pixtheme_get_option('general_settings_logo_text') != '' ? '<div class="logo-text">'.wp_kses_post(pixtheme_get_option('general_settings_logo_text')).'</div>' : '';

?>

	<header class="pix-header pix-levels pix-header-info <?php echo esc_attr($pixtheme_header['header_background']) ?> <?php echo esc_attr( $pixtheme_header_transparent ) ?> <?php echo esc_attr($pixtheme_header['header_sticky']) ?> <?php if ($pixtheme_header['header_bar']) : ?>header-topbar-view<?php endif; ?>">
    
    <?php
    if ($pixtheme_header['header_bar']) {
        get_template_part('templates/header/header_top');
    }
    ?>
    
		<div class="<?php echo esc_attr($pixtheme_header['header_layout']) ?>">
		    <div class="row">
		        <div class="col-3">
                    <div class="menu-logo">
                        <a class="navbar-brand scroll" href="<?php echo esc_url(home_url('/')) ?>" <?php echo wp_kses_post($pixtheme_logo_stl)?>>
                            <img class="pix-header-logo" src="<?php echo esc_url($pixtheme_logo) ?>" alt="<?php esc_attr_e('Logo', 'solutech') ?>"/>
                        </a>
                        <?php echo wp_kses_post($pixtheme_logo_text); ?>
                    </div>
                </div>

                <div class="col-9">
                    <nav class="pix-text-right pix-info-container">
                        <ul>
                            <?php if ( pixtheme_get_option('header_info_1') || pixtheme_get_option('header_info_title_1') ) : ?>
                            <li>
                                <div class="pix-info">
                                    <i class="<?php echo esc_attr(pixtheme_get_option('header_info_icon_1')) ?>"></i>
                                    <span><?php echo pixtheme_get_option('header_info_title_1') ?></span>
                                    <h6><?php echo pixtheme_get_option('header_info_1') ?></h6>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( pixtheme_get_option('header_info_2') || pixtheme_get_option('header_info_title_2') ) : ?>
                            <li>
                                <div class="pix-info">
                                    <i class="<?php echo esc_attr(pixtheme_get_option('header_info_icon_2')) ?>"></i>
                                    <span><?php echo pixtheme_get_option('header_info_title_2') ?></span>
                                    <h6><?php echo pixtheme_get_option('header_info_2') ?></h6>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( pixtheme_get_option('header_info_3') || pixtheme_get_option('header_info_title_3') ) : ?>
                            <li>
                                <div class="pix-info">
                                    <i class="<?php echo esc_attr(pixtheme_get_option('header_info_icon_3')) ?>"></i>
                                    <span><?php echo pixtheme_get_option('header_info_title_3') ?></span>
                                    <h6><?php echo pixtheme_get_option('header_info_3') ?></h6>
                                </div>
                            </li>
                            <?php endif; ?>
                            <?php if ( isset($pixtheme_header['header_button']) && $pixtheme_header['header_button'] ) : ?>
                            <li class="pix-li-button">
                                <a class="pix-button pix-h-s pix-v-xs" href="<?php echo esc_url(pixtheme_get_option('header_button_link')) ?>"><?php echo wp_kses_post(pixtheme_get_option('header_button_text', esc_html__('Booking', 'solutech'))) ?></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="pix-header-menu <?php echo esc_attr(pixtheme_get_option('header_menu_background', get_option('pixtheme_default_header_menu_background')))?> <?php echo esc_attr( $pixtheme_header_menu_transparent ) ?>">
            <div class="container">
            <div class="row">
		        <div class="col">
                    <nav class="<?php echo esc_attr($pixtheme_header['header_menu_pos']) ?>">
                    <?php echo pixtheme_site_menu('main-menu nav navbar-nav'); ?>
                    </nav>
                    <nav class="pix-header-abs-content pix-text-right">
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

                            <?php if ( isset($pixtheme_header['header_button']) && $pixtheme_header['header_button'] ) : ?>
                            <li class="pix-fixed-content">
                                <a class="pix-button pix-h-s pix-v-xs" href="<?php echo esc_url(pixtheme_get_option('header_button_link')) ?>"><?php echo wp_kses_post(pixtheme_get_option('header_button_text', esc_html__('Booking', 'solutech'))) ?></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    <?php if ( $pixtheme_header['header_search'] ) : ?>
                    <div class="search-container">
                        <div class="input-container">
                            <form method="get" id="searchform" class="searchform" action="<?php echo esc_url(site_url()) ?>">
                                <div>
                                    <input type="text" placeholder="<?php esc_attr_e('Search', 'solutech');?>" value="<?php esc_attr(the_search_query()); ?>" name="s" id="search">
                                    <input type="submit" id="searchsubmit" value="">
                                </div>
                            </form>
                        </div>
                        <a class="pix-search-close"><i class="far fa-times-circle"></i></a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            </div>
		</div>
	</header>
