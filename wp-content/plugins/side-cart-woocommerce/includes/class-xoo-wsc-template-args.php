<?php

/**
 * Template Arguments
 */
class Xoo_Wsc_Template_Args{

	public static $gl;
	public static $sy;
	public static $av;

	public static function declare_options(){
		self::$gl = xoo_wsc_helper()->get_general_option();
		self::$sy = xoo_wsc_helper()->get_style_option();
		self::$av = xoo_wsc_helper()->get_advanced_option();
	}


	public static function cart_container(){

		$args = array(
			'showCount' 			=> self::$sy['sck-show-count'],
			'basketIcon' 			=> esc_html( self::$sy['sck-basket-icon'] ),
			'customBasketIcon' 		=> esc_html( self::$sy['sck-cust-icon'] ),
		);


		return apply_filters( 'xoo_wsc_cart_container_args', $args );
		
	}


	public static function cart_body(){

		$show 	= self::$gl['scb-show'];

		$args = array(
			'show' 				=> $show,
			'showPLink' 		=> in_array( 'product_link' , $show ),
			'pnameVariation' 	=> self::$gl['scb-pname-var'],
			'cartOrder'			=> self::$gl['m-cart-order'],
			'cart' 				=> self::$gl['m-cart-order'] === 'desc' ? array_reverse( WC()->cart->get_cart() ) : WC()->cart->get_cart(),
			'emptyCartImg' 		=> self::$sy['scb-empty-img'],
			'shopURL' 			=> self::$gl['m-shop-url'],
			'emptyText' 		=> self::$gl['sct-empty'],
			'shopBtnText' 		=> self::$gl['sct-shop-btn'],
			'buttonClass' 		=> xoo_wsc_frontend()->get_button_classes('text'),
			'priceFormat' 		=> self::$gl['scb-prod-price']
		);

		return apply_filters( 'xoo_wsc_cart_body_args', $args );

	}

	public static function markup_notice(){

		$show 	= self::$gl['sch-show'];

		$args = array(
			'showNotifications' => true,
		);

		return apply_filters( 'xoo_wsc_markup_notice_args', $args );
	}


	public static function cart_header(){

		$show 	= self::$gl['sch-show'];

		$args = array(
			'heading' 			=> trim( esc_html( self::$gl['sct-cart-heading'] ) ),
			'showNotifications' => in_array( 'notifications' , $show ),
			'showBasket' 		=> in_array( 'basket' , $show ),
			'showCloseIcon' 	=> in_array( 'close', $show ),
			'close_icon' 		=> esc_html( self::$sy['sch-close-icon'] ),
		);

		return apply_filters( 'xoo_wsc_cart_header_args', $args );
	}


	public static function cart_footer(){

		$show 	= self::$gl['scf-show'];

		$args = array(
			'heading' 			=> trim( esc_html( self::$gl['sct-cart-heading'] ) ),
			'showCoupon' 		=> in_array( 'coupon' , $show ),
			'couponIcon' 		=> esc_html( self::$sy['scf-coup-icon'] ),
			'footerTxt' 		=> self::$gl['sct-footer'],
			'showFooterTxt' 	=> self::$gl['scf-ftext-hide'] !== "yes" || !WC()->cart->is_empty()
		);

		return apply_filters( 'xoo_wsc_cart_header_args', $args );

	}


	public static function slider(){

		$show 	= self::$gl['scf-show'];

		$args = array(
			'showShipping' 		=> in_array( 'shipping' , $show ),
			'showCoupon' 		=> in_array( 'coupon' , $show ),
			'showNotifications' => in_array( 'notifications', self::$gl['sch-show'] ),
		);

		return apply_filters( 'xoo_wsc_slider_args', $args );

	}


	public static function cart_shortcode(){

		$args = array(
			'icon' 				=> in_array( 'icon', self::$gl['shbk-show'] ) ? 'yes' : 'no',
			'count' 			=> in_array( 'count', self::$gl['shbk-show'] ) ? 'yes' : 'no',
			'subtotal' 			=> in_array( 'subtotal', self::$gl['shbk-show'] ) ? 'yes' : 'no',
			'basketIcon' 		=> esc_html( self::$sy['sck-basket-icon'] ),
			'customBasketIcon' 	=> ''
		);


		return apply_filters( 'xoo_wsc_slider_args', $args );

	}


