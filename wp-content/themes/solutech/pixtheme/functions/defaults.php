<?php 
/**  Theme defaults values  **/

add_action('after_setup_theme', 'pixtheme_theme_defaults');
function pixtheme_theme_defaults(){

    update_option( 'pixtheme_default_content_width', '1200' );
    
	// Logo
	update_option( 'pixtheme_default_logo_width', '140' );
	update_option( 'pixtheme_default_logo_height', '100' );

	// Header
    update_option( 'pixtheme_default_header_menu_background', 'main-color' );

	// Colors and Fonts
	update_option( 'pixtheme_default_main_color', '#216fff' );
	update_option( 'pixtheme_default_gradient_color', '#ffc02d' );
	update_option( 'pixtheme_default_gradient_direction', 'to right' );
	update_option( 'pixtheme_default_additional_color', '#f5f7f9' );
    update_option( 'pixtheme_default_black_color', '#212121' );

	update_option( 'pixtheme_default_fonts_embed', 'Jost:400,500,600,700');

	update_option( 'pixtheme_default_font', 'Jost' );
	update_option( 'pixtheme_default_font_weight', '400' );
	update_option( 'pixtheme_default_font_size', '18' );
	update_option( 'pixtheme_default_font_line_height', '1.8' );
	update_option( 'pixtheme_default_font_ratio', '1.2' );
	update_option( 'pixtheme_default_font_color', '#3a3a3a' );
	update_option( 'pixtheme_default_font_color_light', '#e2e2e2' );

	update_option( 'pixtheme_default_title_font', 'Jost' );
	update_option( 'pixtheme_default_title_weight', '600' );
	update_option( 'pixtheme_default_title_size', '38' );
	update_option( 'pixtheme_default_title_color', '#000000' );

	update_option( 'pixtheme_default_subtitle_font', 'Jost' );
	update_option( 'pixtheme_default_subtitle_weight', '600' );
	update_option( 'pixtheme_default_subtitle_size', '20' );
	update_option( 'pixtheme_default_subtitle_color', '#000000' );

	update_option( 'pixtheme_default_link_font', 'Jost' );
	update_option( 'pixtheme_default_link_weight', '600' );
	update_option( 'pixtheme_default_link_size', '20' );
	update_option( 'pixtheme_default_link_color', '#000000' );

	update_option( 'pixtheme_default_button_font', 'Jost' );
	update_option( 'pixtheme_default_button_font_size', '18' );
	update_option( 'pixtheme_default_button_font_weight', '500' );
    update_option( 'pixtheme_default_button_shape', 'pix-rounded' );
    update_option( 'pixtheme_default_button_color', 'main' );
    update_option( 'pixtheme_default_button_border', '2' );

	// Header Title and Breadcrumbs
	update_option( 'pixtheme_default_tab_bg_color', '#050017' );
	update_option( 'pixtheme_default_tab_bg_color_gradient', '' );
	update_option( 'pixtheme_default_tab_gradient_direction', 'to top left' );
	update_option( 'pixtheme_default_tab_bg_opacity', '80' );
	update_option( 'pixtheme_default_tab_padding_top', '190' );
	update_option( 'pixtheme_default_tab_padding_bottom', '260' );
    update_option( 'pixtheme_default_tab_margin_bottom', '0' );

	update_option( 'pixtheme_default_decor', '0' );
	
	update_option( 'pixtheme_default_blog_icons', 'off' );

}

add_filter( 'pixtheme_header_settings', 'pixtheme_header_settings_var' );
function pixtheme_header_settings_var( $post_ID=0 ){

	/// Header global parameters
    $solutech['header_type'] = pixtheme_get_option('header_type', 'header1');
    $solutech['header_background'] = pixtheme_get_option('header_background', 'black');
    $solutech['header_transparent'] = pixtheme_get_option('header_transparent', '0');
    $solutech['top_bar_background'] = pixtheme_get_option('top_bar_background', 'black');
    $solutech['top_bar_transparent'] = pixtheme_get_option('top_bar_transparent', '100');
    $solutech['header_layout'] = pixtheme_get_option('header_layout', 'container');
    $solutech['header_bar'] = pixtheme_get_option('header_bar', '0');
    $solutech['header_sticky'] = pixtheme_get_option('header_sticky', 'sticky');
    $solutech['header_sticky_width'] = pixtheme_get_option('header_sticky_width', '');
    $solutech['header_sticky_mobile'] = pixtheme_get_option('header_sticky_mobile', '');
    $solutech['header_menu_pos'] = pixtheme_get_option('header_menu_pos', 'pix-text-center');
    $solutech['header_menu_right_info'] = pixtheme_get_option('header_menu_right_info', 'phone');


    /// Header menu settings
    $solutech['header_menu'] = pixtheme_get_option('header_menu', '1');

    /// Header widgets
    $solutech['header_minicart'] = pixtheme_get_option('header_minicart', '0');
    $solutech['header_search'] = pixtheme_get_option('header_search', '1');
    $solutech['header_socials'] = pixtheme_get_option('header_socials', '1');
    $solutech['header_button'] = pixtheme_get_option('header_button', '0');

    $solutech['header_phone'] = pixtheme_get_option('header_phone', '');
    $solutech['header_email'] = pixtheme_get_option('header_email', '');
    $solutech['header_address'] = pixtheme_get_option('header_address', '');
    $solutech['header_custom_info'] = pixtheme_get_option('header_custom_info', '');
    

    /// Responsive
    $solutech['mobile_sticky'] = pixtheme_get_option('mobile_sticky', '');
    $solutech['mobile_topbar'] = pixtheme_get_option('mobile_topbar', '');
    $solutech['tablet_minicart'] = pixtheme_get_option('tablet_minicart', '');
    $solutech['tablet_search'] = pixtheme_get_option('tablet_search', '');
    $solutech['tablet_phone'] = pixtheme_get_option('tablet_phone', '');
    $solutech['tablet_socials'] = pixtheme_get_option('tablet_socials', '');


    /// Logo
    $solutech['logo'] = pixtheme_get_option('general_settings_logo', '');
    $solutech['logo_mobile'] = pixtheme_get_option('general_settings_logo_mobile', '');


	return $solutech;
	
}