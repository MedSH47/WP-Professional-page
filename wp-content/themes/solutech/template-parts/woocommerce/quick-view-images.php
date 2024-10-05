<?php
/**
 * Popup Product Image
 */

defined( 'ABSPATH' ) || exit;

global $post, $product;

$slides_html = '';

$attachment_ids = $product->get_gallery_image_ids();

if ( has_post_thumbnail() ) {
    $thumbnail_id = (int) get_post_thumbnail_id();
    array_unshift( $attachment_ids, $thumbnail_id );
}
?>

<div class="images">
<?php if ( ! empty( $attachment_ids ) ) :
    $count_attachments = count( $attachment_ids );
    ?>

    <?php if ( $count_attachments > 1 ) : ?>

        <?php
        foreach ( $attachment_ids as $attachment_id ) :
            $props = wc_get_product_attachment_props( $attachment_id, $post );

            if ( ! $props['url'] ) {
                continue;
            }

            $slides_html .= '<div class="swiper-slide">' . wp_get_attachment_image( $attachment_id, 'woocommerce_single' ) . '</div>';

        endforeach;
        ?>
        <div class="popup__productImg woocommerce-product-gallery__image pix-swiper">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <?php echo wp_kses( $slides_html, 'solutech-default' ); ?>
                </div>
                <div class="arrows__btn-prev"><i class="pix-icon-chevron-left"></i></div><div class="arrows__btn-next" href="#"><i class="pix-icon-chevron-right"></i></div>
            </div>
        </div>

    <?php else : ?>
        <div class="popup__productImg woocommerce-product-gallery__image">
            <?php
            if ( isset( $thumbnail_id ) ) :
                echo wp_get_attachment_image( $thumbnail_id, 'woocommerce_single', '', array( 'class' => 'wp-post-image woocommerce-product-gallery__image' ) );
            endif;
            ?>
        </div>
    <?php endif; ?>

<?php else : ?>
<div class="popup__productImg woocommerce-product-gallery__image">
    <?php echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img class="wp-post-image woocommerce-product-gallery__image" src="%s" alt="%s" />', wc_placeholder_img_src(), esc_attr__( 'Placeholder', 'solutech' ) ), $post->ID ); ?>
</div>
<?php endif; ?>
</div>
