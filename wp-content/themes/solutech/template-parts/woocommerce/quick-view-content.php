<?php
/**
 * Quickview popup template.
 *
 */

global $post, $product;

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );

?>
<div id="popup__product-quick-view-content-<?php echo esc_attr( $product->get_id() ); ?>" <?php wc_product_class( 'popup__product fullprod', $product ); ?>>

    <div class="popup__productImg">
        <div class="fullprod__image-wrapper">
            <?php
            if ( function_exists( 'woocommerce_show_product_sale_flash' ) ) :
                woocommerce_show_product_sale_flash();
            endif;
            get_template_part( 'template-parts/woocommerce/quick-view', 'images' );
            ?>
        </div>
    </div>
    <div class="popup__productInfo">
        <div class="fullprod__info">
            <?php
            if ( solutech_get_option( 'show_product_brand', true ) ) :
                $product_brands = wp_get_object_terms( get_the_id(), 'pix-product-brand' );
                if ( ! empty( $product_brands ) && ! is_wp_error( $product_brands ) ) {
                    foreach ( $product_brands as $brand ) {
                        $brand_thumbnail_id = get_term_meta( $brand->term_id, 'thumbnail_id', true );
                        if ( ! empty( $brand_thumbnail_id ) ) {
                            $brand_image_src = wp_get_attachment_image_src( $brand_thumbnail_id, 'solutech-thumb-limit-height-small' );
                            $brand_image_url = $brand_image_src[0];
                            if(isset($brand_image_src[0])) {
	                            echo '<a class="fullprod__brand" href="' . esc_url( get_category_link( $brand->term_id ) ) . '">
                                    <img src="' . esc_url( $brand_image_url ) . '" alt="' . esc_attr( $brand->name ) . '" />
                                </a>';
                            }
                        }
                    }
                }
            endif;

            /**
             * Hook: woocommerce_single_product_summary.
             *
             * @hooked woocommerce_template_single_title - 5
             * @hooked woocommerce_template_single_rating - 10
             * @hooked woocommerce_template_single_price - 10
             * @hooked woocommerce_template_single_excerpt - 20
             * @hooked woocommerce_template_single_add_to_cart - 30
             * @hooked woocommerce_template_single_meta - 40
             * @hooked woocommerce_template_single_sharing - 50
             * @hooked WC_Structured_Data::generate_product_data() - 60
             */
            do_action( 'woocommerce_single_product_summary' );
            ?>
        </div>
    </div>

</div>
