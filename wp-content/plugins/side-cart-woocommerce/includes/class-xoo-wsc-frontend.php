<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class Xoo_Wsc_Frontend{

	protected static $_instance = null;
	public $glSettings;
	public $template_args = array();


	public static function get_instance(){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __construct(){
		$this->glSettings = xoo_wsc_helper()->get_general_option();
		$this->hooks();
	}

	public function hooks(){

		add_action( 'wp_enqueue_scripts' ,array( $this,'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts' , array( $this,'enqueue_scripts' ), 15 );
		add_action( 'wp_footer', array( $this, 'cart_markup' ) );

		add_action( 'wp', array( $this, 'basket_menu_filter' ) );

		add_shortcode( 'xoo_wsc_cart', array( $this, 'basket_shortcode' ) );
	}


	public function basket_menu_filter(){
		$menu = $this->glSettings['shbk-menu'];
		if( !$menu || $menu === 'none' ) return;
		add_filter( 'wp_nav_menu_'.$menu.'_items', array( $this, 'basket_menu_html' ), 9999, 2 );
	}

	public function basket_menu_html( $items, $args ){

		$items .=  '<li class="menu-item xoo-wsc-menu-item">'.do_shortcode('[xoo_wsc_cart]').'</li>';

  		return $items;

	}


	//Enqueue stylesheets
	public function enqueue_styles(){

		if( !xoo_wsc()->isSideCartPage() ) return;

		//Fonts
		wp_enqueue_style( 'xoo-wsc-fonts', XOO_WSC_URL.'/assets/css/xoo-wsc-fonts.css', array(), XOO_WSC_VERSION );

		wp_enqueue_style( 'xoo-wsc-style', XOO_WSC_URL.'/assets/css/xoo-wsc-style.css', array(), XOO_WSC_VERSION );


		$inline_style =  xoo_wsc_helper()->get_template(
			'global/inline-style.php',
			array(
				'gl' => xoo_wsc_helper()->get_general_option(),
				'sy' => xoo_wsc_helper()->get_style_option(),
			),
			'',
			true
		);

		$customCSS = xoo_wsc_helper()->get_advanced_option('m-custom-css');

		wp_add_inline_style( 'xoo-wsc-style', strip_tags( $inline_style . $customCSS ) );

	}

	//Enqueue javascript
	public function enqueue_scripts(){

		if( !xoo_wsc()->isSideCartPage() ) return;

		$glSettings = $this->glSettings;

		if( is_product() ){
			$ajaxAtc = xoo_wsc_enable_ajax_atc_for_product( get_the_id() );
		}
		else{
			$ajaxAtc = $glSettings['m-ajax-atc'] !== 'no';
		}

		wp_enqueue_script( 'xoo-wsc-main-js', XOO_WSC_URL.'/assets/js/xoo-wsc-main.js', array('jquery'), XOO_WSC_VERSION, array( 'strategy' => 'defer' ) ); // Main JS

		$skipAjaxForData = array();

		if( function_exists('WCS_ATT') ){
			$skipAjaxForData['add-to-subscription'] = '';
		}

		$noticeMarkup = '<ul class="xoo-wsc-notices">%s</ul>';

		wp_localize_script( 'xoo-wsc-main-js', 'xoo_wsc_params', array(
			'adminurl'  			=> admin_url().'admin-ajax.php',
			'wc_ajax_url' 		  	=> WC_AJAX::get_endpoint( "%%endpoint%%" ),
			'qtyUpdateDelay' 		=> (int) $glSettings['scb-update-delay'],
			'notificationTime' 		=> (int) $glSettings['sch-notify-time'],
			'html' 					=> array(
				'successNotice' =>	sprintf( $noticeMarkup, xoo_wsc_notice_html( '%s%', 'success' ) ),
				'errorNotice'	=> 	sprintf( $noticeMarkup, xoo_wsc_notice_html( '%s%', 'error' ) ),
			),
			'strings'				=> array(
				'maxQtyError' 			=> __( 'Only %s% in stock', 'side-cart-woocommerce' ),
				'stepQtyError' 			=> __( 'Quantity can only be purchased in multiple of %s%', 'side-cart-woocommerce' ),
				'calculateCheckout' 	=> __( 'Please use checkout form to calculate shipping', 'side-cart-woocommerce' ),
				'couponEmpty' 			=> __( 'Please enter promo code', 'side-cart-woocommerce' )
			),
			'isCheckout' 			=> is_checkout(),
			'isCart' 				=> is_cart(),
			'sliderAutoClose' 		=> true,
			'shippingEnabled' 		=> in_array( 'shipping' , $glSettings['scf-show'] ),
			'couponsEnabled' 		=> in_array( 'coupon' , $glSettings['scf-show'] ),
			'autoOpenCart' 			=> $glSettings['m-auto-open'],
			'addedToCart' 			=> xoo_wsc_cart()->addedToCart,
			'ajaxAddToCart' 		=> $ajaxAtc ? 'yes' : 'no',
			'skipAjaxForData' 		=> $skipAjaxForData,
			'showBasket' 			=> xoo_wsc_helper()->get_style_option('sck-enable'),
			'flyToCart' 			=> 'no',
			'productFlyClass' 		=> apply_filters( 'xoo_wsc_product_fly_class', '' ),
			'refreshCart' 			=> xoo_wsc_helper()->get_advanced_option('m-refresh-cart'),
			'fetchDelay' 			=> apply_filters( 'xoo_wsc_cart_fetch_delay', 200 ),
			'triggerClass' 			=> xoo_wsc_helper()->get_advanced_option('m-trigger-class'),
		) );
	}


	//Cart markup
	public function cart_markup(){

		if( !xoo_wsc()->isSideCartPage() ) return;

		echo '<div class="xoo-wsc-markup-notices"></div>';
		xoo_wsc_helper()->get_template( 'xoo-wsc-markup.php' );

	}

	public function get_button_classes( $view = 'array', $custom = array() ){

		$class = array_merge( $custom, array( 'xoo-wsc-btn' ) );

		if( xoo_wsc_helper()->get_style_option('scf-btns-theme') === 'theme' ){
			$class[] = 'button';
			$class[] = 'btn';
		}

		return $view === 'array' ? $class : implode( ' ' , $class);
	}


	public function basket_shortcode($atts){

		if( is_admin() || !xoo_wsc()->isSideCartPage() ) return;

		$atts = shortcode_atts( array(), $atts, 'xoo_wsc_cart');

		return xoo_wsc_helper()->get_template( 'xoo-wsc-shortcode.php', $atts, '', true );
	}


}

function xoo_wsc_frontend(){
	return Xoo_Wsc_Frontend::get_instance();
}
xoo_wsc_frontend();