	public static function product( $_product, $cart_item, $cart_item_key, $cart_item_args = array() ){

		$bundleData = isset( $cart_item_args['bundleData'] ) ? $cart_item_args['bundleData'] : array();

		$productClasses = array(
			'xoo-wsc-product'
		);

		
		$show 				= self::$gl['scb-show'];
		$showPimage 		= in_array( 'product_image' , $show );
		$showPdel 			= in_array( 'product_del', $show );
		$showPprice 		= in_array( 'product_price' , $show );
		$showSalesCount 	= in_array( 'total_sales', $show );
		$updateQty 			= !$_product->is_sold_individually() && self::$gl['scb-update-qty'] === "yes";


		if( !empty( $bundleData ) ){
			$productClasses[] 	= 'xoo-wsc-is-'.$bundleData['type'];
			$productClasses[] 	= 'xoo-wsc-'.$bundleData['key'];
			$showPimage 		= !$bundleData['image'] ? false : $showPimage;
			$updateQty 			= $bundleData['qtyUpdate'];
			$showPprice 		= $showSalesCount = false;
			$showPdel 			= !$bundleData['delete'] ? false : $showPdel;
		}


		$args = array(
			'showPimage' 		=> $showPimage,
			'updateQty' 		=> $updateQty,
			'showSalesCount' 	=> $showSalesCount,
			'showPprice' 		=> $showPprice,
			'showPdel' 			=> $showPdel,
			'productClasses' 	=> $productClasses,
			'showPname' 		=> in_array( 'product_name' , $show ),
			'showPtotal' 		=> in_array( 'product_total' , $show ),
			'showPmeta' 		=> in_array( 'product_meta' , $show ),
			'showPqty' 			=> in_array( 'product_qty', $show ),
			'close_icon' 		=> esc_html( self::$sy['sch-close-icon'] ),
			'delete_icon' 		=> esc_html( self::$sy['scb-del-icon'] ),
			'qtyPriceDisplay' 	=> self::$gl['scbp-qpdisplay'],
			'deletePosition' 	=> self::$sy['scbp-delpos'],
			'deleteType' 		=> self::$sy['scbp-deltype'],
			'deleteText' 		=> self::$gl['sct-delete']
		);

		$args = wp_parse_args( $args, $cart_item_args );

		return apply_filters( 'xoo_wsc_product_args', $args, $_product, $cart_item, $cart_item_key );

	}


	public static function shipping_bar(){

		$show 			= self::$gl['sch-show'];
		$data 			= xoo_wsc_cart()->get_shipping_bar_data();

		$args = array(
			'showBar' 	=> in_array( 'shipping_bar', $show ),
			'data' 		=> $data
		);


		if( !empty( $data ) ){
			$args['text']  	= $data['free'] ? self::$gl['sct-sb-free'] : str_replace( '%s', wc_price( $data['amount_left'] ), self::$gl['sct-sb-remaining']);
		}
	
		return apply_filters( 'xoo_wsc_shipping_bar_args', $args );

	}

	public static function footer_buttons(){

		$show 			= self::$gl['scf-show'];
		$buttonOrder 	= self::$sy['scf-button-pos'];
		$checkoutTxt	= esc_html( self::$gl['sct-ft-chkbtn'] );
		$buttonDesign 	= self::$sy['scf-btns-theme'];
		$buttonClass 	=  xoo_wsc_frontend()->get_button_classes( 'array', array( 'xoo-wsc-ft-btn' ) );
		
		$chkoutBtnClass = !is_user_logged_in() && self::$gl['scf-chklogin-en'] === "yes" && function_exists('xoo_el') ? array_merge( $buttonClass, array( 'xoo-el-login-tgr' ) ) : $buttonClass;	

		$checkoutTotal = self::$gl['scf-chkbtntotal-en'] === 'yes' ? WC()->cart->get_total() : '';

		$buttons = array(
			'continue' 		=> array(
				'label' => self::$gl['sct-ft-contbtn'],
				'url' 	=> self::$gl['scu-continue'],
				'class' => $buttonClass,
			), 
			'cart' 			=>  array(
				'label' => self::$gl['sct-ft-cartbtn'],
				'url' 	=> self::$gl['scu-cart'],
				'class' => $buttonClass,
			),
			'checkout' 		=> array(
				'label' => self::$gl['sct-ft-chkbtn'] . $checkoutTotal,
				'url' 	=> self::$gl['scu-checkout'],
				'class' => $chkoutBtnClass,
			)
		);

		if( $buttons['continue']['url'] === "#" ){
			$buttons['continue']['class'][] = 'xoo-wsc-cart-close';
		}

		
		$buttons = array_merge( array_flip( $buttonOrder ), $buttons );

		//Remove cart & checkout button if cart is empty
		if( WC()->cart->is_empty() ){
			unset( $buttons['cart'] );
			unset( $buttons['checkout'] );
		}

		
		$args = array(
			'buttons' => $buttons
		);

		return apply_filters( 'xoo_wsc_footer_buttons_args', $args );
	}

	public static function footer_extras(){

		$show 				= self::$gl['scf-show'];

		$args = array(
			'showCoupon'	=> in_array( 'coupon' , $show ),
			'couponIcon' 	=> esc_html( self::$sy['scf-coup-icon'] )
		);

		return apply_filters( 'xoo_wsc_footer_extras_args', $args );
	}

	public static function suggested_products(){

		$products 		= xoo_wsc_cart()->get_suggested_products();
		$show 			= self::$gl['scsp-show'];

		$args = array(
			'disable' 		=> !$products || !$products->have_posts() || self::$gl['scsp-enable'] !== 'yes' || ( wp_is_mobile() && self::$gl['scsp-mob-enable'] !== 'yes' ),
			'products' 		=> $products,
			'showPLink' 	=> in_array( 'product_link' , self::$gl['scb-show'] ),
			'showTitle' 	=> in_array( 'title', $show ),
			'showImage' 	=> in_array( 'image', $show ),
			'showDesc' 		=> in_array( 'desc', $show ),
			'showPrice' 	=> in_array( 'price', $show ),
			'showATC' 		=> in_array( 'addtocart', $show ),
			'style' 		=> esc_html( self::$sy['scsp-style'] ),
		);

		return apply_filters( 'xoo_wsc_suggested_product_args', $args );
	}

	public static function footer_totals(){

		$args = array(
			'totals' => xoo_wsc_cart()->get_totals()
		);

		return apply_filters( 'xoo_wsc_footer_totals_args', $args );
	}

}

Xoo_Wsc_Template_Args::declare_options();