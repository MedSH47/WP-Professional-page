<?php /* Header Mobile */
    $post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : get_the_ID();

    $pixtheme_header = apply_filters('pixtheme_header_settings', $post_ID);
    $pixtheme_logo_m = $pixtheme_header['logo_mobile'] == '' ? $pixtheme_header['logo'] : $pixtheme_header['logo_mobile'];
    $logo_src = $pixtheme_logo_m != '' ? $pixtheme_logo_m : get_template_directory_uri().'/images/logo-w.svg';
    
?>

		<header class="menu-mobile <?php echo esc_attr($pixtheme_header['header_sticky_mobile']) ?>">
			<div class="row">
				<div class="col-12">
					<div class="menu-mobile__header <?php echo esc_attr($pixtheme_header['header_background']) ?>">

                        <a class="navbar-brand scroll" href="<?php echo esc_url(home_url('/')) ?>">
                            <img class="normal-logo" src="<?php echo esc_url($logo_src) ?>" alt="<?php esc_attr_e('Logo', 'solutech') ?>"/>
                        </a>

                        <button class="hamburger hamburger--spring js-mobile-toggle" type="button" onclick="this.classList.toggle('is-active');">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>

                        <?php if (class_exists('WooCommerce') && $pixtheme_header['header_minicart']) : ?>
                        <div class="cart-container">
                            <a href="<?php echo wc_get_cart_url(); ?>">
                                <div class="pix-cart-items">
                                    <i class="fas fa-shopping-basket"></i>
                                    <span class="pix-cart-count"><?php echo WC()->cart->cart_contents_count; ?></span>
                                </div>
                            </a>
                        </div>
                        <?php endif; ?>

                        <?php if ( $pixtheme_header['header_search'] ) : ?>
                        <i class="fas fa-search js-search-toggle"></i>
                        <div class="search-container">
                            <div class="input-container"></div>
                        </div>
                        <?php endif; ?>

					</div>
					<div class="menu-mobile__list">
                        <div class="pix-mobile-menu-container">
                        <?php
                        if ( has_nav_menu( 'mobile_nav' ) ) {
                            wp_nav_menu(array(
                                'theme_location'  => 'mobile_nav',
                                'container'       => false,
                                'menu_id'		  => 'mobile-menu',
                                'menu_class'      => '',
                                'depth'           => 3,
                                'walker'          => new PixTheme_Walker_Mobile_Menu(),
                            ));
                        } elseif( has_nav_menu( 'primary_nav' ) ) {
                            wp_nav_menu(array(
                                'theme_location'  => 'primary_nav',
                                'container'       => false,
                                'menu_id'	      => 'mobile-menu',
                                'depth'           => 3,
                                'walker'          => new PixTheme_Walker_Mobile_Menu(),
                            ));
                        }
                        ?>
                        </div>
						<div class="overlay"></div>
					</div>
				</div>
			</div>	
		</header>