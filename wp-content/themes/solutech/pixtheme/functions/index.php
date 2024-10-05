<?php 
	/**  Theme_index  **/

    include_once( get_template_directory() . '/pixtheme/functions/styles_scripts.php' );
    include_once( get_template_directory() . '/pixtheme/functions/functions.php' );
    include_once( get_template_directory() . '/pixtheme/functions/use.php' );
    include_once( get_template_directory() . '/pixtheme/functions/comment_walker.php' );
    include_once( get_template_directory() . '/pixtheme/functions/menu_walker.php' );
    include_once( get_template_directory() . '/pixtheme/functions/portfolio_walker.php' );
	include_once( get_template_directory() . '/pixtheme/functions/sidebars.php');
    include_once( get_template_directory() . '/pixtheme/functions/woo.php' );
    include_once( get_template_directory() . '/pixtheme/functions/defaults.php' );


	function pixtheme_setup() {

	    // Language support
	    load_theme_textdomain('solutech', get_template_directory() . '/languages');
	    $locale      = get_locale();
	    $locale_file = get_template_directory() . "/languages/$locale.php";
	    if (is_readable($locale_file)) {
	        require_once(get_template_directory() . "/languages/$locale.php");
	    }

	    // ADD SUPPORT FOR POST THUMBS
	    add_theme_support('post-thumbnails');
	    // Define various thumbnail sizes
		$img_size = ( ( pixtheme_get_setting('pix-img-base-size', '650') ) &&
					 is_numeric( pixtheme_get_setting('pix-img-base-size', '650') ) &&
					 pixtheme_get_setting('pix-img-base-size', '650') > 0
				 ) ? pixtheme_get_setting('pix-img-base-size', '650') : 650;
		$img_landscape_ratio = ( ( pixtheme_get_setting('pix-img-landscape-ratio', '1.618') ) &&
					 is_numeric( pixtheme_get_setting('pix-img-landscape-ratio', '1.618') ) &&
					 pixtheme_get_setting('pix-img-landscape-ratio', '1.618') > 0
				 ) ? pixtheme_get_setting('pix-img-landscape-ratio', '1.618') : 1.618;
		$img_portrait_ratio = ( ( pixtheme_get_setting('pix-img-portrait-ratio', '1.333') ) &&
					 is_numeric( pixtheme_get_setting('pix-img-portrait-ratio', '1.333') ) &&
					 pixtheme_get_setting('pix-img-portrait-ratio', '1.333') > 0
				 ) ? pixtheme_get_setting('pix-img-portrait-ratio', '1.333') : 1.333;
		$img_size_col_3 = $img_size;
        $img_size_col_4 = round($img_size/1.5 );
		add_image_size('pixtheme-square', $img_size, $img_size, true );
		add_image_size('pixtheme-square-retina', ($img_size*2), ($img_size*2), true);
		add_image_size('pixtheme-landscape', ($img_size*$img_landscape_ratio), $img_size, true );
		add_image_size('pixtheme-portrait', $img_size, ($img_size*$img_portrait_ratio), true );
		add_image_size('pixtheme-original', $img_size, $img_size, false );
		add_image_size('pixtheme-original-retina', ($img_size*2), ($img_size*2), false );
		
		add_image_size('pixtheme-square-col-3', $img_size_col_3, $img_size_col_3, true );
		add_image_size('pixtheme-landscape-col-3', ($img_size_col_3*$img_landscape_ratio), $img_size_col_3, true );
		add_image_size('pixtheme-portrait-col-3', $img_size_col_3, ($img_size_col_3*$img_portrait_ratio), true );
		add_image_size('pixtheme-original-col-3', $img_size_col_3, $img_size_col_3, false );
		add_image_size('pixtheme-square-col-3-retina', ($img_size_col_3*2), ($img_size_col_3*2), true );
		add_image_size('pixtheme-landscape-col-3-retina', ($img_size_col_3*$img_landscape_ratio*2), ($img_size_col_3*2), true );
		add_image_size('pixtheme-portrait-col-3-retina', ($img_size_col_3*2), ($img_size_col_3*$img_portrait_ratio*2), true );
		add_image_size('pixtheme-original-col-3-retina', ($img_size_col_3*2), ($img_size_col_3*2), false );
		
		add_image_size('pixtheme-square-col-4', $img_size_col_4, $img_size_col_4, true );
		add_image_size('pixtheme-landscape-col-4', ($img_size_col_4*$img_landscape_ratio), $img_size_col_4, true );
		add_image_size('pixtheme-portrait-col-4', $img_size_col_4, ($img_size_col_4*$img_portrait_ratio), true );
		add_image_size('pixtheme-original-col-4', $img_size_col_4, $img_size_col_4, false );
		add_image_size('pixtheme-square-col-4-retina', $img_size, $img_size, true );
		add_image_size('pixtheme-landscape-col-4-retina', ($img_size_col_4*$img_landscape_ratio*2), $img_size, true );
		add_image_size('pixtheme-portrait-col-4-retina', $img_size, ($img_size_col_4*$img_portrait_ratio*2), true );
		add_image_size('pixtheme-original-col-4-retina', $img_size, $img_size, false );
		
		add_image_size('pixtheme-thumb', 200, 110, true);
		add_image_size('pixtheme-blog', 950, 460, true);

	    add_theme_support('widgets');
	    add_theme_support('title-tag');
	    add_theme_support('automatic-feed-links');
	    add_theme_support('post-formats', array(
	        'gallery',
	        'video',
	        'quote',
	    ));
	    $args = array(
	        'flex-width' => true,
	        'width' => 350,
	        'flex-height' => true,
	        'height' => 'auto',
	        'default-image' => get_template_directory_uri() . '/images/logo.svg'
	    );
	    add_theme_support('custom-header', $args);
	    $args = array(
	        'default-color' => 'FFFFFF'
	    );
	    add_theme_support('custom-background', $args);

	    add_theme_support( 'woocommerce', array(
	        'single_image_width'            => 600,
            'thumbnail_image_width'         => 400,
            'gallery_thumbnail_image_width' => 300,
        ) );
		//add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

	}

	/* Register 5 navi types */
	function pixtheme_custom_menus() {

	    /* Register Navigations */
        register_nav_menus(array(
            'primary_nav' => esc_html__('Primary Navigation', 'solutech'),
            'primary_left_nav' => esc_html__('Primary Left Navigation', 'solutech'),
            'primary_right_nav' => esc_html__('Primary Right Navigation', 'solutech'),
            'top_nav' => esc_html__('Top Navigation', 'solutech'),
            'footer_nav' => esc_html__('Footer Navigation', 'solutech'),
		    'mobile_nav' => esc_html__('Mobile Navigation', 'solutech'),
        ));
    }


	add_action('after_setup_theme', 'pixtheme_setup');
	add_action('init', 'pixtheme_custom_menus');
	add_filter('wpcf7_autop_or_not', '__return_false');

	if ( ! isset( $content_width ) ) {
		$content_width = 1330;
	}

?>