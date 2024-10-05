<?php


function xoo_wsc_notice_html( $message, $notice_type = 'success' ){
	
	$classes = $notice_type === 'error' ? 'xoo-wsc-notice-error' : 'xoo-wsc-notice-success';

	$icon = $notice_type === 'error' ? 'xoo-wsc-icon-cross' : 'xoo-wsc-icon-check_circle';
	
	$html = '<li class="'.$classes.'"><span class="'.$icon.'"></span>'.$message.'</li>';
	
	return apply_filters( 'xoo_wsc_notice_html', $html, $message, $notice_type );
}


//Divi builder fix
function xoo_wsc_fix_for_divi_builder(){

	if ( isset( $_GET['et_fb'] ) && function_exists('xoo_wsc_frontend') ){
		remove_action( 'wp_footer', array( xoo_wsc_frontend(), 'cart_markup' ) );
		add_action( 'wp_head', array( xoo_wsc_frontend(), 'cart_markup' ), 15 );
	}

}
add_action( 'wp_head', 'xoo_wsc_fix_for_divi_builder'  );


/* Block theme fix */
add_action( 'wp_enqueue_scripts', function(){
	if( !function_exists('wc_current_theme_is_fse_theme') || !wc_current_theme_is_fse_theme() ) return;
	wp_enqueue_script( 'wc-cart-fragments' );
}, PHP_INT_MAX );


function xoo_wsc_add_ajax_atc_disable_form(){
	global $product;

	if( !xoo_wsc_enable_ajax_atc_for_product( $product ) ){
		echo '<span class="xoo-wsc-disable-atc" style="display: none!important"></span>';
	}
}

add_action( 'woocommerce_before_add_to_cart_form', 'xoo_wsc_add_ajax_atc_disable_form' );


function xoo_wsc_enable_ajax_atc_for_product( $product ){

	if( is_int( $product ) ){
		$product = wc_get_product( $product );
	}

	$ajaxAtc = xoo_wsc_helper()->get_general_option('m-ajax-atc');

	$enable = true;

	if( $ajaxAtc === 'yes' ){
		$enable = true;
	}
	else if ( $ajaxAtc === 'no' ) {
		$enable = false;
	}
	else{

		$catIds = xoo_wsc_helper()->get_general_option('m-ajax-atc-catid');

		$catIds = $catIds ? explode(',', $catIds ) : array();
		
		//Enable on all except
		if( $ajaxAtc === 'cat_no' ){
			$enable = !( !empty( $catIds ) && array_intersect( $catIds , $product->get_category_ids() ) );	
		}

		//Enable for these category
		if( $ajaxAtc === 'cat_yes' ){
			$enable = array_intersect( $catIds , $product->get_category_ids() );
		}

	}

	return apply_filters( 'xoo_wsc_enable_ajax_atc', $enable, $product );

}


?>