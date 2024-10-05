<?php
/**
 * Side Cart Markup
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/xoo-wsc-markup.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 2.4.4
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="xoo-wsc-markup">
	<div class="xoo-wsc-modal">

		<?php xoo_wsc_helper()->get_template( 'xoo-wsc-container.php' ); ?>

		<span class="xoo-wsc-opac"></span>

	</div>
</div>