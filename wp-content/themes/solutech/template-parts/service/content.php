<?php
if ( isset( $settings ) ) {
    $image_size = 'solutech-' . esc_attr( $settings['image_proportions'] ) . '-thumb';
} else {
    $image_size = solutech_get_option( 'portfolio_archive_image_proportions', 'square' );
    $image_size = 'solutech-' . esc_attr( $image_size ) . '-thumb';
}

$solutech_add_class = ( has_post_thumbnail() ) ? 'mb-30' : '';

$cats = wp_get_object_terms( get_the_id(), 'pix-service-cat' );
if ( ! empty( $cats ) ) {
    foreach ( $cats as $cat ) {
        $solutech_add_class .= " " . $cat->slug;
    }
}
?>

<div class="col <?php echo esc_attr( $solutech_add_class ); ?>">
    <div class="projects__item">
        <div class="projects__itemImg">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php
            if ( isset( $settings ) && isset( $settings[ 'image_size_default' ] ) ) :
                solutech_get_elementor_attachment_image_html( $settings, get_post_thumbnail_id(), $image_size );
            else :
                the_post_thumbnail( $image_size );
            endif;
        endif;
        ?>
        </div>
        <div class="projects__itemInfo">
            <div class="projects__itemTitle"><?php the_title(); ?></div>
            <div class="projects__itemText"><?php echo pixtheme_limit_words( get_the_excerpt(), 20 ); ?></div>
            <?php
            $solutech_project_icon_url = ! empty( $solutech_project_icon_id = solutech_get_post_meta( 'project_icon' ) ) ? wp_get_attachment_image_src( $solutech_project_icon_id, 'pixtheme-thumb-limit-height-small' )[0] : '';
            if ( $solutech_project_icon_url ) :
                ?>
                <div class="projects__itemLogo"><img src="<?php echo esc_url( $solutech_project_icon_url ); ?>" alt="<?php the_title_attribute(); ?>" /></div>
                <?php
            endif;
            ?>
            <a href="<?php the_permalink(); ?>"></a>
        </div>
    </div>
</div>