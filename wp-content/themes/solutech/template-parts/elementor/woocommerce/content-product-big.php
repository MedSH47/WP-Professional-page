<?php
/**
 * Vertical card product template.
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

<div class="bigSliderItem">
    <div class="bestseller">
        <div class="bestseller__head">
            <?php if ( ! has_post_thumbnail() ) : ?>
                <div class="productCard2__slider">
                    <a class="productCard2__images" href="<?php the_permalink(); ?>">
                        <span class="active">
                            <?php echo solutech_get_elementor_woo_placeholder_html( $settings, 'woocommerce_thumbnail' ); ?>
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
                                        <?php solutech_get_elementor_attachment_image_html( $settings, $attachment_id, 'woocommerce_thumbnail' ); ?>
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

            <div class="bestseller__info">
                <?php if ( wc_review_ratings_enabled() ) : ?>
                <div class="bestseller__rating">
                    <?php
                    if ( function_exists( 'woocommerce_template_loop_rating' ) ) {
                        woocommerce_template_loop_rating();
                    }
                    if ( comments_open() ) {
                        $reviews_count = $product->get_review_count();
                        if ( $reviews_count > 0 ) {
                            echo '<span>(' . sprintf( _n( '%s review', '%s reviews', $reviews_count, 'solutech' ), esc_html( $reviews_count ) ) . ')</span>';
                        } else {
                            echo '<span>(' . esc_html__( 'No reviews yet', 'solutech' ) . ')</span>';
                        }
                    }
                    ?>
                </div>
                <?php endif; ?>
                <div class="bestseller__details">
                    <?php
                    if ( function_exists( 'woocommerce_template_single_meta' ) ) {
                        woocommerce_template_single_meta();
                    }
                    ?>
                </div>
                <div class="bestseller__cost">
                    <?php
                    /**
                     * woocommerce_after_shop_loop_item_title hook.
                     *
                     * @hooked woocommerce_template_loop_rating - 5
                     * @hooked woocommerce_template_loop_price - 10
                     */
                    do_action( 'woocommerce_after_shop_loop_item_title' );
                    ?>
                    <div class="bestseller__icons dataFlowUp">
                        <?php solutech_get_archive_wishlist_button_template(); ?>
                        <?php solutech_get_archive_compare_button_template(); ?>
                        <?php solutech_get_quick_view_button_template(); ?>
                        <?php woocommerce_template_loop_add_to_cart(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="bestseller__badges">
            <?php
            if ( function_exists( 'woocommerce_show_product_loop_sale_flash' ) ) {
                woocommerce_show_product_loop_sale_flash();
            }
            ?>
        </div>
        <div class="bestseller__body">
            <h4 class="bestseller__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <div class="bestseller__text">
                <?php
                if ( function_exists( 'woocommerce_template_single_excerpt' ) ) {
                    woocommerce_template_single_excerpt();
                }
                ?>
            </div>
        </div>
    </div>
</div>
