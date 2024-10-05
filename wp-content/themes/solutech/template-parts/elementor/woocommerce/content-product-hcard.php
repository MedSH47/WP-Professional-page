<?php
/**
 * Horizontal card product template.
 *
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$attachment_ids = $product->get_gallery_image_ids();

if ( has_post_thumbnail() ) {
    $thumbnail_id = (int) get_post_thumbnail_id();
    array_unshift( $attachment_ids, $thumbnail_id );
}
?>

<div class="productCard2">
    <div class="productCard__badges">
        <?php
        if ( function_exists( 'woocommerce_show_product_loop_sale_flash' ) ) {
            woocommerce_show_product_loop_sale_flash();
        }
        ?>
    </div>
    <div class="productCard2Left">
        <?php if ( ! has_post_thumbnail() ) : ?>
            <div class="productCard2__slider">
                <a class="productCard2__images" href="<?php the_permalink(); ?>">
                    <span class="active">
                        <?php echo solutech_get_elementor_woo_placeholder_html( $settings, 'solutech-product-thumb' ); ?>
                    </span>
                </a>
            </div>
        <?php elseif ( ! empty( $attachment_ids ) ) : ?>
            <div class="productCard2__slider">
                <a class="productCard2__images" href="<?php the_permalink(); ?>">
                    <?php $i = 1; ?>
                    <?php foreach ( $attachment_ids as $attachment_id ) : ?>
                        <?php
                        $props = wc_get_product_attachment_props( $attachment_id, $post );
                        if ( $props['url'] ) :
                        ?>
                                <span <?php if ( $i === 1 ) : ?>class="active"<?php endif; ?>>
                                    <?php solutech_get_elementor_attachment_image_html( $settings, $attachment_id, 'solutech-product-thumb' ); ?>
                                </span>
                            <?php
                        endif;
                        $i++;
                    endforeach; ?>
                    <i class="productCard2__hover"></i>
                </a>
                <span class="productCard2__dots"></span>
            </div>
        <?php endif; ?>
    </div>
    <div class="productCard2Right">
        <?php if ( $product->is_in_stock() && $product->is_on_sale() ) :
            $sales_price_to = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );
            $sales_price_date_to = ( $sales_price_to ) ? date( "Y/m/d", $sales_price_to ) : '';
            ?>
            <?php if ( ! empty( $sales_price_date_to ) ) : ?>
                <div class="productCard2__timer timer" data-countdown="<?php echo esc_attr( $sales_price_date_to ); ?>"></div>
            <?php endif; ?>
        <?php endif; ?>

        <h6 class="productCard2__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h6>
        <div class="productCard2__text">
             <?php
            if ( function_exists( 'woocommerce_template_single_excerpt' ) ) {
                woocommerce_template_single_excerpt();
            }
            ?>
        </div>
        <div class="productCard2__info <?php echo solutech_get_option( 'shop_product_buttons', '' ); ?>">
            <?php
            /**
             * woocommerce_after_shop_loop_item_title hook.
             *
             * @hooked woocommerce_template_loop_rating - 5
             * @hooked woocommerce_template_loop_price - 10
             */
            do_action( 'woocommerce_after_shop_loop_item_title' );
            ?>
            <div class="productCard2__icons dataFlowUp">
                <?php solutech_get_archive_wishlist_button_template(); ?>
                <?php solutech_get_archive_compare_button_template(); ?>
                <?php solutech_get_quick_view_button_template(); ?>
                <?php woocommerce_template_loop_add_to_cart(); ?>
            </div>
        </div>
    </div>
</div>
