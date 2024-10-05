<?php
/**
 * Basket Shortcode
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/xoo-wsc-shortcode.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 2.2
 */


if ( ! defined( 'ABSPATH' ) || !WC() || !WC()->cart ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::cart_shortcode() );
?>


<div class="xoo-wsc-sc-cont">
	<div class="xoo-wsc-cart-trigger">

		<?php if( $subtotal === 'yes' ): ?>
			<span class="xoo-wsc-sc-subt">
				<?php echo WC()->cart->get_cart_subtotal() ?>
			</span>
		<?php endif; ?>


		<div class="xoo-wsc-sc-bkcont">
			
			<?php if( $icon === 'yes' ): ?>

				<?php if( $customBasketIcon ): ?>
					<span class="xoo-wsc-sc-bki"><img src="<?php echo esc_url($customBasketIcon) ?>"></span>
				<?php else: ?>
					<span class="xoo-wsc-sc-bki <?php echo esc_html($basketIcon) ?>"></span>
				<?php endif; ?>

			<?php endif; ?>

			<?php if( $count === 'yes' ): ?>
				<span class="xoo-wsc-sc-count"><?php echo esc_html( xoo_wsc_cart()->get_cart_count() ) ?></span>
			<?php endif; ?>

		</div>

		<?php do_action( 'xoo_wsc_cart_shortcode_content' ); ?>

	</div>
</div>