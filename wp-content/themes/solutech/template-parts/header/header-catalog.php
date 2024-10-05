<?php
$solutech_catalog_categories = solutech_get_option( 'header_catalog_categories', 'all' );
if ( 'selected' === $solutech_catalog_categories ) {
    $product_cats = solutech_get_option( 'header_catalog_selected_categories' );
    $product_cats = ! empty( $product_cats ) ? explode( ',', $product_cats ) : '';
    $product_cats = ! empty( $product_cats ) ? $product_cats : array();
}

$cats_id_arr = array();

$solutech_catalog_banner_img = solutech_get_option( 'header_catalog_banner_img' );
$solutech_catalog_banner_text = solutech_get_option( 'header_catalog_banner_text' );
$solutech_catalog_banner_url = solutech_get_option( 'header_catalog_banner_url' );
$solutech_catalog_title = solutech_get_option( 'header_catalog_title', esc_html__( 'Catalog', 'solutech' ) );
$solutech_catalog_height = solutech_get_option( 'header_catalog_height', 'pix-catalog-100' );
?>

<?php if ( solutech_get_option( 'show_header_catalog', true ) ) : ?>

    <ul class="menu__catalog <?php echo esc_attr( $solutech_catalog_height ) ?>">
        <li class="menu__btn"><a href="#"><i class="pix-icon-menu d-inl"></i> <?php echo esc_html( $solutech_catalog_title ); ?></a>
            <ul>
                <?php
                if ( 'selected' === $solutech_catalog_categories ) :
                    foreach( $product_cats as $slug ) {
                        $term = get_term_by( 'slug', $slug, 'product_cat' );
                        if ( isset( $term->term_id ) ) {
                            $cats_id_arr[] = $term->term_id;
                        }
                    }
                endif;
                $woo_args = array(
                     'taxonomy' => 'product_cat',
                     'orderby'  => 'menu_order',
                     'include'  => $cats_id_arr,
                     'parent'   => 0,
                );
                $woo_categories = get_categories( $woo_args );
                foreach ( $woo_categories as $cat ) :
                    // get the image URL
                    $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                    $image_arr = wp_get_attachment_image_src( $thumbnail_id, 'solutech-thumb-mini', true );
                    $image_src = isset( $image_arr[0] ) ? $image_arr[0] : '';

                    $woo_sub_args = array(
                         'taxonomy' => 'product_cat',
                         'orderby'  => 'menu_order',
                         'include'  => $cats_id_arr,
                         'parent'   => $cat->term_id,
                    );
                    $woo_subcategories = get_categories( $woo_sub_args );
                ?>
                    <li class="menu__catalogItemN1">
                        <a href="<?php echo get_category_link( $cat->term_id ); ?>">
                            <i>
                                <?php if ( ! empty( $image_src ) ) : ?>
                                <img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr( $cat->name ); ?>">
                                <?php endif; ?>
                            </i>
                            <span><?php echo esc_html( $cat->name ); ?></span>
                            <?php if ( ! empty( $woo_subcategories ) ) : ?>
                                <i class="pix-icon-chevron2-right"></i>
                            <?php else : ?>
                                <i></i>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="menu__catalogItemN2">
                        <div class="row">
                            <div class="menu__catalogItemN2Menu">
                                <div class="menu__catalogItemN2MenuInner">
    
                                <?php if ( ! empty( $woo_subcategories ) ) : ?>
                                    <?php foreach ( $woo_subcategories as $subcat ) : ?>
                                    <?php
                                    // get the image URL
                                    $thumbnail_id = get_term_meta( $subcat->term_id, 'thumbnail_id', true );
                                    $image_arr = wp_get_attachment_image_src( $thumbnail_id, 'solutech-thumb-mini', true );
                                    $image_src = isset( $image_arr[0] ) ? $image_arr[0] : '';
    
                                    $woo_sub_sub_args = array(
                                         'taxonomy' => 'product_cat',
                                         'orderby'  => 'menu_order',
                                         'include'  => $cats_id_arr,
                                         'parent'   => $subcat->term_id,
                                    );
                                    $woo_sub_subcategories = get_categories( $woo_sub_sub_args );
                                    ?>
    
                                                <div class="menu__catalogSubmenu">
                                                    <a class="menu__catalogSubmenuTitle" href="<?php echo get_category_link( $subcat->term_id ); ?>">
                                                        <i>
                                                            <?php if ( ! empty( $image_src ) ) : ?>
                                                            <img src="<?php echo esc_url( $image_src ); ?>" alt="<?php echo esc_attr( $subcat->name ); ?>">
                                                            <?php endif; ?>
                                                        </i>
                                                        <span><?php echo esc_html( $subcat->name ); ?></span>
                                                        <?php if ( ! empty( $woo_sub_subcategories ) ) : ?>
                                                            <i class="pix-icon-chevron2-bottom"></i>
                                                        <?php else : ?>
                                                            <i></i>
                                                        <?php endif; ?>
                                                    </a>
                                                    <?php if ( $woo_sub_subcategories ) : ?>
                                                        <ul>
                                                        <?php foreach ( $woo_sub_subcategories as $sub_subcat ) : ?>
                                                            <li><a href="<?php echo get_category_link( $sub_subcat->term_id ); ?>"><?php echo esc_html( $sub_subcat->name ); ?></a></li>
                                                        <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
    
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if ( ! empty( $solutech_catalog_banner_img ) || ! empty( $solutech_catalog_banner_text ) ) : ?>
                            <div class="menu__catalogItemN2Banner">
                                <?php if ( ! empty( $solutech_catalog_banner_img ) ) : ?>
                                <div class="menu__catalogItemN2BannerImg">
                                    <img src="<?php echo esc_url( $solutech_catalog_banner_img ); ?>" alt="<?php echo esc_attr__( 'Catalog banner', 'solutech' ); ?>">
                                </div>
                                <?php endif; ?>
                                <?php if ( ! empty( $solutech_catalog_banner_text ) ) : ?>
                                <div class="menu__catalogItemN2BannerInfo"><?php echo esc_html( $solutech_catalog_banner_text ); ?></div>
                                <?php endif; ?>
                                <?php if ( $solutech_catalog_banner_url ) : ?>
                                <a class="menu__catalogItemN2BannerLink" href="<?php echo esc_url( $solutech_catalog_banner_url ); ?>"></a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>
    </ul>

<?php endif;
