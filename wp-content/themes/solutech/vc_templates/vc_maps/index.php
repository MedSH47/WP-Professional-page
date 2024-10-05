<?php 
/**  Theme_vc_index  **/

add_action( 'vc_before_init', 'pixtheme_integrate_vc', 200 );

function pixtheme_integrate_vc() {
    /** Fonts Icon Loader */

    include_once( get_template_directory() . '/vc_templates/vc_maps/vc_add_icons.php' );
    include_once( get_template_directory() . '/vc_templates/vc_maps/vc_add_params.php' );
    include_once( get_template_directory() . '/vc_templates/vc_maps/vc_add_carousel.php' );
    include_once( get_template_directory() . '/vc_templates/vc_maps/vc_add_gradient.php' );
    include_once( get_template_directory() . '/vc_templates/vc_maps/vc_add_animate.php' );
    include_once( get_template_directory() . '/vc_templates/vc_maps/vc_add_shadows.php' );
    include_once( get_template_directory() . '/vc_templates/vc_maps/vc_common.php' );

    //////////////////////////////////////////////////////////////////////

	if(isset($_GET['vc_action']) && $_GET['vc_action'] == 'vc_inline'){
		wp_enqueue_style('pixtheme-theme', get_stylesheet_directory_uri() . '/pixtheme/admin/css/editor_styles.css');
	}

	return true;

}
?>