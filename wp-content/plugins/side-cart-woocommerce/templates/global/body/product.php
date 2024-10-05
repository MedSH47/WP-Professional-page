<?php
/**
 * Product
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/body/product.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 2.5
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$productClasses = apply_filters( 'xoo_wsc_product_class', $productClasses );
$oneLiner  		= $qtyPriceDisplay === 'one_liner' && $showPprice && $showPtotal && $showPqty;

?>

<div data-key="<?php echo $cart_item_key ?>" class="<?php echo implode( ' ', $productClasses ) ?>">

	<?php do_action( 'xoo_wsc_product_start', $_product, $cart_item_key ); ?>

		<div class="xoo-wsc-img-col">

			<?php if( $showPimage ): ?>

				<?php echo $thumbnail; ?>

			<?php endif; ?>

			<?php if( $showPdel && $deletePosition === 'image' ): ?>

				<?php if( $deleteType === 'icon' ): ?>
					<span class="xoo-wsc-smr-del <?php echo $delete_icon ?>"></span>
				<?php else: ?>
					<span class="xoo-wsc-smr-del xoo-wsc-del-txt"><?php echo $deleteText ?></span>
				<?php endif; ?>

			<?php endif; ?>


			<?php do_action( 'xoo_wsc_product_image_col', $_product, $cart_item_key ); ?>

		</div>


	<div class="xoo-wsc-sum-col">

		<?php do_action( 'xoo_wsc_product_summary_col_start', $_product, $cart_item_key ); ?>

		<div class="xoo-wsc-sm-info">

			<div class="xoo-wsc-sm-left">

				<?php if( $showPname ): ?>
					<span class="xoo-wsc-pname"><?php echo $product_name; ?></span>
				<?php endif; ?>
				
				<?php if( $showPmeta ) echo $product_meta ?>


				<!-- Quantity -->

				
				<?php if( $oneLiner ): ?>

					<div class="xoo-wsc-qty-price">
						<span><?php echo $cart_item['quantity']; ?></span>
						<span>X</span>
						<span><?php echo $product_price; ?></span>
						<span>=</span>
						<span><?php echo $product_subtotal ?></span>
					</div>

				<?php else: ?>

					<?php if( $showPqty ): ?>
						<div class="xoo-wsc-sml-qty"><?php _e( 'Qty:', 'side-cart-woocommerce' ) ?> <span><?php echo $cart_item['quantity']; ?></span></div>
					<?php endif; ?>

					<?php if( $showPprice ): ?>
						<div class="xoo-wsc-pprice">
							<?php echo __( 'Price: ', 'side-cart-woocommerce' ) . $product_price ?>
						</div>
					<?php endif; ?>

				<?php endif; ?>

			</div>

			<!-- End Quantity -->

			<div class="xoo-wsc-sm-right">

				<?php if( $showPdel && $deletePosition === 'default' ): ?>

					<?php if( $deleteType === 'icon' ): ?>
						<span class="xoo-wsc-smr-del <?php echo $delete_icon ?>"></span>
					<?php else: ?>
						<span class="xoo-wsc-smr-del xoo-wsc-del-txt"><?php echo $deleteText ?></span>
					<?php endif; ?>

				<?php endif; ?>

				<?php if( $showPtotal && !$oneLiner ): ?>
					<span class="xoo-wsc-smr-ptotal"><?php echo $product_subtotal ?></span>
				<?php endif; ?>

			</div>

		</div>

		<?php do_action( 'xoo_wsc_product_summary_col_end', $_product, $cart_item_key ); ?>

	</div>

	<?php do_action( 'xoo_wsc_product_end', $_product, $cart_item_key ); ?>

</div>