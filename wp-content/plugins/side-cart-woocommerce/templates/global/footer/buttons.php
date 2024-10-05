<?php
/**
 * Footer Buttons
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/footer/buttons.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 2.4
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


extract( Xoo_Wsc_Template_Args::footer_buttons() );

do_action( 'xoo_wsc_before_footer_btns' );

$buttonHTML = '<a href="%1$s" class="%2$s">%3$s</a>';

?>
<div class="xoo-wsc-ft-buttons-cont">

	<?php foreach ( $buttons as $key => $button_data ){

		if( !$button_data['label'] ) continue;
		$button_data['class'][] = 'xoo-wsc-ft-btn-'.$key;

		printf(
			$buttonHTML,
			esc_url( $button_data['url'] ),
			implode( ' ', $button_data['class'] ),
			wp_kses_post( $button_data['label'] )
		);

	} ?>

</div>

<?php do_action( 'xoo_wsc_after_footer_btns' ); ?>