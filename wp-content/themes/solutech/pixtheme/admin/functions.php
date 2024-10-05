<?php

    function pixtheme_get_option($slug, $_default = false){

	    $slug = 'pixtheme_' . $slug;

        $pix_options = get_theme_mods();

		if (isset($pix_options[$slug])){
			return wp_kses_post($pix_options[$slug]);
		}else{
			if (isset($_default))
				return wp_kses_post($_default);
			else
				return false;
		}

	}

	function pixtheme_get_setting($field, $default = ''){

        if( class_exists( 'PixThemeSettings' ) ) {
            global $pix_settings;
            return $pix_settings->settings->get_setting($field);
        } else {
            return $default;
        }

	}
	
	function pixtheme_get_post_meta( $slug, $default = false ) {

        if ( is_home() && 'page' === get_option( 'show_on_front' ) ) {
            $post_id = get_option( 'page_for_posts' );
        } elseif ( function_exists( 'is_shop' ) && is_shop() ) {
            $post_id = wc_get_page_id( 'shop' );
        } else {
            $post_id = get_the_ID();
        }
    
        $post_metas = get_post_meta( $post_id );
    
        $slug = 'solutech_' . $slug;
    
        if ( $post_metas != false && isset( $post_metas[ $slug ] ) ) {
            return $post_metas[ $slug ][0];
        }
    
        return $default;
    
    }

	function pixtheme_retina(){
        $is_retina = false;

        if( class_exists( 'PixThemeSettings' ) ) {
            global $pix_settings;
            $is_retina = $pix_settings->settings->get_setting('pix-retina-img') != 'off' && $pix_settings->is_retina;
        }

        return $is_retina;

	}
    
    function pixtheme_get_layout( $post_type = 'blog', $post_id = 0 ){
        
        $post_type = str_replace('pix-', '', $post_type);
        $class = array('', 'pix-no-sidebar', 'pix-right-sidebar', 'pix-left-sidebar');
    
        $layout_number = array(
            'full-width'    => '1',
            'right'         => '2',
            'left'          => '3'
        );
        
        if(is_single() && $post_id > 0) {
            $layout = get_post_meta($post_id, 'pix_page_layout', true) != '' ? get_post_meta($post_id, 'pix_page_layout', true) : $layout_number[pixtheme_get_setting('pix-layout-'.$post_type, 'right')];
            $sidebar = get_post_meta($post_id, 'pix_selected_sidebar', true) != '' ? get_post_meta($post_id, 'pix_selected_sidebar', true) : pixtheme_get_setting('pix-sidebar-'.$post_type, 'sidebar');
        } else {
            $layout = $layout_number[pixtheme_get_setting('pix-layout-'.$post_type, 'right')];
            $sidebar = pixtheme_get_setting('pix-sidebar-'.$post_type, 'sidebar');
        }
    
        if ( ! is_active_sidebar($sidebar) ){
            $layout = '1';
        }
    
        $pix_layout = array(
            'layout' => $layout,
            'sidebar' => $sidebar,
            'class' => $class[$layout]
        );
        
        return $pix_layout;
        
    }
    
    function pixtheme_get_layout_width( $post_type = 'blog' ){
        
        $post_type = str_replace('pix-', '', $post_type);
        
        if( pixtheme_get_setting('pix-width-'.$post_type, '') == '' ){
            $pix_width = 'pix-width-'.pixtheme_get_setting('pix-width-global', get_option('pixtheme_default_content_width'));
        } else {
            $pix_width = 'pix-width-'.pixtheme_get_setting('pix-width-'.$post_type, get_option('pixtheme_default_content_width'));
        }
        
        if( pixtheme_get_setting('pix-boxed-global', 'on') == 'on' ){
            $pix_width .= ' pix-container-boxed';
        }
        
        return $pix_width;
        
    }

	function pixtheme_vc_get_params_array($arr, $key){
	    $keys_arr = array();
	    if( !empty($key) ){
            foreach($arr as $k => $v){
                if(substr_count($k, $key) > 0){
                    $keys_arr[$k] = $v;
                }
            }
        }
	    return $keys_arr;
    }

	function pixtheme_get_section_content($section_id){

        if ($section_id == 'global'){
            return '';
        }
    
        $section = get_post($section_id);
        
        if (!isset($section->post_content)){
            return '';
        }
        
        $shortcodes_custom_css = get_post_meta( $section_id, '_wpb_shortcodes_custom_css', true );
        if ( ! empty( $shortcodes_custom_css ) ) {
            echo '
                <script>
                    jQuery(function($){
                        $("head").append("<style>'.esc_html($shortcodes_custom_css).'</style>");
                    });
                </script>';
        }
        echo apply_filters('the_content', $section->post_content);

	}
	
	function pixtheme_get_el_section_content( $section_id ) {
    	
    	if ($section_id == 'global'){
            return '';
        }
        if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {
        	echo Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $section_id );
        }
    }

	function pixtheme_get_sections_array($is_footer = false){
		$args = array(
			'post_type'        => 'pix-section',
			'post_status'      => 'publish',
		);
		$pix_sections = array();
		$pix_sections[] = 'Select Section';
		$pix_sections_data = get_posts( $args );
		foreach($pix_sections_data as $pix_section){
			$pix_sections[$pix_section->ID] = $pix_section->post_title;
		}
		if($is_footer){
		    $pix_sections['no-footer'] = esc_html__('No Footer', 'solutech');
        }
		return $pix_sections;
	}

	function pixtheme_get_el_sections_array($is_footer = false){
		$args = array(
			'post_type'        => 'pix-el-section',
			'post_status'      => 'publish',
		);
		$pix_sections = array();
		$pix_sections[] = 'Select Section';
		$pix_sections_data = get_posts( $args );
		foreach($pix_sections_data as $pix_section){
			$pix_sections[$pix_section->ID] = $pix_section->post_title;
		}
		if($is_footer){
		    $pix_sections['no-footer'] = esc_html__('No Footer', 'solutech');
        }
		return $pix_sections;
	}

