<?php
/**
 * Totals
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/footer/totals.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 2.1
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::footer_totals() );

?>

<?php if( WC()->cart->is_empty() ) return; ?>

<div class="xoo-wsc-ft-totals">
	<?php foreach( $totals as $key => $data ): ?>
		<div class="xoo-wsc-ft-amt xoo-wsc-ft-amt-<?php echo $key; ?> <?php echo isset( $data['action'] ) ? $data['action'] : '' ?>">
			<span class="xoo-wsc-ft-amt-label"><?php echo $data['label'] ?></span>
			<span class="xoo-wsc-ft-amt-value"><?php echo $data['value'] ?></span>
		</div>
	<?php endforeach; ?>

	<?php do_action( 'xoo_wsc_totals_end' ); ?>

</div>