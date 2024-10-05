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

<div <?php wc_product_class( 'col pix-product-icons-center', $product ); ?>>
    <div class="productCard">
        
        <div class="productCard__linkContainer">
            <div class="productCard__img">
                <?php echo woocommerce_get_product_thumbnail('solutech-product-thumb'); ?>
            </div>
            
            <div class="productCard__badges">
                <?php
                if ( function_exists( 'woocommerce_show_product_loop_sale_flash' ) ) {
                    woocommerce_show_product_loop_sale_flash();
                }
                ?>
            </div>
    
            <?php woocommerce_template_loop_product_link_open(); ?>
            <?php woocommerce_template_loop_product_link_close(); ?>
            
            <div class="productCard__icons">
                <?php solutech_get_archive_wishlist_button_template(); ?>
                <?php solutech_get_archive_compare_button_template(); ?>
                <?php solutech_get_quick_view_button_template(); ?>
                <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>
        </div>
        
        <div class="productCard__info">
            <div class="productCard__infoTitle"><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php the_title(); ?></a></div>
		    <?php
			    /**
			     * woocommerce_after_shop_loop_item_title hook.
			     *
			     * @hooked woocommerce_template_loop_rating - 5
			     * @hooked woocommerce_template_loop_price - 10
			     */
			    do_action( 'woocommerce_after_shop_loop_item_title' );
		    ?>
        </div>
        
    </div>
</div>
