<?php

	require_once(get_template_directory() . '/pixtheme/admin/customizer/class.customizer.fonts.php');
	require_once(get_template_directory() . '/pixtheme/admin/customizer/general.php');
	require_once(get_template_directory() . '/pixtheme/admin/customizer/header.php');
	require_once(get_template_directory() . '/pixtheme/admin/customizer/responsive.php');
	require_once(get_template_directory() . '/pixtheme/admin/customizer/social.php');
	require_once(get_template_directory() . '/pixtheme/admin/customizer/sanitizer.php' );

	
	function pixtheme_customize_register( $wp_customize ) {

		/** GENERAL SETTINGS **/
		pixtheme_customize_general_tab($wp_customize,'solutech');
		
		
		/** HEADER SECTION **/

		pixtheme_customize_header_tab($wp_customize,'solutech');


		/** RESPONSIVE SECTION **/

		pixtheme_customize_responsive_tab($wp_customize,'solutech');


		/** SOCIAL SECTION **/

		pixtheme_customize_social_tab($wp_customize,'solutech');

		/** Remove unused sections */

		$removedSections = apply_filters('pixtheme_admin_customize_removed_sections', array('header_image','background_image'));
		foreach ($removedSections as $_sectionName){
			$wp_customize->remove_section($_sectionName);
		}

    }
    
    
	add_action( 'customize_register', 'pixtheme_customize_register' );
	
	

    add_action('wp_ajax_pix_get_customizer_header', 'pix_get_customizer_header');
    add_action('wp_ajax_nopriv_pix_get_customizer_header', 'pix_get_customizer_header');
    
    function pix_get_customizer_header() {
        $data = array_map( 'esc_attr', $_POST );
        
        check_ajax_referer( 'pix_customizer_ajax_nonce', 'nonce' );
        $keys = array_keys($data);
        
        if( true && in_array('header', $keys) ) {
            ob_start();
            get_template_part('templates/header/'.$data['header']);
            $header = ob_get_contents();
            ob_end_clean();
            
            wp_send_json_success( $header );
        } else {
            wp_send_json_error(array('error' => 'Something wrong!'));
        }
    }


    
    add_action('wp_ajax_pix_get_customizer_topbar', 'pix_get_customizer_topbar');
    add_action('wp_ajax_nopriv_pix_get_customizer_topbar', 'pix_get_customizer_topbar');
    
    function pix_get_customizer_topbar() {
        $data = array_map( 'esc_attr', $_POST );
        
        check_ajax_referer( 'pix_customizer_ajax_nonce', 'nonce' );
        $keys = array_keys($data);
        
        if( true && in_array('topbar', $keys) ) {
            ob_start();
            get_template_part('templates/header/header_top');
            $topbar = ob_get_contents();
            ob_end_clean();
            
            wp_send_json_success( $topbar );
        } else {
            wp_send_json_error(array('error' => 'Something wrong!'));
        }
    }

?>