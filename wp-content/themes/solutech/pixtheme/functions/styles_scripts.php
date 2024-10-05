<?php
function pixtheme_fonts_url($post_id) {
	$fonts_url = '';

	$font_families = array();
	$custom_fonts_arr = array('Jost', 'Helvetica', 'Arial');

	$font_families[] = pixtheme_get_option('fonts_embed', get_option('pixtheme_default_fonts_embed'));
	
    if(!empty($font_families)) {
        
        foreach($font_families as $key => $font){
            $font_arr = explode(':', $font);
            if( in_array($font_arr[0], $custom_fonts_arr) ){
                unset($font_families[$key]);
            }
        }
        
        $fonts_url = '';
        if(!empty($font_families)) {
            $query_args = array(
                'family' => str_replace('%2B', '+', urlencode(implode('|', $font_families))),
                'subset' => urlencode('latin,latin-ext'),
            );
            $fonts_url = add_query_arg($query_args, '//fonts.googleapis.com/css');
        }
    }

	return esc_url_raw( $fonts_url );
}

add_filter('woocommerce_enqueue_styles', 'pixtheme_load_woo_styles');
function pixtheme_load_woo_styles($styles){
	if (isset($styles['woocommerce-general']) && isset($styles['woocommerce-general']['src'])){
		$styles['woocommerce-general']['src'] = get_template_directory_uri() . '/assets/woocommerce/css/woocommerce.css';
	}
	return $styles;
}

add_action( 'wp_enqueue_scripts', 'pixtheme_register_swiper', 4 );
function pixtheme_register_swiper() {
    $theme_version = wp_get_theme()->get( 'Version' );

    wp_register_script( 'swiper', get_template_directory_uri() . '/assets/elementor/js/swiper.min.js', array( 'jquery', 'imagesloaded' ) , NULL, true );
    wp_register_script( 'pixtheme-swiper-options', get_template_directory_uri() . '/assets/elementor/js/swiper-options.js', array( 'jquery', 'swiper' ), $theme_version, true );
}


