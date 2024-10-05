<?php

/**
 * Icons loader for VC
 */

function pixtheme_init_vc_icons(){
    $pix_libs = $pix_fonts = $pix_fonts_str = $params = $params1 = $params2 = array();

    if(function_exists('fil_init')) {

        if( array_key_exists( 'vc_iconpicker-type-pixflaticon' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Flaticon', 'solutech' )] = 'pixflaticon';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixfontawesome' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Font Awesome', 'solutech' )] = 'pixfontawesome';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixelegant' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Elegant', 'solutech' )] = 'pixelegant';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixicomoon' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Icomoon', 'solutech' )] = 'pixicomoon';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixsimple' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Simple', 'solutech' )] = 'pixsimple';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixlinear' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Linear', 'solutech' )] = 'pixlinear';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixstroke' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Stroke-Gap-Icons', 'solutech' )] = 'pixstroke';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom', 'solutech' )] = 'pixcustom';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom1' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom 1', 'solutech' )] = 'pixcustom1';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom2' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom 2', 'solutech' )] = 'pixcustom2';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom3' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom 3', 'solutech' )] = 'pixcustom3';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom4' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom 4', 'solutech' )] = 'pixcustom4';
        }
        if( array_key_exists( 'vc_iconpicker-type-pixcustom5' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'Custom 5', 'solutech' )] = 'pixcustom5';
        }
        if( array_key_exists( 'vc_iconpicker-type-fontawesome' , $GLOBALS['wp_filter']) ) {
            $pix_libs[esc_html__( 'VC Font Awesome', 'solutech' )] = 'fontawesome';
        }
        if( get_option('fil_use_vc_icons') ) {
            if (array_key_exists('vc_iconpicker-type-openiconic', $GLOBALS['wp_filter'])) {
                $pix_libs[esc_html__('VC Open Iconic', 'solutech')] = 'openiconic';
            }
            if (array_key_exists('vc_iconpicker-type-typicons', $GLOBALS['wp_filter'])) {
                $pix_libs[esc_html__('VC Typicons', 'solutech')] = 'typicons';
            }
            if (array_key_exists('vc_iconpicker-type-entypo', $GLOBALS['wp_filter'])) {
                $pix_libs[esc_html__('VC Entypo', 'solutech')] = 'entypo';
            }
            if (array_key_exists('vc_iconpicker-type-linecons', $GLOBALS['wp_filter'])) {
                $pix_libs[esc_html__('VC Linecons', 'solutech')] = 'linecons';
            }
        }

        if (empty($pix_libs)) {
            $pix_libs[esc_html__('No Active Fonts', 'solutech')] = 'no-fonts';
        }

        $add_icon_libs = array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Icon library', 'solutech' ),
            'param_name' => 'type',
            'value' => $pix_libs,
            'admin_label' => true,
            'description' => esc_html__( 'Select icon library.', 'solutech' ),
        );

        if (!empty($pix_libs)) {
            $pix_fonts_str[] = $add_icon_libs;

            foreach ($pix_libs as $val) {
                if ($val != ''){
                    $pix_fonts[$val] = array(
                        'type' => 'iconpicker',
                        'heading' => esc_html__('Icon', 'solutech'),
                        'param_name' => 'icon_' . $val,
                        'value' => '',
                        'settings' => array(
                            'emptyIcon' => true,
                            'type' => $val,
                            'iconsPerPage' => 4000,
                        ),
                        'dependency' => array(
                            'element' => 'type',
                            'value' => $val,
                        ),
                        'description' => esc_html__('Select icon from library.', 'solutech'),
                    );
                }

                $pix_fonts_str[] = $pix_fonts[$val];
            }
        }
    }
    return $pix_fonts_str;
}



function pixtheme_get_vc_icons($pix_fonts_str, $element='', $value=array()){
    $result = array();
    if (!empty($pix_fonts_str) && function_exists('fil_init')) {
        if($element != '') {
            $pix_fonts_str[0]['dependency'] = array('element' => $element,'value' => $value);
        } elseif( isset($pix_fonts_str[0]['dependency']) ){
            unset($pix_fonts_str[0]['dependency']);
        }
        $result = apply_filters('pixtheme_vc_icons_loader_show', $pix_fonts_str);
    }

    return array_values($result);

}






?>