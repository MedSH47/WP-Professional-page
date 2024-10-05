<?php
	
	/*  Redirect To Theme Options Page on Activation  */
	if (is_admin() && isset($_GET['activated'])) {
	    wp_redirect(admin_url('themes.php'));
	}
	
	/*  Load custom admin scripts & styles  */
	function pixtheme_load_custom_wp_admin_style() {

		wp_enqueue_media();

		// ion.rangeSlider
        wp_enqueue_style('ion-rangeSlider', get_template_directory_uri() . '/pixtheme/admin/js/ion-rangeSlider/css/ion.rangeSlider.css');
        wp_enqueue_style('ion-rangeSlider-skinModern', get_template_directory_uri() . '/pixtheme/admin/js/ion-rangeSlider/css/ion.rangeSlider.skinNice.css');
        wp_enqueue_script('ion-rangeSlider', get_template_directory_uri() . '/pixtheme/admin/js/ion-rangeSlider/js/ion.rangeSlider.min.js', array('jquery') , false, true);
        wp_enqueue_script('wNumb', get_template_directory_uri() . '/pixtheme/admin/js/ion-rangeSlider/js/wNumb.js', array('jquery'), false, true);

        // Add the color picker css file
	    wp_enqueue_style( 'wp-color-picker' );

	    wp_enqueue_script('pixtheme-custom-slider', get_template_directory_uri() . '/pixtheme/admin/js/custom-slider.js', array('jquery'), false, true);

		wp_register_script( 'pixtheme-custom-admin', get_template_directory_uri() . '/pixtheme/admin/js/custom-admin.js', array( 'jquery', 'wp-color-picker' ) );
	    wp_localize_script( 'pixtheme-custom-admin', 'meta_image',
	        array(
	            'title' => esc_html__( 'Choose or Upload an Image', 'solutech' ),
	            'button' => esc_html__( 'Use this image', 'solutech' ),
                'font_api' => pixtheme_get_option('font_api', 'AIzaSyAAChcJ6xYHmHRRTRMvt9GLCXeQG1qasV4'),
	        )
	    );
	    wp_localize_script( 'pixtheme-custom-admin', 'pix_post_ajax',
	        array(
	            'url'   => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'pix_post_ajax_nonce' ),
	        )
	    );
	    wp_enqueue_script( 'pixtheme-custom-admin' );

	    wp_enqueue_style('pixtheme-custom-admin', get_template_directory_uri() . '/pixtheme/admin/css/custom-admin.css');
	    wp_enqueue_style('pixtheme-admin-font', get_template_directory_uri() . '/fonts/fontawesome/css/fontawesome.min.css');

	}
	
	function pixtheme_add_editor_styles() {
		add_editor_style( 'pixtheme-editor-style.css' );
	}

	function pixtheme_customizer_preview() {
		wp_enqueue_script( 'pixtheme-customizer-preview', get_template_directory_uri() . '/pixtheme/admin/js/customizer-preview.js', array( 'customize-preview' ), null, true );
        wp_localize_script( 'pixtheme-customizer-preview', 'pix_customizer_ajax',
            array(
                'url'   => admin_url( 'admin-ajax.php' ),
                'nonce' => wp_create_nonce( 'pix_customizer_ajax_nonce' ),
                'template' => get_template_directory_uri(),
                'main_color' => get_option('pixtheme_default_main_color'),
                'add_color' => get_option('pixtheme_default_additional_color'),
                'gradient_color' => get_option('pixtheme_default_gradient_color'),
                'black_color' => get_option('pixtheme_default_black_color'),
            )
        );
	}
	function pixtheme_customizer_control() {
		wp_enqueue_script( 'pixtheme-customizer-control', get_template_directory_uri() . '/pixtheme/admin/js/customizer-control.js', array( 'jquery', 'customize-controls' ), null, true );
	}

	add_filter('login_headerurl', function(){return get_home_url("/");});
	add_filter('login_headertext', function(){return false;});
	add_action('admin_enqueue_scripts', 'pixtheme_load_custom_wp_admin_style');
	add_action('admin_init', 'pixtheme_add_editor_styles' );
	add_action('customize_preview_init', 'pixtheme_customizer_preview');
	add_action('customize_controls_enqueue_scripts', 'pixtheme_customizer_control');


	
	/* Admin Panel */
	require_once(get_template_directory() . '/pixtheme/admin/customizer/index.php');

	require_once(get_template_directory() . '/pixtheme/admin/class-tgm-plugin-activation.php');
	
	require_once(get_template_directory() . '/pixtheme/admin/post-fields.php');

	require_once(get_template_directory() . '/pixtheme/admin/functions.php');
	

?>