function pixtheme_load_styles_scripts(){

    wp_enqueue_style('style', get_stylesheet_uri());
    

    /* PRIMARY CSS */
    wp_enqueue_style('pixtheme-fonts', pixtheme_fonts_url(get_the_ID()), array(), null );

	wp_enqueue_script('jquery-ui-slider');
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/bootstrap/bootstrap.min.css');
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/bootstrap/bootstrap.min.js', array('jquery') , null, true);

    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/fonts/fontawesome/css/fontawesome.min.css');
    wp_enqueue_style('simple-line-icons', get_template_directory_uri() . '/fonts/simple/simple-line-icons.css');
    
    if ( did_action( 'elementor/loaded' ) ) {
        
        $theme_version = wp_get_theme()->get( 'Version' );
        
        wp_enqueue_script( 'imagesloaded' );
        wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/elementor/js/bootstrap.min.js', array( 'jquery' ) , NULL, true );
        wp_enqueue_script( 'swiper' );
        wp_enqueue_script( 'pixtheme-swiper-options' );
        wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/elementor/js/fancybox.min.js', array( 'jquery' ) , NULL, true );
        wp_enqueue_script( 'pixtheme-el-custom', get_template_directory_uri() . '/assets/elementor/js/custom.js', array( 'jquery' ) , $theme_version, true );
        
        wp_enqueue_script('pixtheme-main-el', get_template_directory_uri() . '/js/main-el.js', array() , null, true);
        
        wp_enqueue_style('pixtheme-main-el', get_template_directory_uri() . '/assets/elementor/css/main-el.css');
        
    } else {
    	
    	// Owl-Carousel
	    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.min.css');
		wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/owl-carousel/owl.carousel.min.js', array() , null, true);
		wp_enqueue_script('owl-carousel-filter', get_template_directory_uri() . '/assets/owl-carousel/owlcarousel2-filter.min.js', array() , null, true);
    }

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    // Placeholder
    wp_enqueue_script('placeholder', get_template_directory_uri() . '/js/jquery.placeholder.min.js', array('jquery') , null, true);
	
	// SmoothScroll
    wp_enqueue_script('smoothscroll', get_template_directory_uri() . '/assets/smoothscroll/SmoothScroll.js', array('jquery') , null, true);

	// Isotope
	wp_enqueue_script('isotope', get_template_directory_uri() . '/assets/isotope/isotope.pkgd.min.js', array() , null, true);
    wp_enqueue_script('imagesloaded', get_template_directory_uri() . '/assets/isotope/imagesloaded.pkgd.min.js', array() , null, true);
    
    // Animate
    wp_enqueue_style('animate', get_template_directory_uri() . '/assets/animate/animate.css');
    
    // WOW
    wp_enqueue_script('wow', get_template_directory_uri() . '/assets/wow/wow.min.js', array('jquery') , null, true);

    // EasyPieChart
    wp_enqueue_script('easypiechart', get_template_directory_uri() . '/assets/easypiechart/jquery.easypiechart.min.js', array('jquery') , null, true);

    // Magnific-Popup
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/magnific-popup/magnific-popup.css');
    wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/magnific-popup/jquery.magnific-popup.min.js', array('jquery') , null, true);

    // Main CSS
    wp_enqueue_style('pixtheme-main', get_template_directory_uri() . '/css/main.css');
	wp_enqueue_style('pixtheme-responsive', get_template_directory_uri() . '/css/responsive.css');


    $api_key = pixtheme_get_setting('pix-google-api');
    if($api_key != '') {
        wp_enqueue_script('pixtheme-google-maps-api', "//maps.googleapis.com/maps/api/js?key=$api_key");
    }
    
    // CUSTOM SCRIPT
    $post_ID = isset ($wp_query) ? $wp_query->get_queried_object_id() : get_the_ID();
	if( class_exists( 'WooCommerce' ) && pixtheme_is_woo_page() && pixtheme_get_option('woo_header_global','1') ){
		$post_ID = get_option( 'woocommerce_shop_page_id' ) ? get_option( 'woocommerce_shop_page_id' ) : $post_ID;
	} elseif ( get_option('page_for_posts') != '' && (get_post_type($post_ID) == 'post' || get_option('page_for_posts') == $post_ID) ){
		$post_ID = get_option('page_for_posts');
	}
    wp_enqueue_style('pixtheme-dynamic-styles', admin_url('admin-ajax.php').'?action=dynamic_styles&pageID='.$post_ID);
    wp_enqueue_script('pixtheme-common', get_template_directory_uri() . '/js/theme.js', array() , null, true);
    

    ob_start();
    get_template_part('searchform');
    $search_form = ob_get_contents();
    ob_end_clean();

    wp_localize_script( 'pixtheme-common', 'pix_js_vars',
        array(
            'search_form' => $search_form,
        )
    );

}
add_action('wp_enqueue_scripts', 'pixtheme_load_styles_scripts');


function pixtheme_dynamic_styles() {
	include( get_template_directory().'/pixtheme/functions/dynamic-styles.php' );
	exit;
}
add_action('wp_ajax_dynamic_styles', 'pixtheme_dynamic_styles');
add_action('wp_ajax_nopriv_dynamic_styles', 'pixtheme_dynamic_styles');



add_filter('body_class','pixtheme_browser_body_class');
function pixtheme_browser_body_class($classes = '') {

    $classes[] = pixtheme_get_option('theme_boxes_shape', 'pix-rounded');
    $classes[] = pixtheme_get_option('buttons_shape', get_option('pixtheme_default_button_shape')).'-buttons';
    $classes[] = pixtheme_get_option('style_theme_tone', '');
    //$classes[] = 'pix-width-'.pixtheme_get_setting('pix-width-page', '1300');

    return $classes;
}



?>