<?php
    $solutech_title_breacrumbs_display = solutech_get_option( 'title_breacrumbs_display', 'show' );
    
    $post_ID = isset( $wp_query ) ? $wp_query->get_queried_object_id() : ( get_the_ID() > 0 ? get_the_ID() : '' );
    $bg_image_id = get_post_meta( $post_ID, 'solutech_header_bg_image', true );
    if( isset(wp_get_attachment_image_src( $bg_image_id, 'full' )[0]) && wp_get_attachment_image_src( $bg_image_id, 'full' )[0] != '' ){
        $bg_image = wp_get_attachment_image_src( $bg_image_id, 'full' )[0];
    } else {
        $bg_image = solutech_get_option('header_bg_image', '');
    }
    $image = $bg_image;
    
    if ( class_exists( 'WooCommerce' ) && is_product() && solutech_get_option( 'header_style_prod', '' ) != '' ){
        $solutech_title_breacrumbs_display = solutech_get_option( 'header_style_prod' );
        $solutech_title_breacrumbs_display = $solutech_title_breacrumbs_display == 'hide_breadcrumbs' ? 'hide' : $solutech_title_breacrumbs_display;
        $image = solutech_get_option('header_bg_image_prod', '') != '' ? solutech_get_option('header_bg_image_prod', '') : $bg_image;
    }
    
    $image = $image == '' ? '' : 'style="background-image:url('.esc_url($image).');"';
?>
<div class="header__page text-center" <?php echo wp_kses($image, 'post') ?>>
    <div class="pix-overlay"></div>
    <div class="container">
        <div class="header__pageInfo">
            <?php if ( $solutech_title_breacrumbs_display != 'hide' && $solutech_title_breacrumbs_display != 'hide_title' ) : ?>
            <h1 class="h2">
                <?php solutech_the_header_title(); ?>
            </h1>
            <?php endif; ?>
            <?php if ( function_exists( 'solutech_breadcrumbs' ) && $solutech_title_breacrumbs_display != 'hide' && $solutech_title_breacrumbs_display != 'hide_breadcrumbs' ) : ?>
            <nav aria-label="breadcrumb">
                <?php solutech_breadcrumbs(); ?>
            </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
