<?php

    /* Define library path */

    /* Load ADMIN main file */
    require_once(get_template_directory() . '/pixtheme/admin/index.php');

    /* Load FUNCTIONS main file */
    require_once(get_template_directory() . '/pixtheme/functions/index.php');

    if ( did_action( 'elementor/loaded' ) ) {
        require_once get_template_directory() . '/pixtheme/elementor/class-extension.php';
    }

    /* Load VC MAP files */
    require_once(get_template_directory() . '/vc_templates/vc_maps/index.php');

    /* Load Plugins */
    require_once(get_template_directory() . '/pixtheme/install/index.php');

?>