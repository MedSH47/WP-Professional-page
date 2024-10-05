<?php
/**
 * Markup Notice
 *
 * This template can be overridden by copying it to yourtheme/templates/side-cart-woocommerce/global/markup-notice.php.
 *
 * HOWEVER, on occasion we will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen.
 * @see     https://docs.xootix.com/side-cart-woocommerce/
 * @version 4.1
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

extract( Xoo_Wsc_Template_Args::markup_notice() );

if( !$showNotifications ) return;

?>

<div class="xoo-wsc-markup-notices">
	<?php xoo_wsc_cart()->print_notices_html( 'markup' ); ?>
</div>