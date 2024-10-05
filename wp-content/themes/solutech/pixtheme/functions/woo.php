<?php

/********** WOOCOMERCE **********/

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);

add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 9);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15);
add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20);


add_filter( 'woocommerce_show_page_title' , 'pixtheme_woo_hide_page_title' );
function pixtheme_woo_hide_page_title() {
	return false;
}

add_filter('woocommerce_product_description_heading', '__return_empty_string');
add_filter('woocommerce_product_additional_information_heading', '__return_empty_string');


add_action( 'woocommerce_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_title_open', 5);
function pixtheme_woo_shop_loop_item_title_open() {
	echo '<div class="woo-item-footer">';
};

add_action( 'woocommerce_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_title', 10);
function pixtheme_woo_shop_loop_item_title() {
	echo '<div class="product-name"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>';
};

add_action( 'woocommerce_after_shop_loop_item_title', 'pixtheme_woo_shop_loop_item_title_close', 15);
function pixtheme_woo_shop_loop_item_title_close() {
	echo '</div>';
};

add_filter( 'loop_shop_per_page', function( $cols ){ return pixtheme_get_option('solutech_products_per_page','6'); }, 20 );


add_filter('loop_shop_columns', 'pixtheme_loop_columns');
if (!function_exists('pixtheme_loop_columns')) {
	function pixtheme_loop_columns() {
		return 3; // 3 products per row
	}
}

add_filter( 'woocommerce_output_related_products_args', 'pixtheme_related_products_args' );
function pixtheme_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 3 related products
	$args['columns'] = 3; // arranged in 3 columns
	return $args;
}

add_filter( 'woocommerce_add_to_cart_fragments', 'pixtheme_cart_count_fragments', 10, 1 );
function pixtheme_cart_count_fragments( $fragments ) {

    $icon = '<i class="fas fa-shopping-basket"></i>';
    $fragments['div.pix-cart-items'] = '<div class="pix-cart-items">'.wp_kses_post($icon).'<span class="pix-cart-count">'.WC()->cart->cart_contents_count.'</span></div>';

    return $fragments;

}

function pixtheme_woo_get_page_id(){

    global $post;

    if( is_shop() || is_product_category() || is_product_tag() )
        $id = get_option( 'woocommerce_shop_page_id' );
    elseif( is_product() || !empty($post->ID) )
        $id = $post->ID;
    else
        $id = 0;
    return $id;
}

function pixtheme_is_woo_page () {
        if(  function_exists ( "is_woocommerce" ) && is_woocommerce()){
                return true;
        }
        $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                        "woocommerce_terms_page_id" ,
                                        "woocommerce_cart_page_id" ,
                                        "woocommerce_checkout_page_id" ,
                                        "woocommerce_pay_page_id" ,
                                        "woocommerce_thanks_page_id" ,
                                        "woocommerce_myaccount_page_id" ,
                                        "woocommerce_edit_address_page_id" ,
                                        "woocommerce_view_order_page_id" ,
                                        "woocommerce_change_password_page_id" ,
                                        "woocommerce_logout_page_id" ,
                                        "woocommerce_lost_password_page_id" ) ;
        foreach ( $woocommerce_keys as $wc_page_id ) {
                if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                        return true ;
                }
        }
        return false;
}