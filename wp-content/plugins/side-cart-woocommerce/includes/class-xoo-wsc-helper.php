<?php

class Xoo_Wsc_Helper extends Xoo_Helper{

	protected static $_instance = null;

	public static function get_instance( $slug, $path ){
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self( $slug, $path );
		}
		return self::$_instance;
	}

	public function get_general_option( $subkey = '' ){
		return $this->get_option( 'xoo-wsc-gl-options', $subkey );
	}

	public function get_style_option( $subkey = '' ){
		return $this->get_option( 'xoo-wsc-sy-options', $subkey );
	}

	public function get_advanced_option( $subkey = '' ){
		return $this->get_option( 'xoo-wsc-av-options', $subkey );
	}

	public function box_shadow_desc($value){
		$html = '<a href="https://box-shadow.dev/" target="__blank">Preview & click on "Show code" -> copy value</a>';
		if( $value ){
			$html .= 'Default: '.$value;
		}
		return $html;
	}

}

function xoo_wsc_helper(){
	return Xoo_Wsc_Helper::get_instance( 'side-cart-woocommerce', XOO_WSC_PATH );
}
xoo_wsc_helper();

?>