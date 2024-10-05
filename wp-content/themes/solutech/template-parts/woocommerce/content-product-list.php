<?php
/**
 * The template for displaying list type product content within loops
 *
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
?>

<div <?php wc_product_class( 'productlistItem', $product ); ?>>
    <div class="productlistItem__img">
        <?php echo woocommerce_get_product_thumbnail(); ?>
    </div>

    <div class="productlistItem__badges">
        <?php
        if ( function_exists( 'woocommerce_show_product_loop_sale_flash' ) ) {
            woocommerce_show_product_loop_sale_flash();
        }
        ?>
    </div>
    <div class="productlistItem__body">
        <div class="productlistItem__title"><?php the_title(); ?></div>
        <div class="productlistItem__details">
            <div class="productlistItem__info">
                <?php
                if ( function_exists( 'woocommerce_template_single_meta' ) ) {
                    woocommerce_template_single_meta();
                }
                ?>
            </div>
            <div class="productlistItem__description">
                <?php
                /**
                 * woocommerce_after_shop_loop_item_title hook.
                 *
                 * @hooked woocommerce_template_loop_rating - 5
                 * @hooked woocommerce_template_loop_price - 10
                 */
                do_action( 'woocommerce_after_shop_loop_item_title' );
                wc_get_template( 'single-product/short-description.php' );
                ?>
            </div>
        </div>
    </div>

    <div class="productlistItem__icons">
        <?php solutech_get_archive_wishlist_button_template(); ?>
        <?php solutech_get_archive_compare_button_template(); ?>
        <?php solutech_get_quick_view_button_template(); ?>
        <?php woocommerce_template_loop_add_to_cart(); ?>
    </div>

    <?php woocommerce_template_loop_product_link_open(); ?>
    <?php woocommerce_template_loop_product_link_close(); ?>
</div>
